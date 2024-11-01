@extends('layouts.vertical', ['title' => 'الرئيسية' , 'mode' => 'rtl'])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/selectize/selectize.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                    <h4 class="page-title">احصائيات</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">

            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fas fa-users font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="mt-1"> <span data-plugin="counterup">{{ $users }}</span></h3>
                                <p class="text-muted mb-1 text-truncate"> المستخدمين</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fa fa-list-alt font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $categories }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">الأقسام</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fa fa-list-alt font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $subcategories }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">الأقسام الفرعية </p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div>


</div>
<!-- end row-->


        <div class="row">
            <div class="col-xl-6">
                <div class="card-box">
                    <h4 class="header-title mb-3"> اخر الطلبات </h4>
                    <div class="table-responsive">
                        <table  style="text-align: center;" class="table table-borderless table-nowrap table-hover table-centered m-0">

                            <thead class="thead-light">
                                <tr>
                                    <th>
                                        اسم المنتج
                                    </th>
                                    <th>
                                        معرف المستخدم
                                    </th>
                                    <th>
                                        اسم المستخدم
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
                            </thead>
                            <tbody>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>

                                    <td>
                                        <h5 class="m-0 font-weight-normal"></h5>
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <h5 class="m-0 font-weight-normal"></h5>
                                    </td>

                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
                </div> <!-- end card-box-->
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card-box">
                    <h4 class="header-title mb-3"> اخر العمليات </h4>
                    <div class="table-responsive">
                        <table  style="text-align: center;" class="table table-borderless table-nowrap table-hover table-centered m-0">

                            <thead class="thead-light">
                                <tr>
                                    <th>المستخدم</th>
                                    <th>المبلغ</th>
                                    <th>نوع العمليه</th>
                                    <th> العمله</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>

                                        </td>
                                        <td style="direction: ltr;">

                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                    </tr>

                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>

    <!-- Dashboar 1 init js-->
    <script src="{{ asset('assets/js/pages/dashboard-1.init.js') }}"></script>
@endsection
