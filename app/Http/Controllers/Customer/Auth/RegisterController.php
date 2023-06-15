<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\Traits\Registerable;

class RegisterController extends Controller
{
    use Registerable;
    
    private $model = Customer::class;
    private $guard = 'customer';
    private $table = 'customers';
    private $redirectTo = RouteServiceProvider::LOGIN_CODE;

    public function register(StoreCustomerRequest $request)
    {
        return $this->store($request->validated());
    }
}
