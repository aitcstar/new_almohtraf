<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Setting;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Category;
use App\Models\Project;
use App\Mail\SendMail;
use Mail;

class IndexController extends Controller
{
    public function index()
    {
       // جلب عدد المشاريع لكل قسم
        $categoryCounts = DB::table('projects')
        ->select(DB::raw('category_id, COUNT(*) as total_projects'))
        ->whereIn('category_id', [1, 2, 3, 4, 5, 6, 7, 8])
        ->groupBy('category_id')
        ->pluck('total_projects', 'category_id');


        // استرجاع آخر 8 مشاريع مضافة بناءً على created_at
        $projects = Project::orderBy('created_at', 'desc')->take(8)->get();


        return view('frontend.index', compact('categoryCounts','projects'));
    }

    public function profile(request $request){
        //$currencies=Currency::orderBy('id', 'ASC')->get();
        return view('frontend.profile');
    }

    public function accounts(request $request){
        //$currencies=Currency::orderBy('id', 'ASC')->get();
        return view('frontend.accounts');
    }

    public function currency_change(request $request){
        User::whereId(auth()->user()->id)->update([
            'currency_id' => $request->currency
        ]);

        return back()->with("message", "تم تغيير العملة بنجاح");
    }

    public function updatecurrency($id,$userId){
        User::where('id',$userId)->update([
            'currency_id' => $id
        ]);

        return back()->with("message", "تم تغيير العملة بنجاح");
    }

    public function ratecurrency($id){
       return Currency::where('id',$id)->value('rate');
    }

    public function transformation(request $request){

        Balance::create([
            'user_id' => Auth::user()->id,
            'price'   => '-'.$request->munsendPrice,
            'currency_id' => 1,
        ]);

        Balance::create([
            'user_id' => Auth::user()->id,
            'price'   => $request->plustotal,
            'currency_id' => $request->currencyID,
        ]);

        return back()->with("message", "تم تحويل المبلغ بنجاح");

    }

    public function transformation_member(request $request){

        $usercheck = User::where('phone',$request->member)->first();

        if(  $usercheck== null ){
            return back()->with("message", "رقم الجوال  غير مسجل لدينا بالنظام");
        }else{

            if(Auth::user()->balance(Auth::user()->id, $request->currency_id)  <=  $request->price){
                return back()->with("message", "المبلغ المحدد غير متوفر بالحساب");
            }else{
                //dd('2');
                Balance::create([
                    'user_id'       => Auth::user()->id,
                    'price'         => '-'.$request->price,
                    'currency_id'   => $request->currency_id,
                    'wages'         => $request->wages,
                    'nots'          => $request->currenotsncy_id,
                ]);

                Balance::create([
                    'user_id'     => $usercheck->id,
                    'price'       => $request->price,
                    'currency_id' => $request->currency_id,
                    'wages'         => $request->wages,
                    'nots'          => $request->currenotsncy_id,
                ]);

                return back()->with("message", "تم تحويل المبلغ بنجاح");
            }
        }
    }

}
