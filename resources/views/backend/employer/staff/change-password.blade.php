@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        Staff Management
        <small>Change Password</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('admin.employer.staffs.index')!!}"><i class="fa fa-dashboard"></i> Staff Management</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Create Staff' ) !!}</li>
@stop

@section('content')

    @include('backend.employer.includes.partials.staffs.header-buttons')

    {!! Form::open(['route' => ['admin.employer.staffs.change-password', $user->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        <label class="col-lg-2 control-label">Password</label>
        <div class="col-lg-10">
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">Confirm Password</label>
        <div class="col-lg-10">
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>
    </div><!--form control-->

    <div class="well">
        <div class="pull-left">
            <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">Cancel</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="Save" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    {!! Form::close() !!}

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    {!! HTML::script('js/backend/access/permissions/script.js') !!}
    {!! HTML::script('js/backend/access/users/script.js') !!}
@stop