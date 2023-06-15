<!DOCTYPE html>

<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
	<!--begin::Head-->
	<head><base href="">
		<title>احجز</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="shortcut icon" href="{{ asset('frontend/img/favicon.ico') }}">
		<!--begin::Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
		<!--end::Fonts-->

		@stack('styles')

		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('admin-panel/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin-panel/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<style>
			input[type="email"]::placeholder {text-align: right !important}
			input[type="password"]::placeholder {text-align: right !important}
		</style>
		
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		
		<!--begin::Main-->

		@yield('main')

		<!--end::Main-->

		<!--begin::Javascript-->
		<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('admin-panel/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('admin-panel/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->

		@stack('scripts')

    <script>
			const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
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

			function updateAjax(mytext, callback, args) {
				Swal.fire({
					title:  `هل أنت متأكد أنك تريد ${mytext}؟`,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'تأكيد',
					cancelButtonText: "تراجع",
				}).then((result) => {
					if (result.isConfirmed) {
						return callback.apply(this, args);
					}
				});
      }

		</script>

		@auth('admin')
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
		
				var channel = pusher.subscribe('private-App.Models.Admin.' + {{ auth_admin()->id }});
		
				channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
						console.log(data);
		
						var count = parseInt($('#count_notifications').text())
		
						if (!count) {
								$('#ul_notifications').text('')
						}
		
						$('#count_notifications').text(parseInt(count + 1)).show()
		
						switch (data.type) {
								case 'PropertyIsCreated':
										return fireNotification(`طلب موافقة على وحدة جديدة`, `/admin/properties/${data.property_id}`)
										break;
						}
				})
		
				function fireNotification(message, route) {
						Toast.fire({
								icon: 'info',
								title: message
						})
		
						$('#ul_notifications').prepend(`
							<div class="d-flex flex-stack py-4">
								<div class="d-flex align-items-center me-2">
									<span class="h-10px w-10px badge badge-circle bg-danger me-4"></span>
									<a href="${route}" class="text-gray-800 text-hover-primary fw-bold">طلب موافقة على وحدة جديدة</a>
								</div>
								<span class="badge badge-light fs-8">منذ لحظات</span>
							</div>
						`)
				}
		</script>
		@endauth

		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>