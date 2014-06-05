<?php 
/* Main file of this architect */
set_time_limit(0);

/* Error-reporting */
error_reporting(E_ALL ^ E_NOTICE);

/* Session Start */
//session_start();

/* Define base path of application */
define('PATH', $_SERVER['DOCUMENT_ROOT'].'/cms/');

/* Include config file */
require_once(PATH .'includes/config/config.php');

/* check logged in or not*/
$login=new login();
$login->checkAuth();
/* Load Controller */
$oCms->load();

/* __autoload to include classes automatically when called*/
function __autoload($className)
{ 
     if($className=='mysqliDb'){
	 	$file=LIBPATH. 'mysqli.class.php';
	 }elseif($className=='Encryption'){
	 	$file=LIBPATH. 'encryption.class.php';
	 }else{
	 	$file = MODELPATH .strtolower($className) . '.model.php';
	 }	
	 require_once($file);
}