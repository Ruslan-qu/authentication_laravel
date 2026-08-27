<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
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
    public function AuthorizationUser(Request $request)
    {
        dd($request->all());
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
