<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceController;

/**
 * Route untuk dashboard aplikasi keuangan
 * Menampilkan overview saldo, daily safe limit, dan transaksi terakhir
 */
Route::get('/', [FinanceController::class, 'dashboard'])->name('dashboard');

/**
 * Route untuk menyimpan transaksi baru
 * Method POST digunakan untuk keamanan dan best practice web
 */
Route::post('/transaction', [FinanceController::class, 'storeTransaction'])
    ->name('transaction.store');
