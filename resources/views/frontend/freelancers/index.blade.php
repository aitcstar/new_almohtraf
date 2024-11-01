@extends('frontend.layouts.master')
@section('title', 'ابحث عن حريفة')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
<style>

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
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 16px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('message') }}
        </div>
        @endif
        <div class="container" style="min-height: 100vh;">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        @auth
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                        @endauth
                        <li class="breadcrumb-item" data-index="1">ابحث عن حريفة</li>
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
                                        <label for="project__category"><p>التخصص </p></label>
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
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <main class="freelancers" id="freelancers-list">
                        @include('frontend.freelancers.partials.freelancers-list', ['onlineFreelancers' => $onlineFreelancers])
                    </main>
                </div>
            </div>

        </div>
    </div>
</category>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>

<script>
    $(document).ready(function() {
        // لتحميل المشاريع عند تغيير الصفحة أو الفلتر
        function loadFreelancers(page = 1, categoryIds = []) {
            $.ajax({
                url: "{{ route('freelancers.list') }}",
                type: "GET",
                data: {
                    page: page,
                    category_ids: categoryIds
                },
                success: function(data) {
                    $('#freelancers-list').html(data);
                }
            });
        }

        // فلترة المشاريع عند تغيير الفلاتر
        $('.category-filter').change(function() {
            let selectedCategories = [];
            $('.category-filter:checked').each(function() {
                selectedCategories.push($(this).val());
            });
            loadFreelancers(1, selectedCategories);
        });

        // التنقل بين الصفحات
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let selectedCategories = [];
            $('.category-filter:checked').each(function() {
                selectedCategories.push($(this).val());
            });
            loadFreelancers(page, selectedCategories);
        });
    });
</script>
@endsection
