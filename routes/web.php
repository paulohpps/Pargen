<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard/home');
    } else {
        return redirect('/login');
    }
});

Route::get('/logout' , function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');
