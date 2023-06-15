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
              العمولة
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
                <form action="{{ route('admin.commission') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-2 mb-10">
                      <label class="form-label">نسبة العمولة</label>
                      <input type="number" name="commission" min="0" max="100" value="{{ old('commission') ?? $settings->commission }}" style="direction: rtl;" class="form-control form-control-solid"/>
                      @error('commission')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                    <button class="btn btn-primary">تحديث العمولة</button>
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