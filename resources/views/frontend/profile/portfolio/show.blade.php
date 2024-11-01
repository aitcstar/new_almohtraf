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
        <div class="container" style="background-color: white;">




                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb" dir="rtl">
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item" data-index="1"><a href="/profile/index">الملف الشخصي</a></li>
                            <li class="breadcrumb-item" data-index="2"> {{ $portfolio->title }}</li>

                        </ol>
                    </div>

                    <div class="col-md-10">
                        <i class="fa fa-user"  style="padding: 0 26px 0 0;"></i> {{ $portfolio->user->firstname . ' ' . $portfolio->user->familyname}}
                        <i class="fa fa-eye" style="padding: 0 26px 0 0;"></i> {{ $portfolio->views }} مشاهدة
                        <i class="fa fa-clock-o" style="padding: 0 26px 0 0;"></i> اضيف منذ {{ $portfolio->timeElapsed($portfolio->created_at) }}
                        <i class="fa fa-clock-o" style="padding: 0 26px 0 0;"></i> انجز في {{ $portfolio->formatDateToArabic($portfolio->completion_date) }}
                        <i class="fa fa-link" style="padding: 0 26px 0 0;"></i> <a href="{{ $portfolio->preview_link }}" target="_blank">رابط المعاينة </a>
                    </div>



                    @if($portfolio->user_id == auth()->id())
                        <div class="col-md-2">
                             <a href="{{ route('profile.editPortfolio', $portfolio->id) }}" style="color: #0099be;"><i class="fa fa-edit" style="padding: 0 26px 0 0;"></i> تعديل </a>
                            <a href="#" data-toggle="modal" data-target="#danger-alert-modal{{ $portfolio->id }}" style="color: red;"><i class="fa fa-trash" style="padding: 0 26px 0 0;"></i> حذف</a>
                        </div>
                    @endif
                </div>
                <hr>

                <div class="form-group">
                    <label for="description">وصف العمل</label>
                    {{  $portfolio->description }}
                </div>
                <hr>

                <div class="form-group">
                    <label for="preview_link">  صور وملفات العمل</label>
                    <div class="row">
                        @foreach($portfolio->files as $file)
                            <div class="col-md-4" style="border: 1px solid #cccccc;text-align: center;">
                                <img src="{{ asset('storage/' . $file->file_path) }}" alt="Thumbnail" style="max-width: 400px;">
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr>

                <div class="text-muted">
                    المهارات المستخدمة
                    @foreach($skills->skills as $skill)
                    <li class="skills__item">
                        <a class="tag">
                            <i class="fa fa-fw fa-tag"></i> <bdi> {{ $skill->name }} </bdi>
                        </a>
                    </li>
                @endforeach
                </div>

                <div id="danger-alert-modal{{ $portfolio->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content modal-filled" style="background-color: #e9e9e9 !important;">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <input type="hidden" value="{{ $portfolio->id }}" name="del_id" id="app_id">
                                    <i class="dripicons-wrong h1 text-black"></i>
                                    <h4 class="mt-2 text-black">هل انت متأكد من الحذف ؟</h4>
                                    <p class="mt-3 text-black">هل تريد حقًا حذف هذه السجلات؟ لا يمكن التراجع عن هذه العملية.</p>
                                    <button type="button"
                                        onclick="location.href='{{ url('/profile/destroy/' . $portfolio->id) }}';"
                                        class="btn btn-light my-2">حذف</button>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

        </div>
    </div>
</category>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>


@endsection
