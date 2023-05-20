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

// Registration
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('setup');
Route::post('/register', [RegisterController::class, 'store'])->name('register')->middleware('setup');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('setup');
Route::post('/login', [LoginController::class, 'store'])->name('login')->middleware('setup');

Route::group(['middleware' => ['auth', 'setup']], function () {
    // Home
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/current-month/line-chart', [DashboardController::class, 'getCurrentMonthLineChartData'])->name('month.line-chart');
    Route::get('/current-year/line-chart', [DashboardController::class, 'getCurrentYearLineChartData'])->name('year.line-chart');

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
        Route::put('/{expenseType}', [ExpenseTypeController::class, 'update'])->name('update');
        Route::delete('/{expenseType}', [ExpenseTypeController::class, 'destroy'])->name('destroy');
        Route::get('/data/status', [ExpenseTypeController::class, 'expenseTypeStatusPieChart'])->name('data.status');
        Route::get('/section/piechart', [ExpenseTypeController::class, 'piechart'])->name('section.piechart');
        Route::get('/section/header', [ExpenseTypeController::class, 'header'])->name('section.header');
        Route::get('/section/accordion', [ExpenseTypeController::class, 'accordion'])->name('section.accordion');
    });

    // Budget
    Route::group([
        'prefix' => 'budget',
        'as' => 'budget.'
    ], function () {
        Route::get('/{month}/{year}/list', [BudgetController::class, 'index'])->name('index');
        Route::get('/{expenseType}/{month}/{year}', [BudgetController::class, 'create'])->name('create');
        Route::post('/', [BudgetController::class, 'store'])->name('store');
        Route::get('/{budget}', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{budget}', [BudgetController::class, 'update'])->name('update');
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
        Route::get('/details/year/{year}', [TrackingHistoryController::class, 'showYearWiseTransactions'])->name('yearly');
        Route::get('/detail/{trackingHistory}/edit', [TrackingHistoryController::class, 'editTrackingDetailPage'])->name('edit');
        Route::put('/detail/{trackingHistory}/update', [TrackingHistoryController::class, 'updateTrackingDetail'])->name('update');
        Route::delete('/detail/{trackingHistory}/delete', [TrackingHistoryController::class, 'deleteTrackingDetail'])->name('destroy');
    });

    // Dream
    Route::group([
        'prefix' => 'dream',
        'as' => 'dream.'
    ], function () {
        Route::get('/all', [DreamController::class, 'index'])->name('index');
        Route::get('/', [DreamController::class, 'create'])->name('create');
        Route::post('/', [DreamController::class, 'store'])->name('store');
        Route::get('/{dream}/edit', [DreamController::class, 'edit'])->name('edit');
        Route::put('/{dream}', [DreamController::class, 'update'])->name('update');
        Route::delete('/{dream}/delete', [DreamController::class, 'destroy'])->name('destroy');
        Route::post('/image/{dream}', [DreamController::class, 'updateImage'])->name('image');
        Route::get('/section/accordion', [DreamController::class, 'accordion'])->name('section.accordion');
    });

    // Logout
    Route::get('/logout', [LogoutController::class, 'doLogout'])->name('logout');
});

require __DIR__ . '/setup.php';