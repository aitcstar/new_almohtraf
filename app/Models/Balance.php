<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{

    public $table = 'balances';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'price',
        'currency_id',
        'wages',
        'nots',
    ];

    public function balance(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id','id');
    }
}
