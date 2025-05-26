<?php
ini_set('display_errors','on');
error_reporting(E_ALL);

//echo getcwd();

die;
shell_exec('rm -f storage');
shell_exec('ln -s /var/www/vhosts/commonlandsnet.org/httpdocs/storage/app/public/ /var/www/vhosts/commonlandsnet.org/httpdocs/public/storage');
shell_exec('chmod 777 storage');

echo "<pre>";
echo shell_exec('ls -la');
echo "</pre>";