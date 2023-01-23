<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arhead extends Model
{
    use HasFactory;

    protected $table = "arhead";

    protected $fillable = [
        'tracking_history_id',
        'wallet_id',
        'row_sign',
        'amount',
        'transaction_charge',
        'user_id'
    ];
}
