

@extends('frontend.layouts.master')
@section('title', ' مشاريع')
@section('content')

<!-- Include noUiSlider CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>

<!-- Include jQuery (for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
#slider-range {
    width: 100%;  /* Adjust the width of the slider */
    margin-top: 10px;
    direction: ltr; /* Set text direction to left-to-right */

}
.noUi-connect {
    background: #0099be;
}
#amount {
    margin-bottom: 10px;
    font-size: 16px;
}


</style>
<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        @auth
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                        @endauth
                        <li class="breadcrumb-item" data-index="1"> المشاريع المفتوحة </li>
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
                                    <label for="project__category"><p>الأقسـام </p></label>
                                    @foreach($categories as $category)
                                        <div class="form-check">
                                            <label>
                                                <input type="checkbox" class="category-filter" value="{{ $category->id }}">

                                                <!--<input type="checkbox" name="categories[]" class="category-filter" data-id="{{ $category->id }}">-->
                                                <span class="label-text">{{ $category->name }}</span>
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

                            <!-- مدة التسليم -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project__duration"><p>مدة التسليم</p></label>
                                    <label>
                                        <input type="checkbox" class="delivery-time-filter" value="1_week_less"> أقل من أسبوع واحد
                                    </label>
                                    <label>
                                        <input type="checkbox" class="delivery-time-filter" value="1_2_weeks"> من 1 إلى 2 أسابيع
                                    </label>
                                    <label>
                                        <input type="checkbox" class="delivery-time-filter" value="2_weeks_1_month"> من 2 أسابيع إلى شهر
                                    </label>
                                    <label>
                                        <input type="checkbox" class="delivery-time-filter" value="1_3_months"> من شهر إلى 3 أشهر
                                    </label>
                                    <label>
                                        <input type="checkbox" class="delivery-time-filter" value="3_months_more"> أكثر من 3 أشهر
                                    </label>
                                </div>
                            </div>

                            <!-- Slider Range -->
                            <div class="col-md-12">
                                <label for="price_range">الميزانية :</label>
                                <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                <div id="slider-range"></div>
                            </div>

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
                        {{$projects->count()}}
                        @include('frontend.projects.partials.project-list', ['projects' => $projects])

                    </main>
                </div>


            </div>
        </div>
    </div>
</category>



<script>

// لتحميل المشاريع عند تغيير الصفحة أو الفلتر
function loadProjects(page = 1, categoryIds = []) {

            $.ajax({
                url: "{{ route('projects.list') }}",
                type: "GET",
                data: {
                    page: page,
                    category_ids: categoryIds
                },
                success: function(data) {
                    alert(categoryIds);
                    $('#projects-list').html(data);
                }
            });
        }

        // فلترة المشاريع عند تغيير الفلاتر
        $('.category-filter').change(function() {
            let selectedCategories = [];
            $('.category-filter:checked').each(function() {
                selectedCategories.push($(this).val());
            });
            loadProjects(1, selectedCategories);
        });


        // عندما يتم تغيير أي checkbox
        $('.delivery-time-filter').change(function() {
            // اجلب الفلاتر المختارة
            var selectedFilters = [];
            $('.delivery-time-filter:checked').each(function() {
                selectedFilters.push($(this).val());
            });

            // أرسل طلب Ajax لجلب المشاريع بناءً على الفلاتر المختارة
            $.ajax({
                url: '{{ route("filter") }}', // تأكد من تعديل هذا الرابط إلى المسار الصحيح
                method: 'GET',
                data: { delivery_times: selectedFilters },
                success: function(response) {
                    // حدث قائمة المشاريع
                    $('#projects-list').html(response);
                }
            });
        });
        //////////////////////////

        $(document).ready(function() {
        var slider = document.getElementById('slider-range');
        var amount = document.getElementById('amount');

        // Initialize noUiSlider
        noUiSlider.create(slider, {
            start: [25, 5000], // Starting values
            connect: true,
            range: {
                'min': 0,
                'max': 10000
            },
            step: 25
        });

        // Update the displayed values when slider is moved
        slider.noUiSlider.on('update', function(values) {
            var minValue = parseFloat(values[0]).toFixed(2);
            var maxValue = parseFloat(values[1]).toFixed(2);
            amount.value = minValue + ' - ' + maxValue;

            // Send AJAX request with the updated range
            $.ajax({
                url: '/filter-projects',
                type: 'GET',
                data: {
                    min_price: minValue,
                    max_price: maxValue
                },
                success: function(response) {
                    // Handle the response (e.g., update the page with the filtered data)
                    $('#projects-list').html(response);
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        });

    $(document).ready(function() {


    });

        /////////////////////////////////

        // التنقل بين الصفحات
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let selectedCategories = [];
            $('.category-filter:checked').each(function() {
                selectedCategories.push($(this).val());
            });
            loadProjects(page, selectedCategories);
        });
    });
</script>

@endsection
