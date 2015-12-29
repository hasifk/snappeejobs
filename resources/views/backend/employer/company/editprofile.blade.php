@extends ('backend.layouts.master')

@section ('title', 'Admin Company Profile')

@section('page-header')
    <h1>
        Employer Company Profile
        <small>View Company Profile</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.company.showprofile', 'Company Profile' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.company.header-buttons')

    <h3>Company Profile</h3>

    {!! Form::open(['route' => 'admin.employer.company.updateprofile', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Company Size</label>
        <div class="col-lg-3">
            <div class="checkbox">
                <input type="radio" name="size" value="small" />
                Small
            </div>
            <div class="checkbox">
                <input type="radio" name="size" value="medium" />
                Medium
            </div>
            <div class="checkbox">
                <input type="radio" name="size" value="big" />
                Big
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Industry</label>
        <div class="col-lg-10">
            <select name="industries" id="industries" class="form-control" multiple>
                @foreach($industries as $industry)
                    <option
                            value="{{ $industry->id }}"
                            {{ $company && $company->industry_id == $industry->id ? 'selected="selected"' : '' }}
                    >
                        {{ $industry->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Description</label>
        <div class="col-lg-10">
            <textarea name="description" cols="30" rows="10" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="what_it_does" class="col-lg-2 control-label">What it does</label>
        <div class="col-lg-10">
            <textarea name="what_it_does" cols="30" rows="10" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">Office Life</label>
        <div class="col-lg-10">
            <textarea name="office_life" cols="30" rows="10" class="form-control"></textarea>
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
                            {{ $company && $company->country_id == $country->id ? 'selected="selected"' : '' }}
                            {{ $company && !$company->country_id && $country->id == 222 ? 'selected="selected"' : '' }}
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
                            {{ $company && $company->state_id == $state->id ? 'selected="selected"' : '' }}
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