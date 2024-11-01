<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'message', 'is_read', 'project_id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class);
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

   public static function getLastThreeMessages($userId)
    {
        return self::where('is_read', 0)
                ->where('receiver_id', $userId)
               //->orWhere('sender_id', $userId)
               ->orderBy('created_at', 'desc')
               ->take(3)
               ->get();
    }
}
