<?php
//echo "xaxis=".$_POST["xaxis"]." ";
//echo "yaxis=".$_POST["yaxis"]." ";
//echo '<pre>'.print_r($_POST,true).'</pre>';
$start = microtime(true);

if (isset($_POST["xaxis"]) || isset($_POST["yaxis"])) {
    system ("motor_ctrl $_POST[xaxis] $_POST[yaxis]");
    //usleep (30000);
    //system ('motor_ctrl 0 0');
} else {
    system ('motor_ctrl 0 0');
} 
?>