@extends('layouts.customer.index')
@section('content')

<!-- Start Page -->
<div id="searchpage">

<div class="bar py-3 bg-primary text-white">
    <div class="container">
        <span> الرئيسية </span> <i class="fas fa-angle-left mx-2"></i> <span> اتصل بنا </span>
    </div>
</div>

<div class="container mt-5">
    <div class="aboutus">
        <div class="row align-items-center">
            <div class="col-md-5 col-12">
                <img src="{{ asset('frontend/img/contact.svg') }}" class="w-100">
            </div>
            <div class="col-md-7 col-12">
                <form action="{{ route('contact-us') }}" method="POST">
                    @csrf
                    <div class="row bg-white shadow rounded p-4">
                        <div class="col-12 mb-3">
                            <label for="name">الاسم</label>
                            <input name="name" value="{{ old('name') }}" type="text" class="w-100 form-control mt-1" placeholder="أدخل الاسم">
                            @error('name')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email">البريد الإلكتروني</label>
                            <input name="email" value="{{ old('email') }}" style="direction: ltr;text-align: end;" type="email" class="w-100 form-control mt-1" placeholder="أدخل البريد الإلكتروني">
                            @error('email')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="phone">رقم الهاتف</label>
                            <input name="phone" value="{{ old('phone') }}" type="text" class="w-100 form-control mt-1" placeholder="أدخل رقم الهاتف">
                            @error('phone')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <label for="details">الوصف</label>
                            <textarea name="details" class="form-control w-100 mt-1" style="height: 120px;">{{ old('details') }}</textarea>
                            @error('details')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-secondary w-100">أرسل</button>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Eng Page -->

@endsection
