@extends('layouts.owner.index')
@section('content')

<!-- Start Page -->
<div id="notifications">
    <div class="container">
        <h4 class="mt-5 fw-bold mb-4"> الإشعارات </h4>
        <div class="row">
            <div class="col-12">
                @if ($notifications->isNotEmpty())
                    @foreach ($notifications as $notification)
                        @switch($notification->type)
                            @case('App\Notifications\PropertyStatusNotification')
                                    <a href="{{ route('owner.home') }}" style="color: #4f4f4f">
                                        <div class="notification-item @if(!$notification->read_at) new @endif bg-white border p-3 d-flex align-items-center rounded shadow-sm mb-3">
                                            <img src="{{ asset('frontend/img/asd.png') }}" style="width: 66px;">
                                            <div class="me-3">
                                                <h6 class="fw-bold"> تم {{ $notification->data['status'] }} الوحدة الخاصة بك </h6>
                                            </div>
                                        </div>
                                    </a>
                                @break
                            @case('App\Notifications\BookingIsCreatedNotification')
                                    <a href="{{ route('owner.properties.bookings', $notification->data['property_id']) }}" style="color: #4f4f4f">
                                        <div class="notification-item @if(!$notification->read_at) new @endif bg-white border p-3 d-flex align-items-center rounded shadow-sm mb-3">
                                            <img src="{{ asset('frontend/img/asd.png') }}" style="width: 66px;">
                                            <div class="me-3">
                                                <h6 class="fw-bold">يوجد لديك حجز جديد</h6>
                                            </div>
                                        </div>
                                    </a>
                                @break
                            @case('App\Notifications\BookingIsCanceledNotification')
                                    <a href="{{ route('owner.properties.bookings', $notification->data['property_id']) }}" style="color: #4f4f4f">
                                        <div class="notification-item @if(!$notification->read_at) new @endif bg-white border p-3 d-flex align-items-center rounded shadow-sm mb-3">
                                            <img src="{{ asset('frontend/img/asd.png') }}" style="width: 66px;">
                                            <div class="me-3">
                                                <h6 class="fw-bold">تم إلغاء حجز لديك</h6>
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
            <div class="d-flex flex-row-reverse my-5">{{ $notifications->links() }}</div>
        </div>
    </div>
</div>
<!-- Eng Page -->

@endsection

@push('scripts')
<script>
    $(".des-item").click(function() {
        $(this).next('.des-item-content').toggle();
        $(this).find('.fas').toggleClass('fa-angle-up');
        $(this).find('.fas').toggleClass('fa-angle-down');
    });
</script>
@endpush