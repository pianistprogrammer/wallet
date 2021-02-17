<?php

use App\Http\Controllers\LgaController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'auth',
    'middleware' => 'api'], function () {
    Route::apiResource('wallets', WalletController::class);
    Route::apiResource('lga', LgaController::class);
    Route::apiResource('users', UserController::class);
    Route::get('getuserdetails', [UserController::class, 'getUserDetails']);
    Route::get('getwalletdetails', [WalletController::class, 'getWalletDetails']);
    Route::get('getsummary', [TransactionHistoryController::class, 'getSystemSummary']);
    Route::post('creditwallet', [WalletController::class, 'creditWallet']);
    Route::post('lga/import', [LgaController::class, 'importfile']);

});
