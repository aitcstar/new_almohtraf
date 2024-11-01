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
    <style>
         .head-top {
            background-color: #ffffff; /* لون خلفية الشريط العلوي */
            height: 90px;
        }
        .text_align_right {
    text-align: right;
}
        ul, li, ol {
    /* margin: 0px; */
    padding: 5px;
    list-style: none;
}
        ul.email {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
ul.email li {
    display: inline-block;
}

ul li {
    list-style: none;
}
ul.email li a {
    font-size: 14px;
    color: #fff;
    display: flex;
    align-items: center;
    /* padding-right: 60px; */
}


.class-_-1{
    color: #ffffff;
    padding-left: 34px;
    padding-right: 34px;
    font-size: 18px;
    font-weight: 500;
    background-color:#049d9d;
    text-align: center;
    height: 54px;
    min-width: 130px;
    border-radius: 8px;
    margin-top: 15px;
}
.flex-row-center-center {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
.ui.heading.size-textlg {
    font-size: 17px;
    font-weight: 500;
    font-style: bold;
    text-align: right;
    color: #333333;
}
.ui.heading.size-textlg {
    font-size: 17px;
    font-weight: 500;
    font-style: bold;
    text-align: right;
    margin-top: 15px;
}
            </style>
  </head>
  <body>

    <div class="head-top">
        <div class="container-fluid">
            <div class="row d_flex">

                <div class="col-sm-12">
                    <ul class="email text_align_right" style="width: 90%;">
                        <li class="d_none">
                            <a href="/login-client">
                                <p class="flex-row-center-center  class-_ ui heading size-textlg">تسجيل الدخول</p>
                            </a>

                           <!-- <a href="/login-client" style="font-size: 14px;color: #059d9d; border: 1px solid #059d9d;padding: 6px 7px;;display: flex;align-items: center;">  تسجيل دخول  &nbsp;</a>-->
                        </li>
                        <li class="d_none">
                            <a href="/register">
                                <p class="flex-row-center-center class-_-1" >انشاء حساب</p>
                            </a>

                            <!--<a href="/register" style="font-size: 14px;color: #059d9d; border: 1px solid #059d9d;padding: 6px 7px;;display: flex;align-items: center;"> حساب جديد &nbsp;</a>-->
                            </li>

                        <li class="d_none">
                            <a href="{{ route('index') }}"><img src="{{ asset('frontend/index/public/images/img_nlogo_2.png') }}" style=" height: 54px;margin-left: 10px;"/></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="contents"  style="background-color:#f2f2f2;padding: 21px 0px;">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-12">
            <div class="form-block mx-auto" style="direction: rtl;text-align: right;">
              <div class="text-center mb-5">

                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 14px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
                @endif
                <h3 class="text-uppercase">تسجيل الدخول </h3>
              </div>
              <form action="{{ route('login.ClientStore') }}" autocomplete="off" method="POST">
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
                  <span class="ml-auto"><a href="/reset-password" class="forgot-pass" style="color: #059d9d;">استعادة كلمة المرور</a></span>
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-block" type="submit" style="background-color: #059d9d;border-color: #059d9d;">تسجيل الدخول </button>
                </div>

                <hr>

                <a href="/register" style="color: #059d9d;">لا املك حساب ! انشاء حساب جديد</a>


               <!-- <span class="text-center my-3 d-block">او</span>


                <div class="" style="direction: ltr;">
                <a href="#" class="btn btn-block py-2 btn-facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-microsoft" viewBox="0 0 16 16">
                        <path d="M7.462 0H0v7.19h7.462zM16 0H8.538v7.19H16zM7.462 8.211H0V16h7.462zm8.538 0H8.538V16H16z"/>
                      </svg> باستخدام ماكروسوفت
                </a>


                <a href="{{ route('login.google') }}" class="btn btn-block py-2 btn-google"><span class="icon-google mr-3"></span>   باستخدام جوجل</a>
                </div>-->

              </form>
            </div>
          </div>
        </div>
      </div>



  </div>
  <footer class="text-dark pt-5">

    <div class="text-center py-3" style="background: #ffffff;color: #059d9d;">
      <p class="mb-0">&copy;  2024  جميع الحقوق محفوظة المحترف .</p>
    </div>
  </footer>
  <script src="{{ asset('frontend/auth/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('frontend/auth/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/auth/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/auth/js/main.js') }}"></script>

  </body>
</html>
