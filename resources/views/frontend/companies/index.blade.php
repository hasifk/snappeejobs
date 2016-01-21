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
                    <form role="form" action="{{ route('companies.search') }}">

                        <input type="hidden" name="search" value="1">

                        <div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="locations">Location</label>
                                    <select
                                        name="locations[]"
                                        id="locations"
                                        class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                        multiple="multiple"
                                        style="width: 100%;"
                                        >
                                        @if (count($locations) > 0)
                                        @foreach($locations as $location)
                                        <option
                                            value="{{ $location->id }}"
                                            {{ request('locations')
                                        && in_array($location->id, request('locations')) ? 'selected="selected"' : '' }}
                                        >
                                        {{ $location->state }}, {{ $location->country_code }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
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
                                        @if (count($companies_data['companies']) > 0)
                                        @foreach($companies_data['companies'] as $company)
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
                                            id="small"
                                            value="small" {{ request('size') == 'small' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_internship">Small</label>
                                        &nbsp;
                                        <input
                                            type="radio"
                                            name="size"
                                            id="medium"
                                            value="medium" {{ request('size') == 'medium' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_entry">Medium</label>
                                        &nbsp;
                                        <input
                                            type="radio"
                                            name="size"
                                            id="large"
                                            value="big" {{ request('size') == 'large' ? 'checked="checked"' : '' }}
                                        />
                                        <label for="level_mid">Large</label>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md12">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1" style="margin-bottom: 20px;">
        <div class="col-md-6">Companies</div>
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

    <div class="col-md-10 col-md-offset-1">
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

@endsection



