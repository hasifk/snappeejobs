@extends ('backend.layouts.master')

@section ('title', "Mailbox")

@section('page-header')
    <h1>
        Send Message
        <small>Mail Dashboard</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.mail.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.mail.header-buttons')

    {!! Form::open(['route' => 'admin.employer.mail.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        <label for="to" class="col-lg-2 control-label">To:</label>
        <div class="col-lg-10">
            <select name="to" id="to" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                <option value="">Please select</option>
                @foreach($to_users as $to_user)
                    <option value="{{ $to_user->id }}">{{ $to_user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="to" class="col-lg-2 control-label">Subject:</label>
        <div class="col-lg-10">
            <input type="text" name="subject" id="subject" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="message" class="col-lg-2 control-label">Message:</label>
        <div class="col-lg-10">
            <textarea name="message" id="message" cols="30" rows="10" class="form-control textarea"></textarea>
        </div>
    </div>

    <div class="well">
        <div class="pull-left">
            <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">{{ 'Discard' }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ 'Send Message' }}" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    {!! Form::close() !!}

    <div class="clearfix"></div>
@stop