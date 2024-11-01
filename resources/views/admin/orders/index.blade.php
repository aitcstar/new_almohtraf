@extends('layouts.vertical', ['title' => 'الطلبات', 'mode' => 'rtl'])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">قائمه الطلبات</h4>
            </div>
        </div>
    </div>

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


    <div class="card">
        <div class="card-body">
            <a class="btn bg-secondary text-white" href="{{ route('ordersIndex', ['admin', 'orders', 'index']) }}">
                الكل {{ $all }}
             </a>

            <a class="btn bg-success text-white" href="{{ route('ordersstatus', ['admin', 'orders', 'status', 'processing']) }}">
               قيد الانتظار {{ $processing }}
            </a>

            <a class="btn bg-info text-white" href="{{ route('ordersstatus', ['admin', 'orders', 'status', 'working']) }}">
                قيد العمل {{ $working  }}
             </a>

             <a class="btn bg-primary text-white" href="{{ route('ordersstatus', ['admin', 'orders', 'status', 'complete']) }}">
                مقبول {{ $complete  }}
             </a>
             <a class="btn bg-warning text-white" href="{{ route('ordersstatus', ['admin', 'orders', 'status', 'rejected']) }}">
                مرفوض {{ $rejected  }}
             </a>
             <a class="btn bg-danger text-white" href="{{ route('ordersstatus', ['admin', 'orders', 'status', 'canceled']) }}">
                ملغي {{ $canceled  }}
             </a>
             <br>
             <br>
            <table id="datatable-buttons" name="example"class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <th>#</th>
                   <!-- <th>اسم القسم</th>-->
                    <th> اسم المنتج</th>
                    <th> المستخدم</th>
                    <th>معرف المستخدم</th>
                    <th>السعر</th>
                    <th>الكميه</th>
                   <!-- <th> العدد</th>-->
                    <th>اجمالي السعر</th>
                    <th> الحاله</th>
                    <th>التاريخ</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            # {{ $order->id }}
                        </td>
                        <!--<td>
                            <a href="{{url('/service',$order->category->id)}} "  target="_blank" class="paypal-btn">
                                {{ $order->category->name }}
                            </a>
                        </td>-->
                        <td>
                            <a href="{{route('ordersShow',['admin','orders' ,'show',$order->id] )}}" class="paypal-btn">
                                <b>{{ $order->service->name }}</b>
                            </a>
                        </td>
                        <td>
                            {{ $order->user->fullname }}
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
                        <!--<td>
                            @if( $order->service->type == 1)
                                <h5 class="m-0 font-weight-normal">{{ $order->quantity }}</h5>
                            @else
                                <h5 class="m-0 font-weight-normal">{{  $order->quantity * $order->service->quantity }}</h5>
                            @endif
                        </td>-->
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
                            <a class="action-icon" href="{{route('ordersShow',['admin','orders' ,'show',$order->id] )}}">
                                <i class="mdi mdi-eye"></i>
                            </a>
                           {{-- @if($order->type  == "processing")
                                <button type="button"
                                onclick="location.href='{{ url('/dashboard/admin/orders/complete/orders/complete/' . $order->id) }}';"
                                class="bg-danger text-white my-2">مكتمل</button>
                            @endif--}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
