@if ($settings->play_store && $settings->apple_store)
<!-- Download -->
<div class="download bg-primary text-white">
  <div class="container">
    <div class="row">
      <div class="col-md-5 col-12">
        <h3 class="fw-bold mt-6"> {{ $settings->mobile_headline }} </h3>
        <p class="mt-4 mb-5">
          {{ $settings->mobile_text }}
        </p>
        <div class="mb-6">
          @if ($settings->play_store)
            <a href="{{ $settings->play_store }}" target="_blank" class="ms-3">
              <img src="{{ asset('frontend/img/playstore.svg') }}" style="height: 65px;">
            </a>
          @endif
          @if ($settings->apple_store)
            <a href="{{ $settings->apple_store }}" target="_blank" class="ms-3">
              <img src="{{ asset('frontend/img/appstore.svg') }}" style="height: 65px;">
            </a>
          @endif
        </div>
      </div>
      <div class="col-1"></div>
      <div class="col-6">

      </div>
    </div>
  </div>
</div>
<!-- End Download -->
@endif