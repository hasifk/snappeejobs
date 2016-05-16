@extends('emails.layout')

@section('heading')
	SnappeeJobs: Confirm your account!
@endsection

@section('content')
	Hi {{$username}},
    {{$company_title}} created a new job.Please check this <a href="{{ url('job/' . $company.'/'.$job) }}">{{$job_title}}</a>
@endsection