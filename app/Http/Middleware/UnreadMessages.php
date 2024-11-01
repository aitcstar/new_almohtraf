<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Message;
use DB;
class UnreadMessages
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $userId = auth()->id();
           // استرجاع عدد الرسائل الغير مقروءة لكل مستخدم
            $unreadMessagesCount = DB::table('messages')
            ->where(function($query) use ($userId) {
                $query->where('receiver_id', $userId);
                    //->orWhere('receiver_id', $userId);
            })
            ->where('is_read', 0) // فقط الرسائل الغير مقروءة
            ->count();

            view()->share('unreadMessagesCount', $unreadMessagesCount);
        }

        return $next($request);
    }
}
