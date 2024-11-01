@extends('layouts.vertical', ['title' => 'اضافه الاقسام', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item"><a href="/dashboard/admin/categories/index">الاقسام</a></li>
                            <li class="breadcrumb-item active">اضف قسم</li>
                        </ol>
                    </div>
                    <h4 class="page-title">اضف / قسم</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('subcategories.store',['admin'])  }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="product-category">الاقسام <span class="text-danger">*</span></label>
                    <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="parent_id">
                        @foreach($categories as $key=>$value)
                           <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="required" for="title">القسم الفرعي</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="title">الحاله</label> <br>
                <input type="checkbox" name="status"  checked>&nbsp;&nbsp;مفعل
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
