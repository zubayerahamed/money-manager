<?php

namespace App\Models;

use App\Traits\FilterByuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dream extends Model
{
    use HasFactory, FilterByuser;

    protected $fillable = ['name', 'image', 'target_year', 'amount_needed', 'user_id', 'note', 'wallet_id'];

    public function getImageAttribute($value)
    {
        return $value ? '/upload/dream/' . $value : "/assets/images/no-image.png";
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }
}
