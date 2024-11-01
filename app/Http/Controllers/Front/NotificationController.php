<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\User;

class NotificationController extends Controller
{
    // عرض جميع الإشعارات الخاصة بالمستخدم
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.notifications.index', compact('notifications'));
    }

   // تحديث حالة الإشعار إلى مقروءة عند النقر على الرابط
   public function markAsRead($id)
   {
       $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

       if ($notification && !$notification->is_read) {
           $notification->update(['is_read' => 1]);
       }
       // إعادة توجيه المستخدم إلى الـ URL المرتبط بالإشعار
       return redirect($notification->url ?? '/notifications');
   }

    public function getUnreadCount()
    {
        $unreadCount = Notification::where('user_id', auth()->id())
                                    ->where('is_read', 0)
                                    ->count();

        return response()->json([
            'unreadCount' => $unreadCount
        ]);
    }



}
