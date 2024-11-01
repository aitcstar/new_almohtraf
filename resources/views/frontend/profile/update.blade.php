@extends('frontend.layouts.master')
@section('title', 'الصفحه الشخصيه')
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
            padding: 1px;
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
        <div class="container">

            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 20px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('message') }}
            </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item" data-index="1"><a href="/profile/index">الملف الشخصي</a></li>
                        <li class="breadcrumb-item" data-index="2"> تعديل إعدادات الحساب</li>

                    </ol>
                </div>

                    <div class="col-md-5">
                        <div class="container panel panel-default">


                                <div class="form-group avatar-section" style="text-align: center;">
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

                                <div class="form-group">
                                    <label>الاسم الأول <em class="text-danger">*</em></label>
                                    <input type="text" name="firstname" class="form-control" placeholder="أكتب اسمك باللغة العربية" value="{{ $user->firstname }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>اسم العائلة <em class="text-danger">*</em></label>
                                    <input type="text" name="familyname" class="form-control" placeholder="أكتب اسم العائلة هنا باللغة العربية" value="{{  $user->familyname }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>الدولة <em class="text-danger">*</em></label>
                                    <select name="country_id" id="country" class="form-control select2" required>
                                        <option value="" disabled selected>اختر دولتك</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id',$user->country_id ?? '') == $country->id ? 'selected' : '' }}  data-phone-code="{{ $country->phone_code }}">
                                                {{ $country->name }} ({{ $country->phone_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>اللغة <em class="text-danger">*</em></label>
                                    <select name="language_id" id="language" class="form-control select2" required>
                                        <option value="" disabled selected>اختر لغتك</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ old('language_id',$user->language_id ?? '') == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>الجنس <em class="text-danger">*</em></label>
                                    <select name="gender" id="gender" class="form-control select2" required>
                                        <option value="" disabled selected>اختر الجنس</option>
                                        <option value="male" {{ old('gender',$user->gender ?? '') == 'male' ? 'selected' : '' }}>ذكر</option>
                                        <option value="female" {{ old('gender',$user->gender ?? '') == 'female' ? 'selected' : '' }}>أنثى</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>رقم الجوال <em class="text-danger">*</em></label>
                                    <input type="text" name="phone" class="form-control" placeholder="أدخل رقم الجوال" value="{{ old('phone',$user->phone ) }}">
                                </div>
                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button> <br><br>

                        </div>
                    </div>


                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="carda__body carda__body_profile">
                                    <div id="profile-fields">
                                        <div class="form-group">
                                            <label for="account_type">نوع الحساب <em class="text-danger">*</em></label>
                                            <div class="checkbox">
                                                <label class="list-group-item">
                                                    <input type="checkbox" name="account_types[]" @if(in_array(1, session('account_type_ids'))) checked @endif  value="1"> صاحب مشاريع
                                                    <small class="text-muted">(أبحث عن محترفين لتنفيذ مشاريعي)</small>
                                                </label>

                                                <label class="list-group-item">
                                                    <input type="checkbox" name="account_types[]"  @if(in_array(2, session('account_type_ids'))) checked @endif  value="2"> حريف
                                                    <small class="text-muted">(أبحث عن مشاريع لتنفيذها)</small>
                                                </label>
                                                @if(in_array(2, session('account_type_ids')))
                                                <label class="list-group-item" id="freelancer_availability">
                                                    <input id="freelancer_available_checkbox" name="freelancer_availability" type="checkbox" value="{{ $user->freelancer_availability }}" @if($user->freelancer_availability == 1) checked @endif >
                                                    <input id="freelancer_available_hidden" name="freelancer_availability_hidden" type="hidden" value="{{ $user->freelancer_availability }}"> متاح للتوظيف
                                                    <small class="text-muted">(إزالة هذه الإشارة سيخفي حسابك بشكل مؤقت من نتائج البحث)</small>
                                                </label>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profile__speciality_id">التخصص <em class="text-danger">*</em></label>
                                                    <select name="category_id" id="categories" class="form-control select2" required>
                                                        <option value="" disabled selected>اختر قسماً</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ ( old('category_id',$user->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">اختر مجال عملك</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="subcategories"> المسمي الوظيفي <span class="text-danger">*</span></label>
                                                    <select id="subcategorySelect" name="subcategory_id"  class="form-control select2" required>
                                                        <option value="">اختر المسمي الوظيفي</option>
                                                    </select>
                                                    <small class="text-muted">أدخل مسمى وظيفي مثل</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="profile__bio">النبذة التعريفية</label>
                                            <textarea id="profile__bio" class="form-control" rows="5" name="biography">{{ old('biography', $user->biography ?? '')}}</textarea>
                                            <small class="text-muted">أضف سيرة ذاتية تعرف عن نفسك وتعليمك وخبراتك ومهاراتك</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="skills">المهارات</label>
                                            <select name="skills[]" id="skills" class="form-control select2" multiple required>
                                                @foreach($skills as $skill)
                                                    <option  value="{{ $skill->id }}"  {{ in_array($skill->id, old('skills', $user->skills->pluck('id')->toArray())) ? 'selected' : '' }}> {{ $skill->name }} </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">أضف مهاراتك وخبراتك وتخصصاتك</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="video__url">الفيديو التعريفي</label>
                                            <input class="form-control"  name="video" type="text" value="{{ $user->video ?? ''}}">
                                            <small class="text-muted">رابط لفيديو لك تعرف به عن نفسك من YouTube أو Vimeo</small>
                                        </div>


                                    </div>
                            </div>
                        </div>
                    </div>

            </div>
        </form>
        </div>
    </div>
</category>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        /*$('#categories').on('change', function() {
            var categoryId = $(this).val();

            // قم بمسح الأقسام الفرعية السابقة
            $('#subcategorySelect').empty();
            $('#subcategorySelect').append('<option value="">اختر القسم الفرعي</option>');

            if(categoryId) {
                $.ajax({
                    url: '/subcategory/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategorySelect').empty();
                        $('#subcategorySelect').append('<option value="">اختر الفئة الفرعية</option>');
                        $.each(data, function(key, value) {
                            $('#subcategorySelect').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#subcategorySelect').empty();
                $('#subcategorySelect').append('<option value="">اختر الفئة الفرعية</option>');
            }
        });*/


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


        document.getElementById('freelancer_available_checkbox').addEventListener('change', function() {
    // إذا تم التحقق من checkbox
    if (this.checked) {
        document.getElementById('freelancer_available_hidden').value = "1"; // المتاح للتوظيف
    } else {
        document.getElementById('freelancer_available_hidden').value = "0"; // غير متاح للتوظيف
    }
});


</script>

@endsection
