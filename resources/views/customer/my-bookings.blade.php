@extends('layouts.customer.index')
@push('styles')
    <style>
        .col-12 .chalet-item {height: 320px !important}
        .my-rating polygon[class*="svg-active-"] {fill: #3550bd!important;}
    </style>
@endpush
@section('content')

<!-- Start Page -->
<div id="mybookings">
    <div class="container">
        <h4 class="mt-5 fw-bold mb-4"> حجوزاتي </h4>
        <div class="row">
            @if (auth_customer()->bookings->isNotEmpty())
                @foreach (auth_customer()->bookings->sortBy('starts_at') as $booking)

                    <div class="col-12 mb-4">
                            <div class="chalet-item rounded bg-white text-end">
                                <div class="img position-relative">
                                    @if ($booking->property_id)
                                        @if ($booking->property->is_special->is(PropertyIsSpecial::Yes))
                                            <span class="position-absolute text-white" style="right: 0; top: 13px; z-index: 10000; background-color: #fba710; padding: 3px 11px; font-size: 14px;">
                                                هذه الوحدة مميزة
                                            </span>
                                        @endif
                                        <span class="position-absolute rounded text-white" style="left: 13px; top: 13px; z-index: 10000; background-color: rgba(0, 0, 0, 0.4); padding: 3px 11px; font-size: 14px;">
                                            <i class="fas fa-eye ms-1"></i> {{ views($booking->property)->remember(12*60)->count() }}
                                        </span>
                                        <div id="img{{ $booking->property_id }}" class="carousel slide" data-mdb-ride="carousel">
                                            <div class="carousel-indicators">
                                                @foreach ($booking->property->imgs->take(5) as $key => $img)
                                                    <button type="button" data-mdb-target="#img{{ $booking->property_id }}" data-mdb-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}"></button>
                                                @endforeach
                                                </div>
                                            <div class="carousel-inner">
                                                @foreach ($booking->property->imgs->take(5) as $key => $img)
                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                        <img src="{{ $img->name }}" class="d-block w-100" alt="{{ $booking->property->name }}" />                        
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-mdb-target="#img{{ $booking->property_id }}" data-mdb-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-mdb-target="#img{{ $booking->property_id }}" data-mdb-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="content pt-4 pb-4 ps-3 pe-3 text-dark">
                                    @if ($booking->property_id)

                                        @can('review', $booking)

                                            <button type="button" class="btn btn-link p-1" data-mdb-toggle="modal" data-mdb-target="#modal{{ $booking->property_id }}">
                                                تقييم الوحدة
                                            </button>
                                        
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal{{ $booking->property_id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">مراجعة {{ $booking->property->name }}</h5>
                                                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <div class="contact_form_container">
                                                            <!-- Modal -->
                                                            <div class="text-left">
                                                                <div data-rate="{{ $booking->property_id }}" class="my-rating"></div>
                                                                <div class="mt-3 your_rating d-flex align-items-center" style="">
                                                                </div>
                                                            </div>
                                        
                                                            <form action='{{ route('properties.review', $booking->property_id) }}' method="POST" class="review_form"> @csrf
                                                                <div class="contact_form_text mb-2">
                                                                    <input data-rate="{{ $booking->property_id }}"  type="hidden" name="rating" value="">
                                                                    <textarea class="form-control mt-2" data-review="{{ $booking->property_id }}" name="body" rows="4" placeholder="أكتب مراجعتك" required="required"></textarea>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" data-delete-review="{{ $booking->property_id }}" class="btn btn-danger" onclick="destroy(event)" 
                                                        formaction="{{ route('properties.review', $booking->property_id) }}" style="display:none">حذف المراجعة</button>
                                                    <button type="button" class="btn btn-primary" onclick="storeReview(event, {{ $booking->property_id }})">حفظ المراجعة</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                        @endcan
                                        
                                        <h4 class="fw-bold"><a style="color:inherit" href="{{ route('properties.show', $booking->property->slug) }}">{{ $booking->property->name }}</a></h4>
                                        <h6 class="text-muted d-block mt-3 mb-3"> كود الوحدة : <span> ({{ $booking->property->code }}) </span> </h6>
                                        <h6 class="text-muted mt-3 mb-3"> <i class="fas fa-map-marker-alt ms-2"></i> {{ $booking->property->gov_reg }} </h6>
                                    @endif
                                    <h6 class="text-muted d-block mt-3 mb-3"> الحالة : {{ $booking->status->description }}</span> </h6>
                                    <h4 class="text-primary mb-3"> {{ $booking->total_price }} د.ك </h4>
                                    <h6 class="mt-3"> الحجز من <span class="fw-bold">{{ $booking->starts_at->format('Y/m/d') }}</span> إلى <span class="fw-bold">{{ $booking->ends_at->format('Y/m/d') }}</span> </h6>
                                    @if ($booking->property_id)
                                        <a class="btn btn-link p-2" href="{{ route('messages.show', [$booking->property_id, $booking->customer_id]) }}">تواصل مع المالك</a>                                                                       
                                    @endif
                            </div>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="alert alert-danger my-5">
                    لا يوجد لك أي حجوزات.
                </div>
            @endif
        
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

<script>

    var bookings = @json(auth_customer()->bookings);
    var reviews = @json($reviews);
    Object.values(bookings).forEach(function (booking) { 
        if (booking.property_id) {
            $(`[data-rate=${booking.property_id}]`).starRating({
                starSize: 22,
                disableAfterRate: false,
                initialRating: 0,
                ratedColor: '#3550bd',
                useFullStars: true,
                callback: function(currentRating, $el) {
                    var ratingInput = $el.parent().siblings().find('input[name="rating"]');
                    ratingInput.val(currentRating)
                }
            }) 
        }
    })
    Object.values(reviews).forEach(function (review) { 
        if (review.rating) {
            $(`[data-rate=${review.property_id}]`).starRating('setRating', review.rating)
            $(`input[data-rate=${review.property_id}]`).val(review.rating)
            $(`[data-review=${review.property_id}]`).text(review.body)
            $(`[data-delete-review=${review.property_id}]`).show()
            $(`[data-mdb-target='#modal${review.property_id}']`).html(`<i class="fas fa-star ms-2"></i>${review.rating}`)
        }
    })
</script>

<script>
    function storeReview(event, property_id) {
        event.preventDefault();
        var form = $(event.target).parent().parent().find('.review_form');
        var ratingInput = form.find('input[name="rating"]');
        var bodyInput = form.find('textarea[name="body"]');
        var rating = ratingInput.val();
        var body = bodyInput.val();
        $.ajax({
            url: form.attr('action'),
            type:'POST',
            dataType:"json",
            data: {"_token": "{{  csrf_token() }}", 'rating': rating, 'body': body},
            success:function(data) { 
                if (data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: data.success
                    })
                    $(`[data-mdb-target='#modal${property_id}']`).html(`<i class="fas fa-star ms-2"></i>${rating}`)
                    $('.modal').modal('hide')
                }
            },
            error:function(data) { 
                if (error = Object.values(data.responseJSON.errors)[0][0]) {
                    Toast.fire({
                        icon: 'error',
                        title: error
                    })
                }
            },
        });
    }
</script>

@endpush