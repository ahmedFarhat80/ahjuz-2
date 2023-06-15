<?php

use Illuminate\Support\Str;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Customer\SearchController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\ContactController;
use App\Http\Controllers\Customer\MessageController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\PropertyController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\LandingPageController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\Auth\RegisterController;

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

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page.index');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/redirect', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('/login/code-confirm', [LoginController::class, 'showLoginCodeForm'])->name('login.code');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:customer')->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::group(['middleware' => 'auth:customer'], function() {
    Route::get('/home', [ProfileController::class, 'bookings'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/properties/{property}/payment', [PaymentController::class, 'index'])->name('properties.payment');
    Route::post('/properties/{property}/payment', [PaymentController::class, 'charge'])->name('properties.payment');
    Route::get('/properties/{property}/payment/success', [PaymentController::class, 'success'])->name('properties.payment.success');
    
    Route::post('/properties/{property}/review', [PropertyController::class, 'review'])->name('properties.review');
    Route::delete('/properties/{property}/review', [PropertyController::class, 'destroyReview'])->name('properties.review.destroy');
    
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{property}/{customer}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show')->middleware('prevent-back-history');

Route::post('/properties/{property}/bookings/date', [BookingController::class, 'date'])->name('properties.bookings.date');
Route::post('/coupon', [BookingController::class, 'coupon'])->name('coupon');
Route::delete('/coupon', [BookingController::class, 'destroyCoupon'])->name('coupon');


Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/autocomplete-search', [SearchController::class, 'autocompleteSearch']);


Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactController::class, 'store']);

Route::view('/about-us', 'customer.about-us')->name('about-us');

Route::get('/governorates/{governorate}', [PropertyController::class, 'governorates'])->name('governorates');




Route::get('test', function () {
    Illuminate\Support\Facades\Artisan::call('storage:link');
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    Illuminate\Support\Facades\Artisan::call('config:clear');
});
// Auth::guard('admin')->loginUsingId(1);
// Auth::guard('owner')->loginUsingId(3);
// Auth::guard('customer')->loginUsingId(4);
