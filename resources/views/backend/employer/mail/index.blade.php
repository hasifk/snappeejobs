@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        Mail
        <small>Mail Dashboard</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.mail.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.mail.header-buttons')

    <h3>Mail Dashboard</h3>

    <div class="clearfix"></div>
@stop