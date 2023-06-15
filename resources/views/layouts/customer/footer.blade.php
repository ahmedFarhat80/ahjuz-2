<!-- Start Footer -->
<footer class="bg-dark text-white">
<div class="container">
    <div class="row">
        <div class="col-md-3 col-12">
            <h5 class="fw-bold text-white mb-3"> احجز من خلالنا واستمتع بأسعار وعروضات حصرية </h5>
            <p class="text-white">
                {{ $settings->footer_text }}
            </p>
        </div>
        <div class="col-md-1 col-12"></div>


        <div class="col-md-4 col-12">
            <h5 class="fw-bold"> اتصل بنا </h5>
            @if ($settings->address)
                <div class="d-flex mt-2 align-items-center">
                    <i class="fas fa-map-marker"></i>
                    <span class="me-3">{{ $settings->address }}</span>
                </div>
            @endif
            @if ($settings->phone)
                <div class="d-flex mt-2 align-items-center">
                    <i class="fas fa-phone"></i>
                    <a style="direction: ltr;text-align: start" href="tel:{{ $settings->phone }}" target="_blank" class="me-3"> {{ $settings->phone }}  </a>
                </div>
            @endif
            @if ($settings->whatsapp_1)
                <div class="d-flex mt-2 align-items-center">
                    <i class="fab fa-whatsapp"></i>
                    <a style="direction: ltr;text-align: start" href="https://iwtsp.com/{{ $settings->whatsapp_1 }}" target="_blank" class="me-3"> {{ $settings->whatsapp_1 }} </a>
                </div>
            @endif
            @if ($settings->whatsapp_2)
                <div class="d-flex mt-2 align-items-center">
                    <i class="fab fa-whatsapp"></i>
                    <a style="direction: ltr;text-align: start" href="https://iwtsp.com/{{ $settings->whatsapp_2 }}" target="_blank" class="me-3"> {{ $settings->whatsapp_2 }} </a>
                </div>
            @endif
            @if ($settings->email)
                <div class="d-flex mt-2 align-items-center">
                    <i class="fas fa-envelope"></i>
                    <a style="direction: ltr;text-align: start" href="mailto:{{ $settings->email }}" target="_blank" class="me-3"> {{ $settings->email }}  </a>
                </div>
            @endif
        </div>

        <div class="col-md-4 col-12">
            <h5> تابعنا </h5>
            <div class="d-flex mt-2">
                @foreach ($settings->social as $v)
                    @if ($settings->$v)
                        <a href="{{ $settings->$v }}" target="_blank" class="mx-1 text-light"> <img src="{{ asset("frontend/img/$v.png") }}" style="width: 38px; height: 38px;"> </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
</footer>
<!-- End Footer -->

<div class="bottombar d-none d-md-block text-white ">
<div class="container ">
    <div class="row ">
        <div class="col-6 text-end ">
            <span>جميع الحقوق محفوظة لموقع موقع 2021</span>
        </div>
        <div class="col-6 text-start ">
            <a href="# " class="ms-3 "> سياسة الخصوصية </a>
            <span>|</span>
            <a href="{{ route('contact-us') }}" class="me-3 "> اتصل بنا </a>
        </div>
    </div>
</div>
</div>
