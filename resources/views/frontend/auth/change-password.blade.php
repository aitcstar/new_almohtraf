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

    <title>تغيير كلمة المرور </title>
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
                <h3 class="text-uppercase"> تغيير كلمة المرور </h3>
              </div>
              <form action="{{ route('restorechangepassword') }}" autocomplete="off" method="POST">
                @csrf
                <input type="hidden" name="mail" value="{{$mail}}">
                <div class="form-group mb-3" style="direction: rtl;">
                    <div
                        class="input-group input-group-merge @if ($errors->has('password')) is-invalid @endif">
                        <input class="form-control @if ($errors->has('password')) is-invalid @endif"
                            name="new_password" type="password" required="" id="password"
                            placeholder=" كلمة المرور الجديده" />
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group mb-3" style="direction: rtl;">
                    <div
                        class="input-group input-group-merge @if ($errors->has('password_confirmation')) is-invalid @endif">
                        <input class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif"
                            name="password_confirmation" type="password" required=""
                            placeholder=" تأكيد كلمة المرور" />
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-block" type="submit" style="background-color: #059d9d;border-color: #059d9d;">إرسال </button>
                </div>

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
