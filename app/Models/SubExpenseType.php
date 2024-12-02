<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubExpenseType extends Model
{
    use HasFactory, FilterByuser;

    protected $fillable = [
        'name',
        'active',
        'user_id',
        'expense_type_id',
    ];

    // Temporary dynamic property
    protected $attributes = [
        'amount' => 0, // Default value
    ];

    // Add amount to appends to include it in queries
    protected $appends = ['amount'];

    // Getter for the amount
    public function getAmountAttribute()
    {
        return $this->attributes['amount'];
    }

    // Setter for the amount
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value;
    }

    public function getTotalExpenseAttribute()
    {
        $totalExpense = DB::table('transaction_history_details')
            ->selectRaw("SUM(amount) as totalExpense")
            ->where('sub_expense_type_id', '=', $this->id)
            ->where('user_id', '=', auth()->id())
            ->get();

        return $totalExpense->isEmpty() ? 0 : $totalExpense->get(0)->totalExpense;
    }
}
