<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IncomeSourceController extends Controller
{

    public function incomeSources(){

        $incomeSources = IncomeSource::all()->sortDesc();

        $totalIncome = DB::table('tracking_history')
                                ->selectRaw("SUM(amount) as totalIncome")
                                ->where('user_id', '=', auth()->user()->id)
                                ->where('transaction_type', '=', 'INCOME')
                                ->get();

        return view('income-sources', [
            'incomeSources' => $incomeSources,
            'totalIncome' => $totalIncome[0]->totalIncome == null? 0 : $totalIncome[0]->totalIncome
        ]);
    }

    public function showCreateIncomeSourcePage(){
        return view('income-source-create');
    }

    public function showUpdateIncomeSourcePage(IncomeSource $incomeSource){
        return view('income-source-update', ['incomeSource' => $incomeSource]);
    }

    public function createIncomeSource(Request $requset){

        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('income_source')],
            'icon' => 'required'
        ]);

        $incomingFields['note'] = $requset->get('note');
        $incomingFields['user_id'] = auth()->user()->id;

        $incomeSource = IncomeSource::create($incomingFields);

        if($incomeSource) return redirect('/income-source/' . $incomeSource->id . '/edit')->with('success', $incomeSource->name . ' income source created successfully');

        return redirect('/income-source')->with('error', "Can't create income source");
    }

    public function updateIncomeSource(IncomeSource $incomeSource, Request $requset){

        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('income_source')->ignore($incomeSource->id)],
            'icon' => 'required'
        ]);

        $incomingFields['note'] = $requset->get('note');

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
