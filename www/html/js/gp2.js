var hasGP = false;
var repGP;
var movearea=0.3;
var stoped = true;

function mstop(){
    if (stoped == false){
        sendgpaddata(10,0,0);
        stoped = true;
    }
}

function mgo(movebuttonid, xaxis, yaxis){
    sendgpaddata(movebuttonid, xaxis, yaxis);
    stoped = false;
}

function sendgpaddata(movebuttonid, xaxis, yaxis){
    var a= new XMLHttpRequest();
    a.open("GET", "/php/marsohod1.php?q=" + movebuttonid + "&xaxis=" + xaxis + "&yaxis=" + yaxis, true);
    a.onreadystatechange=function(){
       if(a.readyState==4){
       if(a.status==200){
         var myObj = JSON.parse(a.responseText);
         document.getElementById("sn").innerHTML = myObj[0];
         tick1 = myObj[1];
       } else alert ("http error"); } }
   a.send(); 
} 

function itsAlive() {return "getGamepads" in navigator;}
function scanGamepad() {
        var gp = navigator.getGamepads()[0];
        //html += "id: "+gp.id+"<br/>";
 
        for(var i=0;i<gp.buttons.length;i++) {
            //html+= "Button "+(i+1)+": ";
            //if(gp.buttons[i].pressed) html+= " pressed";
            //html+= "<br/>";
        }

        // [0] -> j1 right left  [1] -> j1 up down 
        // [2] -> j2 right left  [3] -> j2 up down

        for(var i=0; i<gp.axes.length; i+=2) {
            //document.getElementById("gp2test").innerHTML = "Stick "+(Math.ceil(i/2)+1)+": "+gp.axes[i].toFixed(2)+", "+gp.axes[i+1].toFixed(2);
            if((Math.ceil(i/2)+1)==2){ //для стик1 ==1. для стик2 ==2
                // движение, если отклонение стика более переменной movearea
                if(gp.axes[i].toFixed(2) > movearea || gp.axes[i].toFixed(2) < -movearea || gp.axes[i+1].toFixed(2) > movearea || gp.axes[i+1].toFixed(2) < -movearea) {  
                    mgo(10, gp.axes[i].toFixed(2), gp.axes[i+1].toFixed(2));
                    document.getElementById("gp2test").innerHTML = i+" Send"+(Math.ceil(i/2)+1)+": "+gp.axes[i].toFixed(2)+", "+gp.axes[i+1].toFixed(2);
                } else {
                    mstop();
                }
            }
        
        }
    }
 
$(document).ready(function() {
    if(itsAlive()) {
        $(window).on("gamepadconnected", function() {
            hasGP = true;
            repGP = window.setInterval(scanGamepad,100);
        });
 
        $(window).on("gamepaddisconnected", function() {
            window.clearInterval(repGP);
        });

        var checkGP = window.setInterval(function() {
            if(navigator.getGamepads()[0]) {
                if(!hasGP) $(window).trigger("gamepadconnected");
                window.clearInterval(checkGP);
            }
        }, 500);
    }

    /* keyboard press detection start */
    $("body").on("keydown", function(event) {
    if ( this.className === 'hold' ) { return false; }
         this.className = 'hold';

      var a= new XMLHttpRequest();
      a.open("GET", "/php/marsohod1.php?q=" + event.keyCode, true);
      a.onreadystatechange=function(){
          if(a.readyState==4){ 
          if(a.status==200){
              var myObj = JSON.parse(a.responseText);
              document.getElementById("sn").innerHTML = myObj[0];
          } else alert ("http error"); } }
      a.send();
      //alert(event.keyCode + ' 1 ');
    });
   /* keyboard press detection end */
});

$("body").on("keyup", function(event) {
    this.className = '';
});