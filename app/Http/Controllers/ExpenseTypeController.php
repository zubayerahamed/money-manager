<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function expenseTypes(){
        return view('expense-types');
    }
}
