var app = require('express')();

var fs = require( 'fs' );
const cors = require('cors');

var http;

// Check if the protocol is HTTPS
var httpsOptions = {
    key: fs.readFileSync('/etc/apache2/ssl/server.key'),
    cert: fs.readFileSync('/etc/apache2/ssl/server.crt'),
    ca: fs.readFileSync('/etc/apache2/ssl/server-ca.crt')
};
http = require('https').createServer(httpsOptions, app);

app.use(cors({ origin: '*' }));

var server = http.listen(3000, () => {
    console.log('listening on *:3000');
});


var io = require('socket.io')(http,  { cors: { origin: '*' } });
const axios = require('axios');
//
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/socket.html');
});
 // local setUP
const saveMsgUrl = "https://pro.gocarhub.app/api/save-message";
const seenMsgUrl = "https://pro.gocarhub.app/api/seen-message";

// LIVE SetUP CLINTS //////

// const saveMsgUrl = "http://3.130.87.79/api/save-message";
// const seenMsgUrl = "http://3.130.87.79/api/seen-message";

var clients = {};
io.on("connection", function (socket) {
    console.log("socket connected");
    socket.on('join', function (name) {
        clients[name] = socket.id;
        console.log(clients)
    });

    socket.on("sendMessage", msg => {
        console.log("msg sendMessage => ", msg)
     try{
        axios.post(saveMsgUrl, msg).then(function (response) {
                console.log('api response', response.data);
                // Send message to partner
                io.to(clients[msg.chatId]).emit('receivedMessage', response.data.data);
                // Receive api response on own side also
                let myId = msg.sender_id.toString() + msg.receiver_id.toString();
                console.log('myId', myId);
                io.to(clients[myId]).emit('sendedMessageDetail', response.data.data);
            })
            .catch(function (error) {
                console.log(error);
            });
        }catch (error) {
            console.error(error.response.data);     // NOTE - use "error.response.data` (not "error")
          }
    });

    socket.on("message_seen", msg => {
        console.log("msg message_seen => ", msg)
    });

    socket.on("disconnect", function () {
        console.log("user disconnected");
    });
});
