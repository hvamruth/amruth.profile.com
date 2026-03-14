const express = require("express");
const http = require("http");
const socketio = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = socketio(server);

const suspiciousAgents = [
"burp",
"zap",
"acunetix",
"sqlmap",
"nikto",
"nmap",
"dirbuster",
"wpscan"
];

const ipTracker = {};

app.use((req,res,next)=>{

const ip = req.headers['x-forwarded-for'] || req.socket.remoteAddress;
const ua = (req.headers["user-agent"] || "").toLowerCase();

/* user-agent detection */

suspiciousAgents.forEach(agent=>{

if(ua.includes(agent)){

io.emit("security-alert",{
level:"high",
title:"Scanner Detected",
message:`${agent} scan from IP ${ip}`
});

}

});

/* rate detection */

if(!ipTracker[ip]){

ipTracker[ip]={
count:1,
time:Date.now()
};

}else{

ipTracker[ip].count++;

if(ipTracker[ip].count>100){

io.emit("security-alert",{
level:"high",
title:"Scanning Activity",
message:`High request rate from ${ip}`
});

}

}

next();

});

app.use(express.static("public"));

server.listen(3000,()=>{
console.log("Security server running");
});
