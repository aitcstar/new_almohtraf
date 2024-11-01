<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>  المحترف للعمل الحر </title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')}}">
      <!-- style css -->
      <link rel="stylesheet" href="{{ asset('frontend/css/new4ewstyle.css')}}">
      <!-- responsive-->
      <link rel="stylesheet" href="{{ asset('frontend/css/new4responsive.css')}}">
      <!-- awesome fontfamily -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
      <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .select2-container--default .select2-selection--single{
                background-color: #fff;
                border: 1px solid #ced4db;
                border-radius: 4px;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 38px;
            user-select: none;
            -webkit-user-select: none;
        }

        .sidepanel {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            right: 0;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }


        footer {
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    padding: 10px;
    }


        .menu-content {
            display: none;
            position: absolute;
            right: 80px;
            background: #fff;
            border: 1px solid #fff;
            width: 250px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            text-align: right;
            top: 60px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .menu-content.active {
            display: block;
        }


    </style>
   </head>
   <!-- body -->
   <body class="main-layout">
        @include('frontend.layouts.header')
        @include('frontend.layouts.message')

        @show
        @yield('content')

        @include('frontend.layouts.footer')

      <!-- Javascript files-->
      <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
      <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('frontend/js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{ asset('frontend/js/custom.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


      <script>
        $(document).ready(function() {
            $('.select2').select2({
                dir: "rtl" // لدعم النصوص من اليمين إلى اليسار
            });
        });
    </script>

<script>
    // Function to open the sidepanel
    function openNav() {
        document.getElementById("mySidepanel").style.width = "250px";
    }

    // Function to close the sidepanel
    function closeNav() {
        document.getElementById("mySidepanel").style.width = "0";
    }

    // Close sidepanel when clicking outside of it
    document.addEventListener('click', function(event) {
        var sidepanel = document.getElementById("mySidepanel");

        // If the click is outside the sidepanel, close it
        if (!sidepanel.contains(event.target) && sidepanel.style.width === "250px") {
            closeNav();
        }
    });

    // Prevent closing the sidepanel when clicking inside the button or the sidepanel itself
    document.querySelector('.openbtn').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    document.querySelector('.sidepanel').addEventListener('click', function(event) {
        event.stopPropagation();
    });


    $(document).ready(function() {
    // إرسال طلب لتحديث الحالة عند تسجيل الدخول
    function updateStatus(status) {
        $.ajax({
            url: '/update-status',
            method: 'POST',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            }
        });
    }

    // تحديث الحالة إلى "متصل" عند تحميل الصفحة
    updateStatus('online');

    // تحديث الحالة إلى "غير متصل" عند الخروج من الصفحة
    $(window).on('beforeunload', function() {
        updateStatus('offline');
    });




});


</script>
@if (Auth::check())
<script>
// تهيئة Pusher
    Pusher.logToConsole = true;


    var pusher = new Pusher('a3986473cacf6c49899f', {
      cluster: 'mt1'
    });
    // الاستماع للقناة الخاصة بالمستخدم
    var channel = pusher.subscribe('user-{{ Auth::user()->id }}');
    //alert(channel);

    channel.bind('project.status.updated', function(data) {
        // عرض الإشعار مع صوت
        //alert(data.message);

        // تشغيل صوت الإشعار
        var audio = new Audio("{{ url('frontend/notification.wav') }}");
        audio.play();

        $.ajax({
            url: '/notifications/unread-count',
            method: 'GET',
            success: function(data) {
                if(data.unreadCount > 0) {
                    $('.notification-count').text(data.unreadCount);
                    $('.notification-count').show();

                    // إذا تم تلقي إشعار جديد، شغل الصوت
                    if(data.unreadCount > previousUnreadCount) {
                        var audio = new Audio('https://leefreelance.leetaxi.com/frontend/notification.wav');
                        audio.play();
                    }

                    previousUnreadCount = data.unreadCount;
                } else {
                    $('.notification-count').text('');
                    $('.notification-count').hide();
                }
            }
        });
    });

    const channelUerNotifications = pusher.subscribe('user-notifications-{{ Auth::user()->id }}');

    channelUerNotifications.bind('invitation.accepted', function(data) {
        alert(data.message);

        var audio = new Audio("{{ url('frontend/notification.wav') }}");
        audio.play();
        //alert('تم قبول دعوتك للعمل على المشروع!');
        // يمكنك تحديث واجهة المستخدم هنا حسب الحاجة
    });


    var previousUnreadCount = 0;

    setInterval(function() {
        $.ajax({
            url: '/notifications/unread-count',
            method: 'GET',
            success: function(data) {
                if(data.unreadCount > 0) {
                    $('.notification-count').text(data.unreadCount);
                    $('.notification-count').show();

                    // إذا تم تلقي إشعار جديد، شغل الصوت
                    if(data.unreadCount > previousUnreadCount) {
                        var audio = new Audio('https://leefreelance.leetaxi.com/frontend/notification.wav');
                        audio.play();
                    }

                    previousUnreadCount = data.unreadCount;
                } else {
                    $('.notification-count').text('');
                    $('.notification-count').hide();
                }
            }
        });
    }, 5000); // تحديث كل 5 ثوانٍ


    // عندما يتم النقر على أيقونات القائمة
    document.getElementById('messages-icon').addEventListener('click', function (e) {
        e.stopPropagation(); // لمنع إغلاق القائمة فوراً عند النقر
        toggleMenu('messages-menu');
    });

    document.getElementById('notifications-icon').addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu('notifications-menu');
    });

    document.getElementById('profile-icon').addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu('profile-menu');
    });

    // دالة لفتح قائمة وإغلاق القوائم الأخرى
    function toggleMenu(menuToShowId) {
        // الحصول على جميع القوائم
        var menus = ['messages-menu', 'notifications-menu', 'profile-menu'];

        // اغلق جميع القوائم ما عدا القائمة التي نريد فتحها
        menus.forEach(function (menuId) {
            var menu = document.getElementById(menuId);
            if (menuId === menuToShowId) {
                // إذا كانت القائمة التي نريد فتحها مغلقة، نفتحها
                menu.classList.toggle('active');
            } else {
                // أغلق جميع القوائم الأخرى
                menu.classList.remove('active');
            }
        });
    }

    // إخفاء القوائم عند النقر في أي مكان خارجها
    document.addEventListener('click', function (e) {
        var menus = ['messages-menu', 'notifications-menu', 'profile-menu'];
        menus.forEach(function (menuId) {
            var menu = document.getElementById(menuId);
            // إغلاق القائمة إذا تم النقر خارجها
            if (!e.target.closest('.nav-item')) {
                menu.classList.remove('active');
            }
        });
    });



</script>
@endif
   </body>
</html>
