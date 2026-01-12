<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        try {
            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Create notification object
            $notification = new Notification();

            // Get notification data
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            Log::info('Midtrans Notification received:', [
                'order_id' => $orderId,
                'transaction_status' => $transaction,
                'payment_type' => $type,
                'fraud_status' => $fraud
            ]);

            // Find order by order_number
            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                Log::error('Order not found for notification', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Find the latest transaction for this order
            $transaction = Transaction::where('order_id', $order->id)
                ->latest()
                ->first();

            if (!$transaction) {
                Log::error('Transaction not found for order', ['order_id' => $orderId]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Handle transaction status
            $newOrderStatus = $this->getOrderStatus($transaction, $notification);
            
            // Update order status
            $order->update(['status' => $newOrderStatus]);

            // Update transaction status and details
            $transaction->update([
                'payment_status' => $notification->transaction_status,
                'payment_details' => array_merge((array) $transaction->payment_details, [
                    'notification_data' => (array) $notification
                ])
            ]);

            Log::info('Order and transaction updated successfully', [
                'order_id' => $orderId,
                'new_status' => $newOrderStatus,
                'transaction_status' => $notification->transaction_status
            ]);

            return response()->json(['message' => 'Notification processed successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    private function getOrderStatus($transaction, $notification)
    {
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'challenge') {
                    return 'challenge';
                } else if ($fraudStatus == 'accept') {
                    return 'settlement';
                }
                break;
            case 'settlement':
                return 'settlement';
            case 'pending':
                return 'pending';
            case 'deny':
                return 'deny';
            case 'expire':
                return 'expire';
            case 'cancel':
                return 'cancel';
            default:
                return $transaction->payment_status ?? 'pending';
        }

        return $transaction->payment_status ?? 'pending';
    }
}
