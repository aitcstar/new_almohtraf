<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>الرئيسية - منصة المحترفين</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#000000" />
    <meta name="description" content="Web site created using create-react-app" />
    <img
      alt="Logo"
      src="https://appproject.dhiwise.com/dhiwise-logo.png?c=&v="
      style="width: 0px; height: 0px; display: none"
    />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/swiper@11.0.6/swiper.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/index/css/index.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/index/css/font.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/index/css/styles.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/index/css/components.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/index/css/Landingpage.css')}}"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11.0.6/swiper-bundle.min.js" defer></script>
    <script>
      async function handleSlider() {
        const slider = document.querySelector("#slider");

        // Wait for all content to load before setting maxWidth
        const imageList = slider.querySelectorAll("img");
        const onLoadPromiseList = [];
        for (const image of imageList) {
          if (image.complete) continue;

          const onLoadPromise = new Promise((resolve, reject) => {
            if (image.complete) return resolve();
            image.onload = resolve;
            image.onerror = resolve;
          });
          onLoadPromiseList.push(onLoadPromise);
        }
        await Promise.all(onLoadPromiseList);

        // Set max width and height to prevent slider from overflowing
        slider.style.maxWidth = getComputedStyle(slider).width;
        slider.style.maxHeight = getComputedStyle(slider).height;

        const sliderParent = slider.parentElement;
        const sliderTrack = document.querySelector("#slider > .swiper-wrapper");
        const slides = document.querySelectorAll("#slider > .swiper-wrapper > .swiper-slide");

        // Clone slides for infinite loop
        const slidesToShow = 3;
        const slidesRequired = 6;
        for (let i = 0; slides.length <= slidesToShow && i <= slidesRequired - 1; i++) {
          const index = i % slidesToShow;
          const clone = slides[index]?.cloneNode(true);
          clone?.setAttribute("cloned", "");
          sliderTrack?.appendChild(clone);
        }

        const swiper = new Swiper("#slider", {
          grabCursor: true,
          loop: true,
          slidesOffsetAfter: 0,
          slidesOffsetBefore: 0,
          slidesPerView: 3,
          pagination: {
            el: "#slider-pagination",
            clickable: true,
            bulletElement: "div",
          },
          breakpoints: {
            0: { slidesPerView: 1 },
            551: { slidesPerView: 1 },
            1051: { slidesPerView: 3 },
          },
        });
      }

      /**
       * Hydrate slider #slider
       */
      document.addEventListener("DOMContentLoaded", async () => {
        try {
          await handleSlider();
        } catch (error) {
          console.error(error);
        }
      });
      /**
       * Handles the value change functionality in a chip view
       */
      function handleChipView(/** @type {HTMLElement} */ target) {
        const labels = /** @type {NodeListOf<HTMLLabelElement>} */ target.querySelectorAll("label");
        for (const label of labels) {
          const checkbox = /** @type {HTMLInputElement} */ label.querySelector("input[type=checkbox]");
          if (!checkbox) continue;

          const template = /** @type {HTMLTemplateElement} */ label.querySelector("template");
          if (!template) continue;

          const labelSelectedStyles = /** @type {string[]} */ [
            ...template.content.querySelector("label[selected-styles]").classList,
          ].filter((className) => !label.classList.contains(className));
          const labelUnselectedStyles = /** @type {string[]} */ [
            ...template.content.querySelector("label[unselected-styles]").classList,
          ].filter((className) => !label.classList.contains(className));

          const closeButton = label.querySelector("[close-button]");

          function checkboxChangeEffect(/** @type {Event} */ event) {
            if (label.getAttribute("removed")) return;
            if (checkbox.checked) {
              labelSelectedStyles.forEach((style) => label.classList.add(style));
              labelUnselectedStyles.forEach((style) => label.classList.remove(style));
            } else {
              labelSelectedStyles.forEach((style) => label.classList.remove(style));
              labelUnselectedStyles.forEach((style) => label.classList.add(style));
            }
          }

          function closeButtonClickEffect(/** @type {Event} */ event) {
            if (label.getAttribute("removed")) return;
            event.preventDefault();
            label.setAttribute("remove", "true");
            label.parentElement.removeChild(label);
          }

          checkbox?.addEventListener("change", checkboxChangeEffect);
          closeButton?.addEventListener("click", closeButtonClickEffect);
        }
      }
      /**
       * Hydrate chip view(s)
       */
      document.addEventListener("DOMContentLoaded", () => {
        const elements = /** @type {NodeListOf<HTMLElement>} */ (document.querySelectorAll("[chip-view]"));
        for (const element of elements) handleChipView(element);
      });
      async function handleSlider1() {
        const slider = document.querySelector("#slider1");

        // Wait for all content to load before setting maxWidth
        const imageList = slider.querySelectorAll("img");
        const onLoadPromiseList = [];
        for (const image of imageList) {
          if (image.complete) continue;

          const onLoadPromise = new Promise((resolve, reject) => {
            if (image.complete) return resolve();
            image.onload = resolve;
            image.onerror = resolve;
          });
          onLoadPromiseList.push(onLoadPromise);
        }
        await Promise.all(onLoadPromiseList);

        // Set max width and height to prevent slider from overflowing
        slider.style.maxWidth = getComputedStyle(slider).width;
        slider.style.maxHeight = getComputedStyle(slider).height;

        const sliderParent = slider.parentElement;
        const sliderTrack = document.querySelector("#slider1 > .swiper-wrapper");
        const slides = document.querySelectorAll("#slider1 > .swiper-wrapper > .swiper-slide");

        // Clone slides for infinite loop
        const slidesToShow = 2;
        const slidesRequired = 4;
        for (let i = 0; slides.length <= slidesToShow && i <= slidesRequired - 1; i++) {
          const index = i % slidesToShow;
          const clone = slides[index]?.cloneNode(true);
          clone?.setAttribute("cloned", "");
          sliderTrack?.appendChild(clone);
        }

        document.getElementById('slider1').style.maxHeight = '300px';
        document.getElementById('slider').style.maxHeight = '170px';

        const swiper = new Swiper("#slider1", {
          grabCursor: true,
          loop: true,
          slidesOffsetAfter: 0,
          slidesOffsetBefore: 0,
          slidesPerView: 2,
          pagination: {
            el: "#slider1-pagination",
            clickable: true,
            bulletElement: "div",
          },
          breakpoints: {
            0: { slidesPerView: 1 },
            551: { slidesPerView: 1 },
            1051: { slidesPerView: 2 },
          },
        });
      }

      /**
       * Hydrate slider #slider1
       */
      document.addEventListener("DOMContentLoaded", async () => {
        try {
          await handleSlider1();
        } catch (error) {
          console.error(error);
        }
      });
    </script>
  </head>
  <body>
    <div class="landing-page">
      <div class="row">
        <div class="column">
          <header class="navigationbar">
            <div class="row_two container-xs">
              <div class="row-4">
                <ul class="row_-4">
                  <li>
                    <a href="/login-client" class="class-_-link">
                      <p class="class-_-12 ui heading size-textlg">تسجيل الدخول</p>
                    </a>
                  </li>
                  <li>
                    <a href="/register">
                      <p class="class-_ ui heading size-textlg">انشاء حساب</p>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="rowline">
                <div class="row_one">
                  <div class="row-7">
                    <a href="/project/index"><p class="ui text size-textxs">تصفح المشاريع</p></a>
                    <a href="/project/index">
                      <img src="{{ url('frontend/index/public/images/img_icons8_webpages.svg') }}" alt="Icons8webpages" class="icons8webpages" />
                    </a>
                  </div>
                  <div class="row-7">
                    <a href="/freelancers"><p class="ui text size-textxs">ابحث عن محترفين</p></a>
                    <a href="/freelancers">
                      <img src="{{ url('frontend/index/public/images/img_search.svg') }}" alt="Search" class="icons8webpages" />
                    </a>
                  </div>
                  <!--<div class="row-7">
                    <a href="/profile/index?tab=tab-3"><p class="ui text size-textxs">اضف عمل</p></a>
                    <a href="/profile/index?tab=tab-3">
                      <img src="{{ url('frontend/index/public/images/img_icons8_add_new_1.svg') }}" alt="Icons8addnew" class="icons8webpages" />
                    </a>
                  </div>-->
                  <div class="row-7">
                    <a href="/project/create"><p class="ui text size-textxs">اضف مشروع</p></a>
                    <a href="/project/create">
                      <img src="{{ url('frontend/index/public/images/img_icons8_add_1_1.svg') }}" alt="Icons8add1one" class="icons8webpages" />
                    </a>
                  </div>
                </div>
                <div class="line_one"></div>
                <a href="/"><img src="{{ url('frontend/index/public/images/img_nlogo_2.png') }}" alt="Nlogotwo" class="nlogotwo_one" /></a>
              </div>
            </div>
          </header>
          <div class="column-1 container-xs">
            <div class="column_-1">
              <div class="column-4">
                <h1 class="ui heading size-headingxl">انجز مشاريعك بكفاءة مع أفضل المحترفين</h1>
                <p class="ui text size-textxl" style="color: white;">تواصل مع آلاف المحترفين المهرة وأكمل مشاريعك بسهولة</p>
              </div>
              <a href="/register" class="class-_-link">
                <p class="flex-row-center-center class-_-1">ابدأ الآن</p>
              </a>
              <!--<button class="flex-row-center-center class-_-1">ابدأ الآن</button>-->
            </div>
          </div>
        </div>
      </div>
      <div class="row_">
        <div class="column_one">
          <div class="column_ container-xs">
            <h2 class="class-_ ui heading size-headinglg">كيف نعمل؟</h2>
            <div class="landing_page">
              <div class="column_one-1">
                <div class="rowfour">
                  <img src="{{ url('frontend/index/public/images/img_icons8_service_1_cyan_700.svg') }}" alt="Image" class="image-1" />
                  <div class="column-18">
                    <div class="flex-col-center-center columnfour">
                      <h3 class="four ui heading size-headings">04</h3>
                    </div>
                  </div>
                </div>
                <div class="column-11">
                  <p class="-8 ui text size-texts">بدء العمل واستلام النتائج</p>
                  <p class="-9 ui text size-textmd">ابدأ العمل واحصل على النتائج المطلوبة</p>
                </div>
              </div>
              <div class="rectangle"></div>
              <div class="column_one-1">
                <div class="rowfour">
                  <img src="{{ url('frontend/index/public/images/img_icons8_service_1_cyan_700_44x44.svg') }}" alt="Image" class="image-1" />
                  <div class="column-18">
                    <div class="flex-col-center-center columnfour">
                      <h4 class="four ui heading size-headings">03</h4>
                    </div>
                  </div>
                </div>
                <div class="column-11">
                  <p class="-8 ui text size-texts">اختيار المحترف المناسب</p>
                  <p class="-9 ui text size-textmd">اختر المحترف الأفضل لمشروعك</p>
                </div>
              </div>
              <div class="rectangle"></div>
              <div class="column_one-1">
                <div class="rowfour">
                  <img src="{{ url('frontend/index/public/images/img_icons8_service_1.svg') }}" alt="Image" class="image-1" />
                  <div class="column-18">
                    <div class="flex-col-center-center columnfour">
                      <h5 class="four ui heading size-headings">02</h5>
                    </div>
                  </div>
                </div>
                <div class="column-11">
                  <p class="-8 ui text size-texts">استقبال العروض</p>
                  <p class="-9 ui text size-textmd">استقبل مقترحات المحترفين المتنوعة</p>
                </div>
              </div>
              <div class="rectangle"></div>
              <div class="column_one-1">
                <div class="rowfour">
                  <img src="{{ url('frontend/index/public/images/img_icons8_service_1_44x44.svg') }}" alt="Image" class="image-1" />
                  <div class="column-18">
                    <div class="flex-col-center-center columnfour">
                      <h6 class="four ui heading size-headings">01</h6>
                    </div>
                  </div>
                </div>
                <div class="column-11">
                  <p class="-8 ui text size-texts">نشر مشروعك</p>
                  <p class="-9 ui text size-textmd">ابدأ بوصف فكرتك بوضوح</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="row_three">
          <div class="row-1 container-xs">
            <img src="{{ url('frontend/index/public/images/img_rectangle_27.png') }}" alt="Image" class="image" />
            <div class="column_two">
              <div class="column-5">
                <h2>للمحترفين واصحاب المشاريع</h2>
                <div class="column-15">
                  <p class="-16 ui text size-texts">مزايا استثنائية لتجربة عمل سلسة</p>
                  <p class="-17 ui text size-textxs">
                    تقدم منصتنا نظام دفع آمن، تصنيفات موثوقة للمحترفين ، وحماية كاملة لحقوقك في كل مشروع، مما يضمن لك
                    تجربة موثوقة وفعالة
                  </p>
                </div>
              </div>
              <div class="column-6">
                <div class="rowiconseight">
                  <div class="row-8">
                    <p class="-18 ui text size-textmd">ضمان حقوقك وفقًا للاتفاقية</p>
                    <p class="-8 ui text size-texts"> : حماية حقوق العمل</p>
                  </div>
                  <img src="{{ url('frontend/index/public/images/img_icons8_checkmark.svg') }}"  alt="Iconseight" class="iconseight" />
                </div>
                <div class="rowiconseight">
                  <div class="row-8">
                    <p class="-18 ui text size-textmd"> تعامل مالي مضمون وآمن بالكامل  </p>
                    <p class="-8 ui text size-texts"> : نظام الدفع الآمن   </p>
                  </div>
                  <img src="{{ url('frontend/index/public/images/img_icons8_checkmark.svg') }}" alt="Iconseight" class="iconseight" />
                </div>
                <div class="rowiconseight">
                  <div class="row-8">
                    <p class="-18 ui text size-textmd">اعرف تقييمات المحترفين مسبقًا</p>
                    <p class="-8 ui text size-texts"> : تصنيفات وتقييمات المحترفين</p>
                  </div>
                  <img src="{{ url('frontend/index/public/images/img_icons8_checkmark.svg') }}" alt="Iconseight" class="iconseight" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="column_one">
          <div class="columnicons_one container-xs">
            <div class="row-2">
              <div class="column-7">
                <a href="/all-categories"><h2 class="class-_ ui heading size-textlg">استكشف المزيد</h2></a>
                <div class="line_two"></div>
              </div>
              <div class="column-8">
                <h3 class="class-_ ui heading size-headinglg">الخدمات التي تحتاجها في مكان واحد</h3>
                <p class="-4 ui text size-textxs">
                  استكشف مجموعة واسعة من الخدمات التي تلبي احتياجاتك وتساعدك في إنجاز مشاريعك بكفاءة وجودة عالية.
                </p>
              </div>
            </div>
            <div>
              <div class="landing_page-1">
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons.svg') }}"  alt="Image" class="image_one" />
                      <h4 class="-23 ui heading size-textlg">تصميم، فيديو وصوتيات</h4>
                      <div class="rowonehundredtw">
                        <h5 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[4] ?? 0 }}</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_178x276.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons_white_a700.svg') }}"  alt="Image" class="image_one" />
                      <h6 class="-23 ui heading size-textlg">هندسة، عمارة وتصميم داخلي</h6>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[3] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_1.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons_white_a700_32x32.svg') }}"  alt="Image" class="image_one" />
                      <p class="-23 ui heading size-textlg">برمجة، تطوير المواقع والتطبيقات</p>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[2] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_2.png') }}"  alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_user.svg') }}" alt="Image" class="image_one" />
                      <p class="-23 ui heading size-textlg">اعمال وخدمات استشارية</p>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[1] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_3.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons_32x32.svg') }}" alt="Image" class="image_one" />
                      <p class="-23 ui heading size-textlg">تدريب وتعليم عن بعد</p>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[8] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_4.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons_1.svg') }}" alt="Image" class="image_one" />
                      <p class="-23 ui heading size-textlg">دعم، مساعدة وإدخال بيانات</p>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[7] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_5.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons_2.svg') }}" alt="Image" class="image_one" />
                      <p class="-23 ui heading size-textlg">كتابة، تحرير، ترجمة ولغات</p>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[6] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="stack">
                  <img src="{{ url('frontend/index/public/images/img_rectangle_31_6.png') }}" alt="Image" class="image-5" />
                  <div class="row-11">
                    <div class="column-23">
                      <img src="{{ url('frontend/index/public/images/img_icons_3.svg') }}"  alt="Image" class="image_one" />
                      <p class="-23 ui heading size-textlg">تسويق إلكتروني ومبيعات</p>
                      <div class="rowonehundredtw">
                        <h6 class="onehundredtwo ui heading size-headingmd">{{ $categoryCounts[5] ?? 0 }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row_-1">
        <div class="column_five">
          <div class="column_four container-xs">
            <div class="row-2">
              <div class="column-9">
                <a href="/project/index"><h2 class="class-_ ui heading size-textlg">استكشف المزيد</h2></a>
                <div class="line_three"></div>
              </div>
              <div class="column-8">
                <h3 class="class-_ ui heading size-headinglg">احدث المشاريع</h3>
                <p class="-5 ui text size-textxs">
                  تابع أحدث الفرص المتاحة الآن وتقدم للعمل على مشاريع جديدة تناسب مهاراتك واهتماماتك.
                </p>
              </div>
            </div>
            <div class="column-2">
              <div id="slider1" class="slider1 swiper" style="max-height: 300px;">
                <div class="swiper-wrapper">

                @foreach($projects as $project)
                  <div class="dhi-group swiper-slide">
                    <div class="row_-8" style="min-height: 250px;">
                      <div class="column-32">
                        <div class="row_-13">
                          <p class="class-_-21 ui text size-texts">{{ $project->category->name}} </p>
                          <div class="column-37">
                            <p class="-8 ui text size-texts">{{ $project->title}} </p>
                            <p class="-38 ui text size-texts">
                                {{ Str::limit($project->description, 60, '...') }}
                            </p>
                          </div>
                        </div>
                        <div class="row-24">
                          <div class="row_-15">
                            <p class="class-_-27 ui text size-texts">{{$project->ownerProject->firstname . ' ' . $project->ownerProject->familyname}}</p>
                            <img src="{{ url('frontend/index/public/images/img_icons8_user_1.svg') }}" alt="Icons8userone" class="icons8userone" />
                          </div>
                          <!--<div class="row_-16">
                            <p class="class-_-27 ui text size-texts">فلسطين، غزة</p>
                            <img src="{{ url('frontend/index/public/images/img_icons8_location.svg') }}" alt="Icons8location"class="icons8userone" />
                          </div>-->
                          <div class="row_-16">
                            <p class="class-_-27 ui text size-texts" style="direction: rtl;">{{ $project->timeElapsed($project->created_at) }} </p>
                            <img src="{{ url('frontend/index/public/images/img_icons8_clock_1.svg') }}" alt="Icons8clockone" class="icons8userone"/>
                          </div>
                        </div>
                        <div class="columnline">
                          <div class="line-1"></div>
                          <div class="row_-17">
                            <a  href="{{ route('projects.show', $project->id) }}" class="flex-row-center-center class-_-29"> تقديم عرض</a>

                            <div class="column100000200">
                              <div class="row10000020000">
                                <h4 class="class-10000020000 ui heading size-headings">  $  {{ $project->min_price }} - {{ $project->max_price }} </h4>
                                <h5 class="class-_-33 ui heading size-headingxs"> : الميزانية </h5>
                              </div>
                              <div class="rowzero">
                                <h6 class="zero ui heading size-headingxs"> {{ $project->bidsCount() }} </h6>
                                <p class="-18 ui text size-texts"> : عروض مقدمة</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach


                </div>
              </div>
              <div id="slider1-pagination" class="slider1-pagination"></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="column_one">
          <div class="column_six container-xs">
            <div class="column_-2">
              <h2 class="class-_ ui heading size-headinglg">قالوا عنا</h2>
              <p class="ui text size-textxs">
                اكتشف آراء العملاء حول منصتنا وكيف ساعدتهم في تحقيق أهدافهم بسهولة واحترافية
              </p>
            </div>
            <div class="column_-3">
              <div id="slider" class="slider swiper">
                <div class="swiper-wrapper">
                  <div class="dhi-group-2 swiper-slide">
                    <div class="row_-10">
                      <div class="column_-5">
                        <p class="-16 ui text size-texts">علي محمود</p>
                        <div class="column-35">
                          <p class="-36 ui text size-texts">
                            منصة ذات تجربة ممتعة وشياقة وسهلة الاستخدام، انصح الجميع<br />بالعمل فيها.
                          </p>
                          <div class="rowfive-2">
                            <p class="five ui text size-texts">(5 تقييمات)</p>
                            <h3 class="fortynine ui heading size-headingmd">4.9</h3>
                            <div class="ratingbar-1 ui ratingbar">
                              <input type="radio" id="ratingbar21" name="ratingbar2" value="1" />
                              <label for="ratingbar21" title="text"> </label>
                              <input type="radio" id="ratingbar22" name="ratingbar2" value="2" />
                              <label for="ratingbar22" title="text"> </label>
                              <input type="radio" id="ratingbar23" name="ratingbar2" value="3" />
                              <label for="ratingbar23" title="text"> </label>
                              <input type="radio" id="ratingbar24" name="ratingbar2" value="4" />
                              <label for="ratingbar24" title="text"> </label>
                              <input type="radio" id="ratingbar25" name="ratingbar2" value="5" />
                              <label for="ratingbar25" title="text"> </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <img src="{{ url('frontend/index/public/images/img_rectangle_33.png') }}"  alt="Image" class="image-13" />
                    </div>
                  </div>
                  <div class="dhi-group-2 swiper-slide">
                    <div class="row_-10">
                      <div class="column_-6">
                        <p class="-16 ui text size-texts">محمد احمد الخالدي</p>
                        <p class="-31 ui text size-texts">
                          منصة ذات تجربة ممتعة وشياقة وسهلة الاستخدام، انصح الجميع<br />بالعمل فيها.
                        </p>
                        <div class="rowfive">
                          <p class="five ui text size-texts">(5 تقييمات)</p>
                          <h4 class="fortynine ui heading size-headingmd">4.9</h4>
                          <div class="ratingbar-1 ui ratingbar">
                            <input type="radio" id="ratingbar11" name="ratingbar1" value="1" />
                            <label for="ratingbar11" title="text"> </label>
                            <input type="radio" id="ratingbar12" name="ratingbar1" value="2" />
                            <label for="ratingbar12" title="text"> </label>
                            <input type="radio" id="ratingbar13" name="ratingbar1" value="3" />
                            <label for="ratingbar13" title="text"> </label>
                            <input type="radio" id="ratingbar14" name="ratingbar1" value="4" />
                            <label for="ratingbar14" title="text"> </label>
                            <input type="radio" id="ratingbar15" name="ratingbar1" value="5" />
                            <label for="ratingbar15" title="text"> </label>
                          </div>
                        </div>
                      </div>
                      <img src="{{ url('frontend/index/public/images/img_rectangle_33_80x80.png') }}"  alt="Image" class="image-13" />
                    </div>
                  </div>
                  <div class="dhi-group-2 swiper-slide">
                    <div class="row_-10">
                      <div class="column_-6">
                        <p class="-16 ui text size-texts">علي خالد فارس</p>
                        <p class="-31 ui text size-texts">
                          منصة ذات تجربة ممتعة وشياقة وسهلة الاستخدام، انصح الجميع<br />بالعمل فيها.
                        </p>
                        <div class="rowfive">
                          <p class="five ui text size-texts">(5 تقييمات)</p>
                          <h5 class="fortynine ui heading size-headingmd">4.9</h5>
                          <div class="ratingbar-1 ui ratingbar">
                            <input type="radio" id="ratingbar1" name="ratingbar" value="1" />
                            <label for="ratingbar1" title="text"> </label>
                            <input type="radio" id="ratingbar2" name="ratingbar" value="2" />
                            <label for="ratingbar2" title="text"> </label>
                            <input type="radio" id="ratingbar3" name="ratingbar" value="3" />
                            <label for="ratingbar3" title="text"> </label>
                            <input type="radio" id="ratingbar4" name="ratingbar" value="4" />
                            <label for="ratingbar4" title="text"> </label>
                            <input type="radio" id="ratingbar5" name="ratingbar" value="5" />
                            <label for="ratingbar5" title="text"> </label>
                          </div>
                        </div>
                      </div>
                      <img src="{{ url('frontend/index/public/images/img_rectangle_33_1.png') }}" alt="Image" class="image-13" />
                    </div>
                  </div>
                </div>
              </div>
              <div id="slider-pagination" class="slider1-pagination"></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div>
          <div class="rowview3dman">
            <img src="{{ url('frontend/index/public/images/img_view_3d_man_holding_laptop.png') }}" alt="View3dman" class="view3dman_one" />
            <div class="column-3">
              <div class="column_-4">
                <h2 class="ui heading size-headinglg">أبدأ معنا الآن</h2>
                <p class="-6 ui text size-textxs" style="color: white;">
                  انضم إلينا اليوم وحقق أهدافك بسهولة! اختر الخدمة التي تحتاجها، وابدأ رحلتك نحو النجاح
                </p>
              </div>
              <div class="row_-2">
                <a  href="/project/create" class="flex-row-center-center class-_-6">آضف مشروعك</a>
                <a  href="/project/index" class="flex-row-center-center class-_-7">تصفح المشاريع</a>
              </div>
            </div>
          </div>
        </div>
        <footer class="footernlogotwo">
          <div class="rowline_four container-xs">
            <div class="columnline_five">
              <div class="columnnlogotwo">
                <div class="rownlogotwo">
                  <div class="row_seven">
                    <a href="#" class="iconbutton">
                      <img src="{{ url('frontend/index/public/images/img_component_1.svg') }}" />
                    </a>
                    <a href="#" class="iconbutton">
                      <img src="{{ url('frontend/index/public/images/img_component_1_white_a700.svg') }}" />
                    </a>
                    <a href="#" class="iconbutton">
                      <img src="{{ url('frontend/index/public/images/img_component_1_white_a700_32x32.svg') }}" />
                    </a>
                    <a href="#" class="iconbutton">
                      <img src="{{ url('frontend/index/public/images/img_component_1_32x32.svg') }}" />
                    </a>
                    <a href="#" class="iconbutton">
                      <img src="{{ url('frontend/index/public/images/img_component_1_1.svg') }}" />
                    </a>
                  </div>
                  <img src="{{ url('frontend/index/public/images/img_nlogo_2.png') }}" alt="Nlogotwo" class="nlogotwo_three" />
                </div>
                <div class="line_five"></div>
              </div>
              <div class="row_-3">
                <div class="column-16">
                  <h6 class="class-_-8 ui heading size-headingmd">تواصل معنا</h6>
                  <div class="column-22">
                    <p class="ui heading size-textlg">المملكة العربية السعودية</p>
                    <div class="row-4">
                      <p class="ui heading size-textlg">+123 456 7890</p>
                    </div>
                    <p class="ui heading size-textlg">info@leetaxi.com</p>
                  </div>
                </div>
                <div class="column-17">
                  <div class="row-22">
                      <h6 class="-21 ui heading size-headingmd" style="margin: 0 0px 0 165px;">الاقسام</h6>
                    <h6 class="-22 ui heading size-headingmd">الصفحات</h6>
                  </div>
                  <div class="row-20">
                    <div class="row-22">
                      <div class="column_-4">
                        <a href="#"><p class="ui heading size-textlg">كتابة، تحرير، ترجمة ولغات</p></a>
                        <a href="#"><p class="ui heading size-textlg">دعم، مساعدة وادخال بيانات</p></a>
                            <a href="#"><p class="ui heading size-textlg">تدريب وتعليم عن بعد</p></a>
                      </div>
                      <div class="column_-4">
                        <a href="#"><p class="ui heading size-textlg">اعمال وخدمات استشارية</p></a>
                        <a href="#"><p class="ui heading size-textlg">برمجة وتطوير المواقع والتطبيقات</p></a>
                        <a href="#"><p class="ui heading size-textlg">تصميم فيديو وصوتيات</p></a>
                        <a href="#"><p class="ui heading size-textlg">تسويق الكتروني ومبيعات</p></a>
                      </div>
                    </div>
                    <div class="column_-4">
                        <a href="/project/index"><p class="ui heading size-textlg">تصفح المشاريع</p></a>
                      <ul class="column_-4">
                        <li>
                          <a href="/project/create">
                            <p class="ui heading size-textlg">اضف مشرع</p>
                          </a>
                        </li>
                        <!--<li>
                          <a href="#">
                            <p class="ui heading size-textlg">نشر عمل</p>
                          </a>
                        </li>-->
                        <li>
                          <a href="/freelancers" target="_blank" rel="noreferrer">
                            <p class="ui heading size-textlg">المحترفين</p>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="line_five"></div>
              <div class="row_-3">
                <ul class="row-6">
                  <li>
                    <div class="row-23">
                      <a href="/faq" class="class-_-link-1">
                        <p class="class-_-14 ui text size-texts">الاسئلة الشائعة</p>
                      </a>
                      <div class="line_six"></div>
                    </div>
                  </li>
                  <li>
                    <a href="/terms">
                      <p class="class-_-14 ui text size-texts">شروط الاستخدام</p>
                    </a>
                  </li>
                  <li>
                    <div class="rowline_seven">
                      <div class="line_seven"></div>
                      <a href="/privacy" class="class-_-link-1">
                        <p class="class-_-14 ui text size-texts">بيان الخصوصية</p>
                      </a>
                      <div class="line_seven"></div>
                    </div>
                  </li>
                  <li>
                    <div class="rowline_seven">
                      <div class="line_seven"></div>
                      <a href="/guarantee" class="class-_-link-1">
                        <p class="class-_-14 ui text size-texts">ضمان حقوقك</p>
                      </a>
                      <div class="line_seven"></div>
                    </div>
                  </li>

                  <li>
                    <a href="/fees">
                      <p class="class-_-14 ui text size-texts">عمولة المنصة</p>
                    </a>
                  </li>
                </ul>
                <p class="-7 ui text size-texts" style="color: white;">جميع الحقوق محفوظة المحترف © 2024</p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </body>
</html>
