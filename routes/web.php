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
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\TrackingHistoryController;
use App\Http\Controllers\WalletController;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::group(['middleware' => ['guest', 'setup']], function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    // Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login');

    // Forgot Password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::group(['middleware' => ['auth', 'setup']], function () {
    // Home
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/current-month/line-chart', [DashboardController::class, 'getCurrentMonthLineChartData'])->name('month.line-chart');
    Route::get('/current-year/line-chart', [DashboardController::class, 'getCurrentYearLineChartData'])->name('year.line-chart');
    Route::get('/sections/all', [DashboardController::class, 'reloadPageSections'])->name('home.sections');

    // Profile
    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.'
    ], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar');
    });

    // Wallets
    Route::group([
        'prefix' => 'wallet',
        'as' => 'wallet.'
    ], function () {
        Route::get('/all', [WalletController::class, 'index'])->name('index');
        Route::get('/', [WalletController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [WalletController::class, 'edit'])->name('edit');
        Route::post('/', [WalletController::class, 'store'])->name('store');
        Route::put('/{id}', [WalletController::class, 'update'])->name('update');
        Route::delete('/{id}', [WalletController::class, 'destroy'])->name('destroy');
        Route::get('/data/status', [WalletController::class, 'walletStatusPieChart'])->name('data.status');
        Route::get('/section/piechart', [WalletController::class, 'piechart'])->name('section.piechart');
        Route::get('/section/header', [WalletController::class, 'header'])->name('section.header');
        Route::get('/section/accordion', [WalletController::class, 'accordion'])->name('section.accordion');
        Route::get('/sections/all', [WalletController::class, 'reloadPageSections'])->name('sections');
    });

    // Income source
    Route::group([
        'prefix' => 'income-source',
        'as' => 'income-source.'
    ], function () {
        Route::get('/all', [IncomeSourceController::class, 'index'])->name('index');
        Route::get('/', [IncomeSourceController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [IncomeSourceController::class, 'edit'])->name('edit');
        Route::post('/', [IncomeSourceController::class, 'store'])->name('store');
        Route::put('/{id}', [IncomeSourceController::class, 'update'])->name('update');
        Route::delete('/{id}', [IncomeSourceController::class, 'destroy'])->name('destroy');
        Route::get('/data/status', [IncomeSourceController::class, 'incomeSourceStatusPieChart'])->name('data.status');
        Route::get('/section/piechart', [IncomeSourceController::class, 'piechart'])->name('section.piechart');
        Route::get('/section/header', [IncomeSourceController::class, 'header'])->name('section.header');
        Route::get('/section/accordion', [IncomeSourceController::class, 'accordion'])->name('section.accordion');
        Route::get('/sections/all', [IncomeSourceController::class, 'reloadPageSections'])->name('sections');
    });

    // Expense Type
    Route::group([
        'prefix' => 'expense-type',
        'as' => 'expense-type.'
    ], function () {
        Route::get('/all', [ExpenseTypeController::class, 'index'])->name('index');
        Route::get('/', [ExpenseTypeController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [ExpenseTypeController::class, 'edit'])->name('edit');
        Route::post('/', [ExpenseTypeController::class, 'store'])->name('store');
        Route::put('/{id}', [ExpenseTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [ExpenseTypeController::class, 'destroy'])->name('destroy');
        Route::get('/data/status', [ExpenseTypeController::class, 'expenseTypeStatusPieChart'])->name('data.status');
        Route::get('/section/piechart', [ExpenseTypeController::class, 'piechart'])->name('section.piechart');
        Route::get('/section/header', [ExpenseTypeController::class, 'header'])->name('section.header');
        Route::get('/section/accordion', [ExpenseTypeController::class, 'accordion'])->name('section.accordion');
        Route::get('/sections/all', [ExpenseTypeController::class, 'reloadPageSections'])->name('sections');
    });

    // Budget
    Route::group([
        'prefix' => 'budget',
        'as' => 'budget.'
    ], function () {
        Route::get('/{month}/{year}/list', [BudgetController::class, 'index'])->name('index');
        Route::get('/{expenseType}/{month}/{year}', [BudgetController::class, 'create'])->name('create');
        Route::post('/', [BudgetController::class, 'store'])->name('store');
        Route::get('/{id}', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BudgetController::class, 'update'])->name('update');
        Route::delete('/{id}', [BudgetController::class, 'destroy'])->name('destroy');
        Route::get('/sections/all', [BudgetController::class, 'reloadPageSections'])->name('sections');
    });

    // Transactions
    Route::group([
        'prefix' => 'transaction',
    ], function () {
        Route::get('/add-income', [TrackingHistoryController::class, 'addIncome'])->name('add-income');
        Route::get('/add-expense', [TrackingHistoryController::class, 'addExpense'])->name('add-expense');
        Route::get('/do-transfer', [TrackingHistoryController::class, 'doTransfer'])->name('do-transfer');
        Route::post('/', [TrackingHistoryController::class, 'doTransaction'])->name('transaction');
    });

    // Tracking
    Route::group([
        'prefix' => 'tracking',
        'as' => 'tracking.'
    ], function () {
        Route::get('/details/today', [TrackingHistoryController::class, 'showAllTodaysTransactions'])->name('today');
        Route::get('/details/month/{monthno}/{year}', [TrackingHistoryController::class, 'showMonthWiseTransactions'])->name('monthly');
        Route::get('/details/monthlygrouped/{itemid}/{transactiontype}', [TrackingHistoryController::class, 'showItemWiseMonthlyGroupedTotalTransactions'])->name('monthlygrouped');
        Route::get('/details/year/{year}', [TrackingHistoryController::class, 'showYearWiseTransactions'])->name('yearly');
        Route::get('/details/years/summary', [TrackingHistoryController::class, 'showYearWiseTransactionSummary'])->name('years.summary');

        Route::get('/detail/{id}/edit', [TrackingHistoryController::class, 'editTrackingDetailPage'])->name('edit');
        
        Route::put('/detail/{id}/update', [TrackingHistoryController::class, 'updateTrackingDetail'])->name('update');
        Route::delete('/detail/{id}/delete', [TrackingHistoryController::class, 'deleteTrackingDetail'])->name('destroy');
        Route::get('/sections/all', [TrackingHistoryController::class, 'reloadPageSections'])->name('sections');
    });

    // Dream
    Route::group([
        'prefix' => 'dream',
        'as' => 'dream.'
    ], function () {
        Route::get('/all', [DreamController::class, 'index'])->name('index');
        Route::get('/', [DreamController::class, 'create'])->name('create');
        Route::post('/', [DreamController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DreamController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DreamController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [DreamController::class, 'destroy'])->name('destroy');
        Route::post('/image/{id}', [DreamController::class, 'updateImage'])->name('image');
        Route::get('/section/accordion', [DreamController::class, 'accordion'])->name('section.accordion');
    });

    // Logout
    Route::get('/logout', [LogoutController::class, 'doLogout'])->name('logout');
});

require __DIR__ . '/setup.php';
