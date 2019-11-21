<?php

$start = microtime(true);

if (isset($_GET["xaxis"]) || isset($_GET["yaxis"])) {
    system ("motor_ctrl $_GET[xaxis] $_GET[yaxis]");
    //usleep (30000);
    //system ('motor_ctrl 0 0');
} else {
    system ('motor_ctrl 0 0');
} 

/*  if ($_GET["yaxis"] > 0.3 || $_GET["yaxis"] < -0.3) { 
    system ("motor_ctrl 0 $_GET[yaxis]");
    usleep (30000);
    system ('motor_ctrl 0 0');
} else {
    system ('motor_ctrl 0 0');
} 

if ($_GET["xaxis"] > 0.3 || $_GET["xaxis"] < -0.3) {  
    system ("motor_ctrl $_GET[xaxis] 0");
    usleep (30000);
    system ('motor_ctrl 0 0');
} else {
    system ('motor_ctrl 0 0');
} 
 */

/* function save_result($result, $location) {
    $json = json_encode($result);
    $file = fopen($location, 'w'); 
    fwrite($file, $json);
    fclose($file);
   } */

/* function get_result($result, $location) {
    $file = fopen($location, 'r');
    $read = json_decode(fread($file, filesize($location)));
    fclose($location);
    return $read;
   } */

//   save_result($result, 'hello.txt');
//  get_result('hello.txt');



switch ($_GET["q"]) {
case 87: // forward w
    // system('gpio write 0 1'); //right direction
    // system('gpio write 2 0'); //right direction
    // system('gpio write 3 1'); //left direction
    // system('gpio write 4 0'); //left direction
    // system('gpio pwm 26 1023'); //right speed
    // system('gpio pwm 23 940'); //left speed

    system ('motor_ctrl 0 -1');
    break;

case forward_step: //forward_step
    // system('gpio write 0 1'); //right direction
    // system('gpio write 2 0'); //right direction
    // system('gpio write 3 1'); //left direction
    // system('gpio write 4 0'); //left direction
    // system('gpio pwm 26 1023'); //right speed
    // system('gpio pwm 23 940'); //left speed

    system ('motor_ctrl 0 -1');    
    usleep (30000);

    // system('gpio pwm 26 0');
    // system('gpio pwm 23 0');    
    // system('gpio write 0 0');
    // system('gpio write 2 0');
    // system('gpio write 3 0');
    // system('gpio write 4 0');

    system ('motor_ctrl 0 0');
    break;

case back_step: //back_step
    // system('gpio write 0 0'); //right direction
    // system('gpio write 2 1'); //right direction
    // system('gpio write 3 0'); //left direction
    // system('gpio write 4 1'); //left direction
    // system('gpio pwm 26 1023'); //right speed
    // system('gpio pwm 23 940'); //left speed
    
    system ('motor_ctrl 0 1');
    usleep(30000);

    // system('gpio pwm 26 0');
    // system('gpio pwm 23 0');
    // system('gpio write 0 0');
    // system('gpio write 2 0');
    // system('gpio write 3 0');
    // system('gpio write 4 0');

    system ('motor_ctrl 0 0');
    break;

case left: //endless_left
    // system('gpio write 0 1'); //right direction
    // system('gpio write 2 0'); //right direction
    // system('gpio write 3 0'); //left direction
    // system('gpio write 4 1'); //left direction
    // system('gpio pwm 26 600'); //right speed
    // system('gpio pwm 23 600'); //left speed

    system ('motor_ctrl -1 0');
    break;

case right: //endless_right
    // system('gpio write 0 0'); //right direction
    // system('gpio write 2 1'); //right direction
    // system('gpio write 3 1'); //left direction
    // system('gpio write 4 0'); //left direction
    // system('gpio pwm 26 600'); //right speed
    // system('gpio pwm 23 600'); //left speed

    system ('motor_ctrl 1 0');
    break;

case 65: //a
    // system('gpio write 0 1'); //right direction
    // system('gpio write 2 0'); //right direction
    // system('gpio write 3 0'); //left direction
    // system('gpio write 4 1'); //left direction
    // system('gpio pwm 26 1023'); //right speed
    // system('gpio pwm 23 1023'); //left speed

    system ('motor_ctrl -1 0');    
    usleep(30000);

    // system('gpio pwm 26 0');
    // system('gpio pwm 23 0');    
    // system('gpio write 0 0');
    // system('gpio write 2 0');
    // system('gpio write 3 0');
    // system('gpio write 4 0');

    system ('motor_ctrl 0 0');
    break;

case 83: //s
    // system('gpio write 0 0'); //right direction
    // system('gpio write 2 1'); //right direction
    // system('gpio write 3 0'); //left direction
    // system('gpio write 4 1'); //left direction
    // system('gpio pwm 26 900'); //right speed
    // system('gpio pwm 23 800'); //left speed

    system ('motor_ctrl 0 1');
    break;

case 68: //d
    // system('gpio write 0 0'); //right direction
    // system('gpio write 2 1'); //right direction
    // system('gpio write 3 1'); //left direction
    // system('gpio write 4 0'); //left direction
    // system('gpio pwm 26 1023'); //right speed
    // system('gpio pwm 23 1023'); //left speed

    system ('motor_ctrl 1 0');    
    usleep(30000);

    // system('gpio pwm 26 0');
    // system('gpio pwm 23 0');    
    // system('gpio write 0 0');
    // system('gpio write 2 0');
    // system('gpio write 3 0');
    // system('gpio write 4 0');

    system ('motor_ctrl 0 0');
    break;

case 32: //stop
    // system('gpio pwm 26 0');
    // system('gpio pwm 23 0');
    // system('gpio write 0 0');
    // system('gpio write 2 0');
    // system('gpio write 3 0');
    // system('gpio write 4 0');

    system ('motor_ctrl 0 0');
    break;
}

// time
$time = microtime(true) - $start;
$stringtime = sprintf("Запрос %.4F сек.", $time);
$myArr = array($stringtime, 'done');
$myJSON = json_encode($myArr);
echo $myJSON;

?>
