<?php

namespace App\Http\Controllers;
use App\Notifications\TwoFactorCodeNotification;

use Illuminate\Http\Request;

class TwoFactorCodeController extends Controller
{
    public function verify()
    {
        return view("auth.verify");
    }

    public function resend(Request $request) {
        auth()->user()->regenerateTwoFactorCode();
        auth()->user()->notify(new TwoFactorCodeNotification());

        return back()->with("success", "We have resend two factor authentication code");
    }

    public function verifyPost(Request $request) {
        $request->validate([
            "code" => "required",
        ]);

        $user = auth()->user();
        
        if ($user->two_factor_expires_at < now()) {
            return back()->with("error", "Authentication code has expired");
        }
        
        if ($user->two_factor_code !== $request->code) {
            return back()->with("error", "Wrong code");
        }

        $user->clearTwoFactorCode();

        return redirect()->route("dashboard")->with("success", "Two factor authentication code has been verified");
    }
}