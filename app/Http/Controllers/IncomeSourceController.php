<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IncomeSourceController extends Controller
{

    use HttpResponses;

    private  $section_accordion, $section_piechart, $section_header;

    public function __construct()
    {
        $this->section_accordion = ['income-sources-accordion', route('income-source.section.accordion')];
        $this->section_piechart = ['income-sources-pie-chart', route('income-source.section.piechart')];
        $this->section_header = ['income-sources-header', route('income-source.section.header')];
    }

    public function incomeSourceStatusPieChart()
    {

        return DB::table('tracking_history')
            ->leftjoin('income_source', 'income_source.id', '=', 'tracking_history.income_source')
            ->selectRaw("income_source.name, SUM(tracking_history.amount) as value")
            ->where('tracking_history.user_id', '=', auth()->user()->id)
            ->where('tracking_history.transaction_type', '=', 'INCOME')
            ->groupBy('tracking_history.income_source')
            ->groupBy('income_source.name')
            ->get();
    }

    public function index()
    {
        $incomeSources = IncomeSource::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        $totalIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalIncome")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'INCOME')
            ->get();

        return view('income-sources', [
            'incomeSources' => $incomeSources,
            'totalIncome' => $totalIncome[0]->totalIncome == null ? 0 : $totalIncome[0]->totalIncome
        ]);
    }

    public function create()
    {
        return view('layouts.income-sources.income-source-form', ['incomeSource' => new IncomeSource()]);
    }

    public function edit($id)
    {
        $incomeSources = IncomeSource::where('id', '=', $id)->where('user_id', '=', auth()->user()->id)->get();
        return view('layouts.income-sources.income-source-form', ['incomeSource' => $incomeSources->first()]);
    }

    public function store(Request $requset)
    {
        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('income_source')],
            'icon' => 'required'
        ]);

        $incomingFields['note'] = $requset->get('note');
        $incomingFields['user_id'] = auth()->user()->id;

        $incomeSource = IncomeSource::create($incomingFields);

        if ($incomeSource) {
            return $this->successWithReloadSections(null, $incomeSource->name . ' income source created successfully', 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, "Something went wrong, please try again later.", 200);
    }

    public function piechart()
    {
        return view('layouts.income-sources.income-sources-pie-chart');
    }

    public function header()
    {
        $totalIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalIncome")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'INCOME')
            ->get();

        return view('layouts.income-sources.income-sources-header', [
            'totalIncome' => $totalIncome[0]->totalIncome == null ? 0 : $totalIncome[0]->totalIncome
        ]);
    }

    public function accordion()
    {
        $incomeSources = IncomeSource::where('user_id', '=', auth()->user()->id)->get()->sortDesc();

        return view('layouts.income-sources.income-sources-accordion', [
            'incomeSources' => $incomeSources
        ]);
    }

    public function update(IncomeSource $incomeSource, Request $requset)
    {
        $incomingFields = $requset->validate([
            'name' => ['required', Rule::unique('income_source')->ignore($incomeSource->id)],
            'icon' => 'required'
        ]);

        $incomingFields['note'] = $requset->get('note');

        $updated = $incomeSource->update($incomingFields);

        if ($updated) {
            return $this->successWithReloadSections(null, $incomeSource->name . ' income source updated successfully', 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, $incomeSource->name . ' income source update failed', 200);
    }

    public function destroy(IncomeSource $incomeSource)
    {
        if ($incomeSource->trackingHistory()->count() > 0) {
            return $this->error(null, $incomeSource->name . ' already has transaction', 200);
        }

        $incomeSourceName = $incomeSource->name;
        $deleted = $incomeSource->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, $incomeSourceName . ' income source deleted successfully', 200, [
                $this->section_accordion,
            ]);
        }

        return $this->error(null, 'Something went wrong, please try again later', 200);
    }
}
