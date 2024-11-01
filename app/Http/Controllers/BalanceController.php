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
use App\Models\Balance;
use App\Models\Currency;

class BalanceController extends Controller
{
    public function balance()
    {
        $currencies=Currency::orderBy('id', 'ASC')->get();

        return view('frontend.balance', compact('currencies'));
    }

    public function addbalance(Request $request) {

        Balance::create($request->except('_token'));

        $Balances = Balance::where('user_id',$request->user_id)->sum('price');
       
        User::where('id',Auth::user()->id)->update(['balance' => $Balances ]);

        return back()->with('message','تم اضافه الرصيد الي الحساب');
    }
}
