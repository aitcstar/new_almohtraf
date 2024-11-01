<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;


    // علاقة المستخدمين
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
