@extends('frontend.layouts.masternew')

@section('content')

    <div class="container com-search margin-top" style="margin-top: 7%;  margin-bottom: 50px;">
        @if(!empty($terms))
            <div class="row">
                <h3>{{$terms->header}}</h3>
                <div class="col-md-10 col-md-offset-1">
                    {{$terms->content}}
                </div>
            </div>
        @endif
    </div>

@endsection
