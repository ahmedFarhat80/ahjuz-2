<!-- Cities -->
<div class="cities w-100 pb-5 mb-5" style="background-color: #f2f2f2;">

    <div class="container">
        <div class="p-3 w-100"></div>
        <h4 class="mt-5 mb-5 fw-bold"> استكشف حسب المحافظة </h4>
    </div>

    <div id="owl2" class="owl-carousel owl-theme">
        @foreach ($governorates as $governorate)
            <div class="item">
                <a href="{{ route('search', ['governorate_id' => $governorate->id, 'starts_at' => today()->format('Y/m/d'), 'ends_at' => today()->addDay()->format('Y/m/d')]) }}">
                    <div class="city-item rounded overflow-hidden p-3 position-relative" style="background-image: url({{ $governorate->cover }}); background-position: center; background-size: cover; height: 325px;">
                        <div class="opacity w-100 position-absolute" style="background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.6)); opacity: 100%; right: 0; left: 0; bottom: 0; height: 45%;">
                        </div>
                        <h5 class="fw-bold text-white position-absolute" style="z-index:  10000; bottom: 12px; right: 20px;"> {{ $governorate->name }} </h5>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
<!-- End Cities -->