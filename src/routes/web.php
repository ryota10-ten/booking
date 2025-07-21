<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VerificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class,'show'])->name('home');
Route::get('/search',[HomeController::class,'search'])->name('search');
Route::get('/thanks',[HomeController::class, 'done'])->name('booking.done');

Route::post('/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.send');

Route::get('/mypage', [MyPageController::class, 'show'])->name('user.mypage');
Route::delete('/booking/delete', [MyPageController::class, 'destroy'])->name('booking.destroy');

Route::get('/detail/{id}',[ShopController::class, 'show'])->name('shop.detail');
Route::post('/booking/form',[ShopController::class, 'form'])->name('booking.store');
