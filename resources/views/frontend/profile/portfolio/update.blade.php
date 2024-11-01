@extends('frontend.layouts.master')
@section('title', 'إضافة معرض الأعمال')
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
        <div class="container">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
            @endif

            <div class="row">

                    <div class="col-md-12">
                        <ol class="breadcrumb" dir="rtl">
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item" data-index="1"><a href="/profile/index">الملف الشخصي</a></li>
                            <li class="breadcrumb-item" data-index="2">تعديل العمل :  {{ $portfolios->first()->title }}</li>

                        </ol>
                    </div>
                 <div class="container panel panel-default">
                    <form  action="{{ route('profile.updatePortfolio') }}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $portfolios->first()->id  }}">

                        <div class="form-group">
                            <label for="title">عنوان العمل</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $portfolios->first()->title ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">وصف العمل</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required> {{ old('description', $portfolios->first()->description ?? '') }}</textarea>
                        </div>



                        <div class="form-group">
                            <label for="preview_link">  الصورة المصغرة</label>
                            <div class="upload-area" id="uploadfile">
                            انقر هنا او اسحب
                            </div>
                            <input type="file" name="thumbnail" id="fileInput"  style="display: none;">
                            <div id="fileList"></div>
                            @if($portfolios->first()->thumbnail ?? '')
                            <div style="border: 1px solid #cccccc;margin: 10px 0px 10px 0;" id="portfolio-{{  $portfolios->first()->id }}">
                                <img src="{{ asset('storage/' . $portfolios->first()->thumbnail) }}" alt="Thumbnail" style="max-width: 100px;">
                                <button  style="float: left;"  type="button" class="delete-button button-container delete-thumbnail-btn" data-id="{{ $portfolios->first()->id }}">حذف</button></div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="preview_link">  صور وملفات العمل</label>
                            <div class="upload-area" id="uploadfilemultiple">
                                انقر هنا او اسحب
                            </div>
                            <input type="file" name="files[]" id="fileInputmultiple"  multiple style="display: none;">
                            <div id="fileListmultiple"></div>
                            @if($portfolios->count() != 0)
                                @foreach($portfolios->first()->files as $file)
                                    <div  style="border: 1px solid #cccccc;margin: 10px 0px 10px 0;" id="portfolio-{{ $file->id }}">
                                        <img src="{{ asset('storage/' . $file->file_path) }}" alt="Thumbnail" style="max-width: 100px;">
                                        <button  style="float: left" type="button" class="delete-button button-container delete-thumbnail-btn-file" data-id="{{ $file->id }}">حذف</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="preview_link">رابط المعاينة</label>
                            <input type="url" class="form-control" id="preview_link" name="preview_link" value="{{ old('preview_link', $portfolios->first()->preview_link ?? '') }}" >
                        </div>

                        <div class="form-group">
                            <label for="completion_date">تاريخ الإنجاز</label>
                            <input type="date" class="form-control" id="completion_date" name="completion_date" value="{{ old('completion_date', $portfolios->first()->completion_date ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="skills">المهارات</label>
                            <select class="form-control select2" id="skills" name="skills[]" multiple >
                                @foreach($skills as $skill)
                                <option value="{{ $skill->id }}"
                                    {{ $portfolios->isNotEmpty() && $portfolios->first()->skills->contains($skill->id) ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach

                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">تعديل العمل</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</category>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript">
 document.addEventListener("DOMContentLoaded", function() {
    const uploadArea = document.getElementById("uploadfile");
    const fileInput = document.getElementById("fileInput");
    const fileList = document.getElementById("fileList");

    const uploadAreamultiple = document.getElementById("uploadfilemultiple");
    const fileInputmultiple = document.getElementById("fileInputmultiple");
    const fileListmultiple = document.getElementById("fileListmultiple");


    // عند النقر على منطقة الرفع، نفتح نافذة اختيار الملفات
    uploadArea.addEventListener("click", function() {
        fileInput.click();
    });


    // عند تغيير المدخل، نعرض الملفات المحددة
    fileInput.addEventListener("change", function(event) {
        const files = event.target.files;
        displayFiles(files);
    });


    // السحب والإفلات
    uploadArea.addEventListener("dragover", function(event) {
        event.preventDefault();
        uploadArea.style.backgroundColor = "#007bff";
        uploadArea.style.color = "#ffffff";
    });

    uploadArea.addEventListener("dragleave", function(event) {
        event.preventDefault();
        uploadArea.style.backgroundColor = "#ffffff";
        uploadArea.style.color = "#333";
    });

    uploadArea.addEventListener("drop", function(event) {
        event.preventDefault();
        uploadArea.style.backgroundColor = "#ffffff";
        uploadArea.style.color = "#333";

        const files = event.dataTransfer.files;
        displayFiles(files);
    });

     // وظيفة لعرض قائمة الملفات المحددة
     function displayFiles(files) {
        fileList.innerHTML = ""; // مسح القائمة السابقة
        for (let i = 0; i < files.length; i++) {
            const fileItem = document.createElement("div");
            fileItem.classList.add("file-item");

            const fileName = document.createElement("span");
            fileName.textContent = files[i].name;

            const deleteButton = document.createElement("button");
            deleteButton.textContent = "حذف";
            deleteButton.classList.add("delete-button");
            deleteButton.onclick = function() {
                fileList.removeChild(fileItem);
            };

            fileItem.appendChild(fileName);
            fileItem.appendChild(deleteButton);
            fileList.appendChild(fileItem);
        }
    }

    /*********************************************************/



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


    $('.delete-thumbnail-btn').click(function () {
            var portfolioId = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');

            alert(portfolioId);
            if (confirm('هل أنت متأكد من حذف الصورة؟')) {
                $.ajax({
                    url: '/portfolios/' + portfolioId + '/delete-thumbnail',
                    type: 'DELETE',
                    data: {
                        "_token": token
                    },
                    success: function (response) {
                        alert(response.message);
                        if (response.success) {
                            $('#portfolio-' + portfolioId).remove();
                        }
                    },
                    error: function (xhr) {
                        alert('حدث خطأ أثناء حذف الصورة.');
                    }
                });
            }
    });


        $('.delete-thumbnail-btn-file').click(function () {
            var portfolioId = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');

            //alert(portfolioId);
            if (confirm('هل أنت متأكد من حذف الصورة؟')) {
                $.ajax({
                    url: '/portfolios/' + portfolioId + '/delete-thumbnail-files',
                    type: 'DELETE',
                    data: {
                        "_token": token
                    },
                    success: function (response) {
                        alert(response.message);
                        if (response.success) {
                            $('#portfolio-' + portfolioId).remove();
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
