@extends('frontend.layouts.masternew')

@section('content')

    <div class="container com-search margin-top" style="margin-top: 7%; margin-bottom: 50px;">
        @if(!empty($about_us))
            <div class="row">
                <h3>{{$about_us->header}}</h3>
                <div class="col-md-10 col-md-offset-1">
                    {{$about_us->content}}
                </div>
            </div>
        @endif
    </div>

@endsection

