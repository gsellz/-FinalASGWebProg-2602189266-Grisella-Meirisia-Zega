<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('user.store')->with('error', 'User not found. Please register again.');
        }

        // Get the registration price
        $registrationPrice = $user->registration_price;

        return view('payment', compact('registrationPrice'));
    }


    public function payment(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('user.store')->with('error', 'User not found. Please register again.');
        }

        // Extract payment status and registration price from the authenticated user
        $registrationPrice = $user->registration_price;
        $paymentAmount = $request->input('payment_amount');

        // Handle underpayment
        if ($paymentAmount < $registrationPrice) {
            $kurang = $registrationPrice - $paymentAmount;
            return redirect()->back()->with('warning', "You are still underpaid Rp" . number_format($kurang));
        }
        // Handle overpayment
        elseif ($paymentAmount > $registrationPrice) {
            $lebih = $paymentAmount - $registrationPrice;

            session(['overpaid_amount' => $lebih, 'user_id' => $user->id]);

            return redirect()->back()->with('overpaid', "Sorry you overpaid Rp" . number_format($lebih) . ", would you like to enter a balance?");
        }
        // Handle exact payment
        else {
            $user->payment_status = 'Paid';
            $user->save();

            return redirect()->route('user.homepage')->with('success', 'Payment Successful');
        }
    }

    public function handleOverPayment(Request $request)
    {
        $userId = session('user_id');
        $lebih = session('overpaid_amount');

        if (!$lebih || !$userId) {
            return redirect()->route('user.payment.show')->with('error', 'No overpayment data found.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('user.store')->with('error', 'User not found. Please register again.');
        }

        if ($request->input('overpayment_action') === 'balance') {
            $user->payment_status = 'Paid';
            $user->coins += $lebih;
            $user->save();


            session()->forget(['user_id', 'overpaid_amount']);

            return redirect()->route('user.homepage')->with('success', 'Registration Successful');
        } else {
            return redirect()->route('user.payment.show')->with('warning', 'Please enter the correct payment amount');
        }
    }
}
