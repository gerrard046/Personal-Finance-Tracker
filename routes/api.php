<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\TransactionController;

/**
 * Protected routes (butuh session authentication)
 */
Route::middleware('auth:web')->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Goals API
    Route::prefix('goals')->group(function () {
        Route::get('', [GoalController::class, 'index']);
        Route::post('', [GoalController::class, 'store']);
        Route::get('{goal}', [GoalController::class, 'show']);
        Route::put('{goal}', [GoalController::class, 'update']);
        Route::delete('{goal}', [GoalController::class, 'destroy']);
        Route::post('{goal}/save', [GoalController::class, 'addSavings']);
    });

    // Transactions API
    Route::prefix('transactions')->group(function () {
        Route::get('', [TransactionController::class, 'index']);
        Route::post('', [TransactionController::class, 'store']);
        Route::get('stats/summary', [TransactionController::class, 'summary']);
        Route::get('{transaction}', [TransactionController::class, 'show']);
        Route::put('{transaction}', [TransactionController::class, 'update']);
        Route::delete('{transaction}', [TransactionController::class, 'destroy']);
    });

});
