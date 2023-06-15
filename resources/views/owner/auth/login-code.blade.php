@extends('layouts.owner.index')
@section('content')

<!-- Start Content -->
<div class="loginpage">
    <div class="p-4 w-100"></div>
    <div class="container text-center pt-6 pb-6">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <h3 class="fw-bold mb-4 text-white"> <img src="{{ asset('frontend/img/logo.png') }}" style="height: 80px;"> </h3>
                <div class="login-box rounded bg-white border p-4 shadow-sm">
                    <p class="mb-4"> قم بإدخال الرمز المرسل إلى رقم الهاتف <span class="fw-bold" dir="ltr">{{ country_code($phone) }}</span> </p>
                    <form action="{{ route('owner.login') }}" method="POST">
                        @csrf
                        <div class="d-flex border rounded text-start mb-3 overflow-hidden position-relative">
                            <input dir="ltr" type="tel" name="code" id="phone" class="form-control bg-none border-0 text-center" placeholder="000000" style="letter-spacing: 12px;">
                        </div>
                        @error('code')
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <input class="btn btn-primary w-100 mt-3" type="submit" value="المتابعة">    
                    </form>

                    <p class="mt-3 p-0 m-0"> لم يصلك رمز ؟
                        <a class="text-primary" style="cursor: pointer;" onclick="document.getElementById('redirect').submit()"> إعادة الإرسال </a>
                    </p>
                    <form action="{{ route('owner.login.redirect') }}" method="POST" id="redirect">
                        @csrf
                        <input type="hidden" name="phone" value="{{ $phone }}">
                    </form> 

                </div>
            </div>
            <div class="col-4 "></div>
        </div>
    </div>
    <div class="p-5 w-100 "></div>
</div>
<!-- End Content -->

@endsection