@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search margin-top">
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