<?php
$old_path = getcwd();
chdir('/var/www/html/scripts/');
$output = shell_exec('./update_from_github.sh');
chdir($old_path);
echo "<pre>$output</pre>";
?>
