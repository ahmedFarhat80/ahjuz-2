@extends('layouts.admin.app')

@push('styles')
<style>
  thead > tr > td:not(.sorting_disabled), thead > tr > th:not(.sorting_disabled),
  thead > tr > th:not(.sorting_disabled), thead > tr > td:not(.sorting_disabled)
  {
    padding-right: 0.75rem !important;
  }
</style>   

@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
    @include('admin.owners.details.breadcrumb')
  <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-xl-row">

        <!--begin::Sidebar-->
          @include('admin.owners.details.sidebar')
        <!--end::Sidebar-->

        <!--begin::Content-->
          @include('admin.owners.details.content')
        <!--end::Content-->
        
      </div>
      <!--end::Layout-->
      <!--begin::Modals-->

      @include('admin.owners.details.edit')

      <!--end::Modals-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Post-->
</div>



@endsection

@push('scripts')
  <script src="{{ asset('admin-panel/js/ehjiz/owners/edit.js') }}" defer></script>
@endpush