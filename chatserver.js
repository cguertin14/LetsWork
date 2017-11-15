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

http.listen(3000, function() {
    console.log('Listening on Port 3000');
});

var OnlineUsers = [];
var ChatRooms;

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
    ChatRooms[hash].users = [];
    ChatRooms[hash].users.push(data.sender);
    io.emit('roomchat.' + data.sender.email, {hash:hash,receiver:data.receivers[0]});
    addUserToChatRoom(data.sender, hash);
    for(let receiver in data.receivers) {
        io.emit('roomchat.invite.' + receiver.email, {
            hash: hash,
            sender: data.sender
        });
    }
}

function confirmationJoinRoom(data) {
    if (data.confirm) {
        addUserToChatRoom(data.sender, data.hash);
    }
}

function roomMessage(data) {
    io.emit('roomchat.' + data.hash, {
        message: data.message,
        sender: data.sender
    });
}

io.on('connection', function(socket) {
    socket.on('globalchat.users.get', getOnlineUsers);
    socket.on('globalchat', echoback);
    socket.on('roomchat.create', createChatRoom);
    socket.on('roomchat.confirm', confirmationJoinRoom);
    socket.on('roomchat', roomMessage);
    socket.on('roomchat.out', removeUserFromChatRoom);
});

sub.subscribe('__keyevent@0__:set', function(err, count) {});

sub.on('message', function(channel, message) {
    if (message == 'OnlineUsers') {
        redis.get('OnlineUsers', function(err, result) {
            io.emit('globalchat.users', result);
            OnlineUsers = result;
        });
    }
});