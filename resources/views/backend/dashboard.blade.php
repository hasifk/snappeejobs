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

            <div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-captions" data-slide-to="0" class=""></li>
                    <li data-target="#carousel-example-captions" data-slide-to="1" class="active"></li>
                    <li data-target="#carousel-example-captions" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item">

                        <div class="carousel-caption"><h3>First slide label</h3>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>

                        </div>
                    </div>
                    <div class="item active">
                        <div class="carousel-caption"><h3>Second slide label</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="carousel-caption"><h3>Third slide label</h3>
                            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p></div>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-captions" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span>
                </a> <a class="right carousel-control" href="#carousel-example-captions" role="button"
                        data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span> </a></div>

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

        <div class="box-body no-padding">

            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="pad">
                        <h3>{{ trans('strings.backend.dashboard_interest_map') }}</h3>
                        <!-- Map will be created here -->
                        <div id="world-map-markers" style="width: 500px;height: 400px; background-color: #CCC;"></div>
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

            $("#employer-scrolling-info").carousel();

        });

    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfE_cndXYeZfY4bK1R9LKq50YxicFVZF4
&callback=initMap">
    </script>


    <script>
        
        function initMap() {
            var map = new google.maps.Map(document.getElementById('world-map-markers'), {
                zoom: 10,
                center: {lat: -33.9, lng: 151.2}
            });

            setMarkers(map);
        }

        // Data for the markers consisting of a name, a LatLng and a zIndex for the
        // order in which these markers should display on top of each other.

                @if (count($interest_map_info) > 0)
        var beaches=<?php echo $interest_map_info; ?>;
        @endif

        function setMarkers(map) {
            // Adds markers to the map.

            // Marker sizes are expressed as a Size of X,Y where the origin of the image
            // (0,0) is located in the top left of the image.

            // Origins, anchor positions and coordinates of the marker increase in the X
            // direction to the right and in the Y direction down.
            var image = {
                url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                // This marker is 20 pixels wide by 32 pixels high.
                size: new google.maps.Size(20, 32),
                // The origin for this image is (0, 0).
                origin: new google.maps.Point(0, 0),
                // The anchor for this image is the base of the flagpole at (0, 32).
                anchor: new google.maps.Point(0, 32)
            };
            // Shapes define the clickable region of the icon. The type defines an HTML
            // <area> element 'poly' which traces out a polygon as a series of X,Y points.
            // The final coordinate closes the poly by connecting to the first coordinate.
            var shape = {
                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: 'poly'
            };

            for (var i = 0; i < beaches.length; i++) {
                var beach = beaches[i];
                var marker = new google.maps.Marker({
                    position: {lat: parseFloat(beach.latitude), lng: parseFloat(beach.longitude)},
                    map: map,
                    icon: image,
                    shape: shape,
                    title: beach.country

                });

            }

        }


    </script>

@endsection