
<div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
    <!--begin::Add governorate-->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_governorate">إنشاء محافظة جديدة</button>      
    <!--end::Add governorate-->
</div>

<div class="modal fade" id="kt_modal_add_governorate">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <!--begin::Modal content-->
    <div class="modal-content">
      <!--begin::Form-->
      <form class="form" novalidate="novalidate" action="{{ route('admin.governorates.store') }}" id="kt_modal_add_governorate_form" method="POST">
        <!--begin::Modal header-->
        <div class="modal-header" id="kt_modal_add_governorate_header">
          <!--begin::Modal title-->
          <h2 class="fw-bolder">إنشاء محافظة جديدة</h2>
          <!--end::Modal title-->
            <!--begin::Close-->
            <div id="kt_modal_add_governorate_close" class="btn btn-icon btn-sm btn-active-icon-primary">
              <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
              <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                  <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                </svg>
              </span>
              <!--end::Svg Icon-->
            </div>          <!--end::Close-->
         </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-10 px-lg-17">
          <!--begin::Scroll-->
          <div class="scroll-y me-n7 pe-7" id="kt_modal_add_governorate_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_governorate_header" data-kt-scroll-wrappers="#kt_modal_add_governorate_scroll" data-kt-scroll-offset="300px" style="max-height: 62px;">
            <!--begin::Input group-->
            <div class="fv-row mb-7 fv-plugins-icon-container">
              <!--begin::Label-->
              <label class="required fs-6 fw-bold mb-2">الاسم</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input type="text" class="form-control form-control-solid" name="name" placeholder="أدخل الاسم" required autocomplete="off">
              <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div></div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7 fv-plugins-icon-container">
              <!--begin::Label-->
              <label class="required fs-6 fw-bold mb-2">الصورة</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input type="file" class="form-control form-control-solid" name="cover" required>
              <!--end::Input-->
            </div>
            <!--end::Input group-->
          </div>
          <!--end::Scroll-->
        </div>
        <!--end::Modal body-->
        <!--begin::Modal footer-->
        <div class="modal-footer flex-center">
          <!--begin::Button-->
          <button type="reset" id="kt_modal_add_governorate_cancel" class="btn btn-light me-3">تجاهل</button>
          <!--end::Button-->
          <!--begin::Button-->
          <button type="submit" id="kt_modal_add_governorate_submit" class="btn btn-primary">
            <span class="indicator-label">إنشاء المحافظة</span>
            <span class="indicator-progress">الرجاء الانتظار ...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
          </button>
          <!--end::Button-->
        </div>
        <!--end::Modal footer-->
      <div></div></form>
      <!--end::Form-->
    </div>
  </div>
</div>

