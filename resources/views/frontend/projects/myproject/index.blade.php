

@extends('frontend.layouts.master')
@section('title', ' مشاريع')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">


<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="min-height: 100vh;">
            <div class="row">
                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 16px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
                @endif

                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item" data-index="1">  مشاريعي </li>
                    </ol>
                </div>

                <div class="col-md-3">
                    <div class="container">
                        <div class="row">

                                <!-- البحث -->
                                <!--<div class="col-md-12">
                                    <div class="form-group">
                                        <label for="project__keyword"><p>بحث</p></label>
                                        <input class="form-control" id="project__keyword" data-filter="keyword" name="keyword" type="text">
                                    </div>
                                </div>-->

                                <!-- الأقسـام  -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="project__category"><p>الحالة </p></label>
                                        @foreach($projectStatus as $status)
                                            <div class="form-check">
                                                <label>
                                                    <input type="checkbox"  name="status[]" class="filter-checkbox"  value="{{ $status->id }}"
                                                        @if(request('status') == $status->id) checked @endif>

                                                    <span class="label-text">{{ $status->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>



                            <!-- المهارات
                            <div class="col-xs-12 input__wrapper">
                                <div class="form-group">
                                    <label for="project__skills-selectized">المهارات</label>
                                    <div class="tagsinput-container">
                                        <input type="text" class="form-control selectized" id="project__skills" name="skills" data-filter="skills" autocomplete="off">
                                    </div>
                                    <small class="text-muted" id="suggested__skills_notice" style="display: none;">سيتم دمج المهارات المقترحة بعد مراجعتها من قبل الدعم</small>
                                </div>
                            </div>-->



                        <!--<div class="slider-container">
                            <div id="price-slider"></div>
                            <div class="slider-values">
                                <span id="price-min">Min: $100</span> - <span id="price-max">Max: $1000</span>
                            </div>
                        </div>-->

                            <!-- الميزانية
                            <div class="col-xs-12 input__wrapper">
                                <div class="form-group">
                                    <label for="project__budget">الميزانية</label>
                                    <div class="budget-slider">
                                        <input type="hidden" id="project__budget_min" name="project__budget_min" value="25.00">
                                        <input type="hidden" id="project__budget_max" name="project__budget_max" value="10000.00">
                                        <div id="budget-slider-range" class="noUi-target noUi-horizontal"></div>
                                    </div>
                                    <div class="clearfix text-muted text-zeta">
                                        <b class="pull-right" id="sliderMin">25.00</b>
                                        <b class="pull-left" id="sliderMax">10000.00</b>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <main class="projects" id="projects-list">
                        @include('frontend.projects.partials.project-list', ['projects' => $projects])
                    </main>
                </div>


            </div>
        </div>
    </div>
</category>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // عند تغيير أي checkbox نقوم بتصفية المشاريع تلقائياً
    $('.filter-checkbox').on('change', function() {
        filterProjects();
    });

    // دعم التصفح بين الصفحات مع AJAX
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        filterProjects(page);
    });

    function filterProjects(page = 1) {
        // جلب القيم المختارة من الـ checkboxes
        var selectedStatus = [];
        $('.filter-checkbox:checked').each(function() {
            selectedStatus.push($(this).val());
        });

        // إرسال طلب AJAX لتصفية المشاريع حسب الحالات المختارة
        $.ajax({
            url: "{{ route('myprojects') }}?page=" + page,
            method: "GET",
            data: {
                status: selectedStatus
            },
            success: function(data) {
                $('#projects-list').html(data); // تحديث قائمة المشاريع
            }
        });
    }
});


</script>

</script>
@endsection
