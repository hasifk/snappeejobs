@extends ('backend.layouts.master')

@section ('title', "Job Management")

@section('page-header')
    <h1>
        Deleted Jobs
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Staff Management' ) !!}</li>
@stop

@section('content')

    @include('backend.employer.includes.partials.jobs.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Level</th>
            <th>Status</th>
            <th>Published</th>
            <th>Likes</th>
            <th>Country</th>
            <th>State</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ ucfirst($job->level) }}</td>
                <td>{!! $job->status_text !!}</td>
                <td>{!! $job->published_text !!}</td>
                <td>{{ $job->likes }}</td>
                <td>{{ $job->country_name }}</td>
                <td>{{ $job->state_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {{ $jobs->total() }} job(s) total
    </div>

    <div class="pull-right">
        {!! $jobs->render() !!}
    </div>

    <div class="clearfix"></div>
@stop

