<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistoryDetail extends Model
{
    use HasFactory, FilterByuser;

    protected $fillable = [
        'amount',
        'transaction_date',
        'transaction_time',
        'sub_expense_type_id',
        'tracking_history_id',
        'user_id',
        'month',
        'year'
    ];

    public function subExpenseType()
    {
        return $this->belongsTo(SubExpenseType::class, 'sub_expense_type_id');
    }
}
