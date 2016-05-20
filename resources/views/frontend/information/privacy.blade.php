@extends('frontend.layouts.masternew')

@section('content')

<div class="container com-search margin-top" style="margin-top: 7%;  margin-bottom: 50px;">
    @if(!empty($privacy))

    <h3>{{$privacy->header}}</h3>
    <div class="col-md-12">
        <div class="row">
            {{$privacy->content}}
        </div>
    </div>
    @endif
</div>

@endsection