<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check-pending {--order_number=} {--simulate-settlement} {--simulate-status=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update pending orders from Midtrans API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->output = $this->output ?: new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->info('Checking pending orders...');

        if ($this->input && $this->hasOption('order_number') && $orderNumber = $this->option('order_number')) {
            $this->checkSpecificOrder($orderNumber);
            return;
        }

        $pendingOrders = Order::where('manual_status', 'on progress')
            ->whereHas('transactions', function ($query) {
                $query->where('payment_status', 'pending');
            })
            ->with('transactions')
            ->get();

        if ($this->output) {
            $this->info('Found ' . $pendingOrders->count() . ' pending orders');
        }

        foreach ($pendingOrders as $order) {
            $this->checkOrderStatus($order);
        }

        if ($this->output) {
            $this->info('Order check completed!');
        }
    }

    private function checkSpecificOrder($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            if ($this->output) {
                $this->error('Order not found: ' . $orderNumber);
            }
            return;
        }

        $this->checkOrderStatus($order);
    }

    private function checkOrderStatus($order)
    {
        if ($this->output) {
            $this->info("Checking order: {$order->order_number}");
        }
        
        try {
            // Use Midtrans API to check transaction status
            $serverKey = config('midtrans.server_key');
            $base64Key = base64_encode($serverKey . ':');

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $base64Key,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->get('https://api.sandbox.midtrans.com/v2/' . $order->order_number . '/status');

            if ($response->successful()) {
                $transactionData = $response->json();
                if ($this->output) {
                    $this->info("Midtrans API response for {$order->order_number}: " . json_encode($transactionData));
                }
                $this->updateOrderFromMidtrans($order, $transactionData);
            } else {
                if ($this->output) {
                    $this->error('Failed to check order ' . $order->order_number . ': ' . $response->status());
                }
            }
        } catch (\Exception $e) {
            if ($this->output) {
                $this->error('Error checking order ' . $order->order_number . ': ' . $e->getMessage());
            }
            Log::error('Error checking order status', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function updateOrderFromMidtrans($order, $transactionData)
    {
        $transactionStatus = $transactionData['transaction_status'] ?? 'pending';
        $paymentStatus = $this->mapTransactionStatus($transactionStatus);

        // Update transaction payment status
        $transaction = $order->transactions()->latest()->first();
        if ($transaction) {
            $transaction->update([
                'payment_status' => $transactionStatus,
                'payment_details' => array_merge((array) $transaction->payment_details, [
                    'midtrans_check' => $transactionData
                ])
            ]);
        }

        // Update order status only if payment is successful
        if ($paymentStatus === 'completed') {
            $order->update(['status' => 'completed']);
        }

        if ($this->output) {
            $this->info('Updated order ' . $order->order_number . ' payment status: ' . $transactionStatus);
            $this->info('Order status: ' . $order->status . ', Manual status: ' . $order->manual_status);
        }

        Log::info('Order payment status updated from Midtrans API', [
            'order_number' => $order->order_number,
            'payment_status' => $transactionStatus,
            'order_status' => $order->status,
            'manual_status' => $order->manual_status
        ]);
    }

    private function mapTransactionStatus($transactionStatus)
    {
        switch ($transactionStatus) {
            case 'settlement':
            case 'capture':
                return 'completed';
            case 'pending':
                return 'pending';
            case 'deny':
            case 'cancel':
            case 'expire':
                return 'failed';
            default:
                return 'pending';
        }
    }
}
