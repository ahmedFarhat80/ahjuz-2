@extends('layouts.customer.index')

@push('styles')
<style>
  .attachment_text {
    min-width: 0;
    text-overflow: ellipsis;
    width: 150px;
    overflow: hidden;
    white-space: nowrap;
  }
</style>
@endpush

@section('content')

<div class="container">
  <div class="messages mt-5">
    <h5 class="fw-bold mb-4"> الرسائل </h5>
    <div class="row">
      <div class="col-lg-8">
        <div class="messages-box bg rounded" style="background-color: #f9f9f9">
          @if ($conversation->messages->isNotEmpty())
            @foreach ($conversation->messages as $message)
              @include('customer.messages.show.message')
            @endforeach
            @else
              <div class="alert alert-danger my-5 ms_empty">لا يوجد أي رسائل</div>
          @endif
          
        </div>
        <form id="add_message" action="{{ route('messages.store', $conversation->id) }}" method="POST" enctype="multipart/form-data"> @csrf
            <textarea name="body" class="form-control mt-3" style="height: 170px" placeholder="ادخل الرسالة"></textarea>
            <div class="btn btn-outline-primary mt-3 mb-5 attachment_text" onclick="document.getElementById('attachment').click()"> إرفاق ملف </div> 
            <input id="attachment" type="file" name="attachment" class="d-none">
            <button type="submit" class="btn btn-primary mt-3 mb-5"> إرسال </button>  
        </form>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="rounded" style="background-color: #f9f9f9">
          <div class="p-3 fw-bold border-bottom">
            بيانات التواصل
            <ul class="p-0 mt-3">
              <li class="d-flex justify-content-between">
                <span class="text-muted">اسم الوحدة:</span>
                <span>{{ $conversation->property->name }}</span>
              </li>
              <li class="d-flex justify-content-between">
                <span class="text-muted">اسم المالك:</span>
                <span>{{ $conversation->property->owner->full_name }}</span>
              </li>
              <li class="d-flex justify-content-between">
                <span class="text-muted">رقم الهاتف:</span>
                <span dir="ltr">{{ country_code($conversation->property->owner->phone) }}</span>
              </li>
              <li class="d-flex justify-content-between">
                <span class="text-muted">البريد الالكتروني:</span>
                <span dir="ltr">{{ $conversation->property->owner->email }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>

$(document).on('submit', '#add_message', function(e) {
  e.preventDefault();
  var form =  $(this);
  form.find('button').attr("disabled", true);

  $.ajax({
      url: form.attr('action'),
      type: "POST",
      dataType: "json",
      processData: false,
      contentType: false,
      data: new FormData(this),
      success: function(data) {

        $('.messages-box').fadeOut(function () {
          $('.ms_empty').remove()
          form.find('button').attr("disabled", false);
          $('.attachment_text').text('إرفاق الملف')
          $('#attachment').val(null)
          $(this).append(data.message_html)
          form.find('textarea').val('')
        }).fadeIn(); 

      },
      error:function(data) { 
        form.find('button').attr("disabled", false);
        if (error = Object.values(data.responseJSON.errors)[0][0]) {
            Toast.fire({
                icon: 'error',
                title: error
            })
        }
      },
  });
});

$(document).on('change', '#attachment', function(e) {
  $('.attachment_text').text(e.target.files[0].name)
});

</script>
@endpush