<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceController;

/**
 * Default route - redirect to dashboard or login
 */
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('auth.login');
});

/**
 * Routes untuk Authentication
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    /**
     * Routes untuk dashboard dan finance
     */
    Route::get('/dashboard', [FinanceController::class, 'dashboard'])->name('dashboard');
    Route::post('/transaction', [FinanceController::class, 'storeTransaction'])->name('transaction.store');
    Route::get('/add-income', [FinanceController::class, 'showAddIncome'])->name('income.create');
    Route::get('/add-expense', [FinanceController::class, 'showAddExpense'])->name('expense.create');
});


