@extends('layouts.vertical', ['title' => 'العملات', 'mode' => 'rtl'])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">قائمه العملات</h4>
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

    <div class="button-list">
        <a class="btn btn-success btn-rounded waves-effect waves-light"
            href="{{ route('currenciesCreate', ['admin', 'currencies', 'create']) }}">اضف عمله <i class="mdi mdi-plus-circle me-1"></i></a>
    </div><br>

    <div class="card">
        <div class="card-body">
            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                       
                        <th>
                            اسم العملة
                        </th>
                        <th>
                            الرمز
                        </th>
                        <th>
                            سعر الصرف مقابل الدولار 
                        </th>
                        <th>
                            العملة الاساسية
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                        <tr>
                            <td>
                                <a href="{{ route('currenciesEdit', ['admin', 'currencies', 'edit', $currency->id]) }}">
                                    <b>{{ $currency->title }}</b>
                                </a>
                            </td>
                            <td>
                                {{ $currency->symbol }}
                            </td>
                            <td>
                                {{ $currency->rate }}
                            </td>
                            <td>
                                @if ($currency->default != 1)
                                    <span class="badge bg-soft-danger text-danger">لا</span>
                                @else
                                    <span class="badge bg-soft-success text-success">نعم</span>
                                @endif
                            </td>
                            
                            <td>
                                <a class="action-icon" href="{{ route('currenciesEdit', ['admin', 'currencies', 'edit', $currency->id]) }}">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                                @if( $currency->id != 1)
                                <a  class="action-icon" href="#" data-toggle="modal" data-target="#danger-alert-modal{{ $currency->id }}">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @foreach ($currencies as $currency)
                <!-- Danger Alert Modal -->
                <div id="danger-alert-modal{{ $currency->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content modal-filled bg-danger">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <input type="hidden" value="{{ $currency->id }}" name="del_id" id="app_id">
                                    <i class="dripicons-wrong h1 text-white"></i>
                                    <h4 class="mt-2 text-white">هل انت متأكد من الحذف ؟</h4>
                                    <p class="mt-3 text-white">هل تريد حقًا حذف هذه السجلات؟ لا يمكن التراجع عن هذه العملية.</p>
                                    <button type="button"
                                        onclick="location.href='{{ url('/dashboard/admin/currencies/destroy/currencies/destroy/' . $currency->id) }}';"
                                        class="btn btn-light my-2">حذف</button>
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
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>

    <!-- Page js-->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection