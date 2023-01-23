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
        'note'
    ];
}
