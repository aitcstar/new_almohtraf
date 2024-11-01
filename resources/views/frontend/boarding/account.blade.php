@extends('frontend.layouts.master')
@section('title', 'بيانات الحساب')
@section('content')

<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="min-height: 80vh; background-color: white; padding: 20px 20px;">

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
            @endif





    <div class="container">

        @include('frontend.boarding.partials.stepper', ['currentStep' => 1])
        <form id="accountTypesForm" method="POST" action="{{ route('boarding.update-account-types') }}">
            @csrf
            <!-- مثال على نوعين من الحسابات -->
            <div class="account-grid-container" data-action="changeAccountType" data-value="1">
                <div class="account-grid">
                    <img class="svg" src="https://mostaql.hsoubcdn.com/public/assets/images/icons/employer.svg" alt="">
                    <label style="color: #059d9d">صاحب مشاريع</label>
                    <p>أبحث عن محترفين لتنفيذ مشاريعي</p>
                    <input type="checkbox" name="account_types" value="1" id="account_type_employer" autocomplete="off" class="hidden">
                </div>
            </div>

            <div class="account-grid-container" data-action="changeAccountType" data-value="2">
                <div class="account-grid">
                    <img class="svg" src="https://mostaql.hsoubcdn.com/public/assets/images/icons/freelancer.svg" alt="">
                    <label style="color: #059d9d">حريف</label>
                    <p>أبحث عن مشاريع لتنفيذها</p>
                    <input type="checkbox" name="account_types" value="2" id="account_type_freelancer" autocomplete="off" class="hidden">
                </div>
            </div>

            <!-- أضف المزيد من أنواع الحسابات هنا -->
            <br><br><br><br>
            <button type="submit" class="btn btn-lg btn-info">حفظ التعديلات</button>
        </form>
    </div>





        </div>
    </div>
</category>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            const steps = document.querySelectorAll('.stepper .step');
            const currentUrl = window.location.href;

            steps.forEach(step => {
                const link = step.querySelector('a');
                if (currentUrl.includes(link.getAttribute('href'))) {
                    steps.forEach(s => s.classList.remove('active'));
                    step.classList.add('active');
                }
            });
        });




        /*document.addEventListener('DOMContentLoaded', function() {
            const gridItems = document.querySelectorAll('.account-grid-container');
            const form = document.getElementById('accountTypesForm');

            // استبدال هذه القيم بالقيم الفعلية التي تم الحصول عليها من الخادم
            const userAccountTypes = @json($userAccountTypes); // قيمة PHP إلى JavaScript

            // تحديد مربعات الاختيار تلقائيًا بناءً على القيم الراجعة
            gridItems.forEach(item => {
                const value = item.getAttribute('data-value');
                const input = form.querySelector(`input[value="${value}"]`);

                if (userAccountTypes.includes(parseInt(value))) {
                    input.checked = true;
                    item.classList.add('active');
                } else {
                    input.checked = false;
                    item.classList.remove('active');
                }
            });

            // إضافة حدث النقر لتحديث حالة مربع الاختيار
            gridItems.forEach(item => {
                item.addEventListener('click', function() {
                    item.classList.toggle('active');

                    // تحديث حالة الـ checkbox بناءً على النشاط
                    const input = form.querySelector(`input[value="${item.getAttribute('data-value')}"]`);
                    input.checked = item.classList.contains('active');
                });
            });
        });*/


        document.addEventListener('DOMContentLoaded', function() {
    const gridItems = document.querySelectorAll('.account-grid-container');
    const form = document.getElementById('accountTypesForm');

    // استبدال هذه القيم بالقيم الفعلية التي تم الحصول عليها من الخادم
    const userAccountTypes = @json($userAccountTypes); // قيمة PHP إلى JavaScript

    // تحديد مربعات الاختيار تلقائيًا بناءً على القيم الراجعة
    gridItems.forEach(item => {
        const value = item.getAttribute('data-value');
        const input = form.querySelector(`input[value="${value}"]`);

        if (userAccountTypes.includes(parseInt(value))) {
            input.checked = true;
            item.classList.add('active');
        } else {
            input.checked = false;
            item.classList.remove('active');
        }
    });

    // إضافة حدث النقر لتحديث حالة مربع الاختيار
    gridItems.forEach(item => {
        item.addEventListener('click', function() {
            // إزالة "active" من جميع العناصر الأخرى
            gridItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    const input = form.querySelector(`input[value="${otherItem.getAttribute('data-value')}"]`);
                    input.checked = false;
                }
            });

            // إضافة "active" للعنصر الذي تم النقر عليه
            item.classList.add('active');
            const input = form.querySelector(`input[value="${item.getAttribute('data-value')}"]`);
            input.checked = true;
        });
    });
});








</script>


@endsection
