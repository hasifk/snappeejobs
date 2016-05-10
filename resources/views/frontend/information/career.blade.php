@extends('frontend.layouts.masternew')

@section('content')

    <div class="container com-search margin-top" style="margin-top: 7%;  margin-bottom: 50px;">
        @if(!empty($career))
            <div class="row">
                <h3>{{$career->header}}</h3>
                <div class="col-md-10 col-md-offset-1">
                    {{$career->content}}
                </div>
            </div>
        @endif
    </div>

@endsection