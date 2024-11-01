@extends('frontend.layouts.master')
@section('title', 'المحفظة')
@section('content')


<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="min-height: 100vh;">
            <div class="row">
                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 16px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
                @endif

                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        @auth
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                        @endauth
                        <li class="breadcrumb-item" data-index="1">المحفظة</li>
                    </ol>
                </div>


                            <div class="col-md-12">
                                <div class="mt-3" style="text-align: left;padding: 11px 0;">
                                    <!-- زر شحن الرصيد -->
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addFundsModal" >شحن الرصيد</button>
                                </div>

                                <div class="panel">
                                    <a href="#" class="balance-widget">
                                        <div class="panel__card">
                                            <div class="carda__body dashboard__credits pdn--xs-tn">
                                                <div class="row no-gutter">
                                                    <div class="col-sm-6 text-success">
                                                        <h4 class="balance-title">الرصيد الكلي</h4>
                                                        <span class="balance-amount">{{ number_format($wallet->totalBalance(), 2) }} $ </span>
                                                    </div>
                                                    <div class="col-sm-6 text-primary">
                                                        <h4 class="balance-title">الرصيد القابل للسحب</h4>
                                                        <span class="balance-amount">{{ number_format($wallet->withdrawableBalance(), 2) }} $ </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer bg-white text-meta text-zeta text-right-xs">
                                                <div class="row no-gutter">
                                                    <div class="col-md-6">
                                                        <span>الرصيد المتاح</span>
                                                        <b class="text-primary">{{ number_format($wallet->availableBalance(), 2) }} $ </b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span>الرصيد المعلق</span>
                                                        <b class="text-primary">{{ number_format($wallet->pending_balance, 2) }} $ </b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>




                            </div>


                <div class="col-md-3">
                    <div class="container">
                        <div class="row">

                                <!-- البحث -->
                                <!--<div class="col-md-12">
                                    <div class="form-group">
                                        <label for="project__keyword"><p>بحث</p></label>
                                        <input class="form-control" id="project__keyword" data-filter="keyword" name="keyword" type="text">
                                    </div>
                                </div>-->


                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <main class="freelancers" id="freelancers-list">

                    </main>
                </div>



<!-- نافذة شحن الرصيد -->
<div class="modal fade" id="addFundsModal" tabindex="-1" role="dialog" aria-labelledby="addFundsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFundsLabel">شحن الرصيد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="credit-card-tab" data-toggle="tab" href="#credit-card" role="tab" aria-controls="credit-card" aria-selected="true">بطاقة الائتمان</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">PayPal</a>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    <!-- شحن الرصيد عبر بطاقة الائتمان -->
                    <div class="tab-pane fade show active" id="credit-card" role="tabpanel" aria-labelledby="credit-card-tab">
                        <form action="{{ route('wallet.addFunds') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">المبلغ</label>
                                <input type="number" class="form-control" name="amount" placeholder="أدخل المبلغ" required>
                            </div>
                            <div class="form-group">
                                <label for="card_number">رقم البطاقة</label>
                                <input type="text" class="form-control" name="card_number" placeholder="أدخل رقم البطاقة" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">تاريخ الانتهاء</label>
                                <input type="text" class="form-control" name="expiry_date" placeholder="MM/YY" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" class="form-control" name="cvv" placeholder="CVV" required>
                            </div>
                            <button type="submit" class="btn btn-primary">شحن الرصيد</button>
                        </form>
                    </div>

                    <!-- شحن الرصيد عبر PayPal -->
                    <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                        <form action="{{ route('wallet.addFunds') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="paypal_email">بريد PayPal</label>
                                <input type="email" class="form-control" name="paypal_email" placeholder="أدخل بريد PayPal" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">المبلغ</label>
                                <input type="number" class="form-control" name="amount" placeholder="أدخل المبلغ" required>
                            </div>
                            <button type="submit" class="btn btn-primary">شحن الرصيد</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            </div>

        </div>
    </div>
</category>


@endsection
