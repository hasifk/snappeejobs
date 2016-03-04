@extends('frontend.layouts.master')

@section('content')

    <div class="box box-primary">

        <div class="box-body no-padding">
            <div class="mailbox-read-info">
                <h3>{{ $thread->subject }}</h3>
                <br>
                <h5>From: {{ $thread->messages()->orderBy('created_at', 'desc')->first()->sender->name }}
                    <span class="mailbox-read-time pull-right">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans() }}</span></h5>
            </div>


            <!-- /.mailbox-read-info -->
            <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                    <a href="{{ route('admin.employer.mail.destroy', $thread->id) }}" data-method="delete" class="btn btn-default btn-sm">
                        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                        Delete
                    </a>
                </div>

            </div>

            @foreach($thread->messages as $message)
                <div class="mailbox-read-message">
                    {!! $message->content !!}
                </div>
                <hr>
            @endforeach

        </div>
        <!-- /.box-footer -->
    </div>


    <div>

        {!! Form::open(['route' => ['frontend.message.reply', $thread->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

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

@endsection
