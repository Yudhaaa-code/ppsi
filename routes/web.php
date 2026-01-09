<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoardCardController;
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

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Redirect to appropriate dashboard based on role
    Route::get('/dashboard', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'developer' => redirect()->route('developer.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default => redirect()->route('home'),
        };
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
    });
});
