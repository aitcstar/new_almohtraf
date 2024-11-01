<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BidFile extends Model
{
    use HasFactory;

    protected $fillable = ['bid_id', 'file_path'];

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }
}
