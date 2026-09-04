<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    /**
     * The Email Verification Notice.
     */
    public function notice()
    {
        return view('user.verify-email');
    }

    /**
     * The Email Verification Handler.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = Auth::user();
 
        return redirect()->route('user.dashboard', ['user' => $user]);
    }

    /**
     * Resending the Verification Email.
     */
    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('status', 'Ссылка для подтверждения отправлена!');
    }
}
