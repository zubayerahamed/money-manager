<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\ExpenseType;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    use HttpResponses;

    /**
     * Page Sections loader
     *
     * @param Request $requset
     * @return void
     */
    public function reloadPageSections(Request $requset){
        return $this->reloadSectionsOnly(
            [
                ['budgets-accordion', $requset->get('definedRoute')],
            ]
        );
    }

    /**
     * Dislay the budget status page
     *
     * @return Renderable
     */
    public function index($month, $year, Request $request)
    {
        $expenseTypes = ExpenseType::orderBy('name', 'asc')->get();

        $totalBudget = 0;
        $totalSpent = 0;

        foreach ($expenseTypes as $expenseType) {
            $budget = $this->getBudget($expenseType, $year, $month);
            $expenseType['budget_id'] = $budget != null ? $budget->id : 0;
            $expenseType['budget'] = $budget != null ? $budget->amount : 0;
            $totalBudget = $totalBudget + $expenseType['budget'];
            $expenseType['spent'] = $this->getMonthlyExpenseAmount($expenseType, $year, $month);
            $totalSpent = $totalSpent + $expenseType['spent'];
            $expenseType['remaining'] = $expenseType['budget'] - $expenseType['spent'] > 0 ? $expenseType['budget'] - $expenseType['spent'] : 0;
            $expenseType['percent'] = 100;
            $expenseType['exced_amount'] = $expenseType['spent'] - $expenseType['budget'];
            if ($expenseType['remaining'] > 0) {
                $expenseType['percent'] = round((100 * $expenseType['spent']) / $expenseType['budget'], 2);
            }
        }

        if ($request->ajax()) {
            return view('layouts.budgets.budgets-accordion', [
                'expenseTypes' => $expenseTypes,
                'month' => $month,
                'monthText' => date("F", mktime(0, 0, 0, $month, 10)),
                'year' => $year,
                'totalBudget' => $totalBudget,
                'totalSpent' => $totalSpent
            ]);
        }

        $sectionReloadRoute = $request->route()->getName();

        return view('budgets', [
            'expenseTypes' => $expenseTypes,
            'month' => $month,
            'monthText' => date("F", mktime(0, 0, 0, $month, 10)),
            'year' => $year,
            'totalBudget' => $totalBudget,
            'totalSpent' => $totalSpent,
            'sectionReloadRoute' => route($sectionReloadRoute, [
                'month' => $month,
                'year' => $year
            ]),
        ]);
    }

    /**
     * Get Monthly expense amount
     *
     * @param ExpenseType $expenseType
     * @param int $year
     * @param int $month
     * @return int
     */
    private function getMonthlyExpenseAmount($expenseType, $year, $month)
    {
        $amount = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as amount")
            ->where('expense_type', '=', $expenseType->id)
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->get();

        return $amount->isEmpty() ? 0 : $amount->get(0)->amount;
    }

    /**
     * Get Budget Object
     *
     * @param ExpenseType $expenseType
     * @param int $year
     * @param int $month
     * @return Budget|null
     */
    private function getBudget($expenseType, $year, $month)
    {
        $budgets = Budget::where('expense_type', '=', $expenseType->id)
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->get();

        return $budgets->isEmpty() ? null : $budgets->get(0);
    }

    /**
     * Open budget create form in modal
     *
     * @return Renderable
     */
    public function create(ExpenseType $expenseType, $month, $year)
    {
        return view('layouts.budgets.budget-form', [
            'expenseType' => $expenseType,
            'budget' => new Budget(),
            'month' => $month,
            'monthText' => date("F", mktime(0, 0, 0, $month, 10)),
            'year' => $year
        ]);
    }

    /**
     * Store new budget in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_type' => 'required',
            'amount' => ['required', 'numeric', 'gt:0'],
            'month' => ['required'],
            'year' => ['required']
        ]);

        $budget = Budget::create($request->only([
            'amount',
            'expense_type',
            'note',
            'user_id',
            'month',
            'year'
        ]));

        if (!$budget) {
            return $this->error(null, __('common.process.error'));
        }

        return $this->successWithReloadSections(null, __('budget.save.success'), 200, [
            ['budgets-accordion', route('budget.index', [$request->get('month'), $request->get('year')])]
        ]);
    }

    /**
     * Open budget edit form in modal
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $budget = Budget::where('id', '=', $id)->get();
        if ($budget->isEmpty()) return $this->error(null, __('budget.not.found'), 400);

        $budget = $budget->get(0);

        return view('layouts.budgets.budget-form', [
            'budget' => $budget,
            'month' => $budget->month,
            'monthText' => date("F", mktime(0, 0, 0, $budget->month, 10)),
            'year' => $budget->year
        ]);
    }

    /**
     * Update existing budget in storage
     *
     * @param int $id
     * @param Request $requset
     * @return Renderable
     */
    public function update($id, Request $request)
    {
        $budget = Budget::where('id', '=', $id)->get();
        if ($budget->isEmpty()) return $this->error(null, __('budget.not.found'), 400);

        $budget = $budget->get(0);

        $request->validate([
            'expense_type' => 'required',
            'amount' => ['required', 'numeric', 'gt:0']
        ]);

        $updateStatus = $budget->update($request->only([
            'amount'
        ]));

        if ($updateStatus) {
            return $this->successWithReloadSections(null, __('budget.update.success'), 200, [
                ['budgets-accordion', route('budget.index', [$budget->month, $budget->year])]
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
        $budget = Budget::where('id', '=', $id)->get();
        if ($budget->isEmpty()) return $this->error(null, __('budget.not.found'), 400);

        $budget = $budget->get(0);

        $deleted = $budget->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, __('budget.delete.success'), 200, [
                ['budgets-accordion', route('budget.index', [$budget->month, $budget->year])]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }
}
