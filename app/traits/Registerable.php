<?php

namespace App\Traits;

use App\Services\CodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait Registerable
{
    public function __construct()
    {
        $this->middleware("guest:{$this->guard}");
    }

    public function showRegistrationForm()
    {
        return view("{$this->guard}.auth.register");
    }

    public function store($data)
    {
        $user = $this->model::create($data);

        try {
            CodeService::sendTo($user);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'phone'  => [ 'حدث خطأ ما يرجي المحاولة لاحقا' ],
            ]);
        }

        return redirect()->to($this->redirectTo)->withInput(['phone' => $data['phone']]);
    }

    private function guard()
    {
        return  Auth::guard($this->guard);
    }
}
