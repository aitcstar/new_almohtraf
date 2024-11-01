@extends('frontend.layouts.master')
@section('title', 'Home')

@section('content')
    <!-- services -->
    <div style="margin: 50px 0 0 0;">
        @foreach ($sliders as $slider)
            <img class="mySlides" src="{{ url('sliders/', $slider->image) }}">
        @endforeach
    </div>


    <div class="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2> ابحث على حريفة محترفين في كافة المجالات </h2>
                    </div>
                </div>

                @foreach ($categories as $category)
                    <div class="col-md-3" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ url('categories/', $category->logo) }}" class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">{{ $category->name }}</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="services" style="background-color: #fafafa;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>كيف يساعدك المحترف على إنجاز أعمالك</h2>
                    </div>
                </div>

                    <div class="col-md-4" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ url('categories/startup.svg') }}"   class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">أنجز أعمالك بسرعة وسهولة</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ url('categories/like.svg') }}" class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">وظّف أفضل المستقلين </h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ url('categories/dollar-symbol.svg') }}"  class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">نفذ مشاريعك بتكلفة أقل</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ url('categories/laptop.svg') }}"  class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">ادفع بأريحية وأمان</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img  src="{{ url('categories/teamwork.svg') }}"  class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">غطي احتياجاتك من المهارات</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 20px 16px;">
                        <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ url('categories/handshake.svg') }}"   class="card-img-top" />
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="card-title">اضمن حقوقك</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="services">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">ماذا قال عملاؤنا عنا</h2>
                <p class="section-subtitle">آراء وتجارب عملائنا مع خدماتنا</p>
              </div>
            <div class="row">

                   <!-- Testimonial 1 -->
                        <div class="col-md-4">
                          <div class="card shadow-sm mb-4">
                            <div class="card-body text-center">
                              <img src="https://via.placeholder.com/100" alt="Client 1" class="rounded-circle mb-3" style="width: 100px;">
                              <h5 class="card-title">عميل 1</h5>
                              <p class="card-text">
                                "لقد كانت تجربتي مع هذه الشركة رائعة حقاً. الخدمة سريعة وفريق العمل محترف."
                              </p>
                            </div>
                          </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="col-md-4">
                          <div class="card shadow-sm mb-4">
                            <div class="card-body text-center">
                              <img src="https://via.placeholder.com/100" alt="Client 2" class="rounded-circle mb-3" style="width: 100px;">
                              <h5 class="card-title">عميل 2</h5>
                              <p class="card-text">
                                "الخدمة كانت ممتازة وأسعارهم تنافسية. بالتأكيد سأتعامل معهم مرة أخرى."
                              </p>
                            </div>
                          </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="col-md-4">
                          <div class="card shadow-sm mb-4">
                            <div class="card-body text-center">
                              <img src="https://via.placeholder.com/100" alt="Client 3" class="rounded-circle mb-3" style="width: 100px;">
                              <h5 class="card-title">عميل 3</h5>
                              <p class="card-text">
                                "لقد ساعدونا في حل جميع مشكلاتنا بكل احترافية وبسرعة. أنصح الجميع بالتعامل معهم."
                              </p>
                            </div>
                          </div>
                        </div>
            </div>
        </div>
    </div>




    <div class="services" style="background: #fafafa;">
        <div class="container text-center my-5">
            <h2 class="mb-4">هل أنت جاهز لبدء مشروعك؟</h2>
            <a href="/project/create" class="btn btn-primary btn-lg">ابدأ مشروعك الآن</a>
        </div>
    </div>

<div class="services" style="background: #f0fbfe;color: #000000;">
    <div class="container">
        <div class="row">
          <!-- Pages Section -->
          <div class="col-md-4 mb-4">
            <h5 class="text-uppercase">الصفحات</h5>
            <ul class="list-unstyled">
             <li><a href="/faq" class="text-dark text-decoration-none">الأسئلة الشائعة </a></li>
              <li><a href="/terms" class="text-dark text-decoration-none">شروط الاستخدام</a></li>
              <li><a href="/privacy" class="text-dark text-decoration-none">بيان الخصوصية</a></li>
              <li><a href="/guarantee" class="text-dark text-decoration-none">ضمان حقوقك</a></li>
              <li><a href="/fees" class="text-dark text-decoration-none">عمولة المنصة </a></li>
            </ul>
          </div>

          <!-- Services Section -->
          <div class="col-md-4 mb-4">
            <h5 class="text-uppercase">الاقسام</h5>
            <ul class="list-unstyled">
                @foreach ($categories as $category)
                    <li><a href="#" class="text-dark text-decoration-none">{{ $category->name }}</a></li>
                @endforeach
            </ul>
          </div>

          <!-- Contact Section -->
          <div class="col-md-4 mb-4">
            <h5 class="text-uppercase">تواصل معنا</h5>
            <ul class="list-unstyled">
              <li><i class="bi bi-geo-alt-fill me-2"></i>المملكة العربية السعودية جدة </li>
              <li><i class="bi bi-telephone-fill me-2"></i>+123 456 7890</li>
              <li><i class="bi bi-envelope-fill me-2"></i>info@leetaxi.com</li>
              <li>
                <a href="#" class="text-dark text-decoration-none">
                  <i class="bi bi-facebook me-2"></i>Facebook
                </a>
              </li>
              <li>
                <a href="#" class="text-dark text-decoration-none">
                  <i class="bi bi-twitter me-2"></i>Twitter
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

    <!-- end services -->
    </div>
@endsection
