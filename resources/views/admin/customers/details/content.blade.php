<div class="flex-lg-row-fluid ms-lg-15">
  <!--begin:::Tabs-->
  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
    <!--begin:::Tab item-->
    <li class="nav-item">
      <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab">نظرة عامة</a>
    </li>

    <li class="nav-item ms-auto">
      <!--begin::Action menu-->
      <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">الإجراءات 
      <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
      <span class="svg-icon svg-icon-2 me-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
        </svg>
      </span>
      <!--end::Svg Icon-->
      </a>
      <!--begin::Menu-->
      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold py-4 w-250px fs-6" data-kt-menu="true" style="">
        <!--begin::Menu item-->
        <div class="menu-item px-5">
          <form method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}">
            @csrf @method('DELETE')
            <div class="menu-item px-3">
              <button onclick="destroy(event)" type="submit" class="btn btn-link text-danger">حذف الزبون</button>          
            </div>
          </form>
        </div>
        <!--end::Menu item-->
      </div>
      <!--end::Menu-->
      <!--end::Menu-->
    </li>

    <!--end:::Tab item-->
  </ul>
  <!--end:::Tabs-->

  <!--begin:::Tab content-->
  <div class="tab-content" id="myTabContent">
    <!--begin:::Tab pane-->
    <div class="tab-pane fade show active" id="kt_owner_view_overview_tab" role="tabpanel">
      <!--begin::Card-->
      <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
          <!--begin::Card title-->
          <div class="card-title">
            <h2>الحجوزات</h2>
          </div>
          <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
          <!--begin::Table-->
          @if ($bookings->isNotEmpty())

            <div id="kt_table_owners_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table class="table align-middle table-row-dashed gy-5 dataTable no-footer" id="kt_table_owners_payment" role="grid">
              <!--begin::Table head-->
              <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                <!--begin::Table row-->
                <tr class="text-start text-muted text-uppercase gs-0" role="row">
                  <th class="text-center" tabindex="0" rowspan="1" colspan="1" style="width: 77.125px;">الرقم المعرف</th>
                  <th class="text-center" tabindex="0" rowspan="1" colspan="1" style="width: 88.9px;">الوحدة</th>
                  <th class="text-center" tabindex="0" rowspan="1" colspan="1" style="width: 99.9px;">يبدأ</th>
                  <th class="text-center" tabindex="0" rowspan="1" colspan="1" style="width: 99.9px;">ينتهي</th>
                  <th class="text-center" tabindex="0"rowspan="1" colspan="1"style="width: 66.825px;">الحالة</th>
                  <th class="text-center" tabindex="0"rowspan="1" colspan="1"style="width: 99.825px;">تاريخ الإنشاء</th>
                </tr>
                <!--end::Table row-->
              </thead>
              <!--end::Table head-->
              <!--begin::Table body-->
              <tbody class="fs-6 fw-bold text-gray-600">

              @foreach ($bookings as $booking)
                <tr>
                    <td class="text-center">
                      <a href="{{ route('admin.bookings.show', $booking->id) }}">{{ $booking->id }}</a>
                    </td>
                    <td class="text-center">
                      <a href="{{ route('admin.properties.show', $booking->property_id) }}">{{ $booking->property->name }}</a>
                    </td>
                    <td class="text-center">
                      {{ date_ar($booking->starts_at) }}
                    </td>
                    <td class="text-center">
                      {{ date_ar($booking->ends_at) }}
                    </td>
                    <td class="text-center">
                      {{ $booking->status->description }}
                    </td>
                    <td class="text-center">
                      {{ date_hour_ar($booking->created_at) }}
                    </td>
                </tr>
              @endforeach

              </tbody>
              <!--end::Table body-->
              </table>
                </div>
                
                <div class="row">
                  <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                  </div>
                  <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                    {{ $bookings->links() }}
                  </div>
                </div>
            </div>

          @else
            لا يوجد أي حجوزات
          @endif

          <!--end::Table-->
        </div>
        <!--end::Card body-->
      </div>
      <!--end::Card-->
    </div>
    <!--end:::Tab pane-->
  </div>
  <!--end:::Tab content-->


</div>
