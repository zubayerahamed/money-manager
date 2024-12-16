<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\ExpenseType;
use App\Models\IncomeSource;
use App\Models\SubExpenseType;
use App\Models\TrackingHistory;
use App\Models\TransactionHistoryDetail;
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
        $expenseTypes = ExpenseType::with('subExpenseTypes')->orderBy('name', 'asc')->get();

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
     * Open add income form in modal
     *
     * @return Renderable
     */
    public function getLoan()
    {
        $incomeSources = IncomeSource::orderBy('name', 'asc')->get();
        $wallets = Wallet::orderBy('name', 'asc')->get();

        return view('layouts.transactions.transaction-create-form', [
            'incomeSources' => $incomeSources,
            'wallets' => $wallets,
            'transaction_type' => 'LOAN'
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
        } else if ($transactionType == 'LOAN') {
            $message = __('transaction.loan.add.success');

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
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;

                Arhead::create($arhead);
            } else if ($transactionType == 'LOAN') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;

                Arhead::create($arhead);
            } else if ($transactionType == 'EXPENSE') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;

                Arhead::create($arhead);

                // Now create expense details
                $expenseType = ExpenseType::with('subExpenseTypes')->where('id', '=', $incomingFields['expense_type'])->first();
                if($expenseType != null){
                    foreach($expenseType->subExpenseTypes as $se){
                        $amt = $request->get('sub_expense_' . $se->id);
                        if($amt != null && $amt > 0){
                            $detail = new TransactionHistoryDetail();
                            $detail->amount = $amt;
                            $detail->transaction_date = $trackingHistory['transaction_date'];
                            $detail->transaction_time = $trackingHistory['transaction_time'];
                            $detail->sub_expense_type_id = $se->id;
                            $detail->tracking_history_id = $trackingHistory->id;
                            $detail->user_id = auth()->id();
                            $detail->month = date('m', strtotime($trackingHistory['transaction_date']));
                            $detail->year = date('Y', strtotime($trackingHistory['transaction_date']));
                            $detail->save();
                        }
                    }
                }

            } else {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;
                Arhead::create($arhead);

                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;
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
            ->whereIn('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER', 'LOAN', 'OPENING'])
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
            'displayType' => '',
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
            ->whereIn('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER', 'LOAN', 'OPENING'])
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
            'displayType' => '',
            'sectionReloadRoute' => route($sectionReloadRoute, ['year' => $year]),
        ]);
    }

    public function showYearWiseTransactionSummary(Request $request)
    {
        $allTransactions = TrackingHistory::whereIn('transaction_type', ['INCOME', 'EXPENSE'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $yearWiseGroup = [];

        $currentYear = "";
        $i = 0;
        foreach ($allTransactions->all() as $trn) {
            $i++;
            $month_name = date("F", mktime(0, 0, 0, $trn->month, 10));
            $yearname = $trn->year; 
            $currentYearKey = $yearname . '-' . $month_name;

            if ($currentYear == "" || $currentYear != $currentYearKey) {
                $currentYear = $currentYearKey;
                
                $income = 0;
                $expense = 0;
                if ($trn->transaction_type == 'INCOME') $income = $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $expense = $trn->amount;
                
                // Search for previous one
                if(array_key_exists($yearname, $yearWiseGroup)){
                    $yearArr = $yearWiseGroup[$yearname];

                    $monthData = $yearArr['data'];

                    $newMonthData = ['income' => $income, 'expense' => $expense];
                    $monthData = array_push_assoc($monthData, $month_name, $newMonthData);
                    $yearArr = array_push_assoc($yearArr, 'data', $monthData);

                    if ($trn->transaction_type == 'INCOME') $yearArr['income'] = $yearArr['income'] + $trn->amount;
                    if ($trn->transaction_type == 'EXPENSE') $yearArr['expense'] = $yearArr['expense'] + $trn->amount;
                    $yearArr = array_push_assoc($yearArr, 'income', $yearArr['income']);
                    $yearArr = array_push_assoc($yearArr, 'expense', $yearArr['expense']);
                    
                    $yearWiseGroup = array_push_assoc($yearWiseGroup, $yearname, $yearArr);
                } else {
                    $monthData = [$month_name => ['income' => $income, 'expense' => $expense]];
                
                    $yearArr = ['data' => [], 'income' => 0, 'expense' => 0];
                    $yearArr = array_push_assoc($yearArr, 'data', $monthData);
                    $yearArr = array_push_assoc($yearArr, 'income', $income);
                    $yearArr = array_push_assoc($yearArr, 'expense', $expense);
                    
                    $yearWiseGroup = array_push_assoc($yearWiseGroup, $yearname, $yearArr);
                }
            } else {
                
                $yearArr = $yearWiseGroup[$yearname];
                
                $monthData = $yearArr['data'];
                
                $specificMonth = $monthData[$month_name];

                if($specificMonth){
                    if ($trn->transaction_type == 'INCOME') $specificMonth['income'] = $specificMonth['income'] + $trn->amount;
                    if ($trn->transaction_type == 'EXPENSE') $specificMonth['expense'] = $specificMonth['expense'] + $trn->amount;
                    $specificMonth = array_push_assoc($specificMonth, 'income', $specificMonth['income']);
                    $specificMonth = array_push_assoc($specificMonth, 'expense', $specificMonth['expense']);
                    $monthData = array_push_assoc($monthData, $month_name, $specificMonth);
                    $yearArr = array_push_assoc($yearArr, 'data', $monthData);

                    if ($trn->transaction_type == 'INCOME') $yearArr['income'] = $yearArr['income'] + $trn->amount;
                    if ($trn->transaction_type == 'EXPENSE') $yearArr['expense'] = $yearArr['expense'] + $trn->amount;
                    $yearArr = array_push_assoc($yearArr, 'income', $yearArr['income']);
                    $yearArr = array_push_assoc($yearArr, 'expense', $yearArr['expense']);
                    
                    $yearWiseGroup = array_push_assoc($yearWiseGroup, $yearname, $yearArr);
                } 

            }
        }

        //dd($yearWiseGroup);

        $sectionReloadRoute = $request->route()->getName();

        if($request->ajax()){
            return view('layouts.transactions.transaction-detail-accordion', [
                'thDetails' => $yearWiseGroup,
            ]);
        }

        return view('th-details', [
            'thDetails' => $yearWiseGroup,
            'displayType' => 'yearWiseSummary',
            'sectionReloadRoute' => route($sectionReloadRoute),
        ]);
    }

    public function showItemWiseMonthlyGroupedTotalTransactions($itemid, $transactiontype, Request $request)
    {

        $searchColumn = 'expense_type';
        $amountKey = 'expense';
        $altAmountKey = 'income';

        if($transactiontype == 'INCOME'){
            $searchColumn = 'income_source';
            $amountKey = 'income';
            $altAmountKey = 'expense';
        } 

        if($transactiontype == 'LOAN'){
            $searchColumn = 'income_source';
            $amountKey = 'income';
            $altAmountKey = 'expense';
        } 

        $allTransactions = TrackingHistory::where('transaction_type', '=', $transactiontype)
            ->where($searchColumn, '=', $itemid)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        
        $monthWiseGroup = [];

        $currentTransactionMonth = "";
        foreach ($allTransactions->all() as $trn) {
            $month_name = date("F", mktime(0, 0, 0, $trn->month, 10)) . ', ' . $trn->year;

            if($currentTransactionMonth == "" || $currentTransactionMonth != $month_name){
                $currentTransactionMonth = $month_name;
                $amount = $trn->amount;
                $monthWiseGroup = array_push_assoc($monthWiseGroup, $month_name, ['data' => [$trn], $amountKey => $amount, $altAmountKey => '']);
            } else {
                $monthArr = $monthWiseGroup[$month_name];
                $trnDataArr = $monthArr['data'];
                $newAmount = $monthArr[$amountKey] + $trn->amount;
                array_push($trnDataArr, $trn);
                $monthArr = array_push_assoc($monthArr, 'data', $trnDataArr);
                $monthArr = array_push_assoc($monthArr, $amountKey, $newAmount);
                $monthWiseGroup = array_push_assoc($monthWiseGroup, $month_name, $monthArr);
            }
        }

        $sectionReloadRoute = $request->route()->getName();

        if($request->ajax()){
            return view('layouts.transactions.transaction-detail-accordion', [
                'thDetails' => $monthWiseGroup,
            ]);
        }

        return view('th-details', [
            'thDetails' => $monthWiseGroup,
            'displayType' => '',
            'sectionReloadRoute' => route($sectionReloadRoute, ['itemid' => $itemid, 'transactiontype' => $transactiontype]),
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
            ->whereIn('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER', 'LOAN', 'OPENING'])
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
            'displayType' => '',
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
        $trackingHistories = TrackingHistory::with('details')->where('id', '=', $id)->get();
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
        } else if ($trackingHistory->transaction_type == 'LOAN') {
            $incomeSources = IncomeSource::orderBy('name', 'asc')->get();

            return view('layouts.transactions.transaction-edit-form', [
                'trackingHistory' => $trackingHistory,
                'incomeSources' => $incomeSources,
                'wallets' => $wallets,
                'transaction_type' => 'LOAN'
            ]);
        } else if ($trackingHistory->transaction_type == 'EXPENSE') {
            $expenseTypes = ExpenseType::orderBy('name', 'asc')->get();

            $subExpenseTypes = SubExpenseType::where('expense_type_id', '=', $trackingHistory->expense_type)->get();
            foreach($subExpenseTypes as $se){
                $detail = TransactionHistoryDetail::where('sub_expense_type_id', '=', $se->id)->where('tracking_history_id', '=', $trackingHistory->id)->first();
                if($detail != null){
                    $se->amount = $detail->amount;
                } else {
                    $se->amount = 0;
                }
            }
            $subExpenseTypes = $subExpenseTypes->sortByDesc('active');

            return view('layouts.transactions.transaction-edit-form', [
                'trackingHistory' => $trackingHistory,
                'expenseTypes' => $expenseTypes,
                'wallets' => $wallets,
                'transaction_type' => 'EXPENSE',
                'subExpenseTypes' => $subExpenseTypes
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
        } else if ($transactionType == 'LOAN') {
            $message = __('transaction.loan.update.success');

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
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;

                Arhead::create($arhead);
            } else if ($transactionType == 'LOAN') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;

                Arhead::create($arhead);
            } else if ($transactionType == 'EXPENSE') {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;

                Arhead::create($arhead);

                // Now create expense details
                $expenseType = ExpenseType::with('subExpenseTypes')->where('id', '=', $incomingFields['expense_type'])->first();
                if($expenseType != null){
                    foreach($expenseType->subExpenseTypes as $se){
                        $amt = $request->get('sub_expense_' . $se->id);
                        if($amt != null && $amt > 0){
                            $detail = new TransactionHistoryDetail();
                            $detail->amount = $amt;
                            $detail->transaction_date = $trackingHistory['transaction_date'];
                            $detail->transaction_time = $trackingHistory['transaction_time'];
                            $detail->sub_expense_type_id = $se->id;
                            $detail->tracking_history_id = $trackingHistory->id;
                            $detail->user_id = auth()->id();
                            $detail->month = date('m', strtotime($trackingHistory['transaction_date']));
                            $detail->year = date('Y', strtotime($trackingHistory['transaction_date']));
                            $detail->save();
                        }
                    }
                }

            } else {
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['xdate'] = $trackingHistory['transaction_date'];
                $arhead['xtime'] = $trackingHistory['transaction_time'];

                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;
                Arhead::create($arhead);

                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['excluded'] = Wallet::find($arhead['wallet_id'])->excluded;
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
