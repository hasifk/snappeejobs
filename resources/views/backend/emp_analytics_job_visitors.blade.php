@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>{{ trans('strings.backend.dashboard_title') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')
    <div class="row">




        @roles(['Employer', 'Employer Staff'])
        <h3>Job Visitors</h3>

        @if(count($job_auth_visitors)>0)

            @foreach($job_auth_visitors as $job)
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ route('jobs.view' , [ $job->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                    </li>
                    <li class="list-group-item">
                    Visited by:<a href="{{ route('jobseeker.show' , [ $job->user_id ] ) }}">{{ $job->name }}</a>
                    </li>
                    <li class="list-group-item">
                        Country:{{$job->country}}
                    </li>
                    <li class="list-group-item">
                        Latitude:{{$job->latitude}}
                    </li>
                    <li class="list-group-item">
                        Longitude:{{$job->longitude}}
                    </li>
                </ul>

            @endforeach


        @endif
        @if(count($job_visitors)>0)

            @foreach($job_visitors as $job)
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ route('jobs.view' , [ $job->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                    </li>
                    <li class="list-group-item">
                        Visited by:Guest
                    </li>
                    <li class="list-group-item">
                        Country:{{$job->country}}
                    </li>
                    <li class="list-group-item">
                        Latitude:{{$job->latitude}}
                    </li>
                    <li class="list-group-item">
                        Longitude:{{$job->longitude}}
                    </li>
                </ul>

            @endforeach


        @endif
        @endauth

    </div>



@endsection
