<?php

// DO NOT CHANGE THIS
define('SAREGAMA_OFFSET',1390390195);
$time= time();// make sure the system is in sync with UTC time else get time from time servers
$app_id="SaReGaMa";// app_id provided to you
echo 'Auth code generated : '.$auth = _encrypt($app_id,$time);


function _encrypt($app_id,$time){
	$time-=SAREGAMA_OFFSET;
	$lsbs = '';
	for($i=0;$i<=4;$i++)
		$lsbs.=((($time & (1<<$i)) >0 ) ? '1':'0');
	$s = bindec($lsbs);
	$start = $s%22;
	$bit=array($start+5,$start+6,$start+7,$start+8);
	foreach($bit as $b){
		$time = $time ^ (1<<$b);
	}
	$etime=base64_encode($time);
	$n =strlen($app_id);
	$l = substr($app_id, 0,($n/2));
	$r = substr($app_id, $n/2,$n-1);
	$iauth = strrev($l.$etime.$r);
	$final_auth= base64_encode($iauth);
	if(strlen($final_auth)%6==0)
		$final_auth=strrev($final_auth);
	return $final_auth;
}
?>