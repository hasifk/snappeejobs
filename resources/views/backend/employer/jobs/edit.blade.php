@extends ('backend.layouts.master')

@section ('title', "Job Management")

@section('page-header')
    <h1>
        Edit Job
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Staff Management' ) !!}</li>
@stop

@section('content')

    @include('backend.employer.includes.partials.jobs.header-buttons')

    {!! Form::open(['route' => [ 'admin.employer.jobs.update', $job->id ], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title', ( old('title') ? old('title') : $job->title ), ['class' => 'form-control', 'placeholder' => 'Job Title']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">Level</label>
        <div class="col-lg-3">
            <div class="checkbox">
                <input
                        type="radio"
                        name="level"
                        id="level_internship"
                        value="internship" {{
                            old('level') ? old('level') == 'internship' ? 'checked="checked"' : '' :
                            $job && $job->level == 'internship' ? 'checked="checked"' : ''
                        }}
                />
                <label for="level_internship">Internship</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="level"
                        id="level_entry"
                        value="entry" {{
                            old('level') ? old('level') == 'entry' ? 'checked="checked"' : '' :
                            $job && $job->level == 'entry' ? 'checked="checked"' : ''
                        }}
                />
                <label for="level_entry">Entry</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="level"
                        id="level_mid"
                        value="mid" {{
                            old('level') ? old('level') == 'mid' ? 'checked="checked"' : '' :
                            $job && $job->level == 'mid' ? 'checked="checked"' : ''
                        }}
                />
                <label for="level_mid">Mid</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="level"
                        id="level_senior"
                        value="senior" {{
                            old('level') ? old('level') == 'senior' ? 'checked="checked"' : '' :
                            $job && $job->level == 'senior' ? 'checked="checked"' : ''
                        }}
                />
                <label for="level_senior">Senior</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Categories the job belong to</label>
        <div class="col-lg-10">
            @if (count($job_categories) > 0)
                @foreach($job_categories as $job_category)
                    <input
                            type="checkbox"
                            value="{{$job_category->id}}"
                            name="job_category[]"
                            id="job_category-{{$job_category->id}}"
                            {{ old('job_category')
                                && in_array($job_category->id, old('job_category')) ? 'checked="checked"' : '' }}
                            {{ !old('job_category') && ( $job && $job->categories)
                                && in_array($job_category->id, array_pluck($job->categories->toArray(), 'id')) ? 'checked="checked"' : '' }}
                    />
                    <label for="job_category-{{$job_category->id}}">
                        {!! $job_category->name !!}
                    </label>
                    <br/>
                @endforeach
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Description</label>
        <div class="col-lg-10">
            <textarea
                    name="description"
                    cols="30"
                    rows="10"
                    class="form-control">{{ old('description') ?
                    old('description') : ( $job && $job->description ? $job->description : '' ) }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">Country</label>
        <div class="col-lg-10">
            <select name="country_id" id="country_id" class="form-control">
                <option value="">Please select</option>
                @foreach($countries as $country)
                    <option
                            value="{{ $country->id }}"
                            {{ $job && $job->country_id == $country->id ? 'selected="selected"' : '' }}
                            {{ $job && !$job->country_id && $country->id == 222 ? 'selected="selected"' : '' }}
                            {{ old('country_id') && $country->id == old('country_id') ? 'selected="selected"' : '' }}
                    >
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">State</label>
        <div class="col-lg-10">
            <select name="state_id" id="state_id" class="form-control">
                <option value="">Please select</option>
                @foreach($states as $state)
                    <option
                            value="{{ $state->id }}"
                            {{ $job && $job->state_id == $state->id ? 'selected="selected"' : '' }}
                            {{ old('state_id') && $state->id == old('state_id') ? 'selected="selected"' : '' }}
                    >
                        {{ $state->name }}
                    </option>
                @endforeach
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
    </div><!--well-->

    {!! Form::close() !!}

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#country_id').on('change', function(){
                $.getJSON('/admin/get-states/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });
        });
    </script>
@endsection