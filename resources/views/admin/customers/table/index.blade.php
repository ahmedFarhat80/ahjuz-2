@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.customers.table.breadcrumb')
  @include('admin.customers.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/customers/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/customers/delete.js') }}"></script>
@endpush