@extends('frontend.layouts.master')
@section('title', 'تفاصيل المشروع')
@section('content')
    <style>
        .rating-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* لجعل الكلمة والنجوم على نفس السطر */
            margin-bottom: 15px;
            /* مسافة بين كل تصنيف */
            width: 40%;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            gap: 5px;
            margin-top: -40px;
            /* مسافة بين النجوم */
        }
        .nrating {
            display: flex;
            flex-direction: row-reverse;
            gap: 5px;
            /* مسافة بين النجوم */
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 1.5rem;
            /* تصغير حجم النجوم */
            color: #FFD700;
            cursor: pointer;
        }

        .rating label::before {
            content: "★";
            opacity: 0.3;
        }

        .rating input:checked~label::before {
            opacity: 1;
        }

        .rating label:hover::before,
        .rating label:hover~label::before {
            opacity: 1;
        }

        .stars i {
            font-size: 24px;
            /* حجم النجمة */
            margin-right: 5px;
        }

        .clr-amber {
            color: #FFC107;
            /* لون النجمة الممتلئة */
        }

        .clr-gray {
            color: #E0E0E0;
            /* لون النجمة الفارغة */
        }
    </style>

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
                            @auth
                                <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                            @endauth
                            <li class="breadcrumb-item" data-index="1"><a href="/messages/index">الرسائل</a></li>
                        </ol>

                    </div>



                    <div class="col-md-12">

                        @if (Auth::id() == $project->bids->first()->user_id && $project->order_status_id == 3)
                            <form action="{{ route('projects.requestDelivery', $project->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">طلب تسليم المشروع</button>
                            </form>
                        @endif

                        @if ($project->project_progress_id == 3)
                            @if ($project->user_id == Auth::id() && $project->order_status_id == 3)
                                <form action="{{ route('projects.approveDelivery', $project->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">الموافقة على التسليم</button>
                                </form>

                                <form action="{{ route('projects.rejectDelivery', $project->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">رفض التسليم</button>
                                </form>
                            @endif
                        @endif

                        @if (Auth::id() === $project->user_id)
                            @if ($project->reviews->count() == 0)
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h2 class="panel-title">
                                            تقييم المشروع
                                        </h2>
                                    </div>
                                    <form id="review-form">
                                        <div class="content-middle">
                                            <label>الاحترافية بالتعامل</label>
                                            <div class="rating">
                                                <input type="radio" name="professionalism" value="5"
                                                    id="5-prof"><label for="5-prof"></label>
                                                <input type="radio" name="professionalism" value="4"
                                                    id="4-prof"><label for="4-prof"></label>
                                                <input type="radio" name="professionalism" value="3"
                                                    id="3-prof"><label for="3-prof"></label>
                                                <input type="radio" name="professionalism" value="2"
                                                    id="2-prof"><label for="2-prof"></label>
                                                <input type="radio" name="professionalism" value="1"
                                                    id="1-prof"><label for="1-prof"></label>
                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>التواصل والمتابعة</label>
                                            <div class="rating">
                                                <input type="radio" name="communication" value="5"
                                                    id="5-comm"><label for="5-comm"></label>
                                                <input type="radio" name="communication" value="4"
                                                    id="4-comm"><label for="4-comm"></label>
                                                <input type="radio" name="communication" value="3"
                                                    id="3-comm"><label for="3-comm"></label>
                                                <input type="radio" name="communication" value="2"
                                                    id="2-comm"><label for="2-comm"></label>
                                                <input type="radio" name="communication" value="1"
                                                    id="1-comm"><label for="1-comm"></label>
                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>جودة العمل المسلّم</label>
                                            <div class="rating">
                                                <input type="radio" name="quality" value="5" id="5-qual"><label
                                                    for="5-qual"></label>
                                                <input type="radio" name="quality" value="4"
                                                    id="4-qual"><label for="4-qual"></label>
                                                <input type="radio" name="quality" value="3"
                                                    id="3-qual"><label for="3-qual"></label>
                                                <input type="radio" name="quality" value="2"
                                                    id="2-qual"><label for="2-qual"></label>
                                                <input type="radio" name="quality" value="1"
                                                    id="1-qual"><label for="1-qual"></label>
                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>الخبرة بمجال المشروع</label>
                                            <div class="rating">
                                                <input type="radio" name="expertise" value="5"
                                                    id="5-exp"><label for="5-exp"></label>
                                                <input type="radio" name="expertise" value="4"
                                                    id="4-exp"><label for="4-exp"></label>
                                                <input type="radio" name="expertise" value="3"
                                                    id="3-exp"><label for="3-exp"></label>
                                                <input type="radio" name="expertise" value="2"
                                                    id="2-exp"><label for="2-exp"></label>
                                                <input type="radio" name="expertise" value="1"
                                                    id="1-exp"><label for="1-exp"></label>
                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>التسليم في الموعد</label>
                                            <div class="rating">
                                                <input type="radio" name="timeliness" value="5"
                                                    id="5-time"><label for="5-time"></label>
                                                <input type="radio" name="timeliness" value="4"
                                                    id="4-time"><label for="4-time"></label>
                                                <input type="radio" name="timeliness" value="3"
                                                    id="3-time"><label for="3-time"></label>
                                                <input type="radio" name="timeliness" value="2"
                                                    id="2-time"><label for="2-time"></label>
                                                <input type="radio" name="timeliness" value="1"
                                                    id="1-time"><label for="1-time"></label>
                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>التعامل معه مرة أخرى</label>
                                            <div class="rating">
                                                <input type="radio" name="would_work_again" value="5"
                                                    id="5-again"><label for="5-again"></label>
                                                <input type="radio" name="would_work_again" value="4"
                                                    id="4-again"><label for="4-again"></label>
                                                <input type="radio" name="would_work_again" value="3"
                                                    id="3-again"><label for="3-again"></label>
                                                <input type="radio" name="would_work_again" value="2"
                                                    id="2-again"><label for="2-again"></label>
                                                <input type="radio" name="would_work_again" value="1"
                                                    id="1-again"><label for="1-again"></label>
                                            </div>
                                        </div>

                                        <div>
                                            <label>تعليق</label>
                                            <textarea name="comment" style="height: 168px;"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-light my-2">إرسال التقييم</button>
                                    </form>
                                </div>
                                <hr>
                            @endif
                        @endif
                        @if ($project->order_status_id == 7)
                            <h3>التقييمات</h3>
                            @if ($project->reviews->count() > 0)
                                @foreach ($project->reviews as $review)
                                    <div class="panel">
                                        <div class="content-middle">
                                            <label>الاحترافية بالتعامل:</label>
                                            <div class="nrating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= $review->professionalism ? 'clr-amber' : 'clr-gray' }}"></i>
                                                @endfor

                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>التواصل والمتابعة:</label>
                                            <div class="nrating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= $review->communication ? 'clr-amber' : 'clr-gray' }}"></i>
                                                @endfor

                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>جودة العمل المسلّم:</label>
                                            <div class="nrating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= $review->quality ? 'clr-amber' : 'clr-gray' }}"></i>
                                                @endfor

                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>الخبرة بمجال المشروع:</label>
                                            <div class="nrating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= $review->expertise ? 'clr-amber' : 'clr-gray' }}"></i>
                                                @endfor

                                            </div>
                                        </div>

                                        <div class="content-middle">
                                            <label>التسليم في الموعد:</label>
                                            <div class="nrating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= $review->timeliness ? 'clr-amber' : 'clr-gray' }}"></i>
                                                @endfor

                                            </div>
                                        </div>
                                        <div class="content-middle">
                                            <label>التعامل معه مرة أخرى:</label>
                                            <div class="nrating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= $review->would_work_again ? 'clr-amber' : 'clr-gray' }}"></i>
                                                @endfor

                                            </div>
                                        </div>
                                        <hr>
                                        <ul class="list-inline user__meta text-muted">

                                            <li class="list-inline-item" data-toggle="tooltip">
                                                {{ $review->project->ownerProject->firstname . ' ' . $review->project->ownerProject->familyname }}
                                            </li>

                                            <li class="list-inline-item" data-toggle="tooltip"
                                                title="{{ $review->created_at }} ">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $review->timeElapsed($review->created_at) }}
                                            </li>

                                        </ul>

                                        @if ($review->comment)
                                            <p class="mt-2"><strong>تعليق:</strong> {{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p>لا توجد تقييمات لهذا المشروع بعد.</p>
                            @endif
                        @endif
                    </div>



                    <div class="col-md-12">
                        <main class="projects">
                            <h2>المشروع: {{ $project->title }}</h2>

                            <ul class="list-group">
                                @foreach ($messages as $message)
                                    <li class="list-group-item">
                                        <a href="{{ route('freelancers.getUser', $message->sender->id) }}">
                                            <img src="{{ $message->sender->profile_picture ? asset('storage/' . $message->sender->profile_picture) : asset('frontend/images/profile.png') }}"
                                                alt="صورة شخصية" class="profile-img" style="width: 30px;height: 30px;">
                                            {{ $message->sender->firstname . '' . $message->sender->familyname }}
                                        </a>
                                        <i class="fa fa-clock-o"></i> {{ $message->timeElapsed($message->created_at) }}<br>
                                        {{ $message->message }} <br>
                                        @if ($message->attachments->count())
                                            <h5>المرفقات:</h5>
                                            <ul>
                                                @foreach ($message->attachments as $attachment)
                                                    <li><a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                            target="_blank">ملف مرفق</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            @if ($project->order_status_id != 7)
                                <form action="{{ route('message.newstore', $project->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                                    <textarea style="height: 200px;" id="message-text" class="form-control" placeholder="اكتب رسالتك هنا..."
                                        name="message"></textarea>
                                    <input type="hidden" value="{{ $receiverId }}" name="receiver">
                                    <div>
                                        <label for="attachments">المرفقات (اختياري):</label>
                                        <input type="file" name="attachments[]" id="attachments" multiple>
                                    </div>

                                    <button type="submit" id="send-message" class="btn btn-light my-2">إرسال</button>
                                </form>
                            @endif

                        </main>
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
        document.getElementById('review-form').addEventListener('submit', function(e) {
            e.preventDefault(); // منع الإرسال الافتراضي

            let projectId = {{ $project->id }};
            let formData = new FormData(this);

            // إعداد طلب fetch لإرسال بيانات النموذج
            fetch(`/projects/${projectId}/reviews`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // تأكيد حماية CSRF
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    return response.json().then(data => {
                        throw data;
                    });
                })
                .then(data => {
                    alert(data.message); // عرض رسالة النجاح
                    location.reload(); // إعادة تحميل الصفحة
                })
                .catch(error => {
                    if (error.errors) {
                        let messages = '';
                        for (let key in error.errors) {
                            messages += error.errors[key].join(', ') + '\n';
                        }
                        alert(messages); // عرض رسائل الخطأ
                    } else {
                        alert(error.message || 'حدث خطأ ما.');
                    }
                });
        });
    </script>
@endsection
