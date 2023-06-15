@extends('layouts.admin.app')

@push('styles')
  <link href="{{ asset('admin-panel/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
  <style>.ltr_col {direction: ltr}</style>
  <style>
    table.dataTable > thead > tr > td:not(.sorting_disabled), table.dataTable > thead > tr > th:not(.sorting_disabled),
    table.dataTable > thead > tr > th:not(.sorting_disabled), table.dataTable > thead > tr > td:not(.sorting_disabled)
    {
      padding-right: 0.75rem !important;
    }
  </style>   
@endpush

@section('content')
    <!--begin::Card-->
    <div class="card">
      <!--begin::Card body-->
      <div class="card-body pt-6">

        @yield('table')

      </div>
      <!--end::Card body-->
  </div>
  <!--end::Card-->
@endsection

@push('scripts')
  <script src="{{ asset('admin-panel/plugins/custom/datatables/datatables.bundle.js') }}"></script>
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/ar_datatables.js') }}"></script>
@endpush