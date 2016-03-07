@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-home"></i> {{ trans('navs.home') }}</div>

				<div class="panel-body">
					{{ trans('strings.welcome_to', ['place' => app_name()]) }}
				</div>
			</div><!-- panel -->

		</div><!-- col-md-10 -->


        <div class="col-md-10 col-md-offset-1">

            <div
                    v-cloak
                    v-show="!registered || !resumeUploaded || !preferencesSaved"
                    v-bind:class="{ 'panel-default' : !registered, 'panel' : !registered }"
                    class="homepage-modal panel panel-default"
            >

                @if( auth()->guest() )

                    <div class="panel-heading">
                        <h1>DO YOU LOVE YOUR CAREER?</h1>
                    </div>

                    <div class="panel-body">

                        <p>Browse amazing jobs, get the help you need to advance your career, and wake up feeling excited to go work every day.</p>

                        <br>

                        <form v-on:submit.prevent="showModal($event)" action="" class="form-inline">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="name" type="text" class="form-control" id="name" name="name" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="email" type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Improve Your Career
                            </button>
                        </form>

                    </div>

                    @endif

                            <!-- Modal Body -->
                    <div class="modal" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">

                                    <div v-if="registered && !confirmed" class="alert alert-info">
                                        Please confirm your account by following the email sent to your account.
                                    </div>

                                    <h3>@{{ modalHeading }}</h3>
                                </div>

                                <div class="modal-body">

                                    <div v-if="errors.length" class="alert alert-danger">
                                        <p>Oops, there are some errors. </p>
                                        <ul>
                                            <li v-for="error in errors">
                                                @{{ error }}
                                            </li>
                                        </ul>
                                    </div>


                                    <div v-if="! registered" class="form-horizontal">

                                        <div class="form-group">
                                            <label for="name" class="col-md-4 control-label">Name</label>
                                            <div class="col-md-6">
                                                <input v-model="name" class="form-control" name="name2" type="name" id="name2">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="col-md-4 control-label">E-mail</label>
                                            <div class="col-md-6">
                                                <input v-model="email" class="form-control" name="email" type="email" id="email">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="col-md-4 control-label">Password</label>
                                            <div class="col-md-6">
                                                <input v-model="password" class="form-control" name="password" type="password" id="password">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation" class="col-md-4 control-label">Password Confirmation</label>
                                            <div class="col-md-6">
                                                <input v-model="password_confirmation" class="form-control" name="password_confirmation" type="password" id="password_confirmation">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('gender', "Gender", ['class' => 'col-lg-4 control-label']) !!}
                                            <div class="col-lg-6">
                                                <div class="checkbox">
                                                    <input v-model="gender"
                                                           type="radio"
                                                           name="gender"
                                                           id="gender_male"
                                                           value="male"
                                                    />
                                                    <label for="gender_male">Male</label>
                                                </div>
                                                <div class="checkbox">
                                                    <input v-model="gender"
                                                           type="radio"
                                                           name="gender"
                                                           id="gender_female"
                                                           value="female"
                                                    />
                                                    <label for="gender_female">Female</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('dob', "Date of Birth", ['class' => 'col-lg-4 control-label']) !!}
                                            <div class="col-lg-6">
                                                <input v-model="dob" class="form-control bootstrap-datepicker" placeholder="Date of Birth" name="dob" type="text" id="dob">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="office_life" class="col-lg-4 control-label">Country</label>
                                            <div class="col-lg-6">
                                                <select v-model="country_id" name="country_id" id="country_id" class="form-control">
                                                    <option value="">Please select</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                                value="{{ $country->id }}"
                                                                {{ old('country_id') && $country->id == old('country_id') ? 'selected="selected"' : '' }}
                                                        >
                                                            {{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="office_life" class="col-lg-4 control-label">State</label>
                                            <div class="col-lg-6">
                                                <select v-model="state_id" name="state_id" id="state_id" class="form-control">
                                                    <option value="">Please select</option>
                                                    @foreach($states as $state)
                                                        <option
                                                                value="{{ $state->id }}"
                                                                {{ old('state_id') && $state->id == old('state_id') ? 'selected="selected"' : '' }}
                                                        >
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button
                                                        v-on:click="validateRegistration($event)"
                                                        class="btn btn-primary"
                                                        type="submit"
                                                        value="Register"
                                                        data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i> Register'
                                                >Register</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div v-show="registered && !avatarUploaded" class="form-horizontal">
                                        <form
                                                enctype="multipart/form-data"
                                                method="post"
                                                action="{{ route('frontend.profile.resume') }}"
                                                id="upload-profile-image"
                                        >
                                        </form>
                                    </div>

                                    <div v-show="registered && avatarUploaded && !resumeUploaded" class="form-horizontal">
                                        <form enctype="multipart/form-data" method="post" action="{{ route('frontend.profile.resume') }}" id="upload-resume"></form>
                                    </div>

                                    <div v-show="resumeUploaded && !preferencesSaved" style="min-height: 400px;" class="form-horizontal">

                                        <div class="form-group">
                                            <label for="description" class="col-lg-4 control-label">Industry</label>
                                            <div class="col-lg-6">
                                                <select
                                                        v-model="industries"
                                                        name="industries[]"
                                                        id="industries"
                                                        class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                        multiple="multiple"
                                                        style="width: 100%;"
                                                >
                                                    @if (count($industries) > 0)
                                                        @foreach($industries as $industry)
                                                            <option value="{{ $industry->id }}">
                                                                {{ $industry->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="col-lg-4 control-label">Skills</label>
                                            <div class="col-lg-6">
                                                <select
                                                        v-model="skills"
                                                        name="skills[]"
                                                        id="skills"
                                                        class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                        multiple="multiple"
                                                        style="width: 100%;"
                                                >
                                                    @if (count($skills) > 0)
                                                        @foreach($skills as $skill)
                                                            <option value="{{ $skill->id }}">
                                                                {{ $skill->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="col-lg-4 control-label">Preffered Job Categories</label>
                                            <div class="col-lg-6">
                                                <select
                                                        v-model="job_categories"
                                                        name="job_categories[]"
                                                        id="job_categories"
                                                        class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                                        multiple="multiple"
                                                        style="width: 100%;"
                                                >
                                                    @if (count($job_categories) > 0)
                                                        @foreach($job_categories as $job_category)
                                                            <option value="{{ $job_category->id }}">
                                                                {{ $job_category->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="col-lg-4 control-label">I prefer working in a company which is</label>
                                            <div class="col-lg-6">
                                                <div class="checkbox">
                                                    <input
                                                            type="radio"
                                                            name="size"
                                                            id="size_small"
                                                            v-model="size"
                                                            value="small" {{ request('size') == 'small' ? 'checked="checked"' : '' }}
                                                    />
                                                    <label for="size_small">Small</label>
                                                    &nbsp;
                                                    <input
                                                            type="radio"
                                                            name="size"
                                                            id="size_medium"
                                                            v-model="size"
                                                            value="medium" {{ request('size') == 'medium' ? 'checked="checked"' : '' }}
                                                    />
                                                    <label for="size_medium">Medium</label>
                                                    &nbsp;
                                                    <input
                                                            type="radio"
                                                            name="size"
                                                            id="size_big"
                                                            v-model="size"
                                                            value="big" {{ request('size') == 'big' ? 'checked="checked"' : '' }}
                                                    />
                                                    <label for="size_big">Big</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button
                                                        v-on:click="submitPreferences($event)"
                                                        class="btn btn-primary"
                                                        type="button"
                                                        value="Save"
                                                        data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i> Saving...'
                                                >Save</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div v-show="preferencesSaved" style="min-height: 400px;" class="form-horizontal">
                                        <h3>Thank you for completing the registration.</h3>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- Modal Body -->

            </div>

        </div>


        <div class="container">

            <div class="row">

                <div class="col-md-10 col-offset-1">

                    @if(count($pref_jobs_landing))

                        @foreach($pref_jobs_landing as $job)

                            <div class="col-md-4">
                                <div class="job-card">
                                    <div class="row">
                                        <div class="col-md-12 heading">
                                            <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                                        </div>
                                        <div class="col-md-12">

                                        </div>
                                        <div class="col-md-12 sub-heading">
                                            <a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                                {{ str_studly($job->company->title) }}
                                            </a>
                                            <br>
                                <span class="label label-danger">
                                    <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                        {{ str_studly($job->level) }}
                                    </a>
                                </span>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            @foreach($job->categories as $category)
                                                <div class="label label-info">
                                                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            @foreach($job->skills as $skill)
                                                <div class="label label-success">
                                                    <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                                        {{ $skill->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-12">
                                            <div for="" class="label label-info">
                                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                    {{ $job->country->name }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div for="" class="label label-info">
                                                <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                                    {{ $job->state->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    @elseif(count($jobs_landing))
                        @foreach($jobs_landing as $job)


                            <div class="col-md-4">
                                <div class="job-card">
                                    <div class="row">
                                        <div class="col-md-12 heading">
                                            <a href="{{ route('jobs.view' , [ $job->company->url_slug , $job->title_url_slug ] ) }}">{{ $job->title }}</a>
                                        </div>
                                        <div class="col-md-12">

                                        </div>
                                        <div class="col-md-12 sub-heading">
                                            <a href="{{ route('companies.view', ['slug' => $job->company->url_slug]) }}">
                                                {{ str_studly($job->company->title) }}
                                            </a>
                                            <br>
                                <span class="label label-danger">
                                    <a href="{{ route('jobs.search', ['level' => $job->level]) }}">
                                        {{ str_studly($job->level) }}
                                    </a>
                                </span>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            @foreach($job->categories as $category)
                                                <div class="label label-info">
                                                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            @foreach($job->skills as $skill)
                                                <div class="label label-success">
                                                    <a href="{{ route('jobs.search', ['skill' => $skill->id]) }}">
                                                        {{ $skill->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-12">
                                            <div for="" class="label label-info">
                                                <a href="{{ route('jobs.search', ['country' => $job->country_id]) }}">
                                                    {{ $job->country->name }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div for="" class="label label-info">
                                                <a href="{{ route('jobs.search', ['state' => $job->state_id]) }}">
                                                    {{ $job->state->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif

                </div>

            </div>

        </div>

	</div>


@endsection

@section('after-scripts-end')

	<script>

            Dropzone.autoDiscover = false

            var homeRegisterApp = new Vue({
                el: '.homepage-modal',

                data: {
                    modalHeading            : 'Complete your registration here',
                    name                    : '',
                    email                   : '',
                    password                : '',
                    password_confirmation   : '',
                    gender                  : '',
                    dob                     : '',
                    country_id              : '',
                    state_id                : '',
                    errors                  : [],
                    user                    : {},
                    registered              : {{ auth()->guest() ? "false" : "true" }},
                    confirmed               : {{ auth()->user() && auth()->user()->confirmed ? "true" : "false" }},
                    avatarUploaded          : {{ auth()->user() && auth()->user()->avatar_filename ? "true" : "false" }},
                    resumeUploaded          : {{ auth()->user() && auth()->user()->job_seeker_details && auth()->user()->job_seeker_details->has_resume ? "true" : "false" }},
                    industries              : [],
                    skills                  : [],
                    job_categories          : [],
                    size                    : '',
                    preferencesSaved        : {{ auth()->user() && auth()->user()->job_seeker_details && auth()->user()->job_seeker_details->preferences_saved ? "true" : "false" }},
                },

                methods: {
                    showModal: function(event){
                        event.preventDefault();
                        $("#registrationModal").modal();
                    },

                    validateRegistration: function(event){
                        $(event.target).button('loading');
                        var that = this;

                        $.post( "{{ route('frontend.access.validate') }}", this.$data, function(data){

                            $(event.target).button('reset');
                            that.user = data.user;
                            that.registered = true;
                            that.errors = [];
                            that.modalHeading = 'Please upload your profile image';
                            that.enableProfileImageUploadDropZone();

                        }).error(function(err, data){
                            var errorArray = [];
                            for(var key in err.responseJSON) {
                                var error = err.responseJSON[key];
                                error.forEach(function(element, index){
                                    errorArray.push(error[index]);
                                });
                            }
                            that.errors = errorArray;
                            $(event.target).button('reset');
                        });

                    },

                    enableProfileImageUploadDropZone: function(){

                        var that = this;

                        $("#upload-profile-image").addClass('dropzone').dropzone({
                            url: "{{ route('frontend.profileimage.update') }}",
                            dictDefaultMessage: 'Drag your profile image here or Click to upload.',
                            paramName: "file",
                            maxFilesize: 5,
                            accept: function (file, done) {
                                if (
                                        ( file.type == 'image/png' ) ||
                                        ( file.type == 'image/jpg' ) ||
                                        ( file.type == 'image/jpeg' ) ||
                                        ( file.type == 'image/bmp' )
                                ) {
                                    done();
                                } else {
                                    alert('Please upload an image file')
                                }
                            },
                            sending: function (file, xhr, data) {
                                data.append('_token', $('meta[name="_token"]').attr('content'));
                            },
                            success: function (file, xhr) {
                                that.modalHeading = 'Please upload your resume now';
                                that.avatarUploaded = true;
                                that.enableResumeUploadDropZone();
                            }
                        });
                    },

                    enableResumeUploadDropZone: function(){

                        var that = this;

                        $("#upload-resume").addClass('dropzone').dropzone({
                            url: "{{ route('frontend.profile.resume') }}",
                            dictDefaultMessage: 'Drag your resume file here or Click to upload.',
                            paramName: "file",
                            maxFilesize: 5,
                            accept: function (file, done) {
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
                                that.modalHeading = 'One more step, fill in your skills and job categories';
                                that.resumeUploaded = true;
                            }
                        });
                    },

                    submitPreferences: function(event){
                        $(event.target).button('loading');
                        var that = this;
                        $.post( "{{ route('frontend.profile.preferences') }}",
                                {
                                    industries      : $('select#industries').select2().val(),
                                    skills          : $('select#skills').select2().val(),
                                    job_categories  : $('select#job_categories').select2().val(),
                                    size            : $('input[type=radio][name=size]:checked').val()
                                },
                                function(data){
                                    $(event.target).button('reset');
                                    that.preferencesSaved = true;
                                    that.errors = [];
                                    that.modalHeading = '';
                                    setTimeout(function () {
                                        $("#registrationModal").modal('toggle');
                                        location.href = '{{ route('frontend.dashboard') }}'+"?confirmed=false";
                                    }, 1);
                                }).error(function(err, data){
                            var errorArray = [];
                            for(var key in err.responseJSON) {
                                var error = err.responseJSON[key];
                                error.forEach(function(element, index){
                                    errorArray.push(error[index]);
                                });
                            }
                            that.errors = errorArray;
                            $(event.target).button('reset');
                        });
                    }
                }
            });

            @if( auth()->user() && access()->hasRole('User') )

                    @if( auth()->user()->avatar_filename )

                        @if(
                            auth()->user()->job_seeker_details &&
                            auth()->user()->job_seeker_details->has_resume
                            )
                            homeRegisterApp.resumeUploaded = true;
    
                            @if(
                                auth()->user()->job_seeker_details &&
                                auth()->user()->job_seeker_details->preferences_saved
                                )
                                homeRegisterApp.preferencesSaved = true;
                            @else
                                homeRegisterApp.modalHeading = "Please save your preferences";
                                $("#registrationModal").modal();
                            @endif
    
                        @else
                            homeRegisterApp.modalHeading = "Please upload your resume";
                            homeRegisterApp.registered = true;
                            homeRegisterApp.enableResumeUploadDropZone();
                            $("#registrationModal").modal();
                        @endif
                        
                    @else

                        homeRegisterApp.modalHeading = "Please upload your profile image";
                        homeRegisterApp.registered = true;
                        homeRegisterApp.enableProfileImageUploadDropZone();
                        $("#registrationModal").modal();
                        
                    @endif
            @endif

            $('#country_id').on('change', function(){
                $.getJSON('/get-states/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });



	</script>
@stop
