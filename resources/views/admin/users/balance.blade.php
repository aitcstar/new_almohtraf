@extends('layouts.vertical', ['title' => 'Update Balance Users', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item"><a href="/dashboard/admin/users/index/users">المستخدمين</a></li>
                            <li class="breadcrumb-item active">رصيد المستخدم</li>
                        </ol>
                    </div>
                    <h4 class="page-title">الرصيد / المستخدم</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
@if (session()->has('message'))
<div class="col-sm-6">
    <div class="alertPart">
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('message') }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="container card" >
                    <div class="row" style="direction: ltr;">
                        <div class="col-md-12">
                            <div class="titlepage text_align_center" style="text-align: center;padding: 11px 12px;">
                                <h3> حساباتي  </h3>
                            </div>
                        </div>
        
                        @foreach ($currencies as $currency)
                            <div class="col-md-4">
                                <div class="card" style="border: 1px solid #000;padding: 11px 12px;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2 class="card-title" style="margin:0 0 0 0;padding: 20px 16px;font-size: 20px;">{{ $currency->title }}</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <h2 class="card-title" style="margin:0 0 0 0;padding: 20px 16px;font-size: 20px;">{{ $users->balance($users->id, $currency->id) ?? 0 }}
                                                </h2>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <form method="POST" action="{{ route('balanceUpdate',['admin','users' ,'addbalance'])  }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $users->id }}">
                    <div class="mb-3">
                        <label class="required" for="title">الاسم</label>
                        <br>
                        <b> {{ $users->fullname }}</b>
                    </div>
                    <div class="mb-3">
                        <label class="required" for="title">البريد الالكتروني</label>
                        <br>
                        <b> {{ $users->email }}</b>
                   </div>

                    <div class="row mb-3">

                        <input class="form-control col-md-8" type="text" name="balance" type="number" placeholder="المبلغ" required="" min="1" style="min-width: 219px;text-align: center;">

                        <select class="form-control col-md-4" name="currency_id" id="currency">
                            @foreach ($currencies as $currency )
                                <option value="{{ $currency->id}}">{{ $currency->title}}</option>
                            @endforeach
                       </select>

                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            اضافه رصيد
                        </button>
                    </div>
                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <!-- end col -->

<hr>
<!--
     <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('usersPassword',['admin','users' ,'password'])  }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $users->id }}">
                    <div class="mb-3">
                        <label for="required" class="form-label">Password</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="text" name="password" id="password" value="{{ old('password', '') }}" required>
                        @if($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div> 
    </div>
-->
</div>



@endsection

@section('script')
<script>
    let code = document.getElementById('code');
    let phone = document.getElementById('phone');

    $('#code').on('change', function() {
        // alert(code.value);
        document.getElementById('phone').value = '';
        if (code.value == +965) {
            phone.addEventListener('keyup', () => {
                if (phone.value.length > 8) {
                    phone.value = phone.value.slice(0, 8);
                }
            })
        } else {
            phone.addEventListener('keyup', () => {
                if (phone.value.length > 10) {
                    phone.value = phone.value.slice(0, 10);
                }
            })
        }
    })

</script>
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>

    <!-- Page js-->
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/pages/add-product.init.js')}}"></script>

@endsection