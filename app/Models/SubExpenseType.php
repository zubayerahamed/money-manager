<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubExpenseType extends Model
{
    use HasFactory, FilterByuser;

    protected $fillable = [
        'name',
        'active',
        'user_id',
        'expense_type_id',
    ];
}
