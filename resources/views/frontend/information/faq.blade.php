@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search margin-top">
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