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


        @if(count($job_visitors)>0 )



            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Job Visitors</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Job</th>
                            <th>Visited by</th>
                            <th>Country</th>
                            <th>Latitude</th>
                            <th style="width: 40px">Longitude</th>
                        </tr>





                            @foreach($job_visitors as $job)
                                <tr>
                                    <td><a href="{{ route('jobs.view' , [ $job->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a></td>
                                    <td>Guest</td>
                                    <td>{{$job->country}}</td>
                                    <td>
                                        {{$job->latitude}}
                                    </td>
                                    <td>{{$job->longitude}}</td>
                                </tr>
                            @endforeach
                        <div class="col-md-12 center-block">
                            {!! $job_visitors->render() !!}
                        </div>
                    </table>
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        @endif
        @endauth

    </div>



@endsection
