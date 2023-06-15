@push('styles')

@endpush

<div class="col-md-4 col-12 mb-3">
  <div class="rounded border shadow-sm bg-white p-3 booking position-relative">
      <h2 class="text-secondary fw-bold d-inline"> {{ $property->averagePriceShow }} </h2> <span class="text-secondary fw-normal "> د.ك </span> <span class="fw-normal text-muted "> / ليلة </span>
      <div class="my-3"></div>

      <div class="inputs-box rounded border overflow-hidden position-relative" style="cursor: pointer;" onclick="document.getElementById('kt_daterangepicker_1').click()">

        <div class="d-flex border-bottom">
              <div class="p-2 border-start w-100">
                  <span class="fw-normal text-muted"> تاريخ الوصول </span>
                  <span class="text-dark d-block mt-1 fw-bold"> {{ $date->starts_at }} </span>
              </div>
              <div class="p-2 w-100">
                  <span class="fw-normal text-muted"> تاريخ المغادرة </span>
                  <span class="text-dark d-block mt-1 fw-bold"> {{ $date->ends_at }} </span>
              </div>
          </div>
          <div class="d-flex">
              <div class="p-2 w-100 ">
                  <span class="fw-normal text-muted "> عدد الأيام </span>
                  <span class="text-dark d-block mt-1 fw-bold "> @choice('plural.day', $date->days, ['n' => $date->days]) </span>
              </div>
              <form id="date" action="{{ route('properties.bookings.date', $property->id) }}" method="POST">
                @csrf
                <input name="date" type="text" style="visibility: hidden" id="kt_daterangepicker_1" />
                <input name="starts_at" type="hidden"/>
                <input name="ends_at" type="hidden"/>  
              </form>
          </div>
      </div>


      <div class="times-box d-flex mt-3">
          <div class="d-flex w-100 align-items-center">
              <img src="https://gathern.co/img/enter.png" style="height: 30px;">
              <div class="me-2">
                  <span class="text-muted"> وقت الدخول </span>
                  <h6 class="text-dark"> {{ $property->opens_at_ar }} </h6>
              </div>
          </div>
          <div class="d-flex w-100 align-items-center">
              <img src="https://gathern.co/img/logout.png" style="height: 30px;">
              <div class="me-2">
                  <span class="text-muted"> وقت الخروج </span>
                  <h6 class="text-dark"> {{ $property->closes_at_ar }} </h6>
              </div>
          </div>
          
      </div>

      @if ($isAvailable)
        <a href="{{ route('properties.payment', $property->id) }}" class="btn btn-primary w-100 mt-4 mb-4 fs-5 shadow-0">احجز</a>
      @else
        <button class="btn btn-danger w-100 mt-4 mb-4 fs-5 shadow-0" disabled> غير متوفر </button>
      @endif


      <h6 class="d-inline-block fw-bold" style="border-bottom: 2px solid #FBA710; color: #FBA710; padding-bottom: 6px;"> تفاصيل الفاتورة </h6>
      <div class="d-flex mt-2">
          <span class="w-100"> @choice('plural.day', $date->days, ['n' => $date->days]) &nbsp;  X &nbsp;<span dir="ltr"> {{ $property->averagePriceShow }} </span> د.ك</span>
          <span class="text-primary fw-bold w-100 text-start"> {{ $property->averagePrice * $date->days  }} د.ك </span>
      </div>
      <div class="d-flex mt-2">
          <span class="w-100"> تأمين مسترد بعد الحجز</span>
          <span class="text-primary fw-bold w-100 text-start"> {{ $property->insurance_price ?? 0 }} د.ك </span>
      </div>

      <div class="display_coupon" style="display: none">
        <li class="d-flex justify-content-between mt-2">
            <div class="text-success">
              <h6 class="my-0">كوبون 
                <form id="coupon_delete" class="d-inline" style="cursor:pointer">
                    <i class="fas fa-times text-danger" style="font-size: 12px;padding: 0px 2px;"></i>
                </form>
              </h6>
              <small class="coupon_code"></small>
            </div>
            <span class="text-success">-<span class="discount_value m-1"></span>د.ك</span>
        </li>
      </div>
  
      <hr>
      <div class="d-flex mt-1 fw-bold align-items-center">
          <span class="w-100"> المجموع </span>
          <span class="text-primary w-100 text-start fs-5 total_pay"> {{ $property->averagePrice * $date->days + $property->insurance_price }} د.ك </span>
      </div>

      <div class="mt-4">
        <form id="coupon_form" action={{ route('coupon') }} method="POST">
          @csrf
          <div class="input-group">
            <input type="text" name="code" class="form-control" placeholder="أدخل الكوبون">
            <input type="hidden" name="subtotal" value="{{ $property->averagePrice * $date->days  }}">
            <input type="hidden" name="insurance" value="{{ $property->insurance_price }}">
            <button class="btn btn-outline-warning mt-2 w-100"> تطبيق الكوبون </button>    
          </div>
          <div class="error"></div>
        </form>
      </div>

      <div class="spinner2 spinner-border text-primary position-absolute" style="left: 50%;top:50%;width: 3rem;height: 3rem;display: none;" role="status">
        <span class="sr-only">Loading...</span>
      </div>  
  
  </div>
</div>


@push('scripts')
<script>
  $('#kt_daterangepicker_1').data('daterangepicker').setStartDate('{{ $date->starts_at }}');
  $('#kt_daterangepicker_1').data('daterangepicker').setEndDate('{{ $date->ends_at }}');
  $('#kt_daterangepicker_1').on('apply.daterangepicker', function() {
      $('#date').submit(function () {
        [startDate, endDate] = $('input[name=date]').val().split(' - ');
        $('input[name="starts_at"]').val(startDate);
        $('input[name="ends_at"]').val(endDate);
      });
      $("#date").submit();
  });
</script>
<script>
    @if(Session::has('errors'))
      Swal.fire({
          icon: 'error',
          title: "خطأ، الرجاء التحقق من صحة المدخلات",
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      })
    @endif
</script> 


<script>
    $(document).on('submit', '#coupon_form', function(e) {
    e.preventDefault();

    $.ajax({
            url: $(this).attr('action'),
            type:"POST",
            dataType:"json",
            data:  $(this).serializeArray(),
            success: function(data) { 
              $('#coupon_form .error').empty();
              $('.display_coupon').attr('style', 'display: none !important');
              $('input[name="code"]').val('');
              if (data.error) {
                data.total ? $('.total_pay').text((data.total).toFixed(2)) : '';
                return $('#coupon_form .error').append(`<div class="alert alert-danger mt-3">${data.error}</div>`);
              }
              $('.display_coupon').attr('style', 'display: block !important');
              $('.coupon_code').text(`${data.coupon.code}`);
              $('.discount_value').text(data.discount);
              $('.total_pay').text((data.total).toFixed(2));
              $('#coupon_delete').attr('action', '{{ route('coupon') }}');
            },
            beforeSend: function() {
              spinner(true, '.booking', '.spinner2');
            },
            complete: function() {
              spinner(false, '.booking', '.spinner2');
            },
      });
    });

    $(document).on('click', '#coupon_delete', function(e) {
      e.preventDefault();
      $.ajax({
            url: $(this).attr('action'),
            type:"DELETE",
            dataType:"json",
            data: {'_token': '{{ csrf_token() }}', 'subtotal':  $('input[name="subtotal"]').val(), 'insurance':  $('input[name="insurance"]').val()},
            success: function(data) { 
              $('.display_coupon').attr('style', 'display: none !important');
              $('.total_pay').text((data.total).toFixed(2));

              if (data.error) {
                return $('#coupon_form .error').append(`<div class="alert alert-danger mt-3">${data.error}</div>`);
              }
              
            },
            beforeSend: function() {
              spinner(true, '.booking', '.spinner2');
            },
            complete: function() {
              spinner(false, '.booking', '.spinner2');
            },
      });
    });

    function spinner(when, el, spinner) {
      if (when) {
        $(el).css('opacity', '0.5');
        $(spinner).css('display', 'block');
      } else {
        $(el).css('opacity', '1');
        $(spinner).css('display', 'none');
      }
    }

</script>

@endpush