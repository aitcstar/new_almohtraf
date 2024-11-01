

@extends('frontend.layouts.master')
@section('title', 'العروض الخاصة بي')
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
        <div class="container" style="min-height: 100vh;">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        @auth
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                        @endauth
                        <li class="breadcrumb-item" data-index="1"> العروض الخاصة بي</li>
                    </ol>
                </div>

                <div class="col-md-3">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project__category"><p>الحالة </p></label>
                                    @foreach($bidStatus as $status)
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
                        </div>
                    </div>


                </div>

                <div class="col-md-9">
                    <main class="projects" id="projects-bids-list">
                        @include('frontend.projects.partials.project-bids-list', ['bids' => $bids])
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
            url: "{{ route('myBids') }}?page=" + page,
            method: "GET",
            data: {
                status: selectedStatus
            },
            success: function(data) {
                $('#projects-bids-list').html(data); // تحديث قائمة المشاريع
            }
        });
    }
});


</script>

@endsection
