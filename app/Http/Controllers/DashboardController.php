<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Customer Dashboard
     */
    public function customer()
    {
        $userId = auth()->id();

        // Get wallet balance (balance_robux) if exists
        $balanceRobux = DB::table('wallets')->where('user_id', $userId)->value('balance_robux');
        $balanceRobux = $balanceRobux ?? 0;

        return view('dashboard.customer', compact('balanceRobux'));
    }

    /**
     * Customer Transactions (Riwayat Transaksi)
     */
    public function transactions()
    {
        $userId = auth()->id();
        
        if (!$userId) {
            return redirect()->route('login');
        }

        // Load orders for user with transactions
        $orders = Order::where('user_id', $userId)->with('transactions')->latest()->get();

        $rows = collect();
        foreach ($orders as $order) {
            // compute robux amount from order_items if present
            $robux = DB::table('order_items')->where('order_id', $order->id)->sum('quantity');

            foreach ($order->transactions as $txn) {
                $rows->push((object) [
                    'invoice' => $order->order_number,
                    'robux' => $robux,
                    'input_id' => $txn->provider_ref ?? $txn->id,
                    'price' => $txn->amount,
                    'date' => $txn->created_at,
                    'status' => $txn->payment_status,
                ]);
            }
        }

        // Optionally limit to recent 50
        $transactions = $rows->sortByDesc('date')->values();

        return view('dashboard.transactions', compact('transactions'));
    }

    /**
     * Developer Dashboard
     */
    public function developer()
    {
        return view('dashboard.developer');
    }

    /**
     * Admin Dashboard
     */
    public function admin()
    {
        return view('dashboard.admin');
    }
}

