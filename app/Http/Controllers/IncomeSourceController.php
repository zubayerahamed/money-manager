<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeSourceController extends Controller
{
    public function incomeSources(){
        return view('income-sources');
    }
}
