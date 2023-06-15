@extends('layouts.admin.datatable')

@push('styles')
@endpush

@section('table')
  @include('admin.contacts.table.breadcrumb')

  {!! $dataTable->table() !!} 
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
  <script src="{{ asset('admin-panel/js/ehjiz/contacts/delete.js') }}"></script>
@endpush