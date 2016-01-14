@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"> {{ $company->title }}</div>

            <div class="panel-body">

                <div class="col-md-6">
                    <img src="{{$company->path . $company->filename . $company->extension}}" alt="company photo" width="400">
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
                    <a href="/companies/people/{{ $people->id }}">
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
                        {{ $people->testimonial }}
                    </blockquote>
                </div>
                @endforeach

            </div>
        </div><!-- panel -->
    </div>

@endsection