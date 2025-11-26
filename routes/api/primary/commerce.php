<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Primary\Transaction\TradeController;



Route::middleware([
    'auth:sanctum',
])->group(function () {
    // trades
    Route::prefix('commerce')->controller(TradeController::class)->group(function () {
        Route::get('/trades/data', 'commerceData')->name('api.commerce.trades.data');
    });
});




Route::middleware([
    // 'auth:sanctum',
])->group(function () {
    
});