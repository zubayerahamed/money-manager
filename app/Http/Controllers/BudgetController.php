<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    
    public function showCreateBudgetPage(ExpenseType $expenseType){
        return view('budget-create', [
            'expenseType' => $expenseType
        ]);
    }

    public function createBudget(Request $request){
        $incomingFields = $request->validate([
            'expense_type' => 'required',
            'amount' => ['required', 'min:0']
        ]);

        $incomingFields['user_id'] = auth()->user()->id;
        $incomingFields['month'] = date('m');
        $incomingFields['year'] = date('Y');

        $budget = Budget::create($incomingFields);
        if(!$budget){
            return redirect('/expense-type/all')->with('error', "Can't create budget");    
        }

        return redirect('/expense-type/all')->with('success', 'Budget added successfully');
    }

    public function showUpdateBudgetPage(Budget $budget){
        return view('budget-update', [
            'budget' => $budget
        ]);
    }

    public function updateBudget(Budget $budget, Request $request){

        $incomingFields = $request->validate([
            'expense_type' => 'required',
            'amount' => ['required', 'min:0']
        ]);

        $budget->amount = $incomingFields['amount'];
        $updateStatus = $budget->update();

        if($updateStatus){
            return back()->with('success', 'Budget updated successfully');
        }

        return back()->with('error', 'Budget limit update failed');
    }

}
