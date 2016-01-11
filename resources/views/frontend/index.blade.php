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

        @if (! access()->user() )

            <div class="col-md-10 col-md-offset-1">

                <div class="registration-panel panel panel-default">
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
                            <button type="submit" class="btn btn-primary">Improve Your Career</button>
                        </form>

                    </div>


                    <!-- Modal Body -->
                    <div class="modal" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h3>Complete your registration here</h3>
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
                                                <input v-on:click="validateRegistration($event)" class="btn btn-primary" type="submit" value="Register">
                                            </div>
                                        </div>

                                    </div>

                                    <div v-if="! registered" class="form-horizontal">
                                        <form action="{{ route('frontend.profile.resume') }}"
                                              class="dropzone"
                                              id="my-awesome-dropzone"></form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Body -->


                </div>

            </div>

        @endif

	</div>


@endsection

@section('after-scripts-end')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.js"></script>

	<script>
		//Being injected from FrontendController
		console.log(test);

        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            accept: function(file, done) {
//                console.log([file, done]);
            },
            sending: function(file, xhr, data){
//                data.append('_token', $('meta[name="_token"]').attr('content'));
//                data.append('stored_by', 'buyer');
            },
            success: function(file, xhr){
                console.log(xhr);
//                uploadView.uploads.push(xhr);
            }
        };


        (function(){

            var homeRegisterApp = new Vue({
                el: '.registration-panel',

                data: {
                    name                    : '',
                    email                   : '',
                    password                : '',
                    password_confirmation   : '',
                    gender                  : '',
                    age                     : '',
                    errors                  : [],
                    user                    : {},
                    registered              : {{ auth()->guest() ? "false" : "true" }}
                },

                methods: {
                    showModal: function(event){
                        event.preventDefault();
                        $("#registrationModal").modal();
                    },

                    validateRegistration: function(event){
                        $(event.target).attr('disabled', 'disabled');
                        var that = this;
                        $.post( "{{ route('frontend.access.validate') }}", this.$data, function(data){
                            $(event.target).removeAttr('disabled');
                            that.user = data.user;
                            that.registered = true;

                            $("div#my-awesome-dropzone").dropzone({ url: "/file/post" });
                        }).error(function(err, data){
                            var errorArray = [];
                            for(var key in err.responseJSON) {
                                var error = err.responseJSON[key];
                                error.forEach(function(element, index){
                                    errorArray.push(error[index]);
                                });
                            }
                            that.errors = errorArray;
                            $(event.target).removeAttr('disabled');
                        });

                    }
                }
            });

        })();

	</script>
@stop