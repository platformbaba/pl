<?php 
/** 
 * The Login Model
 */
class login 
{
	public $data;
	public function doLogin($username,$password){
		global $oMysqli;
		$sSql="SELECT id,name FROM editor_master WHERE username='".$oMysqli->secure($username)."' AND password='".$oMysqli->secure(md5($password))."' AND status=1 LIMIT 1";
		$data=$oMysqli->query($sSql);
		if($data[0]->id>0){
			$data[0]->success=1;
		}else{
			$data[0] = (object) array('success' => 0 );
		}
		return $data;
	}
	/*check user loogged in or not*/
	public function checkAuth(){
		global $aConfig;
		global $oCms;
		$iEditorId = (int)Encryption::dec($_COOKIE['edtid']);
		$iEditorName = (string)Encryption::dec($_COOKIE['edtname']);
		
		if(in_array(MODULENAME,$aConfig['module']) && MODULENAME!='login'){
			if (!$iEditorId) {
				header("location:".SITEPATH."login");exit;
			}
		}
		/* to check permissons are there for logged in user*/	
		$uAction="view";
		if(cms::sanitizeVariable($_GET['action'])!=""){
			$uAction=cms::sanitizeVariable($_GET['action']);
		}
		if ($oCms->user && $oCms->user->hasPrivilege(strtolower(MODULENAME)."_".strtolower($uAction))==false && strtolower(MODULENAME)!='login' && MODULENAME!="" && in_array(MODULENAME,$aConfig['module'])){
			header("location:".SITEPATH."permission_denied");exit;
		}				
	}
}