<?php

use App\Http\Controllers\Users\AuthorizationController;
use App\Http\Controllers\Users\DashboardUserController;
use App\Http\Controllers\Users\EmailVerificationController;
use App\Http\Controllers\Users\ResetPasswordController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('register', [UserController::class, 'create'])
->middleware('guest')->name('register');

Route::post('register', [UserController::class, 'store'])
->middleware('guest')->name('user.store');

Route::get('/forgot-password', [ResetPasswordController::class, 'formEmailPasswordReset'])
->middleware('guest')->name('password.request');

Route::post('/forgot-password', [ResetPasswordController::class, 'handlingEmailFormPasswordReset'])
->middleware(['guest', 'throttle:2,1'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'formPasswordReset'])
->middleware('guest')->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'passwordReset'])
->middleware('guest')->name('password.update');

Route::get('login', [AuthorizationController::class, 'login'])
->middleware('guest')->name('login');

Route::post('login', [AuthorizationController::class, 'authorizationUser'])
->middleware('guest')->name('authorization.user');

Route::get('logout', [AuthorizationController::class, 'logout'])
->middleware('auth')->name('logout');

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
->middleware(['auth', 'throttle:2,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/user/dashboard/{user}', [DashboardUserController::class, 'index'])
->middleware(['auth', 'verified'])->name('user.dashboard');


