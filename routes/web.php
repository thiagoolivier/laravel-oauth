<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\OAuth\OAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(Auth::check() ? 'dashboard.index' : 'login'));

Route::get('/csrf-token-refresh', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/auth/unlink/{provider}', [OAuthController::class, 'unlink']);

    #region Account
    Route::get('/linked-accounts', [AccountController::class, 'linkedAccounts'])
        ->name('account.linked_accounts');

    Route::get('/linked-accounts/data', [AccountController::class, 'getLinkedAccounts'])
        ->name('account.linked_accounts.data');
    #endregion
});

require __DIR__ . '/auth.php';
