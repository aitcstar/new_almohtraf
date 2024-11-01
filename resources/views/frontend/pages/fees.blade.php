@extends('frontend.layouts.master')
@section('title', 'عمولة المنصة')
@section('content')

    <category  style="direction: rtl;text-align: right;">
        <div class="category">
            <div class="container" style="min-height: 100vh;">
                <div class="row">
                    <div class="container panel panel-default">
                        <div class="col-md-12" s style="width: 100%;max-width: 100%;">
                            {!! $fees !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </category>
    @endsection
