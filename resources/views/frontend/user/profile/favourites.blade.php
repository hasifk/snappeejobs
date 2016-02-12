@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">Favourites</div>

                <div class="panel-body">

                    <div class="col-md-6">
                        <h4>Your Favourite Companies</h4>
                        <ul class="list-group">
                            @foreach($companies as $company)
                                <li class="list-group-item">
                                    <a href="{{ route('companies.view', $company->url_slug) }}">{{ $company->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Your Favourite Jobs</h4>
                        <ul class="list-group">
                            @foreach($jobs as $job)
                                <li class="list-group-item">
                                    <a href="{{ route('jobs.view', [$job->url_slug, $job->title_url_slug]) }}">
                                        {{ $job->job_title }} <small>{{ $job->company_title }}</small>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection

