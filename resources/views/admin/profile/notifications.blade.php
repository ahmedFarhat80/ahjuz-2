@extends('layouts.admin.app')

@push('styles')
<style>
    .new{
        border: 1px solid rgba(251, 167, 16, 0.45) !important;
        box-shadow: 0px 3px 10px rgb(251 167 16 / 32%) !important;
    }
</style>
@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
  <div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
      <!--begin::Page title-->
      <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">الإشعارات</h1>
        <!--end::Title-->
      </div>
      <!--end::Page title-->
    </div>
    <!--end::Container-->
  </div>
    <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="col-12">
            @if ($notifications->isNotEmpty())
                @foreach ($notifications as $notification)
                    @switch($notification->type)
                        @case('App\Notifications\PropertyIsCreatedNotification')
                                <a href="{{ route('admin.properties.show', $notification->data['property_id']) }}" style="color: #4f4f4f">
                                    <div class="notification-item bg-white  p-3 d-flex align-items-center rounded mb-3 @if(!$notification->read_at) new @else border  shadow-sm  @endif">
                                        <img src="{{ asset('frontend/img/asd.png') }}" style="width: 66px;">
                                        <div class="ms-3">
                                            <div class="text-gray-800 text-hover-primary fw-bold">طلب موافقة على وحدة جديدة</div>
                                        </div>
                                    </div>
                                </a>
                            @break
                    @endswitch
                @endforeach
            @else
                <div class="alert alert-danger my-4">لا يوجد أي إشعارات</div>
            @endif
        </div>
        <!--end::Content-->

      </div>
      <div class="d-flex flex-row-reverse my-5">{{ $notifications->links() }}</div>

      <!--end::Layout-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Post-->
</div>


@endsection