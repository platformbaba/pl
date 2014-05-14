<?php

/* Error-reporting */
error_reporting(-1);

register_shutdown_function("shutdown_handler");
spl_autoload_register('cds_autoload',true, false);

define('PATH', $_SERVER['DOCUMENT_ROOT'].'/cds/');
/* Include config file */
global $messenger;
try{
	require_once(PATH .'config/config.php');
	// sanitize the requests here
	require_once FILTERS_PATH.'sanitize_request.php';
	applyFilters(1);

	if(!$messenger['skipController']){
		applyController();
	}
}catch(Exception $e){
	$messenger["response"]["status"] = 0;
	$messenger["response"]["error_msg"] = $e->getMessage();
}

try{
	applyFilters(2);
}catch(Exception $e){
	// do nothing here.. 
}
	returnResponse();

#############################################
# 	****Related Methods Start Here.****		#
#	applyController							#
#	applyFilters							#
#	returnResponse							#
#############################################


function applyFilters($pos){
	// $pos = 1 apply initial filters
	// $pos = 2 apply end filters
	global $filters;
	foreach ($filters as $file => $flag){
		if($flag==$pos){
			include(FILTERS_PATH.$file);
		}
	}
}
	
function applyController(){
	global $messenger;
	$action = $messenger["query"]["action"];
	$cntrl = FactoryController::getController($action);
	if($cntrl){
		$cntrl->execute(); // Fetch Result.
		$cntrl->cleanup(); // Cache result.
	}
}

function returnResponse(){
	
	global $messenger;
	
	if($messenger["response"]['format']=="json"){
		//header("Content-type: application/json");
		$execution_time = round(microtime(true) * 1000) - $messenger['response']['performance']['init'];
		$messenger['response']['performance']["execution_time"] = $execution_time;
		if($messenger['isAlreadyEncoded'])
			echo $messenger["response"]['resp'];
		else
			echo json_encode($messenger["response"]);
	}elseif($messenger["response"]['format']=="xml"){
	
	header("Content-type: text/xml");
		echo "<?xml version='1.0' encoding='UTF-8'?><xml>".getxml($messenger["response"])."</xml>";	
	}else{
		// default response type
		echo json_encode($messenger["response"]);
	}
}

function getxml($arr){
 	$str="";
	if(!empty($arr)){		   
	  foreach($arr as $key=>$value){
	  
		if(is_numeric($key))
			$key = "item";
			
		$key = htmlspecialchars($key);
			
		if(is_array($value))
	 		$str.= "<".$key.">".getxml($value)."</".$key.">";
		 else
		 	$str.= "<".$key.">".htmlspecialchars($value)."</".$key.">";
	 	}
	 }
	 return $str;
}

function shutdown_handler() { 
	// log fatal errors ..
	$error = error_get_last();
	if($error){
		logger::writelogs("error",$error["type"].' | '.$error["message"]. ' | '.$error["file"].' | '.$error["line"]);
	}
	
}



function cds_autoload($className){


	if($className === 'Cache'){
		require(LIB_PATH.'cacheLib.php');
	}else if($className === 'logger'){
		require(LIB_PATH.'loggerLib.php');
	}else if(endsWith($className,'Controller')){
		require(CONTROLLER_PATH.$className.'.php');
	}else if($className === 'mysqliDb'){
		require(LIB_PATH.'mysql.php');;
	}else if(endsWith($className,'_db')){
		require(DB_CLASSES_PATH.$className.'.class.php');
	}else if(endsWith($className,'_solr')){
		require(SOLR_CLASSES_PATH.$className.'.class.php');
	}else if(endsWith($className,'_db_dto')){
		require(DB_DTO_CLASSES_PATH."db_dtos.php");
	}else if(endsWith($className,'_solr_dto')){
		require(SOLR_DTO_CLASSES_PATH."solr_dtos.php");
	}else if(endsWith($className,'_utils')){
		require(UTILS_PATH.$className.'.php');
	}
	
}

function endsWith($haystack, $needle){
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}
?>