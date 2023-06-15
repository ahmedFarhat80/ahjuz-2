@extends('layouts.admin.app')

@push('styles')
@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
    @include('admin.coupons.details.breadcrumb')
  <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-lg-row">

        <!--begin::Content-->
        @include('admin.coupons.details.content')
        <!--end::Content-->

      </div>
      <!--end::Layout-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Post-->
</div>


@endsection

@push('scripts')
<script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
<script>
  flatpickr.localize(flatpickr.l10ns.ar);
  flatpickr.l10ns.default.firstDayOfWeek = 6; // Monday

  $(".kt_datepicker_1").flatpickr({
    "locale": "ar"
  });
  $(".kt_datepicker_2").flatpickr({
    "locale": "ar"
  });
</script>

@endpush