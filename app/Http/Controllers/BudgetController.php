<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    
    public function monthlyBudgetList($month, $year){
        $expenseTypes = ExpenseType::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        $totalBudget = 0;
        $totalSpent = 0;

        foreach($expenseTypes as $expenseType){
            $budget = $this->getBudget($expenseType, $year, $month);
            $expenseType['budget_id'] = $budget != null ? $budget->id : 0;
            $expenseType['budget'] = $budget != null ? $budget->amount : 0;
            $totalBudget = $totalBudget + $expenseType['budget'];
            $expenseType['spent'] = $this->getMonthlyExpenseAmount($expenseType, $year, $month);
            $totalSpent = $totalSpent + $expenseType['spent'];
            $expenseType['remaining'] = $expenseType['budget'] - $expenseType['spent'] > 0 ? $expenseType['budget'] - $expenseType['spent'] : 0;
            $expenseType['percent'] = 100;
            $expenseType['exced_amount'] = $expenseType['spent'] - $expenseType['budget'];
            if($expenseType['remaining'] > 0){
                $expenseType['percent'] = round((100 * $expenseType['spent']) / $expenseType['budget'], 2);
            }
        }

        return view('budgets', [
            'expenseTypes' => $expenseTypes,
            'month' => $month,
            'monthText' => date("F", mktime(0, 0, 0, $month, 10)),
            'year' => $year,
            'totalBudget' => $totalBudget,
            'totalSpent' => $totalSpent
        ]);
    }

    private function getMonthlyExpenseAmount($expenseType, $year, $month){
        $amount = DB::table('tracking_history')
                        ->selectRaw("SUM(amount) as amount")
                        ->where('expense_type', '=', $expenseType->id)
                        ->where('user_id', '=', auth()->user()->id)
                        ->where('transaction_type', '=', 'EXPENSE')
                        ->where('year', '=', $year)
                        ->where('month', '=', $month)
                        ->get();
        return $amount[0]->amount == null ? 0 : $amount[0]->amount;
    }

    private function getBudget($expenseType, $year, $month){
        $budget = DB::table('budgets')
            ->selectRaw("*")
            ->where('expense_type', '=', $expenseType->id)
            ->where('user_id', '=', auth()->user()->id)
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->first();

        return $budget;
    }

    public function showCreateBudgetPage(ExpenseType $expenseType, $month, $year){
        return view('budget-create', [
            'expenseType' => $expenseType,
            'month' => $month,
            'monthText' => date("F", mktime(0, 0, 0, $month, 10)),
            'year' => $year
        ]);
    }

    public function createBudget(Request $request){
        $incomingFields = $request->validate([
            'expense_type' => 'required',
            'amount' => ['required', 'min:0'],
            'month' => ['required'],
            'year' => ['required']
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $budget = Budget::create($incomingFields);
        if(!$budget){
            return back()->with('error', "Can't create budget");    
        }

        return back()->with('success', 'Budget added successfully');
    }

    public function showUpdateBudgetPage(Budget $budget){
        return view('budget-update', [
            'budget' => $budget,
            'month' => $budget->month,
            'monthText' => date("F", mktime(0, 0, 0, $budget->month, 10)),
            'year' => $budget->year
        ]);
    }

    public function updateBudget(Budget $budget, Request $request){

        $incomingFields = $request->validate([
            'expense_type' => 'required',
            'amount' => ['required', 'min:0']
        ]);

        if($incomingFields['amount'] <= 0){
            return back()->with('error', "Budget can't be zero");
        }

        $budget->amount = $incomingFields['amount'];
        $updateStatus = $budget->update();

        if($updateStatus){
            return back()->with('success', 'Budget updated successfully');
        }

        return back()->with('error', 'Budget limit update failed');
    }

}
