@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about" aria-controls="home" role="tab" data-toggle="tab">About</a></li>
                        <li role="presentation"><a href="#office" aria-controls="profile" role="tab" data-toggle="tab">Office</a></li>
                        <li role="presentation"><a href="#people" aria-controls="profile" role="tab" data-toggle="tab">People</a></li>
                        <li role="presentation"><a href="/jobs?search=1&companies[]=3">Jobs</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section>
        <div class="bodycontent">
            <div class="container">
                <div class="row job-details">

                    <div class="col-md-10 col-md-offset-1 comp-details">
                        <div class="row res-clear">

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active"
                                     id="about">


                                    <div class="company-pics">
                                        <div class="col-md-8 comp-pic">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h1 class="company_detail">
                                                        {{ $company->title }}
                                                        <br/>
                                                        @if($company->industries->count())
                                                            @foreach($company->industries as $industry)
                                                                <span>{{ $industry->name }}</span>
                                                            @endforeach
                                                        @endif
                                                        @if ($company->state || $company->country)
                                                            <span>
                                                            @if($company->state)
                                                                {{ $company->state->name }}
                                                            @endif,
                                                            @if ($company->country)
                                                                {{ $company->country->name }}
                                                            @endif
                                                            </span>
                                                        @endif
                                                        @if ($company->size)
                                                            <span>
                                                                {{ $company->size }}
                                                            </span>
                                                        @endif
                                                    </h1>
                                                </div>
                                                <div class="col-md-3">
                                                    <h1>
                                                        <a href="/jobs?search=1&companies[]=3" class="btn-primary">View Jobs</a>
                                                    </h1>
                                                </div>
                                            </div>

                                            <div class="row comp-staff grid">
                                                <div class="grid-sizer"></div>

                                                <div data-category="about" class="col-sm-12 grid-item">
                                                    @if ( $company->photos->count() )
                                                        <img src="{{env('APP_S3_URL') .$company->photos->first()->path . $company->photos->first()->filename . '620x412.' . $company->photos->first()->extension }}"/>
                                                        <div class="moreinfo">
                                                            <div>
                                                                <h3>{{ $company->title }}</h3>
                                                                @if($company->state)
                                                                <p>{{ $company->state->name }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                @foreach($company->people as $people)
                                                    <div data-category="people" class="col-sm-6 grid-item">

                                                        @if($people->path)
                                                            <img src="{{env('APP_S3_URL') .$people->path . $people->filename . '295x297.' . $people->extension }}"/>
                                                        @else
                                                            <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97297&w=295&h=297"/>
                                                        @endif
                                                        <div class="moreinfo">
                                                            <div>
                                                                <h3>{{ $people->name }}</h3>
                                                                <p>{{ $people->designation }}</p>
                                                                <a href="/companies/{{ $company->url_slug }}/people/{{ $people->id }}"
                                                                   class="meet-staff">Meet</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div data-category="office" class="col-sm-6 grid-item ">
                                                    <div class="staff-info">
                                                        @if ( $company->photos->count() )
                                                            @if($company->photos->count() > 1)
                                                                <img src="{{env('APP_S3_URL') .$company->photos()->skip(1)->first()->path . $company->photos()->skip(1)->first()->filename . '295x218.' . $company->photos()->skip(1)->first()->extension }}"/>
                                                            @else
                                                                <img src="{{env('APP_S3_URL') .$company->photos->first()->path . $company->photos->first()->filename . '295x218.' . $company->photos->first()->extension }}"/>
                                                            @endif
                                                        @else
                                                            <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97218&w=295&h=218"/>
                                                        @endif
                                                        <h2>What {{ $company->title }} does ?</h2>
                                                        <br>
                                                        <p class="stf-text">{{ $company->what_it_does }}</p>
                                                    </div>
                                                </div>
                                                <div data-category="office" class="col-sm-6 grid-item spt-realtime">
                                                    <div class="staff-info">
                                                        @if ( $company->photos->count() )
                                                            @if($company->photos->count() > 2)
                                                                <img src="{{env('APP_S3_URL') .$company->photos()->skip(2)->first()->path . $company->photos()->skip(2)->first()->filename . '295x218.' . $company->photos()->skip(2)->first()->extension }}"/>
                                                            @else
                                                                <img src="{{env('APP_S3_URL') .$company->photos->first()->path . $company->photos->first()->filename . '295x218.' . $company->photos->first()->extension }}"/>
                                                            @endif
                                                        @else
                                                            <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97218&w=295&h=218"/>
                                                        @endif
                                                        <h2>Office life at {{ $company->title }}</h2>
                                                        <br>
                                                        <p class="stf-text">{{ $company->office_life }}</p>
                                                    </div>
                                                </div>
                                                @if ( $company->photos->count() )
                                                    <div data-category="people" class="col-sm-6 grid-item">
                                                    @if($company->photos->count() > 3)
                                                            <img src="{{env('APP_S3_URL') .$company->photos()->skip(3)->first()->path . $company->photos()->skip(3)->first()->filename . '295x218.' . $company->photos()->skip(3)->first()->extension }}"/>
                                                    @else
                                                        <img src="{{env('APP_S3_URL') .$company->photos->first()->path . $company->photos->first()->filename . '295x218.' . $company->photos->first()->extension }}"/>
                                                    @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4 company-desc">

                                            <div class="sidetop company-container">
                                                <a class="followcompany" v-on:click="followCompany" href="#"><img src="/images/heart-{{ $followingStatus=='following' ? 'icon' : 'grey' }}.png" /></a>
                                                <img style="width: 282px; height: 44px;;" src="{{ $company->logo_image }}" />
                                            </div>

                                            @if ( $company->photos->count() )
                                                @if($company->photos->count() > 4)
                                                    <?php $fourth_company_image =  env('APP_S3_URL') .$company->photos()->skip(4)->first()->path . $company->photos()->skip(4)->first()->filename . '295x218.' . $company->photos()->skip(4)->first()->extension ?>
                                                @else
                                                    <?php $fourth_company_image =  env('APP_S3_URL') .$company->photos->first()->path . $company->photos->first()->filename . '295x218.' . $company->photos->first()->extension ?>
                                                @endif
                                            @else
                                                <?php $fourth_company_image = 'https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97218&w=295&h=218' ?>
                                            @endif

                                            <div class="cmp-thms">
                                                <div class="cmp-smallpics"
                                                     style="background-image: url('{{ $fourth_company_image }}')">
                                                </div>
                                                <div class="cmp-smallpics"
                                                     style="background-image: url('images/companies/comp-thumb2.jpg')">
                                                    <div class="hover">
                                                        <h3>About {{ $company->title }}</h3>
                                                        <p>{{ $company->description }}</p>
                                                        <a href="/jobs?search=1&companies[]=3" class="btn-primary">View Jobs</a>
                                                    </div>
                                                </div>
                                                @foreach($company->socialmedia as $socialMedia)
                                                    @if(str_contains($socialMedia->url,'twitter.'))
                                                        <div class="twitter-acc">
                                                            <h3>@ {{ $company->title }}</h3>
                                                            <div align="right"><img src="/images/twitter-acc.png"/></div>
                                                        </div>
                                                    @elseif(str_contains($socialMedia->url,'facebook.'))
                                                        <div class="fbook-acc">
                                                            <h3>{{ $company->title }} on Facebook</h3>
                                                            <div align="right"><img src="/images/fbook-acc.png"/></div>
                                                        </div>
                                                    @elseif(str_contains($socialMedia->url,'instagram.'))
                                                        <div class="instagram-acc">
                                                            <h3>{{ $company->title }} on Instagram</h3>
                                                            <div align="right"><img src="/images/fbook-acc.png"/></div>
                                                        </div>
                                                    @elseif(str_contains($socialMedia->url,'pinterest.'))
                                                        <div class="pinterest-acc">
                                                            <h3>{{ $company->title }} on Pinterest</h3>
                                                            <div align="right"><img src="/images/fbook-acc.png"/></div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @foreach($company->people as $people)
                                                <div class="testimonial quotes">
                                                    “{{ $people->testimonial }}”
                                                    <br/><br/>
                                                    <strong>{{ $people->name }}</strong><br/>
                                                    {{ $people->designation }}
                                                </div>
                                                @endforeach

                                                <a href="{{ route('companies.next', $company->id) }}"
                                                   class="btn btn-primary">Next Company</a>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>


                                </div>
                                <div role="tabpanel" class="tab-pane {{ request('search') ? 'active' : '' }}"
                                     id="office">
                                    Office
                                </div>
                                <div role="tabpanel" class="tab-pane {{ request('search') ? 'active' : '' }}"
                                     id="office">
                                    People
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.0/isotope.pkgd.js"></script>

    <script>

        $(document).ready( function() {

            $('.grid').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                category: '[data-category]',
                masonry: {
                    columnWidth: '.grid-sizer'
                }
            });

        });

        var vm = new Vue({
            el: '.company-container',
            data: {
                companyId:{{ $company->id }},
                companyFollowers: {{ $company->followers }},
                followerStatus: '{{ $followingStatus }}'
            },
            methods: {

                followCompany: function(event){
                    var that = this;
                    event.preventDefault();
                    $.ajax({
                        url : '/companies/company/follow',
                        method  : 'post',
                        data : {
                            companyId:this.companyId,
                            '_token' : $('meta[name=_token]').attr("content")
                        },
                        success:function(data){
                            obj = $.parseJSON(data);
                            that.companyFollowers = obj.followers;
                            that.followerStatus = obj.followerStatus;
                            $('a.followcompany img').attr('src', '/images/heart-icon.png');
                        }
                    });

                }
            }
        });
    </script>
@endsection
