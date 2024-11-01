<!-- loader  -->
<div class="loader_bg">
    <div class="loader"><img src="{{ asset('frontend/images/loading.gif') }}"/></div>
</div>
<!-- end loader -->
<div id="mySidepanel" class="sidepanel">
    <!--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>-->

    @if (!Auth::check())
        <a class="active" href="/">الرئيسية <i class="fa fa-fw fa-home"></i></a>
        <a href="/register"> حساب جديد <i class="fa fa-fw fa-user"></i></a>
        <a href="/login-client">تسجيل دخول <i class="fa fa-fw fa-sign-in"></i></a>
        <a href="/all-categories" > الأقسـام <i class="fa fa-fw fa-th-list"></i></a>
        <a href="/project/create">أضف مشروع <i class="fa fa-fw fa-plus"></i></a>
        <a href="/project/index" >تصفح المشاريع <i class="fa fa-fw fa-cubes"></i></a>
        <a href="/freelancers" > ابحث عن حريفة <i class="fa fa-fw fa-users"></i></a>
        <!--<a href="/portfolios" > معرض الأعمال <i class="fa fa-fw fa-picture-o"></i></a>-->
        <hr>
        <a href="/faq" > الأسئلة الشائعة<i class="fa fa-fw fa-th-list"></i></a>
        <a href="/terms">شروط الاستخدام<i class="fa fa-fw fa-user-secret"></i></a>
        <a href="/privacy"> بيان الخصوصية<i class="fa fa-fw fa-user-secret"></i></a>
        <a href="/guarantee"> ضمان حقوقك<i class="fa fa-fw fa-user-secret"></i></a>
        <a href="/fees"> عمولة المنصة <i class="fa fa-fw fa-user-secret"></i></a>


        <!--<a href="https://api.whatsapp.com/send?phone=352681521012">اتصل بنا<i class="fa fa-fw fa-volume-control-phone"></i></a>-->
    @endif
    @if (Auth::check())
        <a href="/profile/index" style="text-align: center;">
            لوحة تحكم<br>
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  class="profile-img" style="width: 50px;height: 50px">
            <br>
            {{ Auth::user()->firstname .' '. Auth::user()->familyname}}
            <br>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" >
            @csrf
        </form>
        <a href="/profile/index">  الملف الشخصي <i class="fa fa-sliders fa-fw"></i></a>

        <a href="/boarding/index">  حسابي <i class="fa fa-fw fa-user"></i></a>

        @if($unreadCount > 0)
            <a href="/notifications/index"> الإشعارات <i class="fa fa-fw fa-bell" ></i><span class="notification-count">{{ $unreadCount }}</span></a>
        @else
            <a href="/notifications/index"> الإشعارات <i class="fa fa-fw fa-bell" ></i><span class="notification-count">0</span></a>
        @endif


        <a href="/messages/index">  رسائلي <i class="fa fa-fw fa-envelope"></i></a>
        <a href="{{ route('wallet.index') }}">  محفظتي <i class="fa fa-fw fa-money"></i></a>
        <a href="{{ route('favorites.index') }}">  مفضلتي <i class="fa fa-fw fa-heart"></i></a>

        <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> تسجيل الخروح <i class="fa fa-fw fa-sign-in"></i></a>

        <hr>
        @if(session('account_type_ids') && in_array(2, session('account_type_ids')))
        <a href="/profile/portfolio">  أضف عمل <i class="fa fa-fw fa-plus"></i></a>
        @endif
        <a href="/project/create">  أضف مشروع <i class="fa fa-fw fa-plus"></i></a>
        @if(session('account_type_ids') && in_array(1, session('account_type_ids')))
            <a href="/my-projects" > مشاريعي <i class="fa fa-folder-open"></i></a>
        @endif
        <!--<a href="#" > المؤسسات <i class="fa fa-fw fa-cubes"></i></a>-->
        @if(session('account_type_ids') && in_array(2, session('account_type_ids')))
            <a href="/my-bids"> عروضي <i class="fa fa-fw fa-cubes"></i></a>
            <a href="/profile/index?tab=tab-3" > أعمالي <i class="fa fa-fw fa-picture-o"></i></a>
            <hr>
        @endif
        <a href="/project/index" >  تصفح المشاريع <i class="fa fa-fw fa-cubes"></i></a>
        <a href="/freelancers" > ابحث عن حريفة <i class="fa fa-fw fa-users"></i></a>
        <!--<a href="/portfolios" > معرض الأعمال <i class="fa fa-fw fa-picture-o"></i></a>-->
        <a href="/all-categories" > الأقسـام <i class="fa fa-fw fa-th-list"></i></a>
        <hr>
        <a href="/faq" > الأسئلة الشائعة <i class="fa fa-fw fa-th-list"></i></a>
        <a href="/terms"> شروط الاستخدام <i class="fa fa-fw fa-user-secret"></i></a>
        <a href="/privacy"> بيان الخصوصية <i class="fa fa-fw fa-user-secret"></i></a>
        <a href="/guarantee"> ضمان حقوقك <i class="fa fa-fw fa-user-secret"></i></a>
        <a href="/fees"> عمولة المنصة <i class="fa fa-fw fa-user-secret"></i></a>

    @endif

</div>
<!-- header -->
<header>
    <!-- header inner -->
    <div class="head-top">
        <div class="container-fluid">
            <div class="row d_flex">
                <div class="col-sm-3">
                    @if (Auth::check())
                        <!--<li class="d_none"> <a href="/login-client"> حساب جديد &nbsp; <i class="fa fa-user"  aria-hidden="true"></i></a></li>-->

                        <div class="container">
                            <ul class="nav">


                                <li class="nav-item">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profile-icon" role="button" >
                                        <img class="rounded-circle" src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  style="width: 30px;height: 30px">
                                    </a>


                                    <div id="profile-menu" class="menu-content">

                                        <ul class="list-group" style="direction: rtl;">
                                            <li class="list-group-item">
                                                <a  href="/profile/index">
                                                    <i class="fa fa-user me-2"></i>  {{ Auth::user()->firstname .' '. Auth::user()->familyname}}
                                                </a>
                                            </li>

                                            <li class="list-group-item">
                                                <a  href="/favorites/index">
                                                    <i class="fa fa-fw fa-heart"></i> مفضلتي
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a  href="/wallet/index">
                                                    <i class="fa fa-fw fa-money"></i> محفظتي
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a  href="/profile/edit" target="_blank">
                                                    <i class="fa fa-edit me-2"></i> تعديل الحساب
                                                </a>
                                            </li>

                                            <li class="list-group-item">
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out me-2"></i> تسجيل خروج
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                </li>



                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="messages-icon" title="الرسائل">

                                        @if($unreadMessagesCount > 0)
                                            <i class="fa fa-envelope"></i><span class="mssage-count">{{ $unreadMessagesCount }}</span>
                                        @else
                                            <i class="fa fa-envelope"></i><span class="mssage-count">0</span>
                                        @endif


                                    </a>
                                    <div id="messages-menu" class="menu-content">

                                        @if($unreadMessagesCount > 0)
                                            <ul class="list-group">
                                                @foreach($latestMessages as $message)
                                                    <li class="list-group-item">
                                                        <a href="{{ route('message.showProjectChat', $message->project->id) }}">
                                                            <strong>المشروع:  {{ $message->project->title }}</strong><br>
                                                        </a>
                                                        {{ $message->message }}<br>
                                                        <small>{{ $message->timeElapsed($message->created_at)}}</small>
                                                    </li>
                                                @endforeach
                                                <hr>
                                               <a href="/messages/index">كل الرسائل <i class="fa fa-envelope"></i></a>
                                            </ul>
                                        @else
                                            <p>لا توجد رسائل</p>
                                        @endif

                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="notifications-icon" title="الإشعارات">
                                        @if($unreadCount > 0)
                                            <i class="fa fa-bell"></i><span class="notification-count">{{ $unreadCount }}</span>
                                        @else
                                            <i class="fa fa-bell"></i><span class="notification-count">0</span>
                                        @endif

                                    </a>
                                    <div id="notifications-menu" class="menu-content">
                                        @if(isset($lasrnotifications) && $lasrnotifications->count() > 0)
                                        <ul class="list-group">
                                            @foreach($lasrnotifications as $notification)
                                                <li class="list-group-item">
                                                    <a href="{{ route('notifications.markAsRead', $notification->id) }}">
                                                                    {{ $notification->message }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    <hr>
                                                    <a href="/notifications/index">كل الإشعارات<li class="fa fa-bell"></li></a>
                                                </ul>
                                            @else
                                                <p>لا توجد اشعارات</p>
                                            @endif
                                    </div>
                                </li>


                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-sm-9">
                    <ul class="email text_align_right">




                            <li class="d_none"> <a href="/project/index">  تصفح المشاريع &nbsp; <i class="fa fa-cubes"  aria-hidden="true" style="font-size: 14px;"></i></a></li>

                            <li class="d_none"> <a href="/freelancers">  ابحث عن حريفة  &nbsp; <i class="fa fa-users"  aria-hidden="true" style="font-size: 14px;"></i></a></li>

                            @if (Auth::check())
                                @if(session('account_type_ids') && in_array(1, session('account_type_ids')))
                                <!--<li class="d_none"> <a href="/freelancers">  ابحث عن حريفة  &nbsp; <i class="fa fa-users"  aria-hidden="true" style="font-size: 14px;"></i></a></li>-->

                                    <li class="d_none"><a href="/my-projects" > مشاريعي &nbsp;<i class="fa fa-folder-open" style="font-size: 14px;"></i></a></li>
                                @else
                                <li class="d_none"><a href="/profile/index?tab=tab-3" >  أعمالي &nbsp;<i class="fa fa-folder-open" style="font-size: 14px;"></i></a></li>

                                    <li class="d_none"><a href="/my-bids" >  عروضي &nbsp;<i class="fa fa-folder-open" style="font-size: 14px;"></i></a></li>

                                    @endif
                            @endif

                            @if (!Auth::check())
                                <li class="d_none"> <a href="/project/create"> أضف مشروع &nbsp; <i class="fa fa-plus"  aria-hidden="true" style="font-size: 14px;"></i></a></li>
                            @endif

                            @if (Auth::check())
                                @if(session('account_type_ids') && in_array(1, session('account_type_ids')))
                                    <li class="d_none"> <a href="/project/create"> أضف مشروع &nbsp; <i class="fa fa-plus"  aria-hidden="true" style="font-size: 14px;"></i></a></li>
                                @endif
                            @endif

                            @if (Auth::check())
                                @if(session('account_type_ids') && in_array(2, session('account_type_ids')))
                                    <li class="d_none"> <a href="/profile/portfolio">  أضف عمل &nbsp; <i class="fa fa-fw fa-plus" aria-hidden="true" style="font-size: 14px;"></i></a></li>
                                @endif

                            @endif

                            <div class="logo">
                                @if (Auth::check())

                                    <a href="{{ route('boarding.index') }}"><img src="{{ url('frontend/index/public/images/img_nlogo_2.png') }}" style=" height: 54px;margin-left: 10px;" /></a>
                                @else
                                    <a href="{{ route('index') }}"><img src="{{ url('frontend/index/public/images/img_nlogo_2.png') }}" style=" height: 54px;margin-left: 10px;" /></a>

                                @endif

                            </div>

  <!--                          <li class="d_none"> <a href="/login-client"> حساب جديد &nbsp; <i class="fa fa-user"  aria-hidden="true"></i></a></li>

-->



                        <li> <button class="openbtn" onclick="openNav()"><img src="{{ asset('frontend/images/menu_btn.png') }}" style="height: 15px;"></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- end header -->

