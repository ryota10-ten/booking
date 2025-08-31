<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;
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
Route::middleware(['auth:admins'])->group(function () {
    Route::get('/manager/register', [AdminController::class, 'register_show'])->name('manager_register.show');
    Route::post('/manager/register', [AdminController::class, 'register'])->name('manager_register');
    Route::get('/admin/thanks',[AdminController::class, 'done'])->name('admin.thanks');
    Route::get('/admin/announcement', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/admin/announcement', [AnnouncementController::class, 'send'])->name('announcement.send');
});

Route::middleware(['auth:managers'])->group(function () {
    Route::get('/manager/mypage', [ManagerController::class, 'manager_mypage'])->name('manager_page.show');
    Route::post('/manager/logout', [ManagerController::class, 'logout'])->name('manager.logout');
    Route::get('/manager/shop-all', [ManagerController::class, 'shop_all_show'])->name('shop_all_show');
    Route::get('/manager/shop-add', [ManagerController::class, 'shop_add_show'])->name('shop.add');
    Route::post('/manager/shop-add', [ManagerController::class, 'store'])->name('shop.store');
    Route::get('/manager/shop-edit/{id}', [ManagerController::class, 'shop_edit_show'])->name('shop.edit');
    Route::post('/manager/shop-edit/{id}', [ManagerController::class, 'update'])->name('shop.update');
});

Route::middleware(['auth:users'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
    Route::get('/mypage', [MyPageController::class, 'show'])->name('user.mypage');
    Route::get('/review/{id}',[ReviewController::class, 'show'])->name('restaurant.review');
    Route::post('/review/{id}',[ReviewController::class, 'review'])->name('form.review');
    Route::post('/booking/form',[ShopController::class, 'form'])->name('booking.store');
});

Route::middleware(['multi_auth:users,managers'])->group(function () {
    Route::get('/done/{id}', [HomeController::class, 'done'])->name('booking.done');
    Route::delete('/booking/delete', [MyPageController::class, 'destroy'])->name('booking.destroy');
    Route::get('/booking/detail/{id}',[BookController::class, 'show'])->name('booking.detail');
    Route::get('/booking/edit/{id}',[BookController::class, 'edit'])->name('booking.edit');
    Route::post('/booking/edit/{id}', [BookController::class, 'change'])->name('booking.change');
});


Route::get('/',[HomeController::class,'show'])->name('home');
Route::get('/search',[HomeController::class,'search'])->name('search');
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/thanks', [RegisterController::class, 'thanks'])->name('register.done');
Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.send');
Route::get('/detail/{id}',[ShopController::class, 'show'])->name('shop.detail');
Route::get('/admin/login', [AdminController::class, 'login_show'])->name('admin_login.show');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin_login');
Route::get('/manager/login', [ManagerController::class, 'manager_login_show'])->name('manager_login.show');
Route::post('/manager/login', [ManagerController::class, 'manager_login'])->name('manager_login');