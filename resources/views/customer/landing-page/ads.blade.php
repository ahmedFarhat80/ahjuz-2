@if ($ads->isNotEmpty())
<!-- ADS -->
<div class="ads w-100 pb-5 mb-5" style="">
  <div class="container">
      <h4 class="mt-5 mb-5 fw-bold text-center"> الاعلانات </h4>
      <div id="owl1" class="owl-carousel owl-theme">
          @foreach ($ads as $ad)
            <div class="item">
              <a href="{{ $ad->url }}" target="_blank"><img src="{{ $ad->cover }}" class="w-100 rounded" style="height: 282px; object-fit: cover;"></a>
            </div>
          @endforeach
      </div>
  </div>
</div>
<!-- End ADS -->
@endif
