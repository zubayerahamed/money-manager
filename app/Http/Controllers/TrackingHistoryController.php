<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
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

        echo "<pre>";
        echo $request->get('to_wallet');
        echo $request->get('transaction_time');
        die;
    }

}
