<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Rules\IsCompositeUnique;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseTypeController extends Controller
{

    use HttpResponses;

    private  $section_accordion, $section_piechart, $section_header;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->section_accordion = ['expense-types-accordion', route('expense-type.section.accordion')];
        $this->section_piechart = ['expense-types-pie-chart', route('expense-type.section.piechart')];
        $this->section_header = ['expense-types-header', route('expense-type.section.header')];
    }

    /**
     * Page Sections loader
     *
     * @param Request $requset
     * @return void
     */
    public function reloadPageSections(Request $requset)
    {
        return $this->reloadSectionsOnly(
            [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart
            ]
        );
    }

    /**
     * Get expense type status pie chart data
     * 
     * @return Renderable
     */
    public function expenseTypeStatusPieChart()
    {

        return DB::table('tracking_history')
            ->leftjoin('expense_type', 'expense_type.id', '=', 'tracking_history.expense_type')
            ->selectRaw("expense_type.name, SUM(tracking_history.amount) as value")
            ->where('tracking_history.user_id', '=', auth()->id())
            ->where('tracking_history.transaction_type', '=', 'EXPENSE')
            ->groupBy('tracking_history.expense_type')
            ->groupBy('expense_type.name')
            ->get();
    }

    /**
     * Dislay the expense type status page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $expenseTypes = ExpenseType::with('subExpenseTypes')->orderBy('name', 'asc')->get();

        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'EXPENSE')
            ->get();

        return view('expense-types', [
            'expenseTypes' => $expenseTypes,
            'totalExpense' => $totalExpense->isEmpty() ? 0 : $totalExpense->get(0)->totalExpense,
        ]);
    }

    public function getExpenseChartDataBySubExpenseType($id) {

        $transactionHistoryDetailOfExpense = DB::table('transaction_history_details')
            ->selectRaw("SUM(amount) as amount, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('year', '=', date('Y'))
            ->where('sub_expense_type_id', '=', $id)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $data = [];

        // Max current month
        $currentMonth = date('n');
        for ($i = 0; $i < $currentMonth; $i++) {
            $data[$i] = [
                'month' => $i + 1,
                'amount' => 0,
            ];
        }

        foreach ($transactionHistoryDetailOfExpense as $history) {
            $data[$history->month - 1]['amount'] = $history->amount;
        }

        return $data;
    }

    public function getExpenseTypeChartData($id) {
        
        $trackingHistoriesOfExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as amount, SUM(transaction_charge) as charge, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('year', '=', date('Y'))
            ->where('expense_type', '=', $id)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = [];

        // Max current month
        $currentMonth = date('n');
        for ($i = 0; $i < $currentMonth; $i++) {
            $data[$i] = [
                'month' => $i + 1,
                'amount' => 0,
            ];
        }

        foreach ($trackingHistoriesOfExpense as $history) {
            $data[$history->month - 1]['amount'] = $history->amount;
        }

        return $data;
    }

    /**
     * Open income source create form in modal
     *
     * @return Renderable
     */
    public function create(Request $request)
    {
        $expenseType = new ExpenseType();
        $expenseType->active = true;

        return view('layouts.expense-types.expense-type-form', [
            'expenseType' => $expenseType,
            'fromtransaction' => $request->get('fromtransaction'),
            'trnId' => $request->get('trnid'),
        ]);
    }

    /**
     * Store new expense type in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function store(Request $requset)
    {
        $requset->validate([
            'name' => ['required', new IsCompositeUnique('expense_type', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id], __('expense-type.name.unique'))],
            'icon' => 'required'
        ]);

        $requset['active'] = $requset->has('active') ? true : false;

        $expenseType = ExpenseType::create($requset->only([
            'name',
            'icon',
            'note',
            'user_id',
            'active'
        ]));

        if ($requset->get('fromtransaction')) {
            // For transaction edit screen
            if ($requset->get('trnId') != null && $requset->get('trnId') != '') {
                $route = route("tracking.edit", [$requset->get('trnId')]);
                $modalTitle = "Edit transaction";

                return $this->successWithReloadSectionsInModal(
                    null,
                    __('expense-type.save.success', ['name' => $expenseType->name]),
                    200,
                    $modalTitle,
                    $route
                );
            }

            // For new transaction screen
            $route = route("do-transfer");
            $modalTitle = "Do Transfer";
            if ($requset->get('fromtransaction') == 'INCOME') {
                $route = route('add-income');
                $modalTitle = "Add Income";
            }
            if ($requset->get('fromtransaction') == 'EXPENSE') {
                $route = route('add-expense');
                $modalTitle = "Add Expense";
            }

            return $this->successWithReloadSectionsInModal(
                null,
                __('expense-type.save.success', ['name' => $expenseType->name]),
                200,
                $modalTitle,
                $route
            );
        }

        if ($expenseType) {
            return $this->successWithReloadSections(null, __('expense-type.save.success', ['name' => $expenseType->name]), 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Open income source edit form in modal
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $expenseTypes = ExpenseType::where('id', '=', $id)->get();
        if ($expenseTypes->isEmpty()) return $this->error(null, __('expense-type.not.found'), 400);

        return view('layouts.expense-types.expense-type-form', [
            'expenseType' => $expenseTypes->first(),
            'fromtransaction' => request()->get('fromtransaction'),
            'trnId' => request()->get('trnid'),
        ]);
    }

    /**
     * Update existing expense type in storage
     *
     * @param int $id
     * @param Request $requset
     * @return Renderable
     */
    public function update($id, Request $requset)
    {
        $expenseTypes = ExpenseType::where('id', '=', $id)->get();
        if ($expenseTypes->isEmpty()) return $this->error(null, __('expense-type.not.found'), 400);

        $expenseType = $expenseTypes->get(0);

        $requset->validate([
            'name' => ['required', new IsCompositeUnique('expense_type', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id], __('expense-type.name.unique'), $expenseType->id)],
            'icon' => 'required'
        ]);

        $requset['active'] = $requset->has('active') ? true : false;

        $updated = $expenseType->update($requset->only([
            'name',
            'icon',
            'note',
            'user_id',
            'active'
        ]));

        if ($updated) {
            return $this->successWithReloadSections(null, __('expense-type.update.success', ['name' => $expenseType->name]), 200, [
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
        $expenseTypes = ExpenseType::where('id', '=', $id)->get();
        if ($expenseTypes->isEmpty()) return $this->error(null, __('expense-type.not.found'), 400);

        $expenseType = $expenseTypes->get(0);

        if ($expenseType->trackingHistory()->count() > 0) {
            return $this->error(null, __('income-source.has.transaction', ['name' => $expenseType->name]));
        }

        $expenseTypeName = $expenseType->name;
        $deleted = $expenseType->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, __('income-source.delete.success', ['name' => $expenseTypeName]), 200, [
                $this->section_accordion,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Expense type page piechart section
     *
     * @return Renderable
     */
    public function piechart()
    {
        return view('layouts.expense-types.expense-types-pie-chart');
    }

    /**
     * Expense type page header section
     *
     * @return Renderable
     */
    public function header()
    {
        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'EXPENSE')
            ->get();

        return view('layouts.expense-types.expense-types-header', [
            'totalExpense' => $totalExpense->isEmpty() ? 0 : $totalExpense->get(0)->totalExpense
        ]);
    }

    /**
     * Expense type page accordion section
     *
     * @return Renderable
     */
    public function accordion()
    {
        $expenseTypes = ExpenseType::orderBy('name', 'asc')->get();

        return view('layouts.expense-types.expense-types-accordion', [
            'expenseTypes' => $expenseTypes
        ]);
    }
}
