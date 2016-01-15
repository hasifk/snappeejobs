@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="col-md-12">
            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Search</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    Search block
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-12">
            <h4>Find the Jobs you love</h4>
        </div>

        @foreach($jobs as $job)
            <div class="col-md-4">
                <div class="job-card">
                    <div class="row">
                        <div class="col-md-12 heading">
                            <a href="{{ route('jobs.search', $job->company->url_slug.'/'.$job->title_url_slug) }}">{{ $job->title }}</a>
                        </div>
                        <div class="col-md-12">
                                <span class="label label-danger">
                                    <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                        {{ str_studly($job->level) }}
                                    </a>
                                </span>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @foreach($job->categories as $category)
                                <div class="label label-info">
                                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @foreach($job->skills as $skill)
                                <div class="label label-success">
                                    <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                        {{ $skill->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <div for="" class="label label-info">
                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                    {{ $job->countryname }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div for="" class="label label-info">
                                <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                    {{ $job->statename }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-md-12 center-block">
            {!! $jobs->render() !!}
        </div>

    </div>

@endsection