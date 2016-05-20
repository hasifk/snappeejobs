@extends ('backend.layouts.master')

@section ('title', "Project")

@section('page-header')
    <h1>
        Projects Details - {{ $project->title }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('admin.projects.index')!!}"><i class="fa fa-dashboard"></i> All Projects</a></li>
    <li>{!! link_to_route('admin.projects.show', $project->title, $project->id) !!}</li>
    <li>{!! link_to_route('admin.projects.edit', "Edit this project", $project->id) !!}</li>
@stop


@section('content')

    @include('backend.projects.includes.partials.header-buttons')

    {!! Form::open(['route' => ['admin.projects.update', $project->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'patch']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title', ( old('title') ? old('title') : $project->title ), ['class' => 'form-control', 'placeholder' => 'Project']) !!}
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
                                {{ !old('members') && ( $project && $project_members)
                                && in_array($member->id, $project_members) ? 'selected="selected"' : '' }}
                        >
                            {{ $member->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('job_listings', 'Job Listings', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <select
                    name="job_listings[]"
                    id="job_listings"
                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                    multiple="multiple"
                    style="width: 100%;"
            >
                @if (count($job_listings) > 0)
                    @foreach($job_listings as $job_listing)
                        <option
                                value="{{ $job_listing->id }}"
                                {{ old('job_listings')
                                && in_array($job_listing->id, old('job_listings')) ? 'selected="selected"' : '' }}
                                {{ !old('job_listings') && ( $project && $project_job_listings)
                                && in_array($job_listing->id, $project_job_listings) ? 'selected="selected"' : '' }}
                        >
                            {{ $job_listing->title }}
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
    </div><!--well-->

    {!! Form::close() !!}

    <div class="clearfix"></div>
@stop