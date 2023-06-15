<div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
  <!--begin::Card-->
  <div class="card card-flush pt-3 mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
      <!--begin::Card title-->
      <div class="card-title">
        <h2 class="fw-bolder">تفاصيل المحادثة</h2>
      </div>
      <!--begin::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-3">

      <div class="row">
        <div class="col-12">
          <div class="messages-box bg rounded" style="background-color: #f9f9f9">
            @if ($conversation->messages->isNotEmpty())
              @foreach ($conversation->messages as $message)
                @include('admin.conversations.details.message')
              @endforeach
              @else
                <div class="alert alert-danger my-5 ms_empty">لا يوجد أي رسائل</div>
            @endif
          </div>
        </div>
      </div>

    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->
</div>
