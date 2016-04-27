@extends('frontend.layouts.masternew')

@section('content')

    <div class="container">

        <h1 class="text-center">Reset your password</h1>

        {!! Form::open(['to' => 'password/reset', 'class' => 'form-horizontal', 'role' => 'form']) !!}

        <input type="hidden" name="token" value="{{ $token }}">

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
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit(trans('labels.reset_password_button'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
