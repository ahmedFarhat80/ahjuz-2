@extends('layouts.admin.app')
@section('content')

  @push('styles')
  <style>
    .swal2-container {
      z-index: 99999 !important;
    }
  </style>
  @endpush

  <!--begin::Card-->
  <div class="card">
    <!--begin::Card body-->
    <div class="card-body pt-6">

      <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
          <!--begin::Page title-->
          <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
              إعدادات أخرى
            </h1>
            <!--end::Title-->
          </div>
          <!--end::Page title-->
        </div>
        <!--end::Container-->
      </div>


            <!--begin::Card-->
            <div class="card pt-4 mb-6 mb-xl-9">
              <!--begin::Card header-->
              <div class="card-header border-0">
      
              </div>
              <!--end::Card header-->
              <!--begin::Card body-->
              <div class="card-body pt-0 pb-5">
                <form action="{{ route('admin.profile') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                    <div class="col-md-6 mb-10">
                      <label class="form-label"><a href="{{ auth_admin()->avatar }}">الصورة الشخصية</a></label>
                      <input type="file" name="avatar" class="form-control form-control-solid"/>
                      @error('avatar')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">الاسم</label>
                      <input type="text" name="name" value="{{ old('name') ?? auth_admin()->name }}" class="form-control form-control-solid"/>
                      @error('name')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">البريد الالكتروني</label>
                      <input type="email" name="email" value="{{ old('email') ?? auth_admin()->email }}" class="form-control form-control-solid"/>
                      @error('email')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    
                    <div class="col-md-6 mb-10">
                      <label class="form-label">رقم الهاتف</label>
                      <input type="phone" name="phone" value="{{ old('phone') ?? auth_admin()->phone }}" class="form-control form-control-solid"/>
                      @error('phone')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">كلمة المرور</label>
                      <input type="password" name="password" class="form-control form-control-solid"/>
                      @error('password')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          
                    <div class="col-md-6 mb-10">
                      <label class="form-label">إعادة كلمة المرور</label>
                      <input type="password" name="password_confirmation" class="form-control form-control-solid"/>
                      @error('password')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          
          
                    </div>
            
                  </div>
      
                    <button class="btn btn-primary">تحديث الحساب</button>
                </form>
              </div>
              
      
            </div>
                <!--end::Table-->
              </div>
              <!--end::Card body-->
            </div>
            <!--end::Card-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->

  @push('scripts')
  @endpush
  @endsection