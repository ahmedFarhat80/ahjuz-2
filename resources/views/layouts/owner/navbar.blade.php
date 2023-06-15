<!-- Start Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-dark p-md-1 p-2">
    <!-- Container wrapper -->
    <div class="container">

        <x-navbar style="color:  hsla(0,0%,100%,.55);"></x-navbar>
        
            <!-- Right elements -->
            <div class="d-flex align-items-center">

                @auth('owner')
                    @php
                        $notifications = auth_owner()->notifications()->where('type', '!=', 'App\Notifications\MessageNotification')->latest()->limit(5)->get();
                        $count_notifications = auth_owner()->notifications()->where('type', '!=', 'App\Notifications\MessageNotification')->whereNull('read_at')->count();
                    @endphp
                    <!-- Notifications -->
                    <div class="dropdown">
                        <a class="text-reset mx-2" href="" role="button" id="notifications" data-mdb-toggle="dropdown">
                            <i class="fas fa-bell text-light fa-fw"></i>
                            <span  id="count_notifications" class="badge rounded-pill badge-notification bg-danger" style="right: 0;@if (!$count_notifications) display:none @endif">{{ $count_notifications }}</span>
                        </a>
                        <div class="dropdown-menu">
                        <ul id="ul_notifications" class="text-end px-0 py-3 list-unstyled" aria-labelledby="notifications" style="width: calc(160px + 20vw);max-height:250px;overflow-y: scroll;">
                            @if ($notifications->isNotEmpty())
                                @foreach ($notifications as $notification)
                                    @switch($notification->type)
                                        @case('App\Notifications\PropertyStatusNotification')
                                            <li @if(!$notification->read_at) style="background-color: #eee" @endif>
                                                <a class="dropdown-item" href="{{ route('owner.home') }}" style="white-space: normal;">
                                                    <strong>تم {{ $notification->data['status'] }} الوحدة الخاصة بك</strong>
                                                    <div class="text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            </li>
                                            @break
                                        @case('App\Notifications\BookingIsCreatedNotification')
                                            <li @if(!$notification->read_at) style="background-color: #eee" @endif>
                                                <a class="dropdown-item" href="{{ route('owner.properties.bookings', $notification->data['property_id']) }}" style="white-space: normal;">
                                                    <strong>يوجد لديك حجز جديد</strong>
                                                    <div class="text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            </li>
                                            @break
                                        @case('App\Notifications\BookingIsCanceledNotification')
                                            <li @if(!$notification->read_at) style="background-color: #eee" @endif>
                                                <a class="dropdown-item" href="{{ route('owner.properties.bookings', $notification->data['property_id']) }}" style="white-space: normal;">
                                                    <strong>تم إلغاء حجز لديك</strong>
                                                    <div class="text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            </li>
                                            @break
                                    @endswitch
                                    @if (!$loop->last)
                                        <li><hr class="dropdown-divider m-0" style="background-color: #eee"/></li>
                                    @endif
                                @endforeach
                            @else
                                <li class="p-3">
                                    لا يوجد لديك أي إشعارات
                                </li>
                            @endif
                        </ul>
                        <div class="w-100 p-2 text-center position-absolute bg-white border-top border-bottom" style="bottom:0;">
                            <a href="{{ route('owner.notifications.index') }}">جميع  الإشعارات</a>
                        </div>
                        </div>
                    </div>

                    @php
                        $messages_notifications = auth_owner()->notifications()->where('type', 'App\Notifications\MessageNotification')->latest()->limit(5)->get();
                        $count_messages_notifications = auth_owner()->notifications()->where('type', 'App\Notifications\MessageNotification')->whereNull('read_at')->count();
                    @endphp

                    <div class="dropdown">
                        <a class="text-reset mx-2" href="" role="button" id="message-notification" data-mdb-toggle="dropdown">
                            <i class="fas fa-message text-light fa-fw"></i>
                            <span id="count_messages_notifications" class="badge rounded-pill badge-notification bg-danger" style="right: 0;@if (!$count_messages_notifications) display:none @endif">{{ $count_messages_notifications }}</span>
                        </a>
                        <div class="dropdown-menu">
                        <ul id="ul_messages_notifications" class="text-end px-0 py-3 list-unstyled" aria-labelledby="message-notification" style="width: calc(160px + 20vw);max-height:250px;overflow-y: scroll;">
                            @if ($messages_notifications->isNotEmpty())
                                @foreach ($messages_notifications as $notification)
                                    <li @if(!$notification->read_at) style="background-color: #eee" @endif>
                                        <a class="dropdown-item" href="{{ route('owner.messages.show', [$notification->data['property_id'], $notification->data['customer_id']]) }}" style="white-space: normal;">
                                            <strong> يوجد لديك رسالة من {{ $notification->data['name'] }} بخصوص {{ $notification->data['property_name'] }}.</strong>
                                            <span>{{ $notification->data['message'] }}</span>
                                            <div class="text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                        </a>
                                    </li>
                                    @if (!$loop->last)
                                    <li><hr class="dropdown-divider m-0" style="background-color: #eee"/></li>
                                    @endif
                                @endforeach
                            @else
                                <li class="p-3">
                                    لا يوجد لديك أي رسائل
                                </li>
                            @endif
                        </ul>
                        <div class="w-100 p-2 text-center position-absolute bg-white border-top border-bottom" style="bottom:0;">
                            <a href="{{ route('owner.messages.index') }}">جميع  الرسائل</a>
                        </div>
                        </div>
                    </div>

                    <div class="dropdown">
                        <!-- Avatar -->
                        <a class="dropdown-toggle me-2 d-flex align-items-center hidden-arrow" href="" id="navbarDropdownMenuLink"
                            role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth_owner()->avatar }}" class="rounded-circle " height="25"
                                loading="lazy" />
                        </a>
                        <ul class="text-end dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item " href="{{ route('owner.home') }}"> <i class="fas fa-list ms-2 "></i> ممتلكاتي </a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="{{ route('owner.profile') }}"> <i class="fas fa-user-cog ms-2 "></i> حسابي </a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="{{ route('login') }}"> <i class="fas fa-user ms-2 "></i> تسجيل دخول الزبون </a>
                            </li>
                            <li>
                                <a class="dropdown-item"  onclick="document.getElementById('logout').submit()" style="cursor: pointer;"> 
                                    <form id="logout" action="{{ route('owner.logout') }}" method="POST"> 
                                        @csrf
                                        <i class="fas fa-sign-out ms-2 "></i> 
                                        تسجيل الخروج
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endauth

                @guest('owner')         
                    <div class="dropdown">
                        <button class="text-reset ms-2 btn ripple-surface btn-light" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false" style="min-width: 114px;">
                            <i class="fas fa-sign-in"></i> الدخول
                        </button>
                        <ul class="dropdown-menu text-end" aria-labelledby="dropdownMenuButton" data-popper-placement="null" data-mdb-popper="none">
                            <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fa fa-user ms-2"></i>تسجيل دخول الزبون </a></li>
                            <li><a class="dropdown-item" href="{{ route('owner.login') }}"><i class="fa fa-house-user ms-2"></i>تسجيل دخول المالك</a></li>
                        </ul>
                    </div>
                @endguest

            </div>
            <!-- Right elements -->

    </div>
    <!-- Container wrapper -->
</nav>
<!-- End Navbar -->