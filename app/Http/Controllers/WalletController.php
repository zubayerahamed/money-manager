<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{

    public function walletStatusPieChart(){
        return DB::table('arhead')    
                ->leftjoin('wallet','wallet.id','=','arhead.wallet_id')                       
                ->selectRaw("wallet.name, SUM(arhead.amount * arhead.row_sign)-SUM(arhead.transaction_charge) as value")
                ->where('arhead.user_id', '=', auth()->user()->id)
                ->groupBy('arhead.wallet_id')
                ->groupBy('wallet.name')
                ->get();
    }

    public function wallets(){
        $wallets = Wallet::all()->sortDesc();

        $totalBalance = DB::table('arhead')
                                ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalance")
                                ->where('user_id', '=', auth()->user()->id)
                                ->get();


        return view('wallets', [
            'wallets' => $wallets,
            'totalBalance' => $totalBalance[0]->totalBalance == null? 0 : $totalBalance[0]->totalBalance
        ]);
    }

    public function showCreateWalletPage(){
        return view('wallet-create');
    }

    public function showUpdateWalletPage(Wallet $wallet){
        return view('wallet-update', ['wallet' => $wallet]);
    }

    public function createWallet(Request $requset){

        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('wallet')],
            'icon' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $wallet = Wallet::create($incomingFields);

        if($wallet) {
            // Add to tracking 
            $trackingFields['transaction_type'] = 'OPENING';
            $trackingFields['amount'] = $requset->get('current_balance');
            $trackingFields['transaction_charge'] = 0;
            $trackingFields['to_wallet'] = $wallet->id;
            $trackingFields['transaction_date'] = date('Y-m-d');
            $trackingFields['transaction_time'] = date('H:i');
            $trackingFields['user_id'] = auth()->user()->id;

            $trackingHistory = TrackingHistory::create($trackingFields);

            // Add to arhead
            if($trackingHistory){
                $arhead['tracking_history_id'] = $trackingHistory->id;
                $arhead['user_id'] = auth()->user()->id;
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;

                $savedArhead = Arhead::create($arhead);
            }

            return redirect('/wallet/' . $wallet->id . '/edit')->with('success', $wallet->name . ' wallet created successfully');
        }

        return redirect('/wallet')->with('error', "Can't create wallet");
    }

    public function updateWallet(Wallet $wallet, Request $requset){

        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('wallet')->ignore($wallet->id)],
            'icon' => 'required'
        ]);

        $uWallet = $wallet->update($incomingFields);

        if($uWallet) return redirect('/wallet/' . $wallet->id . '/edit')->with('success', $wallet->name . ' wallet updated successfully');

        return redirect('/wallet/' . $wallet->id . '/edit')->with('error', $wallet->name . ' wallet update failed');
    }

    public function deleteWallet(Wallet $wallet){
        $walletName = $wallet->name;
        $deleted = $wallet->delete();

        if($deleted) return redirect('/wallet/all')->with('success', $walletName . ' wallet deleted successfully');

        return redirect('/wallet/all')->with('error', "Can't delete wallet");
    }
}
