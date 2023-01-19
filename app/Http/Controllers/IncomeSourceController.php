<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use Illuminate\Http\Request;

class IncomeSourceController extends Controller
{

    public function incomeSources(){

        $incomeSources = IncomeSource::all()->sortDesc();

        return view('income-sources', ['incomeSources' => $incomeSources]);
    }

    public function showCreateIncomeSourcePage(){
        return view('income-source-create');
    }

    public function showUpdateIncomeSourcePage(IncomeSource $incomeSource){
        return view('income-source-update', ['incomeSource' => $incomeSource]);
    }

    public function createIncomeSource(Request $requset){

        $incomingFields = $requset->validate([
            'name' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $incomeSource = IncomeSource::create($incomingFields);

        if($incomeSource) return redirect('/income-source/' . $incomeSource->id . '/edit')->with('success', $incomeSource->name . ' income source created successfully');

        return redirect('/income-source')->with('error', "Can't create income source");
    }

    public function updateIncomeSource(IncomeSource $incomeSource, Request $requset){

        $incomingFields = $requset->validate([
            'name' => 'required'
        ]);

        $uIncomeSource = $incomeSource->update($incomingFields);

        if($uIncomeSource) return redirect('/income-source/' . $incomeSource->id . '/edit')->with('success', $incomeSource->name . ' income source updated successfully');

        return redirect('/income-source/' . $incomeSource->id . '/edit')->with('error', $incomeSource->name . ' income source update failed');
    }

    public function deleteIncomeSource(IncomeSource $incomeSource){
        $incomeSourceName = $incomeSource->name;
        $deleted = $incomeSource->delete();

        if($deleted) return redirect('/income-source/all')->with('success', $incomeSourceName . ' income source deleted successfully');

        return redirect('/income-source/all')->with('error', "Can't delete income source");
    }
}
