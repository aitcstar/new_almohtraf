@extends('frontend.layouts.master')
@section('title', 'الأسئلة الشائعة')
@section('content')

    <category  style="direction: rtl;text-align: right;">
        <div class="category">
            <div class="container">
                <div class="row">
                    <div class="container panel panel-default">
                        <div class="col-md-12" s style="width: 100%;max-width: 100%;">
                            {!! $faq !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </category>
    @endsection
