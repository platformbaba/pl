<?php
	$cache = Cache::getInstance();
	global $messenger;
	$cachedData = $cache->cacheGet($messenger['getKey']());
	if($cachedData){
		$messenger["skipController"]= true;
		$messenger['response']['status']="1";
		$messenger["response"]["resp"]= json_decode($cachedData,true);
	}else{
		// cache miss
	}
?>