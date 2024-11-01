<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // تحقق ما إذا كان المستخدم لديه محفظة، وإذا لم تكن موجودة، قم بإنشائها
        if (!$user->wallet) {
            $wallet = $user->wallet()->create([
                'balance' => 0,
                'pending_balance' => 0,
            ]);
        } else {
            $wallet = $user->wallet;
        }

        return view('frontend.wallet.index', compact('wallet'));
    }


    public function addFunds(Request $request)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'card_number' => 'nullable|required_if:payment_method,credit_card',
            'expiry_date' => 'nullable|required_if:payment_method,credit_card',
            'cvv' => 'nullable|required_if:payment_method,credit_card',
            'paypal_email' => 'nullable|required_if:payment_method,paypal|email',
        ]);

        // Process the payment here based on the payment method (Credit Card/PayPal)
        // Add logic for interacting with payment gateway...

        // Example: Add the funds to the user's wallet
        $wallet = auth()->user()->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect()->route('wallet.index')->with('message', 'تم شحن رصيدك بنجاح!');
    }

}
