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
                    <li role="presentation" class="@if(!request()->has('candidates')) active @endif"><a href="#candidates" aria-controls="candidates" role="tab" data-toggle="tab">Candidates</a></li>
                    <li role="presentation" class="@if(request()->has('staffmembers')) active @endif"><a href="#staffmembers" aria-controls="staffmembers" role="tab" data-toggle="tab">Staffmembers</a></li>
                    <li role="presentation" class="@if(request()->has('jobtype')) active @endif"><a href="#jobtype" aria-controls="jobtype" role="tab" data-toggle="tab">Job Types</a></li>
                    <li role="presentation" class="@if(request()->has('jobtitle')) active @endif"><a href="#jobtitle" aria-controls="jobtitle" role="tab" data-toggle="tab">Job Title</a></li>
                </ul>
            </div>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="staffmembers">
                    @foreach($staffinfo as $staffinfo1)
                        {{$staffinfo1->name}}
                    @endforeach
                    @unless($staffinfo)
                        No Staffs found with this search.
                    @endunless
                </div>

                <div role="tabpanel" class="tab-pane @if(request()->has('jobtype')) active @endif" id="jobtype">
                    @foreach($job_cat_info as $job_cat_info1)
                        {{$job_cat_info1->title}}
                        {{$job_cat_info1->name}}
                    @endforeach
                    @unless($job_cat_info)
                        No Job Categories found with this search.
                    @endunless
                </div>

                <div role="tabpanel" class="tab-pane @if(request()->has('jobtitle')) active @endif" id="jobtitle">
                    @foreach($jobtitle as $jobtitle1)
                        {{$jobtitle1->title}}
                    @endforeach
                    @unless($jobtitle)
                        No jobs found with this search
                    @endunless
                </div>

            </div>

        </div>

        @endauth

    </div>
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