@extends('layouts.vertical', ['title' => 'تعديل  العملات', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item"><a href="/dashboard/admin/sliders/index/sliders">تعديل عمله</a></li>
                            <li class="breadcrumb-item active">تعديل العملات</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تعديل / العملات</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('currenciesUpdate',['admin','currencies' ,'update'])  }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $currency->id }}">

            <div class="form-group">
                <label class="required" for="title">الاسم</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"  value="{{ $currency->title }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="title">رمز العملة</label>
                <input class="form-control {{ $errors->has('symbol') ? 'is-invalid' : '' }}" type="text" name="symbol"  value="{{ $currency->symbol  }}" required>
                @if($errors->has('symbol'))
                    <span class="text-danger">{{ $errors->first('symbol') }}</span>
                @endif
            </div>
            @if($currency->id != 1)
                <div class="form-group">
                    <label class="required" for="title">سعر الصرف مقابل الدولار <span class="text-danger">*</span></label>
                    <input class="form-control {{ $errors->has('rate') ? 'is-invalid' : '' }}" type="text" name="rate" value="{{ $currency->rate  }}" required>
                    @if($errors->has('rate'))
                        <span class="text-danger">{{ $errors->first('rate') }}</span>
                    @endif
                </div>
            @endif
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