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
                    @if($job->prerequisites->count())
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
                    @endif
                    @if(auth()->user())
                    <tr>
                        <td>Apply</td>
                        <td>
                            <div v-cloak v-show="!jobApplied" class="apply-button">
                                <button v-on:click="applyJob" class="btn btn-primary applyjob">Apply</button>
                            </div>
                            <div v-cloak v-show="jobApplied" class="job-applied alert alert-info" transition="expand">
                                <span>@{{ notificationText }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Like this Job? </td>
                        <td>
                            <button class="btn btn-default" v-on:click="likeJob">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                Like (@{{ jobLikes }})
                            </button>
                        </td>
                    </tr>
                    @endif
                </table>

                <div class="col-md-12">
                    <a href="{{ route('jobs.next', $job->id) }}" class="btn btn-primary">Next Job</a>
                </div>

            </div>


            <!-- Modal Body -->
            <div class="modal" id="jobApplicationModal" tabindex="-1" role="dialog" aria-labelledby="jobApplicationModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3 v-show="resumeUploaded">Are you sure you want to apply for this job?</h3>
                            <h3 v-show="!resumeUploaded">Please upload your resume to process this job application</h3>
                            <h3 v-show="resumeUploaded && shouldShowPrerequisites">Please confirm the Prerequisites</h3>
                            <h3 v-show="jobApplied && matchedJobs.length">Here are some matching jobs</h3>
                        </div>

                        <div class="modal-body">

                            <div id="matchedJobs" v-show="jobApplied && matchedJobs.length">

                            </div>

                            <div v-show="resumeUploaded && shouldShowPrerequisites" class="form-horizontal">
                                @if($job->prerequisites->count())
                                    <ul class="list-group">
                                        @foreach($job->prerequisites as $prerequisite)
                                            <li class="list-group-item">
                                                {{ $prerequisite->content }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                    <p>You might want to make sure you satisfy the above mentioned prerequisite</p>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" v-model="prerequisiteConfirmed">
                                            Yes, I agree that I qualify these prerequisite(s)
                                        </label>
                                    </div>
                                @endif
                            </div>

                            <div v-show="resumeUploaded">
                                <button
                                        class="btn btn-default"
                                        v-bind:class="{ 'disabled': !prerequisiteConfirmed }"
                                        v-on:click="sendJobApplication"
                                >
                                    Yes, Apply for this job.
                                </button>

                                &nbsp;
                                &nbsp;

                                <button
                                        class="btn btn-default"
                                        v-on:click="cancelJobApplication"
                                >
                                    No, I dont want to apply for this job.
                                </button>
                            </div>

                            <div v-show="!resumeUploaded" class="form-horizontal">
                                <form enctype="multipart/form-data" method="post" action="{{ route('frontend.profile.resume') }}" id="upload-resume"></form>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <!-- Modal Body -->


        </div>

    </div>

    </div>

@endsection

@section('after-scripts-end')
    <script>

            Dropzone.autoDiscover = false

            var JobView = new Vue({
                el: '.job-view',

                data: {
                    job: {!! $job->toJSON() !!},
                    jobId:{{ $job->id }},
                    companyId:{{ $job->company->id }},
                    jobLikes: {{ $job->likes }},
                    shownPrerequisites: false,
                    jobApplied: {{ $job->job_applied ? 'true' : 'false' }},
                    clickEvent: false,
                    prerequisiteConfirmed: false,
                    notificationText: 'You already have applied for this job.',
                    registered              : {{ auth()->guest() ? "false" : "true" }},
                    matchedJobs: [],
                    resumeUploaded          : {{ auth()->user() && auth()->user()->job_seeker_details && auth()->user()->job_seeker_details->has_resume ? "true" : "false" }}
                },

                computed: {
                    shouldShowPrerequisites: function(){
                        return this.job.prerequisites.length ? true : false
                    }
                },

                methods:{
                    likeJob:function(event){
                        var that = this;
                        $.ajax({
                            url : '/jobs/job/like',
                            method  : 'post',
                            data : {
                                jobId:this.jobId,
                                '_token' : $('meta[name=_token]').attr("content")
                            },
                            success:function(data){
                                data = $.parseJSON(data);
                                JobView.jobLikes = Number(data.likes);
                            }
                        });

                    },

                    applyJob: function(event){
                        event.preventDefault();
                        $(event.target).button('loading');
                        if ( this.shouldShowPrerequisites ) {
                            if ( this.resumeUploaded ) {
                                $("#jobApplicationModal").modal();
                            } else {
                                this.enableDropZone();
                                this.clickEvent = event;
                                $("#jobApplicationModal").modal();
                            }
                        } else {
                            this.prerequisiteConfirmed = true;
                            if ( this.resumeUploaded ) {
                                $("#jobApplicationModal").modal();
                            } else {
                                this.enableDropZone();
                                this.clickEvent = event;
                                $("#jobApplicationModal").modal();
                            }
                        }
                    },

                    sendJobApplication: function(event) {
                        var that = this;
                        $.post( "{{ route('job.apply') }}",
                                { jobId: this.jobId, companyId: this.companyId },
                                function(data){
                                    $(event.target).button('reset');
                                    var modalOpen = ($("#jobApplicationModal").data('bs.modal') || {}).isShown;
                                    if ( modalOpen )  $("#jobApplicationModal").modal('toggle');
                                    that.notificationText = "Thanks for applying this job";
                                    that.jobApplied = true;
                                    that.showMatchedJobs();
                                }).error(function(err, data){
                                    $(event.target).button('reset');
                                });
                    },

                    showMatchedJobs: function(){
                        var that = this;
                        $.post( "{{ route('job.matchedjobs') }}",
                                { jobId: this.jobId, companyId: this.companyId },
                                function(data){
                                    data = JSON.parse(data);
                                    that.matchedJobs = data.jobs;
                                    $("#matchedJobs").html(data.view);
                                }).error(function(err, data){

                                });
                    },

                    cancelJobApplication: function(event){
                        $("#jobApplicationModal").modal('toggle');
                        $('.applyjob').button('reset');
                    },

                    enableDropZone: function(){

                        var that = this;

                        $("#upload-resume").addClass('dropzone').dropzone({
                            url: "{{ route('frontend.profile.resume') }}",
                            paramName: "file",
                            maxFilesize: 5,
                            accept: function (file, done) {
                                console.log(file);
                                if (
                                        ( file.type == 'application/msword' ) ||
                                        ( file.type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) ||
                                        ( file.type == 'application/pdf' ) ||
                                        ( file.type == 'application/kswps' )
                                ) {
                                    done();
                                } else {
                                    alert('Please upload doc/docx/pdf files')
                                }
                            },
                            sending: function (file, xhr, data) {
                                data.append('_token', $('meta[name="_token"]').attr('content'));
                            },
                            success: function (file, xhr) {
                                that.resumeUploaded = true;
                            }
                        });
                    }
                }
            });


    </script>
@endsection
