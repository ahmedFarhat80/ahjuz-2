<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\Traits\Loggable;
use App\Traits\ThrottlesLogins;

class LoginController extends Controller
{
    use Loggable, ThrottlesLogins;
    
    private $model = Customer::class;
    private $guard = 'customer';
    private $redirectTo = RouteServiceProvider::HOME;
    private $registerRoute = RouteServiceProvider::REGISTER;
    private $loginCodeRoute = RouteServiceProvider::LOGIN_CODE;
    private $maxAttempts = 3;
    private $decayMinutes = 5;
}
