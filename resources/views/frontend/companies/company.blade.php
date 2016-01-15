@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"> {{ $company->title }}</div>

            <div class="panel-body">

                <div class="col-md-6">
                    <img src="{{$company->photos->first()->path . $company->photos->first()->filename . $company->photos->first()->extension}}" alt="company photo" >
                </div>

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
                    <img src="{{ $company->logo }}" alt="company photo">
                </div>-->

                @foreach($company->people as $people)
                <div class="col-md-4">
                    <a href="/companies/{{ $company->url_slug }}/people/{{ $people->id }}">
                        <img src="{{ $people->path . $people->filename . $people->extension }}" alt="people company" >
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
                    <a href="/companies/{{ $company->url_slug }}/jobs">
                        <img src="http://dummyimage.com/320x235/888/000/f23.jpg?text=We+are+Hiring" alt="">
                    </a>
                </div>
                @foreach($company->socialmedia as $socialMedia)
                <div class="col-md-4">
                    <a href="{{  $socialMedia->url }}">
                        @if(str_contains($socialMedia->url,'twitter.'))
                        <img src="http://dummyimage.com/320x235/888/000/f23.jpg?text={{ str_slug($company->title,'+') }}+on+Twitter" alt="">
                        @else
                        <img src="http://dummyimage.com/320x235/888/000/f23.jpg?text={{ str_slug($company->title,'+') }}+on+Facebook" alt="">
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div><!-- panel -->
    </div>

@endsection