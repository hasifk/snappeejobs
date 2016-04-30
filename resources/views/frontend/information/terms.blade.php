@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search margin-top" style="margin-top: 7%">
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
