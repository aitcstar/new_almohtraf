<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     // توجيه المستخدم إلى صفحة تسجيل الدخول بجوجل
     public function redirectToGoogle()
     {
         return Socialite::driver('google')->redirect();
     }

     // استلام رد جوجل ومعالجة تسجيل الدخول
     public function handleGoogleCallback()
     {
         try {
             $googleUser = Socialite::driver('google')->stateless()->user();

             // العثور على المستخدم أو إنشاؤه إذا كان جديدًا
             $user = User::where('email', $googleUser->getEmail())->first();

             if ($user) {
                 // تسجيل الدخول إذا كان المستخدم موجودًا
                 Auth::login($user);
             } else {
                 // إنشاء مستخدم جديد إذا لم يكن موجودًا
                 $user = User::create([
                     'firstname' => $googleUser->getName(),
                     'email' => $googleUser->getEmail(),
                     'google_id' => $googleUser->getId(),
                     'password' => bcrypt('defaultpassword') // يمكنك إضافة كلمة مرور افتراضية أو أي شيء آخر
                 ]);

                 Auth::login($user);
             }

             // إعادة التوجيه إلى الصفحة الرئيسية بعد تسجيل الدخول
             //return redirect()->intended('/home');
             if($user->boarding == 0){
                return redirect()->route('boarding.account')->with('message','نرجو منك إكمال إعداد حسابك');
            }elseif($user->boarding == 1){
                return redirect()->route('boarding.profile')->with('message','نرجو منك إكمال إعداد حسابك');
            }elseif($user->boarding == 2){
                return redirect()->route('boarding.portfolio')->with('message','نرجو منك إكمال إعداد حسابك');
            //}
            //elseif(Auth::user()->boarding ==3){
                //return redirect()->route('boarding.acceptance')->with('message','نرجو منك إكمال إعداد حسابك');
            }else{
                 //return redirect('/');
                 return redirect()->route('boarding.index');
            }
         } catch (Exception $e) {
             return redirect('/login')->withErrors(['error' => 'حدث خطأ ما في تسجيل الدخول']);
         }
     }

}
