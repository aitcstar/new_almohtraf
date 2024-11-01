@extends('layouts.vertical', ['title' => 'المستخدمين', 'mode' => 'rtl'])

@section('css')
<!-- Plugins css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">

            <h4 class="page-title">قائمه المستخدمين</h4>
        </div>
    </div>
</div>
@if (session()->has('message'))
<div class="col-sm-6">
    <div class="alertPart">
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('message') }}
        </div>
    </div>
</div>
@endif

<!--<div class="button-list">
    <a class="btn btn-success btn-rounded waves-effect waves-light" href="{{route('usersCreate',['admin','users' ,'create']) }}">
        اضف مستخدم </a>
</div><br>-->

<div class="card">
    <div class="card-body">
        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        الاسم
                    </th>
                    <th>
                        البريد الالكتروني
                    </th>
                    <th>
                        دولار امريكي
                    </th>
                    <th>
                         ريال سعودي
                    </th>
                    <th>
                        ريال يمني
                    </th>
                    <th>
                       مديون
                    </th>
                    <th>
                        الحد الاقصي للسحب بالسالب
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{$user->id}}
                    </td>
                    <td>
                        <a  href="{{route('usersShow',['admin','users' ,'show',$user->id] )}}">
                            <b>{{$user->fullname}}</b>
                        </a>
                    </td>
                    <td>
                        {{$user->email}}
                    </td>
                    <td>
                        {{$user->balance($user->id, 1) ?? 0 }}
                    </td>
                    <td>
                        {{$user->balance($user->id, 2) ?? 0 }}
                    </td>
                    <td>
                        {{$user->balance($user->id, 3) ?? 0 }}
                    </td>
                    <td>
                        @if ($user->minus == 0)
                        <span class="badge bg-soft-success text-success">لا</span>
                        @else
                        <span class="badge bg-soft-danger text-danger">نعم</span>
                        @endif
                    </td>
                    <td style="direction: ltr;">
                        @if ($user->minus == 1)
                        <span class="badge bg-soft-danger text-danger"> {{ $user->minusprice }}</span>
                        @endif
                    </td>
                    <td>
                        <a class="action-icon" href="{{route('usersShow',['admin','users' ,'show',$user->id] )}}">
                            <i class="mdi mdi-eye"></i>
                        </a>
                        <a class="action-icon" href="#" data-toggle="modal" data-target="#danger-alert-modal{{$user->id}}">
                            <i class="mdi mdi-delete"></i>
                        </a>
                       {{-- <a class="btn btn-primary" href="{{route('balanceEdit',['admin','users' ,'balance',$user->id] )}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            اضافه رصيد
                        </a>
                        @if($user->balance == 0)
                        <a class="btn btn-warning" href="{{route('minusbalanceEdit',['admin','users' ,'minusbalance',$user->id] )}}">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                            سحب بالسالب
                        </a
                        @endif--}}
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @foreach($users as $user)
        <!-- Danger Alert Modal -->
        <div id="danger-alert-modal{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content modal-filled bg-danger">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <input type="hidden" value="{{$user->id}}" name="del_id" id="app_id">
                            <i class="dripicons-wrong h1 text-white"></i>
                            <h4 class="mt-2 text-white">هل انت متأكد من الحذف ؟</h4>
                            <p class="mt-3 text-white">هل تريد حقًا حذف هذه السجلات؟ لا يمكن التراجع عن هذه العملية.</p>
                            <button type="button" onclick="location.href='{{ url('/dashboard/admin/users/destroy/users/destroy/'.$user->id) }}';" class="btn btn-light my-2">تاكيد الحذف</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        @endforeach
    </div>


</div>



@endsection
@section('script')
<!-- Plugins js-->
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>

<!-- Page js-->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection
