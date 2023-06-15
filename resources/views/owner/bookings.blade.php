@extends('layouts.owner.index')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .fc-event-title-container{
    cursor: pointer;
  }
  .daterangepicker{
    z-index: 9999999999;
   font-family: cairo;
  }
  .cancelBtn, .applyBtn, .drp-calendar th  {
    font-size: 11px !important;
  }
  .drp-selected{
    margin-right: auto !important;
    font-size: 14px !important;
    margin-bottom: 8px;
    font-weight: 600
  }
</style>
@endpush

@section('content')

<div id="bookings">
  <div class="bar py-3 bg-primary text-white mb-3">
    <div class="container">
      <span> الرئيسية </span>
      <i class="fas fa-angle-left mx-2"></i>
      <span> الحجوزات </span>
      <i class="fas fa-angle-left mx-2"></i>
      <span> {{ $property->name }} </span>
    </div>
  </div>
  <div class="w-100 p-3"></div>
  <div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
    إشغال الوحدة
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> إشغال الوحدة </h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="foreign" action="{{ route('owner.properties.bookings.foreign', $property->id) }}" method="POST">
            @csrf
            <div class="modal-body">

                @if ($errors->any())
                    <div class="alert alert-danger my-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
  
                <label for="date" class="form-label">حدد تاريخ الإشغال</label>
                <input name="date" class="form-control form-control-solid" id="kt_daterangepicker_1" autocomplete="off" dir="ltr"/>
                <input name="starts_at" type="hidden"/>
                <input name="ends_at" type="hidden"/>
                <label for="#" class="form-label mt-2"> أدخل تفاصيل الإشغال </label>
                <input name="details" type="text" class="form-control mt-1 mb-3">  
            </div>
            <div class="modal-footer justify-content-start">
              <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                إلغاء
              </button>
              <button type="submit" class="btn btn-primary">إشغال</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="calendar" class="mt-3">
    </div>

  </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModal"> تفاصيل الحجز </h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="w-100 p-1"></div>
          <div class="d-flex mb-2 justify-content-center customer_label">
            <h6 class="w-100 text-muted"> اسم الزبون: </h6>
            <h6 class="w-100 text-start customer"></h6>
          </div>
          <div class="d-flex mb-2 justify-content-center">
            <h6 class="w-100 text-muted"> يبدأ: </h6>
            <h6 class="w-100 text-start starts_at"></h6>
                    </div>
          <div class="d-flex mb-2 justify-content-center">
            <h6 class="w-100 text-muted"> ينتهي: </h6>
            <h6 class="w-100 text-start ends_at"></h6>
          </div>
          <div class="d-flex mb-2 justify-content-center payment_method_label">
            <h6 class="w-100 text-muted"> وسيلة الدفع: </h6>
            <h6 class="w-100 text-start payment_method"></h6>
          </div>
          <div class="d-flex mb-2 justify-content-center total_price_label">
            <h6 class="w-100 text-muted"> المبلغ الإجمالي: </h6>
            <h6 class="w-100 text-start total_price"></h6>
          </div>
          <div class="d-flex mb-2 justify-content-center status_label">
            <h6 class="w-100 text-muted"> الحالة: </h6>
            <h6 class="w-100 text-start status"></h6>
          </div>
          <div class="d-flex mb-2 justify-content-center details_label">
            <h6 class="w-100 text-muted"> التفاصيل: </h6>
            <h6 class="w-100 text-start details"></h6>
          </div>
          <div class="d-flex mb-2 justify-content-center message_label" style="display: none!important">
            <h6 class="w-100 text-muted"><a href="" class="message">تواصل مع الزبون</a></h6>
          </div>
        </div>
        <div class="modal-footer justify-content-start" style="display: none">
          <form action="" method="POST">
            @csrf @method('DELETE')
            <button onclick="destroy(event)" type="submit" class="btn btn-danger">إلغاء الحجز</button>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>

  var events = @json($events);

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'ar',
      firstDay: 6,
      editable: false,
      selectable: true,
      buttonText: { 
        'today': 'هذا اليوم',
        'year': 'السنة',
        'month': 'الشهر',
        'week': 'الأسبوع',
        'day': 'اليوم',
        'list': 'القائمة',
      },
      dayMaxEvents: true,
      eventClick: function(info) {
        console.log(info.event);
        // info.el.style.borderColor = 'red';
        $(`#eventModal .modal-footer`).attr('style', 'display: none !important')

        handel_modal(['customer', 'payment_method', 'total_price', 'status', 'details'], info.event.extendedProps)
        
        if (v = info.event.extendedProps.delete_url) {
          $(`#eventModal form`).attr('action', v);
          $(`#eventModal .modal-footer`).show()
        }
        
        if (v = info.event.extendedProps.message) {
          $(`#eventModal .message`).attr('href', v);
          $(`#eventModal .message_label`).show()
        }

        $('#eventModal .starts_at').text(info.event.extendedProps.starts_at)
        $('#eventModal .ends_at').text(info.event.extendedProps.ends_at)

        $('#eventModal').modal('show');

      },

      events: [...events]
    });

    calendar.render();

    function handel_modal(values, event) {
      values.forEach(function (v) {
        $(`#eventModal .${v}`).text('')
      })
      values.forEach(function (v) {
        $(`#eventModal .${v}_label`).attr('style', 'display: none !important');
      })
      values.forEach(function (v) {
        if (data = event[v]) {
          $(`#eventModal .${v}_label`).show();
          $(`#eventModal .${v}`).text(data)
        }
      })

    }
  });

</script>

<script>
  $('#foreign').submit(function () {
    [startDate, endDate] = $('input[name=date]').val().split(' - ');
    $('input[name="starts_at"]').val(startDate);
    $('input[name="ends_at"]').val(endDate);
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

@endpush