<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.shared.title-meta', ['title' => "Log In"])

        @include('layouts.shared.head-css')
    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4" style="direction: rtl;">

                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="{{route('index')}}" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{asset('frontend/images/Nlogo.png')}}" alt="" height="100"
                                            </span>
                                        </a>

                                        <a href="{{route('index')}}" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{asset('frontend/images/Nlogo.png')}}" alt="" height="100"
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3" style="text-align: right;font-weight: bold;">
                                         أدخل عنوان بريدك الإلكتروني وكلمة المرور للوصول إلى لوحة الإدارة
                                    </p>
                                </div>

                                <form action="{{route('login')}}" method="POST" novalidate>
                                    @csrf

                                    <div class="form-group mb-3" style="text-align: right;">
                                        <label for="emailaddress">عنوان البريد الإلكتروني</label>
                                        <input class="form-control  @if($errors->has('email')) is-invalid @endif" name="email" type="email"
                                            id="emailaddress" required=""
                                            value="{{ old('email')}}"
                                            placeholder="عنوان البريد الإلكتروني" />

                                            @if($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                    </div>

                                    <div class="form-group mb-3" style="text-align: right;">
                                        <label for="password">كلمة المرور</label>
                                        <div class="input-group input-group-merge @if($errors->has('password')) is-invalid @endif">
                                            <input class="form-control @if($errors->has('password')) is-invalid @endif" name="password" type="password"   required=""
                                                id="password" placeholder="كلمة المرور" />
                                                <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin">تذكرنى</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit">تسجيل الدخول</button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!--<div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="{{route('second', ['auth', 'recoverpw-2'])}}" class="text-white-50 ml-1">Forgot your password?</a></p>
                                <p class="text-white-50">Don't have an account? <a href="{{route('register')}}" class="text-white ml-1"><b>Sign Up</b></a></p>
                            </div>
                        </div>-->
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <!--<footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a>
        </footer>-->

        @include('layouts.shared.footer-script')

    </body>
</html>
