@push('styles')
@endpush

@extends('layouts.admin.app')
@section('content')

  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
      @include('admin.dashboard.breadcrumb')
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-xxl">

        <div class="row gy-5 g-xl-10">
          <!--begin::Col-->
          <div class="col-sm-6 col-xl-2 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card bg-warning h-lg-100">
              <!--begin::Body-->
              <div class="card-body d-flex justify-content-between flex-column">
                <a href="{{ route('admin.commission') }}" class="text-end fs-8 text-light">تغيير العمولة</a>                
                <div class="d-flex flex-column my-7">
                  <!--begin::Number-->
                  <span class="fw-bold fs-4x lh-1 text-light">{{ $settings->commission }}%</span>
                  <!--end::Number-->
                  <!--begin::Follower-->
                  <span class="fw-bold fs-2 text-light">العمولة</span>
                  <!--end::Follower-->
                </div>
                <!--end::Section-->
              </div>
              <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
          </div>
          <!--end::Col-->
          @foreach ($sales as $sale)
          <!--begin::Col-->
          <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a  class="card bg-dark card-xl-stretch mb-5 mb-xl-8">
              <!--begin::Body-->
              <div class="card-body">
                <!--begin::Svg Icon | path: icons/duotune/graphs/gra005.svg-->
                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z" fill="black"></path>
                    <path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="black"></path>
                  </svg>
                </span>
                <!--end::Svg Icon-->
                <div class="text-inverse-success fw-bolder fs-2x mb-2 mt-5" style="direction: ltr;text-align: end;">  {{ number_format($sale['value']) }} KWD </div>
                <div class="fw-bold text-inverse-success fs-4">{{ $sale['name'] }}</div>
              </div>
              <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
          </div>
          <!--end::Col-->
          @endforeach

        </div>

        <div class="row g-5 g-xl-8">
          @foreach ($stats as $key => $value)
            <div class="col-xl-2">
              <!--begin::Statistics Widget 5-->
              <a  class="card bg-body hoverable card-xl-stretch mb-xl-8" style="cursor: auto">
                <!--begin::Body-->
                <div class="card-body">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                  <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
                      <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
                      <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
                      <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                  <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ $value }}</div>
                  <div class="fw-bold text-gray-400">{{ $key }}</div>
                </div>
                <!--end::Body-->
              </a>
              <!--end::Statistics Widget 5-->
            </div>
          @endforeach
        </div>
        
        @if ($bookings->isNotEmpty())
          <!--begin::Row-->
          <div class="row gy-5 g-xl-8">
            <!--begin::Col-->
            <div class="col-xl-12">
              <!--begin::Tables Widget 9-->
              <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5 align-items-center">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">اخر الحجوزات</span>
                  </h3>
                  <a href="{{ route('admin.bookings.index') }}">جميع الحجوزات</a>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                  <!--begin::Table container-->
                  <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                      <!--begin::Table head-->
                      <thead>
                        <tr class="fw-bolder text-muted">
                          <th class="min-w-100px">الرقم المعرف</th>
                          <th class="min-w-140px">اسم الوحدة</th>
                          <th class="min-w-140px">اسم الزبون</th>
                          <th class="min-w-120px">السعر الكلي</th>
                          <th class="min-w-120px">العمولة</th>
                          <th class="min-w-120px">وسيلة الدفع</th>
                          <th class="min-w-120px">يبدأ</th>
                          <th class="min-w-120px">ينتهي</th>
                          <th class="min-w-100px">منذ</th>
                        </tr>
                      </thead>
                      <!--end::Table head-->
                      <!--begin::Table body-->
                      <tbody>
                        @foreach ($bookings as $booking)
                          <tr class="border-top">
                            <td>
                              <a href="{{ route('admin.bookings.show', $booking->id ) }}">{{ $booking->id }}</a>
                            </td>
                            <td>
                              @if ($booking->property_id)
                                <a href="{{ route('admin.properties.show', $booking->property_id ) }}">{{ $booking->property->name }}</a>
                              @endif
                            </td>
                            <td>
                              @if ($booking->customer_id)
                                <a href="{{ route('admin.customers.destroy', $booking->customer_id ) }}">{{ $booking->customer->full_name }}</a>
                              @endif
                            </td>
                            <td>
                              {{ $booking->total_price }}
                            </td>
                            <td>
                              {{ $booking->commission }}
                            </td>
                            <td>
                              {{ $booking->payment_method->description }}
                            </td>
                            <td>
                              {{ date_ar($booking->starts_at) }}
                            </td>
                            <td>
                              {{ date_ar($booking->ends_at) }}
                            </td>
                            <td>
                              {{ $booking->created_at->diffForHumans() }}
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                      <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                  </div>
                  <!--end::Table container-->
                </div>
                <!--begin::Body-->
              </div>
              <!--end::Tables Widget 9-->
            </div>
            <!--end::Col-->
          </div>
          <!--end::Row-->
        @endif

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->
  </div>

@endsection

@push('scripts')
@endpush

