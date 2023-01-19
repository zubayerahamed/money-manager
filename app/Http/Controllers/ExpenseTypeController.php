<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{

    public function expenseTypes(){

        $expenseTypes = ExpenseType::all()->sortDesc();

        return view('expense-types', ['expenseTypes' => $expenseTypes]);
    }

    public function showCreateExpenseTypePage(){
        return view('expense-type-create');
    }

    public function showUpdateExpenseTypePage(ExpenseType $expenseType){
        return view('expense-type-update', ['expenseType' => $expenseType]);
    }

    public function createExpenseType(Request $requset){

        $incomingFields = $requset->validate([
            'name' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $expenseType = ExpenseType::create($incomingFields);

        if($expenseType) return redirect('/expense-type/' . $expenseType->id . '/edit')->with('success', $expenseType->name . ' expense type created successfully');

        return redirect('/expense-type')->with('error', "Can't create expense type");
    }

    public function updateExpenseType(ExpenseType $expenseType, Request $requset){

        $incomingFields = $requset->validate([
            'name' => 'required'
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
