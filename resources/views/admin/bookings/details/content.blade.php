<div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
  <!--begin::Card-->
  <div class="card card-flush pt-3 mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Card title-->
      <div class="card-title">
        <h2 class="fw-bolder">تفاصيل الحجز</h2>
      </div>
      <!--begin::Card title-->
      <!--begin::Card toolbar-->
      @can('cancel', $booking)
          <div class="card-toolbar">
            <!--begin::More options-->
            <a href="#" class="btn btn-sm btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
              الإجراءات
              <i class="fas fa-caret-down ms-2"></i>
            </a>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-150px py-4" data-kt-menu="true" style="">
              <form method="POST">
                @csrf @method('PATCH')
                <div class="menu-item px-3">
                  <button onclick="event.preventDefault(); updateBookingAjax(event)" type="submit" class="btn btn-link text-danger" formaction="{{ route('admin.bookings.cancel', $booking->id) }}">إلغاء الحجز</button>          
                </div>
              </form>
            </div>
            <!--end::Menu-->
            <!--end::More options-->
          </div>
      @endcan


      <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-3">

      <!--begin::Section-->
      <div class="mb-10">
        <!--begin::Title-->
        <!--end::Title-->
        <!--begin::Details-->
        <div class="d-flex flex-wrap py-5">
          <!--begin::Row-->
          <div class="flex-equal ms-5">
            <!--begin::Details-->
            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
              <tbody>
              <!--begin::Row-->
              <tr>
                <td class="text-gray-400">اسم الوحدة:</td>
                @if ($booking->property_id)
                  <td class="text-gray-800"><a href="{{ route('admin.properties.show', $booking->property_id) }}">{{ $booking->property->name }}</a></td>
                @endif
              </tr>
              <tr>
                <td class="text-gray-400">اسم الزبون:</td>
                @if ($booking->customer_id)
                  <td class="text-gray-800"><a href="{{ route('admin.customers.show', $booking->customer_id) }}">{{ $booking->customer->full_name }}</a></td>
                @endif
              </tr>
              <tr>
                <td class="text-gray-400">يبدأ:</td>
                <td class="text-gray-800">{{ date_ar($booking->starts_at) }}</td>
              </tr>
              <tr>
                <td class="text-gray-400">ينتهي:</td>
                <td class="text-gray-800">{{ date_ar($booking->ends_at) }}</td>
              </tr>
              <tr>
                <td class="text-gray-400">وسيلة الدفع:</td>
                <td class="text-gray-800">{{ $booking->payment_method->description }}</td>
              </tr>
              <tr>
                <td class="text-gray-400">الحالة:</td>
                <td class="text-gray-800">{{ $booking->status->description }}</td>
              </tr>
              <tr>
                <td class="text-gray-400">تاريخ الإنشاء:</td>
                <td class="text-gray-800">{{ date_hour_ar($booking->created_at) }}</td>
              </tr>
              <!--end::Row-->
            </tbody></table>
            <!--end::Details-->
          </div>
          <!--end::Row-->

          <div class="flex-equal">
          </div>

          <!--begin::Row-->
          <div class="flex-equal">
              <!--begin::Details-->
              <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                <tbody>
                <!--begin::Row-->
                <tr>
                  <td class="text-gray-400">كود الكوبون:</td>
                  @if ($booking->coupon_id)
                    <td class="text-gray-800"><a href="{{ route('admin.coupons.show', $booking->coupon_id) }}">{{ $booking->coupon->code }}</a></td>
                  @endif
                </tr>
                <tr>
                  <td class="text-gray-400">المجموع الجزئي:</td>
                  <td class="text-gray-800">{{ $booking->subtotal_price }} د.ك</td>
                </tr>
                <tr>
                  <td class="text-gray-400">الخصم:</td>
                  <td class="text-gray-800">-{{ $booking->discount ?? 0}} د.ك</td>
                </tr>
                <tr>
                  <td class="text-gray-400">مبلغ التأمين:</td>
                  <td class="text-gray-800">{{ $booking->insurance ?? 0 }} د.ك</td>
                </tr>
                <tr>
                  <td class="text-gray-400">المجموع الكلي:</td>
                  <td class="text-gray-800">{{ $booking->total_price }} د.ك</td>
                </tr>
                <tr>
                  <td class="text-gray-400">العمولة:</td>
                  <td class="text-gray-800">{{ $booking->commission }} د.ك</td>
                </tr>
                <tr>
                  <td class="text-gray-400">المتبقي لمالك الوحدة:</td>
                  <td class="text-gray-800">{{ $booking->revenue }} د.ك</td>
                </tr>
                </tr>
                <!--end::Row-->
              </tbody></table>
              <!--end::Details-->
          </div>

          <div class="flex-equal">
          </div>    
          <!--end::Row-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Section-->

    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->

</div>


@push('scripts')
  <script>
    function updateBookingAjax(event) {
        var formaction = $(event.target).attr('formaction')
        var text = $(event.target).text()
        var form =  $(event.target.closest('form'))

        if (formaction) {
          form.attr('action', formaction)
        }

        var route = form.attr('action');

        // call ajaxData function with args
        updateAjax(text, ajaxUpdateData, [form, route])
    }

    function ajaxUpdateData(form, route) {
        $.ajax({
            url         :       route,
            type        :       "PATCH",
            data        :       form.serialize(),
            success     :       function(data) { 
  
                                    Swal.fire({
                                            icon: 'success',
                                            title: 'تم الإلغاء بنجاح',
                                            showConfirmButton: false,
                                            timer: 1500
                                    })
                                    .then((result) => location.reload())
                                },
            error     :         function(data) { 
                                    if (message = data.responseJSON.message) {
                                    return  Swal.fire({
                                            text: message,
                                            showConfirmButton: false,
                                            icon: "error",
                                            timer: 2000,
                                            timerProgressBar: true,                                
                                        });
                                    }
                                }
        });
    }
  </script>

@endpush