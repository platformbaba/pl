<?php 


class LoginController extends BaseController{
	
	private $landing_page ;
	private $views =array(
		
		"LOGIN"=>"login_page.php",
				
	);
	
	function __construct(){
		$this->landing_page = 'campaign';
	}
	
	
	function execute(){
		global $messenger;
		$action = StringUtils::getFromRequest("action",false);
		if($action=='login'){
			if(!isset($_SESSION['uid'])){
				$rd = StringUtils::getFromRequest("rd",false);
				$uname = StringUtils::getFromRequest("uname",false);
				$pass = StringUtils::getFromRequest("pass",false);
				if($uname=='root' && $pass='pass'){
					// login successful
					
					$_SESSION['uid'] = "userId";
					$_SESSION['advIds'] = array(1,2);
					if($rd!=null)
						header('Location: '.$rd);
					else 
						header('Location: '.SITEPATH.$this->landing_page);
					exit;
				}else{
					if($uname || $pass){

						$messenger['errormsg'][]='Invalid username and password';
					}
					include VIEW_PATH.'login_page.php';
					exit;
				}
			}
		}else if( $action=='logout'){
			session_start();
			$_SESSION = array();
			session_destroy();
			header('Location: '.SITEPATH.'login?action=login');
			exit;
		}else{
			$this->isLoggedIn();
			// blocking call
		}
		
	
	}
		
	
	
	public static function isLoggedIn(){
		global $messenger;
		if(isset($_SESSION['uid'])){
			// user already logged in 
			if(isset($_SESSION['advIds'])){
				$messenger['advIds'] = $_SESSION['advIds'];
			}
			return true;
		}else{
			header('Location: '.SITEPATH.'login?action=login&rd='.urlencode($_SERVER["REQUEST_URI"]));
			exit;
		}
	}
	
	function login(){
		
	}
	
	function logout(){
		
	}
}


?>