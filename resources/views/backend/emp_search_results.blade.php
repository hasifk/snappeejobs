@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>{{ trans('strings.backend.emp_search_results') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')
    <div class="row">

        @roles(['Employer'])

        <div class="container">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="@if(request()->has('candidates')) active @endif"><a href="#candidates" aria-controls="candidates" role="tab" data-toggle="tab">Candidates</a></li>
                    <li role="presentation" class="@if(request()->has('staffmembers')) active @endif"><a href="#staffmembers" aria-controls="staffmembers" role="tab" data-toggle="tab">Staffmembers</a></li>
                    <li role="presentation" class="@if(request()->has('jobtype')) active @endif"><a href="#jobtype" aria-controls="jobtype" role="tab" data-toggle="tab">Job Types</a></li>
                    <li role="presentation" class="@if(request()->has('jobtitle')) active @endif"><a href="#jobtitle" aria-controls="jobtitle" role="tab" data-toggle="tab">Job Title</a></li>
                </ul>
            </div>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="candidates">
                    @if (count($candidate_info) > 0)
                    <ul class="list-group">
                @foreach($candidate_info as $job_seeker)
                                <li class="list-group-item">

                        <div class="job-card">
                            <div class="row">
                                <div class="col-md-12 heading">
                                    <a href="{{ route('jobseeker.show' , [ $job_seeker->id ] ) }}">{{ $job_seeker->user->name }}</a>
                                </div>
                                <div class="col-md-12 sub-heading">
                                    Looking for job in
                                    <a href="{{ route('jobseeker.search', ['size' => $job_seeker->size]) }}">
                                        {{ str_studly($job_seeker->size) }}
                                    </a>
                                    sized company
                                    <br>
                                    <a href="{{ route('jobseeker.search', ['country_id' => $job_seeker->country->id]) }}">
                                        <i class="fa fa-flag">
                                            {{ str_studly($job_seeker->country->name) }}
                                        </i>
                                    </a>
                                    <br>
                                    <a href="{{ route('jobseeker.search', ['state_id' => $job_seeker->state->id]) }}">
                                        {{ str_studly($job_seeker->state->name) }}
                                    </a>
                                    <br>
                                    @if( $job_seeker->skills->count() )
                                        @foreach($job_seeker->skills as $skill)
                                            <div class="label label-success">
                                                <a href="{{ route('jobseeker.search', ['skill' => $skill->id]) }}">
                                                    {{ $skill->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                    <br>
                                    @if( $job_seeker->categories->count() )
                                        @foreach($job_seeker->categories as $category)
                                            <div class="label label-success">
                                                <a href="{{ route('jobseeker.search', ['category' => $category->id]) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                    <br>
                                    <i class="fa fa-heart">
                                        {{ $job_seeker->likes ? $job_seeker->likes : '0' }}
                                    </i>
                                </div>
                                <hr>
                            </div>
                        </div>
                  </li>
                @endforeach
                </ul>
                <div class="col-md-12 center-block">
                    {!! $paginator1->render() !!}
                </div>
                    @else
                        No Candidate found with this search.
                    @endif
               </div>


                <div role="tabpanel" class="tab-pane" @if(request()->has('staffmembers')) active @endif" id="staffmembers">
                    @if (count($staffinfo) > 0)
                    <ul class="list-group">
                    @foreach($staffinfo as $staffinfo1)
                            <li class="list-group-item">
                        {{$staffinfo1->name}}
                                </li>
                    @endforeach
                        </ul>
                    @else
                        No Staffs found with this search.
                    @endif
                </div>

                <div role="tabpanel" class="tab-pane @if(request()->has('jobtype')) active @endif" id="jobtype">
                    @if (count($job_cat_info) > 0)
                        <ul class="list-group">
                    @foreach($job_cat_info as $job_cat_info1)
                                <li class="list-group-item">
                        {{$job_cat_info1->title}}
                        {{$job_cat_info1->name}}
                                    </li>
                    @endforeach
                            </ul>
                    @else
                        No Job Categories found with this search.
                    @endif
                </div>

                <div role="tabpanel" class="tab-pane @if(request()->has('jobtitle')) active @endif" id="jobtitle">
                    <ul class="list-group">
                        @if (count($jobtitle) > 0)
                    @foreach($jobtitle as $job)
                            <li class="list-group-item">

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

                      </li>
                    @endforeach
                   </ul>
                    <div class="col-md-12 center-block">
                        {!! $paginator->render() !!}
                    </div>
                    @else

                        No jobs found with this search
                    @endif
                </div>

            </div>

        </div>

        @endauth


@endsection
@section('after-scripts-end')
    <script>

        var isSearchPage = function(ss){
            return window.location.href.search("[?&]"+ss+"=") != -1;
        };

        var getNextURL = function(s){

            return isSearchPage(s) ? '{{ request()->route()->getPrefix() }}/employersearch' : '{{ request()->route()->getPrefix() }}/employersearch?'+s
        }

        $(document).ready(function(){


            $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {

                var abc=$(e.target).attr('href');
                history.pushState({}, 'Snappeejobs '+abc+ 'search results', getNextURL(abc));
            })

        });
    </script>
@endsection