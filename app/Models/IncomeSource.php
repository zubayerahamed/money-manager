<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model
{
    use HasFactory;

    protected $table = "income_source";
    protected $fillable = ['name', 'user_id'];
}
