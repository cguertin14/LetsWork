@extends('layouts.master')

@section('styles')
    <style>
    body{
        background-color:#5d5d5d;
    }

.parent{
    height: 100%;
    width: 100%;
    overflow: hidden;
    position: relative;
}

.child{
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: -17px; /* Increase/Decrease this value for cross-browser compatibility */
    overflow-y: scroll;
}

.boxsize{
    width: 75%;
    height: auto;
    margin-bottom: .2em;
    padding-right: .3em;
    padding-left:  .3em;
    border-radius: .7em;
}

.text{
    vertical-align: middle;
    padding: .3em;
    margin: 0px;
}

.username{
    background-color: transparent !important;
}

.currentuser {
    text-align: right;
    color: white;
    background-color: #552AD6;
}

.otheruser{
    text-align: left;
    color: white;
    background-color: #474747;
}

.item{
    cursor:pointer;
}
    </style>
@endsection

@section('content')
    <div id="chat" style="height: 35em">
        <div id="rooms" class="col-md-3" style="height: 100%;">
            <h4 style="color: white; text-align: center;">Conversations</h4>
            <div class="parent" style="height: 100%;">
                <div class="list-group child">
                    <div class="list-group-item item" v-for="room in Object.keys(rooms)" v-bind:data-room="room">@{{room}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="height: 100%;">
            <div class="parent" style="height: 100%;">
                <div id="chatbox" class="list-group child row">
                    <div class="col-md-12" v-for="mess in rooms[currentroom].messages" v-bind:data-user="mess.user.name">
                        <div v-bind:class="iscurrentuser(mess.user.email)" class="username"> @{{mess.user.name}} </div>
                        <div v-bind:class="iscurrentuser(mess.user.email)">
                            <p class="text">@{{mess.message}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <input style="width: 100%" type="text" v-model="message" v-on:keydown.enter="send">
<!-- <button class="" v-on:click="send">Envoyer</button> -->
        </div>
        <div class="col-md-3" style="height: 100%;">
            <h4 style="color: white; text-align: center;">Utilisateurs Connectés</h4>
            <div class="parent" style="height: 100%;">
                <div class="list-group child">
                    <div class="list-group-item item" v-for="user in allotherusers()" v-bind:data-user="user.email" v-on:click="cchatroom(user)">@{{user.name}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var socket = io(location.protocol + '//' + location.hostname + ':3000');
        new Vue({
            el: "#chat",
            methods: {
                send: function (e) {
                    if (this.message != '') {
                        if(this.currentroom === 'Entreprise')
                        {
                            socket.emit("globalchat", {
                                user: this.currentuser,
                                message: this.message
                            });
                        }
                        else
                        {
                            socket.emit("roomchat", {
                                hash: this.rooms[this.currentroom]['hash'],
                                message: this.message,
                                sender: this.currentuser
                            });
                        }
                        this.message = '';
                    }
                    e.preventDefault();
                },
                getuserlist: function () {
                    socket.emit("globalchat.users.get", {
                        data: null
                    });
                },
                allotherusers:function () {
                    var cuser=this.currentuser;
                    return this.allusersonline.filter(function(x) { return x.email !== cuser.email; });
                },
                iscurrentuser: function (user) {
                    return this.currentuser.email===user? "boxsize currentuser pull-right": "boxsize otheruser pull-left";
                },
                cchatroom:function (user){
                    socket.emit("roomchat.create", {
                        sender: this.currentuser,
                        receivers:[user]
                    });
                }
            },
            computed: {

            },
            data: {
                currentuser: @if(!\Illuminate\Support\Facades\Auth::guest()){email:'{{\Illuminate\Support\Facades\Auth::user()->email}}',name:'{{\Illuminate\Support\Facades\Auth::user()->name}}'}
                @else 'Anon' @endif,
                message: '',
                rooms:{Entreprise:{messages:[]}},
                currentroom:'Entreprise',
                messages: [],
                allusersonline: [],
                auth: @if(!\Illuminate\Support\Facades\Auth::guest()) {{'true'}} @else {{'false'}} @endif
            },
            mounted: function () {
                socket.on('globalchat.message', function (data) {
                    $.when(
                    this.rooms[this.currentroom].messages.push({user:data.user, message:data.message})).then(function(){
                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight)});
                }.bind(this));
                socket.on('globalchat.users', function (data) {
                    this.allusersonline = $.parseJSON(data);
                }.bind(this));
                socket.on('roomchat.invite.'+this.currentuser.email, function (data) {
                    socket.emit("roomchat.confirm", {
                        confirm: true,
                        sender:this.currentuser,
                        hash:data.hash
                    });
                    this.rooms[data.sender.name]['messages']=[];
                    this.rooms[data.sender.name]['hash']=data.hash;
                    socket.on('roomchat.'+data.hash, function (data) {
                        $.when(this.rooms[data.sender.name].messages.push({user:data.user, message:data.message})).then(function(){
                            $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight)});}.bind(this));
                    this.currentroom=data.sender.name;
                }.bind(this));
                socket.on('roomchat.'+this.currentuser.email, function (data) {
                    this.rooms[data.receiver.name]['messages']=[];
                    this.rooms[data.receiver.name]['hash']=data.hash;
                    socket.on('roomchat.'+data.hash, function (data) {
                        $.when(this.rooms[data.receiver.name].messages.push({user:data.user, message:data.message})).then(function(){
                            $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight)});}.bind(this));
                    this.currentroom=data.receiver.name;
                }.bind(this));
                this.getuserlist();
            }
        });
    </script>
@endsection