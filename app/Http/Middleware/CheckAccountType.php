<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // الحصول على `account_type_id` من جدول pivot وتخزينه في الجلسة
            $accountTypeIds = $user->accountTypes->pluck('pivot.account_type_id')->toArray();
            //dd($accountTypeIds);
            $request->session()->put('account_type_ids', $accountTypeIds);
        }

        return $next($request);
    }
}
