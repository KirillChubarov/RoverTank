#!/bin/bash

set -e
cd /root/git/RoverTank
git pull
cd /root/git/RoverTank/motor_ctrl
make
cd /root/git/RoverTank
rm -r /var/www/
mkdir /var/www/
cp -avr /root/git/RoverTank/www /var
find /var/www/html/scripts -type f | xargs chmod 4755
echo 'Update complete'
