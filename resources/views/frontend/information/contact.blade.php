@extends('frontend.layouts.masternew')

@section('content')

<div class="container com-search margin-top" style="margin-top: 7%;  margin-bottom: 50px;">
    @if(!empty($contact))

    <h3>{{$contact->header}}</h3>
    <div class="col-md-12">
        <div class="row">
            {{$contact->content}}
        </div>
    </div>
    @endif
</div>

@endsection