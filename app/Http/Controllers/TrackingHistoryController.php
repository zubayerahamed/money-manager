<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\IncomeSource;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingHistoryController extends Controller
{
    
    public function showAddIncomePage(){

        //$incomeSources = DB::table('income_source')->where('user_id', auth()->user()->id)->get();
        $incomeSources = IncomeSource::where('user_id', auth()->user()->id)->get();
        $wallets = Wallet::where('user_id', auth()->user()->id)->get();

        return view('add-income', [
            'incomeSources' => $incomeSources,
            'wallets' => $wallets
        ]);
    }

    public function showAddExpensePage(){
        return view('add-expense');
    }

    public function showDoTransferPage(){
        return view('do-transfer');
    }


    public function doTransaction(Request $request){

        $incomingFields = $request->validate([
            'transaction_type' => 'required',
        ]);

        $transactionType = $request->get('transaction_type');

        $message = "";
        $errorMessage = "";
        $redirectUrl = "";

        if($transactionType == 'Income'){
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

        } else if($transactionType == 'Expense'){
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

        $trackingHistory = TrackingHistory::create($incomingFields);

        if($trackingHistory){

            $arhead['tracking_history_id'] = $trackingHistory->id;
            $arhead['user_id'] = auth()->user()->id;
            if($transactionType == 'Income'){
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;

                $savedArhead = Arhead::create($arhead);
            } else if ($transactionType == 'Expense'){
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
