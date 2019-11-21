all:
	gcc -Wall -o motor_ctrl main.c -lwiringPi -lm
	yes | cp ./motor_ctrl /usr/local/bin/motor_ctrl
	chmod 4755 /usr/local/bin/motor_ctrl