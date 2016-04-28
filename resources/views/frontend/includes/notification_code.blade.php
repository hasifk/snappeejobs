<script>

            @if(auth()->user())

    var socket = io('http://{{ env('SOCKETIO_SERVER_IP', '127.0.0.1') }}:{{ env('SOCKETIO_SERVER_PORT', 8000) }}');

    var SnappeeJobsHeader = new Vue({
        el: '.notifications-header',

        data: {
            unread_messages: [],
            rejected_applications: [],
            unread_messages_order: -1,
            rejected_applications_order: -1
        },

        ready: function(){

            var that = this;

            $.post('{{ route('frontend.notification.unreadchats') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                if ( data.length ) {
                    that.unread_messages = data;
                }
            });

            $.post('{{ route('frontend.notification.rejected_applications') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                if ( data.length ) {
                    that.rejected_applications = data;
                }
            });

            // Listening to the socket
            socket.on('user.{{ auth()->user()->id }}:employerchat-received', function(data){
                that.unread_messages.push(data.message_details)
            });

        },

        methods: {
            mark_rejected_applications_read: function(){
                $.post('{{ route('frontend.notification.rejected_applications_mark_read') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){

                });
            }
        }
    });

    @endif

</script>