<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{

    /**
     * Authorization user.
     */
    public function login()
    {
        return view('user.login');
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
