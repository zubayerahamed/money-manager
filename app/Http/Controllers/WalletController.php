<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{

    use HttpResponses;

    private $section_accordion = ['wallets-accordion', route('wallet.section.accordion')];
    private$section_piechart = ['wallets-pie-chart', route('wallet.section.piechart')];
    private $section_header = ['wallets-header', route('wallet.section.header')];

    public function walletStatusPieChart()
    {
        return DB::table('arhead')
            ->leftjoin('wallet', 'wallet.id', '=', 'arhead.wallet_id')
            ->selectRaw("wallet.name, SUM(arhead.amount * arhead.row_sign)-SUM(arhead.transaction_charge) as value")
            ->where('arhead.user_id', '=', auth()->user()->id)
            ->groupBy('arhead.wallet_id')
            ->groupBy('wallet.name')
            ->get();
    }

    public function index()
    {
        $wallets = Wallet::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        $totalBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalance")
            ->where('user_id', '=', auth()->user()->id)
            ->get();

        return view('wallets', [
            'wallets' => $wallets,
            'totalBalance' => $totalBalance[0]->totalBalance == null ? 0 : $totalBalance[0]->totalBalance
        ]);
    }

    public function create()
    {
        return view('layouts.wallets.wallet-form', ['wallet' => new Wallet()]);
    }

    public function edit($id)
    {
        $wallets = Wallet::where('id', '=', $id)->where('user_id', '=', auth()->user()->id)->get();
        return view('layouts.wallets.wallet-form', ['wallet' => $wallets->first()]);
    }

    public function store(Request $requset)
    {
        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('wallet')],
            'icon' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $wallet = Wallet::create($incomingFields);

        if ($wallet && $requset->get('current_balance') != 0) {
            // Add to tracking 
            $trackingFields['transaction_type'] = 'OPENING';
            $trackingFields['amount'] = $requset->get('current_balance');
            $trackingFields['transaction_charge'] = 0;
            $trackingFields['to_wallet'] = $wallet->id;
            $trackingFields['transaction_date'] = date('Y-m-d');
            $trackingFields['transaction_time'] = date('H:i');
            $trackingFields['user_id'] = auth()->user()->id;
            $trackingFields['month'] = date('m');
            $trackingFields['year'] = date('Y');

            $trackingHistory = TrackingHistory::create($trackingFields);

            // Add to arhead
            if ($trackingHistory) {
                $arhead['tracking_history_id'] = $trackingHistory->id;
                $arhead['user_id'] = auth()->user()->id;
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;

                $savedArhead = Arhead::create($arhead);
            }
        }

        if ($wallet) {
            return $this->successWithReloadSections(null, $wallet->name . ' wallet created successfully', 200, [
                ['wallets-accordion', route('wallet.index')],
                ['wallets-pie-chart', route('wallet.section.piechart')],
                ['wallets-header', route('wallet.header')]
            ]);
        }

        return $this->error(null, "Something went wrong, please try again later.", 200);
    }

    public function piechart()
    {
        return view('layouts.wallets.wallets-pie-chart');
    }

    public function header()
    {
        $totalBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalance")
            ->where('user_id', '=', auth()->user()->id)
            ->get();

        return view('layouts.wallets.wallets-header', [
            'totalBalance' => $totalBalance[0]->totalBalance == null ? 0 : $totalBalance[0]->totalBalance,
        ]);
    }

    public function accordion()
    {
        $wallets = Wallet::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        if (request()->ajax()) {
            return view('layouts.wallets.wallets-accordion', [
                'wallets' => $wallets
            ]);
        }
    }

    public function update(Wallet $wallet, Request $requset)
    {
        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('wallet')->ignore($wallet->id)],
            'icon' => 'required'
        ]);

        $uWallet = $wallet->update($requset->all());

        if ($uWallet) {
            return $this->successWithReloadSections(null, $wallet->name . ' wallet updated successfully', 200, [
                ['wallets-accordion', route('wallet.index')],
                ['wallets-pie-chart', route('wallet.piechart')],
                ['wallets-header', route('wallet.header')]
            ]);
        }

        return $this->error(null, $wallet->name . ' wallet update failed', 200);
    }

    public function destroy(Wallet $wallet)
    {
        $incomeCount =  DB::table('tracking_history')
            ->selectRaw("count(*)")
            ->where('user_id', '=', auth()->user()->id)
            ->where('to_wallet', '=', $wallet->id)
            ->where(function ($query) {
                $query->where('transaction_type', '=', 'INCOME')
                    ->orWhere('transaction_type', '=', 'TRANSFER');
            })
            ->count();

        $expenseCount =  DB::table('tracking_history')
            ->selectRaw("count(*)")
            ->where('user_id', '=', auth()->user()->id)
            ->where('from_wallet', '=', $wallet->id)
            ->where(function ($query) {
                $query->where('transaction_type', '=', 'EXPENSE')
                    ->orWhere('transaction_type', '=', 'TRANSFER');
            })
            ->count();

        if ($incomeCount > 0 || $expenseCount > 0) {
            return $this->error(null, $wallet->name . ' already has transaction', 200);
        }

        $walletName = $wallet->name;
        $deleted = $wallet->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, $walletName . ' wallet deleted successfully', 200, [
                ['wallets-accordion', route('wallet.index')]
            ]);
        }

        return $this->error(null, 'Something went wrong, please try again later', 200);
    }
}
