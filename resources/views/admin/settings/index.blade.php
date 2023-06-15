@extends('layouts.admin.datatable')
@section('table')
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

              <!--begin::Card body-->
              <div class="card-body pt-0 pb-5">
                <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                    <h2 class="mb-7"><i class='fa fa-home me-2'></i>الصفحة الرئيسية</h2>
                    {{-- hero --}}

                    <div class="col-md-6 mb-10">
                      <label class="form-label"><a href="{{ $settings->hero_img }}">الصورة الرئيسية</a></label>
                      <input type="file" name="hero_img" class="form-control form-control-solid"/>
                      @error('hero_img')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    
                    <div class="col-md-6 mb-10">
                      <label class="form-label">النص الرئيسي</label>
                      <input type="text" name="main_headline" value="{{ old('main_headline') ?? $settings->main_headline }}" class="form-control form-control-solid"/>
                      @error('main_headline')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-12 mb-10">
                      <label class="form-label">النص الفرعي</label>
                      <textarea class="form-control form-control-solid" name="main_text">{{ old('main_text') ?? $settings->main_text  }}</textarea>
                      @error('main_text')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    {{-- mobile app --}}

                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط Play Store</label>
                      <input type="text" name="play_store" dir="ltr" value="{{ old('play_store') ?? $settings->play_store }}" class="form-control form-control-solid"/>
                      @error('play_store')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط Apple Store</label>
                      <input type="text" name="apple_store" dir="ltr" value="{{ old('apple_store') ?? $settings->apple_store }}" class="form-control form-control-solid"/>
                      @error('apple_store')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    
                    <div class="col-md-12 mb-10">
                      <label class="form-label">النص الرئيسي لتطبيقات الهاتف</label>
                      <input type="text" name="mobile_headline" value="{{ old('mobile_headline') ?? $settings->mobile_headline }}" class="form-control form-control-solid"/>
                      @error('mobile_headline')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-12 mb-10">
                      <label class="form-label">النص الفرعي  لتطبيقات الهاتف</label>
                      <textarea class="form-control form-control-solid" name="mobile_text">{{ old('mobile_text') ?? $settings->mobile_text  }}</textarea>
                      @error('mobile_text')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    {{-- social --}}

                    <div class="col-md-6 mb-10">
                      <label class="form-label">العنوان</label>
                      <input type="text" name="address" value="{{ old('address') ?? $settings->address }}" class="form-control form-control-solid"/>
                      @error('address')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">الهاتف</label>
                      <input type="text" name="phone" dir="ltr" value="{{ old('phone') ?? $settings->phone }}" class="form-control form-control-solid"/>
                      @error('phone')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          

                    <div class="col-md-6 mb-10">
                      <label class="form-label">واتساب1</label>
                      <input type="text" name="whatsapp_1" dir="ltr" value="{{ old('whatsapp_1') ?? $settings->whatsapp_1 }}" class="form-control form-control-solid"/>
                      @error('whatsapp_1')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          

                    <div class="col-md-6 mb-10">
                      <label class="form-label">واتساب2</label>
                      <input type="text" name="whatsapp_2" dir="ltr" value="{{ old('whatsapp_2') ?? $settings->whatsapp_2 }}" class="form-control form-control-solid"/>
                      @error('whatsapp_2')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">البريد الالكتروني</label>
                      <input type="email" name="email" dir="ltr" value="{{ old('email') ?? $settings->email }}" class="form-control form-control-solid"/>
                      @error('email')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    
                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط الفيسبوك</label>
                      <input type="text" name="facebook" dir="ltr" value="{{ old('facebook') ?? $settings->facebook }}" class="form-control form-control-solid"/>
                      @error('facebook')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط تويتر</label>
                      <input type="text" name="twitter"dir="ltr"  value="{{ old('twitter') ?? $settings->twitter }}" class="form-control form-control-solid"/>
                      @error('twitter')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          

                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط الانستغرام</label>
                      <input type="text" name="instagram" dir="ltr"  value="{{ old('instagram') ?? $settings->instagram }}" class="form-control form-control-solid"/>
                      @error('instagram')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          

                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط السناب شات</label>
                      <input type="text" name="snapchat" dir="ltr"  value="{{ old('snapchat') ?? $settings->snapchat }}" class="form-control form-control-solid"/>
                      @error('snapchat')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>    

                    <div class="col-md-6 mb-10">
                      <label class="form-label">رابط اليوتيوب</label>
                      <input type="text" name="youtube" dir="ltr" value="{{ old('youtube') ?? $settings->youtube }}" class="form-control form-control-solid"/>
                      @error('youtube')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>          

                    <div class="col-md-12 mb-10">
                      <label class="form-label">نص النهاية</label>
                      <textarea class="form-control form-control-solid" name="footer_text">{{ old('footer_text') ?? $settings->footer_text  }}</textarea>
                      @error('footer_text')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                    <h2 class="mb-7"><i class='fa fa-users me-2'></i>من نحن</h2>

                    <div class="col-md-12 mb-10">
                      <label class="form-label"><a href="{{ $settings->about_img }}">صورة من نحن</a></label>
                      <input type="file" name="about_img" class="form-control form-control-solid"/>
                      @error('about_img')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    
                    <div class="col-md-12 mb-10">
                      <label class="form-label">نص من نحن</label>
                      <textarea class="form-control form-control-solid" name="about_text">{{ old('about_text') ?? $settings->about_text  }}</textarea>
                      @error('about_text')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                  </div>
      
                    <button class="btn btn-primary">تحديث الإعدادات</button>
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