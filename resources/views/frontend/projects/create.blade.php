@extends('frontend.layouts.master')
@section('title', 'اضافه مشروع جديد')
@section('content')
<!-- Dropzone CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style>


.upload-area {
    width: 100%;
    height: 200px;
    border: 2px dashed #cccccc;
    border-radius: 10px;
    background-color: #ffffff;
    color: #333;
    line-height: 200px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
    text-align: center;
}

.upload-area:hover {
    background-color: #ffffff;
    color: #333;
}

#fileList {
    margin-top: 20px;
    text-align: left;
}

.file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 10px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.file-item span {
    flex-grow: 1;
}

.delete-button {
    background-color: #ff4c4c;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
}

.delete-button:hover {
    background-color: #ff1c1c;
}

.button-container {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin: 12px 0px 0px 9px;
    }
</style>
<div class="category">
    <div class="container text-right">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb" dir="rtl">
                    @auth
                        <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                    @endauth
                    <li class="breadcrumb-item" data-index="1"><bdi>أضف مشروع</bdi></li>
                </ol>
            </div>

            <div class="col-md-12">
                <div class="container panel">

                    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body form-container" dir="rtl">
                                <div class="form-group" >
                                    <p class="help-block text-muted"><label for="project-title" class="control-label" >عنوان المشروع <span class="text-danger">*</span></label></p>
                                    <input name="title" type="text" class="form-control" value="{{ old('title', isset($project) ? $project->title : '') }}" required>
                                    <p class="help-block text-muted" style="font-size: 11px;">أدرج عنوانا موجزا يصف مشروعك بشكل دقيق.</p>
                                </div>

                                <div class="form-group mb-3">
                                    <p class="help-block text-muted"><label for="product-description" class="control-label">وصف المشروع <span class="text-danger">*</span></label></p>
                                    <textarea class="form-control" rows="10" name="description" required>{{ old('description', isset($project) ? $project->description : '') }}</textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-category" class="control-label">الأقسـام <span class="text-danger">*</span></label></p>
                                            <select class="form-control select2" name="category_id" id="category" required>
                                                <option value="" disabled selected>اختار</option>

                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ isset($project) && $project->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-subcategory" class="control-label">الأقسام الفرعية <span class="text-danger">*</span></label></p>
                                            <select class="form-control select2" name="subcategory_id" id="subcategory" required>
                                                <option value="" disabled selected>اختار</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-budget" class="control-label">الميزانية المتوقعة <span class="text-danger">*</span></label></p>
                                            <select class="form-control select2" name="price_range" required>
                                                <option value="10 - 25">10 - 25 دولار</option>
                                                <option value="25 - 50">25 - 50 دولار</option>
                                                <option value="50 - 100">50 - 100 دولار</option>
                                                <option value="100 - 200">100 - 200 دولار</option>
                                                <option value="200 - 300">200 - 300 دولار</option>
                                                <option value="300 - 400">300 - 400 دولار</option>
                                                <option value="400 - 500">400 - 500 دولار</option>
                                                <option value="500 - 1000">500 - 1000 دولار</option>
                                                <option value="1000 - 2000">1000 - 2000 دولار</option>
                                                <option value="2000 - 3000">2000 - 3000 دولار</option>
                                                <option value="3000 - 4000">3000 - 4000 دولار</option>
                                                <option value="4000 - 5000">4000 - 5000 دولار</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-duration" class="control-label">المدة المتوقعة للتسليم (أيام) <span class="text-danger">*</span></label></p>
                                            <div class="input-group">
                                                <input name="expected_duration" type="number" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group">
                                    <p class="help-block text-muted"><label for="files" class="control-label">ملفات توضيحية</label></p>
                                    <input name="media[]" type="file" class="form-control" multiple >
                                </div>-->

                                <div class="form-group">
                                    <label for="preview_link">ملفات توضيحية</label>
                                    <div class="upload-area" id="uploadfilemultiple">
                                        انقر هنا او اسحب
                                    </div>
                                    <input type="file" name="files[]" id="fileInputmultiple"  multiple style="display: none;">
                                    <div id="fileListmultiple"></div>
                                </div>


                            </div> <!-- end card-body -->
                        <!--
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title text-right" data-toggle="collapse" data-target="#project-questions">
                                    إعدادات متقدمة
                                    <button type="button" class="btn btn-collapse btn-sm">
                                        <span class="fa fa-chevron-up"></span>
                                    </button>
                                </h2>
                            </div>

                            <div id="project-questions" class="collapse in" dir="rtl">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="feature_questions">أسئلة المشروع</label>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 dynamic__list-container">
                                        <div id="input-questions-rows" class="dynamic__list">
                                            <div class="dynamic__list-item">
                                                <div class="form-group">
                                                    <input type="text" name="questions[1722978738309][title]" class="form-control dynamic-row" placeholder="سؤال مثل: ما اللغات البرمجية التي تجيدها؟" autocomplete="off">
                                                    <div class="dynamic__list-options">
                                                        <a class="remove_button" data-container="#input-questions-rows" data-action="removeRow">حذف</a>
                                                        <label>
                                                            <input type="checkbox" value="1" name="questions[1722978738309][required]" checked>
                                                            سؤال إجباري
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="help-block text-muted">أضف الأسئلة التي تود أن يجيب عنها المستقلين أثناء تقديم عروضهم</p>
                                        <button data-action="addNewRow" data-max="5" type="button" class="btn btn-sm btn-default" data-container="#input-questions-rows" data-template-id="template#question_row">إضافة سؤال جديد</button>

                                        <div class="invalid-rows-count text-danger help-block" style="display: none">
                                            لا يمكنك إضافة أكثر من 5 أسئلة
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> --> <!-- end panel -->

                        <div class="btn-group page_action_buttons" style="margin-top: 70px;">
                            <div class="col-md-12">
                                <div class="pull-right mrg--et">
                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-info">
                                        انشر الآن
                                    </button>
                                </div>

                               <!-- <div class="pull-right" style="padding: 0px 15px;">
                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-default">
                                        حفظ كمسودة
                                    </button>
                                </div>-->
                            </div>
                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script>
    $(document).ready(function() {
        const baseURL = window.location.origin;

        $('#category').on('change', function() {

        const id = $(this).val(); // استخدام $(this).val() بدلاً من document.getElementById

        const url = `${baseURL}/subcategory/${id}`; // استخدام القوالب النصية

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                console.log(data);
                $("#subcategory").empty(); // استخدم empty() بدلاً من html('')

                // تحقق من أن البيانات ليست فارغة
                if (data.length > 0) {
                    data.forEach(item => {
                        $("#subcategory").append(`<option value="${item.id}">${item.name}</option>`);
                    });
                } else {
                    $("#subcategory").append('<option disabled>لا توجد خيارات</option>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(`Error: ${textStatus}, ${errorThrown}`);
                $("#subcategory").html('<option disabled>حدث خطأ في تحميل البيانات</option>');
            }
        });
    });

});

</script>


<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
       const uploadAreamultiple = document.getElementById("uploadfilemultiple");
       const fileInputmultiple = document.getElementById("fileInputmultiple");
       const fileListmultiple = document.getElementById("fileListmultiple");

       // عند النقر على منطقة الرفع، نفتح نافذة اختيار الملفات
       uploadAreamultiple.addEventListener("click", function() {
           fileInputmultiple.click();

       });

       // عند تغيير المدخل، نعرض الملفات المحددة
       fileInputmultiple.addEventListener("change", function(event) {
           const Mfiles = event.target.files;
           displayFilesMult(Mfiles);
       });


       // السحب والإفلات
       uploadAreamultiple.addEventListener("dragover", function(event) {
           event.preventDefault();
           uploadAreamultiple.style.backgroundColor = "#007bff";
           uploadAreamultiple.style.color = "#ffffff";
       });

       uploadAreamultiple.addEventListener("dragleave", function(event) {
           event.preventDefault();
           uploadAreamultiple.style.backgroundColor = "#ffffff";
           uploadAreamultiple.style.color = "#333";
       });

       uploadAreamultiple.addEventListener("drop", function(event) {
           event.preventDefault();
           uploadAreamultiple.style.backgroundColor = "#ffffff";
           uploadAreamultiple.style.color = "#333";

           const Mfiles = event.dataTransfer.files;
           displayFilesMult(Mfiles);
       });

        // وظيفة لعرض قائمة الملفات المحددة
        function displayFilesMult(Mfiles) {
           fileListmultiple.innerHTML = ""; // مسح القائمة السابقة
           for (let i = 0; i < Mfiles.length; i++) {
               const MfileItem = document.createElement("div");
               MfileItem.classList.add("file-item");

               const MfileName = document.createElement("span");
               MfileName.textContent = Mfiles[i].name;

               const MdeleteButton = document.createElement("button");
               MdeleteButton.textContent = "حذف";
               MdeleteButton.classList.add("delete-button");
               MdeleteButton.onclick = function() {
                   fileListmultiple.removeChild(MfileItem);
               };

               MfileItem.appendChild(MfileName);
               MfileItem.appendChild(MdeleteButton);
               fileListmultiple.appendChild(MfileItem);
           }
       }





   });

   </script>
@endsection
