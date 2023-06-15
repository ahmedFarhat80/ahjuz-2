@extends('layouts.owner.index')
@section('content')

<!-- Start Content -->
<div class="add-chalet-page">
    <div class="container mt-5">

        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 text-center">
                <img src="{{ asset('frontend/img/confirm.svg') }}" class="w-100">
                <h5 class="fw-bold mt-3 mb-2"> تم إرسال بيانات الشاليه للإدارة </h5>
                <p class="text-muted mb-3">
                    هذا النص هو مثال لنص تجريبي يمكن أن يستبدل في أي وقت
                </p>
                <a class="btn btn-secondary mb-5" href="{{ route('landing-page.index') }}">
                    العودة للصفحة الرئيسية
                </a>
            </div>
            <div class="col-4"></div>
        </div>

    </div>
</div>
<!-- End Content -->

@endsection
