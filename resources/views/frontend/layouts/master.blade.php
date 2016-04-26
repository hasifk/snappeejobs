<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'SNAP - The best way to find a job')">
        <meta name="author" content="@yield('author', 'Silverbloom Technologies')">
        @yield('meta')

        @yield('before-styles-end')
        {!! HTML::style(elixir('css/frontend.css')) !!}
        @yield('after-styles-end')

    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        @include('frontend.includes.nav')

        @include('frontend.includes.alerts')

        <div class="container-fluid">
            @include('includes.partials.messages')
            @yield('content')
        </div><!-- container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
        {!! HTML::script('js/vendor/bootstrap.min.js') !!}

        @yield('before-scripts-end')
        {!! HTML::script(elixir('js/frontend.js')) !!}
        <script>

            @if(auth()->user())

            var socket = io('http://{{ env('SOCKETIO_SERVER_IP', '127.0.0.1') }}:{{ env('SOCKETIO_SERVER_PORT', 8000) }}');

            var SnappeeJobsHeader = new Vue({
                el: '.notifications-header',

                data: {
                    unread_messages: [],
                    rejected_applications: [],
                    unread_messages_order: -1,
                    rejected_applications_order: -1
                },

                ready: function(){

                    var that = this;

                    $.post('{{ route('frontend.notification.unreadchats') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                        if ( data.length ) {
                            that.unread_messages = data;
                        }
                    });

                    $.post('{{ route('frontend.notification.rejected_applications') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                        if ( data.length ) {
                            that.rejected_applications = data;
                        }
                    });

                    // Listening to the socket
                    socket.on('user.{{ auth()->user()->id }}:employerchat-received', function(data){
                        that.unread_messages.push(data.message_details)
                    });

                },

                methods: {
                    mark_rejected_applications_read: function(){
                        $.post('{{ route('frontend.notification.rejected_applications_mark_read') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){

                        });
                    }
                }
            });

            @endif
        </script>
        @yield('after-scripts-end')

        {{--@include('includes.partials.ga')--}}
        @include('sweet::alert')
    </body>
</html>
