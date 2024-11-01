@extends('frontend.layouts.master')
@section('title', 'الصفحه الشخصيه')
@section('content')
<style>
    .tabs {
        list-style: none;
        padding: 0;
        display: flex;
    }

    .tab-link {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid #ccc;
        border-bottom: none;
        background-color: #f9f9f9;
    }


    .tab-content {
        padding: 20px;
        display: none; /* إخفاء المحتوى بشكل افتراضي */
    }

    .tab-content.active {
        display: block; /* عرض المحتوى النشط فقط */
    }

    .stars i {
    font-size: 24px; /* حجم النجمة */
    margin-right: 5px;
}

.clr-amber {
    color: #FFC107; /* لون النجمة الممتلئة */
}

.clr-gray {
    color: #E0E0E0; /* لون النجمة الفارغة */
}

    </style>
<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="min-height: 100vh;">

            <div class="profile-container">
                <div class="profile-header">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  class="profile-img">
                    <h2>{{  $user->firstname . ' ' .  $user->familyname }}
                        @if( $user->status == "online")
                            <i class="fa fa-circle clr-green" data-toggle="tooltip" title="" data-original-title="متصل الان"></i>
                        @endif
                    </h2>


                    <ul class="list-meta">
                        <li class="profile-type">
                            <i class="fa fa-fw fa-user"></i>
                            @foreach ($accountTypeIds as $key => $accountTypeId)
                                {{  $accountTypeIds[$key]['title'] }}@if (!$loop->last), @endif
                            @endforeach
                        </li>
                        <li class="profile-title">
                            <i class="fa fa-fw fa-briefcase"></i>
                            {{ $user->subCategory->name ?? '' }}
                        </li>
                        <li class="profile-location">
                            <i class="fa fa-fw fa-map-marker"></i> {{ $user->country->name ?? '' }}
                        </li>
                    </ul>


                </div>
                <div class="tabs-container">
                    <ul class="tabs" id="tab-nav">
                        <li class="tab-link active" data-tab="tab-1"> <i class="fa fa-fw fa-user"></i> الحساب الشخصي </li>
                        <li class="tab-link" data-tab="tab-2"> <i class="fa fa-star"></i> التقييمات وآراء العملاء</li>
                        <li class="tab-link" data-tab="tab-3"> <i class="fa fa-fw fa-briefcase"></i> معرض الاعمال</li>
                        <!--<li class="tab-link" data-tab="tab-4"> <i class="fa fa-fw fa-sticky-note"></i>  ملاحظات</li>-->
                    </ul>
                    <div id="tab-1" class="tab-content active">
                        <!-- Personal Information Content -->
                        <div class="row">
                            <div class="col-md-8 tab-pane active" id="profile">
                                <!-- About Me Section -->
                                <div class="panel panel-default mrg--bm">
                                    <div class="heada">
                                        <h2 class="heada__title pull-right vcenter">
                                            نبذة عني
                                        </h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="carda__body" >
                                        <div class="text-wrapper-div carda__content">
                                            <p>{{ $user->biography }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- My Skills Section -->
                                <div class="panel panel-default mrg--bm mrg--bn-imp">
                                    <div class="heada">
                                        <h2 class="heada__title pull-right vcenter">
                                            مهاراتي
                                        </h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="carda__body" >
                                        <div class="carda__content">
                                            <ul class="skills text-zeta list-tags">

                                                @foreach($skills->skills as $skill)
                                                    <li class="skills__item">
                                                        <a class="tag">
                                                            <i class="fa fa-fw fa-tag"></i> <bdi> {{ $skill->name }} </bdi>
                                                        </a>
                                                    </li>
                                                @endforeach


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 page_sidebar left-widgets" id="stats-sidebar">
                                <!-- Profile Stats -->
                                <div class="panel panel-default mrg--bm" id="profile-stats">
                                    <div class="heada">
                                        <h4 class="heada__title">إحصائيات</h4>
                                    </div>
                                    <div class="carda__body">
                                        <table class="table table-meta">
                                            <colgroup>
                                                <col class="col-xs-6">
                                                <col class="col-xs-6">
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span title="" data-html="true" data-toggle="tooltip"
                                                            data-original-title="<div class='tooltip-custom-title'> ﻷصحاب المشاريع</div>
                                                            <div>نسبة المشاريع العامة التي قام صاحب المشروع بتوظيف مستقلين عليها إلى المشاريع التي قام بفتحها على مستقل</div>">
                                                            معدل التوظيف
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <label class="label label-rating-good">  {{ $hiringRate }}</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>التقييمات</td>
                                                    <td class="content-middle">
                                                        <span class="rating">
                                                            @php
                                                                $rating = $user->calculateOverallRating(); // أو استخدم التقييم المناسب حسب السياق
                                                            @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fa fa-star {{ $i <= $rating ? 'clr-amber' : 'clr-gray' }}"></i>
                                                                @endfor

                                                        </span>
                                                        <span class="text-secondary">&nbsp;({{ $user->calculateOverallRating() }})</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span title="" data-html="true" data-toggle="tooltip"
                                                            data-original-title="<div class='tooltip-custom-title'>للمستقلين</div>
                                                            <div>نسبة المشاريع التي تم توظيف المستقل عليها وقام بتسليمها إلى إجمالي المشاريع التي استلمها</div>">
                                                            معدل إكمال المشاريع
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <label class="label label-rating-good">  {{ $user->calculateCompletionRate() }}%</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span title="" data-html="true" data-toggle="tooltip"
                                                            data-original-title="<div class='tooltip-custom-title'>للمستقلين</div>
                                                            <div>نسبة أصحاب المشاريع الذين أعادوا توظيف المستقل على أكثر من مشروع إلى إجمالي أصحاب المشاريع الذين عمل معهم</div>">
                                                            معدل إعادة التوظيف
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <label class="label label-rating-good"> {{ $rehireRate }}</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span title="" data-html="true" data-toggle="tooltip"
                                                            data-original-title="<div class='tooltip-custom-title'>للمستقلين</div>
                                                            <div>نسبة المشاريع التي نجح المستقل بتسليمها بالموعد المحدد إلى إجمالي المشاريع التي سلمها</div>">
                                                            معدل التسليم بالموعد
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <label class="label label-rating-good"> {{ $onTimeDeliveryRate }}</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span title="" data-html="true" data-toggle="tooltip"
                                                            data-original-title="<div class='tooltip-custom-title'>للمستقلين</div>
                                                            <div>متوسط سرعة الرد على أول رسالة تصل للمستقل</div>">
                                                            متوسط سرعة الرد
                                                        </span>
                                                    </td>
                                                    <td>{{ $averageTime }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="divider-line"></div>
                                    <div class="carda__body widget__content">
                                        <table class="table table-meta">
                                            <colgroup>
                                                <col class="col-xs-6">
                                                <col class="col-xs-6">
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                    <td>تاريخ التسجيل</td>
                                                    <td><time>{{ $user->formatDateToArabic($user->created_at)  }}</time></td>
                                                </tr>
                                                <tr>
                                                    <td>آخر تواجد</td>
                                                    <td>منذ <time datetime="دقيقة">{{  $user->formatDateToArabic($user->last_login) }}</time></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Verifications -->
                                <div class="panel panel-default mrg--bm" id="profile-verifications">
                                    <div class="heada">
                                        <h4 class="heada__title">توثيقات</h4>
                                    </div>
                                    <div class="carda__body widget__content">
                                        <table class="table table-meta">
                                            <colgroup>
                                                <col class="col-xs-6">
                                                <col class="col-xs-6">
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i class="fa text-success fa-check"></i> البريد الإلكتروني
                                                    </td>
                                                    <td>
                                                        <i class="fa text-muted fa-times"></i> رقم الجوال
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="fa text-muted fa-times"></i> الهوية الشخصية
                                                    </td>
                                                    <td>
                                                        <i class="fa text-muted fa-times"></i> وسيلة الدفع
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Badges
                                <div class="panel panel-default mrg--bm" id="profile-badges-panel">
                                    <div class="heada">
                                        <h2 class="heada__title pull-right vcenter">أوسمة</h2>
                                    </div>
                                    <div class="carda__body collapse in" id="profile-badges">
                                        <ul class="badges list-inline mrg--bn">
                                            <li class="list-inline-item">
                                                <img data-toggle="tooltip" alt="مستخدم منذ 4 سنوات"
                                                    src="https://mostaql.hsoubcdn.com/uploads/badge-573917290-year-4.svg"
                                                    width="42" data-html="true" data-container="body"
                                                    data-title="<div class='tooltip-custom-title'>مستخدم منذ 4 سنوات</div>
                                                                <div>سجل في مستقل منذ 4 سنوات</div>"
                                                    title="">
                                            </li>
                                        </ul>
                                    </div>
                                </div>-->
                            </div>
                        </div>


                    </div>
                    <div id="tab-2" class="tab-content">
                        @if($reviews->isEmpty())
                        <p>لا توجد تقييمات لهذا المستخدم.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>الاحترافية</th>
                                    <th>التواصل</th>
                                    <th>جودة العمل</th>
                                    <th>الخبرة</th>
                                    <th>التسليم في الموعد</th>
                                    <th>التعامل معه مرة أخرى</th>
                                    <th>التعليق</th>
                                    <th>تاريخ التقييم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr>

                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->professionalism ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->communication ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->quality ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->expertise ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->timeliness ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->would_work_again ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor
                                        </td>
                                        <td>{{ $review->comment }}</td>
                                        <td>{{ $review->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    </div>
                    <div id="tab-3" class="tab-content">
                        <div class="container">
                            <div class="row">

                                <!-- إضافة تباعد باستخدام Bootstrap -->
                                <div class="mb-5"></div>



                                @foreach($user->portfolios as $portfolio)
                                    <div class="col-md-3">
                                        <div class="panel panel-default mrg--bm mb-4">
                                            <a href="{{ route('freelancers.showPortfolio',$portfolio->id)}}" class="text-decoration-none">
                                                <img src="{{ asset('storage/' . $portfolio->thumbnail) }}"  alt="{{ $portfolio->title ?? '' }}" style="height: 200px;">
                                            </a>
                                            <div class="card-body">
                                                <h5>
                                                    <a href="{{ route('freelancers.showPortfolio',$portfolio->id)}}" class="text-dark">
                                                        {{ $portfolio->title  ?? ''}}
                                                    </a>
                                                </h5>
                                                <div class="text-muted">
                                                    <i class="fa fa-eye"></i> {{ $portfolio->views }}
                                                    <i class="fa fa-clock-o" style="padding: 0 26px 0 0;"></i>  {{ $portfolio->timeElapsed($portfolio->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div id="tab-4" class="tab-content">
                        <div class="container">
                            <div class="row">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</category>

<script>


document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.tab-link');
    var contents = document.querySelectorAll('.tab-content');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(item) {
                item.classList.remove('active');
            });
            contents.forEach(function(content) {
                content.classList.remove('active');
            });

            this.classList.add('active');
            var activeTab = this.getAttribute('data-tab');
            document.getElementById(activeTab).classList.add('active');
        });
    });
});


$(document).ready(function() {
    // Toggle the visibility of the content when the header is clicked
    $('.heada').click(function() {
        $(this).next('.carda__body').collapse('toggle');
    });

    // Handle showing the spinner during content loading (if needed)
    $('#about_content-panel, #user_skills-panel').on('show.bs.collapse', function() {
        $(this).find('.heada__title b').removeClass('hide');
    }).on('shown.bs.collapse', function() {
        $(this).find('.heada__title b').addClass('hide');
    });
});


</script>

@endsection
