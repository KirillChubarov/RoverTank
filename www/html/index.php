<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
<div class="row">
    <div class="column">
        <div><img id="camera" src="http://buran.club:45001/stream/video.mjpeg"/></div>
    </div>
    
    <div class="column">
        <div>
        <ul style="color:aliceblue; font-size:18px;">
            <li>time: <span id="sn">-</span></li>
            <li>vstick: <span id="result">-</span></li>
            <li>stp: <span id="stp">-</span></li>
            <li>ip: <?= $_SERVER["REMOTE_ADDR"];?></li> 
            <li>gp2: <span id="gp2test">-</span></li>
        </ul>
        </div>
    </div>
</div>
<div id="joy_container" class="row">
</div>

<script src="/js/jquery.js"></script>
<script src="/js/sendcommand.js"></script>
<!-- <script src="/js/gamepad.js"></script> -->
<script src="/js/gp2test.js"></script>
<script src="/js/virtualjoystick.js"></script>

<script>
    console.log("touchscreen is", VirtualJoystick.touchScreenAvailable() ? "available" : "not available");

    var joystick	= new VirtualJoystick({
        mouseSupport: true,
        stationaryBase: true,
        baseX: 350,
        baseY: 650,
        limitStickTravel: true,
        stickRadius: 100
    });
    joystick.addEventListener('touchStart', function(){
        console.log('down')
    })
    joystick.addEventListener('touchEnd', function(){
        console.log('up')
    })

    setInterval(function(){
        var outputEl = document.getElementById('result');

            if(joystick.deltaX() > -30 && joystick.deltaX() < 30 && joystick.deltaY() > -30 && joystick.deltaY() < 30){
            document.getElementById("stp").innerHTML = "stoppp";
                if (stoped==false;){
                    sendgpaddata(10, 0, 0);
                    stoped = true;}
            } else {
                vxaxis1 = (joystick.deltaX().toFixed(0)/100);
                vyaxis1 = (joystick.deltaY().toFixed(0)/100);
                document.getElementById("stp").innerHTML = "run - x:"+ vxaxis1 + " y:"+ vyaxis1;
                sendgpaddata(10, vxaxis1, vyaxis1);
                stoped = false;
            }

        outputEl.innerHTML	= ' '
            + ' dx:'+joystick.deltaX().toFixed(0)
            + ' dy:'+joystick.deltaY().toFixed(0)
            + (joystick.right()	? ' right'	: '')
            + (joystick.up()	? ' up'		: '')
            + (joystick.left()	? ' left'	: '')
            + (joystick.down()	? ' down' : '')	
    }, 1/30 * 1000);
</script>

</body>
</html>