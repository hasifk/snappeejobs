@extends ('backend.layouts.master')

@section ('title', "Projects Details")

@section('page-header')
    <h1>
        Projects Edit Task
    </h1>
@endsection

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
                    @foreach($task->members as $member)
                        <option
                                value="{{ $member->user->id }}"
                                {{ old('members')
                                && in_array($member->user->id, old('members')) ? 'selected="selected"' : '' }}
                                {{ $task->members()->lists('user_id')->toArray() && in_array($member->user->id, $task->members()->lists('user_id')->toArray()) ? 'selected="selected"' : '' }}
                        >
                            {{ $member->user->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="well">
        <div class="pull-left">
            <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
    </div>

    {!! Form::close() !!}

    <div class="clearfix"></div>

@stop