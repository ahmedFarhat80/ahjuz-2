<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Customer;
use App\Models\UserApiCode;
use Illuminate\Http\Request;
use App\Services\CodeService;
use App\Traits\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ThrottlesLogins;

    private $guard = 'sanctum';
    private $maxAttempts = 3;
    private $decayMinutes = 5;

    public function register(StoreCustomerRequest $request)
    {
        $user = Customer::create($request->validated());
        return response()->json(['message' => 'تم إنشاء المستخدم بنجاح', 'phone' => $user->phone], 200);
    }

    public function redirect(Request $request)
    {
        $validated = $request->validate(
            ['phone' =>  'required|digits:8'],
        );
    
        $user = Customer::findByPhoneNumber($validated['phone']);
    
        if (! $user) {
            return response()->json(['message' => 'لم يتم العثور على المستخدم', 'phone' => $validated['phone']], 404);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $this->incrementLoginAttempts($request);
        
        try {
            $code = CodeService::sendTo($user, true);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'phone'  => [ 'حدث خطأ ما يرجي المحاولة لاحقا']
            ]);
        }
    
        return response()->json(['message' => 'تم إرسال الرمز بنجاح'], 200); 
    }

    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'phone' =>  'required|digits:8',
                'code'  =>  'required',
            ]
        );

        $user = Customer::findByPhoneNumber($validated['phone']);
        
        if (! $user) {
            return response()->json(['message' => 'لم يتم العثور على المستخدم', 'phone' => $validated['phone']], 404);
        }

        if ($user->code()->value('code') != $validated['code']) {
            throw ValidationException::withMessages([
                'code'  => [ 'الرمز الذي أدخلته غير مطابق']
            ]);
        };
        
        $this->clearLoginAttempts($request);
        $user->code()->delete();

        return response()->json(['message' => 'تم تسجيل الدخول بنجاح', 'token' => $user->createToken('customer')->plainTextToken, 'user' => $user], 200); 
    }  

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح'], 200); 
    }    

    public function username()
    {
        return 'code';
    }
}
