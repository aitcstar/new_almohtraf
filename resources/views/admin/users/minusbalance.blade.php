@extends('layouts.vertical', ['title' => 'Update minus Balance Users', 'mode' => 'rtl'])
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
                            <li class="breadcrumb-item active">رصيد بالسالب المستخدم</li>
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

                <form method="POST" action="{{ route('minusbalanceUpdate',['admin','users' ,'addminusbalance'])  }}" enctype="multipart/form-data">
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
                   
                    <div class="mb-3">
                        <label class="required" for="title">الرصيد الحالي</label>
                        <br>
                        <b> {{ $users->balance }}</b>
                    </div>

                    <div class="mb-3">
                        <label class="required" for="title"> الحاله  </label>
                        <input type="checkbox" name="minus" value="{{  $users->minus  }}" {{ $users->minus == 1 ? 'checked' : '' }}>
                    </div>
                    
                    <div class="mb-3" style="width: 20%;">
                        <label class="required" for="title">الحد الاقصي للسحب بالسالب</label>
                        <input class="form-control {{ $errors->has('minusprice') ? 'is-invalid' : '' }}" style="direction: ltr;" type="text" name="minusprice" value="{{  $users->minusprice  }}" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            تحديث
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