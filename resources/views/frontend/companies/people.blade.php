@extends('frontend.layouts.masternew')

@section('content')

<div class="col-md-3 col-md-offset-1" style="margin-top: 7%; margin-bottom: 50px;">
    <h2>
        <a href="/companies/{{ $company->url_slug }}">{{ $company->title }}</a>
    </h2>
</div>

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>{{ $people->name }}</h3>
            <h4>{{ $people->designation }}</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-8">
                <!--<img src="{{ $people->path . $people->filename . $people->extension }}" alt="company photo" width="400">-->
                <img src="http://dummyimage.com/680x380/888/000.jpg" alt="company photo" >
            </div>

            <div class="col-md-4">
                <h2>What {{ $people->name }} does?</h2>
                <p> {{ $people->about_me }} </p>
            </div>
            <br>
            <div class="col-md-12">
                <p>
                    <blockquote> "{{ $people->testimonial }}" </blockquote>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>More People</h3>
        </div>
        <div class="panel-body">
            @foreach($company->people as $ppl)
                @unless($ppl->id == $people->id)
                <div class="col-md-4">
                    <a href="/companies/{{ $company->url_slug }}/people/{{ $ppl->id }}">
                        <img src="{{ $ppl->path . $ppl->filename . $ppl->extension }}" alt="people company" >
                        <h3>
                            {{ $ppl->name }}
                        </h3>
                    </a>
                    <h4>
                        {{ $ppl->designation }}
                    </h4>
                    <p>
                        {{ $ppl->about_me }}
                    </p>
                    <blockquote>
                        "{{ $ppl->testimonial }}"
                    </blockquote>
                </div>
                @endunless
            @endforeach
        </div>
    </div>
</div>


@endsection