@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.conversations.table.breadcrumb')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush