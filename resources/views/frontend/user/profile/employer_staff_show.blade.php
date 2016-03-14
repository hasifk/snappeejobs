@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        @if(!empty($staff_in_detail))
        <div class="job-view panel panel-primary">

            <div class="panel-heading">
                {{ $staff_in_detail->name }}
            </div>

            <div class="panel-body">

                <ol class="breadcrumb">
                    <li><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                    <li class="active"><a href="">{{ $staff_in_detail->name }}</a></li>
                </ol>

                <table class="table">
                    <tr>
                        <td>Name</td>
                        <td>{{ $staff_in_detail->name }}</td>
                    </tr>
                    @if(!empty($staff_in_detail->avatar_filename))
                    <tr>
                        <td>Profile Image</td>
                        <td>
                            <img style="height: 50px; width: 50px;" src="{{ $staff_in_detail->getAvatarImage(50) }}" alt="{{ $staff_in_detail->name }}">
                        </td>
                    </tr>
                    @endif




                    @if($staff_in_detail->dob)
                        <tr>
                            <td>Age</td>
                            <td>{{ $staff_in_detail->age }}</td>
                        </tr>
                    @endif
                    @if($staff_in_detail->gender)
                        <tr>
                            <td>Gender</td>
                            <td>{{ $staff_in_detail->gender }}</td>
                        </tr>
                    @endif
                    @if($staff_in_detail->created_at)
                        <tr>
                            <td>Account Created At</td>
                            <td>{{ $staff_in_detail->created_at->diffForHumans() }}</td>
                        </tr>
                    @endif






                </table>

            </div>

        </div>

 @endif
    </div>

@endsection


