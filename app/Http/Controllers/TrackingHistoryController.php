<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\ExpenseType;
use App\Models\IncomeSource;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];

                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;

                $savedArhead = Arhead::create($arhead);

                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;

                $savedArhead = Arhead::create($arhead);
            }

            return redirect('/transaction/' . $redirectUrl)->with('success', $message);
        } 

        return redirect('/transaction/' . $redirectUrl)->with('error', $errorMessage);
    }

}
