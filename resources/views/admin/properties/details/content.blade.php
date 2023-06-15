<div class="flex-lg-row-fluid order-2 order-lg-1 mb-10 mb-lg-0">
  <!--begin::Card-->
  <div class="card card-flush pt-3 mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Card title-->
      <div class="card-title">
        <h2 class="fw-bolder">تفاصيل الوحدة</h2>
      </div>
      <!--begin::Card title-->
      <!--begin::Card toolbar-->
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
            @switch($property->status->value)
                @case(PropertyStatus::Pending)
                    <div class="menu-item px-3">
                      <button onclick="event.preventDefault(); updatePropertyAjax(event)" type="submit" class="btn btn-link" formaction="{{ route('admin.properties.update', [$property->id, 'status' => 'Accepted']) }}">قبول الوحدة</button>          
                    </div>
                    <div class="menu-item px-3">
                      <button type="submit" onclick="event.preventDefault(); updatePropertyAjax(event)" class="btn btn-link" formaction="{{ route('admin.properties.update', [$property->id, 'status' => 'Rejected']) }}">رفض الوحدة</button>          
                    </div>
                    @break
                @case(PropertyStatus::Accepted)
                    <div class="menu-item px-3">
                      <button type="submit" onclick="event.preventDefault(); updatePropertyAjax(event)" class="btn btn-link" formaction="{{ route('admin.properties.update', [$property->id, 'status' => 'Suspended']) }}">إيقاف الوحدة</button>          
                    </div>
                    @break
                @case(PropertyStatus::Suspended)
                    <div class="menu-item px-3">
                      <button type="submit" onclick="event.preventDefault(); updatePropertyAjax(event)" class="btn btn-link" formaction="{{ route('admin.properties.update', [$property->id, 'status' => 'Accepted']) }}">تشغيل الوحدة</button>          
                    </div>
                    @break
            @endswitch
            @if ($property->is_special->is(PropertyIsSpecial::Yes))
              <div class="menu-item px-3">
                <button type="submit" onclick="event.preventDefault(); updatePropertyAjax(event)" class="btn btn-link" formaction="{{ route('admin.properties.update', [$property->id, 'is_special' => 'No']) }}">إيقاف تمييز الوحدة</button>          
              </div>
            @else
              <div class="menu-item px-3">
                <button type="submit" onclick="event.preventDefault(); updatePropertyAjax(event)" class="btn btn-link" formaction="{{ route('admin.properties.update', [$property->id, 'is_special' => 'Yes']) }}">تمييز الوحدة</button>          
              </div>
            @endif
            <div class="menu-item px-3">
              <button onclick="destroy(event)" type="submit" class="btn btn-link text-danger" formaction="{{ route('admin.properties.destroy', $property->id) }}">حذف الوحدة</button>          
            </div>
          </form>
        </div>
        <!--end::Menu-->
        <!--end::More options-->
      </div>
      <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-3">
      <!--begin::Section-->
      <div class="mb-10">
        <!--begin::Title-->
        <h5 class="mb-4">بيانات الوحدة:</h5>
        <!--end::Title-->
        <!--begin::Details-->
        <div class="row py-5">
          <!--begin::Row-->

          <!--end::Row-->
          <!--begin::Row-->
          <div class="flex-equal">
            <!--begin::Details-->
            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
              <!--begin::Row-->
              <tbody>
                <tr>
                  <td class="text-gray-400"> اسم الوحدة :</td>
                  <td class="text-gray-800">{{ $property->name }}</td>
                </tr>
                <tr>
                  <td class="text-gray-400">نوع الوحدة:</td>
                  <td class="text-gray-800">{{ $property->type->description }}</td>
                </tr>
                <tr>
                  <td class="text-gray-400">المالك:</td>
                  <td class="text-gray-800"><a href="{{ route('admin.owners.show', $property->owner_id) }}">{{ $property->owner->full_name }}</a></td>
                </tr>
                <tr>
                  <td class="text-gray-400">المكان المخصص:</td>
                  <td class="text-gray-800">{{ $property->for->description }}</td>
                </tr>
                <tr>
                  <td class="text-gray-400">المساحة:</td>
                  <td class="text-gray-800">{{ $property->area }}م <sup>2</sup></td>
                </tr>
                <tr>
                  <td class="text-gray-400">وقت الدخول:</td>
                  <td class="text-gray-800">{{ $property->opens_at_ar }}</td>
                </tr>
                <tr>
                  <td class="text-gray-400">وقت الخروج:</td>
                  <td class="text-gray-800">{{ $property->closes_at_ar }}</td>
                </tr>
              </tbody>
            </table>
            <!--end::Details-->
          </div>
          <div class="flex-equal">
            <!--begin::Details-->
            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
              <!--begin::Row-->
              <tbody>
              <tr>
                <td class="text-gray-400">سعر اليوم العادي:</td>
                <td class="text-gray-800">{{ $property->day_price }} د.ك</td>
              </tr>
              <tr>
                <td class="text-gray-400">سعر اليوم الخميس:</td>
                <td class="text-gray-800">{{ $property->thursday_price }} د.ك</td>
              </tr>
              <tr>
                <td class="text-gray-400">سعر اليوم الجمعة:</td>
                <td class="text-gray-800">{{ $property->friday_price }} د.ك</td>
              </tr>
              <tr>
                <td class="text-gray-400">مبلغ التـأمين:</td>
                <td class="text-gray-800">{{ $property->insurance_price ?? 0 }} د.ك</td>
              </tr>
              <tr>
                <td class="text-gray-400">جاهز للعرض:</td>
                <td class="text-gray-800"><span class="badge badge-light-{{ $property->ActiveClass }}">{{ $property->is_active->description }}</span></td>
              </tr>
              <tr>
                <td class="text-gray-400">الحالة:</td>
                <td class="text-gray-800"><span class="badge badge-light-{{ $property->statusClass }}">{{ $property->status->description }}</span></td>
              </tr>
              <tr>
                <td class="text-gray-400">تاريخ الإنشاء:</td>
                <td class="text-gray-800">{{ $property->created_at }}</td>
              </tr>
            </tbody></table>
            <!--end::Details-->
          </div>
          <!--end::Row-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Section-->
      <!--begin::Section-->
      <div class="mb-0">
        <!--begin::Title-->
        <h5 class="mb-4">عنوان الوحدة:</h5>
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
                <td class="text-gray-400">المحافظة:</td>
                <td class="text-gray-800">{{ $property->address->governorate->name }}</td>
              </tr>
              <tr>
                <td class="text-gray-400">المنطقة:</td>
                <td class="text-gray-800">{{ $property->address->region->name }}</td>
              </tr>
              <tr>
                <td class="text-gray-400">تفاصيل العنوان:</td>
                <td class="text-gray-800">{{ $property->address->details }}</td>
              </tr>
              <!--end::Row-->
            </tbody></table>
            <!--end::Details-->
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



  
  <!--begin::Card-->
  <div class="card card-flush pt-3 mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Card title-->
      <div class="card-title">
        <h2 class="fw-bolder">صور الوحدة</h2>
      </div>
      <!--begin::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-3">
      <!--begin::Section-->
      <div class="mb-10">
        <!--begin::Details-->
        <div class="d-flex flex-wrap py-5 property_imgs">
            @foreach ($property->imgs as $img)
              <div class="img-item m-2 d-inline-block position-relative">
                  <img src="{{ $img->name }}" class="rounded" style="height: 120px; width: 120px;" alt="{{ $property->name }}">
              </div>    
            @endforeach
        </div>
        <!--end::Row-->
      </div>
      <!--end::Section-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->

</div>