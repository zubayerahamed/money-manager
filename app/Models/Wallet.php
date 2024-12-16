<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory, FilterByuser;

    protected $table = "wallet";

    protected $fillable = [
        'name',
        'icon',
        'note',
        'user_id',
        'excluded'
    ];

    public function getCurrentBalanceAttribute()
    {
        $currentBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as currentBalance")
            ->where('wallet_id', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->get();

        return $currentBalance->isEmpty() ? 0 : $currentBalance->get(0)->currentBalance;
    }

    public function getBalanceByDate($date, $time){
        $currentBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as currentBalance")
            ->where('wallet_id', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->where('xdate', '<=', $date)
            //->where('xtime', '<=', $time)
            ->get();
        
        return $currentBalance->isEmpty() ? 0 : $currentBalance->get(0)->currentBalance;
    }
}
