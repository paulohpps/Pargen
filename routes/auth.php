<?php
use App\Http\Controllers\Home\LoginController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login' , [LoginController::class , 'index'])->middleware(RedirectIfAuthenticated::class)->name('login');
Route::post('/login' , [LoginController::class , 'login'])->middleware(RedirectIfAuthenticated::class)->name('logar');

Route::get('/logout' , function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');
