var io = require('socket.io')(6001)
console.log("CONNECTED TO PORT 6001")
io.on('error' , function (socket) {
   console.log('error')
})
io.on('connection' , function (socket) {
console.log('Có người vừa kết nối ' + socket.id);
})
var Redis = require('ioredis');
var redis = new Redis(6379);
redis.psubscribe("*" , function (err , count ) {
console.log("count" , count)
})
redis.on('pmessage' , function (partner , channel , message) {
     console.log("partner",partner);
     io.emit(channel + ":" + message.event , message.data.message)
})
