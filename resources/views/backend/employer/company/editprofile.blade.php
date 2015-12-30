@extends ('backend.layouts.master')

@section ('title', 'Admin Company Profile')

@section('page-header')
    <h1>
        Employer Company Profile
        <small>View Company Profile</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a>
    </li>
    <li class="active">
        {!! link_to_route('admin.employer.company.showprofile', 'Company Profile' ) !!}
    </li>
@stop

@section('content')
    @include('backend.employer.includes.partials.company.header-buttons')

    <h3>Company Profile</h3>

    {!! Form::open(
    ['route' => 'admin.employer.company.updateprofile',
    'class' => 'form-horizontal',
    'role' => 'form',
    'method' => 'post'
    ]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title',
            old("title") ? old("title") : ( $company ? $company->title : '' ),
            ['class' => 'form-control',
            'placeholder' => 'Title']) !!}
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Company Size</label>
        <div class="col-lg-3">
            <div class="checkbox">
                <input
                        type="radio"
                        name="size"
                        id="size_small"
                        value="small" {{
                            old('size') ?
                            old('size') == 'small' ? 'checked="checked"' : ''
                                :
                            $company && $company->size == 'small' ? 'checked="checked"' : ''
                        }}
                />
                <label for="size_small">Small</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="size"
                        id="size_medium"
                        value="medium" {{
                            old('size') ?
                            old('size') == 'medium' ? 'checked="checked"' : ''
                                :
                            $company && $company->size == 'medium' ? 'checked="checked"' : ''
                        }}
                />
                <label for="size_medium">Medium</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="size"
                        id="size_big"
                        value="big" {{
                            old('size') ?
                            old('size') == 'big' ? 'checked="checked"' : ''
                                :
                            $company && $company->size == 'big' ? 'checked="checked"' : ''
                        }}
                />
                <label for="size_big">Big</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Industry</label>
        <div class="col-lg-10">
            @if (count($industries) > 0)
                @foreach($industries as $industry)
                    <input
                            type="checkbox"
                            value="{{$industry->id}}"
                            name="industry_company[]"
                            id="industry_company-{{$industry->id}}"
                            {{ old('industry_company')
                                && in_array($industry->id, old('industry_company')) ? 'checked="checked"' : '' }}
                            {{ !old('industry_company') && ( $company && $company->industries)
                                && in_array($industry->id, array_pluck($company->industries->toArray(), 'id')) ? 'checked="checked"' : '' }}
                    />
                    <label for="industry_company-{{$industry->id}}">
                        {!! $industry->name !!}
                    </label>
                    <br/>
                @endforeach
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Social Media Links</label>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <label for="social_media_twitter" class="col-lg-2">Twitter</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ ( $company && $company->socialmedia->count() > 0 ) && $company->socialmedia->first()->url ?
                            $company->socialmedia->first()->url : '' }}"
                    >
                    <br><br>
                    <label for="social_media_facebook" class="col-lg-2">Facebook</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ ( $company && $company->socialmedia->count() > 1 ) && $company->socialmedia()->skip(1)->take(1)->first()->url ?
                            $company->socialmedia()->skip(1)->take(1)->first()->url : '' }}"
                    >
                    <br><br>
                    <label for="social_media_instagram" class="col-lg-2">Instagram</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ ( $company && $company->socialmedia->count() > 2 ) && $company->socialmedia()->skip(2)->take(1)->first()->url ?
                            $company->socialmedia()->skip(2)->take(1)->first()->url : '' }}"
                    >
                    <br><br>
                    <label for="social_media_pinterest" class="col-lg-2">Pinterest</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ ( $company && $company->socialmedia->count() > 3 ) && $company->socialmedia()->skip(3)->take(1)->first()->url ?
                            $company->socialmedia()->skip(3)->take(1)->first()->url : '' }}"
                    >
                </div>
            </div>
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
                    old('description') : ( $company && $company->description ? $company->description : '' ) }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="what_it_does" class="col-lg-2 control-label">What it does</label>
        <div class="col-lg-10">
            <textarea
                    name="what_it_does"
                    cols="30"
                    rows="10"
                    class="form-control">{{ old('what_it_does') ?
                    old('what_it_does') : ( $company && $company->what_it_does ? $company->what_it_does : '' ) }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">Office Life</label>
        <div class="col-lg-10">
            <textarea
                    name="office_life"
                    cols="30"
                    rows="10"
                    class="form-control">{{ old('office_life') ?
                    old('office_life') : ( $company && $company->office_life ? $company->office_life : '' ) }}</textarea>
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
                            {{ $company && $company->state_id == $state->id ? 'selected="selected"' : '' }}
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
            <a
                    href="{{route('admin.access.users.index')}}"
                    class="btn btn-danger btn-xs">
                {{ trans('strings.cancel_button') }}
            </a>
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