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
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 16px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('message') }}
        </div>
        @endif
        <div class="container" style="min-height: 100vh;">




                <div class="row">
                    <div class="col-md-12">
                            <ol class="breadcrumb" dir="rtl">
                                @auth
                                    <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                                @endauth
                                <li class="breadcrumb-item" data-index="1"><a href="/freelancers"> ابحث عن حريفة </a></li>
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
                    <form action="{{ route('favorites.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="favoritable_type" value="App\Models\Portfolio">
                        <input type="hidden" name="favoritable_id" value="{{ $portfolio->id }}">
                        <input type="hidden" name="type" value="portfolio"> <!-- أو "user" أو "portfolio" -->
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-heart"></i></button>
                    </form>
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
        </div>
    </div>
</category>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>


@endsection
