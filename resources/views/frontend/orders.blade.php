@extends('frontend.layouts.master')
@section('title', 'الطلبات')
@section('content')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <category>
        <div class="category">
            <div class="container">
                <form action="{{ route('addbalance') }}" method="post">
                    @csrf
                    <div>
                        <div>
                            <div class="w3-padding-8 pro-d1 w3-card">
                                <div style="overflow-x:auto;">
                                    <table style="direction: rtl">
                                        <tr style="background-color: #517097;color: #fff;">
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                اسم القسم
                                            </th>
                                            <th>
                                                اسم المنتج
                                            </th>
                                            <th>
                                                معرف المستخدم
                                            </th>
                                            <th>
                                                السعر
                                            </th>
                                            <th>
                                                الكميه
                                            </th>
                                            <th>
                                               العدد
                                            </th>
                                            <th>
                                                اجمالي السعر
                                            </th>
                                            <th>
                                                الحاله
                                            </th>
                                            <th>
                                                التاريخ
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    {{ $order->id }}
                                                </td>
                                                <td>
                                                    <a href="{{url('/service',$order->category->id)}} "  target="_blank" class="paypal-btn">
                                                        {{ $order->category->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{url('/product',$order->service->id)}} "  target="_blank" class="paypal-btn">
                                                        {{ $order->service->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $order->player_id }}
                                                </td>
                                                <td>
                                                    {{ $order->service->price }}
                                                </td>
                                                
                                                <td>
                                                    <h5 class="m-0 font-weight-normal">{{ $order->quantity }}</h5>
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
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </category>
@endsection
