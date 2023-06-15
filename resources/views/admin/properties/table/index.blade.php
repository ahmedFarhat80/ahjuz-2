@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.properties.table.breadcrumb')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/properties/delete.js') }}"></script>
@endpush