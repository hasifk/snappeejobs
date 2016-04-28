@extends('frontend.layouts.masternew')

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
