@extends ('backend.layouts.master')

@section ('title', 'Jobseekers')

@section('page-header')
    <h1>
        Jobseekers
        <small>Jobseekers Dashboard</small>
    </h1>
@endsection

@section('content')



    <div class="col-md-6">
        <h4>JobSeekers</h4>
    </div>
    <div class="col-md-6">
        <div class="dropdown pull-right">
            Sorted by
            <button class="btn btn-default dropdown-toggle" type="button" id="sortingMenu" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                @if ( is_null(request()->get('sort')) )
                    Newest
                @else
                    {{ (request()->get('sort') == 'created_at') ? 'Newest' : 'Popular' }}
                @endif
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortingMenu">
                <li><a href="
                    @if ( request()->get('sort') == 'likes' )
                    {{ route('backend.jobseekers', array_merge(request()->except('sort'), ['sort' => 'created_at'])) }}
                    @elseif ( request()->get('sort') == 'created_at' )
                    {{ route('backend.jobseekers', array_merge(request()->except('sort'), ['sort' => 'likes'])) }}
                    @else
                    {{ route('backend.jobseekers', array_merge(request()->except('sort'), ['sort' => 'likes'])) }}
                    @endif
                            ">
                        @if ( is_null(request()->get('sort')) )
                            Popular
                        @else
                            {{ (request()->get('sort') == 'created_at') ? 'Popular' : 'Newest' }}
                        @endif
                    </a></li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Company Preference</th>
            <th>Country</th>
            <th>State</th>
            <th>Likes</th>
            <th>Skills</th>
            <th>Categories Preferred</th>
        </tr>
        </thead>
        <tbody>

        @foreach($job_seekers as $job_seeker)
            @if($job_seeker->role->role_id==5)
            <tr>
                <td><a href="{{ route('backend.jobseekers.show' , [ $job_seeker->id ] ) }}">{{ $job_seeker->user->name }}</a>
                </td>
                <td><a href="{{ route('backend.jobseekers', ['size' => $job_seeker->size]) }}">
                        {{ str_studly($job_seeker->size) }}
                    </a></td>
                <td><a href="{{ route('backend.jobseekers', ['country_id' => $job_seeker->country->id]) }}">
                        {{ $job_seeker->country->name }}
                    </a></td>
                <td><a href="{{ route('backend.jobseekers', ['state_id' => $job_seeker->state->id]) }}">
                        {{ $job_seeker->state->name }}
                    </a></td>
                <td>{{ $job_seeker->likes ? $job_seeker->likes : '0' }}</td>
                <td>@if( $job_seeker->skills->count() )
                        @foreach($job_seeker->skills as $skill)
                            <div>
                                <a href="{{ route('backend.jobseekers', ['skill' => $skill->id]) }}">
                                    {{ $skill->name }}
                                </a>
                            </div>
                        @endforeach
                    @endif</td>
                <td>
                    @if( $job_seeker->categories->count() )
                        @foreach($job_seeker->categories as $category)
                            <div>
                                <a href="{{ route('backend.jobseekers', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </div>
                        @endforeach
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    <div class="col-md-12 center-block">
        {!! $paginator->render() !!}
    </div>

    <div class="clearfix"></div>

@stop


@section('after-scripts-end')
    <script>
        $(document).ready(function () {
            $('#country_id').on('change', function () {
                $.getJSON('/admin/get-states/' + $(this).val(), function (json) {
                    var listitems = '<option value="">Please select</option>';
                    $.each(json, function (key, value) {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });
        });
    </script>
@endsection

