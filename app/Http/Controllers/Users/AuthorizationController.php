<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidAuthorizationUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{

    /**
     * Display login form.
     */
    public function login()
    {
        return view('user.login');
    }

    /**
     * Authorization user.
     */
    public function authorizationUser(ValidAuthorizationUserRequest $validAuthorizationUserRequest)
    {
        
        $credentials = $validAuthorizationUserRequest->validated();

        if (Auth::attempt($credentials, $validAuthorizationUserRequest->boolean('remember'))) {
            $validAuthorizationUserRequest->session()->regenerate();

            $user = Auth::user();
 
            return redirect()->route('user.dashboard', ['user' => $user]);
        }

        return back()->withErrors([
            'errorAuthorization' => 'Указанные учетные данные не соответствуют.',
        ]);
    }

    /**
     * Log user out.
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
