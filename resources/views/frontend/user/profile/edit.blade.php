@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('labels.update_information_box_title') }}</div>

				<div class="panel-body">

                    <form class="form-horizontal" enctype="multipart/form-data" accept-charset="UTF-8" action="{{ route('frontend.profile.update') }}" method="POST" role="form">

                        {{ csrf_field() }}

                              <div class="form-group">
                                    {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::input('text', 'name', $user->name, ['class' => 'form-control']) !!}
                                    </div>
                              </div>

                              @if ($user->canChangeEmail())
                                  <div class="form-group">
                                      {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-4 control-label']) !!}
                                      <div class="col-md-6">
                                          {!! Form::input('email', 'email', null, ['class' => 'form-control']) !!}
                                      </div>
                                  </div>
                              @endif

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="">Avatar</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="avatar" placeholder="Avatar">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="">About me</label>
                                <div class="col-md-6">
                                    <textarea name="about_me" cols="30" rows="10"
                                              class="form-control">{{ $user->about_me }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="">Country</label>
                                <div class="col-md-6">
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($countries as $country)
                                            <option
                                                    value="{{ $country->id }}"
                                                    {{ $user->country_id == $country->id ? 'selected="selected"' : '' }}
                                                    {{ !$user->country_id && $country->id == 222 ? 'selected="selected"' : '' }}
                                            >
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="">State</label>
                                <div class="col-md-6">
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($states as $state)
                                            <option
                                                    value="{{ $state->id }}"
                                                    {{ $user->state_id == $state->id ? 'selected="selected"' : '' }}
                                            >
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      {!! Form::submit(trans('labels.save_button'), ['class' => 'btn btn-primary']) !!}
                                  </div>
                              </div>

                       {!! Form::close() !!}

				</div><!--panel body-->

			</div><!-- panel -->

		</div><!-- col-md-10 -->

	</div><!-- row -->
@endsection

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#country_id').on('change', function(){
                $.getJSON('/admin/get-states/'+$(this).val(), function(json){
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