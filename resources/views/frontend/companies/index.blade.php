@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.companies_title') }}</div>

            <div class="panel-body">

                {{ trans('strings.companies_subtitle') }}
                <br>
                @foreach($companies as $company)
                <a href="/companies/{{$company->url_slug}}">
                    <div class="col-md-5">
                        <img src="{{$company->path . $company->filename . $company->extension}}" alt="company photo" width="400">
                        <h2>{{$company->title}}</h2>
                        <h4>{{$company->size}} | {{$company->country}} | {{$company->state}}</h4>
                    </div>
                </a>
                @endforeach

            </div>
        </div><!-- panel -->
    </div>

@endsection



