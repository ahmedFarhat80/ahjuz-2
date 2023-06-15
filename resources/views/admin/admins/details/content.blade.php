<div class="flex-lg-row-fluid ms-lg-15">
  <!--begin:::Tabs-->
  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
    <!--begin:::Tab item-->

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
          <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}">
            @csrf @method('DELETE')
            <div class="menu-item px-3">
              <button onclick="destroy(event)" type="submit" class="btn btn-link text-danger">حذف المشرف</button>          
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


</div>
