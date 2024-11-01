<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('assets/images/users/user-1.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu" style="font-weight: bold;">
                <li>
                    <a href="{{route('home.index',['admin' ]) }}">
                        <i class="fa fa-home"></i>
                        <span> الرئيسية </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('accounttypes.index',['admin' ]) }}">
                        <i class="fa fa-user"></i>
                        <span> انواع الحساب </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarlist" data-toggle="collapse">
                        <i class="fa fa-list"></i>
                        <span> التصنيفات </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidebarlist">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span> الأقسام </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span> الأقسام الفرعية</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{route('skills.index',['admin']) }}">
                        <i class="fas fa-user-cog"></i>
                        <span> المهارات </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('sliders.index',['admin']) }}">
                        <i class="fa fa-image"></i>
                        <span> البنرات </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('adminProjects.index',['admin']) }}">
                        <i class="fa fa-fw fa-cubes"></i>
                        <span> المشاريع </span>
                    </a>
                </li>

                <li>
                    <a href="#sidepages" data-toggle="collapse">
                        <i class="fa fa-cog"></i>
                        <span> الصفحات </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidepages">
                        <ul class="nav-second-level">

                            <li>
                                <a href="{{route('faq.index',['admin']) }}">
                                    <span>الأسئلة الشائعة</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('terms.index',['admin']) }}">
                                    <span>شروط الاستخدام</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('privacy.index',['admin']) }}">
                                    <span>بيان الخصوصية</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('guarantee.index',['admin']) }}">
                                    <span>ضمان حقوقك</span>
                                </a>
                            </li>


                            <li>
                                <a href="{{route('fees.index',['admin']) }}">
                                    <span> عمولة المنصة</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarlist" data-toggle="collapse">
                        <i class="fa fa-list"></i>
                        <span> المستخدمين </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidebarlist">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span> صاحب مشروع </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>  محترف</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>  مدرب</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarlist" data-toggle="collapse">
                        <i class="fa fa-list"></i>
                        <span> الماليه </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidebarlist">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span> الفواتير</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>  المدفوعات</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>  دخل المنصه</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarlist" data-toggle="collapse">
                        <i class="fa fa-list"></i>
                        <span> التقييمات </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidebarlist">
                        <ul class="nav-second-level">

                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span> اصحاب المشاريع</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span> المحترفين</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>  المدربين</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarlist" data-toggle="collapse">
                        <i class="fa fa-list"></i>
                        <span> التقارير </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidebarlist">
                        <ul class="nav-second-level">


                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span> عدد اصحاب المشاريع</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>رصيد اصحاب المشاريع</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>احدث اصحاب المشاريع</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span>عدد المستقلين </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('categories.index',['admin']) }}">
                                    <span> رصيد المستقلين</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>  احدث المستقلين</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span> عدد المدربين</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>رصيد المدربين </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('subcategories.index',['admin']) }}">
                                    <span>احدث المدربين </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarcog" data-toggle="collapse">
                        <i class="fa fa-cog"></i>
                        <span> الاعدادات </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="sidebarcog">
                        <ul class="nav-second-level">

                            <li>
                                <a href="{{route('orderstatus.index',['admin']) }}">
                                    <span>انواع حالات الطلبات</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('settings.index',['admin']) }}">
                                    <span> خصائص الموقع </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>






            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
