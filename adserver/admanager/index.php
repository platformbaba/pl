<?php 

require_once 'config/config.php';
spl_autoload_register('autoload',true, false);

session_start();


$messenger = array(
		"errormsg"=>array(),
		"successmsg"=>array(),
		"data"=>array()
);


$loginController = new LoginController();
$loginController->execute(); 

$module = StringUtils::getFromRequest("module",false,"dashboard");
if(isset($module_controller_map[$module]))
	$controller_name = $module_controller_map[$module];
else{
	// illegal module redirect to campaign
	header('Location: '.SITEPATH.'campaign');
	exit;
}


$controller_class = new $controller_name();
$page = $controller_class->execute();



include 'src/view/header.php';

if($page)
	include VIEW_PATH.$page;

include 'src/view/footer.php';








function autoload($className){
	
	if(endsWith($className,'Controller')){
		require(CONTROLLER_PATH.$className.'.php');
	}else if(endsWith($className,'Model')){
		require(MODEL_PATH.$className.'.php');
	}else if(endsWith($className,'Utils')){
		require(UTILS_PATH.$className.'.php');
	}
	
}

function endsWith($haystack, $needle){
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}




?>