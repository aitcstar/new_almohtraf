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

class AuthController extends Controller
{

    public function loginClient(request $request){
        return view('frontend.auth.login-client');
    }

    public function loginClientStore(request $request){
        $input_data=$request->all();

        if(Auth::attempt(['email'=>$input_data['email'],'password'=>$input_data['password']])){
            if( !Auth::user()->email_verified_at){
                return back()->with('message','من فضلك، قم بتفعيل البريد الإلكتروني.');
            }else{
                $username = Auth::user()->firstname . ' ' . Auth::user()->familyname;
                Session::put('frontSession',$username);
            }
        }else{
            return back()->with('message','يوجد خطا في البيانات المدخله');
        }

        if(Auth::user()->boarding == 0){
            return redirect()->route('boarding.account')->with('message','نرجو منك إكمال إعداد حسابك');
        }elseif(Auth::user()->boarding == 1){
            return redirect()->route('boarding.profile')->with('message','نرجو منك إكمال إعداد حسابك');
        }elseif(Auth::user()->boarding == 2){
            return redirect()->route('boarding.portfolio')->with('message','نرجو منك إكمال إعداد حسابك');
        //}
        //elseif(Auth::user()->boarding ==3){
            //return redirect()->route('boarding.acceptance')->with('message','نرجو منك إكمال إعداد حسابك');
        }else{
             //return redirect('/');
             return redirect()->route('boarding.index');
        }

    }



    public function register(request $request){
        return view('frontend.auth.register');
    }

    public function registerClient(request $request){
        $input_data=$request->all();
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'familyname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if($input_data['password'] != $input_data['password_confirmation']){
            return back()->with('message','كلمه المرور غير متطابقة');
        }

        if($validator->fails()){
            return back()->with('message',' البريد الإلكتروني مسجل بالفعل ');
        }

        $input_data['password'] = Hash::make($input_data['password']);
        $user = User::create($input_data);

         try {
            $title = 'كود تفعيل البريد الإلكتروني';
            $email = $request->email;
            $username = $user->firstname . ' ' .  $user->familyname;
            $company_name = 'المحترف للعمل الحر';

            Mail::to($email)->send(new SendMail($title,$email,$username,$company_name));
        } catch (\Swift_TransportException $ex) {
            $arr = array("value" => 400, "message" => $ex->getMessage(), "data" => []);
        } catch (Exception $ex) {
            $arr = array("value" => 400, "message" => $ex->getMessage(), "data" => []);
        }
        return redirect('/login-client')->with('message',' تمت عملية التسجيل بنجاح، يمكنك تفعيل حسابك عبر الرسالة التي أرسلناها لبريدك الإلكتروني ربما تصل في <spam>
        ');

    }

    public function verified(Request $request){
        User::where('email', $request->email)->update(['email_verified_at' => now()]);

        return redirect('/login-client')->with('message', 'تم تفعيل الحساب');;
    }

    public function profile(request $request){
        $currencies=Currency::orderBy('id', 'ASC')->get();
        return view('frontend.profile', compact('currencies'));
    }

    public function accounts(request $request){
        $currencies=Currency::orderBy('id', 'ASC')->get();
        return view('frontend.accounts', compact('currencies'));
    }



    public function resetPassword(request $request){
        return view('frontend.auth.reset-password');
    }

    public function restorePassword(request $request){
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return back()->with('message','يوجد خطا في البيانات المدخله');
        }else{
            try {
                $title = 'استعادة كلمة المرور';
                $email = $request->email;
                $username = $user->firstname . ' ' .  $user->familyname;
                $company_name = 'المحترف للعمل الحر';

                Mail::to($email)->send(new ResetPassword($title,$email,$username,$company_name));
            } catch (\Swift_TransportException $ex) {
                $arr = array("value" => 400, "message" => $ex->getMessage(), "data" => []);
            } catch (Exception $ex) {
                $arr = array("value" => 400, "message" => $ex->getMessage(), "data" => []);
            }

            return back()->with('message','تم ارسال الرابط علي البريد الإلكتروني ');
        }

    }


    public function changePassword(request $request){
        $mail = Crypt::decrypt($request->email);
        return view('frontend.auth.change-password', compact('mail'));
    }

    public function restoreChangePassword(request $request){
        # Validation
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|confirmed',
        ]);


        #Match The Password And Confirmed
        if($request->new_password != $request->password_confirmation){
            return back()->with("message", "تاكيد كلمه المرور غير متطابقة");
        }

        #Update the new Password
        User::where('email',$request->mail)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return redirect('/login-client')->with("message", "تم تغيير  كلمة المرور بنجاح");
    }


    public function logout(Request $request) {
        User::where('id', Auth::user()->id)->update(['last_login' => now() ]);
        Auth::logout();
        return redirect('/');
    }
}
