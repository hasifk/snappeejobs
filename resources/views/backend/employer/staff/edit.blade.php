@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        Create Employer Staff
        <small>Create Staff</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('admin.employer.staffs.index')!!}"><i class="fa fa-dashboard"></i> Staff Management</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Create Staff' ) !!}</li>
@stop

@section('content')

    @include('backend.employer.includes.partials.staffs.header-buttons')

    {!! Form::open(['route' => ['admin.employer.staffs.update', $user->id ], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => trans('strings.full_name')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('gender', "Gender", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="checkbox">
                <input
                        type="radio"
                        name="gender"
                        id="gender_male"
                        value="male" {{ old('gender') == 'male' ? 'checked="checked"' : '' }}
                        {{$user->gender == 'male' ? 'checked="checked"' : ''}}
                />
                <label for="gender_male">Male</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="gender"
                        id="gender_female"
                        value="female" {{ old('gender') == 'female' ? 'checked="checked"' : '' }}
                        {{$user->gender == 'female' ? 'checked="checked"' : ''}}
                />
                <label for="gender_female">Female</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('age', "Age", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('age', $user->age, ['class' => 'form-control', 'placeholder' => "Age"]) !!}
        </div>
    </div>

    @if ($user->id != 1)
        <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
            <div class="col-lg-1">
                <input type="checkbox" value="1" name="status" {{$user->status == 1 ? 'checked' : ''}} />
            </div>
        </div><!--form control-->

        <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.confirmed') }}</label>
            <div class="col-lg-1">
                <input type="checkbox" value="1" name="confirmed" {{$user->confirmed == 1 ? 'checked' : ''}} />
            </div>
        </div><!--form control-->

        <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.associated_roles') }}</label>
            <div class="col-lg-3">
                @if (count($roles) > 0)
                    @foreach($roles as $role)
                        <input type="checkbox" value="{{$role->id}}" name="assignees_roles[]" {{in_array($role->id, $user_roles) ? 'checked' : ''}} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{!! $role->name !!}</label> <a href="#" data-role="role_{{$role->id}}" class="show-permissions small">(<span class="show-hide">Show</span> Permissions)</a><br/>

                        <div class="permission-list hidden" data-role="role_{{$role->id}}">
                            @if ($role->all)
                                All Permissions<br/><br/>
                            @else
                                @if (count($role->permissions) > 0)
                                    <blockquote class="small">{{--
                                            --}}@foreach ($role->permissions as $perm){{--
                                            --}}{{$perm->display_name}}<br/>
                                        @endforeach
                                    </blockquote>
                                @else
                                    No permissions<br/><br/>
                                @endif
                            @endif
                        </div><!--permission list-->
                    @endforeach
                @else
                    No Roles to set
                @endif
            </div>
        </div><!--form control-->

    @endif

    <div class="well">
        <div class="pull-left">
            <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    @if ($user->id == 1)
        {!! Form::hidden('status', 1) !!}
        {!! Form::hidden('confirmed', 1) !!}
        {!! Form::hidden('assignees_roles[]', 1) !!}
    @endif

    {!! Form::close() !!}

    <div class="clearfix"></div>
@stop