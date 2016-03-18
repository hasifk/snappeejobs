@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>Notifications History</small>
    </h1>
@endsection


@section('content')

    <h3>Notifications History</h3>

    @if($notifications)
    <table class="table">
        <tr>
            <td>Action</td>
            <td>Title</td>
            <td>Person</td>
        </tr>
        @foreach($notifications as $notification)
        <tr>
            <td>{{ $notification->action }}</td>
            <td>{{ $notification->title }}</td>
            <td>{{ $notification->actiontaker }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    @unless($notifications)
        <h5>No Notifications</h5>
    @endunless

    <div class="col-md-12 center-block">
        {!! $paginator->render() !!}
    </div>

@endsection

