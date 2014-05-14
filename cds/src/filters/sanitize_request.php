<?php
	
	
	global $allowedModules,$messenger;
		
	$respformat = string_utils::getFromRequest("format",false,"json");
	$messenger['response']['format']    = $respformat;	
	
	
	################################ READ ALL REQUEST PARAMETERS HERE ###################################
	
	
	$module 	= string_utils::getFromRequest("module"); // audio , video, album ,artist , images etc
	$action		= string_utils::getFromRequest("action",false,"get");	// search or db request
	$actiontype	= string_utils::getFromRequest("actiontype",false);			// depends upon action
	$query  	= string_utils::getFromRequest("query");
	$id  		= string_utils::getFromRequest("id");
	$start		= string_utils::getFromRequest("start",false,"0");
	$limit		= string_utils::getFromRequest("limit",false,"10");
	$sf		 	= string_utils::getFromRequest("sf");
	$so		 	= string_utils::getFromRequest("so",false,"asc");
	$includes 	= string_utils::getFromRequest("includes");
	$criteria	= string_utils::getFromRequest("criteria");
	
	#####################################################################################################


	################################ CHECK ILLEGAL PARAMS HERE ##########################################
		
	if (! in_array($module, $allowedModules)) throw new Exception("illegal Module");
	
	if(!string_utils::isNumeric($start))	$start="0";
	if(!string_utils::isNumeric($limit))	$limit="10";
	
	// for action get
	if($action=="get" && (string_utils::isEmpty($actiontype) || $actiontype=="getdetails") && string_utils::isEmpty($id)) 
		throw new Exception("id compulsary default actiontype or getdetails");
	
	
	if($action=="search" && string_utils::isEmpty($query))
		throw new Exception("query compulsary for search action");
	
	if($limit >50){
		$limit = 10;
	}
	if($so!="asc" && $so!="desc"){
		$so="asc";
	}
	#if($action=="get" && $actiontype=="getdetails" && string_utils::isEmpty($id)) throw new Exception("id compulsary actiontype for getdetails");
	#if($action=="get" && $actiontype=="songs" && string_utils::isEmpty($id)) throw new Exception("id compulsary actiontype for songs");

/* 
	if($action=="" && $actiontype=="" && string_utils::isEmpty($id)) throw new Exception("id compulsary actiontype for getdetails");
	
	if($action=="" && $actiontype=="songs" && string_utils::isEmpty($id)) throw new Exception("id compulsary actiontype for songs");
	 */
	
	$query = string_utils::sqlInjection($query);
	$includes = urldecode($includes);
	$criteria = urldecode($criteria);
	
	#####################################################################################################
	
	
	################################ UPDATE MESSENGER HERE ##############################################
	$messenger['query']['module']  		= $module;
	$messenger['query']['queryS']  		= $query;// added by me.
	$messenger['query']['action'] 		= $action;
	$messenger['query']['actiontype']  	= $actiontype;
	$messenger['query']['limit']  		= $limit;
	$messenger['query']['start']  		= $start;
	$messenger['query']['sf']  			= $sf;
	$messenger['query']['so']  			= $so;
	$messenger['query']['includes']  	= $includes;
	$messenger['query']['id']  			= $id;
	$messenger['query']['criteria']		= $criteria;
	
//	var_dump($messenger["query"]);
//	exit(1);
	#####################################################################################################
	
	
	
?>