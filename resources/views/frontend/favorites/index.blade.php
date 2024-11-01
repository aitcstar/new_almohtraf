

@extends('frontend.layouts.master')
@section('title', ' مفضلتي')
@section('content')
<style>
.form-check {
    margin-bottom: 10px; /* تباعد بين خيارات الراديو */
}

.form-check-input {
    margin-right: 10px; /* تباعد بين الراديو والوسم */
}

.form-check-label {
    font-size: 14px; /* حجم الخط */
    color: #333; /* لون النص */
    cursor: pointer; /* تغيير شكل المؤشر عند المرور فوق النص */
}

.form-check-input:checked + .form-check-label {
    font-weight: bold; /* زيادة سمك النص عند التحديد */
    color: #0099be; /* تغيير لون النص عند التحديد */
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
                        <li class="breadcrumb-item" data-index="1"> مفضلتي </li>
                    </ol>
                </div>

               <!-- نموذج الفلترة -->
               <div class="col-md-2">
                    <form method="GET" action="{{ route('favorites.index') }}">
                        <h2>التصنيفات</h2>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="radio" id="all" name="type" value="" class="form-check-input" onchange="this.form.submit()" {{ request('type') === '' ? 'checked' : '' }}>
                                <label style="margin: 0 29px 0 0;" class="form-check-label" for="all">كل الأنواع</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="project" name="type" value="project" class="form-check-input" onchange="this.form.submit()" {{ request('type') === 'project' ? 'checked' : '' }}>
                                <label style="margin: 0 29px 0 0;"  class="form-check-label" for="project">المشاريع</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="user" name="type" value="user" class="form-check-input" onchange="this.form.submit()" {{ request('type') === 'user' ? 'checked' : '' }}>
                                <label style="margin: 0 29px 0 0;"  class="form-check-label" for="user">الحرفية</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="portfolio" name="type" value="portfolio" class="form-check-input" onchange="this.form.submit()" {{ request('type') === 'portfolio' ? 'checked' : '' }}>
                                <label style="margin: 0 29px 0 0;"  class="form-check-label" for="portfolio">أعمال</label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-10">
                    <ul class="list-group">
                        @foreach($favorites as $favorite)
                            <li class="list-group-item">
                                <form action="{{ route('favorites.remove', $favorite->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button style=" left: 150px;" type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @if ($favorite->favoritable_type === 'App\Models\Project')
                                    <a href="{{ route('projects.show', $favorite->favoritable_id) }}">{{ $favorite->favoritable->title }}</a>
                                @elseif ($favorite->favoritable_type === 'App\Models\User')
                                    <a href="{{ route('freelancers.getUser', $favorite->favoritable_id) }}">{{ $favorite->favoritable->firstname . ' ' .$favorite->favoritable->familyname  }}</a>
                                @elseif ($favorite->favoritable_type === 'App\Models\Portfolio')
                                    <a href="{{ route('freelancers.showPortfolio', $favorite->favoritable_id) }}">{{ $favorite->favoritable->title }}</a>
                                @endif

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</category>



@endsection
