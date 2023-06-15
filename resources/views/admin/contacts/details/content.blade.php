<div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
  <!--begin::Card-->
  <div class="card card-flush pt-3 mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Card title-->
      <div class="card-title">
        <h2 class="fw-bolder">تفاصيل الرسالة</h2>
      </div>
      <div class="card-toolbar">
        <!--begin::More options-->
        <a href="#" class="btn btn-sm btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
          الإجراءات
          <i class="fas fa-caret-down ms-2"></i>
        </a>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-150px py-4" data-kt-menu="true" style="">
          <div class="menu-item px-5">
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}">
              @csrf @method('DELETE')
              <div class="menu-item px-3">
                <button onclick="destroy(event)" type="submit" class="btn btn-link text-danger">حذف الرسالة</button>          
              </div>
            </form>
          </div>
        </div>
        <!--end::Menu-->
        <!--end::More options-->
      </div>
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
                <td class="text-gray-400">الاسم:</td>
                <td class="text-gray-800">{{ $contact->name}}</td>
              </tr>
              <tr>
                <td class="text-gray-400">رقم جوال:</td>
                <td class="text-gray-800">{{ $contact->phone }}</td>
              </tr>
            <!--end::Row-->
            </tbody></table>
            <!--end::Details-->
          </div>
          <!--end::Row-->
          <!--begin::Row-->
          <div class="flex-equal">
            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
              <tbody>
                <tr>
                  <td class="text-gray-400">الإيميل:</td>
                  <td class="text-gray-800 text-start" dir="ltr">{{ $contact->email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Section-->


      <!--begin::Section-->
      <div class="mb-10">
        <!--begin::Title-->
        <h5 class="mb-4">التفاصيل :</h5>
        <!--end::Title-->
        <!--begin::Details-->
        <div class="d-flex flex-wrap py-5">
          <!--begin::Row-->
          <div class="flex-equal ms-5">
            <!--begin::Details-->
            {{ $contact->details }}
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


</div>