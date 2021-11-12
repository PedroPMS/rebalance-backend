<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->name('wallet.')->prefix('wallet')->group(function () {
    Route::apiResource('/wallet', 'WalletController');
});
