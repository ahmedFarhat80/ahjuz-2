@extends('layouts.customer.index')
@push('styles')
    <style>
        .properties_pagination *{
            font-size:19px!important;
        }
        .parent *{
            font-size:inherit!important;
        }
        .typeahead.dropdown-menu {
            right: 0 !important;
            text-align: right!important;
            padding-right: 5px!important;
            z-index: 999999999999!important;
        }
    </style>
@endpush
@section('content')

<!-- Start Page -->
<div id="searchpage">

    <div class="bar py-3 bg-primary text-white">
        <div class="container">
            <span> الرئيسية </span> <i class="fas fa-angle-left mx-2"></i> <span> البحث </span>
        </div>
    </div>
    
    <div class="container">
        <section class="cta rounded w-100 text-end border-0" style="padding: 1.12rem 0 !important;">
            <form id="search_form" action="{{ route('search') }}" method="GET" class="d-flex bg-white shadow-sm align-items-center">
                <div class="position-relative w-100">
                    <input id="search" name="search" value="{{ request()->search }}" type="text" dir="rtl" placeholder="أدخل الاسم أو الوصف أو العنوان" class="w-100 me-1" autocomplete="off">
                </div>
                <div class="position-relative w-100">
                    <i class="fas fa-calendar ms-3 me-3 text-muted"></i>
                    <span name="date" class="w-100" id="kt_daterangepicker_1" autocomplete="off" style="cursor: pointer">تاريخ الوصول / المغادة</span>
                    <span id="clear-date" class="ms-3" style="cursor: pointer;float: left;display:none"><i class="fa fa-times-circle rounded" style="color: #757575"></i></span>
                    <input name="starts_at" type="hidden"/>
                    <input name="ends_at" type="hidden"/>
                </div>
                <div class="position-relative w-100" style="border-right: 1px solid #DEDEDE !important;padding: 14px 1px!important;">
                    <i class="fas fa-calendar-alt ms-3 me-3 text-muted"></i>
                    <span id="days" class="w-100">مدة الحجز</span>
                </div>
                <input type="submit" class="w-50 bg-secondary text-light" value="بحث">    
            </form>
        </section>
    </div>

    <div class="container mt-5">
        <h4 style="font-weight: 500; margin-bottom: 20px;"> وجدنا <span class="text-primary"> (<span id="properties_count">{{ $properties->total() }}</span>) </span> وحدة توافق نتائج بحثك </h4>
        <div class="row">

            @include('customer.search.filter') 

            <div id="properties" class="col-md-9 col-12">
                @include('customer.search.properties')  
            </div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    $('#search').typeahead({
        source: function (query, process) {
            return $.get('/autocomplete-search', {
                query: query
            }, function (data) {
                return process(data);
            });
        }
    })
</script>

<script>
    @if(request()->starts_at && request()->ends_at)
        $('#kt_daterangepicker_1').data('daterangepicker').setStartDate('{{ request()->starts_at }}');
        $('#kt_daterangepicker_1').data('daterangepicker').setEndDate('{{ request()->ends_at }}');
        setDates('{{ request()->starts_at }}', '{{ request()->ends_at }}');
        $('#clear-date').show();
    @endif

    $('#kt_daterangepicker_1').on('apply.daterangepicker', function(ev, picker) {
        setDates(picker.startDate.format('YYYY/MM/DD'), picker.endDate.format('YYYY/MM/DD'));
        $('#clear-date').show();
    });

    $(document).on('click', '#clear-date', function(e) {
        setDates('', '')
        $('#kt_daterangepicker_1').text('تاريخ الوصول / المغادة')
        $('#days').text('مدة الحجز')
        $(this).hide()
    });
</script>

<script>
    $(document).on('change', 'select[name="governorate_id"]', function() {
        var r = $('select[name="region_id"]');
        r.empty();
        r.append(`<option value="">كل المناطق</option>`)
        if (governorate_id = $(this).val()) {
            $.ajax({
                url: `/governorates/${governorate_id}`,
                type:"GET",
                dataType:"json",
                success:function(data) { 
                    data.forEach( function (value) {
                        r.append(`<option value="${value.id}">${value.name}</option>`)
                    });
                },
            });
        }
    });
    
    $(document).on('change', '#filter_form', function() {
        getData($(this).attr('action'))
    });
    
    $(document).on('click', '#properties_pagination a', function(e) {
        e.preventDefault();
        getData($(this).attr('href'))
    });

    function getData(route) {
        $.ajax({
            url: route,
            type:"GET",
            dataType:"json",
            data:$('#filter_form').serialize(),
            success:function(data) { 
                $('#properties').fadeOut(700, function () {
                    $('#properties_pagination').html(data.pagination);
                    $('#properties').html(data.properties_html);
                    $('#properties_count').html(data.properties_count);
                }).fadeIn(700);
            },
        });
    }
</script>
@endpush
