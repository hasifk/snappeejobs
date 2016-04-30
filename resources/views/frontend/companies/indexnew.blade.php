@extends('frontend.layouts.masternew')
@section('search_div')

    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="@if(!request()->has('search')) active @endif"><a href="#browse_companies" aria-controls="browse_jobs" role="tab" data-toggle="tab">Browse</a></li>
                        <li role="presentation" class="@if(request()->has('search')) active @endif"><a href="#search_companies" aria-controls="search_jobs" role="tab" data-toggle="tab">Search and Filter</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane {{ request('search') ? '' : 'active' }}" id="browse_companies">
                            &nbsp;
                        </div>
                        <div role="tabpanel" class="tab-pane @if(request()->has('search')) active @endif" id="search_companies">

                            <br>

                            <div class="com-search">

                                <div class="row" id="companies_search">


                                        <form role="form" action="{{ route('companies.search') }}">

                                            <input type="hidden" name="search" value="1">

                                            <div>

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

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companies">Company</label>
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
                                                        <label for="industries">Industry</label>
                                                        <select
                                                                name="industries[]"
                                                                id="industries"
                                                                class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                                multiple="multiple"
                                                                style="width: 100%;"
                                                        >
                                                            @if (count($industries) > 0)
                                                                @foreach($industries as $industry)
                                                                    <option
                                                                            value="{{ $industry->id }}"
                                                                            {{ request('industries')
                                                                        && in_array($industry->id, request('industries')) ? 'selected="selected"' : '' }}
                                                                    >
                                                                        {{ $industry->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=class="radio">
                                                    <div class="form-group">
                                                        <label for="level">Size</label>
                                                        <div class="checkbox">
                                                            <input
                                                                    type="radio"
                                                                    name="size"
                                                                    id="size_small"
                                                                    value="small" {{ request('size') == 'small' ? 'checked="checked"' : '' }}
                                                            />
                                                            <label for="size_small">Small</label>
                                                            &nbsp;
                                                            <input
                                                                    type="radio"
                                                                    name="size"
                                                                    id="size_medium"
                                                                    value="medium" {{ request('size') == 'medium' ? 'checked="checked"' : '' }}
                                                            />
                                                            <label for="size_medium">Medium</label>
                                                            &nbsp;
                                                            <input
                                                                    type="radio"
                                                                    name="size"
                                                                    id="size_large"
                                                                    value="big" {{ request('size') == 'big' ? 'checked="checked"' : '' }}
                                                            />
                                                            <label for="size_large">Big</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>

                                                <div class="col-sm-3 col-md-2 search-btn">
                                                    <button type="submit" class="btn btn-primary">
                                                        <img src="/images/lens-icon.png"> Search
                                                    </button>
                                                </div>
                                                </div>



                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <h4>Companies</h4>
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
                                                {{ route('companies.search', array_merge(request()->except('sort'), ['sort' => 'created_at'])) }}
                                                @elseif ( request()->get('sort') == 'created_at' )
                                                {{ route('companies.search', array_merge(request()->except('sort'), ['sort' => 'likes'])) }}
                                                @else
                                                {{ route('companies.search', array_merge(request()->except('sort'), ['sort' => 'likes'])) }}
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

                            </div>

                            <div style="margin-top: 25px;" class="col-md-12" id="companies_list">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3>{{ trans('strings.companies_title') }}</h3>
                                    </div>

                                    <div class="panel-body">

                                        <div class="col-md-9">
                                            @if(count($companies_data['companies'])>0)
                                                <h4>{{ trans('strings.companies_subtitle') }}</h4>
                                            @else
                                                <h4>No results found.</h4>
                                            @endif
                                        </div>
                                        @if(count($companies_data['companies'])>0)
                                            @foreach($companies_data['companies'] as $company)
                                                <a href="/companies/{{$company->url_slug}}">
                                                    <div class="col-md-5">
                                                        @if ($company->photos->count())
                                                            <img src="{{$company->photos->first()->path . $company->photos->first()->filename . $company->photos->first()->extension}}" alt="company photo" width="400">
                                                        @endif
                                                        <h2>{{$company->title}}</h2>
                                                        <h4> @foreach($company->industries as $industry){{ $industry->name }} | @endforeach  {{$company->size}} | {{$company->stateName}}</h4>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div><!-- panel -->
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="browse">
                    <span><a href="#" class="titlebox">Browse</a></span>
                    <input type="text" name="" value="" placeholder="Search and Filter" />
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="bodycontent">
            <div class="container cnt-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 companies">
                        @if(count($companies_data['companies'])>0)
                        <h1>{{ trans('strings.companies_title') }}</h1>
                        @else
                            <h1>No results found.</h1>
                        @endif
                        <div class="row">
                            @if(count($companies_data['companies'])>0)
                                @foreach($companies_data['companies'] as $company)
                                    @if($company->paid_expiry > \Carbon\Carbon::now())
                            <div class="col-sm-6 col-md-4 thumbs">
                                @if ($company->photos->count())
                                    <div> <img src="{{ env('APP_S3_URL') . $company->photos->first()->path . $company->photos->first()->filename . '295x218.' . $company->photos->first()->extension}}" alt="company photo"></div>
                                    @else
                                    <div><img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97218&w=295&h=218"></div>
                                @endif
                                    <h2>
                                        <a href="/companies/{{$company->url_slug}}">
                                            {{$company->title}}
                                        </a>
                                    </h2>
                                    <h5>{{$company->countryname}} , {{$company->statename}}</h5>
                                <h5>@foreach($company->industries as $industry){{ $industry->name }} | @endforeach  {{$company->size}} | {{$company->stateName}} </h5>
                                <p>Consumer |  Large Size  |   San Francisco</p>
                            </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="pages">
                                <div class="col-sm-7">
                                    <ul class="pagination">
                                        @if(!empty($companies_data['paginator']))
                                        <li><a href="#"><img src="images/pg-left-arrow.png" /></a></li>

                                        {{--<li><a href="#"><strong>1</strong></a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>--}}
                                            <li>{!! $companies_data['paginator']->render() !!}</li>


                                        <li><a href="#"><img src="images/pg-right-arrow.png" /></a></li>
                                            @endif
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

            $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                if (  $(e.target).attr('href') == '#browse_companies' ) {
                    history.pushState({}, 'Snappeejobs Browse Companies', getNextURL());
                } else if ( $(e.target).attr('href') == '#search_companies' ) {
                    history.pushState({}, 'Snappeejobs Search Companies', getNextURL());
                }
            });

        });

    </script>
@endsection
