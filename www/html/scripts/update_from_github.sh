#!/bin/bash

set -e
cd /root/git/RoverTank
git pull
cd /root/git/RoverTank/motor_ctrl
make
cd /root/git/RoverTank
rm -r /var/www/
mkdir /var/www/
cp -ar /root/git/RoverTank/www /var
find /var/www/html/scripts -type f | xargs chmod 0777
echo 'Update complete'
