<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- awesome fontfamily -->
  <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>

   <link rel="stylesheet" href="{{ asset('frontend/auth/fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/auth/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/auth/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/auth/css/style.css')}}">

    <title>تسجيل الدخول </title>
  </head>
  <body>


  <div class="d-md-flex half">
    <div class="bg" style="background-image: url('frontend/images/bg_1.jpg');"></div>
    <div class="contents">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-12">
            <div class="form-block mx-auto" style="direction: rtl;text-align: right;">
              <div class="text-center mb-5">

                @if (session()->has('message'))
                <div class="alert alert-danger alert-dismissible" style="text-align: center;font-size: 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
                @endif
                <h3 class="text-uppercase">تسجيل الدخول </h3>
              </div>
              <form action="{{ route('login.ClientStore') }}" method="POST">
                @csrf
                <div class="form-group first">
                  <input type="email" class="form-control"  name="email" value="{{ old('email') }}" placeholder=" البريد الإلكتروني"  id="email" required>
                </div>
                <div class="form-group last mb-3">
                  <input type="password" class="form-control " name="password"  id="password"
                  placeholder="كلمة المرور" id="password" required>
                </div>

                <div class="d-sm-flex mb-5 align-items-center" style="direction: ltr;">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">تذكرني</span>
                    <input type="checkbox" checked="checked"/>
                    <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="/reset-password" class="forgot-pass">استعادة كلمة المرور</a></span>
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-block" type="submit" style="background-color: #0198be;border-color: #0198be;">تسجيل الدخول </button>
                </div>

                <hr>

                <a href="/register">لا املك حساب ! انشاء حساب جديد</a>

                <!--
                <span class="text-center my-3 d-block">او</span>


                <div class="" style="direction: ltr;">
                <a href="#" class="btn btn-block py-2 btn-facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-microsoft" viewBox="0 0 16 16">
                        <path d="M7.462 0H0v7.19h7.462zM16 0H8.538v7.19H16zM7.462 8.211H0V16h7.462zm8.538 0H8.538V16H16z"/>
                      </svg> باستخدام ماكروسوفت
                </a>
                <a href="#" class="btn btn-block py-2 btn-google"><span class="icon-google mr-3"></span>   باستخدام جوجل</a>
                </div>
            -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

  <script src="{{ asset('frontend/auth/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('frontend/auth/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/auth/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/auth/js/main.js') }}"></script>

  </body>
</html>
