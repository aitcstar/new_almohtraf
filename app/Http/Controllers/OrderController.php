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
use App\Models\Order;
use App\Models\Service;
use App\Models\Currency;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $currencies=Currency::orderBy('id', 'ASC')->get();
        return view('frontend.orders', compact('orders','currencies'));
    }

    public function buy(Request $request) {

        Order::create($request->except('_token','totalPrice','minus','minusprice','laterbalance','endpoint','product_id','unit_id'));
       
        if($request->endpoint == 2 && $request->webapi == 'redeemly'){
            $data = array(
                "product_id"    => $request->product_id,
                "unit_id"       => $request->unit_id,
                "amount"        => $request->quantity,
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.redeemly.net/cards/orders',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array (
                'Content-type: application/json',
                'Authorization: Bearer XtHpImLPeFwTUKiXNcFAFxCKX25WAW7F',
            )
            ));
            $response = curl_exec($curl);

            $err = curl_error($curl);
            curl_close($curl);

            $result = json_decode($response, true);
            Balance::create([
                'user_id' => $request->user_id,
                'price' => '-'.$request->totalPrice,
                'currency_id' => $request->currency_id,
            ]);
            
            //$Balances = Balance::where('user_id',$request->user_id)->sum('price');
           
            //User::where('id',Auth::user()->id)->update(['balance' => $Balances ]);
           
            $stock = Service::where('id',$request->service_id)->value('stock'); //100
            $newstock =  $stock - $request->quantity;

            Service::where('id',$request->service_id)->update(['stock' => $newstock ]);
    
            return back()->with('message','تمت عمليه الشراء ');
        }elseif($request->endpoint == 2 && $request->webapi == 'qu-card'){
            $data = array(
                "product_id"    => $request->product_id,
                "player_id"     => $request->player_id,
                "quantity"      => $request->quantity,
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://qu-card.com/api/new_order',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array (
                'Content-type: application/json',
                'token:rhZwZEc4wWtt7U4LibXzc7343SIGuifbr1vsum8j',
            )
            ));
            $response = curl_exec($curl);
            //dd($response );
            $err = curl_error($curl);
            curl_close($curl);

            $result = json_decode($response, true);
            //dd($result);
            Balance::create([
                'user_id' => $request->user_id,
                'price' => '-'.$request->totalPrice,
                'currency_id' => $request->currency_id,
            ]);
            
            //$Balances = Balance::where('user_id',$request->user_id)->sum('price');
           
            //User::where('id',Auth::user()->id)->update(['balance' => $Balances ]);
           
            $stock = Service::where('id',$request->service_id)->value('stock'); //100
            $newstock =  $stock - $request->quantity;

            Service::where('id',$request->service_id)->update(['stock' => $newstock ]);
    
            return back()->with('message','تمت عمليه الشراء ');
        
       
        }elseif($request->endpoint == 2 && $request->webapi == 'gift4card'){
            /*$data = array(
                //"product_id"    => $request->product_id,
                "playerID"      => $request->player_id,
                "qty"           => $request->quantity,
                "order_uuid"    => Str::uuid(),
            );*/
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://qu-card.com/api/new_order/'.$request->product_id."/params?qty=".$request->quantity."&order_uuid=".Str::uuid()."&playerID=".$request->player_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                //CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array (
                'Content-type: application/json',
                'api-token:0c507b56a58a6a8b15071a0ef75c113bb2b5e80008737397',
            )
            ));
            $response = curl_exec($curl);
            //dd($response );
            $err = curl_error($curl);
            curl_close($curl);

            $result = json_decode($response, true);
            //dd($result);
            Balance::create([
                'user_id' => $request->user_id,
                'price' => '-'.$request->totalPrice,
                'currency_id' => $request->currency_id,
            ]);
        
           
            $stock = Service::where('id',$request->service_id)->value('stock'); //100
            $newstock =  $stock - $request->quantity;

            Service::where('id',$request->service_id)->update(['stock' => $newstock ]);
    
            return back()->with('message','تمت عمليه الشراء ');
       
        }else{
            if($request->laterbalance <= $request->minusprice){
                return back()->with('message','يرجي مراجعه الاداره الرصيد اقل من المتاح');
            }else{
                Balance::create([
                    'user_id' => $request->user_id,
                    'price' => '-'.$request->totalPrice,
                    'currency_id' => $request->currency_id,
                ]);
                
                //$Balances = Balance::where('user_id',$request->user_id)->sum('price');
               
                //User::where('id',Auth::user()->id)->update(['balance' => $Balances ]);
               
                $stock = Service::where('id',$request->service_id)->value('stock'); //100
                $newstock =  $stock - $request->quantity;
    
                Service::where('id',$request->service_id)->update(['stock' => $newstock ]);
        
                return back()->with('message','تمت عمليه الشراء ');
            }
        }

      
      
    }
}
