@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.owners.table.breadcrumb')
  @include('admin.owners.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/owners/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/owners/delete.js') }}"></script>
@endpush