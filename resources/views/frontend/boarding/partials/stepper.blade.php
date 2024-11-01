  <!-- Start Page-title -->
  <div class="page-title">
    <div class="container">
        <h1 class="title">مرحبا <br> {{ Auth::user()->firstname .' '. Auth::user()->familyname}}</h1>
    </div>
</div> <!-- End Page-title -->

<!-- Stepper -->
<div class="stepper">
    <div class="step {{ $currentStep === 1 ? 'active' : '' }}">
        <a href="{{ route('boarding.account') }}">
            <div class="step-circle">1</div>
            <div class="step-label">بيانات الحساب</div>
        </a>
    </div>
    <div class="step {{ $currentStep === 2 ? 'active' : '' }}">
        <a href="{{ route('boarding.profile') }}">
            <div class="step-circle">2</div>
            <div class="step-label">الملف الشخصي</div>
        </a>
    </div>
    @if(session('account_type_ids') && in_array(2, session('account_type_ids')))
        <div class="step {{ $currentStep === 3 ? 'active' : '' }}">
            <a href="{{ route('boarding.portfolio') }}">
                <div class="step-circle">3</div>
                <div class="step-label"> معرض الأعمال</div>
            </a>
        </div>
        <!--<div class="step {{ $currentStep === 4 ? 'active' : '' }}">
            <a href="#">
                <div class="step-circle">4</div>
                <div class="step-label">اختبار القبول</div>
            </a>
        </div>-->
    @endif

    @if(session('account_type_ids') == null)
    <div class="step {{ $currentStep === 3 ? 'active' : '' }}">
        <a href="{{ route('boarding.portfolio') }}">
            <div class="step-circle">3</div>
            <div class="step-label"> معرض الأعمال</div>
        </a>
    </div>
    <!--<div class="step {{ $currentStep === 4 ? 'active' : '' }}">
        <a href="#">
            <div class="step-circle">4</div>
            <div class="step-label">اختبار القبول</div>
        </a>
    </div>-->
@endif

    @if(session('account_type_ids') && in_array(1, session('account_type_ids')))
        <div class="step {{ $currentStep === 3 ? 'active' : '' }}">
            <a href="{{ route('boarding.briefly') }}">
                <div class="step-circle">3</div>
                <div class="step-label">أخبرنا عن نفسك</div>
            </a>
        </div>
    @endif

</div>
