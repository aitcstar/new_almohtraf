<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    // عرض الرسائل بين صاحب المشروع والمستخدم
    public function index(request $request)
    {
         // الرسائل الواردة (المرسلة إلى المستخدم الحالي)
        $receivedMessages = auth()->user()->receivedMessages()->with('project') // لجلب المشروع المرتبط
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('project_id'); // تجميع الرسائل حسب project_id

        // الرسائل الصادرة (المرسلة من المستخدم الحالي)
        $sentMessages = auth()->user()->sentMessages()->with('project') // لجلب المشروع المرتبط
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('project_id'); // تجميع الرسائل حسب project_id

        $activeTab = $request->input('tab', 'inbox'); // 'inbox' هو القيمة الافتراضية

        return view('frontend.messages.index', compact('receivedMessages', 'sentMessages','activeTab'));
    }

    // إرسال رسالة جديدة
    public function store(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

       // dd($project );
        // التحقق من أن المستخدم إما صاحب المشروع أو المستخدم الذي تم قبول عرضه
        /*if (Auth::id() !== $project->user_id && Auth::id() !== $project->accepted_offer_user_id) {
            abort(403, 'Access denied');
        }*/

        $request->validate([
            'message' => 'required|string',
            //'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', // تأكد من تعديل أنواع الملفات حسب الحاجة
        ]);

        //dd($request->all());
        // إنشاء الرسالة
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver,
            'message' => $request->message,
            'project_id' => $projectId,
        ]);


        // إذا كانت هناك مرفقات، قم بتخزينها
        if ($request->hasFile('attachments')) {
            //dd($request->all());
            //dd($request->hasFile('attachments'));
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public'); // تخزين الملفات في مجلد attachments

                //dd('ddddd');
                // إنشاء سجل المرفق
                $message->attachments()->create([
                    //'message_id' => $message->id,
                    'file_path' => $path,
                ]);
            }
        }

        // إرجاع استجابة JSON
        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الرسالة بنجاح.'
        ], 200);

    //return redirect()->back()->with('message', 'تم إرسال الرسالة بنجاح.');

    }


    public function newstore(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);


        $request->validate([
            'message' => 'required|string',
            //'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', // تأكد من تعديل أنواع الملفات حسب الحاجة
        ]);

        //dd($request->all());
        // إنشاء الرسالة
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver,
            'message' => $request->message,
            'project_id' => $projectId,
        ]);


        // إذا كانت هناك مرفقات، قم بتخزينها
        if ($request->hasFile('attachments')) {
            //dd($request->all());
            //dd($request->hasFile('attachments'));
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public'); // تخزين الملفات في مجلد attachments

                //dd('ddddd');
                // إنشاء سجل المرفق
                $message->attachments()->create([
                    //'message_id' => $message->id,
                    'file_path' => $path,
                ]);
            }
        }

      return redirect()->back()->with('message', 'تم إرسال الرسالة بنجاح.');

    }


    public function showProjectChat($projectId)
    {
        $userId = auth()->user()->id;
        // استرجاع الرسائل الخاصة بالمشروع
        $messages = Message::with(['sender', 'receiver'])
            ->where('project_id', $projectId)
            ->orderBy('created_at', 'asc') // ترتيب الرسائل حسب التاريخ
            ->get();

        $receiverId = $messages->first()->receiver->id;  // الحصول على id المستقبل
        // استرجاع معلومات المشروع إذا كنت بحاجة لعرضها
        $project = Project::findOrFail($projectId);

         // تحديث حالة is_read للرسائل التي لم يتم قراءتها
        Message::where('project_id', $projectId)
        ->where('receiver_id', $userId) // تغيير حالة is_read فقط للمستقبل
        ->where('is_read', 0)
        ->update(['is_read' => 1]);

        return view('frontend.messages.show', compact('messages', 'project','receiverId'));
    }




}
