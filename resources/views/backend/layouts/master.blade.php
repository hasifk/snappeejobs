<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('author', 'Anthony Rappa')">
        @yield('meta')

        @yield('before-styles-end')
        {!! HTML::style(elixir('css/backend.css')) !!}
        @yield('after-styles-end')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">
          @include('backend.includes.header')
          @include('backend.includes.sidebar')

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              @yield('page-header')
              <ol class="breadcrumb">
                @yield('breadcrumbs')
              </ol>
            </section>

            <!-- Main content -->
            <section class="content">
              @include('includes.partials.messages')
              @yield('content')
            </section><!-- /.content -->
          </div><!-- /.content-wrapper -->

          @include('backend.includes.footer')
        </div><!-- ./wrapper -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
        {!! HTML::script('js/vendor/bootstrap.min.js') !!}

        @yield('before-scripts-end')
        {!! HTML::script(elixir('js/backend.js')) !!}
        <script>

            var socket = io('http://{{ env('SOCKETIO_SERVER_IP', '127.0.0.1') }}:{{ env('SOCKETIO_SERVER_PORT', 7878) }}');

            socket.on('connect', function(){
                socket.on('disconnect', function(){
                    socket.socket.reconnectionDelay /= 2;
                });
            });

            var SnappeeJobs = new Vue({
                el: '.notifications-header',

                data: {
                    unread_messages: [],
                    job_applications: [],
                    tasks_assigned: [],
                    job_applications_order: -1
                },

                ready: function(){

                    var that = this;

                    $.post('{{ route('backend.notification.unread_messages') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                        that.unread_messages = data;
                    });

                    $.post('{{ route('backend.notification.job_applications') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                        that.job_applications = data;
                    });

                    $.post('{{ route('backend.notification.task_assigned') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                        that.tasks_assigned = data;
                    });

                    // Listening to the socket
                    socket.on('user.{{ auth()->user()->id }}:jobapplication-received', function(data){
                        that.job_applications.push(data.jobApplication);
                    });
                    socket.on('new_task.{{ auth()->user()->id }}:task-assigned', function(data){
                        that.tasks_assigned.push(data.eventDetails);
                    });

                }
            });
        </script>
        @yield('after-scripts-end')
    </body>
</html>
