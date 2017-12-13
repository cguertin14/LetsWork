@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        .parent {
            height: 100%;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .child {
            position: absolute;
            top: 0;
            bottom: 0;
            margin-bottom: 0;
            left: 0;
            right: 0;
            overflow-y: scroll;
            margin-right: -100px;
            padding-right: 100px;
        }

        .boxsize {
            width: auto;
            max-width: 70%;
            font-size: 1.2em;
            height: auto;
            margin-bottom: .2em;
            padding-right: .3em;
            padding-left: .3em;
            border-radius: .7em;
        }

        .boxsize2 {
            width: 100%;
            font-size: 1.2em;
            height: auto;
            margin-bottom: .2em;
            padding-right: .3em;
            padding-left: .3em;
            border-radius: .7em;
        }

        .text {
            vertical-align: middle;
            padding: .3em;
            margin: 0px;
            font-size: 1.1em;
        }

        .username {
            background-color: transparent !important;
        }

        .currentuser {
            text-align: right;
            color: white;
            background-color: #552AD6;
        }

        .otheruser {
            text-align: left;
            color: white;
            background-color: #474747;
        }

        .item {
            cursor: pointer;
            font-family: Ubuntu,sans-serif;
            font-size: 1.3em;
        }

        .red {
            background-color: #552AD6;
            color: white;
        }

        .yellow {
            text-align: center;
            background-color: #552AD6;
            color: white;
            font-style: italic;
        }

        [v-cloak] {
            display: none;
        }
        .header-col{
            font-family: Montserrat,sans-serif;
            font-size: 1.7em;
        }

        .footer {
            visibility: hidden;
        }

    </style>
@endsection

@section('content')
    <div id="chat" class="col-md-12" style="height: 55em;" v-cloak>
        <div id="rooms" class="col-md-3" style="height: 100%;">
            <h4 class="header-col" style="color: white; text-align: center;">Conversations</h4>
            <div class="parent" style="height: 100%;">
                <div class="list-group child">
                    <div class="list-group-item item content" v-bind:class="seen(room)" v-for="room in Object.keys(rooms)"
                         v-bind:data-room="room" v-on:click="setroom(room)">@{{room}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="height: 100%;border: 2px solid white;border-radius: 1em;background-color: gray;margin-top:3.3em">
            <div class="row" style="height: 77%">
                <div class="parent" style="height: 100%; margin-left: 2%;">
                    <div id="chatbox" class="list-group child row">
                        <div class="col-md-12" v-for="mess in currentmessages" v-bind:data-user="mess.user.name">
                            <div v-bind:class="iscurrentuserName(mess.user)" style="font-family: Ubuntu,sans-serif;font-weight: 700" class="username"> @{{mess.user.name}}</div>
                            <br>
                            <div v-bind:class="iscurrentuser(mess.user)">
                                <p class="text" style="font-family: Ubuntu,sans-serif">@{{mess.message}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <hr style="color: white;width: 100%">
            </div>
            <div class="row input-group input-group-lg" style="margin: 2em;">
                <input class="form-control input-lg" placeholder="Envoyer un message..." style="width: 100%" type="text"
                       v-model="message" v-on:keydown.enter="send">
                <span class="input-group-btn">
                    <button class="btn purplebtn" v-on:click="send">Envoyer</button>
                </span>
            </div>
        </div>
        <div class="col-md-3" style="height: 100%;">
            <h4 class="header-col" style="color: white; text-align: center;">Utilisateurs Connectés</h4>
            <div class="parent" style="height: 100%;">
                <div class="list-group child">
                    <div class="list-group-item item" v-bind:class="isnull(user)" v-for="user in allotherusers()" v-bind:data-user="user.email"
                         v-on:click="cchatroom(user)">@{{user.name}}
                    </div>
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
                        if (this.currentroom === 'Entreprise') {
                            socket.emit("globalchat", {
                                user: this.currentuser,
                                message: this.message
                            });
                            this.message = '';
                        }
                        else {
                            if (this.rooms[this.currentroom].hash == null) {
                                this.reco(this.currentroom);
                            }
                            else {

                                var message = {
                                    hash: this.rooms[this.currentroom].hash,
                                    message: this.message,
                                    sender: this.currentuser,
                                    receiver: this.rooms[this.currentroom].user
                                };
                                socket.emit('roomchat', message);
                                this.savemessage(message);
                                this.message = '';
                            }
                        }
                    }
                    e.preventDefault();
                },
                getuserlist: function () {
                    socket.emit("globalchat.users.get", {
                        data: null
                    });
                },
                allotherusers: function () {
                    var cuser = this.currentuser;
                    var all = this.allusersonline.filter(function (x) {
                        return x.email !== cuser.email;
                    });
                    if (all.length > 0) {
                        return all;
                    }
                    else {
                        return [{email: null, name: "Aucun autre utilisateur n'est connecté"}];
                    }
                },
                iscurrentuserName: function (user) {
                    return this.currentuser.email === user.email ? "boxsize2 currentuser pull-right" : "boxsize2 otheruser pull-left";
                },
                iscurrentuser: function (user) {
                    return this.currentuser.email === user.email ? "boxsize currentuser pull-right" : "boxsize otheruser pull-left";
                },
                cchatroom: function (user) {
                    if (user.email != null) {
                        if (this.rooms[user.name] == null) {
                            socket.emit("roomchat.create", {
                                sender: this.currentuser,
                                receivers: [user]
                            });
                        }
                        else {
                            this.setroom(user.name);
                        }
                    }
                },
                reco: function (roomname) {
                    socket.emit('reco', {
                        receiver: this.rooms[roomname].user,
                        sender: this.currentuser
                    });
                },
                setroom: function (room) {
                    $.when(this.currentroom = room).then(function () {
                        $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                    });
                    this.rooms[this.currentroom]['seen'] = true;
                    if (this.rooms[this.currentroom].hash == null) {
                        this.reco(this.currentroom);
                    }
                },
                savemessage: function (message) {
                    $.ajax({
                        method: 'POST',
                        url: '/savemessages',
                        data: {message: message, _token: '{{csrf_token()}}'}
                    });
                },
                seen: function (room) {
                    return this.rooms[room].seen ? "" : "red";
                },
                isnull:function (user) {
                    return user.email!=null ? "" : "yellow";
                },
                loadlastmessages: function () {
                    var app = this;
                    $.ajax({
                        method: 'GET',
                        url: '/lastmessages',
                        success: function (data) {
                            JSON.parse(data).forEach(function (e) {
                                if (e.sender.id == app.myid) {
                                    if (app.rooms[e.receiver.name] == null) {
                                        app.rooms[e.receiver.name] = {};
                                        app.rooms[e.receiver.name]['messages'] = [];
                                        app.rooms[e.receiver.name]['hash'] = null;
                                        app.rooms[e.receiver.name]['user'] = {
                                            email: e.receiver.email,
                                            name: e.receiver.name
                                        };
                                        app.rooms[e.receiver.name]['seen'] = true;
                                    }
                                    app.rooms[e.receiver.name]['messages'].push({
                                        user: {
                                            email: e.sender.email,
                                            name: e.sender.name
                                        }, message: e.content
                                    });
                                }
                                if (e.receiver.id == app.myid) {
                                    if (app.rooms[e.sender.name] == null) {
                                        app.rooms[e.sender.name] = {};
                                        app.rooms[e.sender.name]['messages'] = [];
                                        app.rooms[e.sender.name]['hash'] = null;
                                        app.rooms[e.sender.name]['user'] = {email: e.sender.email, name: e.sender.name};
                                        app.rooms[e.sender.name]['seen'] = true;
                                    }
                                    app.rooms[e.sender.name]['messages'].push({
                                        user: {
                                            email: e.sender.email,
                                            name: e.sender.name
                                        }, message: e.content
                                    });
                                }
                            });
                            app.$forceUpdate();
                        }
                    });
                }
            },
            computed: {
                currentmessages: function () {
                    return this.rooms[this.currentroom].messages;
                }
            },
            data: {
                currentuser: @if(!\Illuminate\Support\Facades\Auth::guest()){
                    email: '{{\Illuminate\Support\Facades\Auth::user()->email}}',
                    name: '{{\Illuminate\Support\Facades\Auth::user()->name}}'
                }
                @else 'Anon' @endif,
                message: '',
                rooms: {Entreprise: {messages: [], seen: true}},
                currentroom: 'Entreprise',
                messages: [],
                myid:{{\Illuminate\Support\Facades\Auth::id()}},
                allusersonline: [],
                auth: @if(!\Illuminate\Support\Facades\Auth::guest()) {{'true'}} @else {{'false'}} @endif
            },
            mounted: function () {
                var app = this;

                socket.on('globalchat.message', function (data) {
                    $.when(app.rooms['Entreprise'].messages.push({user: data.user, message: data.message}))
                        .then(function () {
                            $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight)
                        });
                    if ('Entreprise' != app.currentroom)
                        app.rooms['Entreprise']['seen'] = false;
                }.bind(this));

                socket.on('globalchat.users', function (data) {
                    this.allusersonline = $.parseJSON(data);
                }.bind(this));

                socket.on('roomchat.invite.' + app.currentuser.email, function (data) {
                    socket.emit("roomchat.confirm", {
                        confirm: true,
                        sender: app.currentuser,
                        hash: data.hash
                    });
                    app.rooms[data.sender.name] = {};
                    app.rooms[data.sender.name]['messages'] = [];
                    app.rooms[data.sender.name]['hash'] = data.hash;
                    app.rooms[data.sender.name]['user'] = data.sender;
                    app.rooms[data.sender.name]['seen'] = true;
                    socket.on('roomchat.' + data.hash, function (data2) {
                        $.when(app.rooms[data.sender.name].messages.push({user: data2.sender, message: data2.message}))
                            .then(function () {
                                $.when(app.$forceUpdate()).then(function () {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                });
                            });
                        if (data.sender.name != app.currentroom)
                            app.rooms[data.sender.name]['seen'] = false;
                    }.bind(app));
                    app.currentroom = data.sender.name;
                }.bind(this));

                socket.on('roomchat.' + app.currentuser.email, function (data) {
                    app.rooms[data.receiver.name] = {};
                    app.rooms[data.receiver.name]['messages'] = [];
                    app.rooms[data.receiver.name]['hash'] = data.hash;
                    app.rooms[data.receiver.name]['user'] = data.receiver;
                    app.rooms[data.receiver.name]['seen'] = true;
                    socket.on('roomchat.' + data.hash, function (data2) {
                        $.when(app.rooms[data.receiver.name]['messages'].push({
                            user: data2.sender,
                            message: data2.message
                        }))
                            .then(function () {
                                $.when(app.$forceUpdate()).then(function () {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                });
                            });
                        if (data.receiver.name != app.currentroom)
                            app.rooms[data.receiver.name]['seen'] = false;
                    }.bind(app));
                    app.currentroom = data.receiver.name;
                }.bind(this));

                socket.on('reco.' + app.currentuser.email, function (data) {
                    app.rooms[data.receiver.name].hash = data.hash;
                    socket.on('roomchat.' + data.hash, function (data2) {
                        $.when(app.rooms[data.receiver.name]['messages'].push({
                            user: data2.sender,
                            message: data2.message
                        }))
                            .then(function () {
                                $.when(app.$forceUpdate()).then(function () {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                });
                            });
                        if (data.receiver.name != app.currentroom)
                            app.rooms[data.receiver.name]['seen'] = false;
                    }.bind(app));
                }.bind(this));
                this.getuserlist();
                this.loadlastmessages();
            }
        });
    </script>
@endsection