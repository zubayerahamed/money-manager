<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dream extends Model
{
    use HasFactory;

    protected $fillable = ['name','image','target_year','amount_needed','user_id','note'];

    public function getImageAttribute($value)
    {
        return $value ? '/upload/dream/' . $value : "/assets/images/demo/users/face11.jpg";
    }
}
