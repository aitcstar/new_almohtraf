<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = ['user_id', 'message', 'url', 'is_read'];

    public function user() {
        return $this->belongsTo(User::class);
    }


    /*public function countUnreadNotifications()
    {
        $unreadCount = Notification::where('user_id', auth()->id())
                        ->where('is_read', 0)
                        ->count();
        return $unreadCount;
    }*/

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
