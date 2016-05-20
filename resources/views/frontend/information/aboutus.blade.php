@extends('frontend.layouts.masternew')

@section('content')

    <div class="container com-search margin-top" style="margin-top: 7%; margin-bottom: 50px;">
        @if(!empty($about_us))
            
                <h3>{{$about_us->header}}</h3>
                <div class="col-xs-12">
                    <div class="row">
                    {{$about_us->content}}
                    </div>
                </div>
            
        @endif
    </div>

@endsection

