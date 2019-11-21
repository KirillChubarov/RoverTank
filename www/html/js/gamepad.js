var haveEvents = 'GamepadEvent' in window;
var haveWebkitEvents = 'WebKitGamepadEvent' in window;
var controllers = {};
var rAF = window.mozRequestAnimationFrame ||
  window.webkitRequestAnimationFrame ||
  window.requestAnimationFrame;

var tick1 = 'done';
function connecthandler(e) {
  addgamepad(e.gamepad);
}

function addgamepad(gamepad) {
  controllers[gamepad.index] = gamepad;
  var d = document.createElement("div");
  d.setAttribute("id", "controller" + gamepad.index);
  var t = document.createElement("h1");
  t.appendChild(document.createTextNode("gamepad: " + gamepad.id));
  d.appendChild(t);
  var b = document.createElement("div");
  b.className = "buttons";
   for (var i=0; i<gamepad.buttons.length; i++) {
    var e = document.createElement("span");
    e.className = "button";
    //e.id = "b" + i;
    e.innerHTML = i;
    b.appendChild(e);
  }  
  d.appendChild(b);
  var a = document.createElement("div");
  a.className = "axes";
  for (i=0; i<gamepad.axes.length; i++) {
    e = document.createElement("meter");
    e.className = "axis";
    //e.id = "a" + i;
    e.setAttribute("min", "-1");
    e.setAttribute("max", "1");
    e.setAttribute("value", "0");
    e.innerHTML = i;
    a.appendChild(e);
  }
  d.appendChild(a);
  document.getElementById("start").style.display = "none";
  document.body.appendChild(d);
  rAF(updateStatus);
}

function disconnecthandler(e) {
  removegamepad(e.gamepad);
}

function sendgpaddata(movebuttonid, xaxis, yaxis){
       if ( tick1 === 'hold' ) { return false; }
      tick1 = 'hold';

        var a= new XMLHttpRequest();
        a.open("GET", "/php/marsohod1.php?q=" + movebuttonid + "&xaxis=" + xaxis + "&yaxis=" + yaxis, true);
        //alert("/php/marsohod1.php?q=" + movebuttonid + "&xaxis=" + xaxis + "&yaxis=" + yaxis);
        a.onreadystatechange=function(){
          if(a.readyState==4){
          if(a.status==200){
            var myObj = JSON.parse(a.responseText);
            document.getElementById("sn").innerHTML = myObj[0];
           tick1 = myObj[1];
          } else alert ("http error"); } }
      a.send(); 
} 

function removegamepad(gamepad) {
  var d = document.getElementById("controller" + gamepad.index);
  document.body.removeChild(d);
  delete controllers[gamepad.index];
}

function updateStatus() {
  scangamepads();
  for (j in controllers) {
    var controller = controllers[j];
    var d = document.getElementById("controller" + j);
    var buttons = d.getElementsByClassName("button");
    for (var i=0; i<controller.buttons.length; i++) {
      var b = buttons[i];
      var val = controller.buttons[i];
      var pressed = val == 1.0;
      if (typeof(val) == "object") {
        pressed = val.pressed;
        val = val.value;       
      }
      var pct = Math.round(val * 100) + "%"; // % нажатия курка
      b.style.backgroundSize = pct + " " + pct;
      var xaxis1 = controller.axes[0].toFixed(2);
      var yaxis1 = controller.axes[1].toFixed(2);
      var xaxis2 = controller.axes[2].toFixed(2);
      var yaxis2 = controller.axes[3].toFixed(2);
      

      if (pressed) {
        b.className = "button pressed";
      } else {
        b.className = "button";
      }
    }

     var axes = d.getElementsByClassName("axis");
    for (var i=0; i<controller.axes.length; i++) {
      var a = axes[i];
      a.innerHTML = i + ": " + controller.axes[i].toFixed(4);
      a.setAttribute("value", controller.axes[i]);
    } 

// [0] -> j1 right left  [1] -> j1 up down 
// [2] -> j2 right left  [3] -> j2 up down


  /*   for (var i=0; i<controller.axes.length; i++) {
      document.getElementById("axis"+[i]).innerHTML = controller.axes[i].toFixed(2);
      sendgpaddata(10, xaxis2, yaxis2);   
    }  */

    for (var i=0; i<controller.axes.length; i++) {
      document.getElementById("axis"+[i]).innerHTML = controller.axes[i].toFixed(2);
      
      if(controller.axes[i].toFixed(2) > 0.3 || controller.axes[i].toFixed(2) < -0.3) {  
        sendgpaddata(10, xaxis1, yaxis1);
      }
      
      if(controller.axes[0].toFixed(2) < 0.2 && controller.axes[0].toFixed(2) > -0.2 && controller.axes[1].toFixed(2) < 0.2 && controller.axes[1].toFixed(2) > -0.2) {
        sendgpaddata(10, 0, 0);
      }
    } 

    
    /*   if(controller.axes[0].toFixed(2) > 0.3 || controller.axes[0].toFixed(2) < -0.3) {
      sendgpaddata(10, xaxis1, yaxis1);
      
    }

    if(controller.axes[1].toFixed(2) > 0.3 || controller.axes[1].toFixed(2) < -0.3) {
      sendgpaddata(10, xaxis1, yaxis1);
      
    }

    if(controller.axes[2].toFixed(2) > 0.3 || controller.axes[2].toFixed(2) < -0.3) {
        sendgpaddata(10, xaxis2, yaxis2);
        
      }

    if(controller.axes[3].toFixed(2) > 0.3 || controller.axes[3].toFixed(2) < -0.3) {
        sendgpaddata(10, xaxis2, yaxis2);
      }
       */

  }
  rAF(updateStatus);
}

function scangamepads() {
  var gamepads = navigator.getGamepads ? navigator.getGamepads() : (navigator.webkitGetGamepads ? navigator.webkitGetGamepads() : []);
  for (var i = 0; i < gamepads.length; i++) {
    if (gamepads[i]) {
      if (!(gamepads[i].index in controllers)) {
        addgamepad(gamepads[i]);
      } else {
        controllers[gamepads[i].index] = gamepads[i];
      }
    }
  }
}

if (haveEvents) {
  window.addEventListener("gamepadconnected", connecthandler);
  window.addEventListener("gamepaddisconnected", disconnecthandler);
} else if (haveWebkitEvents) {
  window.addEventListener("webkitgamepadconnected", connecthandler);
  window.addEventListener("webkitgamepaddisconnected", disconnecthandler);
} else {
  setInterval(scangamepads, 500);
}