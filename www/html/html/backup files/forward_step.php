<?php

//system('gpio mode 0 out');
//system('gpio mode 2 out');
//system('gpio mode 3 out');
//system('gpio mode 4 out');
//system('gpio mode 26 pwm');
//system('gpio mode 23 pwm');


system('gpio write 0 1'); //right direction
system('gpio write 2 0'); //right direction
system('gpio write 3 1'); //left direction
system('gpio write 4 0'); //left direction
system('gpio pwm 26 1023'); //right speed
system('gpio pwm 23 960'); //left speed

usleep(30000);

system('gpio write 0 0');
system('gpio write 2 0');
system('gpio write 3 0');
system('gpio write 4 0');
system('gpio pwm 26 0');
system('gpio pwm 23 0');

?>
