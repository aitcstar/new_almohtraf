

@extends('frontend.layouts.master')
@section('title', ' الإشعارات')
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
                        <li class="breadcrumb-item" data-index="1"> الإشعارات </li>
                    </ol>
                </div>

                <div class="col-md-12">
                    <main class="projects" id="projects-list">
                        @if($notifications->isEmpty())
                        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
                            <h3 class="text-muted">لا توجد اشعارات حاليًا</h3>
                        </div>
                    @else

                        @foreach ($notifications as $notification)
                            <div class="project">
                                <h3><a href="{{ route('notifications.markAsRead', $notification->id) }}">{{ $notification->message }}</a></h3>
                                <ul class="project__meta list-meta-items">

                                    <li class="text-muted"><time datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}" itemprop="datePublished" data-toggle="tooltip" data-original-title="{{ $notification->created_at }}"><i class="fa fa-clock-o"></i> {{ $notification->timeElapsed($notification->created_at) }}</time></li>
                                </ul>
                            </div>
                        @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $notifications->links('pagination::bootstrap-4') }}
                    </div>

                    @endif

                    </main>
                </div>


            </div>
        </div>
    </div>
</category>



@endsection
