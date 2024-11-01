<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBoardingStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

         // تحقق مما إذا كان المستخدم مسجل الدخول وإذا كانت حالة boarding تساوي 0
        if ($user && $user->boarding == 0) {
            // استثناء بعض الصفحات مثل صفحة boarding نفسها أو صفحة تسجيل الخروج
            if (!$request->is('boarding/account') && !$request->is('logout')) {
                // إعادة التوجيه إلى صفحة boarding مع رسالة
                return redirect()->route('boarding.account')->with('message', 'نرجو منك إكمال إعداد حسابك');
            }
        }elseif($user && $user->boarding == 1){
            if (!$request->is('boarding/profile') && !$request->is('logout')) {
                 // استثناء الصفحات المحددة من التحقق
                    $excludedRoutes = [
                        'boarding.account',
                        'boarding.profile',
                    ];

                    // تحقق مما إذا كانت الصفحة الحالية في قائمة الاستثناءات
                    if (!in_array($request->route()->getName(), $excludedRoutes)) {
                        return redirect()->route('boarding.profile')
                            ->with('message', 'يرجى إكمال بيانات الحساب أولاً.');
                    }

            }
        }elseif($user && $user->boarding == 2){
            if(session('account_type_ids') && in_array(2, session('account_type_ids'))){
                if (!$request->is('boarding/portfolio') && !$request->is('logout')) {
                    // استثناء الصفحات المحددة من التحقق
                        $excludedRoutes = [
                            'boarding.account',
                            'boarding.profile',
                            'boarding.portfolio',
                        ];

                        // تحقق مما إذا كانت الصفحة الحالية في قائمة الاستثناءات
                        if (!in_array($request->route()->getName(), $excludedRoutes)) {
                            return redirect()->route('boarding.portfolio')
                                ->with('message', 'يرجى إكمال بيانات الحساب أولاً.');
                        }

                }
            }else{
                if (!$request->is('boarding/briefly') && !$request->is('logout')) {
                    // استثناء الصفحات المحددة من التحقق
                        $excludedRoutes = [
                            'boarding.account',
                            'boarding.profile',
                            'boarding.briefly',
                        ];

                        // تحقق مما إذا كانت الصفحة الحالية في قائمة الاستثناءات
                        if (!in_array($request->route()->getName(), $excludedRoutes)) {
                            return redirect()->route('boarding.briefly')
                                ->with('message', 'يرجى إكمال بيانات الحساب أولاً.');
                        }

                }
            }
        }/*elseif($user && $user->boarding == 3){
            if(session('account_type_ids') && in_array(2, session('account_type_ids'))){
                if (!$request->is('boarding/acceptance') && !$request->is('logout')) {
                    // استثناء الصفحات المحددة من التحقق
                        $excludedRoutes = [
                            'boarding.account',
                            'boarding.profile',
                            'boarding.portfolio',
                            'boarding.acceptance',
                        ];

                        // تحقق مما إذا كانت الصفحة الحالية في قائمة الاستثناءات
                        if (!in_array($request->route()->getName(), $excludedRoutes)) {
                            return redirect()->route('boarding.acceptance')
                                ->with('message', 'يرجى إكمال بيانات الحساب أولاً.');
                        }

                }
            }
        }*/

        return $next($request);
    }
}
