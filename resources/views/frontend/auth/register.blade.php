@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-8 col-md-offset-2">

			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('labels.register_box_title') }}</div>

				<div class="panel-body">

					<div class="row">
						<div class="col-md-12 text-center">
							<a href="/auth/login/linkedin" class="btn btn-primary">Connect with LinkedIn</a>
						</div>
					</div>
					<br>

					{!! Form::open(['to' => 'auth/register', 'class' => 'form-horizontal', 'role' => 'form']) !!}

						<div class="form-group">
							{!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('name', 'name', old('name'), ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('email', 'email', old('email'), ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('password', trans('validation.attributes.password'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control']) !!}
							</div>
						</div>

					<div class="form-group">
						{!! Form::label('gender', "Gender", ['class' => 'col-lg-4 control-label']) !!}
						<div class="col-lg-6">
							<div class="checkbox">
								<input
									   type="radio"
									   name="gender"
									   id="gender_male"
									   value="male"
									   {{ old('gender') == 'male' ? 'checked="checked"' : '' }}
								/>
								<label for="gender_male">Male</label>
							</div>
							<div class="checkbox">
								<input
									   type="radio"
									   name="gender"
									   id="gender_female"
									   value="female"
										{{ old('gender') == 'female' ? 'checked="checked"' : '' }}
								/>
								<label for="gender_female">Female</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						{!! Form::label('age', "Age", ['class' => 'col-lg-4 control-label']) !!}
						<div class="col-lg-6">
							<input
									class="form-control"
									placeholder="Age"
									name="age"
									type="text"
									id="age"
									value="{{ old('age') }}"
							>
						</div>
					</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit(trans('labels.register_button'), ['class' => 'btn btn-primary']) !!}
							</div>
						</div>

					{!! Form::close() !!}

				</div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- col-md-8 -->

    </div><!-- row -->
@endsection