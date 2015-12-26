@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        Employer Settings
        <small>Settings Dashboard</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.settings.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.settings.header-buttons')

    <h3>Settings Dashboard</h3>

    <div class="clearfix"></div>
@stop