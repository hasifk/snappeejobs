@extends('frontend.layouts.masternew')

@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div class="row">

                <div style="min-height:250px;" class="col-sm-10 col-sm-offset-1">

                    <h2 class="text-center">Applied Jobs</h2>

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
                                        @if($application->thread_id)
                                        <a href="{{ route('frontend.message', $application->thread_id) }}" class="btn btn-primary">Conversation</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    @else
                        <hr>
                        <h4 class="text-center">You have not applied for any jobs yet.</h4>
                    @endif

                </div>
            </div>
        </div>

@endsection