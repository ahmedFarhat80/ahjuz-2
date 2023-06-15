<!-- Start Hero -->
<div class="hero text-white position-relative d-flex align-items-center" style="background-image: url({{ $settings->hero_img }})">
<div class="container">
    <div class="row d-flex align-items-center">
        <div class="col-md-5 col-12 hero-text">
            <h2 class="fw-bold mb-4"> {{ $settings->main_headline }} </h2>
            <p style="line-height: 25px;"> {{ $settings->main_text }}</p>
            <a href="{{ route('login') }}" class="btn btn-secondary mt-4 ms-3"> <i class="fas fa-sign-in mx-1"></i> الدخول </a>
            <a href="{{ route('owner.properties.create') }}" class="btn btn-light mt-4"> <i class="fas fa-add mx-1"></i> أضف وحدة </a>

        </div>
        <div class="col-md-2 col-12"></div>
        <div class="col-md-5 col-12">
            <div class="book-box bg-white p-5">
                <h4 class="text-secondary fw-bold mb-2"> احجز الأن </h4>
                <p class="text-muted"> احجز من خلالنا واستمتع بأسعار وعروضات حصرية </p>
                <form action="{{ route('search') }}">
                    <div class="form-check form-check-inline text-dark ms-4 me-0">
                        <input class="form-check-input me-0 ms-2" type="radio" name="type" id="inlineRadio" value="" checked/>
                        <label class="form-check-label" for="inlineRadio" style="font-weight: 500;"> الكل </label>
                    </div>

                    @foreach ($types as $value => $type)
                        <div class="form-check form-check-inline text-dark ms-4 me-0">
                            <input class="form-check-input me-0 ms-2" type="radio" name="type" id="inlineRadio{{ $value }}" value="{{ $value }}" />
                            <label class="form-check-label" for="inlineRadio{{ $value }}" style="font-weight: 500;"> {{ $type }} </label>
                        </div>
                    @endforeach

                    <div class="text-dark mt-3">
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label for="startdate text-primary fw-bold"> المحافظة </label>
                                <select class="form-control mt-1 text-end" name="governorate_id">
                                    <option value="">كل المحافظات</option>
                                    @foreach ($governorates as $governorate)
                                        <option value="{{ $governorate->id }}"> {{ $governorate->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-12" style="cursor: pointer;" onclick="document.getElementById('kt_daterangepicker_1').click()">
                                <label for="startdate text-primary fw-bold"> تاريخ الوصول </label>
                                <input type="text" class="form-control mt-1 text-end" name="starts_at" value="{{ today()->format('Y/m/d') }}">
                            </div>
                            <div class="col-md-6 col-12" style="cursor: pointer;" onclick="document.getElementById('kt_daterangepicker_1').click()">
                                <label for="startdate text-primary fw-bold"> تاريخ المغادرة </label>
                                <input type="text" class="form-control mt-1 text-end" name="ends_at" value="{{ today()->addDay()->format('Y/m/d') }}">
                            </div>
                            <span  type="text" name="date" style="visibility: hidden;height:0;cursor: pointer" id="kt_daterangepicker_1" autocomplete="off">تاريخ الوصول / المغادة</span>
                        </div>                            
                        <div class="col-12">
                            <button type="submit" class="btn btn-secondary w-100"> البحث </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Hero -->

@push('scripts')
<script>
    $('#kt_daterangepicker_1').on('apply.daterangepicker', function(ev, picker) {
        setDates(picker.startDate.format('YYYY/MM/DD'), picker.endDate.format('YYYY/MM/DD'))
    });
</script>
@endpush