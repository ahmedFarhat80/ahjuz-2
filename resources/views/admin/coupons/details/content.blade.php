<div class="flex-lg-row-fluid ms-lg-15">
  <!--begin:::Tabs-->
  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8 justify-content-between">

    <!--begin:::Tab item-->
    <li class="nav-item">
      <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_coupon_view_overview_tab">تعديل الكوبون</a>
    </li>

    <div class="card-toolbar">
      <!--begin::More options-->
      <a href="#" class="btn btn-sm btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        الإجراءات
        <i class="fas fa-caret-down ms-2"></i>
      </a>
      <!--begin::Menu-->
      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-150px py-4" data-kt-menu="true" style="">
        <div class="menu-item px-5">
          <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}">
            @csrf @method('DELETE')
            <div class="menu-item px-3">
              <button onclick="destroy(event)" type="submit" class="btn btn-link text-danger">حذف الكوبون</button>          
            </div>
          </form>
        </div>
      </div>
      <!--end::Menu-->
      <!--end::More options-->
    </div>
    <!--end:::Tab item-->
    
  </ul>
  <!--end:::Tabs-->


  <!--begin:::Tab content-->
  <div class="tab-content" id="myTabContent">
    <!--begin:::Tab pane-->
    <div class="tab-pane fade show active" id="kt_coupon_view_overview_tab" role="tabpanel">
      <!--begin::Card-->
      <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">

        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
          <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
              <div class="col-md-6 mb-10">
                <label class="form-label">الرمز</label>
                <input type="text" name="code" value="{{ old('code') ?? $coupon->code }}" class="form-control form-control-solid"/>
                @error('code')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
                    
              <div class="col-md-6 mb-10">
                <label class="form-label">النوع</label>
                <select class="form-control form-control-solid" name="type">
                  <option value="">اختر نوع الكوبون</option>
                  @foreach ($types as $value => $type)
                      <option value="{{ $value }}" {{ $value == (old('type') ?? $coupon->type->value) ?  'selected' : ''}}> {{ $type }} </option>
                  @endforeach
                </select>
                @error('type')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-6 mb-10">
                <label class="form-label">القيمة</label>
                <input type="number" style="direction: rtl;" class="form-control form-control-solid" value="{{ old('value') ?? $coupon->value }}" name="value" placeholder="أدخل القيمة" required>
                @error('value')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-6 mb-10">
                <label class="form-label">أقصى عدد مرات الاستخدام</label>
                <input type="number" style="direction: rtl;" class="form-control form-control-solid" min="0" value="{{ old('max_use_count') ?? $coupon->max_use_count }}" name="max_use_count" placeholder="أدخل أقصى عدد مرات الاستخدام" required>
                @error('max_use_count')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-6 mb-10">
                <label class="form-label">يبدأ</label>
                <input type="date" class="form-control form-control-solid kt_datepicker_1" name="starts_at" value="{{ old('starts_at') ?? $coupon->starts_at->format('Y-m-d') }}" placeholder="أدخل تاريخ البدء" required>
                @error('starts_at')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-6 mb-10">
                <label class="form-label">ينتهي</label>
                <input type="date" class="form-control form-control-solid kt_datepicker_2" name="ends_at" value="{{ old('ends_at') ?? $coupon->ends_at->format('Y-m-d') }}" placeholder="أدخل تاريخ النهاية" required>
                @error('ends_at')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-6 mb-10">
                <label class="form-check form-switch form-check-custom form-check-solid mb-4">
                  <span class="form-check-label">
                    الحالة
                  </span>
                  <input name="status" type="hidden" value="{{ CouponStatus::Suspended }}">
                  <input name="status" class="form-check-input ms-2" type="checkbox" value="{{ CouponStatus::Active }}" {{ old('status') ?? $coupon->status->is(CouponStatus::Active) ? 'checked' : '' }}/>
                  @error('status')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </label>
                </div>
            </div>

              <button class="btn btn-primary">تحديث الكوبون</button>
          </form>
        </div>
        

      </div>
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