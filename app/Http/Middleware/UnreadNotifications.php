<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Notification;

class UnreadNotifications
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $unreadCount = Notification::where('user_id', auth()->id())
                                       ->where('is_read', 0)
                                       ->count();
            view()->share('unreadCount', $unreadCount);
        }

        return $next($request);
    }
}
