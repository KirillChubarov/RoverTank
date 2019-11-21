<?php
system('gpio write 0 1'); //right direction
system('gpio write 2 0'); //right direction
system('gpio write 3 0'); //left direction
system('gpio write 4 1'); //left direction
system('gpio pwm 26 1023'); //right speed
system('gpio pwm 23 1023'); //left speed

usleep(30000);

system('gpio pwm 26 0');
system('gpio pwm 23 0');    
system('gpio write 0 0');
system('gpio write 2 0');
system('gpio write 3 0');
system('gpio write 4 0');

?>