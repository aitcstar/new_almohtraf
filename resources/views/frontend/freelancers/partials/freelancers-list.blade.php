@if ($onlineFreelancers->isEmpty())
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
            <h3 class="text-muted">لا توجد نتائج الان</h3>
        </div>
    @else

    @foreach ($onlineFreelancers as $freelancer)
            <div class="project">
                <div class="freelancer-row d-flex align-items-start">
                    <div class="info-td text-center">
                        <figure class="usercard__avatar">
                            <a href="{{route('freelancers.getUser',$freelancer->id)}}">
                                <img src="{{ $freelancer->profile_picture ? asset('storage/' . $freelancer->profile_picture) : asset('frontend/images/profile.png') }}" alt="صورة شخصية"  class="profile-img">

                            </a>
                            <i class="fa fa-circle clr-green" data-toggle="tooltip" title="" data-original-title="متصل الان"></i>


                        </figure>
                    </div>


                    <div class="details-td ml-3 flex-grow-1">
                        <div class="card-title_wrapper">
                            <h2 class="card--title m-0 text-meta">
                                <a href="{{route('freelancers.getUser',$freelancer->id)}}">
                                    <bdi>{{ $freelancer->firstname . ' ' .  $freelancer->familyname }}</bdi>
                                </a>
                            </h2>

                            <ul class="list-inline user__meta text-muted">
                                <li class="list-inline-item">
                                    <span class="rating">
                                        @php
                                            $rating = $freelancer->calculateOverallRating(); // أو استخدم التقييم المناسب حسب السياق
                                        @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $rating ? 'clr-amber' : 'clr-gray' }}"></i>
                                            @endfor

                                    </span>
                                </li>
                                <li class="list-inline-item" data-toggle="tooltip" title="نسبة اكمال المشاريع">
                                    <i class="fa fa-fw fa-percent"></i> {{ number_format($freelancer->completionRate, 2) }}
                                </li>
                                <li class="list-inline-item" data-toggle="tooltip" title="{{ $freelancer->subCategory->name }} ">
                                    <i class="fa fa-fw fa-briefcase"></i> {{ $freelancer->subCategory->name }}
                                </li>
                            </ul>
                        </div>

                        <div class="card--actions" style="text-align: left;margin: -63px 0 0 0;direction: ltr;">
                            <form action="{{ route('favorites.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="favoritable_type" value="App\Models\User">
                                <input type="hidden" name="favoritable_id" value="{{ $freelancer->id }}">
                                <input type="hidden" name="type" value="user"> <!-- أو "user" أو "portfolio" -->
                                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-heart"></i></button>
                            </form>
                        </div>
                        <!--
                        <div class="card--actions hidden-xs" style="text-align: left;margin: -63px 0 0 0;direction: ltr;">
                            <div class="dropdown btn-group">
                                <a href="#"
                                   class="btn btn-info btn-sm">
                                    <i class="fa fa-send"></i> تواصل معي
                                </a>
                                <button class="btn btn-info btn-sm" data-toggle="dropdown">
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-left">
                                    <li>
                                        <a href="#bookmark" data-action="bookmark">
                                            <i class="fa fa-bookmark"></i> أضف إلى المفضلة
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-sticky-note"></i> أضف ملاحظة
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#report" data-action="report">
                                            <i class="fa fa-flag"></i> تبليغ عن محتوى
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    -->
                        <div class="freelancer__brief mt-3">
                            <p class="text-wrapper-div">
                                <a href="#" class="details-url">
                                    {{ Str::limit($freelancer->biography, 300, '...') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>



            </div>
        @endforeach

    <div class="d-flex justify-content-center">
        {{ $onlineFreelancers->links('pagination::bootstrap-4') }}
    </div>

    @endif


