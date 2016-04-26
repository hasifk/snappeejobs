@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="job-view panel panel-primary">

            <div class="panel-heading">
                {{ $jobseeker_user->name }}
            </div>

            <div class="panel-body">

                <ol class="breadcrumb">
                    <li><a href="{{ route('jobseeker.search') }}">JobSeekers</a></li>
                    <li class="active"><a href="">{{ $jobseeker_user->name }}</a></li>
                </ol>

                <table class="table">
                    <tr>
                        <td>Name</td>
                        <td>{{ $jobseeker_user->name }}</td>
                    </tr>
                    <tr>
                        <td>Profile Image</td>
                        <td>
                            <img style="height: 50px; width: 50px;" src="{{ $jobseeker_user->getPictureAttribute(45, 45) }}" alt="{{ $jobseeker_user->name }}">
                        </td>
                    </tr>
                    @if($jobseeker_user->about_me)
                    <tr>
                        <td>About me</td>
                        <td>{{ $jobseeker_user->about_me }}</td>
                    </tr>
                    @endif
                    @if($jobseeker_user->country_id)
                    <tr>
                        <td>Country</td>
                        <td>{{ $jobseeker_user->countryname }}</td>
                    </tr>
                    @endif
                    @if($jobseeker_user->state_id)
                    <tr>
                        <td>Country</td>
                        <td>{{ $jobseeker_user->statename }}</td>
                    </tr>
                    @endif
                    @if($jobseeker_user->dob)
                    <tr>
                        <td>Age</td>
                        <td>{{ $jobseeker_user->age }}</td>
                    </tr>
                    @endif
                    @if($jobseeker_user->gender)
                    <tr>
                        <td>Gender</td>
                        <td>{{ $jobseeker_user->gender }}</td>
                    </tr>
                    @endif
                    @if($jobseeker_user->created_at)
                    <tr>
                        <td>Account Created At</td>
                        <td>{{ $jobseeker_user->created_at->diffForHumans() }}</td>
                    </tr>
                    @endif
                    @if($jobseeker->size)
                    <tr>
                        <td>Prefer working in company which is </td>
                        <td>{{ $jobseeker->size }}</td>
                    </tr>
                    @endif
                    @if($jobseeker->categories()->count())
                    <tr>
                        <td>Job Category Preferences</td>
                        <td>
                            <ul class="list-group">
                                @foreach($jobseeker->categories as $category)
                                    <li class="list-group-item">
                                        {{ $category->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    @if($jobseeker->industries()->count())
                    <tr>
                        <td>Job Industry Preferences</td>
                        <td>
                            <ul class="list-group">
                                @foreach($jobseeker->industries as $industry)
                                    <li class="list-group-item">
                                        {{ $industry->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    @if($jobseeker->skills()->count())
                    <tr>
                        <td>Skills</td>
                        <td>
                            <ul class="list-group">
                                @foreach($jobseeker->skills as $skill)
                                    <li class="list-group-item">
                                        {{ $skill->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    @if($jobseeker->images()->count())
                    <tr>
                        <td>Gallery</td>
                        <td>
                            <ul class="list-group">
                                @foreach($jobseeker->images as $image)
                                    <li class="list-group-item">
                                        <img src="{{ $image->image }}" alt="{{ $image->filename }}" style="max-width:50px; max-height: 50px;" >
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    @if($jobseeker->videos()->count())
                    <tr>
                        <td>Video Gallery</td>
                        <td>
                            <ul class="list-group">
                                @foreach($jobseeker->videos as $video)
                                    <li class="list-group-item">
                                        <video
                                                id="jobseeker_video"
                                                class="video-js vjs-default-skin"
                                                controls
                                                preload="auto"
                                                data-setup='{}'
                                                style="max-width: 100%;"
                                        >
                                            <source src="{{ $video->video }}" type='video/{{ $video->extension }}'>
                                        </video>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    @if(auth()->user())
                    <tr>
                        <td>Like this Jobseeker? </td>
                        <td>
                            <button class="btn btn-default likejobseeker">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                Like (<span class="like">{{ $jobseeker->likes ? $jobseeker->likes : 0 }}</span>)
                            </button>
                        </td>
                    </tr>
                    @endif
                </table>

            </div>

        </div>

    </div>

@endsection

@section('after-scripts-end')

    <script>

        $(document).ready(function(){

            $('.likejobseeker').on('click', function () {

                $.ajax({
                    url : '{{ route('jobseeker.like') }}',
                    method  : 'post',
                    data : {
                        jobSeekerId: {{ $jobseeker->id }},
                        '_token' : $('meta[name=_token]').attr("content")
                    },
                    success:function(data){
                        data = $.parseJSON(data);
                        $('.likejobseeker .like').html(data.likes);
                    }
                });

            });

        });

    </script>

@endsection
