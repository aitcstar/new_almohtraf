<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'category_id', 'subcategory_id','budget', 'expected_duration', 'user_id', 'order_status_id','draft','due_date','min_price', 'max_price'
    ];

    // العلاقة مع الفئة الرئيسية
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // العلاقة مع الفئة الفرعية
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

     public function ownerProject()
     {
         return $this->belongsTo(User::class, 'user_id');
     }


     public function projectStatus()
     {
         return $this->belongsTo(OrderStatus::class, 'order_status_id');
     }


     public function files()
     {
        return $this->hasMany(ProjectFile::class);
     }

     public static function getActiveProjects()
     {
        return self::with('bids')->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);
     }

     public static function getCategoryParent()
     {
        return Category::whereNull('parent_id')->orderBy('id', 'ASC')->get();
     }


     public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function bidsCount()
    {
        $bidsCount = $this->bids()->count();

        if ($bidsCount > 0) {
            return  $bidsCount;
        } else {
            return "أضف أول عرض";
        }
    }

    public function averageBid()
    {
        $average = $this->bids()->average('offer_value');

        if ($average > 0) {
            return  round($average, 2);
        } else {
            return "0.00";
        }

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

    // علاقة المشروع مع المستخدمين الذين عملوا عليه
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

     // علاقة المشروع بالمستخدم
     public function user()
     {
         return $this->belongsTo(User::class);
     }

    // علاقة المشروع بالتسليمات
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function acceptedDelivery()
    {
        return $this->hasOne(Delivery::class)->where('status', '2'); //قيد التنفيذ
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function reviews()
    {
        return $this->hasMany(ProjectReview::class);
    }


    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }



}
