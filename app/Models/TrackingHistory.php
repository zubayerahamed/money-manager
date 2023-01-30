<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    use HasFactory;

    protected $table = "tracking_history";
    protected $fillable = [
        'transaction_type', 
        'amount',
        'transaction_charge',
        'to_wallet',
        'from_wallet',
        'income_source',
        'expense_type',
        'transaction_date', 
        'transaction_time', 
        'user_id',
        'month',
        'year',
        'note'
    ];

    public function fromWallet(){
        $this->belongsTo(Wallet::class, 'from_wallet');
    }

    public function toWallet(){
        $this->belongsTo(Wallet::class, 'to_wallet');
    }

    public function incomeSource(){
        $this->belongsTo(IncomeSource::class, 'income_source');
    }

    public function expenseType(){
        $this->belongsTo(ExpenseType::class, 'expense_type');
    }
}
