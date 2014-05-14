<?php 

define('PATH', $_SERVER['DOCUMENT_ROOT'].'/admanager/');
define('SITEPATH', "http://".$_SERVER['HTTP_HOST'].'/admanager/');
define('HREFPATH', '/admanager/');
define('DBMASTERIP',"localhost");
define('DBMASTERPORT',"3306");
define('DBMASTERUSERNAME',"root");
define('DBMASTERPASSWORD',"password");
define('DBMASTERDATABSE',"adserver");
define("CONTROLLER_PATH",PATH.'src/controller/');
define("MODEL_PATH",PATH.'src/model/');
define("UTILS_PATH",PATH.'src/utils/');
define("VIEW_PATH",PATH.'src/view/');
define("JS_PATH",SITEPATH.'static/js/');
define("CSS_PATH",SITEPATH.'static/css/');
define("IMG_PATH",SITEPATH.'static/img/');

require_once 'src/lib/mysql.php';

$mysql = new mysqliDb();


$module_controller_map = array();
$module_controller_map["dashboard"] = 'DashboardController';
$module_controller_map["ad"] = 'AdController';
$module_controller_map["campaign"] = 'CampaignController';
$module_controller_map["report"] = 'ReportController';
$module_controller_map["admin"] = 'AdminController';
$module_controller_map["ajax"] = 'AjaxController';

$view_data =array();

$advIds = array();

?>