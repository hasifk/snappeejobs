@extends('frontend.layouts.masternew')

@section('content')

    <div class="container com-search margin-top" style="margin-top: 7%;  margin-bottom: 50px;">
        @if(!empty($faq))
            <div class="row">
                <h3>{{$faq->header}}</h3>
                <div class="col-md-10 col-md-offset-1">
                    {{$faq->content}}
                </div>
            </div>
        @endif
    </div>

@endsection