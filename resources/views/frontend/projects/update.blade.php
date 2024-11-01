@extends('frontend.layouts.master')
@section('title', 'تعديل مشروع')
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
<category style="direction: rtl;text-align: right;">

<div class="category">
    <div class="container text-right">
        <div class="row">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 16px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('message') }}
            </div>
            @endif

            <div class="col-md-12">
                <ol class="breadcrumb" dir="rtl">
                    <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item" data-index="1"><bdi>تعديل مشروع</bdi></li>
                </ol>
            </div>

            <div class="col-md-12">
                <div class="container panel">

                    <form action="{{ route('updateProject') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$project->id}}">
                            <div class="card-body form-container" dir="rtl">
                                <div class="form-group" >
                                    <p class="help-block text-muted"><label for="project-title" class="control-label" >عنوان المشروع <span class="text-danger">*</span></label></p>
                                    <input name="title" type="text" class="form-control" value="{{$project->title}}" required>
                                    <p class="help-block text-muted" style="font-size: 11px;">أدرج عنوانا موجزا يصف مشروعك بشكل دقيق.</p>
                                </div>

                                <div class="form-group mb-3">
                                    <p class="help-block text-muted"><label for="product-description" class="control-label">وصف المشروع <span class="text-danger">*</span></label></p>
                                    <textarea class="form-control" rows="15" name="description" required>{{$project->description}}</textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-category" class="control-label">الأقسـام <span class="text-danger">*</span></label></p>
                                            <select name="category_id" id="categories" class="form-control select2" required>
                                                <option value="" disabled selected>اختر قسماً</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ ( old('category_id',$project->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-subcategory" class="control-label">الأقسام الفرعية <span class="text-danger">*</span></label></p>
                                            <select id="subcategorySelect" name="subcategory_id"  class="form-control select2" required>
                                                <option value="">اختار</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-budget" class="control-label">الميزانية المتوقعة <span class="text-danger">*</span></label></p>
                                            <select class="form-control select2" name="price_range" required>
                                                <option value="10 - 25" {{ ($project->min_price . ' - ' . $project->max_price)  == '10 - 25' ? 'selected' : '' }}>10 - 25 دولار</option>
                                                <option value="25 - 50" {{ ($project->min_price . ' - ' . $project->max_price) == '25 - 50' ? 'selected' : '' }}>25 - 50 دولار</option>
                                                <option value="50 - 100" {{ ($project->min_price . ' - ' . $project->max_price) == '50 - 100' ? 'selected' : '' }}>50 - 100 دولار</option>
                                                <option value="100 - 200" {{ ($project->min_price . ' - ' . $project->max_price) == '100 - 200' ? 'selected' : '' }}>100 - 200 دولار</option>
                                                <option value="200 - 300" {{ ($project->min_price . ' - ' . $project->max_price) == '200 - 300' ? 'selected' : '' }}>200 - 300 دولار</option>
                                                <option value="300 - 400" {{ ($project->min_price . ' - ' . $project->max_price) == '300 - 400' ? 'selected' : '' }}>300 - 400 دولار</option>
                                                <option value="400 - 500" {{ ($project->min_price . ' - ' . $project->max_price) == '400 - 500' ? 'selected' : '' }}>400 - 500 دولار</option>
                                                <option value="500 - 1000" {{ ($project->min_price . ' - ' . $project->max_price) == '500 - 1000' ? 'selected' : '' }}>500 - 1000 دولار</option>
                                                <option value="1000 - 2000" {{ ($project->min_price . ' - ' . $project->max_price) == '1000 - 2000' ? 'selected' : '' }}>1000 - 2000 دولار</option>
                                                <option value="2000 - 3000" {{ ($project->min_price . ' - ' . $project->max_price) == '2000 - 3000' ? 'selected' : '' }}>2000 - 3000 دولار</option>
                                                <option value="3000 - 4000" {{ ($project->min_price . ' - ' . $project->max_price) == '3000 - 4000' ? 'selected' : '' }}>3000 - 4000 دولار</option>
                                                <option value="4000 - 5000" {{ ($project->min_price . ' - ' . $project->max_price) == '4000 - 5000' ? 'selected' : '' }}>4000 - 5000 دولار</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <p class="help-block text-muted"><label for="project-duration" class="control-label">المدة المتوقعة للتسليم (أيام) <span class="text-danger">*</span></label></p>
                                            <div class="input-group">
                                                <input name="expected_duration" type="number" class="form-control" value="{{$project->expected_duration}}" required >
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
                                        @foreach($project->files as $file)
                                            <div  style="border: 1px solid #cccccc;margin: 10px 0px 10px 0;" id="project-{{ $file->id }}">
                                                <img src="{{ asset('storage/' . $file->media) }}" alt="Thumbnail" style="max-width: 100px;">
                                                <button  style="float: left" type="button" class="delete-button button-container delete-thumbnail-btn-file" data-id="{{ $file->id }}">حذف</button>
                                            </div>
                                        @endforeach
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
                                        تعديل المشروع
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
</category>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

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
                    var selectedSubcategoryId = "{{ $project->subcategory_id ?? '' }}";
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


           $('.delete-thumbnail-btn-file').click(function () {
               var projectId = $(this).data('id');
               var token = $('meta[name="csrf-token"]').attr('content');

               //alert(portfolioId);
               if (confirm('هل أنت متأكد من حذف الصورة؟')) {
                   $.ajax({
                       url: '/projects/' + projectId + '/delete-thumbnail-files',
                       type: 'DELETE',
                       data: {
                           "_token": token
                       },
                       success: function (response) {
                           alert(response.message);
                           if (response.success) {
                               $('#project-' + projectId).remove();
                           }
                       },
                       error: function (xhr) {
                           alert('حدث خطأ أثناء حذف الصورة.');
                       }
                   });
               }
           });




   });

   </script>
@endsection
