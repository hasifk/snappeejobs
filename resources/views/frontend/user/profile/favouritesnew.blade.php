@extends('frontend.layouts.masternew')

@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div class="row">

                <div style="min-height:250px;" class="col-sm-10 col-sm-offset-1">

                    <h2 class="text-center">Favourites</h2>

                    <div class="col-md-6">
                        <h4>Your Favourite Companies</h4>
                        @if($companies)
                        <ul class="list-group">
                            @foreach($companies as $company)
                                <li class="list-group-item">
                                    <a href="{{ route('companies.view', $company->url_slug) }}">{{ $company->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                        @else
                            <h5>You have not favourited any companies yet.</h5>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h4>Your Favourite Jobs</h4>
                        @if($jobs)
                        <ul class="list-group">
                            @foreach($jobs as $job)
                                <li class="list-group-item">
                                    <a href="{{ route('jobs.view', [$job->url_slug, $job->title_url_slug]) }}">
                                        {{ $job->job_title }} <small>{{ $job->company_title }}</small>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @else
                            <h5>You have not applied to any jobs yet.</h5>
                        @endif
                    </div>

                </div>
            </div>
        </div>

@endsection