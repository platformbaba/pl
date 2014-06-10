<?php


require_once "./../config.php";
$ices_bin = "/home/ec2-user/radio/ices/bin/";
$icecast_server_ip="";
$icecast_server_port="";
$ices_modules_dir="/home/ec2-user/radio/ices/etc/modules/";
$ices_conf_dir="/home/ec2-user/radio/ices/etc/";

$channel_id = 42;
$channel_name = "channel_42";

$template = file_get_contents("../templates/ices_temp.tmpl");
$template = str_replace("@@@CHANNEL_NAME@@@",$channel_name,$template);
$template = str_replace("@@@CHANNEL_GENRE@@@",$channel_name,$template);
$template = str_replace("@@@CHANNEL_DESCRIPTION@@@",$channel_name,$template);
#echo $template;
if(!file_exists($ices_conf_dir.$channel_name.'.conf'))
        file_put_contents($ices_conf_dir.$channel_name.'.conf',$template);
else    {
        echo "channel already exits";
        }

$py_module = file_get_contents("../templates/py_temp.py");

if(!file_exists($ices_modules_dir.$channel_name.'.py')){
        file_put_contents($ices_modules_dir.$channel_name.'.py',$py_module);
        }
else    {
        echo "module  already exits";
        exit;
        }








?>
