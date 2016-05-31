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
                    <a href="{{ $job_application->jobseeker->resume }}" class="btn btn-default btn-sm">Download Resume</a>

                </div>
                </div>
            @if(!empty($available_staffs))
                <div class="mailbox-controls with-border text-center">
                    <label>Please Attach an employer staff with this thread</label>
                <div class="btn-group">
                    <form method="POST" action="{{ route('admin.employer.mail.attachparticipant') }}" accept-charset="UTF-8" role="form" enctype='multipart/form-data' >
                        {{ csrf_field() }}
                    <select name="employer_staff" class="select2">
                       @foreach($available_staffs as $staff)
                            <option value="{{$staff->id}}">{{$staff->name}}</option>
                        @endforeach
                    </select>
                        <input type="submit" value="Attach" class="btn btn-primary">
                        </form>
                    </div>
            </div>
            @endif
            <div class="mail_messages">
                @foreach($thread->messages as $message)
                <div class="mailbox-read-message">
                    <div class="row">
                        <div class="col-md-1">
                            <img style="height: 25px; width: 25px;" src="{{ \App\Models\Access\User\User::find($message->sender_id)->getPictureAttribute(25, 25) }}" alt="User">
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

        {!! Form::open(['route' => ['admin.employer.mail.reply', $thread->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <textarea name="message" id="message" cols="30" rows="10" class="form-control textarea" placeholder="Type your reply here"></textarea>

        <div class="well">
            <div class="pull-left">
                <a href="{{route('backend.dashboard')}}" class="btn btn-danger btn-xs">{{ 'Discard' }}</a>
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
            socket.on('user.{{ auth()->user()->id }}:jobseekerchat-received', function(data){
                $(".mail_messages").append('<div class="mailbox-read-message"><div class="row"><div class="col-md-1"><img style="height: 25px; width: 25px;" src="'+ data.message_details.image +'" alt="User"></div><div class="col-md-9">'+ data.message_details.last_message_original +'</div><div class="col-md-2">'+ data.message_details.was_created +'</div></div></div><hr>');
            });
        });

    </script>
@endsection
