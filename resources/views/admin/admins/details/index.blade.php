@extends('layouts.admin.app')

@push('styles')

@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
    @include('admin.admins.details.breadcrumb')
  <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-xl-row">

        <!--begin::Sidebar-->
          @include('admin.admins.details.sidebar')
        <!--end::Sidebar-->

        <!--begin::Content-->
          @include('admin.admins.details.content')
        <!--end::Content-->
        
      </div>
      <!--end::Layout-->
      <!--begin::Modals-->

      @include('admin.admins.details.edit')

      <!--end::Modals-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Post-->
</div>

@endsection

@push('scripts')
  <script src="{{ asset('admin-panel/js/ehjiz/admins/edit.js') }}" defer></script>
@endpush