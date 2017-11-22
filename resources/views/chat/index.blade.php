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
    right: 0;
    overflow-y: scroll;
    margin-right: -100px;
    padding-right: 100px;
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
.red
{
    background-color: red;
}

    </style>
@endsection

@section('content')
    <div id="chat" style="height: 35em;">
        <div id="rooms" class="col-md-3" style="height: 100%;">
            <h4 style="color: white; text-align: center;">Conversations</h4>
            <div class="parent" style="height: 100%;">
                <div class="list-group child">
                    <div class="list-group-item item" v-bind:class="seen(room)" v-for="room in Object.keys(rooms)" v-bind:data-room="room" v-on:click="setroom(room)">@{{room}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="height: 100%;border: 2px solid white;border-radius: 1em">
            <div class="parent" style="height: 100%;">
                <div id="chatbox" class="list-group child row">
                    <div class="col-md-12" v-for="mess in currentmessages" v-bind:data-user="mess.user.name">
                        <div v-bind:class="iscurrentuser(mess.user)" class="username"> @{{mess.user.name}} </div>
                        <div v-bind:class="iscurrentuser(mess.user)">
                            <p class="text">@{{mess.message}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <input class="form-control" placeholder="Envoyer un message..." style="width: 100%" type="text" v-model="message" v-on:keydown.enter="send">
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
                            var message={
                                hash: this.rooms[this.currentroom].hash,
                                message: this.message,
                                sender: this.currentuser,
                                receiver: this.rooms[this.currentroom].user
                            };
                            socket.emit('roomchat', message);
                            this.savemessage(message);
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
                    return this.currentuser.email===user.email? "boxsize currentuser pull-right": "boxsize otheruser pull-left";
                },
                cchatroom:function (user){
                    if(this.rooms[user.name]==null) {
                        socket.emit("roomchat.create", {
                            sender: this.currentuser,
                            receivers: [user]
                        });
                    }
                    else
                    {
                        this.currentroom=user.name;
                    }
                },
                setroom:function (room) {
                    $.when(this.currentroom=room).then(function () {
                        $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                    });
                    this.rooms[this.currentroom]['seen']=true;
                },
                savemessage:function (message) {
                   // $.post('/test1', { message: message, _token: {{csrf_token()}} });
                   $.ajax({
                        method: 'POST',
                        url: '/savemessages',
                        data: { message: message, _token: '{{csrf_token()}}' }
                   });
                },
                seen:function (room) {
                   return this.rooms[room].seen?"":"red";
                },
                loadlastmessages:function () {

                }
            },
            computed: {
                currentmessages:function () {
                    return this.rooms[this.currentroom].messages;
                }
            },
            data: {
                currentuser: @if(!\Illuminate\Support\Facades\Auth::guest()){email:'{{\Illuminate\Support\Facades\Auth::user()->email}}',name:'{{\Illuminate\Support\Facades\Auth::user()->name}}'}
                @else 'Anon' @endif,
                message: '',
                rooms:{Entreprise:{messages:[],seen:true}},
                currentroom:'Entreprise',
                messages: [],
                allusersonline: [],
                auth: @if(!\Illuminate\Support\Facades\Auth::guest()) {{'true'}} @else {{'false'}} @endif
            },
            mounted: function () {
                var app=this;

                socket.on('globalchat.message', function (data) {
                    $.when(app.rooms['Entreprise'].messages.push({user:data.user, message:data.message}))
                        .then(function(){
                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight)
                        });
                        if('Entreprise'!=app.currentroom)
                        app.rooms['Entreprise']['seen']=false;
                }.bind(this));

                socket.on('globalchat.users', function (data) {
                    this.allusersonline = $.parseJSON(data);
                }.bind(this));

                socket.on('roomchat.invite.'+app.currentuser.email, function (data) {
                    socket.emit("roomchat.confirm", {
                        confirm: true,
                        sender:app.currentuser,
                        hash:data.hash
                    });
                    app.rooms[data.sender.name]={};
                    app.rooms[data.sender.name]['messages']=[];
                    app.rooms[data.sender.name]['hash']=data.hash;
                    app.rooms[data.sender.name]['user']=data.sender;
                    app.rooms[data.sender.name]['seen']=true;
                    socket.on('roomchat.'+data.hash, function (data2) {
                        $.when(app.rooms[data.sender.name].messages.push({user:data2.sender, message:data2.message}))
                            .then(function(){
                                $.when(app.$forceUpdate()).then(function () {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                });
                            });
                        if(data.sender.name!=app.currentroom)
                        app.rooms[data.sender.name]['seen']=false;
                    }.bind(app));
                    app.currentroom=data.sender.name;
                }.bind(this));

                socket.on('roomchat.'+app.currentuser.email, function (data) {
                    app.rooms[data.receiver.name]={};
                    app.rooms[data.receiver.name]['messages']=[];
                    app.rooms[data.receiver.name]['hash']=data.hash;
                    app.rooms[data.receiver.name]['user']=data.receiver;
                    app.rooms[data.receiver.name]['seen']=true;
                    socket.on('roomchat.'+data.hash, function (data2) {
                        $.when(app.rooms[data.receiver.name]['messages'].push({user:data2.sender, message:data2.message}))
                            .then(function(){
                                $.when(app.$forceUpdate()).then(function () {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                });
                        });
                        if(data.receiver.name!=app.currentroom)
                        app.rooms[data.receiver.name]['seen']=false;
                    }.bind(app));
                    app.currentroom=data.receiver.name;
                }.bind(this));

                this.getuserlist();
            }
        });
    </script>
@endsection