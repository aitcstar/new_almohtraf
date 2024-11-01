@extends('frontend.layouts.master')
@section('title', 'أخبرنا عن نفسك')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="background-color: white; padding: 20px 20px;">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
            @endif

        @include('frontend.boarding.partials.stepper', ['currentStep' => 3])

        <form action="{{ route('boarding.updateInfo') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="how_did_you_hear_about_us" style="font-size: 20px;">كيف تعرفت علينا؟</label>
                <div class="radio-buttons-container">
                    <label class="radio-block">
                        <input type="radio" name="how_did_you_hear_about_us" value="محرك البحث">
                        <span class="label-text">محرك البحث</span>
                    </label>
                    <label class="radio-block">
                        <input type="radio" name="how_did_you_hear_about_us" value="منصات التواصل الاجتماعي">
                        <span class="label-text">منصات التواصل الاجتماعي</span>
                    </label>
                    <label class="radio-block">
                        <input type="radio" name="how_did_you_hear_about_us" value="أخرى">
                        <span class="label-text">أخرى</span>
                    </label>
                </div>
            </div>
            <br><br><br><br>
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>


        </div>
    </div>
</category>


@endsection
