<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use DB;
use App\Models\Setting;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Category;
use App\Mail\SendMail;
use Mail;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Portfolio;
use App\Models\PortfolioFile;
use App\Models\PortfolioView;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(request $request){
        $user = Auth::user();
        $accountTypeIds = $user->accountTypes->toArray();
        $skills = Auth::user()->load('skills');
        $completionRate = $user->calculateCompletionRate();
        $hiringRate = $user->calculateHiringRate();
        $rehireRate = $user->calculateRehireRate();
        $onTimeDeliveryRate = $user->calculateOnTimeDeliveryRate();
        $averageTime = $user->averageResponseTime();
        $reviews = $user->reviewsReceived()->with('project')->get(); // assuming user has reviews() relationship

        return view('frontend.profile.index', compact('user','accountTypeIds','skills','completionRate','hiringRate','rehireRate','onTimeDeliveryRate','averageTime','reviews'));
    }

    public function edit(request $request){

        $user = Auth::user();
        $categories = Category::whereNull('parent_id')
        ->with(['subCategories.subCategoryProjects', 'projects'])
        ->get();

        $countries = Country::get();
        $languages = Language::get();
        $skills = Skill::get();
        $userAccountTypes = $user->accountTypes->pluck('id')->toArray();

        return view('frontend.profile.update', compact('categories','countries','languages','skills','user','userAccountTypes'));
    }

    public function update(request $request)
    {
        //dd($request->all());

        $user = Auth::user();

         // Validate the form data
        // $request->all();

        // تحقق من وجود الرقم
        $existingUser = User::where('phone', $request->phone)->where('id', '!=', $user->id)->first();

        if ($existingUser) {
            //dd('ddddddd');
            // إعادة توجيه مع رسالة خطأ
            return redirect()->back()->withInput()->with('error' , 'رقم الجوال مسجل بالفعل');
        }


       // التحقق إذا كان هناك صورة شخصية مرفوعة
        if ($request->hasFile('profile_picture')) {
            // تخزين الصورة في مجلد 'profile_pictures' داخل 'public' وتخزين المسار
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            //dd($imagePath);
            // تحديث مسار الصورة الشخصية في جدول المستخدمين
            $user->profile_picture = $imagePath;
        }



        // Update user profile details
        //$user->profile_picture =
        $user->country_id = $request->country_id;
        $user->language_id = $request->language_id;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;
        $user->category_id = $request->category_id;
        $user->subcategory_id = $request->subcategory_id;
        $user->biography = $request->biography;
        $user->video = $request->video;

        $availability = $request->input('freelancer_availability_hidden');
        //dd($availability);

        // بناءً على القيمة (1 أو 0) يمكنك تحديث حالة المستخدم
        if ($availability == 1) {
            // المستخدم متاح للتوظيف
            $user->freelancer_availability = 1;
        } else {
            // المستخدم غير متاح للتوظيف
            $user->freelancer_availability = 0;
        }
        $user->save();


        $user->skills()->sync($request->skills); // Assuming you have a many-to-many relationship

        $types = $request->input('account_types', []);
        // حذف الأنواع الحالية
        $user->accountTypes()->sync($types);

        //dd($user);

        return redirect()->back()->with('message','تم تحديث الملف الشخصي بنجاح');

    }

    public function portfolio(request $request)
    {
        $user = Auth::user();
        // جلب المهارات من قاعدة البيانات لاستخدامها في النموذج
        $skills = Skill::all();

        return view('frontend.profile.portfolio', compact('skills'));
    }

    public function addPortfolio(request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif|max:2048',
        ]);

        // في حالة عدم وجود Portfolio، يتم إنشاء جديد
        $portfolio = new Portfolio();
        $portfolio->user_id = Auth::id();
        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $portfolio->preview_link = $request->preview_link;
        $portfolio->completion_date = $request->completion_date;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $portfolio->thumbnail = $thumbnailPath;
        }

        $portfolio->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                if ($file->isValid()) {
                    $filePath = $file->store('portfolio_files', 'public');

                    // تأكد من أن المسار تم تخزينه بشكل صحيح
                    if (file_exists(storage_path('app/public/' . $filePath))) {
                        PortfolioFile::create([
                            'portfolio_id' => $portfolio->id,
                            'file_path' => $filePath,
                        ]);
                    } else {
                        // معالجة الخطأ إذا لم يكن الملف موجوداً
                        dd('File does not exist or is not readable.');
                    }
                } else {
                    // معالجة الأخطاء إذا كان الملف غير صالح
                    dd('Invalid file.');
                }
            }
        }


        if ($request->has('skills')) {
            $portfolio->skills()->sync($request->skills);
        }

        return redirect()->route('profile.index')->with('message','تم اضافة عمل جديد');
    }

    public function showPortfolio(Portfolio $portfolio)
    {
        //dd('kkk');
        // الحصول على المستخدم الحالي
        $user = Auth::user();
        $portfolio = $portfolio->where(['id' => $portfolio->id , 'user_id' => $user->id])->first();

        if(!$portfolio ){
            return redirect()->route('profile.index');
        }
        // التحقق مما إذا كان المستخدم قد شاهد البورتفوليو من قبل
        $viewed = PortfolioView::where('portfolio_id', $portfolio->id)
            ->where('user_id', $user->id)
            ->exists();

        // إذا لم يشاهد المستخدم البورتفوليو من قبل، نقوم بزيادة عدد المشاهدات
        if (!$viewed) {
            // إنشاء سجل جديد في جدول المشاهدات
            PortfolioView::create([
                'portfolio_id' => $portfolio->id,
                'user_id' => $user->id,
            ]);

            // زيادة عدد المشاهدات في البورتفوليو
            $portfolio->increment('views');
        }

        $skills = $portfolio->load('skills');

        return view('frontend.profile.portfolio.show', compact('portfolio','skills'));
    }


    public function editPortfolio(Portfolio $portfolio)
    {
        $user = Auth::user();
        // جلب جميع الأعمال من قاعدة البيانات
        $portfolios = Portfolio::where('id', $portfolio->id)->with(['files', 'skills'])->get();

        // جلب المهارات من قاعدة البيانات لاستخدامها في النموذج
        $skills = Skill::all();
        return view('frontend.profile.portfolio.update', compact('skills','portfolios'));
    }

    public function updatePortfolio(request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif|max:2048',
        ]);

        // البحث عن Portfolio موجود بالفعل للمستخدم الحالي
        $portfolio = Portfolio::where('id', $request->id)->first();

        if ($portfolio) {
            // في حالة وجود Portfolio، يتم التحديث
            $portfolio->title = $request->title;
            $portfolio->description = $request->description;
            $portfolio->preview_link = $request->preview_link;
            $portfolio->completion_date = $request->completion_date;

            if ($request->hasFile('thumbnail')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($portfolio->thumbnail && \Storage::disk('public')->exists($portfolio->thumbnail)) {
                    \Storage::disk('public')->delete($portfolio->thumbnail);
                }

                // تحميل الصورة الجديدة وتحديث مسار الصورة المصغرة
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $portfolio->thumbnail = $thumbnailPath;
            }

        }

        $portfolio->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                /*if ($file->getSize() > 2048000) { // 2 ميجابايت
                    return redirect()->with(['message' => 'حجم كل ملف يجب ألا يتجاوز 2 ميجابايت.']);
                }*/

                if ($file->isValid()) {
                    $filePath = $file->store('portfolio_files', 'public');

                    // تأكد من أن المسار تم تخزينه بشكل صحيح
                    if (file_exists(storage_path('app/public/' . $filePath))) {
                        PortfolioFile::create([
                            'portfolio_id' => $portfolio->id,
                            'file_path' => $filePath,
                        ]);
                    } else {
                        // معالجة الخطأ إذا لم يكن الملف موجوداً
                        dd('File does not exist or is not readable.');
                    }
                } else {
                    // معالجة الأخطاء إذا كان الملف غير صالح
                    dd('Invalid file.');
                }
            }
        }


        if ($request->has('skills')) {
            $portfolio->skills()->sync($request->skills);
        }

        return redirect()->back()->with('message','تم تحديث بيانات العمل بنجاح');
    }

    public function destroyPortfolio(Portfolio $portfolio)
    {
        $portfolio = Portfolio::findOrFail($portfolio->id);
        $portfolio->delete();

        return redirect()->route('profile.index')->with('message','تم الحذف بنجاح ');
    }


}
