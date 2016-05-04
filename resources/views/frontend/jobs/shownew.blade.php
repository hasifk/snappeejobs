@extends('frontend.layouts.masternew')

@section('content')
<div class="container">
    <div class="browse job-dtmenu">
        <div class="row">
            <div class="col-sm-6">
                <ul>
                    <li><a href="#">Browse</a></li>
                    <li style="width: auto;"><input type="text" name="" value="" placeholder="Search and Filter" /></li>
                </ul>
            </div>
            <div class="col-sm-6">
                <ul>
                    <li><a href="#" class="active">About<span></span></a></li>
                    <li><a href="#">Office</a></li>
                    <li><a href="#">People</a></li>
                    <li><a href="#">Jobs</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@if(!empty($job))
<section>
    <div class="bodycontent">
        <div class="container">
            <div class="row job-details">
                <div class="col-md-10 col-md-offset-1 companies">
                    <h1>{{ $job->company->title }}</h1>
                    <div class="boxWrap">
                        <div class="boxImage" style="background-image:url(images/companies/square-space.jpg);"></div>
                        <div class="boxContent company-desc">
                            @if ( $job->company->photos->count() )
                            <img src="{{env('APP_S3_URL') .$job->company->photos->first()->path . $job->company->photos->first()->filename . '620x412.' . $job->company->photos->first()->extension }}"/>
@endif
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <h2>{{ $job->title }}</h2>
                    @if(auth()->user())
                    <div v-cloak v-show="!jobApplied" class="apply-button col-md-12">
                        <button v-on:click="applyJob" class="btn btn-primary applyjob">Apply</button>
                    </div>
                    <div v-cloak v-show="jobApplied" class="job-applied alert alert-info" transition="expand">
                        <span>@{{ notificationText }}</span>
                    </div>
                    @endif
                    <h3><strong>Info</strong></h3>
                    <ul>
                        <li>Level:-{{ str_studly($job->level) }}</li>
                        <li>Country:-{{ $job->countryname }}</li>
                        <li>State:-{{ $job->statename }}</li>
                        <li>Posted:-{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</li>
                    </ul>
                    <h3><strong>Categories</strong></h3>
                    <ul>
                        @foreach($job->categories as $category)

                            <li> <span class="label label-default">
                                    {{ $category->name }}
                                </span></li>
                            &nbsp;
                        @endforeach
                    </ul>
                    <h3><strong>Skills</strong></h3>
                    <ul>
                        @foreach($job->skills as $skill)

                            <li> <span class="label label-default">
                                    {{ $skill->name }}
                                </span></li>
                            &nbsp;
                        @endforeach
                    </ul>
                    <h3><strong>Description</strong></h3>
                    <p>{!! $job->description !!}</p>
                    @if($job->prerequisites)
                    <h3><strong>Prerequisites</strong></h3>
                    <div class="col-lg-8 about-job">
                        <ul>
                            @foreach($job->prerequisites as $prerequisite)
                            <li > {{ $prerequisite->content }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(auth()->user())
                    @roles(['User'])
                        <h3><strong>Like this Job? </strong></h3>
                    <div>
                            <button class="btn btn-default" v-on:click="likeJob">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                Like (@{{ jobLikes }})
                            </button>
                    </div>

                    @endauth
                    @endif
                    <div class="col-md-12">
                        <a href="{{ route('jobs.next', $job->id) }}" class="btn btn-primary">Next Job</a>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal" id="jobApplicationModal" tabindex="-1" role="dialog" aria-labelledby="jobApplicationModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h3 v-show="resumeUploaded && !jobApplied">Are you sure you want to apply for this job?</h3>
                                    <h3 v-show="!resumeUploaded">Please upload your resume to process this job application</h3>
                                    <h3 v-show="resumeUploaded && shouldShowPrerequisites && !jobApplied">Please confirm the Prerequisites</h3>
                                    <h3 v-show="jobApplied && matchedJobs.length">
                                        Thank you for applying this job
                                        <br>
                                        Here are some matching jobs
                                    </h3>
                                </div>

                                <div class="modal-body">

                                    <div class="row" id="matchedJobs" v-show="jobApplied && matchedJobs.length"></div>

                                    <div v-show="resumeUploaded && shouldShowPrerequisites && !jobApplied" class="form-horizontal">
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

                                    <div v-show="resumeUploaded && !jobApplied">
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

    </div>
</section>
    @endif
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
                                if ( ! data.jobs.length ) {
                                    var modalOpen = ($("#jobApplicationModal").data('bs.modal') || {}).isShown;
                                    if ( modalOpen )  $("#jobApplicationModal").modal('toggle');
                                } else {
                                    that.matchedJobs = data.jobs;
                                    $("#matchedJobs").html(data.view);
                                }
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

