@extends ('backend.layouts.master')

@section ('title', 'Group Chat')

@section('after-styles-end')
    <script src="http://cdn.ckeditor.com/4.4.4/basic/ckeditor.js"></script>
@endsection

@section('page-header')
    <h1>
        Group Chat
    </h1>
@endsection

@section('content')

    <div class="group-chat-container">

        <form method="POST" v-on:submit="sendMessage" action="" accept-charset="UTF-8" class="form-horizontal" role="form">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="message" class="col-lg-2 control-label">Message:</label>
            <div class="col-lg-10">
                <textarea name="message" id="message" cols="30" rows="4" class="form-control"></textarea>
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
        </div>

        {!! Form::close() !!}
    </div>

    <div class="group_messages">
        @foreach($group_messages as $message)
            <div class="mailbox-read-message">
                <div class="row">
                    <div class="col-md-1">
                        <img style="height: 25px; width: 25px;" src="{{ \App\Models\Access\User\User::find($message->sender_id)->getPictureAttribute(25, 25) }}" alt="User">
                    </div>
                    <div class="col-md-9">
                        {!! preg_replace($group_contacts_names, $group_contacts_replace_names, $message->message) !!}
                    </div>
                    <div class="col-md-2">
                        {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>

@stop

@section('after-scripts-end')
    {!! HTML::script('js/backend/access/permissions/script.js') !!}
    {!! HTML::script('js/backend/access/users/script.js') !!}

    <script>

        var at_config = {
            at: "@",
            data: {!! json_encode($group_contacts) !!},
            insertTpl: "@${name}"
        };

        $('#message').atwho(at_config);


        var groupChatContainer = new Vue({
            el: '.group-chat-container',

            methods: {
                sendMessage: function(event){
                    event.preventDefault();

                    var message = $("#message").val();

                    $.post( "{{ route('admin.employer.groupchat.sendmessage') }}",
                            { message: message },
                            function(data){
                                $("#message").val("");
                            }).error(function(err, data){}
                    );

                }
            }
        });


        $(document).ready(function(){

            socket.on('group_chat{{ $group_token }}:chat_received', function(data){
                $(".group_messages").prepend('<div class="mailbox-read-message"><div class="row"><div class="col-md-1"><img style="height: 25px; width: 25px;" src="'+ data.eventDetails.sender_picture +'" alt="User"></div><div class="col-md-9">'+ data.eventDetails.message +'</div><div class="col-md-2">'+ data.eventDetails.sent_at +'</div></div></div><hr>');
            });

        });

    </script>

@stop
