@extends('layouts.vertical', ['title' => 'تعديل  الاقسام', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item"><a href="/dashboard/admin/categories/index">تعديل القسم</a></li>
                            <li class="breadcrumb-item active">تعديل الاقسام</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تعديل / الاقسام</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update',['admin'])  }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $category->id }}">

            <div class="form-group">
                <label class="required" for="title">قسم</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"  value="{{ $category->name }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="logo">اللوجو</label>
                <div class="custom-file">
                  <input type="file" name="logo" class="custom-file-input">
                  <label class="custom-file-label" for="imageUploadInput">تحميل</label>
              </div>
            </div>

            <div class="img-preview @if(!isset($category->logo)) d-none @endif p-2" style="height:100px;border:1px solid #eaeaea">
                <img src="{{url('categories/',$category->logo)}}"style="height:100%" />
            </div>

            <div class="form-group">
                <label class="required" for="title">الحاله</label> <br>
                <input type="checkbox" name="status" @if($category->status == 1) checked @endif>&nbsp;&nbsp;مفعل
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
