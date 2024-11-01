<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\OrderStatus;
use App\Models\Bid;
use App\Models\BidStatus;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Events\InvitationAccepted;
use App\Models\User;
use App\Models\Notification;
use App\Models\Delivery;
use App\Models\Wallet;
use App\Models\Earnings;
class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::getActiveProjects();
        $categories = Project::getCategoryParent();

        //$favoriteProjectIds = auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray();
        $favoriteProjectIds = auth()->check() ? auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray() : [];

        return view('frontend.projects.index', compact('projects','categories','favoriteProjectIds'));
    }

    // لعرض قائمة المشاريع مع إمكانية الفلترة
    public function list(Request $request)
    {

        //dd($request->category_ids);
        $categories = Project::getCategoryParent();
       // $favoriteProjectIds = auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray();
       $favoriteProjectIds = auth()->check() ? auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray() : [];

        $query = Project::query();

        // فلترة المشاريع حسب الأقسام المحددة
        if ($request->has('category_ids')) {
            $categoryIds = $request->input('category_ids');
            $query->whereIn('category_id', $categoryIds)->where('order_status_id', 1)->orderBy('id', 'DESC');
        }


        // جلب المشاريع مع تقسيم الصفحات
        $projects = $query->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);

        // إرجاع عرض جزئي
        return view('frontend.projects.partials.project-list', compact('projects','categories','favoriteProjectIds'))->render();
    }

    //حسب المده
    public function filter(Request $request)
    {
        $deliveryTimes = $request->input('delivery_times', []);

        $categories = Project::getCategoryParent();

       // $favoriteProjectIds = auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray();
       $favoriteProjectIds = auth()->check() ? auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray() : [];

        $query = Project::query();

        //dd($filteredProjects);
        if (in_array('1_week_less', $deliveryTimes)) {
            $query->orWhere('expected_duration', '<', 7); // أقل من أسبوع
        }

        if (in_array('1_2_weeks', $deliveryTimes)) {
            $query->orWhereBetween('expected_duration', [7, 14]); // من 1 إلى 2 أسابيع
        }

        if (in_array('2_weeks_1_month', $deliveryTimes)) {
            $query->orWhereBetween('expected_duration', [14, 30]); // من 2 أسابيع إلى شهر
        }

        if (in_array('1_3_months', $deliveryTimes)) {
            $query->orWhereBetween('expected_duration', [30, 90]); // من شهر إلى 3 أشهر
        }

        if (in_array('3_months_more', $deliveryTimes)) {
            $query->orWhere('expected_duration', '>', 90); // أكثر من 3 أشهر
        }

        $projects = $query->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);

        return view('frontend.projects.partials.project-list', compact('projects','categories','favoriteProjectIds'))->render();

    }


    // حسب السعر
    public function filterProjects(Request $request)
    {
        $categories = Project::getCategoryParent();
        //$favoriteProjectIds = auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray();
        $favoriteProjectIds = auth()->check() ? auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray() : [];

        // Validate request inputs
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 10000);

        // استعلام لتصفية المشاريع
            $projects = Project::where('min_price', '>=', $minPrice)
            ->where('max_price', '<=', $maxPrice)
            ->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);

            //dd($projects );
        // Query to get projects within the specified price range
        //$projects = Project::whereBetween('budget', [$minPrice, $maxPrice])->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);

        // Return a view or a partial HTML to replace in the frontend
        return view('frontend.projects.partials.project-list', compact('projects','categories','favoriteProjectIds'))->render();
    }


    public function listCategory(Request $request)
    {
       // dd($request->subCategory);
        /*$categories = Project::getCategoryParent();
        $query = Project::query();
        // فلترة المشاريع حسب الأقسام المحددة
            $categoryId = $request->Category;
            $projects = $query->where('category_id', $categoryId)->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);

        return view('frontend.projects.index', compact('projects','categories'));
        */


        $categories = Project::getCategoryParent();
        //$favoriteProjectIds = auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray();
        $favoriteProjectIds = auth()->check() ? auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray() : [];

        // جلب قيمة category_id من الطلب
    $categoryId = $request->input('category_id');

    // إنشاء استعلام لجلب المشاريع بناءً على القسم
    $projects = Project::when($categoryId, function($query, $categoryId) {
        return $query->where('category_id', $categoryId);
    })->paginate(10); // يمكن تعديل عدد المشاريع حسب الحاجة

    // عرض النتائج في الـ view
    return view('frontend.projects.partials.project-list', compact('projects','categories','favoriteProjectIds'))->render();


    }

    public function listSubCategory(Request $request)
    {
        //dd($request->subCategory);
        $categories = Project::getCategoryParent();
        $favoriteProjectIds = auth()->check() ? auth()->user()->favoriteProjects->pluck('favoritable_id')->toArray() : [];

        // فلترة المشاريع حسب الأقسام المحددة
        //if ($request->has('subcategory_id')) {
            $categoryId = $request->subCategory;
            $projects = Project::where('subcategory_id', $categoryId)->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);

        return view('frontend.projects.index', compact('projects','categories','favoriteProjectIds'));



    }



    /*
    public function getProjectsByCategories(Request $request)
    {
        $categoryIds = $request->input('ids');
        $categories = Project::getCategoryParent();
        if (!empty($categoryIds)) {
            $projects = Project::whereIn('category_id', $categoryIds)->where('order_status_id', 1)->orderBy('id', 'DESC')->paginate(10);
         }else{
            $projects = Project::getActiveProjects();
         }

        return view('frontend.projects.partials.project-list', compact('projects','categories'))->render();
    }
*/



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            //'budget' => 'required|string',
            'expected_duration' => 'required|integer',
            'price_range' => 'required',
        ]);

        /*if(!auth()->check()){
            return redirect('/register');
        }else{*/

             // افصل النطاق السعري المختار إلى min_price و max_price
            $priceRange = explode('-', $request->input('price_range'));
//dd($priceRange);
            // تأكد من أن السعر مدخل بشكل صحيح
            if (count($priceRange) === 2) {
                $minPrice = $priceRange[0];
                $maxPrice = $priceRange[1];
            }

            $validated['user_id'] = auth()->id();
            $validated['min_price'] = $minPrice;
            $validated['max_price'] =$maxPrice;

            $createdAt = now();  // لا تقم بتحويله إلى سلسلة، احتفظ به كـ Carbon instance
            $expectedDuration = $request->expected_duration;  // المدة المتوقعة بالأيام
            $expectedEndDate = $createdAt->addDays($expectedDuration);  // تاريخ الانتهاء المتوقع

            $createdAtFormatted = $createdAt->format('Y-m-d');  // تنسيق تاريخ الإنشاء
            $expectedEndDateFormatted = $expectedEndDate->format('Y-m-d');  // تنسيق تاريخ الانتهاء المتوقع

            $validated['due_date'] = $expectedEndDateFormatted;

            $project = Project::create($validated);

            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    // حفظ الملف في مجلد storage/app/public/files
                    $path = $file->store('media', 'public');

                    // إدخال مسار الملف إلى قاعدة البيانات
                    ProjectFile::create([
                        'media' => $path,//$file->getClientOriginalName(),
                        'project_id' => $project->id
                    ]);
                }
            }

            return redirect()->route('myprojects')->with('message','تم اضافه المشروع بنحاج وجاري المراجعه من قبل الاداره');;
        //}
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->orderBy('id', 'ASC')->get();
        return view('frontend.projects.create', compact('categories'));
    }


    public function show($projectId)
    {
        $project = Project::with(['bids','files','deliveries.acceptedUser','messages'])->findOrFail($projectId);

        if (!$project) {
            return redirect()->back();
        }

        $averageBid = $project->averageBid();


        $userId = auth()->id(); // الحصول على معرف المستخدم الحالي

    // التحقق من وجود عرض مسبق لهذا المستخدم على المشروع
    $existingBid = Bid::where('project_id', $projectId)
                      ->where('user_id', $userId)
                      ->first();

        $hasMessages = $project->messages()->where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })->exists();


        return view('frontend.projects.show', compact('project','averageBid','existingBid','hasMessages'));
        //return view('frontend.projects.show', compact('project'));
    }


    public function getSubCategory(Request $request)
    {
        $data = Category::where('parent_id',$request->id)->get();
        return  $data;
    }



    public function storeBid(Request $request, Project $project)
    {
        //dd('dddddd');
        $validated = $request->validate([
            'delivery_time' => 'required|integer',
            'offer_value' => 'required|numeric',
            'details' => 'required|string',
            'files.*' => 'sometimes|file|mimes:jpg,png,pdf,docx'
        ]);

        $bid = $project->bids()->create([
            'delivery_time' => $validated['delivery_time'],
            'offer_value' => $validated['offer_value'],
            'earnings' => Bid::calculateEarnings($validated['offer_value']),
            'details' => $validated['details'],
            'user_id' => auth()->id()
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('bid_files', 'public');
                $bid->files()->create(['file_path' => $path]);
            }
        }

        return redirect()->route('projects.show', $project)->with('message', 'تم اضافه العرض');
    }

    public function myprojects(Request $request)
    {
        $categories = Project::getCategoryParent();
        $projectStatus = OrderStatus::where('status',1)->orderBy('id', 'ASC')->get();

        $query = Project::where('user_id', Auth::id())->orderBy('id', 'DESC');

       // تصفية المشاريع بناءً على الحالات المحددة من الـ checkboxes
        if ($request->has('status') && is_array($request->status)) {
            $query->whereIn('order_status_id', $request->status);
        }elseif ($request->has('status')) {
            // إذا كانت هناك حالة ممررة من صفحة أخرى
            $query->where('order_status_id', $request->status);
        }

        // تنفيذ الاستعلام وجلب النتائج
        $projects = $query->paginate(10);
        // إذا كان الطلب عبر AJAX، يتم إرسال البيانات فقط لتحديث العرض
        if ($request->ajax()) {
            return view('frontend.projects.partials.project-list', compact('projects'))->render();
        }

        return view('frontend.projects.myproject.index', compact('projects','categories','projectStatus'));
    }

    public function myBids(Request $request)
    {
        $bidStatus = BidStatus::orderBy('id', 'ASC')->get();
        $user = auth()->user(); // تأكد من تسجيل الدخول
        $query = Bid::where('user_id', $user->id)->with(['project','bidStatus']);

        if ($request->has('status') && is_array($request->status)) {
            $query->whereIn('bid_status_id', $request->status);
        }elseif ($request->has('status')) {
            // إذا كانت هناك حالة ممررة من صفحة أخرى
            $query->where('bid_status_id', $request->status);
        }

        $bids = $query->paginate(10);

        if ($request->ajax()) {
            return view('frontend.projects.partials.project-bids-list', compact('bids'))->render();
        }

        return view('frontend.projects.bids', compact('bids','bidStatus'));
    }


    public function editProject(request $request)
    {
        //dd($request->id);
        $user = Auth::user();
        $categories = Category::whereNull('parent_id')->orderBy('id', 'ASC')->get();

        $project = Project::where(['id' => $request->id , 'user_id' => $user->id])->first();

        if(!$project ){
            return redirect()->back();
        }
        return view('frontend.projects.update', compact('project','categories'));
    }

    public function updateProject(request $request)
    {

        //dd($request->id);
        $project = Project::findOrFail($request->id);

        // تحديث بيانات المشروع
        $project->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'budget' => $request->input('budget'),
            'expected_duration' => $request->input('expected_duration'),

        ]);

        // التعامل مع رفع الصور الجديدة
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // حفظ الملف
                $filePath = $file->store('media', 'public');

                // إضافة الملف إلى قاعدة البيانات
                ProjectFile::create([
                    'project_id' => $request->id,
                    //'file_name' => $file->getClientOriginalName(),
                    'media' => $filePath,
                ]);
            }
         }

        return redirect()->back()->with('message', 'تم تحديث المشروع بنجاح');
    }

    public function deleteThumbnailFiles($id)
    {
        $projectFile = ProjectFile::find($id);
        if ($projectFile) {
            // حذف الصورة من التخزين
            Storage::disk('public')->delete($projectFile->media);

            // حذف السجل من قاعدة البيانات
            $projectFile->delete();

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

    public function destroyProject(request $request)
    {
        // البحث عن المشروع بواسطة الـ ID
        $project = Project::find($request->id);

        if (!$project) {
            return redirect()->back()->with('message', 'المشروع غير موجود.');
        }

        // التحقق من وجود عروض على المشروع
        $bidsCount = Bid::where('project_id', $request->id)->count();

        if ($bidsCount > 0) {
            return redirect()->back()->with('message', 'لا يمكن حذف المشروع لأنه يحتوي على عروض.');
        }

        // إذا لم يكن هناك عروض، قم بحذف المشروع
        $project->delete();

        return redirect()->route('myprojects')->with('message', 'تم حذف المشروع بنجاح.');
    }

    public function accept($id, Request $request)
    {
        $offer = Bid::findOrFail($id);


         // العثور على المحفظة الخاصة بصاحب المشروع
         $projectOwnerWallet = Wallet::where('user_id', $offer->project->user_id)->first();
         //dd($projectOwnerWallet);
         // التحقق من أن الرصيد المتاح لصاحب المشروع كافٍ
         if ($projectOwnerWallet->availableBalance() < $offer->offer_value) {
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك رصيد كافٍ لقبول هذا العرض.'
            ]);

         }

         // حجز المبلغ من المحفظة (نقل الرصيد إلى الرصيد المعلق)
         $projectOwnerWallet->pending_balance += $offer->offer_value;
         $projectOwnerWallet->balance -= $offer->offer_value;
         $projectOwnerWallet->save();


        // تغيير حالة العرض إلى "قيد التنفيذ"
        $offer->bid_status_id = 2;
        $offer->save();

        $createdAt = $offer->project->created_at;  // تاريخ إنشاء المشروع
        $expectedDuration = $offer->delivery_time;  // المدة المتوقعة بالأيام
        $expectedEndDate = $createdAt->addDays($expectedDuration);  // تاريخ الانتهاء المتوقع

         // أضف المستخدم المقبول إلى جدول deliveries
        Delivery::create([
            'project_id' => $offer->project_id,
            'user_id' => $offer->user_id,
            'delivery_date' =>  $expectedEndDate
        ]);

         // إرسال الإشعار إلى المستخدمين المعنيين
         Notification::create([
            'user_id' => $offer->user_id,
            'message' => 'تم قبول عرضك علي مشروع: ' . $offer->project->title,
            'url' => route('projects.show', $offer->project_id),
        ]);

        Project::where('id',$offer->project_id)->update(['is_hired' =>'true' , 'order_status_id' => 3 , 'project_progress_id' => 2]);


        // إرسال إشعار للمستخدم الذي تم قبوله
        event(new InvitationAccepted($offer->user_id, $offer->project_id)); // تأكد من أن لديك هذا الحدث

        return response()->json([
            'success' => true,
            'message' => 'تم قبول العرض'
        ]);
    }

    public function cancelProject(request $request)
    {
        // البحث عن المشروع بواسطة الـ ID
        $project = Project::find($request->id);

        if (!$project) {
            return redirect()->back()->with('message', 'المشروع غير موجود.');
        }

        // تحديث حالة المشروع إلى ملغي
        $project->order_status_id = 5;
        $project->save();

        return redirect()->route('myprojects')->with('message', 'تم الغاء المشروع بنجاح.');
    }

    public function requestDelivery($projectId)
    {
        $project = Project::findOrFail($projectId);
        // تحقق من أن المستخدم هو صاحب العرض المقبول
        /*if (Auth::id() != $project->acceptedOffer->user_id) {
            return redirect()->back()->with('error', 'أنت غير مصرح لك بهذا الإجراء.');
        }*/

        // تغيير حالة المشروع إلى "طلب تسليم المشروع"
        Project::where('id',$projectId)->update(['project_progress_id' => 3]);

         // إرسال إشعار لصاحب المشروع
        Notification::create([
            'user_id' => $project->user_id, // صاحب المشروع
            'message' => 'تم طلب تسليم المشروع: ' . $project->title,
            'url' => route('projects.show', $projectId),
        ]);

        // إرسال إشعار لصاحب المشروع
        //$projectOwner = $project->user_id;
        //$projectOwner->notify(new DeliveryRequestedNotification($project));

        return redirect()->back()->with('message', 'تم طلب تسليم المشروع بنجاح.');
    }

    public function approveDelivery($projectId)
    {
        $project = Project::findOrFail($projectId);

        // تحقق من أن المستخدم هو صاحب المشروع
       /* if (Auth::id() != $project->owner_id) {
            return redirect()->back()->with('error', 'أنت غير مصرح لك بهذا الإجراء.');
        }*/


        // المبلغ المستحق للمستخدم
        $amountDue = $project->bids->first()->offer_value; // يجب أن تحدد المبلغ المناسب
        $platformFee = $amountDue * 0.15; // 15% من المبلغ
        $finalAmount = $amountDue - $platformFee;
        //dd($finalAmount);
       // سحب المبلغ من محفظة صاحب المشروع
        $projectOwnerWallet = Wallet::where('user_id', $project->user_id)->first();
        /*if ($projectOwnerWallet->pending_balance < $amountDue) {
            return redirect()->back()->with('error', 'رصيد صاحب المشروع غير كافٍ.');
        }*/
        //dd($projectOwnerWallet);
        $projectOwnerWallet->pending_balance -= $amountDue;
        $projectOwnerWallet->save();

        // إضافة المبلغ إلى محفظة المستخدم
        $userWallet = Wallet::where('user_id', $project->bids->first()->user_id)->first();
        $userWallet->pending_balance += $finalAmount;
        $userWallet->save();

        // تسجيل الأرباح في جدول الأرباح
        Earnings::create([
            'project_id' => $project->id,
            'user_id' => $project->bids->first()->user_id,
            'amount' => $finalAmount,
            'platform_fee' => $platformFee,
        ]);


        // تغيير حالة المشروع إلى "مكتمل"
        Project::where('id',$projectId)->update(['order_status_id' => 7]);
        Bid::where('project_id',$projectId)->update(['bid_status_id' => 3]);
        // إرسال إشعار للمستخدم الذي قدم التسليم
        Notification::create([
            'user_id' => $project->bids->first()->user_id ,
            'message' => 'تمت الموافقة على تسليم مشروعك: ' . $project->title,
            'url' => route('projects.show', $projectId),
        ]);

        // إرسال إشعار للمستخدم الذي قدم العرض المقبول
        //$acceptedUser = $project->bids->first()->user_id ;
        //$acceptedUser->notify(new DeliveryApprovedNotification($project));

        return redirect()->back()->with('message', 'تم الموافقة على التسليم. المشروع مكتمل.');
    }

    public function rejectDelivery($projectId)
    {
        $project = Project::findOrFail($projectId);

        // تحقق من أن المستخدم هو صاحب المشروع
        /*if (Auth::id() != $project->owner_id) {
            return redirect()->back()->with('error', 'أنت غير مصرح لك بهذا الإجراء.');
        }*/

         // إرسال إشعار للمستخدم الذي قدم التسليم حول رفض الطلب
        Notification::create([
            'user_id' => $project->bids->first()->user_id,
            'message' => 'تم رفض تسليم مشروعك: ' . $project->title,
            'url' => route('projects.show', $projectId),
        ]);

        // لا نقوم بتغيير حالة المشروع، فقط نرسل إشعارًا للمستخدم الذي قدم العرض
        //$acceptedUser = $project->bids->first()->user_id;
        //$acceptedUser->notify(new DeliveryRejectedNotification($project));

        return redirect()->back()->with('message', 'تم رفض التسليم.');
    }

    public function cloneProject($id)
    {
        // جلب بيانات المشروع بناءً على معرف المشروع
        $project = Project::findOrFail($id);
        $categories = Category::whereNull('parent_id')->orderBy('id', 'ASC')->get();

        // تحويل المستخدم إلى صفحة إنشاء المشروع مع تمرير بيانات المشروع
        return view('frontend.projects.create', compact('project','categories'));
    }


}
