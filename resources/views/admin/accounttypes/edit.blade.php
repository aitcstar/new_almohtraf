@extends('layouts.vertical', ['title' => 'تعديل  انواع الحساب', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item"><a href="/dashboard/admin/accounttypes/index">تعديل نوع الحساب</a></li>
                            <li class="breadcrumb-item active">تعديل انواع الحساب</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تعديل / انواع الحساب</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('accounttypes.update',['admin'])  }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $accounttype->id }}">

            <div class="form-group">
                <label class="required" for="title"> نوع الحساب</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"  value="{{ $accounttype->title }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="title">الحاله</label> <br>
                <input type="checkbox" name="status" @if($accounttype->status == 1) checked @endif>&nbsp;&nbsp;مفعل
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
