<?php
$output = shell_exec('/var/www/html/scripts/update_from_github.sh');
echo "<pre>$output</pre>";
?>
