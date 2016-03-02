@extends('frontend.layouts.master')

@section('before-scripts-end')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
@endsection

@section('content')

    <ul id="chats">
        <li v-for="chat in chats">
            @{{ chat.message }}
        </li>
    </ul>

@endsection

@section('after-scripts-end')

    <script>



        new Vue({
            el: '#chats',

            data: {
                chats: []
            },

            ready: function(){

                var that = this;


            }
        })

    </script>

@endsection
