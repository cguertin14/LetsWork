var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

function returnHash() {
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

var users = [];
var chatrooms = new Map();

function allonlineusers() {
	io.emit('user.all.online', users);
}

function echoback(data) {
    io.emit('chat.message', data);
}

function duochatconnect(data) {
    if (!users.has(data.user) || !users.has(data.requesteduser)) {
        io.emit('user.request.duochat.' + data.user, {result: false});
    }
    else {
        var roomname = 'user.chatroom.duo.' + data.user + '.' + data.requesteduser;
        var token = returnHash();
        io.emit('user.request.duochat.' + data.user, {result: true, chatroom: room, token: token});
        io.emit(data.requesteduser + '.askedroomjoin', roomname);
        socket.on(roomname, function (data) {
            io.emit(roomname, data);
        });
        chatrooms.set(room, token);
        redis.set('chatroomslist', JSON.stringify(chatrooms));
    }
}

function duochatunconnect(data) {
    if (chatrooms.get(data.roomname) === data.token) {
        socket.removeAllListeners(data.roomname);
        chatrooms.delete(data.roomname);
        redis.set('chatroomslist', JSON.stringify(chatrooms));
    }
}

io.on('connection', function (socket) {
    socket.on('chat.message', echoback);
    socket.on('user.list',allonlineusers);
    socket.on('user.request.duochat.connect', duochatconnect);
    socket.on('user.request.duochat.unconnect', duochatunconnect);
});

setInterval(function(){
    redis.get('test', function (err, result) {
        console.log(result); //will display 'value'
    });
}, 5000);