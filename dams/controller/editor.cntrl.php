<?php  
$action = cms::sanitizeVariable( $_GET['action'] );

$mEditor=new editor();
$mRole=new Role();
$rParams = array(
				'limit'	  => 100,  
				'orderby' => 'ORDER BY insertDate DESC',  
				'start'   => 0,  
				'where'   => "AND status=1",
		   );
$roleList=$mRole->getAllRoles($rParams);
if( $action == 'add' ){
	$aError=array();
	$view = 'editor_form';
	if(!empty($_POST) && isset($_POST)){
		$username=cms::sanitizeVariable($_POST['username']);
		$password1=cms::sanitizeVariable($_POST['password1']);
		$password2=cms::sanitizeVariable($_POST['password2']);
		$name=cms::sanitizeVariable($_POST['name']);
		$email=cms::sanitizeVariable($_POST['email']);
		
		if($username==""){
			$aError[]="Enter Username!";
		}
		$isUserExist=$mEditor->checkUserExist($username);
		if((int)$isUserExist[0]->cnt>0){
			$aError[]="User already Exist!";
		}
		if($password1==""){
			$aError[]="Enter Password!";
		}
		if($name==""){
			$aError[]="Enter Name!";
		}
		if($email==""){
			$aError[]="Enter Email Id!";
		}
		if($password1!=$password2){
			$aError[]="Password are not matched!";
		}
		if(sizeof($_POST['roleId'])==0){
			$aError[]="Please select role!";
		}
		$picname ="";
		if($_FILES['pic']['name']!=""){
			$ret = TOOLS::saveImage($_FILES['pic']);
			$picname =	$ret['image'];	
		}
		$postData=array(
					'username'=>$username,
					'password'=>$password1,
					'name'=>$name,
					'image'=>$picname,
					'status'=>(int)$_POST['status'],
					'roleId'=>(int)$_POST['roleId'],
					'emailId'=>$email,
					);
		if(empty($aError)){
			$mData=$mEditor->addEditor($postData);
			if($mData){
				$mEditor->assignRole(array('user_id'=>(int)$mData,'role_id'=>$_POST['roleId']));
				header("location:".SITEPATH."editor?action=view&msg=Action completed successfully.");
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
	$data['roleList']=$roleList;
}
if( $action == 'edit' ){
	$view = 'editor_form';
	$id = cms::sanitizeVariable((int)$_GET['id'] );
	$userRoles=$mEditor->getUsersRolesById(array('id'=>$id));//all roles of current users
	$usersRoles=array();
	if($userRoles){
		foreach($userRoles as $v){
			$usersRoles[]=$v->role_id;
		}
	}
	if(!empty($_POST) && isset($_POST)){
		$username=cms::sanitizeVariable($_POST['username']);
		$password1=cms::sanitizeVariable($_POST['password1']);
		$password2=cms::sanitizeVariable($_POST['password2']);
		$name=cms::sanitizeVariable($_POST['name']);
		$email=cms::sanitizeVariable($_POST['email']);
		
		if($username==""){
			$aError[]="Enter Username!";
		}
		$isUserExist=$mEditor->checkUserExist($username);
		if((int)$isUserExist[0]->cnt>0){
			$aError[]="User already Exist!";
		}
		if($password1==""){
			$aError[]="Enter Password!";
		}
		if($name==""){
			$aError[]="Enter Name!";
		}
		if($email==""){
			$aError[]="Enter Email Id!";
		}
		if($password1!=$password2){
			$aError[]="Password are not matched!";
		}
		if(sizeof($_POST['roleId'])==0){
			$aError[]="Please select role!";
		}
		if(sizeof($_FILES)>0 && !empty($_FILES) && $_FILES["pic"]["name"]!=""){
			$ret = TOOLS::saveImage($_FILES['pic']);
			$picname =	$ret['image'];	
		}else{
			$picname = cms::sanitizeVariable($_POST['oPic']);
		}
		$postData=array(
					'id' => $id,
					'username'=>cms::sanitizeVariable($_POST['username']),
					'password'=>cms::sanitizeVariable($_POST['password1']),
					'name'=>cms::sanitizeVariable($_POST['name']),
					'image'=>$picname,
					'status'=>cms::sanitizeVariable($_POST['status']),
					'roleId'=>(int)$_POST['roleId'],
					'emailId'=>$email,
					);
		if(empty($aError)){
			$mData=$mEditor->updateEditor($postData);
			$mEditor->assignRole(array('user_id'=>(int)$id,'role_id'=>$_POST['roleId']));
			if($mData){
				header("location:".SITEPATH."editor?action=view&msg=Action completed successfully.");
				exit;
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}else{
		$aData=$mEditor->getEditorById(array('id'=>$id));
		$edtData=array(
					'id'=>$aData[0]->id,
					'username'=>$aData[0]->username,
					'password'=>$aData[0]->password,
					'name'=>$aData[0]->name,
					'image'=>$aData[0]->image,
					'status'=>$aData[0]->status,
					'roleId'=>$usersRoles,
					'emailId'=>$aData[0]->email_id,
					);
		$data['aContent']=$edtData;
	}
	$data['roleList']=$roleList;
}
if($action == 'view'){
	$view = 'editor_list';
	$roleIdArray=array();
	foreach($roleList as $kRole=>$vRole){
		$roleIdArray[$vRole->role_id]=$vRole->role_name;
	}
	/* Publish/Draft/Delete Action Start */
	if(isset($_POST) && !empty($_POST)){

		if( !empty($_POST['select_ids']) ){
			/* Multi Action Start */
			$contentAction		=	cms::sanitizeVariable( $_POST['act'] );
			$contentActionValue =	TOOLS::getContentActionValue($contentAction);

			if( $contentActionValue !='' ){
				$params = array(
							'contentIds' => $_POST['select_ids'], 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $mEditor->doMultiAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('editor', $contentAction, '3', $this->user->user_id, "Editors, Ids: ".implode("','", $_POST['select_ids'])."" );

				$data['aSuccess'][] = 'Data saved successfully.';
				/* Saved */
			}else{
				/* Error occured */
				$data['aError'][] = 'Error: Please try again.';
			}
			/* Multi Action End */

		}else{
			/* Single Action Start */
			$contentId			=	(int)$_POST['contentId'];
			$contentAction		=	cms::sanitizeVariable( $_POST['contentAction'] );
			$contentModel		=	cms::sanitizeVariable( $_POST['contentModel'] );
			$contentActionValue =	TOOLS::getContentActionValue($contentAction);

			if($contentModel=='editor' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $mEditor->doAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('editor', $contentAction, '3', $this->user->user_id, "Editor, Id: ".$contentId."" );
				/* Saved */
				$data['aSuccess'][] = 'Data saved successfully.';
			}else{
				/* Error occured */
				$data['aError'][] = 'Error: Please try again.';
			}
			/* Single Action End */
		}
		
	}
	/* Publish/Draft/Delete Action End */

	/* Show Language as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => 'ORDER BY insertDate DESC',  
				'start'   => $start,  
			  );

	$data['aContent'] = $mEditor->getAllEditors( $params );
    
	/* start to get role list by user id*/
	$roleWithidArray=array();
	foreach($data['aContent'] as $kAllED=>$vAllED){
		$getUsersRolesById=$mEditor->getUsersRolesById(array('id'=>$vAllED->id));		
		
		#print_r($getUsersRolesById);
		
		if($getUsersRolesById){
			unset($roleWithidArray);
			foreach($getUsersRolesById as $rId){
				$roleWithidArray[$vAllED->id][]=ucfirst($roleIdArray[$rId->role_id]);
			}
			if(is_array($roleWithidArray[$vAllED->id])){
				$roleWithidArray[$vAllED->id]=implode(",",$roleWithidArray[$vAllED->id]);
			}
		}
		#print_r($roleWithidArray);
		if(is_array($roleWithidArray)){
			$data['aRole'][$vAllED->id]=implode(",",$roleWithidArray);
		}
		unset($roleWithidArray);
	}
	/* end to get role list by user id*/
	
	#print_r($data);
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $mEditor->getTotalCount();
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "editor?action=view&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */

}
/* render view */
$oCms->view( $view, $data );