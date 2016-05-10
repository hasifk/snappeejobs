@extends('frontend.layouts.masternew')

@section('content')

    <div class="container com-search margin-top" style="margin-top: 7%;  margin-bottom: 50px;">
        @if(!empty($privacy))
            <div class="row">
                <h3>{{$privacy->header}}</h3>
                <div class="col-md-10 col-md-offset-1">
                    {{$privacy->content}}
                </div>
            </div>
        @endif
    </div>

@endsection