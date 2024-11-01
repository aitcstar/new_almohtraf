@extends('layouts.vertical', ['title' => 'تعديل  البنرات', 'mode' => 'rtl'])
@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/dashboard/admin/sliders/index">تعديل نبر</a></li>
                            <li class="breadcrumb-item active">تعديل البنرات</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تعديل / البنرات</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('sliders.update',['admin'])  }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $slider->id }}">


            <div class="form-group">
                <label class="required" for="logo">الصوره</label>
                <div class="custom-file">
                  <input type="file" name="image" class="custom-file-input">
                  <label class="custom-file-label" for="imageUploadInput">تحميل</label>
              </div>
            </div>

            <div class="img-preview @if(!isset($slider->image)) d-none @endif p-2" style="height:400px;border:1px solid #eaeaea">
                <img src="{{url('sliders/',$slider->image)}}"style="width: 100%;height:100%" />
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    تعديل
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>

    <!-- Page js-->
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/pages/add-product.init.js')}}"></script>

@endsection
