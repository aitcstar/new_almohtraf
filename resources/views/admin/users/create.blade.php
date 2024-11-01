@extends('layouts.vertical', ['title' => 'Add Users', 'mode' => 'rtl'])
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
                    <li class="breadcrumb-item"><a href="/dashboard/admin/users/index/users">Users</a></li>
                    <li class="breadcrumb-item active">Add Users</li>
                </ol>
            </div>
            <h4 class="page-title">Add / Users</h4>
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

                <form method="POST" action="{{ route('usersStore',['admin','users' ,'store'])  }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="required" for="title">Name</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="required" for="title">E-mail</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', '') }}" required>
                        @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="mb-2 col-md-2">
                                <label class="required" for="title">Code</label>

                                <select name="code" id="code" class="form-control" required>
                                    <option value=""> Choose</option>
                                    <option value="+965"> kuwait (+965)</option>
                                    <option value="+20">Egypt (+20)</option>
                                </select>
                                @if($errors->has('code'))
                                <span class="text-danger">{{ $errors->first('code') }}</span>
                                @endif
                            </div>
                            <div class="mb-10 col-md-10">
                                <label class="required" for="title">Phone</label>
                                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                                @if($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>


                        </div>


                    </div>
                    <div class="mb-3">
                        <label for="required" class="form-label">Password</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="text" name="password" id="password" value="{{ old('password', '') }}" required>
                        @if($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>


                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            save
                        </button>
                    </div>
                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <!-- end col -->

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
