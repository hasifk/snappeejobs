@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-home"></i> {{ $company->title }}</div>

            <div class="panel-body">

                <div class="col-md-5">
                    <img src="{{$company->path . $company->filename . $company->extension}}" alt="company photo" width="400">
                </div>

                <div class="col-md-5">
                    <h2>About {{ $company->title }} </h2>
                    <p> {{ $company->description }} </p>
                </div>

                <div class="col-md-5">
                    <h2>What {{ $company->title }} does ?</h2>
                    <p> {{ $company->what_it_does }} </p>
                </div>

                <div class="col-md-5">
                    <h2>Office life at {{ $company->title }} </h2>
                    <p> {{ $company->office_life }} </p>
                </div>

                <div class="col-md-5">
                    <img src="{{ $company->logo }}" alt="company photo">
                </div>

                @foreach($peoples as $people)
                <div class="col-md-3">
                    {{ $people }}
                </div>
                @endforeach

            </div>
        </div><!-- panel -->
    </div>

@endsection