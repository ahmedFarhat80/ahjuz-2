<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\NotificationController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:admin'], function ()
{
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
  
  Route::resource('admins', AdminController::class)->except('create', 'edit');
  Route::resource('customers', CustomerController::class)->except('create', 'edit');
  Route::resource('owners', OwnerController::class)->except('create', 'edit');
  
  Route::delete('properties/img', [PropertyController::class, 'destroyImg'])->name('properties.img');
  Route::resource('properties', PropertyController::class)->only('index', 'show', 'update', 'destroy');

  Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
  Route::resource('bookings', BookingController::class); 
  
  Route::resource('coupons', CouponController::class)->except('create', 'edit');

  Route::resource('governorates', GovernorateController::class)->except('create', 'edit');  
  
  Route::resource('regions', RegionController::class)->except('create', 'edit');

  Route::resource('ads', AdController::class)->except('create', 'edit');

  Route::resource('conversations', ConversationController::class)->only('index', 'show');
  
  Route::resource('contacts', ContactController::class)->only('index', 'show', 'destroy');

  Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

  Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings');
  Route::post('/settings', [SiteSettingController::class, 'update']);

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
  Route::post('/profile', [ProfileController::class, 'update']);

  Route::get('/commission', [CommissionController::class, 'index'])->name('commission');
  Route::post('/commission', [CommissionController::class, 'update']);
});

