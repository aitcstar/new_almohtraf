@extends('layouts.vertical', ['title' => 'تفاصيل الطلب', 'mode' => 'rtl'])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <li class="breadcrumb-item"><a href="/dashboard/admin/orders/index/orders">الطلبات</a></li>
                                <li class="breadcrumb-item active">معلومات الطلب</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card ">
               

                @if (session()->has('message'))
                <div class="col-sm-6">
                    <div class="alertPart">
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif
            
           
                <div class="card-body" style="direction: rtl;">
                  
                    <label style="text-align: center"><b> معلومات الطلب </b></label>
                    <table class="table table-bordered table-striped" style="direction: rtl;text-align: right;">
                        <tbody>
                            <tr>
                                <th style="width: 10%;">
                                    اسم المنتج
                                </th>
                                <td>
                                    <b style="color:blue"> {{ $order->service->name }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    اسم القسم
                                </th>
                                <td>
                                    {{ $order->category->name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                 المستخدم
                                </th>
                                <td>
                                    {{ $order->user->fullname }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    معرف المستخدم
                                </th>
                                <td>
                                    {{ $order->player_id }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    السعر
                                </th>
                                <td>
                                    {{ $order->service->price }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10%;">
                                    الكميه
                                </th>
                                <td style="direction: ltr;">
                                    {{ $order->quantity }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    العدد
                                </th>
                                <td>
                                    @if( $order->service->type == 1)
                                        <h5 class="m-0 font-weight-normal">{{ $order->quantity }}</h5>
                                    @else
                                        <h5 class="m-0 font-weight-normal">{{  $order->quantity * $order->service->quantity }}</h5>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    اجمالي السعر
                                </th>
                                <td>
                                    {{  $order->service->price * $order->quantity }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    الحاله
                                </th>
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
                            </tr>
                            @if($order->reason != "")
                            <tr>
                                <th>
                                   سبب الرفض
                                </th>
                                <td>
                                    {{ $order->reason }}
                                </td>
                            </tr>
                            @endif
                            
                            <tr>
                                <th>
                                    التاريخ
                                </th>
                                <td>
                                    {{ $order->created_at }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    تغير الحاله
                                </th>
                                <td>
                                    <button type="button" onclick="location.href='{{ url('/dashboard/admin/orders/complete/orders/complete/' . $order->id) }}';" class="bg-primary text-white">مقبول</button>
                                   
                                    <button class="bg-warning text-white" href="#" data-toggle="modal" data-target="#danger-alert-modal{{ $order->id }}">
                                        مرفوض
                                    </button>

                                    <button type="button" onclick="location.href='{{ url('/dashboard/admin/orders/canceled/orders/canceled/' . $order->id) }}';" class="bg-danger text-white">ملغي</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Danger Alert Modal -->
                    <div id="danger-alert-modal{{ $order->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content modal-filled bg-warning">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <h4 class="mt-2 text-white">سبب الرفض</h4>
                                        <form method="POST" action="{{ route('ordersrejected',['admin','orders' ,'rejected'])  }}" enctype="multipart/form-data">
                                            @csrf
                                                <input type="hidden" value="{{ $order->id }}" name="id">
                                                <textarea name="reason" rows="4" cols="30" required></textarea>
                                              <button type="submit" class="btn btn-light my-2" >تاكيد </button>
                                        </form>
                                       
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                </div>


            </div>


          


        </div>
    </div>
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>

    <!-- Page js-->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
