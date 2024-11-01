<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\SendMail;
use App\Mail\ResetPassword;
use Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use App\Models\Skill;
use App\Models\Portfolio;
use App\Models\PortfolioFile;
use App\Models\Bid;
use App\Models\BidStatus;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;


class BoardingController extends Controller
{

    public function account(request $request){
        $user = Auth::user();
        $userAccountTypes = $user->accountTypes->pluck('id')->toArray();

        //dd($userAccountTypes);
        return view('frontend.boarding.account', compact('userAccountTypes'), ['message' => 'نرجو منك إكمال إعداد حسابك']);
    }


    public function updateAccountTypes(Request $request)
    {
        $user = Auth::user();
        $types = $request->input('account_types', []);
        // حذف الأنواع الحالية
        $user->accountTypes()->sync($types);
        if($user->boarding == 0 || $user->boarding == 1){
            $user->update(['boarding' => 1 ]);
        }
        return redirect()->route('boarding.profile')->with('message','تم تحديث أنواع الحسابات بنجاح');

       // return redirect()->back()->with('success', 'تم تحديث أنواع الحسابات بنجاح.');
    }

    public function profile(request $request){
        $user = Auth::user();
        $categories = Category::whereNull('parent_id')
        ->with(['subCategories.subCategoryProjects', 'projects'])
        ->get();

        $countries = Country::get();
        $languages = Language::get();
        $skills = Skill::get();
        return view('frontend.boarding.profile', compact('categories','countries','languages','skills','user'),['message' => 'تم تحديث أنواع الحسابات بنجاح']);
    }

    public function updateProfile(Request $request)
    {
        //dd($request->all());
        $user = Auth::user();

        // Validate the form data
        $request->validate([
            'profile_picture' => 'image|max:2048',
            'country_id' => 'required',
            'language_id' => 'required',
            'gender' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required|string|max:15',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'biography' => 'required|string|max:1000',
            'skills' => 'required|array',
        ]);

        // تحقق من وجود الرقم
        $existingUser = User::where('phone', $request->phone)->first();

        if ($existingUser) {
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
        $user->save();
        //dd($user->profile_picture);
        $user->skills()->sync($request->skills); // Assuming you have a many-to-many relationship



        $user->update(['boarding' => 2 ]);
        return redirect()->route('boarding.portfolio')->with('message','تم تحديث الملف الشخصي بنجاح');

    }


    public function portfolio(request $request){
        $user = Auth::user();
        // جلب جميع الأعمال من قاعدة البيانات
        $portfolios = Portfolio::where('user_id', $user->id)->with(['files', 'skills'])->get();

        // جلب المهارات من قاعدة البيانات لاستخدامها في النموذج
        $skills = Skill::all();
        return view('frontend.boarding.portfolio', compact('skills','portfolios'), ['message' => 'نرجو منك إكمال إعداد حسابك']);
    }

    public function updatePortfolio(Request $request)
    {


        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif|max:2048',
            /*'files.*' => 'nullable|file|max:2048',
            'preview_link' => 'nullable|url',
            'completion_date' => 'nullable|date',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',*/
        ]);

        // البحث عن Portfolio موجود بالفعل للمستخدم الحالي
        $portfolio = Portfolio::where('user_id', Auth::id())->first();

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

        } else {
                // في حالة عدم وجود Portfolio، يتم إنشاء جديد
                $portfolio = new Portfolio();
                $portfolio->user_id = Auth::id();
                $portfolio->title = $request->title;
                $portfolio->description = $request->description;
                $portfolio->preview_link = $request->preview_link;
                $portfolio->completion_date = $request->completion_date;

                //dd( $request->all() );

                if ($request->hasFile('thumbnail')) {
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

        $user = Auth::user();
        $user->update(['boarding' => 3 ]);
        return redirect()->route('boarding.index')->with('message','تم تحديث ملفك  بنجاح');
        //return redirect()->route('boarding.acceptance')->with('message','تم تحديث ملف الاعمال  بنجاح');

    }


   /* public function acceptance(request $request){
        return view('frontend.boarding.acceptance', ['message' => 'نرجو منك إكمال إعداد حسابك']);
    }*/

    public function briefly(request $request){
        return view('frontend.boarding.briefly', ['message' => 'نرجو منك إكمال إعداد حسابك']);
    }

    public function updateInfo(request $request){

        $request->validate([
            'how_did_you_hear_about_us' => 'required|string',
        ]);

        $user = Auth::user();

        $user->how_did_you_hear_about_us = $request->input('how_did_you_hear_about_us');
        $user->save();
        $user->update(['boarding' => 3 ]);
        return redirect()->route('boarding.index')->with('message','تم تحديث ملفك  بنجاح');

    }


    public function index(request $request){
        $user = Auth::user();
        // التحقق إذا كان للمستخدم مشاريع
        $hasProject = $user->projects()->exists();

       // جلب كل الحالات من جدول order_status
        $statuses = DB::table('order_status')->get();

        $bitStatuses = DB::table('bid_status')->get();

        // جلب عدد المشاريع لكل حالة بناءً على المستخدم الحالي
        $projectsByStatus = DB::table('projects')
            ->select('order_status_id', DB::raw('count(*) as count'))
            ->where('user_id', $user->id) // تصفية المشاريع بناءً على المستخدم
            ->groupBy('order_status_id')
            ->pluck('count', 'order_status_id'); // جمع النتائج كـ key => value

        // حساب العدد الإجمالي لمشاريع المستخدم
        $totalProjects = $projectsByStatus->sum();

        // بناء ملخص الحالات مع النسبة المئوية
        $statusSummary = $statuses->map(function ($status) use ($projectsByStatus, $totalProjects) {
            $count = $projectsByStatus->get($status->id, 0); // جلب عدد المشاريع لكل حالة أو 0 إذا لا توجد
            $percentage = ($totalProjects > 0) ? round(($count / $totalProjects) * 100, 2) : 0;

            return [
                'id' => $status->id, // أو أي عمود يمثل اسم الحالة
                'status_name' => $status->name, // أو أي عمود يمثل اسم الحالة
                'count' => $count,
                'percentage' => round($percentage, 2),
            ];
        });


           // Get all bid statuses
        $statuses = BidStatus::all();

        // Get all bids for the project
        $bids = Bid::where('user_id', $user->id)->get();

        // Count total bids
        $totalBids = $bids->count();

        // Calculate the count and percentage for each status
        $statusPercentages = $statuses->map(function ($status) use ($bids, $totalBids) {
            $statusBidsCount = $bids->where('bid_status_id', $status->id)->count();
            $percentage = $totalBids > 0 ? ($statusBidsCount / $totalBids) * 100 : 0;

            return [
                'id' => $status->id,
                'name' => $status->name,
                'count' => $statusBidsCount,
                'percentage' => round($percentage, 2),//s$percentage,
            ];
        });


            // عدد الرسائل الواردة
            $incomingCount = $user->incomingMessagesCount();

            // عدد الرسائل الصادرة
            $outgoingCount = $user->outgoingMessagesCount();
            // عدد الرسائل الجديدة (غير المقروءة)
            $newMessagesCount = $user->newMessagesCount();

             // تحقق ما إذا كان المستخدم لديه محفظة، وإذا لم تكن موجودة، قم بإنشائها
            if (!$user->wallet) {
                $wallet = $user->wallet()->create([
                    'balance' => 0,
                    'pending_balance' => 0,
                ]);
            } else {
                $wallet = $user->wallet;
            }

            // جلب الفئات المرتبطة بالمستخدم
            $category = $user->Category;

            // الحصول على الفئات المرتبطة بالمستخدم
            $categoryIds = $user->Category->pluck('id');

            // جلب آخر المشاريع التي تنتمي لهذه الفئات
            $projects = Project::whereIn('category_id', $categoryIds)
                                ->where('order_status_id',1)
                                ->orderBy('created_at', 'desc') // ترتيب المشاريع بناءً على تاريخ الإنشاء
                                ->take(5) // جلب آخر 5 مشاريع مثلاً
                                ->get();

            return view('frontend.boarding.index', compact('hasProject','statusSummary','statusPercentages','incomingCount', 'outgoingCount','newMessagesCount','wallet','projects','category'), ['message' => ' تم تحديث ملفك  بنجاح']);
    }

    public function deleteThumbnail($id)
    {
         // العثور على البورتفوليو
        $portfolio = Portfolio::find($id);

        //dd($portfolio);
        // التحقق من وجود البورتفوليو والصورة
        if ($portfolio && $portfolio->thumbnail) {

            // حذف الصورة من التخزين
            /*if (Storage::disk('public')->exists($portfolio->thumbnail)) {
                Storage::disk('public')->delete($portfolio->thumbnail);
            }*/

            Storage::disk('public')->delete($portfolio->thumbnail);

            // حذف مسار الصورة من قاعدة البيانات
            $portfolio->thumbnail = null;
            $portfolio->save();

            // إرسال استجابة JSON بنجاح العملية
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصورة بنجاح.',
            ]);
        }

        // إرسال استجابة JSON عند عدم العثور على البورتفوليو أو الصورة
        return response()->json([
            'success' => false,
            'message' => 'الصورة غير موجودة.',
        ]);
    }


    public function deleteThumbnailFiles($id)
    {
        $portfolioFile = PortfolioFile::find($id);

        if ($portfolioFile) {
            // حذف الصورة من التخزين
            Storage::disk('public')->delete($portfolioFile->file_path);

            // حذف السجل من قاعدة البيانات
            $portfolioFile->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصورة بنجاح.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'لم يتم العثور على الصورة.'
        ]);
    }


}
