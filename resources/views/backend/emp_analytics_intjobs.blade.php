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
           <h3>Interested Jobs</h3>

        @foreach($interested_jobs as $job)
            @if($job->likes>0)
            <div class="col-md-4" id="job_list">
                <div class="job-card">
                    <div class="row">
                        <div class="col-md-12 heading">
                            <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                        </div>
                        <div class="col-md-12">

                        </div>
                        <div class="col-md-12 sub-heading">
                            <a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                {{ str_studly($job->company->title) }}
                            </a>
                            <br>
                            <span class="label label-danger">
                                <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                    {{ str_studly($job->level) }}
                                </a>
                            </span>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @foreach($job->categories as $category)
                                <div class="label label-info">
                                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @foreach($job->skills as $skill)
                                <div class="label label-success">
                                    <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                        {{ $skill->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <div for="" class="label label-info">
                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                    {{ $job->country->name }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div for="" class="label label-info">
                                <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                    {{ $job->state->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        <div class="col-md-12 center-block">
            {!! $paginator->render() !!}
        </div>
        @endauth

    </div>



@endsection

@section('after-scripts-end')



@endsection