<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IncomeSource extends Model
{
    use HasFactory, FilterByuser;

    protected $table = "income_source";

    protected $fillable = [
        'name',
        'icon',
        'note',
        'user_id'
    ];

    public function getTotalIncomeAttribute()
    {
        $totalIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalIncome")
            ->where('income_source', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'INCOME')
            ->get();

        return $totalIncome->isEmpty() ? 0 : $totalIncome->get(0)->totalIncome;
    }

    public function getTotalLoanAttribute()
    {
        $totalIncome = DB::table('tracking_history')
            ->selectRaw("SUM(amount) as totalLoan")
            ->where('income_source', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->where('transaction_type', '=', 'LOAN')
            ->get();

        return $totalIncome->isEmpty() ? 0 : $totalIncome->get(0)->totalLoan;
    }

    public function trackingHistory()
    {
        return $this->hasMany(TrackingHistory::class, 'income_source', 'id');
    }
}
