@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="col-md-12">
            <div class="box box-default box-solid {{ request('search') ? '' : 'collapsed-box' }}">
                <div class="box-header with-border">
                    <h3 class="box-title">Search</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{{ request('search') ? 'minus' : 'plus' }}"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: {{ request('search') ? 'block' : 'none' }};">
                    <form role="form" action="{{ route('jobs.search') }}">

                        <input type="hidden" name="search" value="1">

                        <div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <div class="checkbox">
                                        <input
                                                type="radio"
                                                name="level"
                                                id="level_internship"
                                                value="internship" {{ request('level') == 'internship' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_internship">Internship</label>
                                        &nbsp;
                                        <input
                                                type="radio"
                                                name="level"
                                                id="level_entry"
                                                value="entry" {{ request('level') == 'entry' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_entry">Entry</label>
                                        &nbsp;
                                        <input
                                                type="radio"
                                                name="level"
                                                id="level_mid"
                                                value="mid" {{ request('level') == 'mid' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_mid">Mid</label>
                                        &nbsp;
                                        <input
                                                type="radio"
                                                name="level"
                                                id="level_senior"
                                                value="senior" {{ request('level') == 'senior' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_senior">Senior</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categories">Companies</label>
                                    <select
                                            name="companies[]"
                                            id="companies"
                                            class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                            multiple="multiple"
                                            style="width: 100%;"
                                    >
                                        @if (count($companies) > 0)
                                            @foreach($companies as $company)
                                                <option
                                                        value="{{ $company->id }}"
                                                        {{ request('companies')
                                                        && in_array($company->id, request('companies')) ? 'selected="selected"' : '' }}
                                                >
                                                    {{ $company->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categories">Categories</label>
                                    <select
                                            name="categories[]"
                                            id="categories"
                                            class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                            multiple="multiple"
                                            style="width: 100%;"
                                    >
                                        @if (count($categories) > 0)
                                            @foreach($categories as $category)
                                                <option
                                                        value="{{ $category->id }}"
                                                        {{ request('categories')
                                                        && in_array($category->id, request('categories')) ? 'selected="selected"' : '' }}
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="skills">Skills</label>
                                    <select
                                            name="skills[]"
                                            id="skills"
                                            class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                            multiple="multiple"
                                            style="width: 100%;"
                                    >
                                        @if (count($skills) > 0)
                                            @foreach($skills as $skill)
                                                <option
                                                        value="{{ $skill->id }}"
                                                        {{ request('skills')
                                                        && in_array($skill->id, request('skills')) ? 'selected="selected"' : '' }}
                                                >
                                                    {{ $skill->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_id">Country</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($countries as $country)
                                            <option
                                                    value="{{ $country->id }}"
                                                    {{ request('country_id') && $country->id == request('country_id') ? 'selected="selected"' : '' }}
                                            >
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state_id">State</label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($states as $state)
                                            <option
                                                    value="{{ $state->id }}"
                                                    {{ request('state_id') && $state->id == request('state_id') ? 'selected="selected"' : '' }}
                                            >
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md12">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-6">
            <h4>Jobs</h4>
        </div>
        <div class="col-md-6">
            <div class="dropdown pull-right">
                Sorted by
                <button class="btn btn-default dropdown-toggle" type="button" id="sortingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    @if ( is_null(request()->get('sort')) )
                        Newest
                    @else
                        {{ (request()->get('sort') == 'created_at') ? 'Newest' : 'Popular' }}
                    @endif
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortingMenu">
                    <li><a href="
                    @if ( request()->get('sort') == 'likes' )
                    {{ route('jobs.search', array_merge(request()->except('sort'), ['sort' => 'created_at'])) }}
                    @elseif ( request()->get('sort') == 'created_at' )
                    {{ route('jobs.search', array_merge(request()->except('sort'), ['sort' => 'likes'])) }}
                    @else
                        {{ route('jobs.search', array_merge(request()->except('sort'), ['sort' => 'likes'])) }}
                    @endif
                                ">
                            @if ( is_null(request()->get('sort')) )
                                Popular
                            @else
                                {{ (request()->get('sort') == 'created_at') ? 'Popular' : 'Newest' }}
                            @endif
                        </a></li>
                </ul>
            </div>
        </div>

        <div class="clearfix"></div>

        @foreach($jobs as $job)
            <div class="col-md-4">
                <div class="job-card">
                    <div class="row">
                        <div class="col-md-12 heading">
                            <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                        </div>
                        <div class="col-md-12">

                        </div>
                        <div class="col-md-12 sub-heading">
                            <a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                {{ str_studly($job->company->title) }}
                            </a>
                            <br>
                            <span class="label label-danger">
                                <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                    {{ str_studly($job->level) }}
                                </a>
                            </span>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @foreach($job->categories as $category)
                                <div class="label label-info">
                                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @foreach($job->skills as $skill)
                                <div class="label label-success">
                                    <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                        {{ $skill->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <div for="" class="label label-info">
                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                    {{ $job->country->name }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div for="" class="label label-info">
                                <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                    {{ $job->state->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-md-12 center-block">
            {!! $paginator->render() !!}
        </div>

    </div>

@endsection

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