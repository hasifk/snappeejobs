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
        <h3>Not Interested Jobs</h3>
        <ul class="list-group">
        @foreach($not_interested_jobs as $job)
            @if($job->likes==0)
                    <li class="list-group-item">
                <div id="job_list">
                    <div class="job-card">
                        <div class="row">
                            <div class="col-md-12 heading">
                                <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                            </div>

                        </div>
                    </div>
                </div>
                </li>
            @endif
        @endforeach
        </ul>
        <div class="col-md-12 center-block">
            {!! $paginator->render() !!}
        </div>
        @endauth

    </div>



@endsection

