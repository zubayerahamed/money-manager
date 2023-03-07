<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTrackingHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function accounts()
    {

        $accounts = Account::where('user_id', '=', auth()->user()->id)->get()->sortDesc();
        $wallets = Wallet::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        $totalSavingAmount = DB::table('account_tracking_histories')
            ->selectRaw("SUM(amount * row_sign) as totalSavingAmount")
            ->where('user_id', '=', auth()->user()->id)
            ->get();

        return view('accounts', [
            'accounts' => $accounts,
            'wallets' => $wallets,
            'totalBalance' => $totalSavingAmount[0]->totalSavingAmount == null ? 0 : $totalSavingAmount[0]->totalSavingAmount
        ]);
    }

    public function showCreateAccountPage()
    {
        return view('account-create');
    }

    public function createAccount(Request $request)
    {

        $incomingFields = $request->validate([
            'name' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $account = Account::create($incomingFields);

        $ach = new AccountTrackingHistory();
        $ach->transaction_type = "OPENING";
        $ach->amount = $request->get('opening_balance');
        $ach->row_sign = +1;
        $ach->account_id = $account->id;
        $ach->transaction_date = date('Y-m-d');
        $ach->transaction_time = date('H:i');
        $ach->note = "Opening Balance";
        $ach->user_id = auth()->user()->id;
        $ach->month = date('m');
        $ach->year = date('Y');
        $ach->save();


        if ($account) return redirect('/account/' . $account->id . '/edit')->with('success', $account->name . ' account created successfully');

        return redirect('/account')->with('error', "Can't create account");
    }

    public function showEditAccountPage(Account $account)
    {
        return view('account-update', ['account' => $account]);
    }

    public function updateAccount(Account $account, Request $request)
    {

        $incomingFields = $request->validate([
            'name' => ['required']
        ]);

        $uaccount = $account->update($incomingFields);

        if ($uaccount) return redirect('/account/' . $account->id . '/edit')->with('success', $account->name . ' account updated successfully');

        return redirect('/account/' . $account->id . '/edit')->with('error', $account->name . ' account update failed');
    }

    public function deleteAccount(Account $account)
    {

        if ($account->currentBalance > 0) {
            return back()->with('error', $account->name . ' already has transaction');
        }

        $accountName = $account->name;

        $deleted = $account->delete();

        if ($deleted) return redirect('/account/all')->with('success', $accountName . ' account deleted successfully');

        return redirect('/account/all')->with('error', "Can't delete account");
    }
}
