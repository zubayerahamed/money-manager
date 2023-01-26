<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IncomeSource extends Model
{
    use HasFactory;

    protected $table = "income_source";
    protected $fillable = ['name', 'icon', 'note', 'user_id'];

    public function getTotalIncomeAttribute(){
        $totalIncome = DB::table('tracking_history')
                                ->selectRaw("SUM(amount) as totalIncome")
                                ->where('income_source', '=', $this->id)
                                ->where('user_id', '=', auth()->user()->id)
                                ->where('transaction_type', '=', 'INCOME')
                                ->get();
        return $totalIncome[0]->totalIncome == null? 0 : $totalIncome[0]->totalIncome;
    }

    public function trackingHistory(){
        return $this->hasMany(TrackingHistory::class, 'income_source', 'id');
    }
}
