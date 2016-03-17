@extends ('backend.layouts.master')

@section ('title', "Inbox")

@section('page-header')
    <h1>
        Show Thread
        <small>Mail Thread Singleview</small>
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.mail.header-buttons')

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
                    <a href="{{ route('admin.mail.destroy', $thread->id) }}" data-method="delete" class="btn btn-default btn-sm">
                        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                        Delete
                    </a>
                </div>

            </div>

            <div class="mail_messages">
                @foreach($thread->messages as $message)
                    <div class="mailbox-read-message">
                        <div class="row">
                            <div class="col-md-1">
                                <img style="height: 25px; width: 25px;" src="{{ \App\Models\Access\User\User::find($message->sender_id)->picture }}" alt="User">
                            </div>
                            <div class="col-md-9">
                                {!! $message->content !!}
                            </div>
                            <div class="col-md-2">
                                {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>

        </div>
        <!-- /.box-footer -->
    </div>


    <div>

        {!! Form::open(['route' => ['admin.mail.reply', $thread->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

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


@section('after-scripts-end')
    <script>

        $(document).ready(function(){

        });

    </script>
@endsection
