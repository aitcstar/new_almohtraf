<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{

    public $table = 'order_status';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'status'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
