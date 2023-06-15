@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.ads.table.breadcrumb')
  @include('admin.ads.table.create')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/ads/create.js') }}"></script>
  <script src="{{ asset('admin-panel/js/ehjiz/ads/delete.js') }}"></script>
@endpush