<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\otpsend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // public function sendResetLinkEmail(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
    //     }

    //     // Generate OTP
    //     $otp = rand(100000, 999999);

    //     // Save OTP and expiration time
    //     $user->otp_code = $otp;
    //     $user->otp_expires_at = Carbon::now()->addMinutes(10);
    //     $user->save();

    //     // Send OTP via email
    //     Mail::to($user->email)->send(new otpsend($otp));

    //     return back()->with('status', 'We have emailed your OTP code!');
    // }
}
