@extends('layouts.customer.index')
@section('content')

<!-- Start Content -->
<div class="loginpage">
    <div class="p-4 w-100"></div>
    <div class="container text-center pt-5 pb-5">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <h3 class="fw-bold mb-4 text-white"> <img src="{{ asset('frontend/img/logo.png') }}"style="height: 80px;"> </h3>
                <div class="login-box rounded bg-white border p-4 shadow-sm">
                    <p class="mb-4"> أدخل باقي البيانات لاستكمال التسجيل </p>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row text-end">
                            <div class="col-12 mb-2">
                                <label for="#"> الاسم الأول </label>
                                <input type="text" name="first_name" class="form-control my-2" placeholder="أدخل الاسم الأول" value="{{ old('first_name') }}">
                                @error('first_name')
                                <span class="invalid-feedback d-block" role="alert" style="font-size: 0.7em;margin-top: -8px">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror        
                            </div>
                            <div class="col-12 mb-2">
                                <label for="#"> اسم العائلة </label>
                                <input type="text" name="last_name" class="form-control my-2" placeholder="أدخل اسم العائلة" value="{{ old('last_name') }}">
                                @error('last_name')
                                <span class="invalid-feedback d-block" role="alert" style="font-size: 0.7em;margin-top: -8px">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror        
                            </div>
                            <div class="col-12 mb-2">
                                <label for="#"> العنوان </label>
                                <input type="text" name="address" class="form-control my-2" placeholder="أدخل عنوانك بالتفصيل" value="{{ old('address') }}">
                                @error('address')
                                <span class="invalid-feedback d-block" role="alert" style="font-size: 0.7em;margin-top: -8px">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror        

                            </div>
                            <div class="col-12 mb-2">
                                <label for="#"> رقم الهاتف (965+)</label>
                                <input type="text" name="phone" class="form-control my-2" placeholder="أدخل رقم هاتفك" value="{{ old('phone') }}">
                                @error('phone')
                                <span class="invalid-feedback d-block" role="alert" style="font-size: 0.7em;margin-top: -8px">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror        

                            </div>
                            <div class="col-12 mb-3">
                                <label for="#"> البريد الإلكتروني </label>
                                <input style="direction: ltr;text-align: end;" type="text" name="email" class="form-control my-2" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert" style="font-size: 0.7em;margin-top: -8px">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror        
                            </div>
                        </div>
                        <input class="btn btn-primary w-100" type="submit" value="المتابعة">      
                    </form>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
    <div class="p-5 w-100"></div>
</div>
<!-- End Content -->

@endsection