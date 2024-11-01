<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Earnings extends Model
{
    use HasFactory;

    // حقل الجدول الذي يتيح لك تحديد حقول النموذج
    protected $fillable = [
        'project_id',   // معرف المشروع
        'user_id',
        'amount',       // المبلغ المضاف
        'platform_fee', // نسبة المنصة
    ];

    // إذا كنت ترغب في تعريف علاقة مع نموذج المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
     public function user()
     {
         return $this->belongsTo(User::class);
     }
}
