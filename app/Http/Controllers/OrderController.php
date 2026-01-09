<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\CoreApi;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_data' => 'required|string',
            'voucher_price' => 'required|numeric',
            'voucher_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'whatsapp_number' => 'required|string',
        ]);

        // Calculate total
        $price = (int) $validated['voucher_price'];
        $quantity = (int) $validated['quantity'];
        $total = $price * $quantity;

        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Log configuration (partial key for security)
        Log::info('Midtrans Configuration:', [
            'is_production' => Config::$isProduction,
            'server_key_prefix' => substr(Config::$serverKey, 0, 5) . '...',
        ]);

        // Create Order in DB
        // Use user ID 1 as fallback for guest if not logged in
        $userId = Auth::check() ? Auth::id() : 1;
        
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(100, 999),
            'user_id' => $userId,
            'total_amount' => $total,
            'currency' => 'IDR',
            'status' => 'pending',
        ]);

        // Prepare Core API Params
        $paymentType = '';
        $paymentParams = [];
        
        switch ($validated['payment_method']) {
            case 'BCA':
                $paymentType = 'bank_transfer';
                $paymentParams = ['bank_transfer' => ['bank' => 'bca']];
                break;
            case 'Mandiri':
                $paymentType = 'echannel';
                $paymentParams = ['echannel' => ['bill_info1' => 'Payment:', 'bill_info2' => 'Online Purchase']];
                break;
            case 'BRI':
                $paymentType = 'bank_transfer';
                $paymentParams = ['bank_transfer' => ['bank' => 'bri']];
                break;
            case 'GOPAY':
                $paymentType = 'qris';
                $paymentParams = []; // Use default settings
                break;
            case 'QRIS':
            case 'DANA':
                $paymentType = 'qris';
                $paymentParams = []; // Use default settings
                break;
            default:
                $paymentType = 'bank_transfer'; // Default fallback
                $paymentParams = ['bank_transfer' => ['bank' => 'bca']];
                break;
        }

        $params = array_merge([
            'payment_type' => $paymentType,
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => 'Customer',
                'email' => 'customer@example.com',
                'phone' => preg_replace('/[^0-9]/', '', $validated['whatsapp_number']),
            ],
            'item_details' => [
                [
                    'id' => 'VOUCHER-' . time(),
                    'price' => $price,
                    'quantity' => $quantity,
                    'name' => substr($validated['voucher_name'], 0, 50),
                ]
            ],
        ], $paymentParams);

        Log::info('Midtrans Payload:', $params);

        try {
            // Call Core API
            $response = CoreApi::charge($params);
            
            // Log successful response
            Log::info('Midtrans Response:', (array)$response);

            // Save Transaction
            Transaction::create([
                'order_id' => $order->id,
                'payment_provider' => 'midtrans',
                'payment_status' => $response->transaction_status,
                'provider_ref' => $response->transaction_id,
                'amount' => $total,
                'payment_details' => (array) $response
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully!',
                'redirect_url' => route('order.payment', $order->id)
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            $message = $e->getMessage();
            if (strpos($message, '"status_code":"402"') !== false) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Metode pembayaran belum aktif di Midtrans Production. Aktifkan QRIS/GoPay di dashboard atau pilih metode lain seperti BCA/BRI.'
                ], 422);
            }
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function showPayment(Order $order)
    {
        $transaction = Transaction::where('order_id', $order->id)->latest()->first();
        
        if (!$transaction) {
            abort(404, 'Transaction not found');
        }

        $paymentDetails = $transaction->payment_details;
        $paymentType = $paymentDetails['payment_type'] ?? 'unknown';
        
        $vaNumber = null;
        $bank = null;
        $qrUrl = null;

        // Extract Payment Info
        if ($paymentType == 'bank_transfer') {
            if (isset($paymentDetails['va_numbers'][0])) {
                $vaNumber = $paymentDetails['va_numbers'][0]['va_number'];
                $bank = $paymentDetails['va_numbers'][0]['bank'];
            } else if (isset($paymentDetails['permata_va_number'])) {
                $vaNumber = $paymentDetails['permata_va_number'];
                $bank = 'permata';
            }
        } elseif ($paymentType == 'echannel') {
            $vaNumber = ($paymentDetails['biller_code'] ?? '') . ' - ' . ($paymentDetails['bill_key'] ?? '');
            $bank = 'mandiri';
        } elseif ($paymentType == 'qris' || $paymentType == 'gopay') {
            // For QRIS, usually in 'actions' -> 'generate-qr-code'
            if (isset($paymentDetails['actions'])) {
                foreach ($paymentDetails['actions'] as $action) {
                    if ($action['name'] == 'generate-qr-code') {
                        $qrUrl = $action['url'];
                        break;
                    }
                }
            }
        }

        return view('order.payment', [
            'order_number' => $order->order_number,
            'amount' => $order->total_amount,
            'item_name' => 'Robux Voucher', // Ideally fetch from order items
            'payment_type' => $paymentType,
            'va_number' => $vaNumber,
            'bank' => $bank,
            'qr_url' => $qrUrl,
            'expiry_time' => strtotime($transaction->created_at) + 24*60*60,
        ]);
    }
}
