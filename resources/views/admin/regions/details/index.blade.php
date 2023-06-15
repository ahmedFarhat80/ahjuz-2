@extends('layouts.admin.app')

@push('styles')
@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
    @include('admin.regions.details.breadcrumb')
  <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-lg-row">

        <!--begin::Content-->
        @include('admin.regions.details.content')
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

@endpush