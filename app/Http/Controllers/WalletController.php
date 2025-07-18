<?php

namespace App\Http\Controllers;

use App\Models\Arhead;
use App\Models\TrackingHistory;
use App\Models\Wallet;
use App\Rules\IsCompositeUnique;
use App\Traits\HttpResponses;
use DebugBar\DataCollector\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    use HttpResponses;

    private  $section_accordion, $section_piechart, $section_header;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->section_accordion = ['wallets-accordion', route('wallet.section.accordion')];
        $this->section_piechart = ['wallets-pie-chart', route('wallet.section.piechart')];
        $this->section_header = ['wallets-header', route('wallet.section.header')];
    }

    /**
     * Page Sections loader
     *
     * @param Request $requset
     * @return void
     */
    public function reloadPageSections(Request $requset){
        return $this->reloadSectionsOnly(
            [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart
            ]
        );
    }

    /**
     * Get wallet status pie chart data
     * 
     * @return Renderable
     */
    public function walletStatusPieChart()
    {
        return DB::table('arhead')
            ->leftjoin('wallet', 'wallet.id', '=', 'arhead.wallet_id')
            ->selectRaw("wallet.name, SUM(arhead.amount * arhead.row_sign)-SUM(arhead.transaction_charge) as value")
            ->where('arhead.user_id', '=', auth()->id())
            ->groupBy('arhead.wallet_id')
            ->groupBy('wallet.name')
            ->get();
    }

    /**
     * Dislay the wallet status page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $wallets = Wallet::orderBy('name', 'asc')->get();

        $totalBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalance")
            ->where('user_id', '=', auth()->id())
            ->where('excluded', '=', 0)
            ->get();
        
        $totalBalanceEx = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalanceEx")
            ->where('user_id', '=', auth()->id())
            ->where('excluded', '=', 1)
            ->get();

        return view('wallets', [
            'wallets' => $wallets,
            'totalBalance' => $totalBalance->isEmpty() ? 0 : $totalBalance->get(0)->totalBalance,
            'totalBalanceEx' => $totalBalanceEx->isEmpty() ? 0 : $totalBalanceEx->get(0)->totalBalanceEx,
        ]);
    }

    /**
     * Open wallet create form in modal
     *
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('layouts.wallets.wallet-form', [
            'wallet' => new Wallet(),
            'fromtransaction' => $request->get('fromtransaction'),
            'trnId' => $request->get('trnid'),
        ]);
    }

    /**
     * Store new wallet in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function store(Request $requset)
    {
        $requset->validate([
            'name' => ['required', new IsCompositeUnique('wallet', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id], __('wallet.name.unique'))],
            'icon' => 'required',
            'current_balance' => ['required', 'numeric', 'min:0']
        ]);

        $requset['excluded'] = $requset->has('excluded');

        $wallet = Wallet::create($requset->only([
            'name', 'icon', 'note', 'user_id', 'excluded'
        ]));

        if ($wallet->exists && $requset->get('current_balance') != 0) {
            // Create tracking 
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

            // Create arhead
            if ($trackingHistory) {
                $arhead['tracking_history_id'] = $trackingHistory->id;
                $arhead['user_id'] = auth()->user()->id;
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = 1;
                $arhead['xdate'] = date('Y-m-d');
                $arhead['xtime'] = date('H:i');
                $arhead['excluded'] = $wallet->excluded;

                Arhead::create($arhead);
            }
        }

        if($requset->get('fromtransaction')){

            // For transaction edit screen
            if($requset->get('trnId') != null && $requset->get('trnId') != ''){
                $route = route("tracking.edit", [$requset->get('trnId')]);
                $modalTitle = "Edit transaction";
    
                return $this->successWithReloadSectionsInModal(
                    null,
                    __('wallet.save.success', ['name' => $wallet->name]),
                    200,
                    $modalTitle,
                    $route
                );
            }

            // For new transaction screen
            $route = route("do-transfer");
            $modalTitle = "Do Transfer";
            if($requset->get('fromtransaction') == 'INCOME') {
                $route = route('add-income');
                $modalTitle = "Add Income";
            }
            if($requset->get('fromtransaction') == 'EXPENSE') {
                $route = route('add-expense');
                $modalTitle = "Add Expense";
            }
            if($requset->get('fromtransaction') == 'LOAN') {
                $route = route('get-loan');
                $modalTitle = "Get Loan";
            }

            return $this->successWithReloadSectionsInModal(
                null,
                __('wallet.save.success', ['name' => $wallet->name]),
                200,
                $modalTitle,
                $route
            );
        }

        if ($wallet->exists) {
            return $this->successWithReloadSections(
                null,
                __('wallet.save.success', ['name' => $wallet->name]),
                200,
                [
                    $this->section_accordion,
                    $this->section_header,
                    $this->section_piechart
                ]
            );
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Open wallet edit form in modal
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $wallets = Wallet::where('id', '=', $id)->get();
        if ($wallets->isEmpty()) return $this->error(null, __('wallet.not.found'), 400);

        return view('layouts.wallets.wallet-form', [
            'wallet' => $wallets->first(),
            'fromtransaction' => request()->get('fromtransaction'),
            'trnId' => request()->get('trnid'),
        ]);
    }

    /**
     * Update existing wallet in storage
     *
     * @param int $id
     * @param Request $requset
     * @return Renderable
     */
    public function update($id, Request $requset)
    {
        $wallets = Wallet::where('id', '=', $id)->get();
        if ($wallets->isEmpty()) return $this->error(null, __('wallet.not.found'), 400);

        $wallet = $wallets->get(0);

        $requset->validate([
            'name' => ['required', new IsCompositeUnique('wallet', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id], __('wallet.name.unique'), $wallet->id)],
            'icon' => 'required'
        ]);

        $requset['excluded'] = $requset->has('excluded');

        $updated = $wallet->update($requset->only([
            'name', 'icon', 'note', 'user_id', 'excluded'
        ]));

        if ($updated) {
            return $this->successWithReloadSections(null, __('wallet.update.success', ['name' => $wallet->name]), 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $wallets = Wallet::where('id', '=', $id)->get();
        if ($wallets->isEmpty()) return $this->error(null, __('wallet.not.found'), 400);

        $wallet = $wallets->get(0);

        $incomeCount =  DB::table('tracking_history')
            ->selectRaw("count(*)")
            ->where('user_id', '=', auth()->id())
            ->where('to_wallet', '=', $wallet->id)
            ->where(function ($query) {
                $query->where('transaction_type', '=', 'INCOME')
                    ->orWhere('transaction_type', '=', 'TRANSFER');
            })
            ->count();

        if ($incomeCount > 0) {
            return $this->error(null, __('wallet.has.transaction', ['name' => $wallet->name]));
        }

        $expenseCount =  DB::table('tracking_history')
            ->selectRaw("count(*)")
            ->where('user_id', '=', auth()->id())
            ->where('from_wallet', '=', $wallet->id)
            ->where(function ($query) {
                $query->where('transaction_type', '=', 'EXPENSE')
                    ->orWhere('transaction_type', '=', 'TRANSFER');
            })
            ->count();

        if ($expenseCount > 0) {
            return $this->error(null, __('wallet.has.transaction', ['name' => $wallet->name]));
        }

        $walletName = $wallet->name;
        $deleted = $wallet->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, __('wallet.delete.success', ['name' => $walletName]), 200, [
                $this->section_accordion,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Wallet page piechart section
     *
     * @return Renderable
     */
    public function piechart()
    {
        return view('layouts.wallets.wallets-pie-chart');
    }

    /**
     * Wallet page header section
     *
     * @return Renderable
     */
    public function header()
    {
        $totalBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalance")
            ->where('user_id', '=', auth()->id())
            ->where('excluded', '=', 0)
            ->get();
        
        $totalBalanceEx = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as totalBalanceEx")
            ->where('user_id', '=', auth()->id())
            ->where('excluded', '=', 1)
            ->get();

        return view('layouts.wallets.wallets-header', [
            'totalBalance' => $totalBalance->isEmpty() ? 0 : $totalBalance->get(0)->totalBalance,
            'totalBalanceEx' => $totalBalanceEx->isEmpty() ? 0 : $totalBalanceEx->get(0)->totalBalanceEx,
        ]);
    }

    /**
     * Wallet page accordion section
     *
     * @return Renderable
     */
    public function accordion()
    {
        $wallets = Wallet::orderBy('name', 'asc')->get();

        return view('layouts.wallets.wallets-accordion', [
            'wallets' => $wallets
        ]);
    }
}
