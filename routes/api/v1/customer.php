<?php

use App\Models\Ad;
use App\Enums\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Customer\Api\AuthController;
use App\Http\Controllers\Customer\Api\SearchController;
use App\Http\Controllers\Customer\Api\BookingController;
use App\Http\Controllers\Customer\Api\ContactController;
use App\Http\Controllers\Customer\Api\MessageController;
use App\Http\Controllers\Customer\Api\PaymentController;
use App\Http\Controllers\Customer\Api\ProfileController;
use App\Http\Controllers\Customer\Api\PropertyController;
use App\Http\Controllers\Customer\Api\GovernorateController;
use App\Http\Controllers\Customer\Api\LandingPageController;
use App\Http\Controllers\Customer\Api\NotificationController;
use App\Http\Controllers\Customer\Api\SpecialPropertiesController;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::get('/', [LandingPageController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login/redirect', [AuthController::class, 'redirect']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function() {
  
  Route::get('/home', [ProfileController::class, 'bookings']);
  Route::get('/profile', [ProfileController::class, 'show']);
  Route::post('/profile', [ProfileController::class, 'update']);
  Route::post('/fcm', [ProfileController::class, 'fcm_token']);

  Route::get('/properties/{property}/reviews', [PropertyController::class, 'reviews']);
  Route::post('/properties/{property}/reviews', [PropertyController::class, 'review']);
  Route::post('/properties/{property}/reviews/delete', [PropertyController::class, 'destroyReview']);

  Route::get('/properties/{property}/payment', [PaymentController::class, 'index']);
  Route::post('/properties/{property}/payment', [PaymentController::class, 'charge']);
  Route::get('/properties/{property}/payment/success', [PaymentController::class, 'success'])->name('api.v1.properties.payment.success');

  Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
  Route::get('/messages/properties/{property}/customers/{customer}', [MessageController::class, 'show'])->name('messages.show');
  Route::post('/messages/conversation/{conversation}', [MessageController::class, 'store'])->name('messages.store');
  
  Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

});

Route::get('/properties/{property}', [PropertyController::class, 'show']);

Route::get('special-properties', [SpecialPropertiesController::class, 'index']);

Route::post('/coupon', [BookingController::class, 'coupon']);

Route::get('/search', [SearchController::class, 'index']);
Route::get('/autocomplete-search', [SearchController::class, 'autocompleteSearch']);

Route::get('/types/{type}/properties', [SearchController::class, 'propertiesByType']);
Route::get('types', fn() => collect(PropertyType::getPluralDescriptions())->map(fn($v, $k) => ['id' => $k, 'value' => $v])->values());

Route::get('/governorates', [GovernorateController::class, 'index']);
Route::get('/governorates/{governorate}/regions', [GovernorateController::class, 'regions']);

Route::get('ads', fn() => Ad::all());

Route::post('/contact-us', [ContactController::class, 'store']);