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
        'note',
        'account_id',
        'account_tracking_historie_id'
    ];

    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet');
    }

    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet');
    }

    public function incomeSource()
    {
        return $this->belongsTo(IncomeSource::class, 'income_source', 'id');
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type');
    }
}
