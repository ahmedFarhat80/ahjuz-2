<?php

namespace App\Http\Controllers\Owner\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOwnerRequest;
use App\Models\Owner;
use App\Providers\RouteServiceProvider;
use App\Traits\Registerable;

class RegisterController extends Controller
{
    use Registerable;
    
    private $model = Owner::class;
    private $guard = 'owner';
    private $table = 'owners';
    private $redirectTo = RouteServiceProvider::OWNER_LOGIN_CODE;

    public function register(StoreOwnerRequest $request)
    {
        return $this->store($request->validated());
    }
}
