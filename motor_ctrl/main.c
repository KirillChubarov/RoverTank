#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <math.h>
#include "../libs/wiringPi/wiringPi.h"

//Настроечные параметры:

#define right_mtr_comp 1 //Снижает скорость правого мотора для компенсации разницы в моторах (0...1)
#define left_mtr_comp 0.5 //Снижает скорость левого мотора для компенсации разницы в моторах (0...1)
#define dead_zone 20 //Устанавливает значение мертвой зоны стика (0...100)
#define min_mtr_pwm 300 //Устанавливает минимальное значение ШИМ моторов (0...1023)
#define max_mtr_pwm 1000 //Устанавливает максимальное значение ШИМ моторов (0...1023)

double map (double value, double from_low, double from_high, double to_low, double to_high)
{
  double outgoing;
  outgoing = to_low + (to_high - to_low) * ((value - from_low) / (from_high - from_low));
  return outgoing;
}

void motor_stop ()
{
  pwmWrite (26, 0);
  pwmWrite (23, 0);
  digitalWrite (0, 0);
  digitalWrite (2, 0);
  digitalWrite (3, 0);
  digitalWrite (4, 0);
  exit (0);
}

void motor_advance (int r_dir, int l_dir, int r_speed, int l_speed, int speedup_pwm)
{
  int r_dir2;
  int l_dir2;
  if (r_dir == 0) {r_dir2 = 1;} else {r_dir2 = 0;}
  if (l_dir == 0) {l_dir2 = 1;} else {l_dir2 = 0;}
  pwmWrite (26, 0);
  pwmWrite (23, 0);
  digitalWrite (0, 0);
  digitalWrite (2, 0);
  digitalWrite (3, 0);
  digitalWrite (4, 0);
  delay (10);
  digitalWrite (0, r_dir);
  digitalWrite (2, r_dir2);
  digitalWrite (3, l_dir);
  digitalWrite (4, l_dir2);
  //pwmWrite (26, speedup_pwm);
  //pwmWrite (23, speedup_pwm);
  //delay (10);
  pwmWrite (26, r_speed);
  pwmWrite (23, l_speed);
  exit (0);
} 

int main (int argc, char *argv[])
{
  wiringPiSetup ();
  pinMode (0, OUTPUT);
  pinMode (2, OUTPUT);
  pinMode (3, OUTPUT);
  pinMode (4, OUTPUT);
  pinMode (26, PWM_OUTPUT);
  pinMode (23, PWM_OUTPUT);

  double x_axis;
  double y_axis;
  double right_mtr_speed;
  double left_mtr_speed;
  bool x_dead_zone_check;
  bool y_dead_zone_check;

  x_axis = (atof(argv[1]));
  y_axis = (atof(argv[2]));

  x_dead_zone_check = (((x_axis*100) < (dead_zone*-1)) || ((x_axis*100) > dead_zone));
  y_dead_zone_check = (((y_axis*100) < (dead_zone*-1)) || ((y_axis*100) > dead_zone));

  x_axis = (x_axis)*100;
  y_axis = ((fabs(y_axis))*y_axis)*100;

  //if (y_axis > 70) {y_axis = 100;}
  //if (y_axis < -70) {y_axis = -100;}

  if ((x_axis < -100) || (x_axis > 100)) {
    printf ("x_axis argument out of range!\n");
    exit (0);
    }
  if ((y_axis < -100) || (y_axis > 100)) {
    printf ("y_axis argument out of range!\n");
    exit (0);
    }
  

  if ((x_dead_zone_check != true) && (y_dead_zone_check != true)) {
    motor_stop();
    }
  
  if ((x_dead_zone_check == true) && (y_dead_zone_check != true)) {
    right_mtr_speed = (map(fabs(x_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp);
    left_mtr_speed = (map(fabs(x_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp);
    if (x_axis < 0) {
      motor_advance (1, 0, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
    }
    else {
      motor_advance (0, 1, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
    }
  }

  if ((x_dead_zone_check != true) && (y_dead_zone_check == true)) {
    if (y_axis < 0) {
        right_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp;
        left_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp;
        motor_advance (1, 1, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
      }
    else {
        right_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp;
        left_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp;
        motor_advance (0, 0, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
    }
  }

  if ((x_dead_zone_check == true) && (y_dead_zone_check == true)) {
    if (y_axis < 0) {
      if (x_axis < 0) {
        right_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp;
        left_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp*(1-(sqrt(fabs(x_axis/100))));
        motor_advance (1, 1, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
      }
      else {
        right_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp*(1-(sqrt(fabs(x_axis/100))));
        left_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp;
        motor_advance (1, 1, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
      }
    }
    else {
      if (x_axis < 0) {
        right_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp;
        left_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp*(1-(sqrt(fabs(x_axis/100))));
        motor_advance (0, 0, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
      }
      else {
        right_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*right_mtr_comp*(1-(sqrt(fabs(x_axis/100))));
        left_mtr_speed = map(fabs(y_axis), dead_zone, 100, min_mtr_pwm, max_mtr_pwm)*left_mtr_comp;
        motor_advance (0, 0, (int)right_mtr_speed, (int)left_mtr_speed, (int)min_mtr_pwm);
      }
    }
  }

return 0;
}


