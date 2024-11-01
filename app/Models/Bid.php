<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Bid extends Model
{

    use HasFactory;
    public $table = 'bids';

    protected $fillable = ['project_id','user_id', 'delivery_time', 'offer_value', 'earnings', 'details','bid_status_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function bidStatus()
    {
        return $this->belongsTo(BidStatus::class, 'bid_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(BidFile::class);
    }

    public static function calculateEarnings($offerValue)
    {
        return $offerValue * 0.90; // Deducting 10% platform fee
    }


    public function timeElapsed($createdAt)
    {
       $now = Carbon::now();
       $createdAt = Carbon::parse($createdAt);

       $diffInMinutes = $createdAt->diffInMinutes($now);
       $diffInHours = $createdAt->diffInHours($now);
       $diffInDays = $createdAt->diffInDays($now);

       if ($diffInDays > 0) {
           return $diffInDays . ' يوم' . ($diffInDays > 1 ? 'ان' : '') . ' مضت';
       } elseif ($diffInHours > 0) {
           return $diffInHours . ' ساعة' . ($diffInHours > 1 ? 'ات' : '') . ' مضت';
       } elseif ($diffInMinutes > 0) {
           return $diffInMinutes . ' دقيقة' . ($diffInMinutes > 1 ? 'ات' : '') . ' مضت';
       } else {
           return 'أقل من دقيقة مضت';
       }
   }
}
