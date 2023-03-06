<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTrackingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'amount',
        'row_sign',
        'wallet_id',
        'account_id',
        'transaction_date',
        'transaction_time',
        'note',
        'user_id',
        'month',
        'year'
    ];
}
