@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"> {{ $company->title }}</div>

            <div class="panel-body">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    @foreach($company->socialmedia as $socialMedia)
                    <div class="col-md-3 pull-right">
                        <a class="btn btn-default btn-block" href="{{  $socialMedia->url }}">
                            @if(str_contains($socialMedia->url,'twitter.'))
                            Twitter
                            @elseif(str_contains($socialMedia->url,'facebook.'))
                            Facebook
                            @else
                            Google+
                            @endif
                        </a>
                    </div>
                    @endforeach
                    <div class="col-md-4 pull-right company-container">
                        <button v-cloak class="btn btn-default btn-block" v-on:click="followCompany" v-show={{ count(auth()->user()) }}>
                            <span class="glyphicon glyphicon-ok"></span>
                            @{{ followerStatus }}(@{{ companyFollowers }})
                        </button>
                    </div>
                    <!--<div class="col-md-3">
                        <button class="btn btn-default btn-block">
                            Google+
                        </button>
                    </div>-->
                </div>


                @if ( $company->photos->count() )
                <div class="col-md-6">
                    <img src="{{$company->photos->first()->image }}" alt="company photo"  width="100%">
                </div>
                @endif

                <div class="col-md-6">
                    <h2>About {{ $company->title }} </h2>
                    <p> {{ $company->description }} </p>
                </div>

                <div class="col-md-6">
                    <h2>What {{ $company->title }} does ?</h2>
                    <p> {{ $company->what_it_does }} </p>
                </div>

                <div class="col-md-6">
                    <h2>Office life at {{ $company->title }} </h2>
                    <p> {{ $company->office_life }} </p>
                </div>

                <!--<div class="col-md-5">
                    <img src="{{ $company->logo_image }}" alt="company photo">
                </div>-->

                @foreach($company->people as $people)
                <div class="col-md-4">
                    <a href="/companies/{{ $company->url_slug }}/people/{{ $people->id }}">
                        <img src="{{ $people->image }}" alt="people company" width="100%">
                        <h3>
                            {{ $people->name }}
                        </h3>
                    </a>
                    <h4>
                        {{ $people->designation }}
                    </h4>
                    <p>
                        {{ $people->about_me }}
                    </p>
                    <blockquote>
                        "{{ $people->testimonial }}"
                    </blockquote>
                </div>
                @endforeach

                <div class="col-md-4">
                    <a href="/jobs?search=1&companies[]={{ $company->id }}&country_id=&state_id=">
                        <img src="http://dummyimage.com/320x235/888/000/f23.jpg?text=We+are+Hiring" alt="" width="100%">
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('companies.next', $company->id) }}" class="btn btn-primary">Next Company</a>
                </div>
                <!--@foreach($company->socialmedia as $socialMedia)
                <div class="col-md-4">
                    <a href="{{  $socialMedia->url }}">
                        @if(str_contains($socialMedia->url,'twitter.'))
                        <img src="http://dummyimage.com/320x235/888/000/f23.jpg?text={{ str_slug($company->title,'+') }}+on+Twitter" alt="" width="100%">
                        @else
                        <img src="http://dummyimage.com/320x235/888/000/f23.jpg?text={{ str_slug($company->title,'+') }}+on+Facebook" alt="" width="100%">
                        @endif
                    </a>
                </div>
                @endforeach-->
            </div>
        </div><!-- panel -->
    </div>

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
