@extends('frontend.layouts.masternew')

@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div style="min-height:300px; margin-top: 80px;" class="row">

                <table class="table table-responsive">
                    <tr>
                        <td>Subject</td>
                        <td>{{ $thread->subject }}</td>
                    </tr>
                    <tr>
                        <td>Sent At</td>
                        <td>{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans() }}</td>
                    </tr>
                </table>

                <div style="margin-bottom: 25px;" class="mailbox-controls with-border text-center">
                    <div class="btn-group">
                        <a href="{{ route('admin.employer.mail.destroy', $thread->id) }}" data-method="delete" class="btn btn-default btn-sm">
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
                                    <img class="img-circle" src="{{ \App\Models\Access\User\User::find($message->sender_id)->getPictureAttribute(25, 25) }}" alt="User">
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

                <div>

                    {!! Form::open(['route' => ['frontend.message.reply', $thread->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

                    <textarea name="message" id="message" cols="30" rows="10" class="form-control textarea" placeholder="Type your reply here"></textarea>

                    <div class="well">
                        <div class="pull-left">
                            <a href="{{route('jobseeker.appliedjobs')}}" class="btn btn-danger btn-xs">{{ 'Discard' }}</a>
                        </div>

                        <div class="pull-right">
                            <input type="submit" class="btn btn-success btn-xs" value="{{ 'Send Message' }}" />
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    {!! Form::close() !!}

                </div>

                <div class="clearfix"></div>

            </div>

        </div>

@endsection

@section('after-scripts-end')
    <script>

        $(document).ready(function(){
            socket.on('user.{{ auth()->user()->id }}:employerchat-received', function(data){
                $(".mail_messages").append('<div class="mailbox-read-message"><div class="row"><div class="col-md-1">'+ data.message_details.image +'</div><div class="col-md-9">'+ data.message_details.last_message_original +'</div><div class="col-md-2">'+ data.message_details.was_created +'</div></div></div><hr>');
            });
        });

    </script>
@endsection