<?php

namespace App\Http\Controllers;

use App\Models\TrackingHistory;
use App\Traits\HttpResponses;
use DebugBar\DataCollector\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    use HttpResponses;

    private  $section_accordion;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->section_accordion = ['dashboard-content-section', route('home')];
    }

    /**
     * Page Sections loader
     *
     * @param Request $requset
     * @return void
     */
    public function reloadPageSections(Request $requset){
        return $this->reloadSectionsOnly(
            [
                $this->section_accordion,
            ]
        );
    }

    /**
     * Display dashboard for user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Current balance
        $currentBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign) - SUM(transaction_charge) as currentBalance")
            ->where('user_id', '=', auth()->id())
            ->where('excluded', '=', 0)
            ->get();

        $currentBalance = $currentBalance->isEmpty() ? 0 : $currentBalance->get(0)->currentBalance;

        // Excluded balance
        $excludedBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign) - SUM(transaction_charge) as excludedBalance")
            ->where('user_id', '=', auth()->id())
            ->where('excluded', '=', 1)
            ->get();

        $excludedBalance = $excludedBalance->isEmpty() ? 0 : $excludedBalance->get(0)->excludedBalance;

        // Get all the transaction of current year except OPENING transaction
        $allTransactionsOfCurrentYear = TrackingHistory::where('year', '=', date('Y'))
            ->where('transaction_type', '<>', 'OPENING')
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Creating Month wise group of transactions
        $monthWiseGroup = [];
        $currentTrnMonth = "";

        foreach ($allTransactionsOfCurrentYear as $trn) {   // Loop through each transaction which is sorted by transaction_date
            $month_name = date("F", mktime(0, 0, 0, $trn->month, 10));  // Get month from record and make current month name to use it make a month wise group

            if ($currentTrnMonth == "" || $currentTrnMonth != $trn->month) {    // This condition refer's to found new month data in loop
                $currentTrnMonth = $trn->month;     // Set the transaction record month to current month variable for track loop

                $income = $trn->transaction_type == 'INCOME' ? $trn->amount : 0;
                $loan = $trn->transaction_type == 'LOAN' ? $trn->amount : 0;
                $expense = $trn->transaction_type == 'EXPENSE' ? $trn->amount : 0;
                $trancharge = $trn->transaction_charge;
                $saving = $income - $expense - $trancharge;

                $monthWiseGroup = array_push_assoc($monthWiseGroup, $month_name, [
                    'income' => $income,
                    'loan' => $loan,
                    'expense' => $expense,
                    'saving' => $saving,
                    'trancharge' => $trancharge,
                    'month' => $trn->month
                ]);
            } else {    // This else condition refer's that, record month already found in previous loop and now it's need to update it's calculation
                $monthData = $monthWiseGroup[$month_name];      // Get the existing month data from month wise group by month name

                // Update the previous values
                if ($trn->transaction_type == 'INCOME') $monthData['income'] = $monthData['income'] + $trn->amount;
                if ($trn->transaction_type == 'LOAN') $monthData['loan'] = $monthData['loan'] + $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $monthData['expense'] = $monthData['expense'] + $trn->amount;
                $monthData['trancharge'] = $monthData['trancharge'] + $trn->transaction_charge;
                $monthData['saving'] = $monthData['income'] - $monthData['expense'] - $monthData['trancharge'];

                // Replacing previous values with new values
                $monthData = array_push_assoc($monthData, 'income', $monthData['income']);
                $monthData = array_push_assoc($monthData, 'loan', $monthData['loan']);
                $monthData = array_push_assoc($monthData, 'expense', $monthData['expense']);
                $monthData = array_push_assoc($monthData, 'saving', $monthData['saving']);
                $monthData = array_push_assoc($monthData, 'trancharge', $monthData['trancharge']);
                $monthData = array_push_assoc($monthData, 'month', $trn->month);

                // Updating the month wise group with new month data
                $monthWiseGroup = array_push_assoc($monthWiseGroup, $month_name, $monthData);
            }
        }

        // Creating Year wise group of transactions
        $yearWiseGroup = [];
        $currentTrnYear = "";

        TrackingHistory::where('year', '<>', date('Y'))->where('transaction_type', '<>', 'OPENING')->chunkById(10000, function ($transactions) use (&$currentTrnYear, &$yearWiseGroup) {
            // Loop through transactions of current chunk
            foreach ($transactions as $trn) {
                if ($currentTrnYear == "" || $currentTrnYear != $trn->year) {    // This condition refer's to found new year data in loop
                    $currentTrnYear = $trn->year;

                    $income = $trn->transaction_type == 'INCOME' ? $trn->amount : 0;
                    $loan = $trn->transaction_type == 'LOAN' ? $trn->amount : 0;
                    $expense = $trn->transaction_type == 'EXPENSE' ? $trn->amount : 0;
                    $trancharge = $trn->transaction_charge;
                    $saving = $income - $expense - $trancharge;

                    $yearWiseGroup = array_push_assoc($yearWiseGroup, $currentTrnYear, [
                        'income' => $income,
                        'loan' => $loan,
                        'expense' => $expense,
                        'saving' => $saving,
                        'trancharge' => $trancharge,
                        'year' => $trn->year
                    ]);
                } else {
                    $yearData = $yearWiseGroup[$currentTrnYear];      // Get the existing year data from year wise group by year

                    // Update the previous values
                    if ($trn->transaction_type == 'INCOME') $yearData['income'] = $yearData['income'] + $trn->amount;
                    if ($trn->transaction_type == 'LOAN') $yearData['loan'] = $yearData['loan'] + $trn->amount;
                    if ($trn->transaction_type == 'EXPENSE') $yearData['expense'] = $yearData['expense'] + $trn->amount;
                    $yearData['trancharge'] = $yearData['trancharge'] + $trn->transaction_charge;
                    $yearData['saving'] = $yearData['income'] - $yearData['expense'] - $yearData['trancharge'];

                    // Replacing previous values with new values
                    $yearData = array_push_assoc($yearData, 'income', $yearData['income']);
                    $yearData = array_push_assoc($yearData, 'loan', $yearData['loan']);
                    $yearData = array_push_assoc($yearData, 'expense', $yearData['expense']);
                    $yearData = array_push_assoc($yearData, 'saving', $yearData['saving']);
                    $yearData = array_push_assoc($yearData, 'trancharge', $yearData['trancharge']);
                    $yearData = array_push_assoc($yearData, 'year', $trn->year);

                    // Updating the year wise group with new year data
                    $yearWiseGroup = array_push_assoc($yearWiseGroup, $currentTrnYear, $yearData);
                }
            }
        });

        if($request->ajax()){
            return view('layouts.dashboard.dashboard-chart', [
                'currentBalance' => $currentBalance,
                'monthWiseGroup' => $monthWiseGroup,
                'yearWiseGroup' => $yearWiseGroup,
                'excludedBalance' => $excludedBalance,
            ]);
        }

        return view('dashboard', [
            'currentBalance' => $currentBalance,
            'monthWiseGroup' => $monthWiseGroup,
            'yearWiseGroup' => $yearWiseGroup,
            'excludedBalance' => $excludedBalance,
        ]);
    }

    /**
     * Get current year line chart data for dashboard
     * @return Renderable
     */
    public function getCurrentYearLineChartData()
    {
        $trackingHistoriesOfIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as amount, SUM(transaction_charge) as charge, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'INCOME')
            ->where('year', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $trackingHistoriesOfExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as amount, SUM(transaction_charge) as charge, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('year', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $trackingHistoriesOfTransfer = DB::table('tracking_history')
            ->selectRaw("SUM(transaction_charge) as charge, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'TRANSFER')
            ->where('year', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $income_amount = 0;
        $expense_amount = 0;
        $transaction_charge_amount = 0;
        $month = [];

        // Loop throught each month of year and set income and expense data
        for ($i = 1; $i <= 12 && $i <= (int) date('m'); $i++) {

            // Calculating income amount and related transaction charge
            for ($j = 0; $j < sizeof($trackingHistoriesOfIncome); $j++) {
                if ($trackingHistoriesOfIncome[$j]->month == $i) {
                    $transaction_charge_amount += $trackingHistoriesOfIncome[$j]->charge;
                    $income_amount += $trackingHistoriesOfIncome[$j]->amount;
                }
            }

            // Calculating transaction charge for transfers
            for ($l = 0; $l < sizeof($trackingHistoriesOfTransfer); $l++) {
                if ($trackingHistoriesOfTransfer[$l]->month == $i) {
                    $transaction_charge_amount += $trackingHistoriesOfTransfer[$l]->charge;
                }
            }

            // Calculation expense amount and related transaction charge
            for ($k = 0; $k < sizeof($trackingHistoriesOfExpense); $k++) {
                if ($trackingHistoriesOfExpense[$k]->month == $i) {
                    $transaction_charge_amount += $trackingHistoriesOfExpense[$k]->charge;
                    $expense_amount += $trackingHistoriesOfExpense[$k]->amount;
                }
            }

            $obj['month'] = date("F", mktime(0, 0, 0, $i, 10));
            $obj['income_amount'] = $income_amount;
            $obj['expense_amount'] = $expense_amount + $transaction_charge_amount;

            array_push($month, $obj);
        }

        return $month;
    }

    /**
     * Get current month line chart data for dashboard
     * @return Renderable
     */
    public function getCurrentMonthLineChartData()
    {
        $trackingHistoriesOfIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as amount, SUM(transaction_charge) as charge, transaction_date")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'INCOME')
            ->where('month', '=', date('m'))
            ->where('year', '=', date('Y'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get();

        $trackingHistoriesOfExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as amount, SUM(transaction_charge) as charge, transaction_date")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('month', '=', date('m'))
            ->where('year', '=', date('Y'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get();

        $trackingHistoriesOfTransfer = DB::table('tracking_history')
            ->selectRaw("SUM(transaction_charge) as charge, transaction_date")
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'TRANSFER')
            ->where('month', '=', date('m'))
            ->where('year', '=', date('Y'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get();

        // Get total number of days in current month of year
        $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

        $income_amount = 0;
        $expense_amount = 0;
        $transaction_charge_amount = 0;
        $data = [];

        // Loop through each date of current month and set income expense data
        for ($i = 1; $i <= $totalDays && $i <= (int) date('d'); $i++) {

            // Calculating income and related transaction charge
            for ($j = 0; $j < sizeof($trackingHistoriesOfIncome); $j++) {
                $trDate = $trackingHistoriesOfIncome[$j]->transaction_date;
                if ((int) date('d', strtotime($trDate)) == $i) {
                    $transaction_charge_amount += $trackingHistoriesOfIncome[$j]->charge;
                    $income_amount += $trackingHistoriesOfIncome[$j]->amount;
                }
            }

            // Calculating transaction charge for transfers
            for ($l = 0; $l < sizeof($trackingHistoriesOfTransfer); $l++) {
                $trDate = $trackingHistoriesOfTransfer[$l]->transaction_date;
                if ((int) date('d', strtotime($trDate)) == $i) {
                    $transaction_charge_amount += $trackingHistoriesOfTransfer[$l]->charge;
                }
            }

            // Calculating expense and related transaction charge
            for ($k = 0; $k < sizeof($trackingHistoriesOfExpense); $k++) {
                $trDate2 = $trackingHistoriesOfExpense[$k]->transaction_date;
                if ((int) date('d', strtotime($trDate2)) == $i) {
                    $transaction_charge_amount += $trackingHistoriesOfExpense[$k]->charge;
                    $expense_amount += $trackingHistoriesOfExpense[$k]->amount;
                }
            }

            $obj['date'] = $i;
            $obj['income_amount'] = $income_amount;
            $obj['expense_amount'] = $expense_amount + $transaction_charge_amount;

            array_push($data, $obj);
        }

        return $data;
    }
}
