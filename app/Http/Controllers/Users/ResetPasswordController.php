<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidAuthorizationUserRequest;
use App\Http\Requests\ValidPasswordResetRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Display password reset request form.
     */
    public function formEmailPasswordReset()
    {
    
        return view('user.forgot-password');
    }

    /**
     * Send password reset link.
     */
    public function handlingEmailFormPasswordReset(Request $request)
    {

       $request->validate(['email' => 'required|string|email']);
 
        $status = Password::sendResetLink(
        $request->only('email'));
 
        return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }

     /**
     * Display password reset form.
     */
    public function formPasswordReset(string $token)
    {
    
       return view('user.reset-password', ['token' => $token]);
    }


    /**
     * Update password.
     */
    public function passwordReset(ValidPasswordResetRequest $validPasswordResetRequest)
    {

       $validPasswordResetRequest->validated();
 
        $status = Password::reset(
        $validPasswordResetRequest->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    }

}
