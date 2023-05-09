<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTrackingController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DreamController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\IncomeSourceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SetupController;
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

// Setup
Route::get('/setup', [SetupController::class, 'index'])->name('setup');

// Registration
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/current-month/line-chart', [DashboardController::class, 'getCurrentMonthLineChartData']);
    Route::get('/current-year/line-chart', [DashboardController::class, 'getCurrentYearLineChartData']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Wallets
    Route::get('/wallet/all', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet', [WalletController::class, 'create'])->name('wallet.create');
    Route::get('/wallet/{id}/edit', [WalletController::class, 'edit'])->name('wallet.edit');
    Route::post('/wallet', [WalletController::class, 'store'])->name('wallet.store');
    Route::put('/wallet/{wallet}', [WalletController::class, 'update'])->name('wallet.update');
    Route::delete('/wallet/{wallet}', [WalletController::class, 'destroy'])->name('wallet.destroy');

    Route::get('/wallet/data/status', [WalletController::class, 'walletStatusPieChart'])->name('wallet.data.status');

    Route::get('/wallet/section/piechart', [WalletController::class, 'piechart'])->name('wallet.section.piechart');
    Route::get('/wallet/section/header', [WalletController::class, 'header'])->name('wallet.section.header');
    Route::get('/wallet/section/accordion', [WalletController::class, 'accordion'])->name('wallet.section.accordion');

    // Income Source
    Route::get('/income-source/all', [IncomeSourceController::class, 'index'])->name('income-source.index');
    Route::get('/income-source', [IncomeSourceController::class, 'create'])->name('income-source.create');
    Route::get('/income-source/{id}/edit', [IncomeSourceController::class, 'edit'])->name('income-source.edit');
    Route::post('/income-source', [IncomeSourceController::class, 'store'])->name('income-source.store');
    Route::put('/income-source/{incomeSource}', [IncomeSourceController::class, 'update'])->name('income-source.update');
    Route::delete('/income-source/{incomeSource}', [IncomeSourceController::class, 'destroy'])->name('income-source.destroy');

    Route::get('/income-source/data/status', [IncomeSourceController::class, 'incomeSourceStatusPieChart'])->name('income-source.data.status');

    Route::get('/income-source/section/piechart', [IncomeSourceController::class, 'piechart'])->name('income-source.section.piechart');
    Route::get('/income-source/section/header', [IncomeSourceController::class, 'header'])->name('income-source.section.header');
    Route::get('/income-source/section/accordion', [IncomeSourceController::class, 'accordion'])->name('income-source.section.accordion');

    // Expense Type
    Route::get('/expense-type/all', [ExpenseTypeController::class, 'index'])->name('expense-type.index');
    Route::get('/expense-type', [ExpenseTypeController::class, 'create'])->name('expense-type.create');
    Route::get('/expense-type/{id}/edit', [ExpenseTypeController::class, 'edit'])->name('expense-type.edit');
    Route::post('/expense-type', [ExpenseTypeController::class, 'store'])->name('expense-type.store');
    Route::put('/expense-type/{expenseType}', [ExpenseTypeController::class, 'update'])->name('expense-type.update');
    Route::delete('/expense-type/{expenseType}', [ExpenseTypeController::class, 'destroy'])->name('expense-type.destroy');

    Route::get('/expense-type/data/status', [ExpenseTypeController::class, 'expenseTypeStatusPieChart'])->name('expense-type.data.status');

    Route::get('/expense-type/section/piechart', [ExpenseTypeController::class, 'piechart'])->name('expense-type.section.piechart');
    Route::get('/expense-type/section/header', [ExpenseTypeController::class, 'header'])->name('expense-type.section.header');
    Route::get('/expense-type/section/accordion', [ExpenseTypeController::class, 'accordion'])->name('expense-type.section.accordion');

    // Budget
    Route::get('/budget/{month}/{year}/list', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('/budget/{expenseType}/{month}/{year}', [BudgetController::class, 'create'])->name('budget.create');
    Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');
    Route::get('/budget/{budget}', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::put('/budget/{budget}', [BudgetController::class, 'update'])->name('budget.update');

    // Transactions
    Route::get('/transaction/add-income', [TrackingHistoryController::class, 'addIncome'])->name('add-income');
    Route::get('/transaction/add-expense', [TrackingHistoryController::class, 'addExpense'])->name('add-expense');
    Route::get('/transaction/do-transfer', [TrackingHistoryController::class, 'doTransfer'])->name('do-transfer');
    Route::post('/transaction', [TrackingHistoryController::class, 'doTransaction'])->name('transaction');

    // Tracking
    Route::get('/tracking/details/today', [TrackingHistoryController::class, 'showAllTodaysTransactions'])->name('tracking.today');
    Route::get('/tracking/details/month/{monthno}/{year}', [TrackingHistoryController::class, 'showMonthWiseTransactions'])->name('tracking.monthly');
    Route::get('/tracking/details/year/{year}', [TrackingHistoryController::class, 'showYearWiseTransactions'])->name('tracking.yearly');
    Route::get('/tracking/detail/{trackingHistory}/edit', [TrackingHistoryController::class, 'editTrackingDetailPage'])->name('tracking.edit');
    Route::put('/tracking/detail/{trackingHistory}/update', [TrackingHistoryController::class, 'updateTrackingDetail'])->name('tracking.update');
    Route::delete('/tracking/detail/{trackingHistory}/delete', [TrackingHistoryController::class, 'deleteTrackingDetail'])->name('tracking.destroy');

    // Dream
    Route::get('/dream/all', [DreamController::class, 'index'])->name('dream.index');
    Route::get('/dream', [DreamController::class, 'create'])->name('dream.create');
    Route::post('/dream', [DreamController::class, 'store'])->name('dream.store');
    Route::get('/dream/{dream}/edit', [DreamController::class, 'edit'])->name('dream.edit');
    Route::put('/dream/{dream}', [DreamController::class, 'update'])->name('dream.update');
    Route::delete('/dream/{dream}/delete', [DreamController::class, 'destroy'])->name('dream.destroy');
    Route::post('/dream/image/{dream}', [DreamController::class, 'updateImage'])->name('dream.image');

    Route::get('/dream/section/accordion', [DreamController::class, 'accordion'])->name('dream.section.accordion');

    // Logout
    Route::get('/logout', [LogoutController::class, 'doLogout'])->name('logout');
});
