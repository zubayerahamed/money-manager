<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\IncomeSourceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'showDashboardPage'])->middleware('auth');


// Login, Register And Logout
Route::get('/register', [RegisterController::class, 'showRegisterPage'])->name('register');
Route::post('/register', [RegisterController::class, 'doRegistration']);
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::post('/login', [LoginController::class, 'doLogin']);
Route::get('/logout', [LogoutController::class, 'doLogout'])->middleware('auth');


// Wallets
Route::get('/wallet/all', [WalletController::class, 'wallets'])->name('wallets');
Route::get('/wallet', [WalletController::class, 'showCreateWalletPage'])->name('wallet.create.page');
Route::get('/wallet/{wallet}/edit', [WalletController::class, 'showUpdateWalletPage'])->name('wallet.update.page');
Route::post('/wallet', [WalletController::class, 'createWallet'])->name('wallet.create');
Route::put('/wallet/{wallet}', [WalletController::class, 'updateWallet'])->name('wallet.update');
Route::delete('/wallet/{wallet}/delete', [WalletController::class, 'deleteWallet'])->name('wallet.delete');

// Income Source
Route::get('/income-sources', [IncomeSourceController::class, 'incomeSources'])->name('income-sources');

// Wallets
Route::get('/expense-types', [ExpenseTypeController::class, 'expenseTypes'])->name('expense-types');
