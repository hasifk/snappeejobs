@extends('frontend.layouts.masternew')

@section('content')

    <div class="container">

        <br>
        <br>

        <div class="row">
            <div class="col-md-12 text-center">
                <a href="/auth/login/linkedin" class="btn btn-primary">Connect with LinkedIn</a>
            </div>
        </div>
        <br>

        {!! Form::open(['url' => 'auth/login', 'class' => 'form-horizontal', 'role' => 'form']) !!}

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
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('remember') !!} {{ trans('labels.remember_me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit(trans('labels.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) !!}

                {!! link_to('password/email', trans('labels.forgot_password')) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
