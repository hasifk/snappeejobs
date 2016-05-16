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




        @roles(['Employer'])

        <h3 class="box-title">Twitter Feeds</h3>

        <ul class="timeline">
            @if(!empty($tweets))
            @foreach($tweets as $tweet)
            <!-- timeline time label -->
            <li class="time-label">
        <span class="bg-red">
            {{ date('M d Y ,H:i', strtotime($tweet->created_at)) }}
        </span>
            </li>
            <!-- /.timeline-label -->

            <!-- timeline item -->
            <li>
                <!-- timeline icon -->
                <i class="fa fa-envelope bg-blue"></i>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="{{\Twitter::linkUser($tweet->user)}}">{{$tweet->user->name}}</a> ...</h3>
                    <div class="timeline-body">
                        {{$tweet->text}}
                    </div>


                </div>
            </li>
            <!-- END timeline item -->
            @endforeach
            @else
                <p>We are having a problem with our Twitter Feed right now.</p>
            @endif

        </ul>



    @endauth

    



    @endsection

