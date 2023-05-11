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
    protected $fillable = ['name', 'icon', 'note', 'user_id'];


    public function getCurrentBalanceAttribute()
    {
        $currentBalance = DB::table('arhead')
            ->selectRaw("SUM(amount * row_sign)-SUM(transaction_charge) as currentBalance")
            ->where('wallet_id', '=', $this->id)
            ->where('user_id', '=', auth()->user()->id)
            ->get();
        return $currentBalance[0]->currentBalance == null ? 0 : $currentBalance[0]->currentBalance;
    }
}
