<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function accounts(){

        $accounts = Account::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        return view('accounts', [
            'accounts' => $accounts
        ]);
    }

    public function showCreateAccountPage(){
        return view('account-create');
    }

    public function createAccount(Request $request){

        $incomingFields = $request->validate([
            'name' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $account = Account::create($incomingFields);

        if ($account) return redirect('/account/' . $account->id . '/edit')->with('success', $account->name . ' account created successfully');

        return redirect('/account')->with('error', "Can't create account");
    }

    public function showEditAccountPage(Account $account){
        return view('account-update', ['account'=>$account]);
    }

    public function updateAccount(Account $account, Request $request){

        $incomingFields = $request->validate([
            'name' => ['required']
        ]);

        $uaccount = $account->update($incomingFields);

        if ($uaccount) return redirect('/account/' . $account->id . '/edit')->with('success', $account->name . ' account updated successfully');

        return redirect('/account/' . $account->id . '/edit')->with('error', $account->name . ' account update failed');

    }

    public function deleteAccount(Account $account)
    {
        $accountName = $account->name;

        $deleted = $account->delete();

        if ($deleted) return redirect('/account/all')->with('success', $accountName . ' account deleted successfully');

        return redirect('/account/all')->with('error', "Can't delete account");
    }
}
