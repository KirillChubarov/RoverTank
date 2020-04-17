#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <math.h>
#include "/root/wiringPi/wiringPi/wiringPi.h"

//Setup parametrs

#define right_dir_pin_1 0 //Set INA (direction) pin for l298n motor driver, right motor
#define right_dir_pin_2 2 //Set INB (direction) pin for l298n motor driver, right motor
#define left_dir_pin_1 3 //Set INC (direction) pin for l298n motor driver, left motor
#define left_dir_pin_2 4 //Set IND (direction) pin for l298n motor driver, left motor
#define right_speed_pin 26 //Set ENA (PWM) pin for l298n motor driver, right motor
#define left_speed_pin 23 //Set ENA (PWM) pin for l298n motor driver, left motor

#define turn_comp 0.5 //Set compensation for turns (0...1.0)
#define min_inpt_val 0.2 //Set minimum input value (0...1.0)
#define min_turn_inpt_val 0.1 // Set minimum value for rotate mode (0...1.0)
#define max_inpt_val 1.0 //Set maximum input value (0...1.0)
#define right_mtr_comp 1.0 //Speed compensation for right motor(0...1.0)
#define left_mtr_comp 1.0 //Speed compensation for left motor(0...1.0)
#define min_mtr_pwm 250.0 //Set minimum motors PWM (0...1023.0)
#define max_mtr_pwm 1000.0 //Set minimum motors PWM (0...1023.0)

double map (double value, double from_low, double from_high, double to_low, double to_high)
{
  double outgoing;
  outgoing = to_low + (to_high - to_low) * ((value - from_low) / (from_high - from_low));
  return outgoing;
}

void motor_stop ()
{
  pwmWrite (right_speed_pin, 0);
  pwmWrite (left_speed_pin, 0);
  digitalWrite (right_dir_pin_1, 0);
  digitalWrite (right_dir_pin_2, 0);
  digitalWrite (left_dir_pin_1, 0);
  digitalWrite (left_dir_pin_2, 0);
  exit (0);
}

void motor_advance (int right_mtr_pwm, int left_mtr_pwm)
{
  int r_dir1, r_dir2, l_dir1, l_dir2;

  if (right_mtr_pwm > 0) {r_dir1 = 1; r_dir2 = 0;} else {r_dir1 = 0; r_dir2 = 1;}
  if (left_mtr_pwm > 0) {l_dir1 = 1; l_dir2 = 0;} else {l_dir1 = 0; l_dir2 = 1;}

  pwmWrite (right_speed_pin, 0);
  pwmWrite (left_speed_pin, 0);
  digitalWrite (right_dir_pin_1, 0);
  digitalWrite (right_dir_pin_2, 0);
  digitalWrite (left_dir_pin_1, 0);
  digitalWrite (left_dir_pin_2, 0);

  digitalWrite (right_dir_pin_1, r_dir1);
  digitalWrite (right_dir_pin_2, r_dir2);
  digitalWrite (left_dir_pin_1, l_dir1);
  digitalWrite (left_dir_pin_2, l_dir2);
  pwmWrite (right_speed_pin, abs(right_mtr_pwm));
  pwmWrite (left_speed_pin, abs(left_mtr_pwm));
  exit (0);
} 

int main (int argc, char *argv[])
{
  wiringPiSetup ();
  pinMode (right_dir_pin_1, OUTPUT);
  pinMode (right_dir_pin_2, OUTPUT);
  pinMode (left_dir_pin_1, OUTPUT);
  pinMode (left_dir_pin_2, OUTPUT);
  pinMode (right_speed_pin, PWM_OUTPUT);
  pinMode (left_speed_pin, PWM_OUTPUT);

  double x_axis, y_axis;
  int right_mtr_speed, left_mtr_speed;
  double y_dir = 0.0;

  x_axis = (atof(argv[1]));
  y_axis = (atof(argv[2]));

  if (fabs(x_axis) > max_inpt_val) {
    printf ("x_axis argument out of range!\n");
    exit (0);
    }
  if (fabs(y_axis) > max_inpt_val) {
    printf ("y_axis argument out of range!\n");
    exit (0);
    }

  if (y_axis < 0) {y_dir = 1.0;}
  if (y_axis > 0) {y_dir = -1.0;}

// Stop mode
  if ((fabs(x_axis) < min_inpt_val) && (fabs(y_axis) < min_turn_inpt_val)) {motor_stop();}
// End of stop mode

// Rotate mode
  if ((fabs(x_axis) >= min_inpt_val) && (fabs(y_axis) < min_inpt_val)) {
    double any_mtr_speed = (map(fabs(x_axis), min_inpt_val, max_inpt_val, min_mtr_pwm, max_mtr_pwm));
    // Left
    if (x_axis < 0) {
      right_mtr_speed = (int)(any_mtr_speed * right_mtr_comp);
      left_mtr_speed = (int)(any_mtr_speed * left_mtr_comp * -1.0);
    }
    // Right
    else {
      right_mtr_speed = (int)(any_mtr_speed * right_mtr_comp * -1.0);
      left_mtr_speed = (int)(any_mtr_speed * left_mtr_comp);
    }
    motor_advance (right_mtr_speed, left_mtr_speed);
  }
// End of rotate mode

// Free advance mode
  double right_turn_factor = 1.0;
  double left_turn_factor = 1.0;
  double any_mtr_speed = (map(fabs(y_axis), min_inpt_val, max_inpt_val, min_mtr_pwm, max_mtr_pwm));

  if (x_axis > 0) {
    right_turn_factor = 1.0 - ((fabs(x_axis)) / turn_comp);
    if (right_turn_factor > max_inpt_val) {right_turn_factor = max_inpt_val;}
  }
  if (x_axis < 0) {
    left_turn_factor = 1.0 - ((fabs(x_axis)) / turn_comp);
    if (left_turn_factor > max_inpt_val) {left_turn_factor = max_inpt_val;}
  }

  right_mtr_speed = (int)(any_mtr_speed * right_turn_factor * right_mtr_comp * y_dir);
  left_mtr_speed = (int)(any_mtr_speed * left_turn_factor * left_mtr_comp * y_dir);
    
  motor_advance (right_mtr_speed, left_mtr_speed);
// End of free advance mode

  printf ("Some strange happens\n");
  return 1;
}
