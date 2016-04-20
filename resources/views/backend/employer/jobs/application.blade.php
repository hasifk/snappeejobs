@extends ('backend.layouts.master')

@section ('title', "Job Management")

@section('page-header')
    <h1>
        Job Application
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Staff Management' ) !!}</li>
@stop

@section('content')

    @include('backend.employer.includes.partials.jobs.header-buttons')

    <div class="job-view panel panel-primary">

        <div class="panel-heading">
            {{ $job_application->job->title }}
        </div>

        <div class="panel-body">
            <h3>
                Job Seeker Details

                <img style="height: 25px; width: 25px;" src="{{ $job_application->jobseeker->picture }}" alt="{{ $job_application->jobseeker->name }}">

            </h3>

            @if( (is_null($job_application->accepted_at)) && (is_null($job_application->declined_at)) )
            <table>
                <tr>
                    <td>
                        <form action="{{ route('admin.employer.jobs.application.accept', $job_application->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="submit" value="Accept" class="btn btn-success">
                        </form>
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <form action="{{ route('admin.employer.jobs.application.decline', $job_application->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="submit" value="Reject" class="btn btn-danger">
                        </form>
                    </td>
                    <td>&nbsp;<a class="btn btn-primary" href="{{ route('admin.employer.jobs.manage', $job_application->job_id) }}">Manage Job Application</a></td>
                </tr>
            </table>
            @endif

            @if($job_application->accepted_at)

                <p>
                    <button class="btn">Accepted</button> {{ \Carbon\Carbon::parse($job_application->accepted_at)->diffForHumans() }}
                </p>

                <p>
                    Resume : <a href="{{ $job_application->jobseeker->resume }}" class="btn btn-primary">Download</a>
                </p>

            @endif

            @if($job_application->declined_at)
                <button class="btn btn-danger">Rejected</button> {{ \Carbon\Carbon::parse($job_application->declined_at)->diffForHumans() }}
            @endif

            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>
                        {{ $job_application->jobseeker->name }}
                    </td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $job_application->jobseeker->country_name }}</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $job_application->jobseeker->state_name }}</td>
                </tr>
                <tr>
                    <td>Industry Preference</td>
                    <td>{{ implode(' , ', $job_seeker->industries->lists('name')->toArray()) }}</td>
                </tr>
                <tr>
                    <td>Category Preference</td>
                    <td>{{ implode(' , ', $job_seeker->categories->lists('name')->toArray()) }}</td>
                </tr>
                <tr>
                    <td>Skills</td>
                    <td>{{ implode(' , ', $job_seeker->skills->lists('name')->toArray()) }}</td>
                </tr>
                @if($job_seeker->images()->count())
                    <tr>
                        <td>Gallery</td>
                        <td>
                            <ul class="list-group">
                                @foreach($job_seeker->images as $image)
                                    <li class="list-group-item">
                                        <img src="{{ $image->image }}" alt="{{ $image->filename }}" style="max-width:50px; max-height: 50px;" >
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif
                @if($job_seeker->videos()->count())
                    <tr>
                        <td>Video Gallery</td>
                        <td>
                            <ul class="list-group">
                                @foreach($job_seeker->videos as $video)
                                    <li class="list-group-item">
                                        <video
                                                id="jobseeker_video"
                                                class="video-js vjs-default-skin"
                                                controls
                                                preload="auto"
                                                data-setup='{}'
                                                style="max-width: 100%;"
                                        >
                                            <source src="{{ $video->video }}" type='video/{{ $video->extension }}'>
                                        </video>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif
            </table>

        </div>


    </div>

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#country_id').on('change', function(){
                $.getJSON('/admin/get-states/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });
        });
    </script>
@endsection
