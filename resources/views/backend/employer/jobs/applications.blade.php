@extends ('backend.layouts.master')

@section ('title', "Job Management - Job Applications")

@section('page-header')
    <h1>
        Add New Job
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
            <th>Job</th>
            <th>JobSeeker</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($jobapplications as $jobapplication)
            <tr>
                <td>{{ $jobapplication->job->title }}</td>
                <td>{{ $jobapplication->jobseeker->name }}</td>
                <td>{!! $jobapplication->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {{ $jobapplications->total() }} job(s) total
    </div>

    <div class="pull-right">
        {!! $jobapplications->render() !!}
    </div>

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
