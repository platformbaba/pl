<?php




require_once "./../config.php";
$ices_bin = "/home/ice/srv/bin/";
$ices_conf_dir="/home/ice/srv/etc/stubs/";
$channel_name='new_channel';
exec($ices_bin.'ices -b -c '.$ices_conf_dir.$channel_name.'.conf' );








?>