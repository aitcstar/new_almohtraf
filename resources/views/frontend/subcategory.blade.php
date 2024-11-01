@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
    <!-- services -->
    <div class="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                       <h3>الاقسام الفرعية </h3>
                    </div>
                 </div>
                 
                @foreach ($parents as $parent)
                    <div class="col-md-3" style="padding: 20px 16px;">
                        <div class="card">
                            <a href="{{ url('/service', $parent->id) }}">
                                <div class="row">
                                        <div class="col-md-6">
                                            <img src="{{ url('categories/', $parent->logo) }}"  class="card-img-top"/>
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class="card-title">{{ $parent->name }}</h2>
                                        </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end services -->
@endsection
