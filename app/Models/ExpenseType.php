<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExpenseType extends Model
{
    use HasFactory, FilterByuser;

    protected $table = "expense_type";

    protected $fillable = [
        'name',
        'icon',
        'note',
        'user_id',
        'active',
    ];

    public function getTotalExpenseAttribute()
    {
        $totalExpense = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('expense_type', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'EXPENSE')
            ->get();

        return $totalExpense->isEmpty() ? 0 : $totalExpense->get(0)->totalExpense;
    }

    public function trackingHistory()
    {
        return $this->hasMany(TrackingHistory::class, 'expense_type', 'id');
    }

    public function subExpenseTypes()
    {
        return $this->hasMany(SubExpenseType::class, 'expense_type_id', 'id');
    }
}
