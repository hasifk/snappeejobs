@extends('emails.layout')

@section('heading')
	SnappeeJobs: Confirm your account!
@endsection

@section('content')
	Click here to confirm your account 
	<a href="{{ url('account/confirm/' . $token) }}">Confirm Account</a>
@endsection
