@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>{{ trans('strings.backend.dashboard_title') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')
    
        @if (Session::has('tw_success'))
            <div class="alert alert-success">{{ Session::get('tw_success') }}</div>
        @endif
        @if (Session::has('tw_failure'))
            <div class="alert alert-danger">{{ Session::get('tw_failure') }}</div>
        @endif



        @roles(['Employer'])

        <h3 class="box-title">Add Twitter Screen Name</h3>


        {!! Form::open(array('url' =>  route('backend.storetwitterinfo'),'class' => 'form-inline')) !!}
        {{ csrf_field() }}
            @if(!empty($screenname))

                <div class="form-group">
                    <input type="text" name="tw_screen_name" class="form-control" value="{{$screenname}}" placeholder="screenname"/>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            @else
            <div class="form-group">
            <input type="text" name="tw_screen_name" class="form-control" value="{{old('tw_screen_name')}}" placeholder="screenname"/>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
           @endif
        {!! Form::close() !!}



        @endauth



@endsection

