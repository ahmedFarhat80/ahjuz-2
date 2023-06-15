@extends('layouts.admin.app')

@push('styles')
@endpush

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Toolbar-->
    @include('admin.properties.details.breadcrumb')
  <!--end::Toolbar-->

  <!--begin::Post-->
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      <!--begin::Layout-->
      <div class="d-flex flex-column flex-lg-row">

        <!--begin::Content-->
        @include('admin.properties.details.content')
        <!--end::Content-->

      </div>
      <!--end::Layout-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Post-->
</div>


@endsection

@push('scripts')
  <script src="{{ asset('admin-panel/plugins/custom/datatables/datatables.bundle.js') }}"></script>

  <script>
    function updatePropertyAjax(event) {
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
                                            title: 'تم التحديث بنجاح',
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