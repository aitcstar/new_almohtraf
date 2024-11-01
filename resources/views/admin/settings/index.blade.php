@extends('layouts.vertical', ['title' => 'خصائص الموقع',  'mode' => 'rtl'])
@section('content')

<div class="card">
    <div class="card-body">
    <form action="{{ route('settings.update',['admin'])  }}"  method="POST" enctype="multipart/form-data" id="create">
            @csrf

            <div class="form-group">
                <label class="required" for="title">اسم الموقع</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="title" value="{{ $title }}" placeholder="اسم الموقع">
            </div>
            <div class="form-group">
                <label class="required" for="title">تفاصيل لمحركات البحث </label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="description" value="{{ $description }}">
            </div>
            <div class="form-group">
                <label class="required" for="title">كلامات دلاليه لمحركات البحث</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="keywords" value="{{ $keywords }}">
            </div>
            <div class="form-group">
                <label class="required" for="title">رقم الجوال</label>
                <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ $phone }}">
            </div>
             <!--<div class="form-group">
                <label class="required" for="title">Phone Other</label>
                <input type="text" class="form-control {{ $errors->has('phoneother') ? 'is-invalid' : '' }}" name="phoneother" value="{{ $phoneother }}">
            </div>-->
             <div class="form-group">
                <label class="required" for="title">وتساب</label>
                <input type="text" class="form-control {{ $errors->has('Whatsapp') ? 'is-invalid' : '' }}" name="whatsapp" value="{{ $whatsapp }}">
            </div>
            <div class="form-group">
                <label class="required" for="title">البريد الالكتروني</label>
                <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ $email }}">
            </div>
            <div class="form-group">
                <label class="required" for="title">العنوان</label>
                <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" value="{{ $address }}">
            </div>
            <div class="form-group">
                <label class="required" for="title">وصف مختصر</label>
                <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="shorabout" value="{{ $shorabout }}">
            </div>


            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
