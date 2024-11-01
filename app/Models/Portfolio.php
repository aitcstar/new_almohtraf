<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'thumbnail', 'description', 'preview_link', 'completion_date','views'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(PortfolioFile::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'portfolio_skill', 'portfolio_id', 'skill_id');

        //return $this->belongsToMany(Skill::class, 'portfolio_skill');
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

    function formatDateToArabic($date)
    {
        // تحويل التاريخ من التنسيق الإنجليزي إلى Carbon
        $carbonDate = Carbon::parse($date);

        // تحويل الأرقام من الإنجليزية إلى العربية
        $arabicNumbers = [
            '0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤',
            '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩'
        ];

        // تحويل أرقام التاريخ
        $arabicDate = strtr($carbonDate->format('d F Y'), $arabicNumbers);

        // تحويل أسماء الأشهر إلى اللغة العربية
        $months = [
            'January' => 'يناير', 'February' => 'فبراير', 'March' => 'مارس',
            'April' => 'أبريل', 'May' => 'مايو', 'June' => 'يونيو',
            'July' => 'يوليو', 'August' => 'أغسطس', 'September' => 'سبتمبر',
            'October' => 'أكتوبر', 'November' => 'نوفمبر', 'December' => 'ديسمبر'
        ];

        // استبدال اسم الشهر بالترجمة العربية
        foreach ($months as $englishMonth => $arabicMonth) {
            $arabicDate = str_replace($englishMonth, $arabicMonth, $arabicDate);
        }

        return $arabicDate;
    }

    // علاقة مع المشاهدات
    public function views()
    {
        return $this->hasMany(PortfolioView::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
