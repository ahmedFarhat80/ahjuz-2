<div class="flex-lg-row-fluid ms-lg-15">
  <!--begin:::Tabs-->
  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8 justify-content-between">

    <!--begin:::Tab item-->
    <li class="nav-item">
      <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_region_view_overview_tab">تعديل المنطقة</a>
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
          <form method="POST" action="{{ route('admin.regions.destroy', $region->id) }}">
            @csrf @method('DELETE')
            <div class="menu-item px-3">
              <button onclick="destroy(event)" type="submit" class="btn btn-link text-danger">حذف المنطقة</button>          
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
    <div class="tab-pane fade show active" id="kt_region_view_overview_tab" role="tabpanel">
      <!--begin::Card-->
      <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">

        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
          <form action="{{ route('admin.regions.update', $region->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
              <div class="col-md-6 mb-10">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" value="{{ old('name') ?? $region->name }}" class="form-control form-control-solid"/>
                @error('name')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
                    
              <div class="col-md-6 mb-10">
                <label class="form-label">المحافظة</label>
                <select class="form-control form-control-solid" name="governorate_id">
                  <option value="">اختر المحافظة</option>
                  @foreach ($governorates as $value => $governorate)
                      <option value="{{ $value }}" {{ $value == (old('governorate_id') ?? $region->governorate_id) ?  'selected' : ''}}> {{ $governorate }} </option>
                  @endforeach
                </select>
                @error('governorate_id')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

            </div>

              <button class="btn btn-primary">تحديث المنطقة</button>
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