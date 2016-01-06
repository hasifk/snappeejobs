@extends ('backend.layouts.master')

@section ('title', "Inbox")

@section('page-header')
    <h1>
        Show Thread
        <small>Mail Thread Singleview</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.mail.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.mail.header-buttons')

    <div class="box box-primary">

        <div class="box-body no-padding">
            <div class="mailbox-read-info">
                <h3>{{ $thread->subject }}</h3>
                <h5>From: {{ $thread->messages()->orderBy('created_at', 'desc')->first()->sender->name }}
                    <span class="mailbox-read-time pull-right">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans() }}</span></h5>
            </div>
            <!-- /.mailbox-read-info -->
            <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                        <i class="fa fa-trash-o"></i></button>
                </div>

            </div>

            <div class="mailbox-read-message">
                {!! $thread->last_message !!}
            </div>

        </div>
        <!-- /.box-footer -->
    </div>


    <div>

        {!! Form::open(['route' => ['admin.employer.mail.reply', $thread->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <textarea name="message" id="message" cols="30" rows="10" class="form-control textarea" placeholder="Type your reply here"></textarea>

        <div class="well">
            <div class="pull-left">
                <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">{{ 'Discard' }}</a>
            </div>

            <div class="pull-right">
                <input type="submit" class="btn btn-success btn-xs" value="{{ 'Send Message' }}" />
            </div>
            <div class="clearfix"></div>
        </div>

        {!! Form::close() !!}

    </div>

    <div class="clearfix"></div>
@stop