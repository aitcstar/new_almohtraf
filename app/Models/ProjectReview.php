<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'user_id',
        'client_id',
        'professionalism',
        'communication',
        'quality',
        'expertise',
        'timeliness',
        'would_work_again',
        'comment',
    ];

    // العلاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // العلاقة مع المستخدم الذي تم تقييمه
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع صاحب المشروع
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
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
