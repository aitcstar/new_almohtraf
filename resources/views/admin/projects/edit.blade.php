@extends('layouts.vertical', ['title' => 'تعديل  المشروع', 'mode' => 'rtl'])
@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/dashboard/admin/projects/index">تعديل المشروع</a></li>
                            <li class="breadcrumb-item active">تعديل المشروع</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تعديل / المشروع </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('adminProjects.update',['admin'])  }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $project->id }}">

            <table class="table table-bordered table-striped" style="direction: rtl;text-align: right;">
                <tbody>
                    <tr>
                        <th style="width: 10%;">
                           عنوان المشروع
                        </th>
                        <td>
                            <b style="color:blue">{{ $project->title }}</b>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 10%;">
                            وصف المشروع
                        </th>
                        <td>
                         <b>{!! $project->description !!}</b>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 10%;">
                            القسم
                        </th>
                        <td>
                            {{ $project->category?->name }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 10%;">
                            القسم الفرعي
                        </th>
                        <td>
                            {{ $project->subCategory?->name }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 10%;">
                          صاحب المشروع
                        </th>
                        <td>
                            {{ $project->ownerProject?->firstname . ' ' .   $project->ownerProject?->familyname }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 10%;">
                            الميزانية المتوقعة
                        </th>
                        <td>
                            {{ $project->budget }}
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 10%;">
                            المدة المتوقعة للتسليم (أيام)
                        </th>
                        <td style="direction: ltr;">
                            {{ $project->expected_duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            تاريج الانشاء
                        </th>
                        <td>
                            {{ $project->created_at }} <br> منذ : {{$project->timeElapsed($project->created_at)}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           الحاله
                        </th>
                        <td>
                            <select class="form-control select2" name="order_status_id" id="orderstatus" >
                                @foreach ($orderstatus as $status )
                                    <option value="{{ $status->id }}"{{($project->projectStatus?->id == $status->id)?' selected':''}}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            ملفات توضيحية
                        </th>
                        <td>
                            @foreach($project->files as $key => $file)
                                <li>
                                    <a href="{{ Storage::url($file->media) }}" target="_blank">مرفق رقم {{ $key+1 }}</a>
                                </li>
                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>


            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    تعديل
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>

    <!-- Page js-->
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/pages/add-product.init.js')}}"></script>
@endsection
