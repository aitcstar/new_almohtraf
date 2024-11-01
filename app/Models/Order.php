<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'category_id',
        'service_id',
        'user_id',
        'player_id',
        'quantity',
        'type',
       'reason'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function service(){
        return $this->belongsTo(Service::class,'service_id','id');
    }

    
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
