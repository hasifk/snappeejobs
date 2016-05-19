@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>{{ trans('strings.backend.profile_title') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.profile')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.profile') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
          <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form enctype="multipart/form-data" accept-charset="UTF-8" action="/admin/profile" method="POST" role="form">
      
            {{ csrf_field() }}

            <legend>Profile</legend>
          
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
              <label for="">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password">
            </div>

            <div class="form-group">
              <label for="">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
            </div>

            <div class="form-group">
              <label for="">Avatar</label>
              <input type="file" class="form-control" name="avatar" placeholder="Avatar">
            </div>

            <div class="form-group">
              <label for="">About me</label>
                <textarea name="about_me" cols="30" rows="10" class="form-control">{{ $user->about_me }}</textarea>
            </div>

            <div class="form-group">
              <label for="">Country</label>
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

            <div class="form-group">
              <label for="">State</label>
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

            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div><!-- /.box-body -->
    </div><!--box box-success-->
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