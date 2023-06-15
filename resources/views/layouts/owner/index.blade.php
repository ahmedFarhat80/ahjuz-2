<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> @yield('title', 'احجز') </title>
    
    <link rel="shortcut icon" href="{{ asset('frontend/img/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @stack('styles')

    <style>
        .swal2-container {
            z-index: 90000000000 !important;
        }
        .page-item.active .page-link{
            background-color: var(--main-color) !important
        }
        .daterangepicker{
            z-index: 9999999999;
            font-family: cairo;
        }
        .cancelBtn, .applyBtn, .drp-calendar th  {
            font-size: 11px !important;
        }
        .drp-selected{
            margin-right: auto !important;
            font-size: 14px !important;
            margin-bottom: 8px;
            font-weight: 600
        }
    </style>
</head>

<body>

    @include('layouts.owner.navbar')

    @yield('content')

    @include('layouts.customer.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript " src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        moment.locale('ar');
        $("#kt_daterangepicker_1").daterangepicker({
            locale: {
                "format": "YYYY/MM/DD",
                "separator": " - ",
                "applyLabel": "متابعة",
                "cancelLabel": "إلغاء",
                "fromLabel": "من",
                "toLabel": "إالى",
                "customRangeLabel": "مخصص",
                "firstDay": 6,
                "daysOfWeek": [
                    "أحد",
                    "اثنين",
                    "ثلاثاء",
                    "أربعاء",
                    "خميس",
                    "جمعة",
                    "سبت"
                ],
                "monthNames": [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "أبريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "أغسطس",
                    "سبتمبر",
                    "أكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
            },
            "minDate": moment().format('YYYY/MM/DD'),
            "startDate": moment().format('YYYY/MM/DD'),
            "endDate":  moment().add(1,'days').format('YYYY/MM/DD')
    
            // autoApply :true,
      })
    
    </script>
    @stack('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        @if(Session::has('message'))
            var type="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'info':
                    Toast.fire({
                        icon: type,
                        title: "{{ Session::get('message') }}"
                    })
                    break;
                case 'success':
                    Toast.fire({
                        icon: type,
                        title: "{{ Session::get('message') }}"
                    })
                    break;
                case 'warning':
                    Toast.fire({
                        icon: type,
                        title: "{{ Session::get('message') }}"
                    })

                    break;
                case 'error':
                    Toast.fire({
                        icon: type,
                        title: "{{ Session::get('message') }}"
                    })
                    break;
            }
        @endif
    </script> 
    
    <script>
        function deleteAjax(mytext, callback, args) {

            Swal.fire({
                    title: `هل أنت متأكد أنك تريد حذف ${mytext}؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: "لا، الغ",
            }).then((result) => {
                    if (result.isConfirmed) {
                        return callback.apply(this, args);
                }
            })
	    }
    </script>

    <script>
        function destroy(event) {
            event.preventDefault(); 
                    
            var text = $(event.target).text()
            var form =  $(event.target.closest('form'))

            if (formaction = $(event.target).attr('formaction')) {
            form.attr('action', formaction)
            }

            var route = form.attr('action');

            Swal.fire({
                                title: `هل أنت متأكد أنك تريد  ${text}؟`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'نعم، احذف',
                                cancelButtonText: "لا، الغ",
                }).then((result) => {
                        if (result.isConfirmed) {
                                
                            $.ajax({
                                url         :       route,
                                type        :       "DELETE",
                                data        :       form.serialize(),
                                success     :       function(data) { 
                                                                                Swal.fire({
                                                                                                icon: 'success',
                                                                                                title: 'تم الحذف',
                                                                                                showConfirmButton: false,
                                                                                                timer: 1500
                                                                                }).then(() => window.location.href = data);
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

                })
		}

    </script>


@auth('owner')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        
        Pusher.logToConsole = true;
        // Initiate the Pusher JS library
        var pusher = new Pusher('d24f21b2089729c451f7', {
            cluster: 'mt1',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }
        });

        var channel = pusher.subscribe('private-App.Models.Owner.' + {{ auth_owner()->id }});

        channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
            console.log(data);

            switch (data.type) {
                case 'PropertyStatus':
                    return fireNotification(`تم ${data.status} الوحدة الخاصة بك`, '/owner')
                    break;
                case 'BookingIsCreated':
                    return fireNotification('يوجد لديك حجز جديد', `/properties/${data.property_id}/bookings`)
                    break;
                case 'BookingIsCanceled':
                    return fireNotification('تم إلغاء حجز لديك',  `/properties/${data.property_id}/bookings`)
                    break;
                case 'NewMessage':
                    return fireMessageNotification('يوجد لديك رسالة جديدة', `/owner/messages/${data.property_id}/${data.customer_id}`, data.name,  data.property_name, data.message)
                    break;
            }
        })

        function fireNotification(message, route) {
            
            var count = parseInt($('#count_notifications').text())

            if (!count) {
                $('#ul_notifications').text('')
            }

            $('#count_notifications').text(parseInt(count + 1)).show()

            Toast.fire({
                icon: 'info',
                title: message
            })

            $('#ul_notifications').prepend(`
                <li style="background-color: #eee">
                    <a class="dropdown-item" href="${route}" style="white-space: normal;">
                        <strong>${message}</strong>
                        <div class="text-muted">منذ لحظات</div>
                    </a>
                </li>
            `)
        }

        function fireMessageNotification(message, route, name, property_name, body) {
                var count_messages = parseInt($('#count_messages_notifications').text())

                if (!count_messages) {
                    $('#ul_messages_notifications').text('')
                }

                $('#count_messages_notifications').text(parseInt(count_messages + 1)).show()

                Toast.fire({
                    icon: 'info',
                    title: message
                })

                $('#ul_messages_notifications').prepend(`
                    <li style="background-color: #eee">
                        <a class="dropdown-item" href="${route}" style="white-space: normal;">
                            <strong> يوجد لديك رسالة من ${name} بخصوص  ${property_name}.</strong>
                            <span>${body}</span>
                            <div class="text-muted">منذ لحظات</div>
                        </a>
                    </li>
                `)
        }
    </script> 
@endauth


</body>

</html>