@extends('layouts.customer.index')
@section('content')
<!-- Start Page -->
<div id="searchpage">

    <div class="bar py-3 bg-primary text-white">
        <div class="container">
            <span> الرئيسية </span> <i class="fas fa-angle-left mx-2"></i> <span> من نحن </span>
        </div>
    </div>

    <div class="container my-5">
        <div class="aboutus">
            <div class="row d-flex align-items-center px-2 py-5">
                <div class="col-md-5 col-12">
                    <img src="{{ $settings->about_img }}" class="w-100">
                </div>
                <div class="col-md-7 col-12 p-md-5 p-md-1 p-2 mt-3">
                    <h2 class="fw-bold mb-3"> من نحن </h2>
                    <p>
                        {{ $settings->about_text }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Eng Page -->
@endsection