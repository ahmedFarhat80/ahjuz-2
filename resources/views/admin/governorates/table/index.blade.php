@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.governorates.table.breadcrumb')
  @include('admin.governorates.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/governorates/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/governorates/delete.js') }}"></script>
@endpush