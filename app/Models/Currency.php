<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Currency extends Model
{

    public $table = 'currencies';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title', 'symbol','rate'
    ];
}
