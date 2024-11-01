<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'reportable_type', 'reportable_id', 'reason'];

    // علاقة مع الشخص الذي قدم التبليغ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة متعدد الأشكال للمحتوى المبلغ عنه
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
