@extends ('backend.layouts.master')

@section ('title', "Project")

@section('page-header')
    <h1>
        Projects Edit Task
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('admin.projects.index')!!}"><i class="fa fa-dashboard"></i> All Projects</a></li>
    <li>{!! link_to_route('admin.projects.show', $task->projectname, $task->project_id) !!}</li>
    <li class="active">{!! link_to_route('admin.projects.showtask', $task->title, $task->id) !!}</li>
@stop

@section('content')

    @include('backend.projects.includes.partials.header-buttons')

    {!! Form::open(['route' => ['admin.projects.updatetask', $task->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title', ( old('title') ? old('title') : $task->title ), ['class' => 'form-control', 'placeholder' => 'Task Title']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('members', 'Assigned Members', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <select
                    name="members[]"
                    id="members"
                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                    multiple="multiple"
                    style="width: 100%;"
            >
                @if (count($task->members) > 0)
                    @foreach($project_members as $member)
                        <option
                                value="{{ $member->id }}"
                                {{ old('members')
                                && in_array($member->id, old('members')) ? 'selected="selected"' : '' }}
                                {{ $task->members()->lists('user_id')->toArray() && in_array($member->id, $task->members()->lists('user_id')->toArray()) ? 'selected="selected"' : '' }}
                        >
                            {{ $member->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="well">
        <div class="pull-left">
            <a href="{{route('backend.dashboard')}}" class="btn btn-danger btn-xs">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
    </div>

    {!! Form::close() !!}

    <div class="clearfix"></div>

@stop