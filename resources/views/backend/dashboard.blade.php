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

    @roles(['Administrator'])

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $employer_count }}</h3>

                <p>Employer Count</p>
            </div>
            <div class="icon">
                <i class="ion-ios-people"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $active_subscriptions }}</h3>

                <p>Active Subscriptions</p>
            </div>
            <div class="icon">
                <i class="ion ion-card"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $blocked_users }}</h3>

                <p>Blocked Users</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-people-outline"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $active_job_listings }}</h3>

                <p>Active Job Listings</p>
            </div>
            <div class="icon">
                <i class="ion ion-briefcase"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $job_seeker_count }}</h3>

                <p>Job Seeker Count</p>
            </div>
            <div class="icon">
                <i class="ion-person-stalker"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->

    @endauth


    @roles(['Employer', 'Employer Staff'])

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $total_jobs_posted }}</h3>

                <p>Total Jobs Posted</p>
            </div>
            <div class="icon">
                <i class="ion-eye"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $total_job_application }}</h3>

                <p>Job Applications Received</p>
            </div>
            <div class="icon">
                <i class="ion ion-card"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $total_staff_members }}</h3>

                <p>Staff Members</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-people-outline"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $new_messages }}</h3>

                <p>New Messages</p>
            </div>
            <div class="icon">
                <i class="ion ion-email-unread"></i>
            </div>
        </div>
    </div>

    @endauth

</div>

<div class="row">

    @roles(['Employer', 'Employer Staff'])



    <div class="col-md-6">

        <div class="employer-notitications">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Employer Notifications</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box employer-notitications-list">

                        @foreach($employer_notifications as $employer_notification)

                        <li class="item">
                            @if(
                                ($employer_notification->notification_type == 'job_created') ||
                                ($employer_notification->notification_type == 'job_updated') ||
                                ($employer_notification->notification_type == 'job_deleted')
                            )
                            <div style="margin-left: 25px;" class="product-info">
                                <a href="#" class="product-title">
                                    {{ unserialize($employer_notification->details)['job']['title'] }}
                                    <span class="label label-warning pull-right">
                                        {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                    </span>
                                </a>
                                <span class="product-description">
                                    {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                </span>
                                by {{ unserialize($employer_notification->details)['user']['name'] }}
                            </div>
                            @endif
                            @if(
                                ($employer_notification->notification_type == 'project_created') ||
                                ($employer_notification->notification_type == 'project_updated') ||
                                ($employer_notification->notification_type == 'project_deleted')
                            )
                            <div style="margin-left: 25px;" class="product-info">
                                <a href="#" class="product-title">
                                    {{ unserialize($employer_notification->details)['project']['title'] }}
                                    <span class="label label-warning pull-right">
                                        {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                    </span>
                                </a>
                                <span class="product-description">
                                    {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                </span>
                                by {{ unserialize($employer_notification->details)['user']['name'] }}
                            </div>
                            @endif
                            @if(
                                ($employer_notification->notification_type == 'task_created') ||
                                ($employer_notification->notification_type == 'task_updated') ||
                                ($employer_notification->notification_type == 'task_deleted')
                            )
                            <div style="margin-left: 25px;" class="product-info">
                                <a href="#" class="product-title">
                                    {{ unserialize($employer_notification->details)['task']['title'] }}
                                    <span class="label label-warning pull-right">
                                        {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                    </span>
                                </a>
                                <span class="product-description">
                                    {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                </span>
                                by {{ unserialize($employer_notification->details)['user']['name'] }}
                            </div>
                            @endif
                        </li>

                        @endforeach

                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="{{ route('backend.notifications.history') }}" class="uppercase">View All Notifications</a>
                </div>
                <!-- /.box-footer -->
            </div>

        </div>

    </div>


    <div class="col-md-6">

        <div class="owl-carousel owl-theme">
            <div class="item" style="text-align: center; background-color: #00c0ef; min-height: 100px; line-height: 100px; color: #fff;">
                <p>
                    Total Visitors for Company: {{$company_visitors}}
                </p>
            </div>
            <div class="item" style="text-align: center; background-color: #b5d592; min-height: 100px; line-height: 100px; color: #fff;">
                <p>
                    Total Visitors for Jobs: {{$job_visitors}}
                </p>
            </div>
            <div class="item" style="text-align: center; background-color: #00a65a; min-height: 100px; line-height: 100px; color: #fff;">
                <p>
                    Total Active Job Openings:{{$active_job_listings1}}
                </p>
            </div>
            <div class="item" style="text-align: center; background-color: #dd4b39; min-height: 100px; line-height: 100px; color: #fff;">
                <p>
                    Total Jobs Posted:{{ $total_jobs_posted }}
                </p>
            </div>
        </div>

    </div>





    @if(!empty($job_visitors_today))
    @if(count($job_interest_level)>0)
    <div class="col-md-6 ">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Jobs Interest Level Today (Total Visits:{{$job_visitors_today}})</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                @foreach($job_interest_level as $job)

                <?php
                $new_width = ($job->items / $job_visitors_today) * 100 . '%';
                ?>
                <div class="progress_group">
                    <span class="progress-text">{{$job->title}}</span>
                    <span class="progress-number">({{$job->items }} / {{$job_visitors_today}})</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="{{$job->items}}" aria-valuemin="0" aria-valuemax="{{count($job_interest_level)}}" style="width:{{$new_width}}">

                        </div>
                    </div>

                </div>
                @endforeach

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col (right) -->

    @endif
    @endif


    <div class="col-xs-12 col-md-6 pull-right" >

        <div class="newsfeed_notifications">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">News Feeds</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box newsfeed_notifications_list">
                        @foreach($newsfeed_notifications as $employer_notification)
                            @if($employer_notification->notification_type == 'news_feed_created')
                        <li class="item">

                            <div style="margin-left: 25px;" class="product-info">
                                <a href="#" class="product-title">
                                    {!!   unserialize ($employer_notification->details)['newsfeed']['news'] !!}
                                    <span class="label label-warning pull-right">
                                        {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                    </span>
                                </a>
                                <span class="product-description">
                                    {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                </span>
                                by {{ unserialize($employer_notification->details)['adminuser']['name'] }}
                            </div>

                        </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="{{ route('backend.newsfeeds.history') }}" class="uppercase">View All NewsFeed Notifications</a>
                </div>
                <!-- /.box-footer -->
            </div>

        </div>

    </div>

    @endauth

</div>


@endsection

@section('after-scripts-end')

<script>

    $(document).ready(function () {

        socket.on('employer_staff.{{ auth()->user()->id }}:employer_notifications', function (data) {
            $('.employer-notitications .employer-notitications-list').append('<li class="item"><div class="product-info" style="margin-left: 25px;"><a class="product-title" href="#">' + data.eventDetails.job_title + '<span class="label label-warning pull-right">' + data.eventDetails.notification_type_text + '</span></a><span class="product-description">' + data.eventDetails.notification_type_text + '</span>' + data.eventDetails.created_by + '</div></li>');
        });

        socket.on('employer_project.{{ auth()->user()->id }}:project_notifications', function (data) {
            $('.employer-notitications .employer-notitications-list').append('<li class="item"><div class="product-info" style="margin-left: 25px;"><a class="product-title" href="#">' + data.eventDetails.project_title + '<span class="label label-warning pull-right">' + data.eventDetails.notification_type_text + '</span></a><span class="product-description">' + data.eventDetails.notification_type_text + '</span>' + data.eventDetails.created_by + '</div></li>');
        });

        socket.on('employer_task.{{ auth()->user()->id }}:task_notifications', function (data) {
            $('.employer-notitications .employer-notitications-list').append('<li class="item"><div class="product-info" style="margin-left: 25px;"><a class="product-title" href="#">' + data.eventDetails.task_title + '<span class="label label-warning pull-right">' + data.eventDetails.notification_type_text + '</span></a><span class="product-description">' + data.eventDetails.notification_type_text + '</span>' + data.eventDetails.created_by + '</div></li>');
        });

        socket.on('employer.{{ auth()->user()->id }}:newsfeed_notifications', function (data) {
            console.log(data);
            $('.newsfeed_notifications .newsfeed_notifications_list').append('<li class="item"><div class="product-info" style="margin-left: 25px;"><a class="product-title" href="#">' + data.eventDetails.newsfeed + '<span class="label label-warning pull-right">' + data.eventDetails.notification_type_text + '</span></a><span class="product-description">' + data.eventDetails.notification_type_text + '</span>' + data.eventDetails.created_by + '</div></li>');
        });

        socket.on('employer.{{ auth()->user()->id }}:company_notifications', function (data) {
            console.log(data);
            $('.employer-notitications .employer-notitications-list').append('<li class="item"><div class="product-info" style="margin-left: 25px;"><a class="product-title" href="#">' + data.eventDetails.company_title + '<span class="label label-warning pull-right">' + data.eventDetails.notification_type_text + '</span></a><span class="product-description">' + data.eventDetails.notification_type_text + '</span>' + data.eventDetails.created_by + '</div></li>');
        });

        $("#employer-scrolling-info").carousel();

    });

</script>



@endsection
