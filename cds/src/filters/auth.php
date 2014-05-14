<?php

	// All valid keys
	$_keys = array("SaReGaMa","AmAgErAs");
	$auth = "";
	if(isset($_REQUEST["auth"]) && !string_utils::isEmpty($_REQUEST["auth"])){
		$auth = $_REQUEST["auth"];
	}else{
		throw new Exception("Unauthorized Access");
	}

	$validity = time()- _decrypt($auth,8) ;
	if($validity > 3000 || $validity < -30){
	
		throw new Exception("Expired Auth");
	}
	
	
	
	function _decrypt($auth,$n){
		global $messenger;
		$_keys = array("SaReGaMa","AmAgErAs");;
		if(strlen($auth)%6==0)
			$auth=strrev($auth);
		$newAuth = base64_decode($auth);
		$newAuth = strrev($newAuth);
		$left  = substr($newAuth, 0,$n/2);
		$right  = substr($newAuth, -$n/2);
		$time = substr($newAuth,($n/2),-($n/2));
		$key = $left.$right;
		if(!in_array($key,$_keys)){
			throw new Exception("Invalid Key");
		}
		$messenger['app_id'] = $key;
		$time=base64_decode($time);
		$e= (($time & (1<<0)) >0 ) ? 1:0;
		$d= (($time & (1<<1)) >0 ) ? 1:0;
		$c= (($time & (1<<2)) >0 ) ? 1:0;
		$b= (($time & (1<<3)) >0 ) ? 1:0;
		$a= (($time & (1<<4)) >0 ) ? 1:0;
		$s = bindec($e.$d.$c.$b.$a);
		$start = ($s%22);
		$bit=array($start+5,$start+6,$start+7,$start+8);
		foreach($bit as $b){
			$time = $time ^ (1<<$b);
		}
		return $time+1390390195;
	}
	

?>