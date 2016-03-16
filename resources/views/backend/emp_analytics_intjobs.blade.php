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
        @if(count($interested_jobs)>0)
           <h3>Interested Jobs</h3>
        <ul class="list-group">
        @foreach($interested_jobs as $job)
            @if($job->likes>0)
                <li class="list-group-item">
                    <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                    Liked by:<a href="{{ route('jobseeker.show' , [ $job->id ] ) }}">{{ $job->name }}</a>
                </li>

            @endif
        @endforeach
       </ul>
        <div class="col-md-12 center-block">
            {!! $interested_jobs->render() !!}
        </div>
        @endif
        @endauth

    </div>



@endsection

@section('after-scripts-end')



@endsection