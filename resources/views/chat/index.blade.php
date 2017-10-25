@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div id="chat">
        <ul>
            <li v-for="mess in messages">@{{mess}}</li>
        </ul>
        <input type="text" v-model="message">
        <button v-on:click="send">Envoyer</button>
    </div>
@endsection

@section('scripts')
    <script>
        var socket = io('http://localhost:3000');
        new Vue({
            el:"#chat",
            methods:{
                send: function (e) {
                    socket.emit("chat.message", this.message);
                    e.preventDefault();
                }
            },
            data:{
                currentuser:{{Auth}}
                message:'',
                messages:[]
            },
            mounted:function () {
                socket.on('chat.message',function (message) {
                    this.messages.push(message);
                }.bind(this));
            }
        });
    </script>
@endsection