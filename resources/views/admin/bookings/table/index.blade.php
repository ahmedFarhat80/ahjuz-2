@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.bookings.table.breadcrumb')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/bookings/delete.js') }}"></script>
@endpush