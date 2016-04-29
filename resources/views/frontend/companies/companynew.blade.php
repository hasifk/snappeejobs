@extends('frontend.layouts.masternew')

@section('content')
    <div class="container">
        <div class="browse job-dtmenu">
            <div class="row">
                <div class="col-sm-6">
                    <ul>
                        <li><a href="#">Browse</a></li>
                        <li style="width: auto;"><input type="text" name="" value="" placeholder="Search and Filter" /></li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ul>
                        <li><a href="#" class="active">About<span></span></a></li>
                        <li><a href="#">Office</a></li>
                        <li><a href="#">People</a></li>
                        <li><a href="#">Jobs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="bodycontent">
            <div class="container">
                <div class="row job-details">
                    <div class="col-md-10 col-md-offset-1 comp-details">
                        <div class="row res-clear">
                            <div class="company-pics">
                                <div class="col-md-8 comp-pic">
                                    <h1>{{ $company->title }}<br />
                                        <span>Technology</span>
                                        <span>Newyork, US</span>
                                        <span>Small size</span>
                                        <a href="#" class="btn-primary">View Jobs</a>
                                    </h1>

                                    <div class="row comp-staff grid">
                                        <div class="grid-sizer"></div>

                                        <div class="col-sm-12 grid-item">
                                            @if ( $company->photos->count() )
                                            <img src="{{env('APP_S3_URL') .$company->photos->first()->path . $company->photos->first()->filename . '620x412.' . $company->photos->first()->extension }}" />
                                            <div class="moreinfo">
                                                <div>
                                                    <h3>{{ $company->title }}</h3>
                                                    <p>Newyork</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        @foreach($company->people as $people)
                                        <div class="col-sm-6 grid-item">

                                            @if($people->path)
                                            <img src="{{env('APP_S3_URL') .$people->path . $people->filename . '295x297.' . $people->extension }}" />
                                            @else
                                                 <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97297&w=295&h=297" />
                                            @endif
                                            <div class="moreinfo">
                                                <div>
                                                    <h3>{{ $people->name }}</h3>
                                                    <p>{{ $people->designation }}</p>
                                                    <p>{{ $people->about_me }}</p>
                                                    <blockquote>
                                                        "{{ $people->testimonial }}"
                                                    </blockquote>
                                                    <a href="/companies/{{ $company->url_slug }}/people/{{ $people->id }}" class="meet-staff">Meet</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="col-sm-6 grid-item ">
                                            <div class="staff-info">
                                                <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97218&w=295&h=218" />
                                                <h2>What {{ $company->title }} does ?</h2>
                                                <p class="stf-text">{{ $company->what_it_does }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 grid-item spt-realtime">
                                            <div class="staff-info">
                                                <img src="https://placeholdit.imgix.net/~text?txtsize=28&txt=295%C3%97218&w=295&h=218" />
                                                <h2>Office life at {{ $company->title }}</h2>
                                                <p class="stf-text">{{ $company->office_life }}</p>
                                            </div>
                                        </div>




                                    </div>


                                </div>
                                <div class="col-md-4 company-desc">
                                    {{--<div class="sidetop">
                                        <a href="#"><img src="images/heart-grey.png" /></a><img src="images/logos/squarespace.png" />
                                    </div>--}}
                                    <div class="cmp-thms">
                                        <div class="cmp-smallpics" style="background-image: url('images/companies/comp-thumb1.jpg')">
                                        </div>
                                        <div class="cmp-smallpics" style="background-image: url('images/companies/comp-thumb2.jpg')">
                                            <div class="hover">
                                                <h3>About {{ $company->title }}</h3>
                                                <p>{{ $company->description }}</p>
                                                <a href="#" class="btn-primary">View Jobs</a>
                                            </div>
                                        </div>
                                        @foreach($company->socialmedia as $socialMedia)
                                            @if(str_contains($socialMedia->url,'twitter.'))
                                        <div class="twitter-acc">
                                            <h3>@ {{ $company->title }}</h3>
                                            <p>Thanks to the gang who came to our SF Meetup. It was fun!</p>
                                            <div align="right"><img src="images/twitter-acc.png" /></div>
                                        </div>
                                            @elseif(str_contains($socialMedia->url,'facebook.'))
                                        <div class="fbook-acc">
                                            <h3>{{ $company->title }} on Facebook</h3>
                                            <p>Thanks to the gang who came to our SF Meetup. It was fun!</p>
                                            <div align="right"><img src="images/fbook-acc.png" /></div>
                                        </div>
                                            @else
                                                <div class="-google-plus-acc">
                                                    <h3>{{ $company->title }} on Google Plus</h3>
                                                    <p>Thanks to the gang who came to our SF Meetup. It was fun!</p>
                                                    <div align="right"><img src="images/fbook-acc.png" /></div>
                                                </div>
                                            @endif
                                        @endforeach
                                            <div class="testimonial quotes">
                                            “There’s a willingness to go the extra mile to build something extraordinary. Everyone here wants to do something special.”
                                            <br /><br />
                                            <strong>Michael</strong><br />
                                            Interface Director
                                        </div>
                                        <div class=" pull-right company-container">
                                        <button v-cloak class="btn btn-default btn-block" v-on:click="followCompany" v-show={{ count(auth()->user()) }}>
                                            <span class="glyphicon glyphicon-ok"></span>
                                            @{{ followerStatus }}(@{{ companyFollowers }})
                                        </button>
                                            </div>



                                            <a href="{{ route('companies.next', $company->id) }}" class="btn btn-primary">Next Company</a>

                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection

@section('after-scripts-end')
    <script>
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

                            console.log(this);

                            that.companyFollowers = obj.followers;
                            that.followerStatus = obj.followerStatus;


                        }
                    });

                }
            }
        });
    </script>
@endsection
