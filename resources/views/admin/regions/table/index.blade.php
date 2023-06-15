@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.regions.table.breadcrumb')
  @include('admin.regions.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/regions/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/regions/delete.js') }}"></script>
@endpush