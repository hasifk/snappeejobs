@extends ('backend.layouts.master')

@section ('title', "Job Management")

@section('page-header')
    <h1>
        Jobs Management
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Staff Management' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.jobs.header-buttons')



    <div class="clearfix"></div>
@stop