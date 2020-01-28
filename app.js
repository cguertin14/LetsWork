var http = require("http");

var server = http.createServer(function (req, res) {
  res.end("Hello World from Node.js " + process.version);
});

// Listen on passenger's socket. You cannot use another port or unix domain
// socket, this is the only one that will work correctly in a Shared Hosting
// environment.
server.listen("passenger");
