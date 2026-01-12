<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function getAdminViewData(string $page): array
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Transaction::where('payment_status', 'settlement')->sum('amount');

        $pendingOrders = Order::where('manual_status', 'on progress')->count();
        $completedOrders = Order::where('manual_status', 'success')->count();
        $failedOrders = Order::where('manual_status', 'failed')->count();
        $cancelledOrders = Order::where('manual_status', 'cancelled')->count();

        $recentOrders = Order::with(['user', 'transactions'])
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('payment_status', 'settlement')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return compact(
            'page',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'completedOrders',
            'failedOrders',
            'cancelledOrders',
            'recentOrders',
            'monthlyRevenue',
        );
    }

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
        return view('dashboard.admin', $this->getAdminViewData('dashboard'));
    }

    public function robux(Request $request)
    {
        $data = $this->getAdminViewData('robux');
        
        $query = Order::with(['user', 'transactions'])
            ->latest();

        // Filter by Search (Username/ID Roblox)
        if ($request->has('search') && $request->search != '') {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        // Filter by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('manual_status', $request->status);
        }

        // Filter by Payment Status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->whereHas('transactions', function($q) use ($request) {
                $q->where('payment_status', $request->payment_status);
            });
        }

        // Filter by Date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $data['recentOrders'] = $query->paginate(25);

        return view('dashboard.transaction', $data);
    }

    /**
     * User Management
     */
    public function users()
    {
        $users = User::paginate(10);

        return view('dashboard.users', compact('users'));
    }

    /**
     * Edit User
     */
    public function editUser(User $user)
    {
        return view('dashboard.users-edit', compact('user'));
    }

    /**
     * Update User
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,developer,admin',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete User
     */
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Update Manual Status
     */
    public function updateManualStatus(Request $request, Order $order)
    {
        $request->validate([
            'manual_status' => 'required|in:on progress,success,failed,cancelled',
        ]);

        $order->update([
            'manual_status' => $request->manual_status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Manual status updated successfully',
        ]);
    }
}
