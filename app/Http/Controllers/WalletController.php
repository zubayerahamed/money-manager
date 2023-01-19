<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function wallets(){

        $wallets = Wallet::all()->sortDesc();

        return view('wallets', ['wallets' => $wallets]);
    }

    public function showCreateWalletPage(){
        return view('wallet-create');
    }

    public function showUpdateWalletPage(Wallet $wallet){
        return view('wallet-update', ['wallet' => $wallet]);
    }

    public function createWallet(Request $requset){

        $incomingFields = $requset->validate([
            'name' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $wallet = Wallet::create($incomingFields);

        if($wallet) return redirect('/wallet/' . $wallet->id . '/edit')->with('success', $wallet->name . ' wallet created successfully');

        return redirect('/wallet')->with('error', "Can't create wallet");
    }

    public function updateWallet(Wallet $wallet, Request $requset){

        $incomingFields = $requset->validate([
            'name' => 'required'
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
