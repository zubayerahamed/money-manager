<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\ExpenseType;
use App\Models\IncomeSource;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class TrackingHistoryController extends Controller
{
    
    public function showAddIncomePage(){
        $incomeSources = IncomeSource::where('user_id', auth()->user()->id)->get();
        $wallets = Wallet::where('user_id', auth()->user()->id)->get();

        return view('add-income', [
            'incomeSources' => $incomeSources,
            'wallets' => $wallets
        ]);
    }

    public function showAddExpensePage(){
        $wallets = Wallet::where('user_id', auth()->user()->id)->get();
        $expenseTypes = ExpenseType::where('user_id', auth()->user()->id)->get();

        return view('add-expense', [
            'expenseTypes' => $expenseTypes,
            'wallets' => $wallets
        ]);
    }

    public function showDoTransferPage(){
        $wallets = Wallet::where('user_id', auth()->user()->id)->get();
        return view('do-transfer', [
            'wallets' => $wallets
        ]);
    }


    public function doTransaction(Request $request){

        $incomingFields = $request->validate([
            'transaction_type' => 'required',
        ]);

        $transactionType = $request->get('transaction_type');

        $message = "";
        $errorMessage = "";
        $redirectUrl = "";

        if($transactionType == 'INCOME'){
            $message = "Income Added Successfully";
            $errorMessage = "Failed to add income";
            $redirectUrl = "add-income";

            $incomingFields = $request->validate([
                'amount' => ['required', 'min:0'],
                'transaction_charge' => ['min:0'],
                'to_wallet' => 'required',
                'income_source' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

        } else if($transactionType == 'EXPENSE'){
            $message = "Expense Added Successfully";
            $errorMessage = "Failed to add expense";
            $redirectUrl = "add-expense";

            $incomingFields = $request->validate([
                'amount' => ['required', 'min:0'],
                'transaction_charge' => ['min:0'],
                'from_wallet' => 'required',
                'expense_type' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            $wallet = Wallet::find($incomingFields['from_wallet']);
            if($wallet->currentBalance < ($incomingFields['amount'] + $incomingFields['transaction_charge'])){
                return back()->with('error', $wallet->name . ' has insufficient balance for transaction');
            }

        } else {
            $message = "Transfer Successfully";
            $errorMessage = "Failed to do transfer";
            $redirectUrl = "do-transfer";

            $incomingFields = $request->validate([
                'amount' => ['required', 'min:0'],
                'transaction_charge' => ['min:0'],
                'from_wallet' => 'required',
                'to_wallet' => 'required',
                'transaction_date' => 'required',
                'transaction_time' => 'required'
            ]);

            $wallet = Wallet::find($incomingFields['from_wallet']);
            if($wallet->currentBalance < ($incomingFields['amount'] + $incomingFields['transaction_charge'])){
                return back()->with('error', $wallet->name . ' has insufficient balance for transaction');
            }
        }


        $incomingFields['transaction_type'] = $request->get('transaction_type');
        $incomingFields['note'] = $request->get('note');
        $incomingFields['user_id'] = auth()->user()->id;
        $incomingFields['month'] = date('m', strtotime($incomingFields['transaction_date']));
        $incomingFields['year'] =  date('Y', strtotime($incomingFields['transaction_date']));

        $trackingHistory = TrackingHistory::create($incomingFields);

        if($trackingHistory){

            $arhead['tracking_history_id'] = $trackingHistory->id;
            $arhead['user_id'] = auth()->user()->id;
            if($transactionType == 'INCOME'){
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;

                $savedArhead = Arhead::create($arhead);
            } else if ($transactionType == 'EXPENSE'){
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;

                $savedArhead = Arhead::create($arhead);
            } else {
                $arhead['amount'] = $trackingHistory['amount'];
                
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;

                $savedArhead = Arhead::create($arhead);

                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];

                $savedArhead = Arhead::create($arhead);
            }

            return redirect('/transaction/' . $redirectUrl)->with('success', $message);
        } 

        return redirect('/transaction/' . $redirectUrl)->with('error', $errorMessage);
    }

    function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }

    public function showAllTransactions(){

        $totalIncome = DB::table('tracking_history')
                                ->where('user_id', '=', auth()->user()->id)
                                ->where('month', '=', date('m'))
                                ->where('year', '=', date('Y'))
                                ->orderBy('transaction_date', 'desc')
                                ->get();

        $dateWiseGroup = [];

        $final_arr = $this->array_push_assoc($dateWiseGroup, '4', [12, 13, 14] );


        $currentTrnDate = "";
        foreach($totalIncome->all() as $trn){


            if($currentTrnDate == "" || $currentTrnDate != $trn->transaction_date){
                $currentTrnDate = $trn->transaction_date;
                $income = 0;
                $expense = 0;
                if($trn->transaction_type == 'INCOME') $income = $trn->amount;
                if($trn->transaction_type == 'EXPENSE') $expense = $trn->amount;
                $dateWiseGroup = $this->array_push_assoc($dateWiseGroup, $trn->transaction_date , ['data' => [$trn], 'income' => $income, 'expense' => $expense]);
            } else {
                $dateData = $dateWiseGroup[$trn->transaction_date];
                $existDateData = $dateData['data'];
                if($trn->transaction_type == 'INCOME') $dateData['income'] = $dateData['income'] + $trn->amount;
                if($trn->transaction_type == 'EXPENSE') $dateData['expense'] = $dateData['expense'] + $trn->amount;
                array_push($existDateData, $trn);
                $dateData = $this->array_push_assoc($dateData, 'data', $existDateData);
                $dateData = $this->array_push_assoc($dateData, 'income', $dateData['income']);
                $dateData = $this->array_push_assoc($dateData, 'expense', $dateData['expense']);
                $dateWiseGroup = $this->array_push_assoc($dateWiseGroup, $trn->transaction_date , $dateData);
            }

           
        }

        dd($dateWiseGroup);

        dd($totalIncome->all());

        return "hi";
    }

}
