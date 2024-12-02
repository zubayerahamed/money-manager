<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\SubExpenseType;
use App\Models\TransactionHistoryDetail;
use App\Rules\IsCompositeUnique;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SubExpenseTypeController extends Controller
{
    use HttpResponses;

    private  $section_accordion;

    public function __construct()
    {
        $this->section_accordion = ['expense-types-accordion', route('expense-type.section.accordion')];
    }

    public function sectionSubexpensesList($tracking_history_id, $expense_type_id)
    {
        $subExpenseTypes = SubExpenseType::where('expense_type_id', '=', $expense_type_id)->get();
        foreach ($subExpenseTypes as $se) {
            $detail = TransactionHistoryDetail::where('sub_expense_type_id', '=', $se->id)->where('tracking_history_id', '=', $tracking_history_id)->first();
            if ($detail != null) {
                $se->amount = $detail->amount;
            } else {
                $se->amount = 0;
            }
        }

        $subExpenseTypes = $subExpenseTypes->sortByDesc('active');

        if($tracking_history_id == 0){
            $subExpenseTypes = $subExpenseTypes->reject(function ($item) {
                return !$item->active;
            });
        }

        return view('layouts.sub-expense-types.sub-expense-list', [
            'subExpenseTypes' => $subExpenseTypes,
        ]);
    }

    public function create($expense_type_id)
    {
        $subExpenseType = new SubExpenseType();
        $subExpenseType->active = true;
        $subExpenseType->expense_type_id = $expense_type_id;

        return view('layouts.sub-expense-types.sub-expense-type-form', [
            'subExpenseType' => $subExpenseType,
        ]);
    }

    public function store(Request $requset, $expense_type_id)
    {
        $requset->validate([
            'name' => ['required', new IsCompositeUnique('sub_expense_types', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id, 'expense_type_id' => $expense_type_id], "Sub Expense Type should be unique.")],
        ]);

        $requset['active'] = $requset->has('active') ? true : false;

        $subExpenseType = SubExpenseType::create(array_merge(
            $requset->only(['name', 'user_id', 'active']),
            ['expense_type_id' => $expense_type_id]
        ));

        if ($subExpenseType) {
            return $this->successWithReloadSections(null, "Sub Expense Type created successfully", 200, [
                ['sub-expense-type-wrapper-' . $expense_type_id, route('sub-expense-type.section.accordion', ['expense_type_id' => $expense_type_id])]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    public function edit($expense_type_id, $id)
    {

        $subExpenseType = SubExpenseType::where('id', '=', $id)->first();
        if ($subExpenseType == null) return $this->error(null, "Sub Expense Type not found", 400);

        return view('layouts.sub-expense-types.sub-expense-type-form', [
            'subExpenseType' => $subExpenseType,
        ]);
    }

    public function update(Request $requset, $expense_type_id, $id)
    {
        $exist = SubExpenseType::where('id', '=', $id)->first();
        if ($exist == null) return $this->error(null, "Sub Expense Type not found", 400);

        $requset->validate([
            'name' => ['required', new IsCompositeUnique('sub_expense_types', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id, 'expense_type_id' => $expense_type_id], "Sub Expense Type should be unique.", $id)],
        ]);

        $requset['active'] = $requset->has('active') ? true : false;

        $updated = $exist->update(array_merge(
            $requset->only(['name', 'user_id', 'active']),
            ['expense_type_id' => $expense_type_id]
        ));

        if ($updated) {
            return $this->successWithReloadSections(null, "Sub Expense Type updated successfully", 200, [
                ['sub-expense-type-wrapper-' . $expense_type_id, route('sub-expense-type.section.accordion', ['expense_type_id' => $expense_type_id])]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    public function destroy($expense_type_id, $id)
    {
        $exist = SubExpenseType::where('id', '=', $id)->first();
        if ($exist == null) return $this->error(null, "Sub Expense Type not found", 400);


        $deleted = $exist->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, "Sub Expense Type updated successfully", 200, [
                ['sub-expense-type-wrapper-' . $expense_type_id, route('sub-expense-type.section.accordion', ['expense_type_id' => $expense_type_id])]
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    public function accordion($expense_type_id)
    {
        $expenseType = ExpenseType::with('subExpenseTypes')->where('id', '=', $expense_type_id)->first();
        if ($expenseType == null) return $this->error(null, __('expense-type.not.found'), 400);

        return view('layouts.sub-expense-types.sub-expense-types-accordion', [
            'expenseType' => $expenseType,
        ]);
    }

    public function showMonthlyGroupedTransactions($sub_expense_type_id)
    {

        $amountKey = 'expense';
        $altAmountKey = 'income';

        $allTransactions = TransactionHistoryDetail::with('subExpenseType')->where('sub_expense_type_id', '=', $sub_expense_type_id)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $monthWiseGroup = [];

        $currentTransactionMonth = "";
        foreach ($allTransactions->all() as $trn) {
            $month_name = date("F", mktime(0, 0, 0, $trn->month, 10)) . ', ' . $trn->year;

            if($currentTransactionMonth == "" || $currentTransactionMonth != $month_name){
                $currentTransactionMonth = $month_name;
                $amount = $trn->amount;
                $monthWiseGroup = array_push_assoc($monthWiseGroup, $month_name, ['data' => [$trn], $amountKey => $amount, $altAmountKey => '']);
            } else {
                $monthArr = $monthWiseGroup[$month_name];
                $trnDataArr = $monthArr['data'];
                $newAmount = $monthArr[$amountKey] + $trn->amount;
                array_push($trnDataArr, $trn);
                $monthArr = array_push_assoc($monthArr, 'data', $trnDataArr);
                $monthArr = array_push_assoc($monthArr, $amountKey, $newAmount);
                $monthWiseGroup = array_push_assoc($monthWiseGroup, $month_name, $monthArr);
            }
        }

        // dd($monthWiseGroup);
        return view('layouts.sub-expense-types.transaction-detail-accordion', [
            'thDetails' => $monthWiseGroup,
        ]);
    }
}
