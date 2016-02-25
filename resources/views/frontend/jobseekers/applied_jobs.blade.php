@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="job-view panel panel-primary">

            @if(!empty($applied))

                        <ul class="list-group">
                            @foreach($applied as $application)
                                <li class="list-group-item">
                                    {{ $application->title }}
                                    <small>at : {{ $application->company_title }}</small>
                                    <small>applied at : {{ $application->created_at }}</small>
                                </li>
                            @endforeach
                        </ul>

            @endif

        </div>

    </div>

@endsection

