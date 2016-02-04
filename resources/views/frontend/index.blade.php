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

		@role('Administrator')
            {{-- You can also send through the Role ID --}}

		    <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.role') . trans('strings.using_blade_extensions') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 1: ' . trans('strings.you_can_see_because', ['role' => trans('roles.administrator')]) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
		@endauth

		@if (access()->hasRole('Administrator'))
		    <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.role') . trans('strings.using_access_helper.role_name') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 2: ' . trans('strings.you_can_see_because', ['role' => trans('roles.administrator')]) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
		@endif

		@if (access()->hasRole(1))
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.role') . trans('strings.using_access_helper.role_id') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 3: ' . trans('strings.you_can_see_because', ['role' => trans('roles.administrator')]) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endif

        @if (access()->hasRoles(['Administrator', 1]))
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.role') . trans('strings.using_access_helper.array_roles_not') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 4: ' . trans('strings.you_can_see_because', ['role' => trans('roles.administrator')]) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endif

        {{-- The second parameter says the user must have all the roles specified. Administrator does not have the role with an id of 2, so this will not show. --}}
        @if (access()->hasRoles(['Administrator', 2], true))
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.role') . trans('strings.using_access_helper.array_roles') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.you_can_see_because', ['role' => trans('roles.administrator')]) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endif

        @permission('view-backend')
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.permission') . trans('strings.using_access_helper.permission_name') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 5: ' . trans('strings.you_can_see_because_permission', ['permission' => 'view-backend']) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endauth

        @if (access()->hasPermission(1))
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.permission') . trans('strings.using_access_helper.permission_id') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 6: ' . trans('strings.you_can_see_because_permission', ['permission' => 'view_backend']) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endif

        @if (access()->hasPermissions(['view-backend', 1]))
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.permission') . trans('strings.using_access_helper.array_permissions_not') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.test') . ' 7: ' . trans('strings.you_can_see_because_permission', ['permission' => 'view_backend']) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endif

        @if (access()->hasPermissions(['view-backend', 2], true))
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('strings.based_on.permission') . trans('strings.using_access_helper.array_permissions') }}</div>

                    <div class="panel-body">
                        {{ trans('strings.you_can_see_because_permission', ['permission' => 'view_backend']) }}
                    </div>
                </div><!-- panel -->

            </div><!-- col-md-10 -->
        @endif

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
                                            {!! Form::label('age', "Age", ['class' => 'col-lg-4 control-label']) !!}
                                            <div class="col-lg-6">
                                                <input v-model="age" class="form-control" placeholder="Age" name="age" type="text" id="age">
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

                                    <div v-show="registered && !resumeUploaded" class="form-horizontal">
                                        <form enctype="multipart/form-data" method="post" action="{{ route('frontend.profile.resume') }}" id="upload-resume"></form>
                                    </div>


                                    <div v-show="resumeUploaded && !preferencesSaved" style="min-height: 400px;" class="form-horizontal">

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

	</div>


@endsection

@section('after-scripts-end')

	<script>

        (function(){

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
                    age                     : '',
                    errors                  : [],
                    user                    : {},
                    registered              : {{ auth()->guest() ? "false" : "true" }},
                    resumeUploaded          : {{ auth()->user() && auth()->user()->job_seeker_details && auth()->user()->job_seeker_details->has_resume ? "true" : "false" }},
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
                            that.modalHeading = 'Please upload your resume';
                            that.enableDropZone();

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
                                        location.reload();
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
                        homeRegisterApp.enableDropZone();
                        $("#registrationModal").modal();
                    @endif
            @endif
        })();

	</script>
@stop
