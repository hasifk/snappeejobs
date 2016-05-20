@extends ('backend.layouts.master')

@section ('title', "Projects Details")

@section('page-header')
    <h1>
        Projects Assign Tasks
    </h1>
@endsection

@section('content')

    @include('backend.projects.includes.partials.header-buttons')

    {!! Form::open(['route' => ['admin.projects.createtask', $project_id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title', ( old('title') ? old('title') : '' ), ['class' => 'form-control', 'placeholder' => 'Task Title']) !!}
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
                @if (count($members) > 0)
                    @foreach($members as $member)
                        <option
                                value="{{ $member->id }}"
                                {{ old('members')
                                && in_array($member->id, old('members')) ? 'selected="selected"' : '' }}
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

    <h5><b>Tasks in this project</b></h5>

    <table class="table">
        <tr>
            <th>Title</th>
            <th>Members</th>
        </tr>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->allmembers }}</td>
            <td>
                <a href="{{ route('admin.projects.edittask', $task->id) }}" class="btn btn-xs btn-info">
                    <i
                        class="fa fa-pencil"
                        data-toggle="tooltip"
                        data-placement="top"
                        title=""
                        data-original-title="Edit this task"
                    ></i>
                </a>
                <a href="{{ route('admin.projects.deletetask', $task->id) }}" data-method="delete" class="btn btn-xs btn-danger">
                    <i
                            class="fa fa-trash"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Delete this task"
                            data-original-title="Delete this task"
                    ></i>
                </a>
            </td>
        </tr>
        @endforeach
    </table>

@stop