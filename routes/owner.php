<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\BookingController;
use App\Http\Controllers\Owner\MessageController;
use App\Http\Controllers\Owner\ProfileController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Owner\Auth\LoginController;
use App\Http\Controllers\Owner\NotificationController;
use App\Http\Controllers\Owner\Auth\RegisterController;

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

Route::get('/', [PropertyController::class, 'index'])->middleware('auth:owner')->name('home');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/redirect', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('/login/code-confirm', [LoginController::class, 'showLoginCodeForm'])->name('login.code');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:owner')->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth:owner')->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth:owner')->name('profile.update');

Route::group(['prefix' => 'properties', 'as' => 'properties.', 'middleware' => 'auth:owner'], function () {

  Route::get('{property}/bookings', [BookingController::class, 'index'])->name('bookings');
  Route::post('{property}/bookings/foreign', [BookingController::class, 'foreign'])->name('bookings.foreign');
  Route::delete('{property}/bookings/{booking}/foreign', [BookingController::class, 'destroyForeign'])->name('bookings.foreign.destroy');
  Route::post('img', [PropertyController::class, 'storeImg'])->name('img');
  Route::delete('img', [PropertyController::class, 'destroyImg'])->name('img');
  Route::get('terms', [PropertyController::class, 'terms'])->name('terms');
  Route::patch('{property}/is_active', [PropertyController::class, 'updateStatus'])->name('is_active');
  Route::post('terms', [PropertyController::class, 'agreeTerms'])->name('terms');
  Route::get('success', [PropertyController::class, 'success'])->name('success');
});

Route::resource('properties', PropertyController::class)->middleware('auth:owner')->except('index', 'show');

Route::get('/messages', [MessageController::class, 'index'])->middleware('auth:owner')->name('messages.index');
Route::get('/messages/{property}/{customer}', [MessageController::class, 'show'])->middleware('auth:owner')->name('messages.show');
Route::post('/messages/{conversation}', [MessageController::class, 'store'])->middleware('auth:owner')->name('messages.store');

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth:owner')->name('notifications.index');
