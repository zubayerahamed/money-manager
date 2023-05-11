<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory, FilterByuser;

    protected $fillable = ['amount', 'expense_type', 'note', 'user_id', 'month', 'year'];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type', 'id');
    }
}
