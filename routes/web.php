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
    Route::get('/', [DashboardController::class, 'showDashboardPage'])->name('home');
    Route::get('/current-month/line-chart', [DashboardController::class, 'getCurrentMonthLineChartData']);
    Route::get('/current-year/line-chart', [DashboardController::class, 'getCurrentYearLineChartData']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'showProfilePage'])->name('profile.page');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile');
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
    Route::get('/transaction/add-income', [TrackingHistoryController::class, 'showAddIncomePage'])->name('add-income.page');
    Route::get('/transaction/add-expense', [TrackingHistoryController::class, 'showAddExpensePage'])->name('add-expense.page');
    Route::get('/transaction/do-transfer', [TrackingHistoryController::class, 'showDoTransferPage'])->name('do-transfer.page');
    Route::post('/transaction', [TrackingHistoryController::class, 'doTransaction'])->name('transaction');

    // Tracking
    Route::get('/tracking/details/today', [TrackingHistoryController::class, 'showAllTodaysTransactions'])->name('tracking.today');
    Route::get('/tracking/details/month/{monthno}/{year}', [TrackingHistoryController::class, 'showMonthWiseTransactions'])->name('tracking.monthly');
    Route::get('/tracking/details/year/{year}', [TrackingHistoryController::class, 'showYearWiseTransactions'])->name('tracking.yearly');
    Route::get('/tracking/detail/{trackingHistory}/edit', [TrackingHistoryController::class, 'editTrackingDetailPage'])->name('tracking.edit.page');
    Route::put('/tracking/detail/{trackingHistory}/update', [TrackingHistoryController::class, 'updateTrackingDetail'])->name('tracking.update');
    Route::delete('/tracking/detail/{trackingHistory}/delete', [TrackingHistoryController::class, 'deleteTrackingDetail'])->name('tracking.delete');

    // Dream
    Route::get('/dream/all', [DreamController::class, 'dreams'])->name('dreams');
    Route::get('/dream', [DreamController::class, 'showCreateDreamPage'])->name('dream.create.page');
    Route::post('/dream', [DreamController::class, 'createDream'])->name('dream.create');
    Route::get('/dream/{dream}/edit', [DreamController::class, 'showEditDreamPage'])->name('dream.edit.page');
    Route::put('/dream/{dream}', [DreamController::class, 'updateDream'])->name('dream.update');
    Route::post('/dream/image/{dream}', [DreamController::class, 'updateImage'])->name('dream.image');
    Route::delete('/dream/{dream}/delete', [DreamController::class, 'deleteDream'])->name('dream.delete');

    // Account
    Route::get('/account/all', [AccountController::class, 'accounts'])->name('accounts');
    Route::get('/account', [AccountController::class, 'showCreateAccountPage'])->name('account.create.page');
    Route::post('/account', [AccountController::class, 'createAccount'])->name('account.create');
    Route::get('/account/{account}/edit', [AccountController::class, 'showEditAccountPage'])->name('account.edit.page');
    Route::put('/account/{account}', [AccountController::class, 'updateAccount'])->name('account.update');
    Route::delete('/account/{account}/delete', [AccountController::class, 'deleteAccount'])->name('account.delete');

    // Account Tracking
    Route::post('/ac-tracking/saving', [AccountTrackingController::class, 'save'])->name('do.ac.transaction.saving');
    Route::post('/ac-tracking/withdraw', [AccountTrackingController::class, 'withdraw'])->name('do.ac.transaction.withdraw');

    // Logout
    Route::get('/logout', [LogoutController::class, 'doLogout'])->name('logout');
});
