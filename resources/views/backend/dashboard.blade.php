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
                                    @if( ($employer_notification->notification_type == 'job_created') || ($employer_notification->notification_type == 'job_updated') || ($employer_notification->notification_type == 'job_deleted') )
                                        <div style="margin-left: 25px;" class="product-info">
                                            <a href="#" class="product-title">
                                                {{ unserialize($employer_notification->details)['job']->title }}
                                                <span class="label label-warning pull-right">
                                                {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                            </span>
                                            </a>
                                            <span class="product-description">
                                              {{ ucwords(str_replace('_', " ", $employer_notification->notification_type)) }}
                                            </span>
                                            by {{ unserialize($employer_notification->details)['user']->name }}
                                        </div>
                                    @endif
                                </li>

                            @endforeach

                        </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="#" class="uppercase">View All Notifications</a>
                    </div>
                    <!-- /.box-footer -->
                </div>

            </div>

        </div>


        <div class="col-md-6">
            <div id="employer-scrolling-info" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#employer-scrolling-info" data-slide-to="0" class=""></li>
                    <li data-target="#employer-scrolling-info" data-slide-to="1" class="active"></li>
                    <li data-target="#employer-scrolling-info" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item">
                        Total Visitors for Company: {{$visitors}}
                    </div>
                    <div class="item">
                        Total Active Job Openings:{{$active_job_listings1}}
                    </div>
                    <div class="item">
                        Active Job Openings:{{ $total_jobs_posted }}
                    </div>
                </div>
            </div>
        </div>

        @endauth

    </div>

@endsection

@section('after-scripts-end')

    <script>

        $(document).ready(function(){

            socket.on('employer_staff.{{ auth()->user()->id }}:employer_notifications', function(data){
                $('.employer-notitications .employer-notitications-list').append('<li class="item"><div class="product-info" style="margin-left: 25px;"><a class="product-title" href="#">'+ data.eventDetails.job_title +'<span class="label label-warning pull-right">'+ data.eventDetails.notification_type_text +'</span></a><span class="product-description">'+ data.eventDetails.notification_type_text +'</span>'+ data.eventDetails.created_by +'</div></li>');
            });

        });

    </script>

@endsection