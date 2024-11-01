@extends('frontend.layouts.master')
@section('title', 'اختبار القبول')
@section('content')

<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 20px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('message') }}
            </div>
        @endif

        @include('frontend.boarding.partials.stepper', ['currentStep' => 4])


        </div>
    </div>
</category>



@endsection
