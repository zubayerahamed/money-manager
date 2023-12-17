<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\ExpenseType;
use App\Models\IncomeSource;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use App\Traits\HttpResponses;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TrackingHistoryController extends Controller
{
    use HttpResponses;

    /**
     * Page Sections loader
     *
     * @param Request $requset
     * @return void
     */
    public function reloadPageSections(Request $requset){
        return $this->reloadSectionsOnly(
            [
                ['transaction-detail-accordion', $requset->get('definedRoute')],
            ]
        );
    }

    /**
     * Open add income form in modal
     *
     * @return Renderable
     */
    public function addIncome()
    {
        $incomeSources = IncomeSource::orderBy('name', 'asc')->get();
        $wallets = Wallet::orderBy('name', 'asc')->get();

        return view('layouts.transactions.transaction-create-form', [
            'incomeSources' => $incomeSources,
            'wallets' => $wallets,
            'transaction_type' => 'INCOME'
        ]);
    }

    /**
     * Open add expense form in modal
     *
     * @return Renderable
     */
    public function addExpense()
    {
        $wallets = Wallet::orderBy('name', 'asc')->get();
        $expenseTypes = ExpenseType::orderBy('name', 'asc')->get();

        return view('layouts.transactions.transaction-create-form', [
            'expenseTypes' => $expenseTypes,
            'wallets' => $wallets,
            'transaction_type' => 'EXPENSE'
        ]);
    }

    /**
     * Open do transfer form in modal
     *
     * @return Renderable
     */
    public function doTransfer()
    {
        $wallets = Wallet::orderBy('name', 'asc')->get();

        return view('layouts.transactions.transaction-create-form', [
            'wallets' => $wallets,
            'transaction_type' => 'TRANSFER'
        ]);
    }

    /**
     * Do Transaction and add data to storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function doTransaction(Request $request)
    {
        $incomingFields = $request->validate([
            'transaction_type' => 'required',
        ]);

        $transactionType = $request->get('transaction_type');

        $message = "";
        $errorMessage = __('common.process.error');

        if ($transactionType == 'INCOME') {
            $message = __('transaction.income.add.success');

            $incomingFields = $request->validate([
                'amount' => ['required', 'numeric', 'min:0'],
                'transaction_charge' => ['required', 'numeric', 'min:0'],
                'to_wallet' => 'required',
                'income_source' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);
        } else if ($transactionType == 'EXPENSE') {
            $message = __('transaction.expense.add.success');

            $incomingFields = $request->validate([
                'amount' => ['required',  'numeric', 'min:0'],
                'transaction_charge' => ['required', 'numeric', 'min:0'],
                'from_wallet' => 'required',
                'expense_type' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            $wallet = Wallet::find($incomingFields['from_wallet']);

            if ($wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) == null || $wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) < ($incomingFields['amount'] + $incomingFields['transaction_charge'])) {
                return $this->error(null, __('transaction.insufficient.balance', ['name' => $wallet->name]), 400);
            }
        } else {
            $message = __('transaction.transfer.add.success');

            $incomingFields = $request->validate([
                'amount' => ['required',  'numeric', 'min:0'],
                'transaction_charge' => ['required', 'numeric', 'min:0'],
                'from_wallet' => 'required',
                'to_wallet' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            $wallet = Wallet::find($incomingFields['from_wallet']);
            if ($wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) == null || $wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) < ($incomingFields['amount'] + $incomingFields['transaction_charge'])) {
                return $this->error(null, __('transaction.insufficient.balance', ['name' => $wallet->name]), 400);
            }
        }


        $incomingFields['transaction_type'] = $request->get('transaction_type');
        $incomingFields['note'] = $request->get('note');
        $incomingFields['user_id'] = auth()->id();
        $incomingFields['month'] = date('m', strtotime($incomingFields['transaction_date']));
        $incomingFields['year'] =  date('Y', strtotime($incomingFields['transaction_date']));

        $trackingHistory = TrackingHistory::create($incomingFields);

        if ($trackingHistory) {

            $arhead['tracking_history_id'] = $trackingHistory->id;
            $arhead['user_id'] = auth()->id();
            if ($transactionType == 'INCOME') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                Arhead::create($arhead);
            } else if ($transactionType == 'EXPENSE') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                Arhead::create($arhead);
            } else {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                Arhead::create($arhead);

                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                Arhead::create($arhead);
            }

            return $this->success(null, $message);
        }

        return $this->error(null, $errorMessage);
    }

    /**
     * Dislay the todays transaction details page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showAllTodaysTransactions(Request $request)
    {
        $totalIncome = TrackingHistory::where('user_id', '=', auth()->user()->id)
            ->where('transaction_date', '=', date('Y/m/d'))
            ->whereIn('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER'])
            ->orderBy('id', 'desc')
            ->get();

        $dateWiseGroup = [];

        $currentTrnDate = "";
        foreach ($totalIncome->all() as $trn) {

            if ($currentTrnDate == "" || $currentTrnDate != $trn->transaction_date) {
                $currentTrnDate = $trn->transaction_date;
                $income = 0;
                $expense = 0;
                if ($trn->transaction_type == 'INCOME') $income = $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $expense = $trn->amount;
                $dateWiseGroup = array_push_assoc($dateWiseGroup, $trn->transaction_date, ['data' => [$trn], 'income' => $income, 'expense' => $expense]);
            } else {
                $dateData = $dateWiseGroup[$trn->transaction_date];
                $existDateData = $dateData['data'];
                if ($trn->transaction_type == 'INCOME') $dateData['income'] = $dateData['income'] + $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $dateData['expense'] = $dateData['expense'] + $trn->amount;
                array_push($existDateData, $trn);
                $dateData = array_push_assoc($dateData, 'data', $existDateData);
                $dateData = array_push_assoc($dateData, 'income', $dateData['income']);
                $dateData = array_push_assoc($dateData, 'expense', $dateData['expense']);
                $dateWiseGroup = array_push_assoc($dateWiseGroup, $trn->transaction_date, $dateData);
            }
        }

        $sectionReloadRoute = $request->route()->getName();

        if($request->ajax()){
            return view('layouts.transactions.transaction-detail-accordion', [
                'thDetails' => $dateWiseGroup,
            ]);
        }

        return view('th-details', [
            'thDetails' => $dateWiseGroup,
            'sectionReloadRoute' => route($sectionReloadRoute),
        ]);
    }

    /**
     * Dislay the year wise transaction details page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showYearWiseTransactions($year, Request $request)
    {
        $totalIncome = TrackingHistory::where('year', '=', $year)
            ->whereIn('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $dateWiseGroup = [];

        $currentTrnDate = "";
        foreach ($totalIncome->all() as $trn) {

            if ($currentTrnDate == "" || $currentTrnDate != $trn->transaction_date) {
                $currentTrnDate = $trn->transaction_date;
                $income = 0;
                $expense = 0;
                if ($trn->transaction_type == 'INCOME') $income = $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $expense = $trn->amount;
                $dateWiseGroup = array_push_assoc($dateWiseGroup, $trn->transaction_date, ['data' => [$trn], 'income' => $income, 'expense' => $expense]);
            } else {
                $dateData = $dateWiseGroup[$trn->transaction_date];
                $existDateData = $dateData['data'];
                if ($trn->transaction_type == 'INCOME') $dateData['income'] = $dateData['income'] + $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $dateData['expense'] = $dateData['expense'] + $trn->amount;
                array_push($existDateData, $trn);
                $dateData = array_push_assoc($dateData, 'data', $existDateData);
                $dateData = array_push_assoc($dateData, 'income', $dateData['income']);
                $dateData = array_push_assoc($dateData, 'expense', $dateData['expense']);
                $dateWiseGroup = array_push_assoc($dateWiseGroup, $trn->transaction_date, $dateData);
            }
        }

        $sectionReloadRoute = $request->route()->getName();

        if($request->ajax()){
            return view('layouts.transactions.transaction-detail-accordion', [
                'thDetails' => $dateWiseGroup,
            ]);
        }

        return view('th-details', [
            'thDetails' => $dateWiseGroup,
            'sectionReloadRoute' => route($sectionReloadRoute, ['year' => $year]),
        ]);
    }

    /**
     * Dislay the month wise transaction details page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showMonthWiseTransactions($monthno, $year, Request $request)
    {

        $totalIncome = TrackingHistory::where('month', '=', $monthno)
            ->where('year', '=', $year)
            ->whereIn('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $dateWiseGroup = [];

        $currentTrnDate = "";
        foreach ($totalIncome->all() as $trn) {

            if ($currentTrnDate == "" || $currentTrnDate != $trn->transaction_date) {
                $currentTrnDate = $trn->transaction_date;
                $income = 0;
                $expense = 0;
                if ($trn->transaction_type == 'INCOME') $income = $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $expense = $trn->amount;
                $dateWiseGroup = array_push_assoc($dateWiseGroup, $trn->transaction_date, ['data' => [$trn], 'income' => $income, 'expense' => $expense]);
            } else {
                $dateData = $dateWiseGroup[$trn->transaction_date];
                $existDateData = $dateData['data'];
                if ($trn->transaction_type == 'INCOME') $dateData['income'] = $dateData['income'] + $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $dateData['expense'] = $dateData['expense'] + $trn->amount;
                array_push($existDateData, $trn);
                $dateData = array_push_assoc($dateData, 'data', $existDateData);
                $dateData = array_push_assoc($dateData, 'income', $dateData['income']);
                $dateData = array_push_assoc($dateData, 'expense', $dateData['expense']);
                $dateWiseGroup = array_push_assoc($dateWiseGroup, $trn->transaction_date, $dateData);
            }
        }

        $sectionReloadRoute = $request->route()->getName();

        if($request->ajax()){
            return view('layouts.transactions.transaction-detail-accordion', [
                'thDetails' => $dateWiseGroup,
            ]);
        }

        return view('th-details', [
            'thDetails' => $dateWiseGroup,
            'sectionReloadRoute' => route($sectionReloadRoute, ['year' => $year, 'monthno' => $monthno]),
        ]);
    }

    /**
     * Dislay the transaction edit page in modal
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function editTrackingDetailPage($id)
    {
        $trackingHistories = TrackingHistory::where('id', '=', $id)->get();
        if ($trackingHistories->isEmpty()) return $this->error(null, __('transaction.not.found'), 400);

        $trackingHistory = $trackingHistories->get(0);

        $wallets = Wallet::orderBy('name', 'asc')->get();

        if ($trackingHistory->transaction_type == 'INCOME') {
            $incomeSources = IncomeSource::orderBy('name', 'asc')->get();

            return view('layouts.transactions.transaction-edit-form', [
                'trackingHistory' => $trackingHistory,
                'incomeSources' => $incomeSources,
                'wallets' => $wallets,
                'transaction_type' => 'INCOME'
            ]);
        } else if ($trackingHistory->transaction_type == 'EXPENSE') {
            $expenseTypes = ExpenseType::orderBy('name', 'asc')->get();

            return view('layouts.transactions.transaction-edit-form', [
                'trackingHistory' => $trackingHistory,
                'expenseTypes' => $expenseTypes,
                'wallets' => $wallets,
                'transaction_type' => 'EXPENSE'
            ]);
        } else {
            return view('layouts.transactions.transaction-edit-form', [
                'trackingHistory' => $trackingHistory,
                'wallets' => $wallets,
                'transaction_type' => 'TRANSFER'
            ]);
        }
    }

    /**
     * Update transaction details in storage
     *
     * @param int $id
     * @param Request $request
     * @return Renderable
     */
    public function updateTrackingDetail($id, Request $request)
    {
        $trackingHistories = TrackingHistory::where('id', '=', $id)->get();
        if ($trackingHistories->isEmpty()) return $this->error(null, __('transaction.not.found'), 400);

        $trackingHistory = $trackingHistories->get(0);

        // add new tracking
        $incomingFields = $request->validate([
            'transaction_type' => 'required',
        ]);

        $transactionType = $request->get('transaction_type');

        $message = "";
        $errorMessage = __('common.process.error');

        if ($transactionType == 'INCOME') {
            $message = __('transaction.income.update.success');

            $incomingFields = $request->validate([
                'amount' => ['required', 'numeric', 'min:0'],
                'transaction_charge' => ['required', 'numeric', 'min:0'],
                'to_wallet' => 'required',
                'income_source' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            // Delete previous
            $trackingHistory->delete();
        } else if ($transactionType == 'EXPENSE') {
            $message = __('transaction.expense.update.success');

            $incomingFields = $request->validate([
                'amount' => ['required', 'numeric', 'min:0'],
                'transaction_charge' => ['required', 'numeric', 'min:0'],
                'from_wallet' => 'required',
                'expense_type' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            
            $wallet = Wallet::find($incomingFields['from_wallet']);
            if ($wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) == null || $wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) < ($incomingFields['amount'] + $incomingFields['transaction_charge'] - $trackingHistory->amount - $trackingHistory->transaction_charge)) {
                return $this->error(null, __('transaction.insufficient.balance', ['name' => $wallet->name]), 400);
            }

            // Delete previous
            $trackingHistory->delete();
        } else {
            $message = __('transaction.transfer.update.success');

            $incomingFields = $request->validate([
                'amount' => ['required', 'numeric', 'min:0'],
                'transaction_charge' => ['required', 'numeric', 'min:0'],
                'from_wallet' => 'required',
                'to_wallet' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            $wallet = Wallet::find($incomingFields['from_wallet']);
            if ($wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) == null || $wallet->getBalanceByDate($incomingFields['transaction_date'], $incomingFields['transaction_time']) < ($incomingFields['amount'] + $incomingFields['transaction_charge'] - $trackingHistory->amount - $trackingHistory->transaction_charge)) {
                return $this->error(null, __('transaction.insufficient.balance', ['name' => $wallet->name]), 400);
            }

            // Delete previous
            $trackingHistory->delete();
        }


        $incomingFields['transaction_type'] = $request->get('transaction_type');
        $incomingFields['note'] = $request->get('note');
        $incomingFields['user_id'] = auth()->id();
        $incomingFields['month'] = date('m', strtotime($incomingFields['transaction_date']));
        $incomingFields['year'] =  date('Y', strtotime($incomingFields['transaction_date']));

        $trackingHistory = TrackingHistory::create($incomingFields);

        if ($trackingHistory) {

            $arhead['tracking_history_id'] = $trackingHistory->id;
            $arhead['user_id'] = auth()->user()->id;
            if ($transactionType == 'INCOME') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                Arhead::create($arhead);
            } else if ($transactionType == 'EXPENSE') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                Arhead::create($arhead);
            } else {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                Arhead::create($arhead);

                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                Arhead::create($arhead);
            }

            return $this->successWithReload(null, $message);
        }

        return $this->error(null, $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Renderable
     */
    public function deleteTrackingDetail($id)
    {
        $trackingHistories = TrackingHistory::where('id', '=', $id)->get();
        if ($trackingHistories->isEmpty()) return $this->error(null, __('transaction.not.found'), 400);

        $trackingHistory = $trackingHistories->get(0);

        $deleted = $trackingHistory->delete();
        if ($deleted) {
            return $this->successWithReload(null, __('transaction.delete.success'));
        }

        return $this->error(null, __('common.process.error'));
    }
}
