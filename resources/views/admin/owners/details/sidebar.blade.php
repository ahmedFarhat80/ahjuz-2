<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
  <!--begin::Card-->
  <div class="card mb-5 mb-xl-8">
    <!--begin::Card body-->
    <div class="card-body pt-15">
      <!--begin::Summary-->
      <div class="d-flex flex-center flex-column mb-5">
        <!--begin::Avatar-->
        <div class="symbol symbol-100px symbol-circle mb-7">
          <img src="{{ $owner->avatar }}" alt="image">
        </div>
        <!--end::Avatar-->
        <!--begin::Name-->
        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-7">{{ $owner->full_name }}</a>
        <!--end::Name-->
        {{-- <!--begin::Position-->
        <div class="fs-5 fw-bold text-muted mb-6">Software Enginer</div>
        <!--end::Position--> --}}

        <!--begin::Info-->
        <div class="d-flex flex-wrap flex-center">
          <!--begin::Stats-->
          <div class="border border-success rounded py-3 px-3 mx-2 mb-3">
            <div class="fs-4 fw-bolder text-gray-700 text-center">
              <span class="w-75px">{{ number_format($owner->bookings_sum_subtotal_price - $owner->bookings_sum_discount) }}</span>
            </div>
            <div class="fw-bold text-muted">الإيرادات</div>
          </div>
          <!--end::Stats-->
          <!--begin::Stats-->
          <div class="border border-primary rounded py-3 px-3 mx-2 mb-3">
            <div class="fs-4 fw-bolder text-gray-700 text-center">
              <span class="w-50px">{{ $owner->bookings_count }}</span>
            </div>
            <div class="fw-bold text-muted">الحجوزات</div>
          </div>
          <!--end::Stats-->
          <!--begin::Stats-->
          <div class="border border-danger rounded py-3 px-3 mx-2 mb-3">
            <div class="fs-4 fw-bolder text-gray-700 text-center">
              <span class="w-50px">{{ $properties->total() }}</span>
            </div>
            <div class="fw-bold text-muted">الوحدات</div>
          </div>
          <!--end::Stats-->
        </div>
        <!--end::Info-->
      </div>
      <!--end::Summary-->

      
      <!--begin::Details toggle-->
      <div class="d-flex flex-stack fs-4 py-3">
        <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_owner_view_details" role="button" aria-expanded="false" aria-controls="kt_owner_view_details">
          التفاصيل
        <span class="ms-2 rotate-180">
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
          <span class="svg-icon svg-icon-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span></div>
        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="تعديل بيانات المالك">
          <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_owner">تعديل</a>
        </span>
      </div>
      <!--end::Details toggle-->
      <div class="separator separator-dashed my-3"></div>
      <!--begin::Details content-->
      <div id="kt_owner_view_details" class="collapse show">
        <div class="py-5 fs-6">
          <div class="fw-bolder mt-5">الرقم المعرف</div>
          <div class="text-gray-600">{{ $owner->id }}</div>

          <div class="fw-bolder mt-5">العنوان</div>
          <div class="text-gray-600" dir="ltr" style="text-align: right">{{ $owner->address }}</div>

          <div class="fw-bolder mt-5">رقم الهاتف</div>
          <div class="text-gray-600">&#x200E;{{ country_code($owner->phone) }}</div>
          
          <div class="fw-bolder mt-5">البريد الالكتروني</div>
          <div class="text-gray-600">
            <a href="#" class="text-gray-600 text-hover-primary text-end" dir="ltr">{{ $owner->email }}</a>
          </div>
        </div>
      </div>
      <!--end::Details content-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->
</div>
