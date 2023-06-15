@extends('layouts.customer.index')
@push('styles')
<style>
    .social-btn-sp #social-links ul {
        margin: 0 auto;
        padding-left: 5px;
        padding-right: 5px;
        max-width: 500px;
    }
    .social-btn-sp #social-links {
        margin: 0 auto;
        max-width: 500px;
    }
    .social-btn-sp #social-links ul li {
        display: inline-block;
    }          
    .social-btn-sp #social-links ul li a {
        /* padding: 5px; */
        margin-right: 10px;
        font-size: 30px;
        color: #fbfbfb;

    }
    table #social-links{
        display: inline-table;
    }
    table #social-links ul li{
        display: inline;
    }
    table #social-links ul li a{
        /* padding: 5px; */
        border: 1px solid #ccc;
        margin: 1px;
        font-size: 15px;
        background: #e3e3ea;
    }
</style>

@endpush
@section('content')

<!-- Start Page -->
<div id="chalet ">
<div class="bar py-3 bg-primary text-white mb-3">
    <div class="container">
        <span> الرئيسية </span> <i class="fas fa-angle-left mx-2"></i> <span> {{ $property->name }} </span>
    </div>
</div>

<div class="container ">

    <div class="images d-flex position-relative mb-3" style="height: 524px">
        <div class="w-100 position-relative text-center">
            <img src="{{ $property->imgs[0]->name }}" class="w-100" alt="{{ $property->name }}" style="height: 100%; object-fit: cover">
        </div>
        <div class="w-50">
            <img src="{{ $property->imgs[1]->name }}" class="w-100 " alt="{{ $property->name }}" style="height: 50%; object-fit: cover">
            <img src="{{ $property->imgs[2]->name }}" class="w-100 " alt="{{ $property->name }}" style="height: 50%; object-fit: cover">
        </div>
        <div class="w-50">
            <img src="{{ $property->imgs[3]->name }}" class="w-100" alt="{{ $property->name }}" style="height: 50%; object-fit: cover">
            <img src="{{ $property->imgs[4]->name }}" class="w-100 " alt="{{ $property->name }}" style="height: 50%; object-fit: cover">
        </div>
        <div class="position-absolute social-btn-sp" style="left: 18px; bottom: 10px;">
            {!! $shareComponent !!}
        </div>
        <button type="button" class="btn btn-light py-2 px-3 position-absolute" data-mdb-toggle="modal" data-mdb-target="#staticBackdrop" style="right: 18px; bottom: 16px;"> <i class="fas fa-image mx-1"></i> عرض كل الصور </button>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-8 col-12 mb-3">
                <h4 style="font-size: 24px; font-weight: 500; "> {{ $property->name }} </h4>
                <p class="p-0 text-muted " style="font-weight: 500; font-size: 18x; color: #848484; "> كود الوحدة ({{ $property->code }}) </p>
                <div class="row mb-4">
                    <div class="col-6">
                        <i class="fas fa-star text-warning ms-1 "></i> <span class="fw-bold ">{{ number_format($property->reviews_avg_rating, 1) }}</span> <span class="fw-normal text-muted "> ({{ $reviews->total() }}) تقييم </span>
                        <div class="my-1 "></div>
                        <i class="fas fa-map-marker text-muted ms-1 "></i> <span class="fw-normal text-muted "> {{ $property->gov_reg }} </span>
                    </div>
                    <div class="col-6 ">
                        <i class="fas fa-house text-muted ms-1 "></i> <span class="fw-normal text-muted "> مساحة الوحدة </span> <span class="fw-normal text-muted "> {{ $property->area }} م2 </span>
                        <div class="my-1 "></div>
                        <i class="fas fa-users text-muted ms-1 "></i> <span class="fw-normal text-muted "> مخصص {{ $property->for->description }} </span>
                    </div>
                    <div class="col-6 ">
                        <i class="fas fa-road text-muted ms-1 "></i> <span class="fw-normal text-muted "> {{ $property->address->details }} </span>
                    </div>
                </div>

                <h5 class="text-secondary title "> وصف الوحدة </h5>
                <hr style="width: 62px; height: 1.5px; color: #FBA710; opacity: 1; " class="mt-0 mb-3 ">
                <p style="font-weight: 500; font-size: 16px; color:#848484; ">
                    {{ $property->description }}
                </p>

                <div class="tabs border rounded mt-4 mb-4">
                    <!-- Tabs navs -->
                    <ul class="nav pe-0 nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="ex3-tab-2" data-mdb-toggle="tab" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false"> التقييمات </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex3-tab-3" data-mdb-toggle="tab" href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false">الخريطة</a>
                        </li>
                    </ul>
                    <!-- Tabs navs -->

                    <!-- Tabs content -->
                    <div class="tab-content p-3" id="ex2-content">


                        <div class="tab-pane fade show active position-relative" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">

                                <div id="reviews">

                                    @include('customer.property.reviews')
                                    
                                </div>

                                <div class="spinner spinner-border text-primary position-absolute" style="left: 50%;top:35%;width: 3rem;height: 3rem;display: none;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>

                        <div class="tab-pane fade" id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <input name="latitude" type="hidden" id="latitude" required value="{{ $property->address->latitude }}">
                                            <input name="longitude" type="hidden" id="longitude" required value="{{ $property->address->longitude }}">
                                        </div>
                                    </div>
                                </div>
                                <div id="map" style="height:500px"></div>
                            </div>                        
                        </div>
                        
                    </div>
                    <!-- Tabs content -->
                </div>
            </div>

            @include('customer.property.booking')

        </div>
    </div>
</div>
</div>
<!-- Eng Page -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> صور الوحدة </h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Carousel wrapper -->
            <div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    @foreach ($property->imgs as $key => $img)
                        <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}"></button>
                    @endforeach
                </div>

                <!-- Inner -->
                <div class="carousel-inner">

                    @foreach ($property->imgs as $key => $img)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ $img->name }}" class="d-block w-100" alt="{{ $property->name }}" style="height: 500px; object-fit: cover" />                        
                        </div>
                    @endforeach

                </div>
                <!-- Inner -->

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
            <!-- Carousel wrapper -->
        </div>
    </div>
</div>
</div>

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
    var reviews = @json($reviews->items());
    console.log(reviews);
    Object.values(reviews).forEach(function (review) { 
        if (review.rating) {
            $(`[data-rate=${review.customer_id}]`).starRating({
                starSize: 15,
                readOnly: true,
                initialRating: review.rating,
                ratedColor: '#3550bd',
            });
        }
    })
</script>

<script>
    $(document).on('click', '.reviews_pagination a', function(e) {
        e.preventDefault();
        newReviews($(this).attr('href'))
    });

    function newReviews(href, spinner = '.spinner') {
        $.ajax({
            url: href,
            type:"GET",
            dataType:"json",
            success: function(data) {
                var el = $('#reviews');
                el.fadeOut(200, function () {

                    el.html(data.reviews);
                    data.newReviews.data.forEach(function (review) {
                        if (!!parseFloat(`${review.rating}`)) {
                            $(`[data-rate=${review.customer_id}]`).starRating({
                                starSize: 15,
                                readOnly: true,
                                initialRating: review.rating,
                                ratedColor: '#3550bd',
                            });
                        }
                    })
                    $('.reviews_pagination').html(data.pagination);
                    $('#reviews').css('opacity', '1');

                }).fadeIn(200);
            },
            beforeSend: function() {
                $('#reviews').css('opacity', '0.5');
                $(spinner).css('display', 'block');
            },
            complete: function() {
                $(spinner).css('display', 'none');
            },
        });
    }
</script>

<script>
    function initAutocomplete() {
        const myLatLng = { lat: parseFloat($('#latitude').val()), lng: parseFloat($('#longitude').val()) };
        var map = new google.maps.Map(document.getElementById('map'), {
            center:myLatLng,
            zoom: 13,
            mapTypeId: 'roadmap'
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '{{ $property->name }}'
        });
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQDC3VV5CGRaueUYpEEJ308KNx8zbG5t0&libraries=places&callback=initAutocomplete&language=en&region=kw"></script>

@endpush