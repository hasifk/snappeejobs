@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="job-view panel panel-info">

            @if(!empty($applied))

                <table class="table">
                    <tr>
                        <th>Job</th>
                        <th>Company</th>
                        <th>Applied</th>
                        <th>Status</th>
                        <th>Conversation</th>
                    </tr>
                    @foreach($applied as $application)
                    <tr>
                        <td>
                            {{ $application->title }}
                        </td>
                        <td>
                            {{ $application->company_title }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}
                        </td>
                        <td>
                            @if ( is_null($application->accepted_at) && $application->declined_at )
                                Rejected
                            @elseif ( is_null($application->declined_at) && $application->accepted_at )
                                Accepted
                            @else
                                Not decided
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('frontend.message', $application->thread_id) }}" class="btn btn-primary">Conversation</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

            @endif

        </div>

    </div>

@endsection

