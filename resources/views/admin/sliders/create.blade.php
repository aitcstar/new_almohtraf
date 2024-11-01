@extends('layouts.vertical', ['title' => 'اضافه بنر', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item"><a href="/dashboard/admin/sliders/index">البنرات</a></li>
                            <li class="breadcrumb-item active">اضف بنر</li>
                        </ol>
                    </div>
                    <h4 class="page-title">اضف / بنر</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('sliders.store',['admin'])  }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="logo">الصوره</label>
                <div class="custom-file">
                  <input type="file" name="image" class="custom-file-input" required>
                  <label class="custom-file-label" for="imageUploadInput">تحميل</label>
              </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    حفظ
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
