<?php

namespace App\Http\Controllers;

use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function getCurrentYearLineChartData()
    {

        $totalIncome = DB::table('tracking_history')
            ->selectRaw("sum(amount) as amount, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'INCOME')
            ->where('year', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $totalExpense = DB::table('tracking_history')
            ->selectRaw("sum(amount) as amount, month")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('year', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $income_amount = 0;
        $expense_amount = 0;
        $data = [];

        for ($i = 1; $i <= 12 && $i <= (int) date('m'); $i++) {

            for ($j = 0; $j < sizeof($totalIncome); $j++) {
                if ($totalIncome[$j]->month == $i) {
                    $income_amount += $totalIncome[$j]->amount;
                }
            }

            for ($k = 0; $k < sizeof($totalExpense); $k++) {
                if ($totalExpense[$k]->month == $i) {
                    $expense_amount += $totalExpense[$k]->amount;
                }
            }

            $month_num = $i;
            $month_name = date("F", mktime(0, 0, 0, $month_num, 10));

            $obj['month'] = $month_name;
            $obj['income_amount'] = $income_amount;
            $obj['expense_amount'] = $expense_amount;

            array_push($data, $obj);
        }

        return $data;
    }

    public function getCurrentMonthLineChartData()
    {

        $totalIncome = DB::table('tracking_history')
            ->selectRaw("sum(amount) as amount, transaction_date")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'INCOME')
            ->where('month', '=', date('m'))
            ->where('year', '=', date('Y'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get();

        $totalExpense = DB::table('tracking_history')
            ->selectRaw("sum(amount) as amount, transaction_date")
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('month', '=', date('m'))
            ->where('year', '=', date('Y'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get();

        $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

        $income_amount = 0;
        $expense_amount = 0;
        $data = [];

        for ($i = 1; $i <= $totalDays && $i <= (int) date('d'); $i++) {

            for ($j = 0; $j < sizeof($totalIncome); $j++) {
                $trDate = $totalIncome[$j]->transaction_date;
                if ((int) date('d', strtotime($trDate)) == $i) {
                    $income_amount += $totalIncome[$j]->amount;
                }
            }

            for ($k = 0; $k < sizeof($totalExpense); $k++) {
                $trDate2 = $totalExpense[$k]->transaction_date;

                if ((int) date('d', strtotime($trDate2)) == $i) {
                    $expense_amount += $totalExpense[$k]->amount;
                }
            }

            $obj['date'] = $i;
            $obj['income_amount'] = $income_amount;
            $obj['expense_amount'] = $expense_amount;

            array_push($data, $obj);
        }

        return $data;
    }

    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function showDashboardPage()
    {

        // Current balance
        $currentBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as currentBalance")
            ->where('user_id', '=', auth()->user()->id)
            ->get();

        $currentBalanceFinal = $currentBalance[0]->currentBalance == null ? 0 : $currentBalance[0]->currentBalance;

        // month wise grid data
        $allTransactionsOfCurrentYear = TrackingHistory::where('user_id', '=', auth()->user()->id)
            ->where('year', '=', date('Y'))
            ->where('transaction_type', '<>', 'OPENING')
            ->orderBy('transaction_date', 'desc')
            ->get();

        $monthWiseGroup = [];

        $currentTrnMonth = "";
        foreach ($allTransactionsOfCurrentYear->all() as $trn) {
            $month_name = date("F", mktime(0, 0, 0, $trn->month, 10));

            if ($currentTrnMonth == "" || $currentTrnMonth != $trn->month) {
                $currentTrnMonth = $trn->month;
                $income = 0;
                $expense = 0;
                $trancharge = $trn->transaction_charge;
                if ($trn->transaction_type == 'INCOME') $income = $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $expense = $trn->amount;
                $saving = $income - $expense - $trancharge;
                $monthWiseGroup = $this->array_push_assoc($monthWiseGroup, $month_name, [
                    'income' => $income,
                    'expense' => $expense,
                    'saving' => $saving,
                    'trancharge' => $trancharge,
                    'month' => $trn->month
                ]);
            } else {
                $dateData = $monthWiseGroup[$month_name];
                if ($trn->transaction_type == 'INCOME') $dateData['income'] = $dateData['income'] + $trn->amount;
                if ($trn->transaction_type == 'EXPENSE') $dateData['expense'] = $dateData['expense'] + $trn->amount;
                $dateData['trancharge'] = $dateData['trancharge'] + $trn->transaction_charge;

                $dateData['saving'] = $dateData['income'] - $dateData['expense'] - $dateData['trancharge'];
                $dateData = $this->array_push_assoc($dateData, 'income', $dateData['income']);
                $dateData = $this->array_push_assoc($dateData, 'expense', $dateData['expense']);
                $dateData = $this->array_push_assoc($dateData, 'saving', $dateData['saving']);
                $dateData = $this->array_push_assoc($dateData, 'trancharge', $dateData['trancharge']);
                $dateData = $this->array_push_assoc($dateData, 'month', $trn->month);
                $monthWiseGroup = $this->array_push_assoc($monthWiseGroup, $month_name, $dateData);
            }
        }

        return view('dashboard', [
            'currentBalance' => $currentBalanceFinal,
            'monthWiseGroup' => $monthWiseGroup
        ]);
    }
}
