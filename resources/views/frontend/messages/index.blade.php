

@extends('frontend.layouts.master')
@section('title', 'رسائلي')
@section('content')




<category style="direction: rtl;text-align: right;">
    <div class="category">
        <div class="container" style="min-height: 100vh;">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" dir="rtl">
                        @auth
                            <li class="breadcrumb-item"><a href="{{ route('boarding.index') }}">الرئيسية</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                        @endauth
                        <li class="breadcrumb-item" data-index="1"> رسائلي </li>
                    </ol>
                </div>

                <div class="col-md-12">
                    <main class="projects" id="projects-list">
                       <!-- التبويبات -->
                            <ul class="nav nav-tabs" id="messageTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $activeTab == 'inbox' ? 'active' : '' }}" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="{{ $activeTab === 'inbox' ? 'true' : 'false' }}">الرسائل الواردة</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $activeTab == 'sent' ? 'active' : '' }}" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="{{ $activeTab === 'sent' ? 'true' : 'false' }}">الرسائل الصادرة</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-4" id="messageTabsContent">
                                <!-- تبويب الرسائل الواردة -->
                                <div class="tab-pane fade {{ $activeTab == 'inbox' ? 'show active' : '' }}" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
                                    <h3>الرسائل الواردة</h3>
                                    @if($receivedMessages->isEmpty())
                                        <p>لا توجد رسائل واردة.</p>
                                    @else
                                        <ul class="list-group">
                                            @foreach($receivedMessages as $projectId => $messages)
                                                @php
                                                    $lastmessage = $messages->first(); // الحصول على أحدث رسالة
                                                 @endphp
                                            <li class="list-group-item">
                                                    <h3><a href="{{ route('message.showProjectChat', $lastmessage->project->id) }}"> {{ $lastmessage->project->title }} </a></h3>
                                                    <a href="{{route('freelancers.getUser',$lastmessage->receiver->id)}}">
                                                        <img src="{{ $lastmessage->receiver->profile_picture ? asset('storage/' . $lastmessage->receiver->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  class="profile-img" style="width: 30px;height: 30px;">
                                                        {{ $lastmessage->receiver->firstname . '' . $lastmessage->receiver->familyname}}
                                                    </a>

                                                    <i class="fa fa-clock-o"></i> {{ $lastmessage->timeElapsed($lastmessage->created_at)  }}<br>
                                                    <strong>الرسالة:</strong> {{ $lastmessage->message }} <br>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                <!-- تبويب الرسائل الصادرة -->
                                <div class="tab-pane fade {{ $activeTab == 'sent' ? 'show active' : '' }}" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                                    <h3>الرسائل الصادرة</h3>
                                    @if($sentMessages->isEmpty())
                                        <p>لا توجد رسائل صادرة.</p>
                                    @else
                                        <ul class="list-group">
                                            @foreach($sentMessages as $projectId => $messages)
                                                @if($messages->isNotEmpty())
                                                    @php
                                                        $lastmessage = $messages->first(); // الحصول على أحدث رسالة
                                                    @endphp
                                                    <li class="list-group-item">
                                                        <h3><a href="{{ route('message.showProjectChat', $lastmessage->project->id) }}"> {{ $lastmessage->project->title }} </a></h3>
                                                        <a href="{{route('freelancers.getUser',$lastmessage->sender->id)}}">
                                                            <img src="{{ $lastmessage->sender->profile_picture ? asset('storage/' . $lastmessage->sender->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  class="profile-img" style="width: 30px;height: 30px;">
                                                            {{ $lastmessage->sender->firstname . '' . $lastmessage->sender->familyname}}
                                                        </a>
                                                        <i class="fa fa-clock-o"></i> {{ $lastmessage->created_at->format('Y-m-d H:i') }}<br>
                                                        <strong>الرسالة:</strong> {{ $lastmessage->message }} <br>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                    </main>
                </div>


            </div>
        </div>
    </div>
</category>
<script>
    $(document).ready(function() {
        // تفعيل التبويب بناءً على قيمة activeTab
        var activeTab = '{{ $activeTab }}';
        if (activeTab === 'sent') {
            $('#sent-tab').tab('show'); // تفعيل تبويب الرسائل الصادرة
        } else {
            $('#inbox-tab').tab('show'); // تفعيل تبويب الرسائل الواردة
        }
    });
</script>

@endsection
