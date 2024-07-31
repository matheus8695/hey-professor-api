<?php
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

Route::post('login', Auth\LoginController::class)->name('login');
Route::post('register', Auth\RegisterController::class)->name('register');

Route::post('logout', Auth\LogoutController::class)
    ->middleware(['auth'])
    ->name('logout');
