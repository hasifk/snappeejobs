@extends('frontend.layouts.masternew')

@section('search_div')


    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">

                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="@if(!request()->has('search')) active @endif"><a href="#browse_jobs" aria-controls="browse_jobs" role="tab" data-toggle="tab">Browse</a></li>
                        <li role="presentation" class="@if(request()->has('search')) active @endif"><a href="#search_jobs" aria-controls="search_jobs" role="tab" data-toggle="tab">Search and Filter</a></li>
                    </ul>
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane @if(!request()->has('search')) active @endif" id="browse_jobs">
                            &nbsp;
                        </div>
                        <div role="tabpanel" class="tab-pane @if(request()->has('search')) active @endif" id="search_jobs">

                            <div class="com-search">

                                <div class="row" id="job_search">

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
                                                <div class="col-sm-3 col-md-2 search-btn">
                                                    <button type="submit" class="btn btn-primary">
                                                        <img src="/images/lens-icon.png"> Search
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <br>
                <br>
    </div>

@endsection

@section('content')

    <section>

        <div class="bodycontent">

            <div class="container cnt-body">

                <div class="row">

                    <div class="col-md-10 col-md-offset-1 col-sm-12 companies">

                        <h1>Explore Jobs</h1>

                        <div class="row">

                            @if (count($jobs) > 0)

                                @foreach($jobs as $job)

                                    <div class="col-sm-6 col-md-4 thumbs">
                                        @if ( $job->company->photos->count() )
                                            <div> <img src="{{env('APP_S3_URL') .$job->company->photos->first()->path . $job->company->photos->first()->filename . '620x412.' . $job->company->photos->first()->extension }}" /></div>
                                        @else
                                            <div> <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=620%C3%97412&w=620&h=412" /></div>
                                            {{--<div><img src="images/companies/thumbtack.jpg" /></div>--}}
                                        @endif
                                        <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}"> <h2> {{ $job->title }}</h2></a>
                                        <a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                            <h5>{{ str_studly($job->company->title) }}</h5>
                                        </a>
                                        <p>
                                            @foreach($job->categories as $category) {{ $category->name }} | @endforeach
                                                | {{ str_studly($job->level) }}
                                                | @foreach($job->skills as $skill) {{ $skill->name }} @endforeach
                                                | {{ $job->country->name }} | {{ $job->state->name }}
                                        </p>
                                    </div>

                                @endforeach

                                    <div class="pages">
                                        <div class="col-sm-7">
                                            <ul class="pagination">
                                                {!! $paginator->render() !!}
                                            </ul>
                                        </div>

                                    </div>

                            @else

                                <h3 style="margin-bottom: 100px;" class="text-center">No Jobs found</h3>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@section('after-scripts-end')
    <script>

        var isSearchPage = function(){
            return window.location.href.search("[?&]search=") != -1;
        };

        var getNextURL = function(){
            return isSearchPage() ? '{{ request()->route()->getUri() }}' : '{{ request()->route()->getUri() }}?search=1'
        }

        $(document).ready(function(){
            $('#country_id').on('change', function(){
                $.getJSON('/get-states/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });

            $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                if (  $(e.target).attr('href') == '#browse_jobs' ) {
                    history.pushState({}, 'Snappeejobs Browse Jobs', getNextURL());
                } else if ( $(e.target).attr('href') == '#search_jobs' ) {
                    history.pushState({}, 'Snappeejobs Search Jobs', getNextURL());
                }
            })

        });
    </script>
@endsection
