<!-- Start Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light p-md-1 p-2">
    <!-- Container wrapper -->
    <div class="container">

            <x-navbar></x-navbar>
        
            <!-- Right elements -->
            <div class="d-flex align-items-center t">

                @auth('customer')
                    @php
                        $notifications = auth_customer()->notifications()->where('type', '!=', 'App\Notifications\MessageNotification')->latest()->limit(5)->get();
                        $count_notifications = auth_customer()->notifications()->where('type', '!=', 'App\Notifications\MessageNotification')->whereNull('read_at')->count();
                    @endphp
                    <!-- Notifications -->
                    <div class="dropdown">
                        <a class="text-reset mx-2" href="" role="button" id="notifications" data-mdb-toggle="dropdown">
                            <i class="fas fa-bell fa-fw"></i>
                            <span  id="count_notifications" class="badge rounded-pill badge-notification bg-danger" style="right: 0;@if (!$count_notifications) display:none @endif">{{ $count_notifications }}</span>
                        </a>
                        <div class="dropdown-menu">
                        <ul id="ul_notifications" class="text-end px-0 py-3 list-unstyled" aria-labelledby="notifications" style="width: calc(160px + 20vw);max-height:250px;overflow-y: scroll;">
                            @if ($notifications->isNotEmpty())
                                @foreach ($notifications as $notification)
                                    @switch($notification->type)
                                        @case('App\Notifications\BookingIsCanceledNotification')
                                            <li @if(!$notification->read_at) style="background-color: #eee" @endif>
                                                <a class="dropdown-item" href="{{ route('home') }}" style="white-space: normal;">
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
                            <a href="{{ route('notifications.index') }}">جميع  الإشعارات</a>
                        </div>
                        </div>
                    </div>

                    @php
                        $messages_notifications = auth_customer()->notifications()->where('type', 'App\Notifications\MessageNotification')->latest()->limit(5)->get();
                        $count_messages_notifications = auth_customer()->notifications()->where('type', 'App\Notifications\MessageNotification')->whereNull('read_at')->count();
                    @endphp
                    
                    <div class="dropdown">
                        <a class="text-reset mx-2" href="#" role="button" id="message-notification" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-message"></i>
                            <span id="count_messages_notifications" class="badge rounded-pill badge-notification bg-danger" style="right: 0;@if (!$count_messages_notifications) display:none @endif">{{ $count_messages_notifications }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <ul id="ul_messages_notifications" class="text-end px-0 py-3 list-unstyled" aria-labelledby="message-notification" style="width: calc(160px + 20vw);max-height:250px;overflow-y: scroll;">
                                @if ($messages_notifications->isNotEmpty())
                                    @foreach ($messages_notifications as $notification)
                                        <li @if(!$notification->read_at) style="background-color: #eee" @endif>
                                            <a class="dropdown-item" href="{{ route('messages.show', [$notification->data['property_id'], auth_customer()->id]) }}" style="white-space: normal;">
                                                <strong> يوجد لديك رسالة من {{ $notification->data['name'] }}.</strong>
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
                                <a href="{{ route('messages.index') }}">جميع  الرسائل</a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown">
                        <!-- Avatar -->
                        <a class="me-2 d-flex align-items-center" href="#" id="navbarDropdownMenuLink1"
                            role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth_customer()->avatar }}" class="rounded-circle " height="25"
                                loading="lazy" />
                        </a>
                        <ul class="text-end dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink1">
                            <li>
                                <a class="dropdown-item " href="{{ route('home') }}"> <i class="fas fa-list ms-2 "></i> حجوزاتي </a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="{{ route('profile') }}"> <i class="fas fa-user-cog ms-2 "></i> حسابي </a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="{{ route('owner.login') }}"> <i class="fas fa-house-user ms-2 "></i> تسجيل دخول المالك </a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="document.getElementById('logout').submit()" style="cursor: pointer;"> 
                                    <form id="logout" action="{{ route('logout') }}" method="POST"> 
                                        @csrf
                                        <i class="fas fa-sign-out ms-2 "></i> 
                                        تسجيل الخروج
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>

                @endauth

                @guest('customer')    
                    <div class="dropdown">
                        <button class="text-reset ms-2 btn ripple-surface" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false" style="min-width: 114px;">
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