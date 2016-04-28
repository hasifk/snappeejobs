@extends('frontend.layouts.masternew')

@section('content')

    <div class="container">



        <h1 class="text-center">Forgot Password ? </h1>

        {!! Form::open(['to' => 'password/email', 'class' => 'form-horizontal', 'role' => 'form']) !!}

        <div class="form-group">
            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('email', 'email', old('email'), ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit(trans('labels.send_password_reset_link_button'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
