<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\RequestRole\RequestRole;
use App\Models\Balance;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Message;
use Carbon\Carbon;
use App\Models\Wallet;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'familyname', 'country', 'gender', 'birthday', 'email', 'email_verified_at', 'email_code', 'phone', 'phone_verified_at', 'phone_code', 'personal_identification', 'identification_verified_at', 'password', 'category_id', 'subcategory_id', 'biography', 'video', 'date_registration', 'last_login','boarding', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }


    /*public function accountTypes()
    {
        return $this->belongsToMany(AccountType::class, 'user_account_types');
    }*/

    public function accountTypes(): BelongsToMany
    {
        return $this->belongsToMany(AccountType::class, 'user_account_types', 'user_id', 'account_type_id');
    }


    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user');
    }

    // علاقة الدولة
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

     // العلاقات مع المشاريع
     public function projects()
     {
         return $this->hasMany(Project::class);
     }

     public function bids()
{
    return $this->hasMany(Bid::class);
}

     // وظيفة حساب نسبة المشاريع المكتملة

     // وظيفة حساب نسبة المشاريع المكتملة
    public function calculateCompletionRate()
    {

         // الحصول على جميع العطاءات للمستخدم
         $totalBids = $this->bids()->count();

         // الحصول على عدد العطاءات التي تم توظيفه عليها وأكمل تسليمها
         $completedDeliveries = $this->bids()->where('bid_status_id', 3)->count();

         // إذا كانت عدد العطاءات الإجمالية صفرًا، فإرجاع 0 لتجنب القسمة على صفر
         if ($totalBids === 0) {
             return 0;
         }

         // حساب نسبة التسليم
         return round(($completedDeliveries / $totalBids) * 100, 2);; // النسبة المئوية

        // جلب إجمالي المشاريع التي استلمها المستخدم
       /* $totalProjects = $this->projects()->count();


        // جلب عدد المشاريع المكتملة
        $completedProjects = $this->projects()->where('order_status_id', 7)->count();

        // تجنب القسمة على صفر
        if ($totalProjects == 0) {
            return 0;//'لم يحسب بعد'; // يمكن إرجاع رسالة أو قيمة افتراضية
        }
        //dd($totalProjects);
        // حساب النسبة
        $completionRate = ($completedProjects / $totalProjects) * 100;

        return round($completionRate, 2);*/
    }




    // العلاقة مع المشاريع التي قام المستخدم بفتحها
    public function openedProjects()
    {
        return $this->hasMany(Project::class);
    }

    // دالة لحساب نسبة المشاريع التي قام بتوظيف المستخدمين عليها
    public function calculateHiringRate()
    {
        // جلب إجمالي المشاريع التي قام المستخدم بفتحها
        $totalOpenedProjects = $this->openedProjects()->count();

        // جلب عدد المشاريع التي تم توظيف المستخدمين عليها
        $hiredProjects = $this->openedProjects()->where('is_hired', 'true')->count();

        // تجنب القسمة على صفر
        if ($totalOpenedProjects == 0) {
            return 'لم يحسب بعد'; // يمكن إرجاع رسالة أو قيمة افتراضية
        }

        // حساب النسبة
        $hiringRate = ($hiredProjects / $totalOpenedProjects) * 100;

        return round($hiringRate, 2) . " % ";
    }

    // علاقة المستخدم مع المشاريع التي عمل عليها
    public function projectsUser()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }


    // دالة لحساب نسبة أصحاب المشاريع الذين أعادوا توظيف المستخدم على أكثر من مشروع
    public function calculateRehireRate()
    {
        // اجلب جميع أصحاب المشاريع الذين عمل معهم هذا المستخدم
       // اجلب جميع أصحاب المشاريع الذين عمل معهم هذا المستخدم
       $allClients = $this->projectsUser()
       ->select('projects.user_id')
       ->distinct()
       ->pluck('projects.user_id');

        // اجلب أصحاب المشاريع الذين عمل معهم المستخدم على أكثر من مشروع
        $rehiredClients = $this->projectsUser()
            ->select('projects.user_id')
            ->groupBy('projects.user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('projects.user_id');

        // تجنب القسمة على صفر
        if ($allClients->count() == 0) {
            return 'لم يحسب بعد';
        }

        // حساب النسبة
        $rehireRate = ($rehiredClients->count() / $allClients->count()) * 100;

        return round($rehireRate, 2);
    }


     // علاقة المستخدم بالتسليمات
     public function deliveries()
     {
         return $this->hasMany(Delivery::class);
     }

     // دالة لحساب نسبة المشاريع التي تم تسليمها في الوقت المحدد بناءً على عدد الأيام
     public function calculateOnTimeDeliveryRate()
     {
         // اجلب المشاريع التي تم تسليمها في الوقت المحدد
         $onTimeDeliveriesCount = $this->deliveries()
         ->join('projects', 'deliveries.project_id', '=', 'projects.id')
         ->whereColumn('deliveries.delivery_date', '<=', 'projects.due_date')
         ->count();

         // اجلب العدد الإجمالي للمشاريع المسلمة
         $totalDeliveriesCount = $this->deliveries()->count();

         // تجنب القسمة على صفر
         if ($totalDeliveriesCount == 0) {
            return 'لم يحسب بعد';
         }

         // حساب النسبة
         $onTimeDeliveryRate = ($onTimeDeliveriesCount / $totalDeliveriesCount) * 100;

         return round($onTimeDeliveryRate, 2);
     }



    public function averageResponseTime()
    {
        // الحصول على أول رسالة استلمها المستخدم
        $firstReceivedMessage = $this->receivedMessages()->oldest('created_at')->first();

        if (!$firstReceivedMessage) {
            return 'لم يحسب بعد';
        }

        // الحصول على الردود التي قام بها المستخدم بعد أول رسالة
        $responses = $this->sentMessages()
            ->where('created_at', '>', $firstReceivedMessage->created_at)
            ->orderBy('created_at')
            ->get();

        if ($responses->isEmpty()) {
            return 'لم يحسب بعد';
        }

        // حساب الأوقات بين أول رسالة والردود
        $responseTimes = $responses->map(function ($response) use ($firstReceivedMessage) {
            return Carbon::parse($response->created_at)->diffInMinutes($firstReceivedMessage->created_at);
        });


        // حساب متوسط سرعة الرد بالدقائق
        $averageTimeInMinutes = $responseTimes->average();

        // تحويل المتوسط من دقائق إلى ساعات ودقائق
        $hours = floor($averageTimeInMinutes / 60);
        $minutes = $averageTimeInMinutes % 60;

        // صياغة النتيجة
        return "{$hours} ساعة و {$minutes} دقيقة";



        //سreturn $averageTime;

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


    // علاقة للحصول على الرسائل الصادرة من المستخدم
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // علاقة للحصول على الرسائل الواردة إلى المستخدم
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // دالة لحساب عدد الرسائل الواردة
    public function incomingMessagesCount()
    {
        return $this->receivedMessages()->count();
    }

    // دالة لحساب عدد الرسائل الصادرة
    public function outgoingMessagesCount()
    {
        return $this->sentMessages()->count();
    }

    // دالة لحساب عدد الرسائل الجديدة (غير المقروءة)
    public function newMessagesCount()
    {
        return $this->receivedMessages()->where('is_read', 0)->count();
    }


    protected static function booted()
    {
        static::created(function ($user) {
            $user->wallet()->create([
                'balance' => 0,
                'pending_balance' => 0,
            ]);
        });
    }


    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }


    public function acceptedDeliveries()
    {
        return $this->hasMany(Delivery::class, 'user_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(ProjectReview::class, 'client_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(ProjectReview::class, 'user_id');
    }


    // حساب التقييم الإجمالي
    public function calculateOverallRating()
    {
        // جلب جميع التقييمات للمستخدم
        $reviewsReceived = $this->reviewsReceived;

        // التأكد من أن المستخدم لديه تقييمات
        if ($reviewsReceived->isEmpty()) {
            return 0; // إذا لم يكن هناك تقييمات، قيمة التقييم الإجمالي ستكون 0
        }

        // جمع مجموع التقييمات حسب كل فئة (مثلاً الاحترافية، التواصل، الجودة، إلخ)
        $totalProfessionalism = $reviewsReceived->sum('professionalism');
        $totalCommunication = $reviewsReceived->sum('communication');
        $totalQuality = $reviewsReceived->sum('quality');
        $totalExpertise = $reviewsReceived->sum('expertise');
        $totalTimeliness = $reviewsReceived->sum('timeliness');
        $totalWouldWorkAgain = $reviewsReceived->sum('would_work_again');

        // حساب المتوسط لكل فئة
        $averageProfessionalism = $totalProfessionalism / $reviewsReceived->count();
        $averageCommunication = $totalCommunication / $reviewsReceived->count();
        $averageQuality = $totalQuality / $reviewsReceived->count();
        $averageExpertise = $totalExpertise / $reviewsReceived->count();
        $averageTimeliness = $totalTimeliness / $reviewsReceived->count();
        $averageWouldWorkAgain = $totalWouldWorkAgain / $reviewsReceived->count();

        // حساب التقييم الإجمالي بناءً على متوسط جميع الفئات
        $overallRating = ($averageProfessionalism + $averageCommunication + $averageQuality + $averageExpertise + $averageTimeliness + $averageWouldWorkAgain) / 6;

        return round($overallRating, 2); // تقريب التقييم الإجمالي إلى أقرب رقم عشري
    }


    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }


    public function favoriteProjects()
    {
        return $this->hasMany(Favorite::class, 'user_id')
                    ->where('favoritable_type', Project::class);
    }
}
