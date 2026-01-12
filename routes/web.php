<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardCardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/order/robux', function () {
    return view('order.robux');
})->name('order.robux');

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/payment/{order}', [OrderController::class, 'showPayment'])->name('order.payment');
Route::post('/midtrans/notification', [MidtransNotificationController::class, 'handle'])->name('midtrans.notification');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Redirect to role-specific dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'developer') {
            return redirect()->route('developer.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Dashboard Routes with Role Middleware
    Route::middleware('role:customer')->group(function () {
        Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
    });

    Route::middleware('role:developer')->group(function () {
        Route::get('/developer/dashboard', [DashboardController::class, 'developer'])->name('developer.dashboard');
        Route::get('/developer/board/cards', [BoardCardController::class, 'index'])->name('developer.cards.index');
        Route::post('/developer/board/cards', [BoardCardController::class, 'store'])->name('developer.cards.store');
        Route::patch('/developer/board/cards/{card}', [BoardCardController::class, 'update'])->name('developer.cards.update');
        Route::patch('/developer/board/cards/{card}/status', [BoardCardController::class, 'updateStatus'])->name('developer.cards.status');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/robux', [DashboardController::class, 'robux'])->name('admin.robux');
        Route::get('/admin/users', [DashboardController::class, 'users'])->name('users.index');
        Route::get('/admin/users/{user}/edit', [DashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/admin/users/{user}', [DashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/admin/users/{user}', [DashboardController::class, 'destroyUser'])->name('users.destroy');
        Route::post('/admin/orders/{order}/manual-status', [DashboardController::class, 'updateManualStatus'])->name('admin.orders.manual-status');
    });
});
