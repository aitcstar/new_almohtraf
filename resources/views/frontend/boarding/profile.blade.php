@extends('frontend.layouts.master')
@section('title', 'بيانات الحساب')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
       .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar-dropdown {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .avatar-image-wrapper {
            position: relative;
            display: inline-block;
        }

        .avatar-image-wrapper img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd; /* Optional border */
        }

        .camera-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            color: #fff;
            padding: 8px;
            cursor: pointer;
            font-size: 20px;
            transition: background-color 0.3s;
            width: 50px;
        }

        .camera-icon:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 200px;
            z-index: 1;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-menu li {
            /*padding: 10px;*/
            cursor: pointer;
        }

        .dropdown-menu li:hover {
            background-color: #f1f1f1;
        }

        .dropdown-menu .divider {
            height: 1px;
            background-color: #ddd;
            margin: 0;
        }

        .dropdown-menu span {
            display: block;
            text-align: center;
        }
    </style>
<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="background-color: white; padding: 20px 20px;">
        @include('frontend.layouts.message')

        @include('frontend.boarding.partials.stepper', ['currentStep' => 2])


        <form action="{{ route('boarding.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Profile Picture -->

            <!--<div class="form-group">
                <label for="profile_picture">صورة شخصية</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
            </div>-->


            <div class="centered-container" >
                <div class="avatar-dropdown">
                    <div class="avatar-image-wrapper">
                        <img id="profileImage" src="{{ old('profile_picture') ? asset('storage/' . old('profile_picture')) : ($user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('frontend/images/profile.png')) }}" alt="صورة شخصية" style="width: 150px; height: 150px;">

                        <div class="camera-icon" onclick="toggleDropdown()">
                            <i class="fas fa-camera"></i> <!-- أيقونة الكاميرا من FontAwesome -->
                        </div>
                        <input type="file" id="fileInput" name="profile_picture" style="display: none;" accept="image/jpg, image/jpeg, image/png, image/bmp, image/gif">
                    </div>
                    <ul class="dropdown-menu" id="dropdownMenu">
                        <li onclick="document.getElementById('fileInput').click()">
                            <span>رفع صورة جديدة</span>
                        </li>
                        <li class="divider"></li>
                        <li onclick="removeImage()">
                            <span>حذف</span>
                        </li>
                    </ul>
                </div>
            </div>
            <br><br><br><br>
            <div class="row">
            <!-- Country -->
                <div class="form-group col-md-6">
                    <label for="country">الدولة <span class="text-danger">*</span></label>
                    <select name="country_id" id="country" class="form-control select2" required>
                        <option value="" disabled selected>اختر دولتك</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id',$user->country_id ?? '') == $country->id ? 'selected' : '' }}  data-phone-code="{{ $country->phone_code }}">
                                {{ $country->name }} ({{ $country->phone_code }})
                            </option>
                        @endforeach
                    </select>


                </div>

                <!-- Language -->
                <div class="form-group col-md-6">
                    <label for="language">اللغة <span class="text-danger">*</span></label>
                    <select name="language_id" id="language" class="form-control select2" required>
                        <option value="" disabled selected>اختر لغتك</option>
                        @foreach($languages as $language)
                            <option value="{{ $language->id }}" {{ old('language_id',$user->language_id ?? '') == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
            <!-- Gender -->
                <div class="form-group col-md-6">
                    <label for="gender">الجنس <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-control select2" required>
                        <option value="" disabled selected>اختر الجنس</option>
                        <option value="male" {{ old('gender',$user->gender ?? '') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender',$user->gender ?? '') == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>

                <!-- Date of Birth -->
                <div class="form-group col-md-6">
                    <label for="dob">تاريخ الميلاد <span class="text-danger">*</span></label>
                    <input type="date" name="birthday" id="dob" value="{{ old('birthday',$user->birthday ?? '') }}" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <!-- Categories -->
                <div class="form-group col-md-6">
                    <label for="categories">الأقسام <span class="text-danger">*</span></label>
                    <select name="category_id" id="categories" class="form-control select2" required>
                        <option value="" disabled selected>اختر قسماً</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ( old('category_id',$user->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcategories -->
                <div class="form-group col-md-6">
                    <label for="subcategories">الأقسام الفرعية <span class="text-danger">*</span></label>
                    <select id="subcategorySelect" name="subcategory_id"  class="form-control select2" required>
                        <option value="">اختر الفئة الفرعية</option>
                    </select>
                </div>
            </div>

            <!-- Mobile Number -->
            <div class="form-group">
                <label for="mobile">رقم الجوال <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="mobile" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" placeholder="رقم الجوال" required>
            </div>
            <!-- Biography -->

            <div class="form-group">
                <label for="bio">نبذة تعريفية</label>
                <textarea name="biography" id="bio" class="form-control" rows="6" placeholder="اكتب نبذة عنك" required>{{ old('biography', $user->biography ?? '')}}</textarea>
            </div>

            <!-- Skills -->
            <div class="form-group">
                <label for="skills">المهارات <span class="text-danger">*</span></label>
                <select name="skills[]" id="skills" class="form-control select2" multiple required>
                    @foreach($skills as $skill)
                        <option  value="{{ $skill->id }}"  {{ in_array($skill->id, old('skills', $user->skills->pluck('id')->toArray())) ? 'selected' : '' }}> {{ $skill->name }} </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">تحديث</button>
        </form>



        </div>
    </div>
</category>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {


        var selectedCategoryId = $('#categories').val();

        // إذا كان هناك قسم رئيسي محدد عند تحميل الصفحة، قم بتحميل الأقسام الفرعية تلقائيًا
        if (selectedCategoryId) {
            loadSubcategories(selectedCategoryId);
        }

        // استدعاء AJAX لتحميل الأقسام الفرعية بناءً على القسم الرئيسي المحدد
        function loadSubcategories(categoryId) {
            $.ajax({
                url: '/subcategory/' + categoryId,
                type: 'GET',
                success: function(data) {
                    $('#subcategorySelect').empty(); // مسح الأقسام الفرعية السابقة
                    $('#subcategorySelect').append('<option value="">اختر القسم الفرعي</option>');

                    $.each(data, function(index, subcategory) {
                        $('#subcategorySelect').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });

                    // تحديد القسم الفرعي إذا كان هناك قيمة محددة مسبقًا
                    var selectedSubcategoryId = "{{ $user->subcategory_id ?? '' }}";
                    if (selectedSubcategoryId) {
                        $('#subcategorySelect').val(selectedSubcategoryId);
                    }
                },
                error: function() {
                    console.log('Error fetching subcategories');
                }
            });
        }

        // تحميل الأقسام الفرعية عند تغيير القسم الرئيسي
        $('#categories').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                loadSubcategories(categoryId);
            } else {
                $('#subcategorySelect').empty();
                $('#subcategorySelect').append('<option value="">اختر القسم الفرعي</option>');
            }
        });
    });

/*document.addEventListener("DOMContentLoaded", function() {
    const categories = document.getElementById('categories');
    const subcategories = document.getElementById('subcategories');

    // Dynamically load subcategories based on the selected category
    categories.addEventListener('change', function() {
        const categoryId = this.value;

        fetch(`/api/subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategories.innerHTML = ''; // Clear previous options
                data.subcategories.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategories.appendChild(option);
                });
            });
    });
});*/

function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        document.getElementById('fileInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('profileImage').src = '{{ asset("frontend/images/profile.png") }}'; // استبدل بالصورة الافتراضية
            document.getElementById('fileInput').value = ''; // إفراغ مدخل الملف
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.avatar-dropdown')) {
                document.getElementById('dropdownMenu').style.display = 'none';
            }
        });
    </script>

</script>

@endsection
