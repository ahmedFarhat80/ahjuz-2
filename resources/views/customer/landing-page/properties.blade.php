<!-- Start Chalets -->
<div class="chalets text-center pb-5">
    <div class="container">
        <h4 class="mt-3 mb-5 fw-bold"> أبرز الوحدات </h4>
        <div class="row">
            @foreach ($properties as $property)
                <div class="col-md-6 col-12 mb-4">
                    <a href="{{ route('properties.show', $property->slug) }}">
                        <div class="chalet-item rounded bg-white text-end">
                            <div class="img position-relative">
                                @if ($property->is_special->is(PropertyIsSpecial::Yes))
                                <span class="position-absolute text-white" style="right: 0; top: 13px; z-index: 10000; background-color: #fba710; padding: 3px 8px; font-size: 11px;">
                                    هذه الوحدة مميزة
                                </span>
                                @endif
                                <span class="position-absolute rounded text-white" style="left: 13px; top: 13px; z-index: 10000; background-color: rgba(0, 0, 0, 0.4); padding: 3px 8px; font-size: 11px;">
                                    <i class="fas fa-eye ms-1"></i> {{ views($property)->remember(12*60)->count() }}
                                </span>
                                <div id="img{{ $property->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($property->imgs->take(5) as $key => $img)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ $img->name }}" class="d-block w-100" alt="{{ $property->name }}" />                        
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-next" type="button" data-bs-target="#img{{ $property->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden"> التالي </span>
                                    </button>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#img{{ $property->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden"> السابق </span>
                                    </button>
                                </div>
                            </div>
                            <div class="content pt-4 pb-4 ps-3 pe-3 text-dark">
                                <h5> {{ $property->name }}</ </h5>
                                <h6 class="text-muted d-block mt-3 mb-3"> كود الوحدة : <span> ({{ $property->code }}) </span> </h6>
                                <h6 class="text-warning"> <i class="fas fa-star ms-2"></i> {{ number_format($property->reviews_avg_rating, 1) }} ({{ $property->reviews_count }} تقييم)  </h6>
                                <h6 class="text-muted mt-3 mb-3"> <i class="fas fa-map-marker-alt ms-2"></i> {{ $property->gov_reg }} </h6>
                                <h5 class="text-primary"> {{ $property->averagePriceShow }} د.ك <span style="font-size: 21px; font-weight: 500;" class="text-muted ms-2"> / ليلة </span> </h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- End Chalets -->
