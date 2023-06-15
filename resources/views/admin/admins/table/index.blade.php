@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.admins.table.breadcrumb')
  @include('admin.admins.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/admins/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/admins/delete.js') }}"></script>
@endpush