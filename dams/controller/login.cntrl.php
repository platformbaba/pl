<?php 
$view = 'login';

$action = cms::sanitizeVariable( $_GET['action'] );
if( $action == 'logout' ){
	/* Logout */
	setcookie("edtid",$eEditorId,time()-(60*60*24*365),"/");
	setcookie("edtname",$eEditorName,time()-(60*60*24*365),"/");
	header("location:".SITEPATH."login");
	exit;
}
if( $_POST['loginBtn']=='Log me in' ){
	$sUsername =  cms::sanitizeVariable($_POST['username']);
	$sPassword = cms::sanitizeVariable($_POST['password']);
	$sRemember = cms::sanitizeVariable($_POST['remember']);
	
	$isLogin=NULL;
	$login=new login();
	$logData=$login->doLogin($sUsername,$sPassword);
	if($logData[0]->id>0){
		$editorId=$logData[0]->id;
		$editorName=$logData[0]->name;
				
		$eEditorId = Encryption::enc($editorId);
		$eEditorName = Encryption::enc($editorName);
		if($sRemember==1){
			setcookie("edtid",$eEditorId,time()+(60*60*24*365),"/");
			setcookie("edtname",$eEditorName,time()+(60*60*24*365),"/");
		}else{		
			setcookie("edtid",$eEditorId,-1,"/");
			setcookie("edtname",$eEditorName, -1,"/");
		}
		header("location:".SITEPATH."dashboard");				
	}else{
		$data['aError'] = "Enter correct username/password!";
	}
}
/* render view */
$oCms->view( $view, $data );