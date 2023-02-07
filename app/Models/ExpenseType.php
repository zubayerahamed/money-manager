<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExpenseType extends Model
{
    use HasFactory;

    protected $table = "expense_type";
    protected $fillable = ['name', 'icon', 'note', 'user_id'];

    public function getTotalExpenseAttribute()
    {
        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('expense_type', '=', $this->id)
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->get();
        return $totalExpense[0]->totalExpense == null ? 0 : $totalExpense[0]->totalExpense;
    }

    public function trackingHistory()
    {
        return $this->hasMany(TrackingHistory::class, 'expense_type', 'id');
    }

    public function getBudgetAttribute(){
        $budgets = $this->hasMany(Budget::class, 'expense_type', 'id');

        $currentMonthBudget = new Budget();
        foreach($budgets->get() as $budget){
            if($budget->month == date('m') && $budget->year == date('Y')){
                $currentMonthBudget =  $budget;
            }
        }

        return $currentMonthBudget;
    }

    public function getCurrentMonthExpenseAttribute(){
        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('expense_type', '=', $this->id)
            ->where('user_id', '=', auth()->user()->id)
            ->where('transaction_type', '=', 'EXPENSE')
            ->where('year', '=', date('Y'))
            ->where('month', '=', date('m'))
            ->get();
        return $totalExpense[0]->totalExpense == null ? 0 : $totalExpense[0]->totalExpense;
    }
}
