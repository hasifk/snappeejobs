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
                    <h1>Explore Jobs</h1>
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