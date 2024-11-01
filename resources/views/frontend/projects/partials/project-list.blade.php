    @if($projects->isEmpty())
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
            <h3 class="text-muted">لا توجد مشاريع مضافة حاليًا</h3>
        </div>
    @else

        @foreach ($projects as $project)
            <div class="project">
                @if(request()->path() != "filter-projects" && request()->path() != "project/list" && request()->path() != "projects/filter")
                    <span class="badge" style="background-color: {{ $project->projectStatus->color }};color:#fff;">{{$project->projectStatus->name}}</span>
                @endif
                <h3 style="max-width: 600px;"><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3>
                <div style="display: flex; justify-content: left; align-items: center; gap: 5px; margin: -37px 0px 0px 0;">
                    @if(request()->path() == "filter-projects" || request()->path() == "project/list" || request()->path() == "projects/filter")
                        @if(session('account_type_ids') && in_array(1, session('account_type_ids')))
                            <a href="{{ route('projects.clone', $project->id) }}" class="btn btn-primary" style="font-size: 13px;">
                                <i class="fa fa-fw fa-plus"></i> مشروع مماثل
                            </a>
                        @endif
                    @endif

                    <form action="{{ route('favorites.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="favoritable_type" value="App\Models\Project">
                        <input type="hidden" name="favoritable_id" value="{{ $project->id }}">
                        <input type="hidden" name="type" value="project"> <!-- أو "user" أو "portfolio" -->
                        <span>
                            @if(in_array($project->id, $favoriteProjectIds))
                                <!-- Favorite Icon with Active Color -->
                                <button type="submit" class="btn btn-primary" style="font-size: 13px;color: red;"><i class="fa fa-fw fa-heart"></i></button>

                            @else
                                <!-- Favorite Icon with Default Color -->
                                <button type="submit" class="btn btn-primary" style="font-size: 13px;"><i class="fa fa-fw fa-heart"></i></button>

                            @endif
                        </span>
                    </form>
                    @if(request()->path() == "filter-projects" || request()->path() == "project/list" || request()->path() == "projects/filter")

                    <!-- زر التبليغ -->
                    <button type="button" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $project->id }}" class="btn btn-primary" style="font-size: 13px;">
                        <i class="fa fa-flag"></i>
                    </button>
                    @endif
                </div>



                <ul class="project__meta list-meta-items">
                    <li class="text-muted"><i class="fa fa-fw fa-user"></i> <bdi>{{$project->ownerProject->firstname . ' ' . $project->ownerProject->familyname}}</bdi></li>

                    <li class="text-muted"><time datetime="{{ $project->created_at }}" title="{{ $project->created_at }}" itemprop="datePublished" data-toggle="tooltip" data-original-title="{{ $project->created_at }}"><i class="fa fa-clock-o"></i> {{ $project->timeElapsed($project->created_at) }}</time></li>
                    <li class="text-muted"><i class="fa fa-fw fa-ticket"></i> {{ $project->bidsCount() }}</li>
                </ul>

                <p>{{ Str::limit($project->description, 300, '...') }}</p>
            </div>


 <div class="modal" id="reportModal-{{ $project->id }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">تبليغ عن محتوى</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('report.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reportable_type" value="App\Models\Project">
                    <input type="hidden" name="reportable_id" value="{{ $project->id }}">
                    <div class="form-group">
                        <label for="reason">سبب التبليغ</label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer" style="direction: ltr;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-danger">إرسال التبليغ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        @endforeach

    <div class="d-flex justify-content-center">
        {{ $projects->links('pagination::bootstrap-4') }}
    </div>
    @endif

 <!-- مودال التبليغ -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

