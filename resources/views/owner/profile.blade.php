@extends('layouts.owner.index')
@section('content')

<!-- Start Page -->
<div id="mybookings">
    <div class="container">
        <h4 class="mt-5 fw-bold mb-4"> ملفي الشخصي </h4>
        <div class="row">
            <div class="col-12">
                <div class="profile-box bg-light shadow-sm p-4 border rounded mb-5">
                    <form action="{{ route('owner.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                                <div class="col-md-2 col-12 p-3 user_avatar">
                                    <img src="{{ auth_owner()->avatar }}" class="w-100 rounded" style="height: 180px">
                                    @error('file')
                                        <span class="invalid-feedback d-block mt-1 mb-5" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <button class="btn btn-primary w-100 mt-2" onclick="event.preventDefault(); document.getElementsByName('avatar')[0].click()">
                                        <i class="fas fa-upload"></i> تعديل الصورة
                                    </button>
                                    <input type="file" name="avatar" value="{{ auth_owner()->avatar }}" class="d-none" onchange="readURL(this)">
                                </div>
                                <div class="col-md-10 col-12 pt-3">
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-4">
                                            <label for="#"> الاسم الأول </label>
                                            <input type="text" class="form-control mt-1 bg-white shadow-sm" name="first_name" value="{{ old('first_name') ?? auth_owner()->first_name }}" style="font-weight: 500;">
                                            @error('first_name')
                                                <span class="invalid-feedback d-block mt-1 mb-5" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mb-4">
                                            <label for="#"> اسم العائلة </label>
                                            <input type="text" class="form-control mt-1 bg-white shadow-sm" name="last_name" value="{{ old('last_name') ?? auth_owner()->last_name }}" style="font-weight: 500;">
                                            @error('last_name')
                                                <span class="invalid-feedback d-block mt-1 mb-5" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mb-4">
                                            <label for="#"> البريد الإلكتروني </label>
                                            <input  type="text" class="form-control mt-1 bg-white shadow-sm" name="email" value="{{ old('email') ?? auth_owner()->email }}" style="font-weight: 500;direction: ltr;text-align: end;">
                                            @error('email')
                                                <span class="invalid-feedback d-block mt-1 mb-5" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mb-4">
                                            <label for="#"> رقم الهاتف </label>
                                            <div class="d-flex shadow-sm mt-1 text-start overflow-hidden position-relative" style="border: 1px solid #bdbdbd; border-radius: 0.25rem;">
                                                <input dir="ltr" type="tel" name="phone" id="phone" class="form-control border-0 bg-none" placeholder="" value="{{ old('phone') ?? auth_owner()->phone }}">
                                                <input type="tel" name="countrycode" id="countrycode" class="form-control border-0 bg-none pe-0" value="965+" style="width: 10.5%; font-weight: 600;" readonly>
                                            </div>
                                            @error('phone')
                                                <span class="invalid-feedback d-block mt-1 mb-5" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-4">
                                            <label for="#"> العنوان </label>
                                            <input type="text" class="form-control mt-1 bg-white shadow-sm" name="address" value="{{ old('address') ?? auth_owner()->address }}" style="font-weight: 500;">
                                            @error('address')
                                                <span class="invalid-feedback d-block mt-1" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-12"></div>
                                        <div class="col-md-4 col-12">
                                            <input type="submit" class="btn text-white w-100 bg-secondary" value="حفظ" style="font-weight: 500;">
                                        </div>
                                        <div class="col-md-4 col-12"></div>
                                    </div>
                                </div>    
                        </div>
                </form>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- Eng Page -->

@endsection

@push('scripts')
<script>
    $(".des-item").click(function() {
        $(this).next('.des-item-content').toggle();
        $(this).find('.fas').toggleClass('fa-angle-up');
        $(this).find('.fas').toggleClass('fa-angle-down');
    });

    function readURL(input){
        if (input.files) {
            Array.from(input.files).forEach(function (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).siblings('img').attr('src', `${e.target.result}`)
                };
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endpush