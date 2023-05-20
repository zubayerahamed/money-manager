<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use App\Rules\IsCompositeUnique;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeSourceController extends Controller
{

    use HttpResponses;

    private  $section_accordion, $section_piechart, $section_header;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->section_accordion = ['income-sources-accordion', route('income-source.section.accordion')];
        $this->section_piechart = ['income-sources-pie-chart', route('income-source.section.piechart')];
        $this->section_header = ['income-sources-header', route('income-source.section.header')];
    }

    /**
     * Get income source status pie chart data
     * 
     * @return Renderable
     */
    public function incomeSourceStatusPieChart()
    {
        return DB::table('tracking_history')
            ->leftjoin('income_source', 'income_source.id', '=', 'tracking_history.income_source')
            ->selectRaw("income_source.name, SUM(tracking_history.amount) as value")
            ->where('tracking_history.user_id', '=', auth()->id())
            ->where('tracking_history.transaction_type', '=', 'INCOME')
            ->groupBy('tracking_history.income_source')
            ->groupBy('income_source.name')
            ->get();
    }

    /**
     * Dislay the income source status page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $incomeSources = IncomeSource::orderBy('name', 'asc')->get();

        $totalIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalIncome")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'INCOME')
            ->get();

        return view('income-sources', [
            'incomeSources' => $incomeSources,
            'totalIncome' => $totalIncome->isEmpty() ? 0 : $totalIncome->get(0)->totalIncome
        ]);
    }

    /**
     * Open income source create form in modal
     *
     * @return Renderable
     */
    public function create()
    {
        return view('layouts.income-sources.income-source-form', [
            'incomeSource' => new IncomeSource()
        ]);
    }

    /**
     * Store new income source in storage
     *
     * @param Request $requset
     * @return Renderable
     */
    public function store(Request $requset)
    {
        $requset->validate([
            'name' => ['required', new IsCompositeUnique('income_source', ['name' => $requset->get('name'), 'user_id' => auth()->id()], __('income-source.name.unique'))],
            'icon' => 'required'
        ]);

        $incomeSource = IncomeSource::create($requset->only([
            'name', 'icon', 'note', 'user_id'
        ]));

        if ($incomeSource) {
            return $this->successWithReloadSections(null, __('income-source.save.success', ['name' => $incomeSource->name]), 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Open income source edit form in modal
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $incomeSources = IncomeSource::where('id', '=', $id)->get();
        if ($incomeSources->isEmpty()) return $this->error(null, __('income-source.not.found'), 400);

        return view('layouts.income-sources.income-source-form', [
            'incomeSource' => $incomeSources->first()
        ]);
    }

    /**
     * Update existing income source in storage
     *
     * @param int $id
     * @param Request $requset
     * @return Renderable
     */
    public function update($id, Request $requset)
    {
        $incomeSources = IncomeSource::where('id', '=', $id)->get();
        if ($incomeSources->isEmpty()) return $this->error(null, __('income-source.not.found'), 400);

        $incomeSource = $incomeSources->get(0);

        $requset->validate([
            'name' => ['required', new IsCompositeUnique('income_source', ['name' => $requset->get('name'), 'user_id' => auth()->id()], __('income-source.name.unique'), $incomeSource->id)],
            'icon' => 'required'
        ]);

        $updated = $incomeSource->update($requset->only([
            'name', 'icon', 'note', 'user_id'
        ]));

        if ($updated) {
            return $this->successWithReloadSections(null, __('income-source.update.success', ['name' => $incomeSource->name]), 200, [
                $this->section_accordion,
                $this->section_header,
                $this->section_piechart,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $incomeSources = IncomeSource::where('id', '=', $id)->get();
        if ($incomeSources->isEmpty()) return $this->error(null, __('income-source.not.found'), 400);

        $incomeSource = $incomeSources->get(0);

        if ($incomeSource->trackingHistory()->count() > 0) {
            return $this->error(null, __('income-source.has.transaction', ['name' => $incomeSource->name]));
        }

        $incomeSourceName = $incomeSource->name;
        $deleted = $incomeSource->delete();

        if ($deleted) {
            return $this->successWithReloadSections(null, __('income-source.delete.success', ['name' => $incomeSourceName]), 200, [
                $this->section_accordion,
            ]);
        }

        return $this->error(null, __('common.process.error'));
    }

    /**
     * Income source page piechart section
     *
     * @return Renderable
     */
    public function piechart()
    {
        return view('layouts.income-sources.income-sources-pie-chart');
    }

    /**
     * Income source page header section
     *
     * @return Renderable
     */
    public function header()
    {
        $totalIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalIncome")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'INCOME')
            ->get();

        return view('layouts.income-sources.income-sources-header', [
            'totalIncome' => $totalIncome->isEmpty() ? 0 : $totalIncome->get(0)->totalIncome
        ]);
    }

    /**
     * Income source page accordion section
     *
     * @return Renderable
     */
    public function accordion()
    {
        $incomeSources = IncomeSource::orderBy('name', 'asc')->get();

        return view('layouts.income-sources.income-sources-accordion', [
            'incomeSources' => $incomeSources
        ]);
    }
}
