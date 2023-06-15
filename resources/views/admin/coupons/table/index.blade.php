@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.coupons.table.breadcrumb')
  @include('admin.coupons.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/coupons/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/coupons/delete.js') }}"></script>
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