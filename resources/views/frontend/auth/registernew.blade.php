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
            {!! Form::label('gender', "Gender", ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
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
            {!! Form::label('dob', "Date of Birth", ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <input
                        class="form-control bootstrap-datepicker"
                        placeholder="Date of Birth"
                        name="dob"
                        type="text"
                        id="dob"
                        value="{{ old('dob') }}"
                >
            </div>
        </div>

        <div class="form-group">
            <label for="office_life" class="col-md-4 control-label">Country</label>
            <div class="col-md-6">
                <select name="country_id" id="country_id" class="form-control">
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
            <label for="office_life" class="col-md-4 control-label">State</label>
            <div class="col-md-6">
                <select name="state_id" id="state_id" class="form-control">
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
                {!! Form::submit(trans('labels.register_button'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
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
        });
    </script>
@endsection
