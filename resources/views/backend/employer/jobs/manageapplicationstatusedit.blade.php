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

    {!! Form::open(['route' => ['admin.employer.jobs.manage.applicationstatus.update', $job_application_status->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Real Name', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <label for="" disabled="disabled" class="form-control">{{ $job_application_real_name }}</label>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('name', 'Your version', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('name', ( old('name') ? old('name') : $job_application_status->name ), ['class' => 'form-control', 'placeholder' => 'Status Name']) !!}
        </div>
    </div><!--form control-->

    <div class="well">
        <div class="pull-left">
            <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    {!! Form::close() !!}


@stop