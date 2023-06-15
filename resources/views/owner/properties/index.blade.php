@extends('layouts.owner.index')
@section('content')

<!-- Start Page -->
<div id="mychalets">
    <div class="bar py-3 bg-primary text-white mb-3">
        <div class="container">
            <span> الرئيسية </span> <i class="fas fa-angle-left mx-2"></i> <span> ممتلكاتي </span>

        </div>
    </div>
    <div class="w-100 p-2"></div>
    <div class="container ">

        <h4 class="fw-bold d-inline"> ممتلكاتي </h4>
        <a class="btn btn-warning float-start" href="{{ route('owner.properties.create') }}"> <i class="fas fa-add"></i> إضافة جديد </a>
        <div class="row mt-4">
            @if ($properties->isNotEmpty())
                @foreach ($properties as $property)
                    <div class="col-12 mb-4 property">
                        <div class="chalet-item rounded bg-white text-end">
                            <div class="img position-relative">
                                @if ($property->is_special->is(PropertyIsSpecial::Yes))
                                    <span class="position-absolute text-white" style="right: 0; top: 13px; z-index: 10000; background-color: #fba710; padding: 3px 11px; font-size: 14px;">
                                        هذه الوحدة مميزة
                                    </span>
                                @endif
                                <span class="position-absolute rounded text-white" style="left: 13px; top: 13px; z-index: 10000; background-color: rgba(0, 0, 0, 0.4); padding: 3px 11px; font-size: 14px;">
                                    <i class="fas fa-eye ms-1"></i> {{ views($property)->remember(12*60)->count() }}
                                </span>
                                <div id="img{{ $property->id }}" class="carousel slide" data-mdb-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach ($property->imgs->take(5) as $key => $img)
                                            <button type="button" data-mdb-target="#img{{ $property->id }}" data-mdb-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}"></button>
                                        @endforeach
                                        </div>
                                    <div class="carousel-inner">
                                        @foreach ($property->imgs->take(5) as $key => $img)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ $img->name }}" class="d-block w-100" alt="{{ $property->name }}" />                        
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-mdb-target="#img{{ $property->id }}" data-mdb-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-mdb-target="#img{{ $property->id }}" data-mdb-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="content pt-3 pb-3 ps-3 pe-3 text-dark">
                                <h4 class="fw-bold"><a style="color:inherit" href="{{ route('properties.show', $property->slug) }}">{{ $property->name }}</a></h4>
                                <h6 class="text-muted d-block mt-3 mb-3"> الحالة : <span class="badge badge-{{ $property->statusClass }}">{{ $property->status->description }}</span> </h6>
                                <h6 class="text-muted d-block mt-3 mb-3"> كود الوحدة : <span> ({{ $property->code }}) </span> </h6>
                                <h6 class="text-warning"> <i class="fas fa-star ms-2"></i> 5 (440 تقييم) </h6>
                                <h6 class="text-muted mt-3 mb-3"> <i class="fas fa-map-marker-alt ms-2"></i> {{ $property->gov_reg }} </h6>
                                <a class="btn btn-success" href="{{ route('owner.properties.edit', $property->id) }}"> <i class="fas fa-edit ms-1"></i> تعديل بيانات الوحدة </a>
                                <a class="btn btn-secondary me-2" href="{{ route('owner.properties.bookings', $property->id) }}"> <i class="fas fa-calendar-check ms-1"></i> الحجوزات </a>

                                <form class="d-inline-block" action="{{ route('owner.properties.is_active', $property->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-info me-2"> 
                                        <i class="fas fa-stop ms-1"></i> {{ $property->is_active('text') }} تنشيط الوحدة
                                    </button>
                                </form>

                                <form class="d-inline-block" action="{{ route('owner.properties.destroy', $property->id) }}" onclick="event.preventDefault(); deletePropertyAjax(event, 'الوحدة')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger me-2"> 
                                        <i class="fas fa-trash ms-1"></i> حذف الوحدة 
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger my-5">
                    لا يوجد لك أي ممتلكات.
                </div>
            @endif

        </div>

    </div>
</div>
<!-- Eng Page -->

@endsection

@push('scripts')
    <script>
        $(".des-item").click(function() {
            $(this).next('.des-item-content').toggle();
            $(this).find('.fas').toggleClass('fa-angle-up');
            $(this).find('.fas').toggleClass('fa-angle-down');
        });
    </script>

    <script>
        function deletePropertyAjax(event, text) {
            var form =  $(event.target.closest('form'));
            var route = form.attr('action');
            // call ajaxData function with args
            deleteAjax(text, ajaxDeleteData, [form, route])
        }

        function ajaxDeleteData(form, route) {
            $.ajax({
                url         :       route,
                type        :       "DELETE",
                data        :       form.serialize(),
                success     :       function(data) { 

                                        form.closest('div.property').fadeOut(1000, function () {
                                            $(this).remove();
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