@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="job-view panel panel-primary">

            <div class="panel-heading">
                {{ $job->title }}
            </div>
            <div class="panel-body">

                <ol class="breadcrumb">
                    <li><a href="{{ route('companies.view', $job->company->url_slug) }}">{{ $job->company->title }}</a></li>
                    <li class="active"><a href="">{{ $job->title }}</a></li>
                </ol>

                <table class="table">
                    <tr>
                        <td>Company</td>
                        <td>{{ $job->company->title }}</td>
                    </tr>
                    <tr>
                        <td>Job Title</td>
                        <td>{{ $job->title }}</td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>{{ str_studly($job->level) }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>{{ $job->countryname }}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>{{ $job->statename }}</td>
                    </tr>
                    <tr>
                        <td>Posted</td>
                        <td>{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</td>
                    </tr>
                    <tr>
                        <td>Categories</td>
                        <td>
                            @foreach($job->categories as $category)
                                <span class="label label-default">
                                    {{ $category->name }}
                                </span>
                                &nbsp;
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Skills</td>
                        <td>
                            @foreach($job->skills as $skill)
                                <span class="label label-default">
                                    {{ $skill->name }}
                                </span>
                                &nbsp;
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{!! $job->description !!}</td>
                    </tr>
                    <tr>
                        <td>Prerequisites</td>
                        <td>
                            <ul class="list-group">
                            @foreach($job->prerequisites as $prerequisite)
                                <li class="list-group-item">
                                    {{ $prerequisite->content }}
                                </li>
                            @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Apply</td>
                        <td>
                            <button class="btn btn-primary">Apply</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Like this Job? </td>
                        <td>
                            <button class="btn btn-default" v-on:click="likeJob" v-show={{ count(auth()->user()) }}>
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                Like (@{{ jobLikes }})
                            </button>
                        </td>
                    </tr>
                </table>

            </div>

        </div>

    </div>

@endsection

@section('after-scripts-end')
    <script>


            var JobView = new Vue({
                el: '.job-view',

                data: {
                    job: {!! $job->toJSON() !!},
                    jobId:{{ $job->id }},
                    jobLikes: {{ $job->likes }}
                },
                methods:{
                    likeJob:function(event){
                        var that = this;
                        event.preventDefault();

                        $.ajax({
                            url : '/jobs/job/like',
                            method  : 'post',
                            data : {
                                jobId:this.jobId,
                                '_token' : $('meta[name=_token]').attr("content")
                            },
                            success:function(data){

                                obj = $.parseJSON(data);

                                console.log(this);

                                that.jobLikes = obj.likes+1;

                            }
                        });

                    }
                }
            });


    </script>
@endsection
