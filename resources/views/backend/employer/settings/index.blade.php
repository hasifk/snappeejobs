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

    @if($subscribed)
        You are subscribed to the plan <span class="badge">{{ $plan['name'] }}</span>
        <br>
        <br>
        Want to upgrade ? <a class="btn btn-primary btn-xs" href="{{ route('admin.employer.settings.chooseplanupgrade') }}">Upgrade</a>

    @else
        You have not subscribed to any plans yet, to do so, please go to
        <a class="btn btn-primary btn-xs" href="{{ route('admin.employer.settings.plan') }}">Payment</a>
    @endif

    <div class="clearfix"></div>
@stop