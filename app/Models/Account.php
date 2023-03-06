<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name','note','user_id'];

    public function getCurrentBalanceAttribute()
    {
        $currentBalance = DB::table('account_tracking_histories')
            ->selectRaw("SUM(amount * row_sign) as currentBalance")
            ->where('account_id', '=', $this->id)
            ->where('user_id', '=', auth()->user()->id)
            ->get();
        return $currentBalance[0]->currentBalance == null ? 0 : $currentBalance[0]->currentBalance;
    }
}
