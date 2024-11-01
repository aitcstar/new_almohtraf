    @if($bids->isEmpty())
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
            <h3 class="text-muted">لا توجد عروض مضافة حاليًا</h3>
        </div>
    @else

        @foreach ($bids as $bid)
            <div class="project">

                <span class="badge" style="background-color: {{ $bid->bidStatus->color }};color:#fff">{{$bid->bidStatus->name}}</span>
                <h3 style="max-width: 600px;"><a href="{{ route('projects.show', $bid->project_id) }}">{{ $bid->project->title }}</a></h3>
                <ul class="project__meta list-meta-items">
                    <li class="text-muted"><i class="fa fa-fw fa-user"></i> <bdi>{{$bid->project->ownerProject->firstname . ' ' . $bid->project->ownerProject->familyname}}</bdi></li>

                    <li class="text-muted"><time datetime="{{ $bid->project->created_at }}" title="{{ $bid->project->created_at }}" itemprop="datePublished" data-toggle="tooltip" data-original-title="{{ $bid->project->created_at }}"><i class="fa fa-clock-o"></i> {{ $bid->project->timeElapsed($bid->project->created_at) }}</time></li>
                    <li class="text-muted"><i class="fa fa-fw fa-ticket"></i> {{ $bid->project->bidsCount() }}</li>
                </ul>

                <p>{{ Str::limit($bid->project->description, 300, '...') }}</p>
            </div>
        @endforeach

    <div class="d-flex justify-content-center">
        {{ $bids->links('pagination::bootstrap-4') }}
    </div>

    @endif
