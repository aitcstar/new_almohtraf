<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{

    public $table = 'sliders';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'image',
    ];
}
