@extends('layouts.owner.index')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <style>
        .dropzone .dz-remove {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 1.65rem;
            width: 1.65rem;
            font-size: 1rem;
            text-indent: -9999px;
            white-space: nowrap;
            position: absolute;
            z-index: 2;
            background-size: 40%;
            background-color: #ffffff !important;
            box-shadow: 0 0.1rem 1rem 0.25rem rgb(0 0 0 / 5%);
            border-radius: 100%;
            top: -0.825rem;
            right: -0.825rem;
            background-repeat: no-repeat;
            background-position: center;
            background-color: transparent;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23A1A5B7'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e");
        }
    </style>
    <style>
        .overflow {
            width: 100%;
            height: 100%;
            position: absolute;
            background: #000;
            opacity: 0.3;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
        }
    </style>
@endpush

@section('content')

<!-- Start Content -->
<div class="add-chalet-page">
    <div class="container mt-6">

        <!-- Horizontal Steppers -->
          <h5 class="mb-3 text-primary text-center">تعديل الوحدة</h4>
          <div class="row">
              <form  action="{{ route('owner.properties.update', $property->id) }}" method="POST">
                  @csrf @method('PUT')

                  <div class="col-12 mb-5 p-5 bg-white shadow rounded">
                      <div class="row ">

                          <div class="col-6 mb-3 ">
                              <label for="# "> نوع القسم </label>
                              <select class="form-control mt-1 mb-3" name="type">
                                  <option value="">اختر نوع القسم</option>
                                  @foreach ($types as $value => $type)
                                      <option value="{{ $value }}" {{ $value == ( old('type') ?? "$property->type") ?  'selected' : ''}} > {{ $type }} </option>
                                  @endforeach
                              </select>
                              @error('type')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> اسم الوحدة </label>
                              <input type="text" name="name" value="{{ $property->name ?? old('name') }}"  class="form-control mt-1  mb-3" placeholder="أدخل اسم الوحدة ">
                              @error('name')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> المكان مخصص </label>
                              <select class="form-control mt-1 mb-3" name="for">
                                  <option value="">اختر نوع تخصص المكان</option>
                                  @foreach ($for as $value => $row)
                                      <option value="{{ $value }}" {{ $value == ( old('for') ?? "$property->for") ?  'selected' : ''}}> {{ $row }} </option>
                                  @endforeach
                              </select>
                              @error('for')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          
                          <div class="col-6 mb-3 ">
                              <label for="# "> المساحة </label>
                              <input type="text" name="area" value="{{ old('area') ?? $property->area }}" class="form-control mt-1  mb-3" placeholder="أدخل المساحة بالمتر المربع ">
                              @error('area')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> وقت الدخول </label>
                              <input type="time" name="opens_at" value="{{ old('opens_at') ?? $property->opens_at->isoFormat('HH:mm')  }}" class="form-control mt-1  mb-3">
                              @error('opens_at')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          
                          <div class="col-6 mb-3 ">
                              <label for="# "> وقت الخروج </label>
                              <input type="time" name="closes_at" value="{{ old('closes_at') ?? $property->closes_at->isoFormat('HH:mm') }}" class="form-control mt-1  mb-3">
                              @error('closes_at')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> سعر اليوم العادي (د.ك) </label>
                              <input type="text" name="day_price" value="{{ old('day_price') ?? $property->day_price }}" class="form-control mt-1 mb-3" placeholder="أدخل سعر اليوم العادي">
                              @error('day_price')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> سعر اليوم الخميس  (د.ك) </label>
                              <input type="text" name="thursday_price" value="{{ old('thursday_price') ?? $property->thursday_price }}" class="form-control mt-1 mb-3" placeholder="أدخل سعر اليوم الخميس">
                              @error('thursday_price')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> سعر اليوم الجمعة (د.ك) </label>
                              <input type="text" name="friday_price" value="{{ old('friday_price') ?? $property->friday_price }}" class="form-control mt-1 mb-3" placeholder="أدخل سعر اليوم الجمعة">
                              @error('friday_price')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          
                          <div class="col-6 mb-3 ">
                            <label for="# "> مبلغ التـأمين (اختياري) </label>
                            <input type="text" name="insurance_price" value="{{ old('insurance_price') ?? $property->insurance_price }}" class="form-control mt-1  mb-3" placeholder="أدخل مبلغ التـأمين ">
                              @error('insurance_price')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-12 mb-3 ">
                              <label for="# "> الوصف </label>
                              <textarea class="form-control mt-1  mb-3" style="height: 100px;" name="description">{{ old('description') ?? $property->description }}</textarea>
                              @error('description')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> المحافطة </label>
                              <select class="form-control mt-1 mb-3" name="governorate_id">
                                  <option value="">اختر المحافظة</option>
                                  @foreach ($governorates as $id => $governorate)
                                      <option value="{{ $id }}" {{ $id == (old('governorate_id') ?? $property->address->governorate_id) ?  'selected' : ''}}> {{ $governorate }} </option>
                                  @endforeach
                              </select>
                              @error('governorate_id')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-6 mb-3 ">
                              <label for="# "> المنطقة </label>
                              <select class="form-control mt-1 mb-3" name="region_id">
                                  <option value="">اختر المنطقة</option>
                                  @foreach ($property->address->governorate->regions as $region)
                                    <option value="{{ $region->id }}" {{ $property->address->region_id === (old('region_id') ?? $region->id) ? 'selected' : '' }}>
                                      {{ $region->name }}
                                    </option>
                                  @endforeach          
                              </select>
                              @error('region_id')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-12 mb-3 ">
                              <label for="# "> تفاصيل العنوان </label>
                              <input type="text" name="address_details" value="{{ old('address_details') ?? $property->address->details }}" class="form-control mt-1  mb-3" placeholder="أدخل تفاصيل العنوان ">
                              @error('address_details')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="col-12 mb-3 ">
                              <label for="# " class="d-block mb-1 "> الصور </label>
                              <!--begin::Dropzone-->
                              <div class="dropzone mb-3" id="id_dropzone">
                                  <div class="dz-message needsclick">
                                      <div class="ms-4">
                                          <h3 class="fs-5 fw-bolder text-gray-900 mb-1"> اسحب و القِ الصور هنا أو اضغط للرفع</h3>
                                          <span class="fs-7 fw-bold text-gray-400">أقصى حجم 8 ميجابايت</span>
                                      </div>
                                      <i class="fa fa-arrow-down text-primary fa-2x"></i>
                                  </div>
                              </div>
                              @if (old('imgs') && (count(old('imgs')) - count($property->imgs)) > 0)
                                  <div class="text-success d-block mb-3" role="alert">
                                      <strong>تم  رفع  {{ count(old('imgs')) - count($property->imgs) }} صورة/صور بنجاح</strong>
                                  </div>

                                  @foreach (old('imgs') as $img)
                                      <input type="hidden" name="imgs[]" value="{{ $img }}">
                                  @endforeach
                              @endif

                              @if (!old('imgs') && $property->imgs)
                                  @foreach ($property->imgs as $img)
                                      <input type="hidden" name="imgs[]" value="{{ $img->name }}">
                                  @endforeach
                              @endif


                              @error('imgs')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                              <!--end::Dropzone-->
                          </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="projectinput1" class="">اختر موقع الوحدة الخاصة بك</label>
                                            <input type="text" id="search_input" class="form-control" placeholder="ابحث هنا">
                                            <input name="latitude" type="hidden" id="latitude" required value="{{ old('latitude') ?? $property->address->latitude }}">
                                            <input name="longitude" type="hidden" id="longitude" required value="{{ old('longitude') ?? $property->address->longitude }}">
                                        </div>
                                    </div>
                                </div>
                                <div id="map" style="height:500px"></div>
                            </div>

                            <div class="col-12 mt-3 mb-3">
                                <div class="checkbox">
                                    <label class="d-flex align-items-center">
                                        <span class="ms-2">هل الوحدة جاهزة للعرض على الموقع؟</span>
                                        <input name="is_active" type="hidden" value="{{ PropertyIsActive::No }}">
                                        <input type="checkbox" name="is_active" data-toggle="toggle" data-on="نعم" data-off="لا" value="{{ PropertyIsActive::Yes }}" {{ $property->is_active('checked')}}>
                                    </label>
                                </div>    
                            </div>

                            <div class="col-12 mt-3 mb-5">
                                    <label class="d-flex align-items-center">
                                        <span class="ms-2">الحالة</span>
                                        <td class="ms-2"><span class="badge badge-{{ $property->statusClass }}">{{ $property->status->description }}</span></td>
                                    </label>
                            </div>

                          <div class="col-4"></div>
                          <div class="col-4">
                              <button class="btn btn-primary w-100" type="submit"> المتابعة
                              </button>
                          </div>
                          <div class="col-4"></div>
                      </div>
                  </div>
              </form>

            <div class="col-12 mb-5 p-5 bg-white shadow rounded">
                <h5 class="text-primary mb-4">الصور الخاصة بالوحدة</h5>
                @foreach ($property->imgs as $img)
                    <div class="img-item m-2 d-inline-block position-relative">
                        <img src="{{ $img->name }}" class="rounded" style="height: 120px; width: 120px;" alt="{{ $property->name }}">
                        <form action="{{ route('owner.properties.img') }}" onclick="event.preventDefault(); deleteImgAjax(event, 'الصورة')">
                            @csrf @method('DELETE')
                            <input type="hidden" name="imgID" value="{{ $img->id }}">
                            <button class="btn p-0 m-0 position-absolute shadow-0 text-white" style="top: 6px; right: 6px; z-index: 10000;">
                                <i class="fas fa-times-circle rounded"></i>
                            </button>    
                        </form>
                        <div class="overflow rounded"></div>
                    </div>    
                @endforeach
            </div>
          </div>
    </div>
</div>
<!-- End Content -->

@endsection

@push('scripts')
<script src="{{ asset('frontend/js/google_map.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQDC3VV5CGRaueUYpEEJ308KNx8zbG5t0&libraries=places&callback=initAutocomplete&language=en&region=kw"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
    $(document).on('change', 'select[name="governorate_id"]', function() {
        get_region($(this).val(), null)
    });

    var governorate_id = parseInt("{{ old('governorate_id') }}");
    var region_id = parseInt("{{ old('region_id') }}");

    if (governorate_id) {
        get_region(governorate_id, region_id)
    }

    function get_region(governorate_id, region_id) {
        if (governorate_id) {         
            $.ajax({
                url: `/governorates/${governorate_id}`,
                type:"GET",
                dataType:"json",
                success:function(data) { 
                var r = $('select[name="region_id"]');
                r.empty();
                data.forEach( function (value) {
                    var selected = value.id == region_id ? 'selected' : '';
                    r.append(`<option value="${value.id}" ${selected} >${value.name}</option>`)
                } );
                },
            });
        }
    }
</script>

<script>

    Dropzone.autoDiscover = false;
    var uploadedDocumentMap = {}
    var myDropzone = new Dropzone("#id_dropzone", {
            url: "/owner/properties/img",
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
	        maxFiles: 20, 
            maxFilesize: 8,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file) 
            {
                if (this.options.dictRemoveFile) {
				    return Dropzone.confirm("هل أنت متأكد أنك تريد حذف الصورة", function() {
                    var name = file.previewElement.name;

					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
                        type: 'delete',
                        url: '/owner/properties/img',
						data: {filename: name},
						success: function (data){
							alert('تم الحذف بنجاح');
						},
						error: function(e) {
							console.log(e);
						}});
						var fileRef;
						(fileRef = file.previewElement) != null ? 
						fileRef.parentNode.removeChild(file.previewElement) : void 0;


                        var fname = ''
                        if (typeof name !== 'undefined') {
                            fname = name
                        } else {
                            fname = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="imgs[]"][value="' + fname + '"]').remove()
				   });
			    }		
            },
       
            success: function(file, response) 
            {
                file.previewElement.name = response;
                var olddatadzname = file.previewElement.querySelector("[data-dz-name]");   
				file.previewElement.querySelector("img").alt = response;
				olddatadzname.innerHTML = response.replace(/^.*[\\\/]/, '');
                olddatadzname.dir="ltr";

                $('form').append('<input type="hidden" name="imgs[]" value="' + response + '">')
                uploadedDocumentMap[file.name] = response

            },
            error: function(file, response)
            {
               if($.type(response) === "string")
					var message = response; //dropzone sends it's own error messages in string
				else
					var message = response.message;
				file.previewElement.classList.add("dz-error");
				_ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
				_results = [];
				for (_i = 0, _len = _ref.length; _i < _len; _i++) {
					node = _ref[_i];
					_results.push(node.textContent = message);
				}
				return _results;
            }
            
    })

    with (myDropzone.options) {
        dictDefaultMessage = "اسحب الصور هنا أو اضغط للرفع";
        dictFallbackMessage = "المتصفح الخاص بك لا يدعم السحب والإلقاء";
        dictFileTooBig = "حجم الملف كبير، أقصى حجم هو @{{maxFilesize}}MB";
        dictInvalidFileType = "لا تستطيع رفع ملفات من هذا النوع";
        dictCancelUpload = "إلفاء الرفع";
        dictCancelUploadConfirmation = "هل أنت متأكد أنك تريد إلفاء الرفع؟";
        dictRemoveFile = "حذف";
        dictMaxFilesExceeded = "لا تستطيع رفع ملفات أكثر من ذلك";
    };

</script>

<script>
    function deleteImgAjax(event, text) {
        var form =  $(event.target.closest('form'));
        var route = form.attr('action');
        // call ajaxData function with args
        deleteAjax(text, ajaxData, [form, route])
    }

    function ajaxData(form, route) {
        $.ajax({
            url         :       route,
            type        :       "DELETE",
            data        :       form.serialize(),
            success     :       function(data) { 
                console.log(data);
                                    form.closest('div').fadeOut(1000, function () {
                                        $(this).remove();
                                        $(`input[value='${data}']`).remove();
                                    });

                                    Swal.fire({
                                            icon: 'success',
                                            title: 'تم الحذف',
                                            showConfirmButton: false,
                                            timer: 1500
                                    })

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
