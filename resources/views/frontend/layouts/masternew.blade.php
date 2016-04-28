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

    @include('frontend.includes.nav_new')

    <div class="container">
        @include('frontend.includes.alerts')
    </div>

    <div class="container">
        @include('includes.partials.messages')
    </div>

    @yield('content')

    @include('frontend.includes.footer')

    @yield('before-scripts-end')

    {!! HTML::script(elixir('js/frontend.js')) !!}

    @include('frontend.includes.notification_code')

    @yield('after-scripts-end')

    @include('sweet::alert')

</body>
</html>
