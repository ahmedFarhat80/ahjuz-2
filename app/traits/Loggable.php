<?php

namespace App\Traits;

use App\Services\CodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

trait Loggable
{
    public function __construct()
    {
        $this->middleware("guest:{$this->guard}")->except('logout');
    }

    public function showLoginForm()
    {
        return view("{$this->guard}.auth.login");
    }

    public function redirect(Request $request)
    {
        // check phone number:
        // if is exists send code and show login code form.
        // if not go to register form.   

        $validated = $request->validate(
            ['phone' =>  'required|digits:8'],
        );

        $user = $this->model::findByPhoneNumber($validated['phone']);

        if (! $user) {
            return redirect()->to($this->registerRoute)->withInput(['phone' => $validated['phone']]);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $this->incrementLoginAttempts($request);

        try {
            CodeService::sendTo($user);
        } catch (\Throwable $th) {
            return $this->sendFailedLoginResponse('phone', 'حدث خطأ ما يرجي المحاولة لاحقا');
        }

        return redirect()->to($this->loginCodeRoute); 
    }
    
    public function showLoginCodeForm()
    {
        if (!Session::get('login_code') || ! $phone = Session::get('login_code')['user']->phone) {
            return redirect()->to($this->redirectTo);
        }

        return view("{$this->guard}.auth.login-code", compact('phone'));
    }

    public function login(Request $request)
    {
        $login_code = Session::get('login_code');
        
        if ($login_code && $login_code['code'] == $request->code) {

            $this->guard()->login($login_code['user'], true);
            
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            Session::forget('login_code');

            if (get_segment(Session::get('url.intended')) == $this->guard) {
                return redirect()->intended($this->redirectTo);
            } elseif (! in_array(get_segment(Session::get('url.intended')), ['owner', 'admin'])) {
                return redirect()->intended($this->redirectTo);
            } else {
                return redirect($this->redirectTo);
            }
        };

        return $this->sendFailedLoginResponse();
    }

    public function logout(Request $request) {
        $this->guard()->logout();
        return $this->loggedOut($request) ?: redirect('/');
    }

    public function loggedOut(Request $request)
    {
        return redirect($this->redirectTo);
    }

    private function sendFailedLoginResponse($input = 'code', $message = 'الرمز الذي أدخلته غير مطابق')
    {
        throw ValidationException::withMessages([
            $input  => [ $message ],
        ]);
    }

    private function guard() 
    {
        return  Auth::guard($this->guard);
    }

    public function username()
    {
        return 'code';
    }
}
