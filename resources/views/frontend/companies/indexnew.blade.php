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
                        <div role="tabpanel" class="tab-pane @if(!request()->has('search')) active @endif" id="browse_companies">                    
                             &nbsp;
                        </div>
                        <div role="tabpanel" class="tab-pane @if(request()->has('search')) active @endif" id="search_companies">

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
                                                <div class="col-md-6">
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
                        <br>
                        <br>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div class="row">

                <div class="col-md-10 col-md-offset-1 col-sm-12 companies">

                    <h1>Explore Companies</h1>

                    <div class="row">
                        @if(count($companies_data['companies'])>0)
                            @foreach($companies_data['companies'] as $company)
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

                            @endforeach

                        @else
                            <h3 style="margin-bottom: 100px;" class="text-center">No Companies found</h3>
                        @endif

                    </div>

                </div>

            </div>

        </div>
    </div>

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
            });

        });

    </script>
@endsection
