<!--begin::Modal - New Address-->
<div class="modal fade" id="kt_modal_update_owner" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <!--begin::Modal content-->
    <div class="modal-content">
      <!--begin::Form-->
      <form class="form"  novalidate="novalidate" action="{{ route('admin.owners.update', $owner->id) }}" id="kt_modal_update_owner_form" enctype="multipart/form-data">
        @method('PUT')
        <!--begin::Modal header-->
        <div class="modal-header" id="kt_modal_update_owner_header">
          <!--begin::Modal title-->
          <h2 class="fw-bolder">تحديث بيانات المالك</h2>
          <!--end::Modal title-->
          <!--begin::Close-->
          <div id="kt_modal_update_owner_close" class="btn btn-icon btn-sm btn-active-icon-primary">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
              </svg>
            </span>
            <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-10 px-lg-17">
          <!--begin::Scroll-->
          <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_owner_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_owner_header" data-kt-scroll-wrappers="#kt_modal_update_owner_scroll" data-kt-scroll-offset="300px" style="max-height: 52px;">
              <!--begin::Input group-->
              <div class="mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-bold mb-2">
                  <span>تحديث الصورة الشخصية</span>
                  <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="الأنواع المسموحة: png, jpg, jpeg."></i>
                </label>
                <!--end::Label-->
                <!--begin::Image input wrapper-->
                <div class="mt-1 fv-row">
                  <!--begin::Image input-->
                  <div class="image-input image-input-outline {{ $owner->getRawOriginal('avatar') ? '' : 'image-input-empty'}}" data-kt-image-input="true" style="background-image: url({{ asset('frontend/img/avatar.png') }})">
                    <!--begin::Preview existing avatar-->
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset($owner->avatar) }})"></div>
                    <!--end::Preview existing avatar-->
                    <!--begin::Edit-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-original-title="تغيير الصورة الشخصية">
                      <i class="bi bi-pencil-fill fs-7"></i>
                      <!--begin::Inputs-->
                      <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                      <input type="hidden" name="avatar_remove">
                      <div class="invalid-feedback"></div>
                      <!--end::Inputs-->
                    </label>
                    <!--end::Edit-->
                    <!--begin::Cancel-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="الغاء">
                      <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Cancel-->
                    <!--begin::Remove-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="ازالة">
                      <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Remove-->
                  </div>
                  <!--end::Image input-->
                </div>
                <!--end::Image input wrapper-->
              </div>
              <!--end::Input group-->

            <!--begin::Input group-->
            <div class="fv-row mb-7 fv-plugins-icon-container">
              <!--begin::Label-->
              <label class="required fs-6 fw-bold mb-2">الاسم الأول</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input type="text" class="form-control form-control-solid" name="first_name" value="{{ $owner->first_name }}" placeholder="أدخل الاسم الأول" required autocomplete="off">
              <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div></div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7 fv-plugins-icon-container">
              <!--begin::Label-->
              <label class="required fs-6 fw-bold mb-2">اسم العائلة</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input type="text" class="form-control form-control-solid" name="last_name" value="{{ $owner->last_name }}" placeholder="أدخل اسم العائلة" required>
              <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div></div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7 fv-plugins-icon-container">
              <!--begin::Label-->
              <label class="required fs-6 fw-bold mb-2">العنوان</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input type="text" class="form-control form-control-solid"  name="address" value="{{ $owner->address }}" placeholder="أدخل العنوان" dir="ltr" style="text-align: right" required>
              <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div></div>
            <!--end::Input group-->
              <!--begin::Input group-->
              <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fs-6 fw-bold mb-2">رقم الهاتف (965+)</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control form-control-solid" name="phone" value="{{ $owner->phone }}" placeholder="أدخل رقم الهاتف" required>
                <!--end::Input-->
              </div>
              <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-15 fv-plugins-icon-container">
              <!--begin::Label-->
              <label class="required fs-6 fw-bold mb-2">البريد الالكتروني</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input type="email" class="form-control form-control-solid" dir="auto" value="{{ $owner->email }}" direction="auto" name="email" placeholder="أدخل البريد الإلكتروني" required>
              <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div></div>
            <!--end::Input group-->

          </div>
          <!--end::Scroll-->
        </div>
        <!--end::Modal body-->
        <!--begin::Modal footer-->
        <div class="modal-footer flex-center">
          <!--begin::Button-->
          <button type="reset" id="kt_modal_update_owner_cancel" class="btn btn-light me-3">تجاهل</button>
          <!--end::Button-->
          <!--begin::Button-->
          <button type="submit" id="kt_modal_update_owner_submit" class="btn btn-primary">
            <span class="indicator-label">تحديث المالك</span>
            <span class="indicator-progress">الرجاء الانتظار ...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
          </button>
          <!--end::Button-->
        </div>
        <!--end::Modal footer-->
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>
<!--end::Modal - New Address-->