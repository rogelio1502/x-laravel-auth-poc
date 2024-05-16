<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/logout', function () {
    $authType = session()->get('auth_type');

    Auth::logout();

    if ($authType === 'google') {
        GoogleAuthController::logout();
    }

    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
})->name('logout');


Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('login.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::post('/auth/google/logout', [GoogleAuthController::class, 'logout'])->name('logout.google');
