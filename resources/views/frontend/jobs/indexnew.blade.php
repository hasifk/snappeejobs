@extends('frontend.layouts.masternew')

@section('content')

<section>
    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">

                <div>
                    <h1>Explore Jobs</h1>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="@if(!request()->has('search')) active @endif"><a href="#browse_jobs" aria-controls="browse_jobs" role="tab" data-toggle="tab">Browse</a></li>
                        <li role="presentation" class="@if(request()->has('search')) active @endif"><a href="#search_jobs" aria-controls="search_jobs" role="tab" data-toggle="tab">Search and Filter</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane @if(!request()->has('search')) active @endif" id="browse_jobs">
                    <div class="row">
                        @if (count($jobs) > 0)
                            @foreach($jobs as $job)
                                @if($job->paid_expiry > \Carbon\Carbon::now())
                        <div class="col-sm-6 col-md-4 thumbs">
                            @if ( $job->company->photos->count() )
                                <div> <img src="{{env('APP_S3_URL') .$job->company->photos->first()->path . $job->company->photos->first()->filename . '620x412.' . $job->company->photos->first()->extension }}" /></div>
                            {{--<div><img src="images/companies/thumbtack.jpg" /></div>--}}
                            @endif
                          <div><a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}"> <h2> {{ $job->title }}</h2></a></div>
                            <div><a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                <h2>{{ str_studly($job->company->title) }}</h2></a></div>
                            <div> <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                   <p>{{ str_studly($job->level) }}</p>
                                </a></div>

                          <div>
                              @foreach($job->categories as $category)
                              <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                <p>{{ $category->name }}</p>
                            </a>
                              @endforeach
                          </div>
                            <div>
                                @foreach($job->skills as $skill)
                                    <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                       <p>{{ $skill->name }}</p>
                                    </a>
                                @endforeach
                            </div>

                           <div>
                            <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                               <p> {{ $job->country->name }}</p></a>
                           </div>
                            <div>
                            <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                <p>{{ $job->state->name }}</p>
                            </a>
                            </div>
                        </div>
                                @endif
                            @endforeach
                        @endif

                        <div class="pages">
                            <div class="col-sm-7">
                                <ul class="pagination">
                                    <li><a href="#"><img src="images/pg-left-arrow.png" /></a></li>
                                    {!! $paginator->render() !!}
                                    <li><a href="#"><img src="images/pg-right-arrow.png" /></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-5 text-right">
                                <a href="#" class="browse-btn">Browse more Jobs</a>
                            </div>

                        </div>

                    </div>

                </div>
                        <div role="tabpanel" class="tab-pane @if(request()->has('search')) active @endif" id="search_jobs">

                            <div class="clearfix"></div>

                            <div class="com-search">

                                <br>

                                <div class="box box-default box-solid " id="job_search">

                                    <div class="box-body">
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
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <br>
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
                            <div class="row">
                                @if (count($jobs) > 0)
                                    @foreach($jobs as $job)

                                            <div class="col-sm-6 col-md-4 thumbs">
                                                @if ( $job->company->photos->count() )
                                                    <div> <img src="{{env('APP_S3_URL') .$job->company->photos->first()->path . $job->company->photos->first()->filename . '620x412.' . $job->company->photos->first()->extension }}" /></div>
                                                    {{--<div><img src="images/companies/thumbtack.jpg" /></div>--}}
                                                @endif
                                                <div><a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}"> <h2> {{ $job->title }}</h2></a></div>
                                                <div><a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                                        <h2>{{ str_studly($job->company->title) }}</h2></a></div>
                                                <div> <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                                        <p>{{ str_studly($job->level) }}</p>
                                                    </a></div>

                                                <div>
                                                    @foreach($job->categories as $category)
                                                        <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                                            <p>{{ $category->name }}</p>
                                                        </a>
                                                    @endforeach
                                                </div>
                                                <div>
                                                    @foreach($job->skills as $skill)
                                                        <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                                            <p>{{ $skill->name }}</p>
                                                        </a>
                                                    @endforeach
                                                </div>

                                                <div>
                                                    <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                        <p> {{ $job->country->name }}</p></a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                                        <p>{{ $job->state->name }}</p>
                                                    </a>
                                                </div>
                                            </div>

                                    @endforeach
                                @endif

                                <div class="pages">
                                    <div class="col-sm-7">
                                        <ul class="pagination">
                                            <li><a href="#"><img src="images/pg-left-arrow.png" /></a></li>
                                            {!! $paginator->render() !!}
                                            <li><a href="#"><img src="images/pg-right-arrow.png" /></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-5 text-right">
                                        <a href="#" class="browse-btn">Browse more Jobs</a>
                                    </div>

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
                $.getJSON('/admin/get-states/'+$(this).val(), function(json){
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