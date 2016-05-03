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

@roles(['Employer', 'Employer Staff'])
@section('content')
    <div class="row">







        @if (!empty($cmp_interest_map_info))
            <div class="box-body no-padding">

                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <div class="pad">
                            <h3>{{ trans('strings.backend.dashboard_cmp_interest_map') }}</h3>
                            <!-- Map will be created here -->
                            <div id="world-map-markers" style="width: 500px;height: 400px; background-color: #CCC;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>



@endsection

@section('after-scripts-end')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfE_cndXYeZfY4bK1R9LKq50YxicFVZF4
        &callback=initMap">
    </script>
    @if (!empty($cmp_interest_map_info))
        <?php $latlong= explode("_",$latlong); ?>

        <script>

            function initMap() {
                var map = new google.maps.Map(document.getElementById('world-map-markers'), {
                    zoom: 10,
                    center: {lat:<?php echo $latlong[0]; ?>, lng: <?php echo $latlong[1]; ?>},
                    disableDefaultUI: true
                });

                setMarkers(map);
            }

            // Data for the markers consisting of a name, a LatLng and a zIndex for the
            // order in which these markers should display on top of each other.
            //var beaches= [];

            var beaches =<?php echo $cmp_interest_map_info; ?>;




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

                    marker.addListener('click', function () {
                        map.setZoom(8);
                        map.setCenter(marker.getPosition());
                    });
                }
            }

            $(".owl-carousel").owlCarousel({
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
                autoHeight: true
            });

        </script>

    @endif

@endsection
@endauth