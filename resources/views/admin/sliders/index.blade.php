@extends('layouts.vertical', ['title' => 'البنرات', 'mode' => 'rtl'])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">قائمه البنرات</h4>
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
            href="{{ route('sliders.create', ['admin']) }}">اضف بنر <i class="mdi mdi-plus-circle me-1"></i></a>
    </div><br>

    <div class="card">
        <div class="card-body">
            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            الصوره
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>
                                {{ $slider->id }}
                            </td>
                            <td>
                                <a href="{{ route('sliders.edit', ['admin', $slider->id]) }}">
                                    <img src="{{url('sliders/',$slider->image)}}" style="width: 200px;height:100px" />
                                </a>
                            </td>
                            <td>
                                <a class="action-icon" href="{{ route('sliders.edit', ['admin', $slider->id]) }}">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                                <a  class="action-icon" href="#" data-toggle="modal" data-target="#danger-alert-modal{{ $slider->id }}">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @foreach ($sliders as $slider)
                <!-- Danger Alert Modal -->
                <div id="danger-alert-modal{{ $slider->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content modal-filled bg-danger">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <input type="hidden" value="{{ $slider->id }}" name="del_id" id="app_id">
                                    <i class="dripicons-wrong h1 text-white"></i>
                                    <h4 class="mt-2 text-white">هل انت متأكد من الحذف ؟</h4>
                                    <p class="mt-3 text-white">هل تريد حقًا حذف هذه السجلات؟ لا يمكن التراجع عن هذه العملية.</p>
                                    <button type="button"
                                        onclick="location.href='{{ url('/dashboard/admin/sliders/destroy/' . $slider->id) }}';"
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
