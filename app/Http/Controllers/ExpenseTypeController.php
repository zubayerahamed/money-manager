<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExpenseTypeController extends Controller
{

    public function expenseTypeStatusPieChart(){

        return DB::table('tracking_history')
                ->leftjoin('expense_type','expense_type.id','=','tracking_history.expense_type')                       
                ->selectRaw("expense_type.name, SUM(tracking_history.amount) as value")
                ->where('tracking_history.user_id', '=', auth()->user()->id)
                ->where('tracking_history.transaction_type', '=', 'EXPENSE')
                ->groupBy('tracking_history.expense_type')
                ->groupBy('expense_type.name')
                ->get();

    }

    public function expenseTypes(){

        $expenseTypes = ExpenseType::all()->sortDesc();

        $totalExpense = DB::table('tracking_history')
                                ->selectRaw("SUM(amount) as totalExpense")
                                ->where('user_id', '=', auth()->user()->id)
                                ->where('transaction_type', '=', 'EXPENSE')
                                ->get();

        return view('expense-types', [
            'expenseTypes' => $expenseTypes,
            'totalExpense' => $totalExpense[0]->totalExpense == null? 0 : $totalExpense[0]->totalExpense
        ]);
    }

    public function showCreateExpenseTypePage(){
        return view('expense-type-create');
    }

    public function showUpdateExpenseTypePage(ExpenseType $expenseType){
        return view('expense-type-update', ['expenseType' => $expenseType]);
    }

    public function createExpenseType(Request $requset){

        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('expense_type')],
            'icon' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $expenseType = ExpenseType::create($incomingFields);

        if($expenseType) return redirect('/expense-type/' . $expenseType->id . '/edit')->with('success', $expenseType->name . ' expense type created successfully');

        return redirect('/expense-type')->with('error', "Can't create expense type");
    }

    public function updateExpenseType(ExpenseType $expenseType, Request $requset){

        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('expense_type')->ignore($expenseType->id)],
            'icon' => 'required'
        ]);

        $uExpenseType = $expenseType->update($incomingFields);

        if($uExpenseType) return redirect('/expense-type/' . $expenseType->id . '/edit')->with('success', $expenseType->name . ' expense type updated successfully');

        return redirect('/expense-type/' . $expenseType->id . '/edit')->with('error', $expenseType->name . ' expense type update failed');
    }

    public function deleteExpenseType(ExpenseType $expenseType){
        $expenseTypeName = $expenseType->name;
        $deleted = $expenseType->delete();

        if($deleted) return redirect('/expense-type/all')->with('success', $expenseTypeName . ' expense type deleted successfully');

        return redirect('/expense-type/all')->with('error', "Can't delete expense type");
    }
}
