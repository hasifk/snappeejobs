@extends('emails.layout')

@section('heading')
	SnappeeJobs: Confirm your account!
@endsection

@section('content')
	{{ trans('strings.click_here_to_reset') }} <a href="{{ url('password/reset/' . $token) }}">Reset Password</a>
@endsection
