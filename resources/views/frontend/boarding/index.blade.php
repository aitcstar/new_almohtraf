@extends('frontend.layouts.master')
@section('title', 'لوحة التحكم')
@section('content')

    <category style="direction: rtl;text-align: right;">
        <div class="category">
            <div class="container">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible" style="text-align: center;font-size: 20px;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('message') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb" dir="rtl">
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item" data-index="1"><bdi> لوحة التحكم</bdi></li>
                        </ol>
                    </div>


                    <div class="custom-col col-md-4">
                        <div class="panel">
                            <div class="heada" style="text-align: center;">
                                <div class="panel-actions">
                                    <a  href="/profile/index">
                                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"
                                        alt="User Image" class="profile-img">
                                    </div>
                                    <h2 class="panel-title">
                                        {{ Auth::user()->firstname . ' ' . Auth::user()->familyname }}
                                    </h2>
                                </a>
                            </div>

                            <div style="text-align: center;">
                                <a href="/profile/edit">
                                    <i class="fa fa-sliders fa-fw"></i>
                                    <span>تعديل الملف الشخصي</span>
                                </a>
                            </div>
                        </div>


                        <div class="panel">

                            <div class="heada">
                                <h4 class="panel-title">
                                    {{ __('خطوات إكمال الحساب') }}
                                </h4>
                            </div>

                            <div class="carda__body text-right-xs onboarding">
                                <div class="dropler__content respon-sm-3">
                                    <ul class="list-unstyled checklist text-meta">

                                        @php
                                        $steps = [];

                                        // Check if session contains account_type_ids and if 1 is in the array
                                        if(session('account_type_ids') && in_array(1, session('account_type_ids'))) {
                                            $steps[] = [
                                                'url' => '/project/create',
                                                'text' => 'أضف مشروعك الأول',
                                                'completed' => $hasProject,
                                            ];
                                        }

                                        $steps[] = [
                                            'url' => '#',
                                            'text' => 'تأكيد رقم الجوال',
                                            'completed' => false,
                                        ];

                                        $steps[] = [
                                            'url' => '/profile/edit',
                                            'text' => 'إضافة المهارات',
                                            'completed' => true,
                                        ];

                                        $steps[] = [
                                            'url' => '/profile/index',
                                            'text' => 'إضافة أعمال جديدة',
                                            'completed' => true,
                                        ];

                                        $steps[] = [
                                            'url' => '#',
                                            'text' => 'توثيق الهوية',
                                            'completed' => false,
                                        ];
                                    @endphp


                                        @foreach ($steps as $step)
                                            <li class="{{ $step['completed'] ? 'check' : '' }}">
                                                <a href="{{ $step['url'] }}" class="pdn--sn-imp"
                                                    target="{{ str_contains($step['url'], 'accounts.hsoub.com') ? '_blank' : '_self' }}">
                                                    <i
                                                        class="text-delta fa {{ $step['completed'] ? 'fa-check-circle' : 'fa-circle-o' }}"></i>
                                                    <span class="step">{{ __($step['text']) }}</span>
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="panel">
                            <div class="widget">
                                <div class="widget__header">
                                    <a href="#" class="widget__link">
                                        <h4 class="widget__title">الرسائل الجديدة</h4>
                                        <span class="widget__count">{{ $newMessagesCount }}</span>
                                    </a>
                                </div>
                                <div class="widget__footer">
                                    <div class="row no-gutter">
                                        <div class="col-md-6">
                                            <a href="{{ route('message.index', ['tab' => 'inbox']) }}" class="widget__link">
                                                <span class="widget__text">الرسائل الواردة</span>
                                                <b class="widget__number">{{ $incomingCount }}</b>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('message.index', ['tab' => 'sent']) }}" class="widget__link">
                                                <span class="widget__text">الرسائل الصادرة</span>
                                                <b class="widget__number">{{ $outgoingCount }}</b>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="custom-col col-md-8">
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

                        @if(session('account_type_ids') && in_array(1, session('account_type_ids')))
                        <div class="panel">
                            <div class="heada">
                                <h3 class="panel-title">
                                    مشاريعي
                                </h3>
                            </div>
                            <div class="carda__body widget__content">
                                <div class="row row-eq-height" style="padding: 11px 20px;">

                                    @foreach($statusSummary as $status)
                                    <div class="col-sm-6 col-xs-12">

                                        <a href="{{ route('myprojects', ['status' => $status['id']]) }}" class="progress__bar">
                                            <div class="projects-progress">
                                                <div class="clearfix">
                                                    <div class="pull-right">{{ $status['count'] }} {{ $status['status_name'] }}</div>
                                                    <div class="pull-left">{{ $status['percentage'] }}%</div>
                                                </div>
                                                <div class="progress progress--slim">
                                                    <div class="progress-bar label-prj-draft" role="progressbar"
                                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{ $status['percentage'] }}%">
                                                        <span class="sr-only">{{ $status['percentage'] }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>


                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endif

                        @if(session('account_type_ids') && in_array(2, session('account_type_ids')))
                        <div class="panel">


                                <div class="heada">
                                    <h3 class="panel-title">
                                        عروضي
                                    </h3>
                                </div>

                                <div class="row content-middle-sm" style="padding: 11px 20px;">
                                    @foreach($statusPercentages as $bidStatus)
                                        <div class="col-sm-6 progress__bars">

                                            <a href="{{ route('myBids', ['status' => $bidStatus['id']]) }}" class="progress__bar">
                                                <div class="projects-progress">
                                                    <div class="clearfix">
                                                        <div class="pull-right">{{ $bidStatus['count'] }} {{ $bidStatus['name']  }}</div>
                                                        <div class="pull-left">{{ $bidStatus['percentage'] }}%</div>
                                                    </div>
                                                    <div class="progress progress--slim">
                                                        <div class="progress-bar label-prj-open" role="progressbar"
                                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                            style="width: {{ $bidStatus['percentage'] }}%;">
                                                            <span class="sr-only">{{ $bidStatus['percentage'] }}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                        @endforeach
                                </div>

                        </div>
                        @endif

                        <div class="panel">
                            <div class="heada">
                                <h3 class="panel-title">
                                    آخر مشاريع {{  $category->name}}
                                </h3>
                            </div>
                            <div class="row content-middle-sm" style="padding: 11px 20px;">
                                @foreach($projects as $project)
                                <div class="project">
                                    <h3 style="max-width: 600px;"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a></h3>
                                    <ul class="project__meta list-meta-items">
                                        <li class="text-muted"><i class="fa fa-fw fa-user"></i> <bdi>{{$project->ownerProject->firstname . ' ' . $project->ownerProject->familyname}}</bdi></li>

                                        <li class="text-muted"><time datetime="{{ $project->created_at }}" title="{{ $project->created_at }}" itemprop="datePublished" data-toggle="tooltip" data-original-title="{{ $project->created_at }}"><i class="fa fa-clock-o"></i> {{ $project->timeElapsed($project->created_at) }}</time></li>
                                        <li class="text-muted"><i class="fa fa-fw fa-ticket"></i> {{ $project->bidsCount() }}</li>
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </category>
@endsection
