@extends('layouts.vertical', ['title' => 'الأسئلة الشائعة ', 'mode' => 'rtl'])
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/summernote/summernote.min.css') }}" rel="stylesheet" type="text/css" />
    @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('faq.update', ['admin']) }}" method="POST" enctype="multipart/form-data" id="create">
                @csrf
                <label for="product-description"> الأسئلة الشائعة </label>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="form-group mb-3">
                                <label for="product-description">المحتوي <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote" rows="20" name="faq" placeholder="اكتب محتوي الصفحه" required>
                                    {{ $faq }}
                                </textarea>
                            </div>
                        </div> <!-- end card-box -->
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-3">
                            <button type="submit" class="btn w-sm btn-success waves-effect waves-light">حفظ</button>
                        </div>
                    </div> <!-- end col -->
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 400,
            });
        });
    </script>
    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/summernote/summernote.min.js') }}"></script>

    @endsection
