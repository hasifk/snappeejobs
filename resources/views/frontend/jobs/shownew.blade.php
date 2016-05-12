@extends('frontend.layouts.masternew')

@section('after-styles-end')
    <style>
        .prerequisites-list-group li {
            margin-bottom:20px !important;
        }
        .job-details p {
            margin:10px 0 !important;
        }
    </style>
@endsection

@section('content')
@if(!empty($job))
<section style="margin-top: 50px;">
    <div class="bodycontent">
        <div class="container">
            <div class="job-view row job-details">
                <div class="col-md-10 col-md-offset-1 companies">
                    <h1>
                        {{ $job->company->title }}
                        <span>
                            @foreach($job->categories as $category)
                                {{ $category->name }},
                            @endforeach
                            {{ $job->statename }},
                            {{ $job->countryname }}
                        </span>
                    </h1>
                    <div class="boxWrap">
                        @if ( $job->company->photos->count() )
                            <?php $job_main_image = env('APP_S3_URL') .$job->company->photos->first()->path . $job->company->photos->first()->filename . '620x412.' . $job->company->photos->first()->extension; ?>
                        @else
                            <?php $job_main_image = 'https://placeholdit.imgix.net/~text?txtsize=28&txt=No image&w=640&h=412'; ?>
                        @endif
                        <div class="boxImage" style="background-image:url('{{ $job_main_image }}');"></div>
                        <div class="boxContent company-desc">
                            @if($job->company->logo_image)
                            <img style="width: 288px; height: 44px;;" src="{{ $job->company->logo_image }}" />
                            @endif
                            <p>{{ $job->company->description }}</p>
                            <a style="color: #337ab7;" href="mailto:?Subject=Thought you'd like to see inside {{ $job->company->title }}&body=Hey! I recently discovered Just Snapt It!, which showcases cool companies and what it's like to work there. When I saw the profile of {{ $job->company->title }}, I thought of you. Hope you enjoy! It's at: {{ $job->company->url_slug }}">
                                <img src="/images/mail-icon.png" />
                                Send to a friend
                            </a>
                            @if(auth()->user())
                                @roles(['User'])


                            <a  v-on:click="likeJob"  href="#" class="btn-fav">
                                <img class="likejob" src="/images/heart-{{ $job_liked ? 'icon' : 'grey' }}.png" />
                            </a>
                                @endauth
                            @endif
                            <br>
                            <a v-on:click="flagJob" style="color: #337ab7;" href="#" class="flag"><img src="/images/flag-down.png" /> Flag this job as down</a>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <h2 style="margin-left: 15px;">{{ $job->title }}</h2>
                    @if(auth()->user())
                        @roles(['User'])
                    <div v-cloak v-show="!jobApplied" class="apply-button col-md-12">
                        <button style="margin-bottom: 25px;" v-on:click="applyJob" class="btn btn-primary applyjob">APPLY NOW</button>
                    </div>
                    <div v-cloak v-show="jobApplied" style="margin-top: 25px;" class="job-applied alert alert-info" transition="expand">
                        <span>@{{ notificationText }}</span>
                    </div>
                        @endauth
                    @endif

                    <br>

                    <div style="margin-left: 15px;">{!! $job->description !!}</div>

                    <h3 style="margin-left: 15px;"><strong>About This Job</strong></h3>
                    <div class="col-lg-8 about-job">
                        <ul>
                            <li ><a href="#" class="level">{{ str_studly($job->level) }}</a></li>
                            <li><a href="#" class="location">{{ $job->statename }}, {{ $job->countryname }}</a> </li>
                            <li>
                                <a href="#" class="document">
                                    @foreach($job->categories as $category)
                                        {{ $category->name }}&nbsp;
                                    @endforeach
                                </a>
                            </li>
                        </ul>
                    </div>
                    @roles(['User'])
                    <a v-on:click="applyJob"  v-show="!jobApplied" href="#" class="btn-primary MB-60 applyjob">APPLY NOW</a>
                    @endauth
                    <a href="{{ route('jobs.next', $job->id) }}" class="btn-primary MB-60">NEXT JOB</a>


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
                                            <ul class="prerequisites-list-group">
                                                @foreach($job->prerequisites as $prerequisite)
                                                    <li>
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
                                            <br>
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
                            if(data.toggle=='liked')
                            {
                            $('img.likejob').attr('src', '/images/heart-icon.png');
                            }
                            else {
                                $('img.likejob').attr('src', '/images/heart-grey.png');
                            }
                        }
                    });

                },


                flagJob:function(event){
                    var that = this;
                    $.ajax({
                        url : '/jobs/job/flag',
                        method  : 'post',
                        data : {
                            jobId:this.jobId,
                            '_token' : $('meta[name=_token]').attr("content")
                        },
                        success:function(data){
                            swal('Flagged the job down.');
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
                    var that = this;
                    $.ajax({
                        url : '/jobs/job/dislike',
                        method  : 'post',
                        data : {
                            jobId:this.jobId,
                            cancel:true,
                            '_token' : $('meta[name=_token]').attr("content")
                        },
                        success:function(data){
                            data = $.parseJSON(data);
                            JobView.jobLikes = Number(data.likes);
                            $('img.likejob').attr('src', '/images/heart-icon.png');
                        }
                    });
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

