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
                    <p class="mb-4">  أدخل رقم الجوال لتسجيل الدخول المالك </p>
                    <form class="mb-3" action="{{ route('owner.login.redirect') }}" method="POST"> 
                        @csrf
                        <div class="d-flex border rounded text-start mb-3 overflow-hidden position-relative">
                            <input dir="ltr" type="tel" name="phone" id="phone" class="form-control bg-none border-0" placeholder="">
                            <input type="tel" name="countrycode" id="countrycode" class="form-control border-0 pe-0" value="965+" style="width: 14%; font-weight: 600;" readonly>
                        </div>
                        @error('phone')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @error('code')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input class="btn btn-primary w-100 mt-3" type="submit" value="المتابعة">
                    </form>
                    <a href="{{ route('owner.register') }}">إنشاء حساب مالك</a>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
    <div class="p-5 w-100"></div>
</div>
<!-- End Content -->

@endsection
