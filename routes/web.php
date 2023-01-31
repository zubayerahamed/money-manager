<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\IncomeSourceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TrackingHistoryController;
use App\Http\Controllers\WalletController;
use GuzzleHttp\Middleware;
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


// Registration
Route::get('/register', [RegisterController::class, 'showRegisterPage'])->name('register');
Route::post('/register', [RegisterController::class, 'doRegistration']);

// Login
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::post('/login', [LoginController::class, 'doLogin']);

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/', [DashboardController::class, 'showDashboardPage']);
    Route::get('/current-month/line-chart', [DashboardController::class, 'getCurrentMonthLineChartData']);
    Route::get('/current-year/line-chart', [DashboardController::class, 'getCurrentYearLineChartData']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'showProfilePage'])->name('profile.page');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Wallets
    Route::get('/wallet/status', [WalletController::class, 'walletStatusPieChart'])->name('wallet.status');
    Route::get('/wallet/all', [WalletController::class, 'wallets'])->name('wallets');
    Route::get('/wallet', [WalletController::class, 'showCreateWalletPage'])->name('wallet.create.page');
    Route::get('/wallet/{wallet}/edit', [WalletController::class, 'showUpdateWalletPage'])->name('wallet.update.page');
    Route::post('/wallet', [WalletController::class, 'createWallet'])->name('wallet.create');
    Route::put('/wallet/{wallet}', [WalletController::class, 'updateWallet'])->name('wallet.update');
    Route::delete('/wallet/{wallet}/delete', [WalletController::class, 'deleteWallet'])->name('wallet.delete');

    // Income Source
    Route::get('/income-source/status', [IncomeSourceController::class, 'incomeSourceStatusPieChart'])->name('income-source.status');
    Route::get('/income-source/all', [IncomeSourceController::class, 'incomeSources'])->name('income-sources');
    Route::get('/income-source', [IncomeSourceController::class, 'showCreateIncomeSourcePage'])->name('income-sources.create.page');
    Route::get('/income-source/{incomeSource}/edit', [IncomeSourceController::class, 'showUpdateIncomeSourcePage'])->name('income-sources.update.page');
    Route::post('/income-source', [IncomeSourceController::class, 'createIncomeSource'])->name('income-sources.create');
    Route::put('/income-source/{incomeSource}', [IncomeSourceController::class, 'updateIncomeSource'])->name('income-sources.update');
    Route::delete('/income-source/{incomeSource}/delete', [IncomeSourceController::class, 'deleteIncomeSource'])->name('income-sources.delete');

    // Wallets
    Route::get('/expense-type/status', [ExpenseTypeController::class, 'expenseTypeStatusPieChart'])->name('expense-type.status');
    Route::get('/expense-type/all', [ExpenseTypeController::class, 'expenseTypes'])->name('expense-types');
    Route::get('/expense-type', [ExpenseTypeController::class, 'showCreateExpenseTypePage'])->name('expense-type.create.page');
    Route::get('/expense-type/{expenseType}/edit', [ExpenseTypeController::class, 'showUpdateExpenseTypePage'])->name('expense-type.update.page');
    Route::post('/expense-type', [ExpenseTypeController::class, 'createExpenseType'])->name('expense-type.create');
    Route::put('/expense-type/{expenseType}', [ExpenseTypeController::class, 'updateExpenseType'])->name('expense-type.update');
    Route::delete('/expense-type/{expenseType}/delete', [ExpenseTypeController::class, 'deleteExpenseType'])->name('expense-type.delete');

    // Transactions
    Route::get('/transaction/add-income', [TrackingHistoryController::class, 'showAddIncomePage'])->name('add-income.page');
    Route::get('/transaction/add-expense', [TrackingHistoryController::class, 'showAddExpensePage'])->name('add-expense.page');
    Route::get('/transaction/do-transfer', [TrackingHistoryController::class, 'showDoTransferPage'])->name('do-transfer.page');
    Route::post('/transaction', [TrackingHistoryController::class, 'doTransaction'])->name('transaction');

    // Logout
    Route::get('/logout', [LogoutController::class, 'doLogout'])->middleware('auth');
});
