<?php
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::delete('/{order_id}', [OrderController::class, 'destroy']);
    Route::get('/{order_id}/discount', [OrderController::class, 'orderDiscount']);
});
