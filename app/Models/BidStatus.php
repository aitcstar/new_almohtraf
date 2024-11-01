<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidStatus extends Model
{

    public $table = 'bid_status';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'color',
    ];

    // Relationship with Bid
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
