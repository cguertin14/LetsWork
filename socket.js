var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

http.listen(3000, function(){
    console.log('Listening on Port 3000');
});

var users=new Map();

io.on('connection',function (socket) {

	socket.on('chat.message',function (message) {
		console.log(message);
		io.emit('chat.message',message);
	});
});