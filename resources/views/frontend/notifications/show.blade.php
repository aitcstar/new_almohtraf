@extends('frontend.layouts.master')
@section('title', 'تفاصيل المشروع')
@section('content')


<category style="direction: rtl;text-align: right;">
    <div class="category">


        <div class="container" style="min-height: 100vh;">
            <div class="custom-row">
                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 16px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
                @endif

                    <div class="col-md-12">
                        <ol class="breadcrumb" dir="rtl">
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item" data-index="1"><a href="/project/index">المشاريع</a></li>
                            <li class="breadcrumb-item" data-index="2"> {{ $project->category?->name}}</li>
                            <li class="breadcrumb-item" data-index="3"> {{  $project->title }}</li>
                        </ol>



                    </div>



                    <div class="custom-col col-md-7">

                        <div class="panel" id="project-brief">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    وصف المشروع
                                </h2>
                                @if($project->user_id == auth()->id())
                                    @if($project->bidsCount() == "أضف أول عرض" )
                                        <div class="panel-actions">
                                            <a href="{{ route('editProject', $project->id) }}" style="color: #0099be;"><i class="fa fa-edit" style="padding: 0 26px 0 0;"></i>  تعديل </a>
                                        <a href="#" data-toggle="modal" data-target="#danger-alert-modal{{ $project->id }}" style="color: red;"> <i class="fa fa-trash" style="padding: 0 26px 0 0;"></i> حذف</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="panel-body collapse show" id="project-brief-panel">
                                <div class="text-wrapper-div">
                                    <div class="formatted-text">{!! nl2br(e( $project->description )) !!}</div>


                                </div>

                                <ul class="list-group attachments collapse show" id="project-files-panel">
                                    @foreach($project->files as $key => $file)
                                        <li class="list-group-item attachment">
                                            <div>
                                                <ul class="list-meta">

                                                        <li>
                                                            <bdi>
                                                                <a href="{{ asset('storage/'.$file->media) }}"  target="_blank" style="color: #000;" data-file-type="jpeg" class="fancybox">
                                                                    مرفق رقم {{ $key+1 }}
                                                                </a>
                                                            </bdi>
                                                        </li>

                                                </ul>
                                            </div>
                                            <div class="text-zeta"></div>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        @if( session('account_type_ids') && !in_array(1, session('account_type_ids')))
                            @if($project->user_id != auth()->id())
                                @if(!$existingBid)
                                    <div class="panel" id="add-bid-panel">
                                        <div class="panel-heading">
                                            <h2 class="panel-title">أضف عرضك الآن</h2> {{in_array(1, session('account_type_ids'))}}

                                        </div>
                                        @if (Auth::check())
                                                <div class="panel-body">
                                                    <form action="{{ route('projects.storeBid', $project->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div id="bid-form_container">
                                                            <div class="row">
                                                                <div class="form-group col-md-4 col-sm-6">
                                                                    <input type="hidden" name="project" value="963594">
                                                                    <label for="bid__period">مدة التسليم <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="tel" name="delivery_time" id="delivery_time"  min="1">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-textt" >أيام</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-4 col-sm-6">
                                                                    <label for="bid__cost">قيمة العرض <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="tel" name="offer_value" id="total_amount" min="1">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-textt" >$</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-4 d-none d-sm-block">
                                                                    <label for="bid__cost-real">مستحقاتك</label>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="number" name="earnings"  id="commission" readonly value="0">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-textt" >$</span>
                                                                        </div>
                                                                    </div>
                                                                    <p class="help-block text-zeta">بعد خصم <a href="/fees" target="_blank">العمولة</a></p>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="bid__details">تفاصيل العرض <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" rows="10" name="details"></textarea>
                                                            </div>
                                                            <!--
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#bid-attachments">
                                                                    <i class="fa fa-paperclip"></i> أرفق ملفات <small class="text-muted">(اختياري)</small>
                                                                </button>
                                                                <div class="collapse mt-2" id="bid-attachments">
                                                                    <div class="dropzone-box dropzone dz-clickable" data-ui="dropzone" data-input-name="files">
                                                                        <div class="dz-default dz-message">
                                                                            <div class="media">
                                                                                <div class="media-body">
                                                                                    <p class="text-delta">اسحب الملفات إلى هنا</p>
                                                                                    <p class="text-muted">أو انقر للاختيار يدويا</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="files" id="uploadedFiles">
                                                                    </div>
                                                                    <input name="multiple_up_completed" type="hidden" value="1">
                                                                </div>
                                                            </div>
                                                            -->
                                                            <div class="form-group">
                                                                <ul class="help-block text-zeta">
                                                                    <li>لا تستخدم وسائل تواصل خارجية</li>
                                                                    <li>لا تضع روابط خارجية، قم بالاهتمام <a target="_blank" style="color: #0099be;" href="/profile/index?tab=tab-3">بمعرض أعمالك</a> بدلا منها</li>
                                                                    <!--<li><a target="_blank" href="https://support.mostaql.com/proposal-tips">اقرأ هنا كيف تضيف عرضًا مميزًا على أي مشروع</a></li>-->
                                                                </ul>
                                                            </div>

                                                            <div class="btn-group">
                                                                <button type="submit" class="btn btn-primary btn-lg" style="background-color: #0198be;border-color: #0198be;">أضف عرضك</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                        @else
                                        قم بفتح حساب جديد او تسجيل الدخول <a href="/register" style="color: #0099be;">  من هنا </a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endif
                        <div class="panel" id="project-bids-panel">
                            <div class="panel-heading">
                                <h2 class="heada__title  pull-right vcenter" data-toggle="collapse" data-collapse-toggle="" data-target="#project-bids">
                                    العروض المقدمة ({{ $project->bids->count() }})
                                </h2>
                            </div>
                                @forelse ($project->bids as $bid)
                                    <div class="project">
                                        <div class="freelancer-row d-flex align-items-start">
                                            <div class="info-td text-center">
                                                <figure class="usercard__avatar">
                                                    <a href="{{route('freelancers.getUser',$bid->user->id)}}">
                                                        <img src="{{ $bid->user->profile_picture ? asset('storage/' . $bid->user->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  class="profile-img" style="width: 60px;height: 40px;">
                                                    </a>
                                                </figure>
                                            </div>

                                            <div class="details-td ml-3 flex-grow-1" style="max-width: 560px;">
                                                <div class="card-title_wrapper">
                                                    <h2 class="card--title m-0 text-meta">
                                                        <a href="{{route('freelancers.getUser',$bid->user->id)}}">
                                                            &nbsp;<bdi>{{ $bid->user->firstname . ' ' .  $bid->user->familyname }}</bdi>
                                                        </a>
                                                    </h2>

                                                    <ul class="list-inline user__meta text-muted">
                                                       <li class="list-inline-item">
                                                            <div class="freelancers__item-rating">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fa fa-star clr-amber rating-star"></i>
                                                                @endfor
                                                                @if ($bid->user->completionRate % 1 != 0)
                                                                    <i class="fa fa-star-half-o clr-amber fa-flip-horizontal rating-star"></i>
                                                                @endif
                                                            </div>
                                                        </li>
                                                        {{--<li class="list-inline-item" data-toggle="tooltip" title="نسبة اكمال المشاريع">
                                                            <i class="fa fa-fw fa-percent"></i> {{ number_format($bid->user->completionRate, 2) }}
                                                        </li>--}}
                                                         <li class="list-inline-item" data-toggle="tooltip" title="{{ $bid->user->subCategory->name }} ">
                                                            <i class="fa fa-fw fa-briefcase"></i> {{ $bid->user->subCategory->name }}
                                                        </li>
                                                        <li class="list-inline-item" data-toggle="tooltip" title="{{ $bid->created_at }} ">
                                                            <i class="fa fa-clock-o"></i> {{ $bid->timeElapsed($bid->created_at) }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if($project->user_id == auth()->id())
                                                    <div class="card--actions hidden-xs" style="text-align: left;margin: -39px 0px 8px -46px;direction: ltr;">
                                                        <div class="col-md-4" style="text-align: right">
                                                            <div class="dropdown btn-group">
                                                                <a href="#"
                                                                class="btn btn-info btn-sm">
                                                                    <i class="fa fa-send"></i> تواصل معي
                                                                </a>
                                                                <button class="btn btn-info btn-sm" data-toggle="dropdown">
                                                                    <i class="fa fa-caret-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-left">
                                                                    <li>
                                                                        <a href="#bookmark" data-action="bookmark">
                                                                            <i class="fa fa-bookmark"></i> أضف إلى المفضلة
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <i class="fa fa-sticky-note"></i> أضف ملاحظة
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#report" data-action="report">
                                                                            <i class="fa fa-flag"></i> تبليغ عن محتوى
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="vertical-meta " style="background-color: #f0fafd;">
                                                        <div class="row text-center ">
                                                            <div class="col-xs-6 col-sm-4 vertical-meta-column">
                                                                <p class="meta-title">المبلغ</p>
                                                                <div data-bid="cost" class="meta-content"><span dir="rtl">{{ $bid->offer_value }} $</span></div>
                                                            </div>

                                                            <div class="col-xs-6 col-sm-4 vertical-meta-column">
                                                                <p class="meta-title">مدة التنفيذ</p>
                                                                <div class="meta-content"> {{ $bid->delivery_time }} أيام </div>
                                                            </div>

                                                            <div class="col-xs-6 col-sm-4 vertical-meta-column ">
                                                                <p class="meta-title">معرض الأعمال</p>
                                                                <div class="meta-content">
                                                                    <a href="{{route('freelancers.getUser',$bid->user->id)}}" class="clr-gray-darker">
                                                                        {{ $bid->user->portfolios->count() }} أعمال
                                                                    </a>
                                                                </div>
                                                            </div>

                                                                </div>
                                                    </div>

                                                    <div class="freelancer__brief">
                                                        <p class="text-wrapper-div">
                                                             {{ $bid->details }}
                                                        </p>
                                                    </div>
                                               @else

                                                <div class="freelancer__brief">
                                                    <p class="text-wrapper-div">
                                                         {{ Str::limit($bid->details, 150, '...') }}
                                                    </p>
                                                </div>
                                                @endif

                                                @if($bid->files->count())
                                                    <h4>الملفات المرفقة:</h4>
                                                    <ul>
                                                        @foreach ($bid->files as $file)
                                                            <li><a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">ملف مرفق</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                            </div>
                                        </div>



                                    </div>
                                @empty
                                    <p>لا توجد عروض مقدمة لهذا المشروع.</p>
                                @endforelse


                        </div>


                    </div>

                    <div class="custom-col col-md-5">
                        <div class="panel" id="project-meta">
                            <div class="panel-heading">
                                <h2 class="panel-title">بطاقة المشروع</h2>
                            </div>
                            <div class="panel-body">
                                <table class="table table-meta">

                                    <tbody>
                                        <tr>
                                            <td>حالة المشروع</td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $project->projectStatus?->color }};color:#fff">{{ $project->projectStatus?->name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>تاريخ النشر</td>
                                            <td>
                                                <time datetime="{{ $project->created_at }}" title="{{ $project->created_at }}"> {{ $project->timeElapsed($project->created_at) }}</time>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>الميزانية</td>
                                            <td><span dir="rtl">   {{ $project->budget }} </span></td>
                                        </tr>
                                        <tr>
                                            <td>مدة التنفيذ</td>
                                            <td> {{ $project->expected_duration }} يوما</td>
                                        </tr>
                                        <tr>
                                            <td>متوسط العروض</td>
                                            <td>
                                                <span dir="rtl">
                                                    @if ($averageBid)
                                                        {{ $averageBid }} دولار
                                                    @else
                                                        لا توجد عروض بعد
                                                    @endif
                                                </span>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>عدد العروض</td>
                                            <td>{{ $project->bidsCount() }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr class="separator d-none d-sm-block">
                                <div id="project-users">
                                    <h5 class="mrg--bt-reset">صاحب المشروع</h5>
                                    <div class="profile_card">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="profile__name mrg--an">
                                                    <bdi> {{ $project->ownerProject?->firstname . ' ' .   $project->ownerProject?->familyname }}</bdi>
                                                </h5>
                                                <ul class="list-unstyled text-muted mrg--an">
                                                    <li><i class="fa fa-fw fa-briefcase"></i>  {{ $project->ownerProject?->subCategory->name ?? '' }}</li>
                                                </ul>
                                                <table class="table table-meta mrg--tt">
                                                    <colgroup>
                                                        <col class="col-6">
                                                        <col class="col-6">
                                                    </colgroup>
                                                    <tbody>
                                                        <tr>
                                                            <td>تاريخ التسجيل</td>
                                                            <td>{{ $project->formatDateToArabic($project->ownerProject?->created_at) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>معدل التوظيف</td>
                                                            <td>لم يحسب بعد</td>
                                                        </tr>
                                                        <!--<tr>
                                                            <td>المشاريع المفتوحة</td>
                                                            <td>1</td>
                                                        </tr>
                                                        <tr>
                                                            <td>مشاريع قيد التنفيذ</td>
                                                            <td>0</td>
                                                        </tr>-->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel">

                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    شارك المشروع
                                </h2>
                                <div class="pull-left"></div>
                            </div>

                            <div class="carda__body" id="item__social-panel-content">
                                <div class="carda__body">
                                    <input class="form-control" readonly id="social-share-link">
                                </div>




                                <ul class="list-meta text-center pdn--as">
                                    <!-- Twitter -->
                                    <li class="list-inline-item">
                                        <a href="#" id="share-twitter" class="btn btn-sm btn-x-twitter btn-flat" target="_blank">
                                            <i class="fa fa-twitter"></i> Twitter
                                        </a>
                                    </li>

                                    <!-- Facebook -->
                                    <li class="list-inline-item">
                                        <a href="#" id="share-facebook" class="btn btn-sm btn-facebook btn-flat"target="_blank">
                                            <i class="fa fa-facebook"></i> Facebook
                                        </a>
                                    </li>

                                    <!-- LinkedIn -->
                                    <li class="list-inline-item">
                                        <a href="#" id="share-linkedin"  class="btn btn-sm btn-linkedin btn-flat" target="_blank">
                                            <i class="fa fa-linkedin"></i> LinkedIn
                                        </a>
                                    </li>
                                </ul>




                            </div>
                        </div>


                    </div>


                </div>


            </div>

            <div id="danger-alert-modal{{ $project->id }}" class="modal fade" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content modal-filled" style="background-color: #e9e9e9 !important;">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <input type="hidden" value="{{ $project->id }}" name="del_id" id="app_id">
                                <i class="dripicons-wrong h1 text-black"></i>
                                <h4 class="mt-2 text-black">هل انت متأكد من الحذف ؟</h4>
                                <p class="mt-3 text-black">هل تريد حقًا حذف هذه السجلات؟ لا يمكن التراجع عن هذه العملية.</p>
                                <button type="button"
                                    onclick="location.href='{{ url('/project/destroy/' . $project->id) }}';"
                                    class="btn btn-light my-2">حذف</button>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>


    </div>

</category>

<script>





        window.onload = function() {
            // Get the current URL
            var currentUrl = window.location.href;
            document.getElementById('social-share-link').value = currentUrl;

            // Log the current URL to the console
            console.log('Current URL:', currentUrl);

            // Update share links with the current URL
            var twitterLink = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(currentUrl);
            var facebookLink = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(currentUrl);
            var linkedinLink = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(currentUrl);

            console.log('Twitter Link:', twitterLink);
            console.log('Facebook Link:', facebookLink);
            console.log('LinkedIn Link:', linkedinLink);

            document.getElementById('share-twitter').href = twitterLink;
            document.getElementById('share-facebook').href = facebookLink;
            document.getElementById('share-linkedin').href = linkedinLink;




            document.getElementById('delivery_time').addEventListener('input', function (e) {
        // إزالة أي أحرف غير رقمية
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('total_amount').addEventListener('input', function (e) {
        // إزالة أي أحرف غير رقمية
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // الحصول على العنصر
    var totalAmountInput = document.getElementById('total_amount');
            var amountAfterFeeInput = document.getElementById('commission');
            var deliveryTime = document.getElementById('delivery_time');

        // دالة لحساب المبلغ بعد خصم العمولة
        function calculateAmountAfterFee() {
            var totalAmount = parseFloat(totalAmountInput.value) || 0;
            var platformFee = totalAmount * 0.15;
            var amountAfterFee = totalAmount - platformFee;
            // تحديث الحقل بالمبلغ بعد الخصم
            amountAfterFeeInput.value = amountAfterFee;
        }

        function preventLeadingZeroDay() {
            if (deliveryTime.value.length > 1 && deliveryTime.value[0] === '0') {
                deliveryTime.value = deliveryTime.value.substring(1);
            }
        }


        // دالة لمنع المستخدم من إدخال صفر كأول رقم
        function preventLeadingZero() {
            if (totalAmountInput.value.length > 1 && totalAmountInput.value[0] === '0') {
                totalAmountInput.value = totalAmountInput.value.substring(1);
            }
        }

        deliveryTime.addEventListener('input', function() {
            preventLeadingZeroDay();
        });

       // إضافة حدث الاستماع لتحديث الحسابات عند إدخال المبلغ الإجمالي
        totalAmountInput.addEventListener('input', function() {
            preventLeadingZero();
            preventLeadingZeroDay();
            calculateAmountAfterFee();
        });

        };
</script>

@endsection
