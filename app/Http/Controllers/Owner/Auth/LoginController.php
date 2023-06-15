<?php

namespace App\Http\Controllers\Owner\Auth;

use App\Models\Owner;
use App\Traits\Loggable;
use App\Traits\ThrottlesLogins;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    use Loggable, ThrottlesLogins;

    private $model = Owner::class;
    private $guard = 'owner';
    private $redirectTo = RouteServiceProvider::OWNER;
    private $registerRoute = RouteServiceProvider::OWNER_REGISTER;
    private $loginCodeRoute = RouteServiceProvider::OWNER_LOGIN_CODE;
    private $maxAttempts = 3;
    private $decayMinutes = 5;
}
