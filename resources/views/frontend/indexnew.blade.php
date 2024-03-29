<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'SNAP - The best way to find a job')">
    <meta name="author" content="@yield('author', 'Silverbloom Technologies')">
    @yield('meta')

    @yield('before-styles-end')
    {!! HTML::style(elixir('css/frontend.css')) !!}
    @yield('after-styles-end')

</head>
<body>

    @if(auth()->user())

        @include('frontend.includes.nav_new')

        <div class="container user-home">
            <div class="browse col-md-10">
                <p><span class="username">Hey {{ explode(' ', Auth::user()->name)[0] }},</span> Let's make today great. Check out some new jobs and companies</p>
            </div>
        </div>

        @if(count($companies_landing)>0)
        <section class="home-loggedin">
            <div class="bodycontent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-sm-12 companies">
                            <h1>Newest Companies</h1>
                            <div class="row">

                                @foreach($companies_landing as $company)

                                    <div class="col-sm-6 col-md-4 thumbs">
                                        @if ($company->photos->count())
                                            <div>
                                                <img src="{{ env('APP_S3_URL') . $company->photos->first()->path . $company->photos->first()->filename . '295x218.' . $company->photos->first()->extension}}" alt="company photo">
                                            </div>
                                        @else
                                            <div><img src="http://placehold.it/295x218">
                                            </div>
                                        @endif
                                        <h2>
                                            <a href="/companies/{{$company->url_slug}}">
                                                {{$company->title}}
                                            </a>
                                        </h2>
                                        <h5>{{$company->countryname}} , {{$company->statename}}</h5>
                                        <p> @foreach($company->industries as $industry){{ $industry->name }} | @endforeach  {{$company->size}} | {{$company->stateName}}</p>
                                    </div>

                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section>
            <hr />
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 companies text-right">
                        <a href="/companies" class="view-jobs-btn">View all companies</a>
                    </div>
                </div>
            </div>
        </section>

        @endif

        @if( (count($pref_jobs_landing)> 0) || (count($jobs_landing)> 0) )
        <section class="new-comp">
            <div class="bodycontent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-sm-12 companies">
                            <h1>Newest Jobs</h1>
                            <div class="row">

                                @foreach($pref_jobs_landing as $job)

                                        <div class="col-sm-6 col-md-4 thumbs">
                                            @if ($job->company->photos->count())
                                            <div><img src="{{ env('APP_S3_URL') . $job->company->photos->first()->path . $job->company->photos->first()->filename . '295x218.' . $job->company->photos->first()->extension}}" /></div>
                                            @else
                                            <div><img src="http://placehold.it/295x218">
                                            </div>
                                            @endif
                                            <h2>
                                                <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}
                                                </a>
                                            </h2>
                                            <h5>Software Engineer, Integrations</h5>
                                            <p><a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                                    {{ str_studly($job->level) }}
                                                </a>
                                                |
                                                @foreach($job->categories as $category)
                                                        <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                                            {{ $category->name }}
                                                        </a>
                                                @endforeach
                                                |
                                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                    {{ $job->country->name }}
                                                </a>
                                                |
                                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                    {{ $job->state->name }}
                                                </a>
                                            </p>
                                        </div>


                                @endforeach

                                @foreach($jobs_landing as $job)

                                        <div class="col-sm-6 col-md-4 thumbs">
                                            @if ($job->company->photos->count())
                                                <div><img src="{{ env('APP_S3_URL') . $job->company->photos->first()->path . $job->company->photos->first()->filename . '295x218.' . $job->company->photos->first()->extension}}" /></div>
                                            @else
                                                <div><img src="http://placehold.it/295x218">
                                                </div>
                                            @endif
                                            <h2>
                                                <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}
                                                </a>
                                            </h2>
                                            <h5>Software Engineer, Integrations</h5>
                                            <p><a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                                    {{ str_studly($job->level) }}
                                                </a>
                                                |
                                                @foreach($job->categories as $category)
                                                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                @endforeach
                                                |
                                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                    {{ $job->country->name }}
                                                </a>
                                                |
                                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                    {{ $job->state->name }}
                                                </a>
                                            </p>
                                        </div>

                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section>
            <hr />
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 companies text-right">
                        <a href="/jobs" class="view-jobs-btn">View all Jobs</a>
                    </div>
                </div>
            </div>
        </section>
        @endif


        <section class="user-home">
            <div class="cl-logos featured ftr-logos">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div style="padding: 20px 0">As featured in</div>
                        </div>
                        <div class="col-sm-10">
                            <div class="owl-carousel owl-featured">
                                <div class="item"><img src="images/tnw.png" /></div>
                                <div class="item"><img src="images/lg-entpr.png" /></div>
                                <div class="item"><img src="images/lg-giga.png" /></div>
                                <div class="item"><img src="images/lg-fast.png" /></div>
                                <div class="item"><img src="images/lg-wired.png" /></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


    @endif

    <!-- Home page Content -->

        <div
                v-show="!registered || !resumeUploaded || !preferencesSaved"
                v-bind:class="{ 'panel-defaultt' : !registered, 'panell' : !registered }"
                class="homepage-modal"
        >

            @if( auth()->guest() )

            <header style="display: block;">
                <div class="home-banner">
                    <nav class="">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div id="navbar" class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="/">HOME</a></li>
                                    <li><a href="/jobs">EXPLORE</a></li>
                                    <li><a href="/companies">COMPANIES</a></li>
                                    <li><a href="/advice">GET ADVICE</a></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right top-head">
                                    <li><a href="/employers">For Employers</a></li>
                                    <li><a href="/auth/login"> Sign In</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="container">
                        <div class="home-logo text-center"><img src="images/snap-logo.png"/></div>
                        <h1>The best way to find a job</h1>
                        <div class="row">
                            <div class="col-sm-12">
                                <form v-on:submit.prevent="showModal($event)" action="" class="form-inline text-center">
                                    <div class="form-group">
                                        <label class="sr-only" for="">Your name</label>
                                        <input v-model="name" type="text" class="form-control input-lg" id="name"
                                               placeholder="Your name">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="">Your email</label>
                                        <input v-model="email" type="email" class="form-control input-lg" id="email"
                                               placeholder="Your email">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg">Sign up</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    </nav>
                </div>
            </header>

            @endif

            <div v-cloak class="modal" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"><img src="images/close-btn.png" /></button>
                                <h2 class="modal-title text-center">@{{ modalHeading }}</h2>
                                <p class="text-center" v-if="registered && !confirmed">
                                    Please confirm your account by following the email sent to your account.
                                </p>
                            </div>

                            <div class="modal-body">

                                <div v-if="errors.length" class="alert alert-danger">
                                    <p>Oops, there are some errors. </p>
                                    <ul>
                                        <li v-for="error in errors">
                                            @{{ error }}
                                        </li>
                                    </ul>
                                </div>


                                <div v-if="! registered" class="form-horizontal">

                                    <div class="form-group">
                                        <label for="name" class="col-sm-5 control-label">Name</label>
                                        <div class="col-sm-6">
                                            <input v-model="name" class="form-control" name="name2" type="name" id="name2">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-sm-5 control-label">E-mail</label>
                                        <div class="col-sm-6">
                                            <input v-model="email" class="form-control" name="email" type="email" id="email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-5 control-label">Password</label>
                                        <div class="col-sm-6">
                                            <input v-model="password" class="form-control" name="password" type="password" id="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="col-sm-5 control-label">Password Confirmation</label>
                                        <div class="col-sm-6">
                                            <input v-model="password_confirmation" class="form-control" name="password_confirmation" type="password" id="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('gender', "Gender", ['class' => 'col-sm-5 control-label']) !!}
                                        <div class="col-sm-6">
                                            <div class="checkbox">
                                                <input v-model="gender"
                                                       type="radio"
                                                       name="gender"
                                                       id="gender_male"
                                                       value="male"
                                                />
                                                <label for="gender_male">Male</label>
                                            </div>
                                            <div class="checkbox">
                                                <input v-model="gender"
                                                       type="radio"
                                                       name="gender"
                                                       id="gender_female"
                                                       value="female"
                                                />
                                                <label for="gender_female">Female</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('dob', "Date of Birth", ['class' => 'col-sm-5 control-label']) !!}
                                        <div class="col-sm-6">
                                            <input v-model="dob" class="form-control bootstrap-datepicker" placeholder="Date of Birth" name="dob" type="text" id="dob">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="office_life" class="col-sm-5 control-label">Country</label>
                                        <div class="col-sm-6">
                                            <select v-model="country_id" name="country_id" id="country_id" class="form-control">
                                                <option value="">Please select</option>
                                                @foreach($countries as $country)
                                                    <option
                                                            value="{{ $country->id }}"
                                                            {{ old('country_id') && $country->id == old('country_id') ? 'selected="selected"' : '' }}
                                                    >
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="office_life" class="col-sm-5 control-label">State</label>
                                        <div class="col-sm-6">
                                            <select v-model="state_id" name="state_id" id="state_id" class="form-control">
                                                <option value="">Please select</option>
                                                @foreach($states as $state)
                                                    <option
                                                            value="{{ $state->id }}"
                                                            {{ old('state_id') && $state->id == old('state_id') ? 'selected="selected"' : '' }}
                                                    >
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-5">
                                            <button
                                                    v-on:click="validateRegistration($event)"
                                                    class="btn btn-primary"
                                                    type="submit"
                                                    value="Register"
                                                    data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i> Register'
                                            >Register</button>
                                        </div>
                                    </div>

                                </div>

                                <div v-show="registered && !avatarUploaded" class="form-horizontal">
                                    <form
                                            enctype="multipart/form-data"
                                            method="post"
                                            action="{{ route('frontend.profile.resume') }}"
                                            id="upload-profile-image"
                                    >
                                    </form>
                                </div>

                                <div v-show="registered && avatarUploaded && !resumeUploaded" class="form-horizontal">
                                    <form enctype="multipart/form-data" method="post" action="{{ route('frontend.profile.resume') }}" id="upload-resume"></form>
                                </div>

                                <div v-show="resumeUploaded && !preferencesSaved" class="form-horizontal">

                                    <div class="form-group">
                                        <label for="description" class="col-lg-4 control-label">Industry</label>
                                        <div class="col-lg-6">
                                            <select
                                                    v-model="industries"
                                                    name="industries[]"
                                                    id="industries"
                                                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                    multiple="multiple"
                                                    style="width: 100%;"
                                            >
                                                @if (count($industries) > 0)
                                                    @foreach($industries as $industry)
                                                        <option value="{{ $industry->id }}">
                                                            {{ $industry->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="col-lg-4 control-label">Skills</label>
                                        <div class="col-lg-6">
                                            <select
                                                    v-model="skills"
                                                    name="skills[]"
                                                    id="skills"
                                                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                    multiple="multiple"
                                                    style="width: 100%;"
                                            >
                                                @if (count($skills) > 0)
                                                    @foreach($skills as $skill)
                                                        <option value="{{ $skill->id }}">
                                                            {{ $skill->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="col-lg-4 control-label">Preffered Job Categories</label>
                                        <div class="col-lg-6">
                                            <select
                                                    v-model="job_categories"
                                                    name="job_categories[]"
                                                    id="job_categories"
                                                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                    multiple="multiple"
                                                    style="width: 100%;"
                                            >
                                                @if (count($job_categories) > 0)
                                                    @foreach($job_categories as $job_category)
                                                        <option value="{{ $job_category->id }}">
                                                            {{ $job_category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="col-lg-4 control-label">I prefer working in a company which is</label>
                                        <div class="col-lg-6">
                                            <div class="checkbox">
                                                <input
                                                        type="radio"
                                                        name="size"
                                                        id="size_small"
                                                        v-model="size"
                                                        value="small" {{ request('size') == 'small' ? 'checked="checked"' : '' }}
                                                />
                                                <label for="size_small">Small</label>
                                                &nbsp;
                                                <input
                                                        type="radio"
                                                        name="size"
                                                        id="size_medium"
                                                        v-model="size"
                                                        value="medium" {{ request('size') == 'medium' ? 'checked="checked"' : '' }}
                                                />
                                                <label for="size_medium">Medium</label>
                                                &nbsp;
                                                <input
                                                        type="radio"
                                                        name="size"
                                                        id="size_big"
                                                        v-model="size"
                                                        value="big" {{ request('size') == 'big' ? 'checked="checked"' : '' }}
                                                />
                                                <label for="size_big">Big</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button
                                                    v-on:click="submitPreferences($event)"
                                                    class="btn btn-primary"
                                                    type="button"
                                                    value="Save"
                                                    data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i> Saving...'
                                            >Save</button>
                                        </div>
                                    </div>

                                </div>

                                <div v-show="preferencesSaved" style="min-height: 400px;" class="form-horizontal">
                                    <h3>Thank you for completing the registration.</h3>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


        </div>

        @if(auth()->guest())
        <div class="popcap text-center">
            <a href="#">How  JustSnapIt<sup>®</sup> Help Me?</a>
        </div>
        <section class="container pr-logos">
            <div class="row">
                <div class="col-md-6 cl-partners col-md-offset-3 text-center">
                    No bad apples here. We only work with the best companies to ensure you end up in an incredible place.
                </div>
            </div>
            <div class="row">
                <div class="cl-logos">
                    <img src="images/Company1.png" />
                    <img src="images/Company2.png" />
                    <img src="images/Company3.png" />
                    <img src="images/Company4.png" />
                    <img src="images/Company5.png" />
                    <img src="images/Company6.png" />
                    <img src="images/Company7.png" />
                    <img src="images/Company8.png" />
                    <img src="images/Company9.png" />
                    <img src="images/Company10.png" />
                </div>
            </div>
        </section>
        <section>
            <div class="boxWrap">
                <div class="boxImage applicant"></div>
                <div class="boxContent">
                    <h2>JustSnapIt®<br />Better Jobs for Everyone</h2>
                    <p class="clearfix">We connect millions of aspiring job seekers
                        to world's best employers</p>
                    <div class="clearfix MB-30"></div>
                    <a href="/auth/register" class="signup-btn">Sign Up</a>
                </div>
            </div>
            <div class="boxWrap">
                <div class="boxContent emplr">
                    <h2>For Employers</h2>
                    <p class="clearfix">Are you an employer looking to attract the best talent? Showcase the<br />
                        heart and soul of your company and find the candidates<br />
                        that you are searching for !
                        to world's best employers</p>
                    <div class="clearfix MB-30"></div>
                    <a href="/employers" class="signup-btn">learn more <img src="images/btn-arrow.png" align="center" /></a>
                </div>
                <div class="boxImage employer"></div>
            </div>
        </section>

        <section class="customer-reviews">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h2>Customer Reviews</h2>
                    </div>
                    <div class="clearfix"></div>
                    <div class="customers">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="owl-carousel owl-reviews">
                                <div class="item">
                                    <p>Aside from actually finding my job on The Muse, it helped me figure out what
                                        to wear to my first Chartbeat interview. All the advice just made the whole
                                        process less stressful.
                                    </p>
                                    <img style="width: 100px; height: 100px; margin: 0 auto;" src="images/customer1.png"/>
                                    <h3>Kate Coghlan</h3>
                                    <p>Art Director, Brick Media</p>
                                </div>
                                <div class="item">
                                    <p>Aside from actually finding my job on The Muse, it helped me figure out what
                                        to wear to my first Chartbeat interview. All the advice just made the whole
                                        process less stressful.
                                    </p>
                                    <img style="width: 100px; height: 100px; margin: 0 auto;" src="images/customer2.png"/>
                                    <h3>Kate Coghlan</h3>
                                    <p>Art Director, Brick Media</p>
                                </div>
                                <div class="item">
                                    <p>Aside from actually finding my job on The Muse, it helped me figure out what
                                        to wear to my first Chartbeat interview. All the advice just made the whole
                                        process less stressful.
                                    </p>
                                    <img style="width: 100px; height: 100px; margin: 0 auto;" src="images/customer3.png"/>
                                    <h3>Kate Coghlan</h3>
                                    <p>Art Director, Brick Media</p>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>

            <div class="boxWrap">
                <div class="boxImage deal"></div>
                <div class="boxContent">
                    <h2>Everything About Your Career<br /> at One Place Now</h2>
                    <p class="clearfix">Start Your Job Search With 250,000+ Jobs from  <br />All Over the Web</p>
                    <div class="clearfix MB-30"></div>
                    <a href="#" class="signup-btn">Sign Up</a>
                </div>
            </div>
            <div class="boxWrap">
                <div class="boxContent hire">
                    <h2>Discover your next great hire</h2>
                    <p class="clearfix">Are you an employer looking to attract the best talent? Showcase the heart and soul of your company and find the candidates that you are searching for !</p>
                    <div class="clearfix MB-30"></div>
                    <a href="#" class="signup-btn">Employer side  <img src="images/btn-arrow.png" align="center" /></a>
                    <div class="clearfix"></div>
                </div>
                <div class="boxImage employees"></div>
            </div>
        </section>
        <section class="container featurd">
            <div class="cl-logos featured">
                <div class="row">
                    <div class="col-sm-2">
                        <div style="padding: 20px 0">As featured in</div>
                    </div>
                    <div class="col-sm-10">
                        <div class="owl-carousel owl-featured">
                            <div class="item"><img src="images/tnw.png" /></div>
                            <div class="item"><img src="images/lg-entpr.png" /></div>
                            <div class="item"><img src="images/lg-giga.png" /></div>
                            <div class="item"><img src="images/lg-fast.png" /></div>
                            <div class="item"><img src="images/lg-wired.png" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif


        @include('frontend.includes.footer')

    <!-- Home page Content -->

    @yield('before-scripts-end')

    {!! HTML::script(elixir('js/frontend.js')) !!}

    @include('frontend.includes.notification_code')

    @yield('after-scripts-end')

    @include('sweet::alert')

    <script>
            Dropzone.autoDiscover = false
            var homeRegisterApp = new Vue({
                el: '.homepage-modal',
                data: {
                    modalHeading            : 'Complete your registration here',
                    name                    : '',
                    email                   : '',
                    password                : '',
                    password_confirmation   : '',
                    gender                  : '',
                    dob                     : '',
                    country_id              : '',
                    state_id                : '',
                    errors                  : [],
                    user                    : {},
                    registered              : {{ auth()->guest() ? "false" : "true" }},
                    confirmed               : {{ auth()->user() && auth()->user()->confirmed ? "true" : "false" }},
                    avatarUploaded          : {{ auth()->user() && auth()->user()->avatar_filename ? "true" : "false" }},
                    resumeUploaded          : {{ auth()->user() && auth()->user()->job_seeker_details && auth()->user()->job_seeker_details->has_resume ? "true" : "false" }},
                    industries              : [],
                    skills                  : [],
                    job_categories          : [],
                    size                    : '',
                    preferencesSaved        : {{ auth()->user() && auth()->user()->job_seeker_details && auth()->user()->job_seeker_details->preferences_saved ? "true" : "false" }},
                },
                methods: {
                    showModal: function(event){
                        event.preventDefault();
                        $("#registrationModal").modal();
                    },
                    validateRegistration: function(event){
                        $(event.target).button('loading');
                        var that = this;
                        $.post( "{{ route('frontend.access.validate') }}", this.$data, function(data){
                            $(event.target).button('reset');
                            that.user = data.user;
                            that.registered = true;
                            that.errors = [];
                            that.modalHeading = 'Please upload your profile image';
                            that.enableProfileImageUploadDropZone();
                        }).error(function(err, data){
                            var errorArray = [];
                            for(var key in err.responseJSON) {
                                var error = err.responseJSON[key];
                                error.forEach(function(element, index){
                                    errorArray.push(error[index]);
                                });
                            }
                            that.errors = errorArray;
                            $(event.target).button('reset');
                        });
                    },
                    enableProfileImageUploadDropZone: function(){
                        var that = this;
                        $("#upload-profile-image").addClass('dropzone').dropzone({
                            url: "{{ route('frontend.profileimage.update') }}",
                            dictDefaultMessage: 'Drag your profile image here or Click to upload.',
                            paramName: "file",
                            maxFilesize: 5,
                            accept: function (file, done) {
                                if (
                                        ( file.type == 'image/png' ) ||
                                        ( file.type == 'image/jpg' ) ||
                                        ( file.type == 'image/jpeg' ) ||
                                        ( file.type == 'image/bmp' )
                                ) {
                                    done();
                                } else {
                                    alert('Please upload an image file')
                                }
                            },
                            sending: function (file, xhr, data) {
                                data.append('_token', $('meta[name="_token"]').attr('content'));
                            },
                            success: function (file, xhr) {
                                that.modalHeading = 'Please upload your resume now';
                                that.avatarUploaded = true;
                                that.enableResumeUploadDropZone();
                            }
                        });
                    },
                    enableResumeUploadDropZone: function(){
                        var that = this;
                        $("#upload-resume").addClass('dropzone').dropzone({
                            url: "{{ route('frontend.profile.resume') }}",
                            dictDefaultMessage: 'Drag your resume file here or Click to upload.',
                            paramName: "file",
                            maxFilesize: 5,
                            accept: function (file, done) {
                                if (
                                        ( file.type == 'application/msword' ) ||
                                        ( file.type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) ||
                                        ( file.type == 'application/pdf' ) ||
                                        ( file.type == 'application/kswps' )
                                ) {
                                    done();
                                } else {
                                    alert('Please upload doc/docx/pdf files')
                                }
                            },
                            sending: function (file, xhr, data) {
                                data.append('_token', $('meta[name="_token"]').attr('content'));
                            },
                            success: function (file, xhr) {
                                that.modalHeading = 'One more step, fill in your skills and job categories';
                                that.resumeUploaded = true;
                            }
                        });
                    },
                    submitPreferences: function(event){
                        $(event.target).button('loading');
                        var that = this;
                        $.post( "{{ route('frontend.profile.preferences') }}",
                                {
                                    industries      : $('select#industries').select2().val(),
                                    skills          : $('select#skills').select2().val(),
                                    job_categories  : $('select#job_categories').select2().val(),
                                    size            : $('input[type=radio][name=size]:checked').val()
                                },
                                function(data){
                                    $(event.target).button('reset');
                                    that.preferencesSaved = true;
                                    that.errors = [];
                                    that.modalHeading = '';
                                    setTimeout(function () {
                                        $("#registrationModal").modal('toggle');
                                        location.href = '{{ route('frontend.dashboard') }}'+"?confirmed=false";
                                    }, 1);
                                }).error(function(err, data){
                            var errorArray = [];
                            for(var key in err.responseJSON) {
                                var error = err.responseJSON[key];
                                error.forEach(function(element, index){
                                    errorArray.push(error[index]);
                                });
                            }
                            that.errors = errorArray;
                            $(event.target).button('reset');
                        });
                    }
                }
            });

            $('#registrationModal').on('hidden.bs.modal', function () {
                if ( ! homeRegisterApp.confirmed ) {
                    swal('You would receive an email from Snap it very shortly. Please follow the steps to confirm the account.');
                    homeRegisterApp.name = '';
                    homeRegisterApp.email = '';
                }
            });

            @if( auth()->user() && access()->hasRole('User') )
                    @if( auth()->user()->avatar_filename )
                    @if(
                        auth()->user()->job_seeker_details &&
                        auth()->user()->job_seeker_details->has_resume
                        )
                    homeRegisterApp.resumeUploaded = true;

            @if(
                auth()->user()->job_seeker_details &&
                auth()->user()->job_seeker_details->preferences_saved
                )
                    homeRegisterApp.preferencesSaved = true;
            @else
                    homeRegisterApp.modalHeading = "Please save your preferences";
            $("#registrationModal").modal();
            @endif

                    @else
                    homeRegisterApp.modalHeading = "Please upload your resume";
            homeRegisterApp.registered = true;
            homeRegisterApp.enableResumeUploadDropZone();
            $("#registrationModal").modal();
            @endif

                    @else
                    homeRegisterApp.modalHeading = "Please upload your profile image";
            homeRegisterApp.registered = true;
            homeRegisterApp.enableProfileImageUploadDropZone();
            $("#registrationModal").modal();

            @endif
    @endif
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


            $('.owl-reviews').owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                dots:true,
                autoplay:true,
                autoplayTimeout:2000,
                autoplayHoverPause:false,
                responsive:{
                    0:{
                        items:1
                    }
                }
            })
            $('.owl-featured').owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                dots:false,
                autoWidth:false,
                autoplay:true,
                autoplayTimeout:2000,
                autoplayHoverPause:false,
                responsive:{
                    1023:{ items:5 },
                    991:{ items:4 },
                    767:{ items:3 },
                    0:{ items:2 }
                }
            })

        </script>

</body>
</html>
