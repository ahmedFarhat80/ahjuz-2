@extends('layouts.admin.app')

@push('styles')
<style>
  table.dataTable > thead > tr > td:not(.sorting_disabled), table.dataTable > thead > tr > th:not(.sorting_disabled),
  table.dataTable > thead > tr > th:not(.sorting_disabled), table.dataTable > thead > tr > td:not(.sorting_disabled)
  {
    padding-right: 0.75rem !important;
  }
</style>   

@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
    @include('admin.customers.details.breadcrumb')
  <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-xl-row">

        <!--begin::Sidebar-->
          @include('admin.customers.details.sidebar')
        <!--end::Sidebar-->

        <!--begin::Content-->
          @include('admin.customers.details.content')
        <!--end::Content-->
        
      </div>
      <!--end::Layout-->
      <!--begin::Modals-->

      @include('admin.customers.details.edit')

      <!--end::Modals-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Post-->
</div>



@endsection

@push('scripts')
  <script src="{{ asset('admin-panel/js/ehjiz/customers/edit.js') }}" defer></script>
@endpush