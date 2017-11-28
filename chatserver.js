var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
var sub = new Redis();

function newHash() {
    var abc = "abcdefghijklmnopqrstuvwxyz1234567890".split("");
    var token = "";
    for (var i = 0; i < 128; i++) {
        token += abc[Math.floor(Math.random() * abc.length)];
    }
    return token; //Will return a 32 bit "hash"
}

http.listen(3000, function () {
    console.log('Listening on Port 3000');
});

var OnlineUsers = [];
var ChatRooms = {};

function getOnlineUsers(data) {
    io.emit('globalchat.users', OnlineUsers);
}

function echoback(data) {
    io.emit('globalchat.message', data);
}

function addUserToChatRoom(user, hash) {
    ChatRooms[hash].users.push(user);
}

function removeUserFromChatRoom(data) {
    ChatRooms[data.hash].users.splice(ChatRooms[data.hash].users.indexOf(data.user), 1);
}

function createChatRoom(data) {
    let hash = newHash();
    ChatRooms[hash] = {};
    ChatRooms[hash].users = [];
    ChatRooms[hash].users.push(data.sender);
    ChatRooms[hash].hash = hash;
    io.emit('roomchat.' + data.sender.email, {
        hash: hash,
        receiver: data.receivers[0]
    });
    data.receivers.forEach(function (receiver) {
        io.emit('roomchat.invite.' + receiver.email, {
            email: receiver.email,
            hash: hash,
            sender: data.sender
        });
    });
}

function confirmationJoinRoom(data) {
    if (data.confirm) {
        addUserToChatRoom(data.sender, data.hash);
    }
}

function roomMessage(data) {
    io.emit('roomchat.' + data.hash, {
        message: data.message,
        sender: data.sender,
        receiver: data.receiver
    });
}

function roominvite(data) {
    io.emit('roomchat.invite.' + data.email, data);
}

function reco(data) {
    var rep={};
    var chatroom=null;
    Object.keys(ChatRooms).forEach(function (c) {
        var sender = false;
        var receiver = false;
        ChatRooms[c].users.forEach(function (u) {
            if (u.email == data.receiver.email) {
                receiver = true;
            }
            if (u.email == data.sender.email) {
                sender = true;
            }
        });
        if (sender && receiver) {
            chatroom = ChatRooms[c];
        }
    });
    if(chatroom!=null)
    {
        rep['hash']=chatroom.hash;
        rep['receiver']=data.receiver;
    }
    else {
        let hash = newHash();
        ChatRooms[hash] = {};
        ChatRooms[hash].users = [];
        ChatRooms[hash].users.push(data.sender);
        ChatRooms[hash].users.push(data.receiver);
        ChatRooms[hash].hash = hash;
        rep['hash']=hash;
        rep['receiver']=data.receiver;
    }
    io.emit('reco.' + data.sender.email, rep);
}

io.on('connection', function (socket) {
    socket.on('globalchat.users.get', getOnlineUsers);
    socket.on('globalchat', echoback);
    socket.on('roomchat.create', createChatRoom);
    socket.on('roomchat.confirm', confirmationJoinRoom);
    socket.on('roomchat', roomMessage);
    socket.on('roomchat.out', removeUserFromChatRoom);
    socket.on('roomchat.invite.*', roominvite);
    socket.on('reco', reco);
});

sub.subscribe('__keyevent@0__:set', function (err, count) {
});

sub.on('message', function (channel, message) {
    if (message == 'OnlineUsers') {
        redis.get('OnlineUsers', function (err, result) {
            io.emit('globalchat.users', result);
            OnlineUsers = result;
        });
    }
});