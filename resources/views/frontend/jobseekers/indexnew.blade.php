@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="{{ request('search') ? '' : 'active' }}"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Browse</a></li>
                        <li role="presentation" class="{{ request('search') ? 'active' : '' }}"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Search and Filter</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane {{ request('search') ? '' : 'active' }}" id="home">
                            &nbsp;
                        </div>
                        <div role="tabpanel" class="tab-pane {{ request('search') ? 'active' : '' }}" id="profile">
                            <div class="com-search">

                                <div class="row">

                                    <form role="form" action="{{ route('jobseeker.search') }}">
                                        <input type="hidden" name="search" value="1">

                                    <div class="col-sm-9 col-md-10">
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
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
                                        </div>
                                        <div class="radio">
                                            <div class="form-group">
                                                Working on company which is
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
                                                            id="size_big"
                                                            value="big" {{ request('size') == 'big' ? 'checked="checked"' : '' }}
                                                    />
                                                    <label for="size_big">Big</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-2 search-btn">
                                        <button type="submit" class="btn btn-primary">
                                            <img src="/images/lens-icon.png"> Search
                                        </button>
                                    </div>

                                    </form>

                                </div>
                                {{--<span class="btn-close"><img src="images/close-btn.png"></span>--}}

                            </div>
                        </div>
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

                <div class="col-md-10 col-md-offset-1 companies">
                    <?php $t = 0; ?>
                    @foreach($job_seekers as $job_seeker)
                        @if(! $t )
                    <div class="row">
                        @endif
                        <?php $t++; ?>
                        <div class="col-sm-6">
                            <div class="thumb-wrap">
                                <div class="job-seeker">
                                    <div class="profileImage">
                                        @if($job_seeker->user->avatar_filename)
                                        <img class="img-circle" src="{{ env('APP_S3_URL') . $job_seeker->user->avatar_path . $job_seeker->user->avatar_filename . '90x90.' . $job_seeker->user->avatar_extension}}">
                                        @else
                                            <img src="http://placehold.it/90x90">
                                        @endif
                                    </div>
                                    <div class="profileContent">
                                        <h2>
                                            <a href="{{ route('jobseeker.show' , [ $job_seeker->id ] ) }}">
                                                {{ $job_seeker->user->name }}
                                            </a>
                                            <a
                                                href="{{ route('jobseeker.show' , [ $job_seeker->id ] ) }}"
                                                class="btn-fav"
                                            >
                                                <img src="/images/red-heart.png" align="absmiddle"> {{ $job_seeker->likes ? $job_seeker->likes : '0' }}
                                            </a>
                                        </h2>
                                        <p class="req">Looking for <a href="{{ route('jobseeker.search', ['size' => $job_seeker->size]) }}">
                                                {{ str_studly($job_seeker->size) }}
                                            </a> sized company</p>
                                        <p class="jobseeker-loc"><img src="/images/loc-icongrey.png"> <a href="{{ route('jobseeker.search', ['state_id' => $job_seeker->state->id]) }}">
                                                {{ str_studly($job_seeker->state->name) }}
                                            </a>, <a href="{{ route('jobseeker.search', ['country_id' => $job_seeker->country->id]) }}">
                                                {{ str_studly($job_seeker->country->name) }}
                                            </a></p>
                                        <hr>
                                        <p class="skills"><span>Skills</span> : @if( $job_seeker->skills->count() )
                                            @foreach($job_seeker->skills as $skill)
                                                    <a href="{{ route('jobseeker.search', ['skill' => $skill->id]) }}">
                                                        {{ $skill->name }}
                                                    </a>
                                                @endforeach
                                                @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if( $t == 2 )
                            <?php $t = 0; ?>
                    </div>
                        @endif


                    @endforeach

                        @if( $t )
                        </div>
                        @endif

                    <div class="row">
                        <div class="pages">
                            <div class="col-sm-12">
                                {!! $paginator->render() !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-10 col-md-offset-1 companies">
                    @if($job_seekers->isEmpty())
                        <h3 style="margin-bottom: 50px;" class="text-center">No results found.</h3>
                    @endif
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
                if (  $(e.target).attr('href') == '#home' ) {
                    history.pushState({}, 'Snapit Browse Jobseekers', getNextURL());
                } else if ( $(e.target).attr('href') == '#profile' ) {
                    history.pushState({}, 'Snapit Search Jobseekers', getNextURL());
                }
            })

        });
    </script>
@endsection

