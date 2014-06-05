<?php
/* CMS CLass contain all common functions for this framework */

class cms{
	public $user;
	public function __construct(){
		$iEditorId = TOOLS::getEditorId();
		if (isset($iEditorId)){
    		$this->user = privilegeduser::getEditorById(array("id"=>(int)$iEditorId));
		}	
	}
	public function header(){
		global $aConfig;
		$cTheme=TOOLS::getTheme();
		include_once(TEMPLATESPATH. 'header.php');
	} /* header */

	public function lhs(){
		global $aConfig;
		include_once(TEMPLATESPATH. 'lhs.php');
	} /* lhs */

	public function footer(){
		global $aConfig;
		include_once(TEMPLATESPATH. 'footer.php');
	
	} /* footer */

	public static function sanitizeVariable( $val ){
		return strip_tags(trim($val));
	} /* sanitizeVariable */

	public function load(){
		global $oCms,$oTools,$oMysqli,$oNotification;
		$data = array();
		
		if( MODULENAME == ''){
			/* include login controller */
			include_once(CONTROLLERPATH. 'login.cntrl.php');

		}else if( file_exists(CONTROLLERPATH.MODULENAME.'.cntrl.php') ){
			/* include respective controller */
			include_once(CONTROLLERPATH.MODULENAME.'.cntrl.php');

		}else{
			/* include login controller */
			include_once(CONTROLLERPATH. 'login.cntrl.php');
		}
	} /* load */

	public function view( $view, array $data= array() ){
		global $aConfig;
		global $aError;
		#print_r($this->user);
		if($view!='login'){
			/* Include header file */
			$this->header();
			
			/* Include LHS file */
			$this->lhs();
		}
		/* include View HTML file */
		extract( $data );
		include_once(VIEWPATH.$view.'.view.php');
		if($view!='login'){
			/*   footer file */
			$this->footer();
		}
	}
	public function getUser(){
		return  $this->user;
	}
} /* CMS */
