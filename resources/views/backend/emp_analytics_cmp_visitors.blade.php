@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>{{ trans('strings.backend.dashboard_title') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')
    <div class="row">




        @roles(['Employer', 'Employer Staff'])
        <h3>Company Visitors</h3>
        @if(count($company_auth_visitors)>0)


                @foreach($company_auth_visitors as $cmp)
                <ul class="list-group">
                        <li class="list-group-item">
                       <a href="{{ route('jobseeker.show' , [ $cmp->user_id ] ) }}">Name:{{ $cmp->name }}</a>
                        </li>
                    <li class="list-group-item">
                        Country:{{$cmp->country}}
                    </li>
                    <li class="list-group-item">
                        Latitude:{{$cmp->latitude}}
                    </li>
                    <li class="list-group-item">
                        Longitude:{{$cmp->longitude}}
                    </li>
                </ul>

                @endforeach


        @endif

        @if(count($company_visitors)>0)


            @foreach($company_visitors as $cmp)
                <ul class="list-group">
                    <li class="list-group-item">
                       Name:Guest
                    </li>
                    <li class="list-group-item">
                        Country:{{$cmp->country}}
                    </li>
                    <li class="list-group-item">
                        Latitude:{{$cmp->latitude}}
                    </li>
                    <li class="list-group-item">
                        Longitude:{{$cmp->longitude}}
                    </li>
                </ul>

            @endforeach


        @endif
        @endauth

    </div>



@endsection

