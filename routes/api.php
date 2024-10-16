<?php

use App\Http\Controllers\API\V1\TransactionController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('transfer', [TransactionController::class, 'transfer'])->name('transaction.transfer');
    Route::get('top-users', [userController::class, 'topUsers'])->name('users.top-users');
});
