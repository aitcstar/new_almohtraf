@extends('layouts.vertical', ['title' => 'تفاصيل الحساب', 'mode' => 'rtl'])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('tab_title', 'حساب المستخدم')
@section('content')
    <div class="row">
        <div class="col-12">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box" style="direction: rtl;">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/dashboard/admin/users/index/users">المستخدمين</a></li>
                                <li class="breadcrumb-item active">معلومات حساب المستخدم</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card ">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            
           
                <div class="card-body" style="direction: rtl;">
                    <a style="float: left;" class="btn btn-sm btn-danger" href="{{ route('changepassword', ['admin', 'users', 'changepassword', $user->id]) }}">
                        تغيير كلمة المرور
                    </a><br><br>

                                        <label style="text-align: center"><b> معلومات الحساب </b></label>
                    <table class="table table-bordered table-striped" style="direction: rtl;text-align: right;">
                        <tbody>
                            <tr>
                                <th style="width: 10%;">
                                    اسم المستخدم
                                </th>
                                <td>
                                    <b style="color:blue">{{ $user->fullname }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    المجموعات
                                </th>
                                <td>
                                   
                                    <form method="POST" action="{{ route('ChangeGroup',['admin','users' ,'changegroup', $user->id])  }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="group_id" required>
                                               @foreach ($groups as $group)
                                                    <option value="{{$group->id}}"{{($user->group->id == $group->id)?' selected':''}} >{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-danger" type="submit">
                                                تغيير المجموعه
                                            </button>
                                        </div>
                                    </form>


                                </td>
                            </tr>

                            <tr>
                                <th style="width: 10%;">
                                    البريد الالكتروني
                                </th>
                                <td>
                                    {{ $user->email }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    دولار امريكي
                                </th>
                                <td>
                                    {{$user->balance($user->id, 1) ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    ريال سعودي
                                </th>
                                <td>
                                    {{$user->balance($user->id, 2) ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                   ريال يمني
                                </th>
                                <td>
                                    {{$user->balance($user->id, 3) ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    مديون
                                </th>
                                <td>
                                    @if ($user->minus == 0)
                                    <span class="badge bg-soft-success text-success">لا</span>
                                    @else
                                    <span class="badge bg-soft-danger text-danger">نعم</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    الحد الاقصي للسحب بالسالب
                                </th>
                                <td style="direction: ltr;">
                                    @if ($user->minus == 1)
                                    <span class="badge bg-soft-danger text-danger">  {{ $user->minusprice }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    تاريج الانشاء
                                </th>
                                <td>
                                    {{ $user->created_at }}
                                </td>
                            </tr>

                            <tr>
                                <th>

                                </th>
                                <td>
                                    <a class="btn btn-primary"
                                        href="{{ route('balanceEdit', ['admin', 'users', 'balance', $user->id]) }}">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        اضافه رصيد
                                    </a>
                                </td>
                            </tr>


                            <tr>
                                <th>

                                </th>
                                <td>
                                    @if ($user->balance == 0)
                                        <a class="btn btn-warning"
                                            href="{{ route('minusbalanceEdit', ['admin', 'users', 'minusbalance', $user->id]) }}">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                            سحب بالسالب
                                        </a @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <br><hr><br>
                    
                    <label style="text-align: center">طلباتي</label>
                    <table id="datatable-buttons" name="example"class="table table-striped dt-responsive nowrap w-100"  style="direction: rtl;text-align: right;">
                        <thead>
                            <th>#</th>
                            <th>اسم القسم</th>
                            <th> اسم المنتج</th>
                            <th>معرف المستخدم</th>
                            <th>السعر</th>
                            <th>الكميه</th>
                            <th> العدد</th>
                            <th>اجمالي السعر</th>
                            <th> الحاله</th>
                            <th>التاريخ</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>
                                    {{ $order->id }}
                                </td>
                                <td>
                                    <b>{{ $order->category->name }}</b>
                                </td>
                                <td>
                                    <a href="{{route('ordersShow',['admin','orders' ,'show',$order->id] )}}" class="paypal-btn">
                                        <b>{{ $order->service->name }}</b>
                                    </a>
                                </td>
                               
                                <td>
                                    {{ $order->player_id }}
                                </td>
                                <td>
                                    {{ $order->service->price }}
                                </td>
                                
                                <td>
                                    {{ $order->quantity }}
                                </td>
                                <td>
                                    @if( $order->service->type == 1)
                                        <h5 class="m-0 font-weight-normal">{{ $order->quantity }}</h5>
                                    @else
                                        <h5 class="m-0 font-weight-normal">{{  $order->quantity * $order->service->quantity }}</h5>
                                    @endif
                                </td>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{  $order->service->price * $order->quantity }}</h5>                                        
                                </td>
                               
                                <td>
                                    @if($order->type  == "processing")
                                                        <span class="badge bg-success text-white">قيد الانتظار    </span>
                                                    @elseif($order->type  == "working")
                                                        <span class="badge bg-info text-white"> قيد العمل </span>
                                                    @elseif($order->type  == "rejected")
                                                        <span class="badge bg-warning text-white">  مرفوض</span>
                                                    @elseif($order->type  == "canceled")
                                                        <span class="badge bg-danger text-white">  ملغي</span>
                                                    @elseif($order->type  == "complete")
                                                        <span class="badge bg-primary text-white"> مقبول </span>
                                                    @endif
                                </td>
                                <td>
                                    {{ $order->created_at }}
                                </td>
                                <td>
                                    @if($order->reason != "")
                                    {{ $order->reason }}
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>


            </div>


          


        </div>
    </div>
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>

    <!-- Page js-->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
