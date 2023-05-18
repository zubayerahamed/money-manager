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

    public function __construct()
    {
        $this->section_accordion = ['expense-types-accordion', route('expense-type.section.accordion')];
        $this->section_piechart = ['expense-types-pie-chart', route('expense-type.section.piechart')];
        $this->section_header = ['expense-types-header', route('expense-type.section.header')];
    }

    public function expenseTypeStatusPieChart()
    {

        return DB::table('tracking_history')
            ->leftjoin('expense_type', 'expense_type.id', '=', 'tracking_history.expense_type')
            ->selectRaw("expense_type.name, SUM(tracking_history.amount) as value")
            ->where('tracking_history.user_id', '=', auth()->user()->id)
            ->where('tracking_history.transaction_type', '=', 'EXPENSE')
            ->groupBy('tracking_history.expense_type')
            ->groupBy('expense_type.name')
            ->get();
    }

    public function index()
    {
        $expenseTypes = ExpenseType::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->get();

        return view('expense-types', [
            'expenseTypes' => $expenseTypes,
            'totalExpense' => $totalExpense[0]->totalExpense == null ? 0 : $totalExpense[0]->totalExpense,
        ]);
    }

    public function create()
    {
        return view('layouts.expense-types.expense-type-form', ['expenseType' => new ExpenseType()]);
    }

    public function edit($id)
    {
        $expenseTypes = ExpenseType::where('id', '=', $id)->where('user_id', '=', auth()->user()->id)->get();
        return view('layouts.expense-types.expense-type-form', ['expenseType' => $expenseTypes->first()]);
    }

    public function store(Request $requset)
    {

        $incomingFields = $requset->validate([
            'name' => ['required', new IsCompositeUnique('expense_type', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id], "Expense type name must be unique")],
            'icon' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $expenseType = ExpenseType::create($incomingFields);

        if ($expenseType) {
            return $this->successWithReloadSections(null, $expenseType->name . ' expense type created successfully', 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, "Something went wrong, please try again later.", 200);
    }

    public function piechart()
    {
        return view('layouts.expense-types.expense-types-pie-chart');
    }

    public function header()
    {
        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->get();

        return view('layouts.expense-types.expense-types-header', [
            'totalExpense' => $totalExpense[0]->totalExpense == null ? 0 : $totalExpense[0]->totalExpense
        ]);
    }

    public function accordion()
    {
        $expenseTypes = ExpenseType::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        return view('layouts.expense-types.expense-types-accordion', [
            'expenseTypes' => $expenseTypes
        ]);
    }

    public function update(ExpenseType $expenseType, Request $requset)
    {
        $incomingFields = $requset->validate([
            'name' => ['required', new IsCompositeUnique('expense_type', ['name' => $requset->get('name'), 'user_id' => auth()->user()->id], "Expense type name must be unique", $expenseType->id)],
            'icon' => 'required'
        ]);

        $updated = $expenseType->update($incomingFields);

        if ($updated) {
            return $this->successWithReloadSections(null, $expenseType->name . ' expense type updated successfully', 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, $expenseType->name . ' expense type update failed', 200);
    }

    public function destroy(ExpenseType $expenseType)
    {
        if ($expenseType->trackingHistory()->count() > 0) {
            return $this->error(null, $expenseType->name . ' already has transaction', 200);
        }

        $expenseTypeName = $expenseType->name;
        $deleted = $expenseType->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, $expenseTypeName . ' expense type deleted successfully', 200, [
                $this->section_accordion,
            ]);
        }

        return $this->error(null, 'Something went wrong, please try again later', 200);
    }
}
