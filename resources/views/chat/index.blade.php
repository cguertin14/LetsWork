@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div id="chat">
        <div id="chatbox" style="overflow: scroll;height: 20em;">
        <ul class="list-group">
            <li class="" v-for="mess in messages">@{{mess}}</li>
        </ul>
        </div>
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
                    socket.emit("chat.message",{
                        user:this.currentuser,
                        message:this.message
                    });
                    e.preventDefault();
                },
                connection:function () {
                    socket.emit("user.connection",{
                        user:this.currentuser
                    });
                }
            },
            data:{
                currentuser:'@if(!\Illuminate\Support\Facades\Auth::guest()){{\Illuminate\Support\Facades\Auth::user()->email}}@else Anon @endif',
                message:'',
                messages:[]
            },
            mounted:function () {
                socket.on('chat.message',function (data) {
                    this.messages.push(data.user+"> "+data.message);
                    $("#chatbox").scrollTop(100000000);
                }.bind(this));
                socket.on(this.currentuser + '.askedroomjoin',function (data) {
                    alert(data.room);
                }.bind(this));
            }
        });
    </script>
@endsection