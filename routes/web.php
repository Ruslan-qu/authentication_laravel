<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\Users\DashboardUserController;
use App\Http\Controllers\Users\EmailVerificationController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('register', [UserController::class, 'create'])->name('register');

Route::post('register', [UserController::class, 'store'])->name('user.store');

Route::get('login', [AuthorizationController::class, 'login'])->name('login');

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


