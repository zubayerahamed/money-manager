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
}
