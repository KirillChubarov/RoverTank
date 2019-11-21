<?php

$start = microtime(true);
$try_numbers =1;
//echo '<pre>';

for ($x=-0.5; $x<0.49; $x=$x+0.01) {
     system("motor_ctrl $x $x", $retval1);
     $try_numbers = $try_numbers + 1;
}
//$last_line = system('motor_ctrl 0 0');

//echo '<pre>';


$time = microtime(true) - $start;
printf("Скрипт из %.4F вызовов motor_ctrl выполнялся %.4F сек.",$try_numbers, $time);
printf("<br/>Время выполнения одного вызова motor_ctrl %.4F сек.", ($time/$try_numbers));

system('motor_ctrl 0 0', $retval2);

echo "<br/>retval 1 = ".$retval1."<br/>";
echo "retval 2 = ".$retval2."<br/>";
?>

