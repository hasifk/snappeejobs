@extends ('backend.layouts.master')

@section ('title', "Job Management")

@section('page-header')
    <h1>
        Manage Job Application Statuses
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Staff Management' ) !!}</li>
@stop

@section('content')


    <div style="margin-bottom:10px;">
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Menu
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{route('admin.employer.jobs.index')}}">
                        Jobs
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>

    <table class="table">
        @foreach($job_application_statuses as $job_application_status)
        <tr>
            <td>{{ $job_application_status->name }}</td>
            <td>
                <a href="{{ route('admin.employer.jobs.manage.applicationstatus.edit', $job_application_status->id) }}" class="btn btn-primary">Edit the text</a>
            </td>
        </tr>
        @endforeach
    </table>

@stop