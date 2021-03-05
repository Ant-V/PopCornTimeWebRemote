<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PopcornTime Remote</title>
  <script src="https://unpkg.com/vue@next"></script>
  <script src="butter_remote/butter_remote.min.js"></script>
</head>
<body>
<div id="vueapp">

<div v-if="!connected">
<input v-model="username" placeholder="username">
<input v-model="password" placeholder="password">
<input v-model="ip" placeholder="ip">
<input v-model="port" placeholder="port">
<input v-model="debug" placeholder="debug">
<button @click="connect">Connect</button>

</div>
<div v-else><span style="color: green;">CONNECTED<span> <button @click="search()">Search</button><br><button @click="ping()">Ping</button><br>
<div style="max-width: 400px;text-align: center;">
<button @click="back()">BACK</button><br>
<button @click="move('up')">UP</button><br>
<button @click="move('left')">LEFT</button>
<button @click="move('right')">RIGHT</button><br>
<button @click="move('down')">DOWN</button><br>
<button @click="enter()">ENTER</button>
<br>
<button @click="startstream()">startstream</button>
<br>
<button @click="toggletab()">toggletab</button><br>
<button @click="mute()">Mute on/off</button>
<button @click="playPause()">Play/Pause</button>
<button @click="fullscreen()">togglefullscreen</button><br>
<button @click="season('prev')">Previous season</button>
<button @click="season('next')">Next season</button>

</div>
</div>

</div>
<hr>
</body>
<script>
const RemotePopcorn = {
  data(){
    return{
      username: "popcorn",
      password: "popcorn",
      // ip: "127.0.0.1",
      ip: "192.168.2.6",
      port: "8008",
      debug: "false",
      connected: false
    }
  },
  methods:{
    connect(){
      butter_remote.init(
        {
          username:this.username,
          password:this.password,
          ip:this.ip,
          port:this.port,
          debug:this.debug
        }, (data)=>{
          console.log(data);
          this.connected = butter_remote.isConnected;
        }
      );
    },
    ping(){
      butter_remote.ping()
    },
    toggletab(){
      butter_remote.toggletab();
    },
    move(where){
      butter_remote[where]();
    },
    enter(){
      butter_remote.enter();
    },
    back(){
      butter_remote.back();
    },
    search(){
      var searchString = prompt("What should I look for?");
      butter_remote.filtersearch([searchString])
    },
    startstream(){
      butter_remote.startstream((data)=>{
          console.log(data);
        });
    },
    playPause(){
      butter_remote.toggleplaying();
    },
    fullscreen(){
      butter_remote.togglefullscreen();
    },
    mute(){
      butter_remote.togglemute();
    },
    season(which){
      switch (which){
        case 'prev':
          butter_remote.previousseason((data)=>{
            console.log(data);
          });
          break;
        case 'next':
          butter_remote.nextseason((data)=>{
            console.log(data);
          });
          break;
        default:
          break;
      }
    }
    
  },
  mounted() {
    // setInterval(function() {
    //   butter_remote.listennotifications(function(data) {
    //       //Use the data object to read the notifications
    //       //and do wathever you need with the notifications you just took (changing commands etc.)
    //       console.log(data);
    //   })
    // }, 1000);
  }
}
/*
butter_remote.init(
//If you don't need to change these settings you can remove this whole part
  {
    username: "popcorn",
    password: "popcorn",
    // ip: "127.0.0.1",
    ip: "192.168.2.6",
    port: "8008",
    debug: "false"
  }
//If you don't need to change these settings you can remove this whole part
);

// butter_remote.ping();
function search(){
  var searchString = prompt("What should I look for?");
  butter_remote.filtersearch([searchString])
}
function move(where){
  butter_remote[where]();
}
setInterval(function() {
    pr.listennotifications(function(data) {
        //Use the data object to read the notifications
        //and do wathever you need with the notifications you just took (changing commands etc.)
        console.log(data);
    })
}, 1000);
*/



Vue.createApp(RemotePopcorn).mount('#vueapp');
</script>
</html>