<?php    
$action = cms::sanitizeVariable( $_GET['action'] );
$mRole=new Role();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
if( $action == 'add' ){
	$aError=array();
	$view = 'role_form';
	if(!empty($_POST) && isset($_POST)){
		$roleName=cms::sanitizeVariable($_POST['roleName']);
		$status=cms::sanitizeVariable($_POST['status']);
	
		if($roleName==""){
			$aError[]="Enter Role Name!";
		}
		if(empty($aError)){
			$postData=array(
						'roleName'=>$roleName,
						'status'=>$status,
						);

			$mData=$mRole->addRole($postData);
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('role', $action, '5', $this->user->user_id, "Roles, Id: ".(int)$mData."" );
				header("location:".SITEPATH."role?action=view&msg=Action completed successfully.");
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}
if( $action == 'edit' ){
	$view = 'role_form';
	$id = cms::sanitizeVariable((int)$_GET['id'] );
	if(!empty($_POST) && isset($_POST)){
		$roleName=cms::sanitizeVariable($_POST['roleName']);
		$status=cms::sanitizeVariable($_POST['status']);
		
		if($roleName==""){
			$aError[]="Enter Role Name!";
		}
		$postData=array(
					'id' => $id,
					'roleName'=>$roleName,
					'status'=>$status,
					);
		if(empty($aError)){
			$mData=$mRole->editRole($postData);
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('role', $action, '5', $this->user->user_id, "Roles, Ids: ".$id."" );
				header("location:".SITEPATH."role?action=view&msg=Action completed successfully.");
				exit;
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}else{
		$aData=$mRole->getRoleById(array('id'=>$id));
		$edtData=array(
					'id'=>$id,
					'roleName'=>$aData[0]->role_name,
					'status'=>$aData[0]->status,
					);
		$data['aContent']=$edtData;
	}
}
if($action == 'view'){
	$do = cms::sanitizeVariable( $_GET['do'] );
	$roleId=cms::sanitizeVariable($_GET['rId'] );

	if($do=="roleperm"){
		if(!empty($_POST) || sizeof($_POST)>0 ){
			if($_POST['select_ids']){
				$aData=$mRole->insertRolePermissions(array('roleId'=>$roleId,'permArr'=>$_POST['select_ids']));
					/* Write DB Activity Logs */
					//TOOLS::log('permissions', "add", '5', $this->user->user_id, "Permissons, Ids: ".implode(",",$_POST['select_ids'])."" );
					header("location:".SITEPATH."role?action=view&msg=Action completed successfully.");exit;
			}
		}
		$view = 'roleperm_form';	
		global $aConfig;
		$aData=$mRole->getRoleById(array('id'=>$roleId));
		$roleName=$aData[0]->role_name;
		$allPermissionByRole = Role::getRolePerms((int)$roleId);
		$data['aPermissions'] = $allPermissionByRole;
		#$data['aContent'] = $mRole->getAllPermissions();
		$allPermissions = $mRole->getAllPermissions();
		#print_r($allPermissions);
		foreach($aConfig['module'] as $kMod=>$vMod){
			foreach($allPermissions as $kPerm=>$vPerm){
				if(strpos($vPerm->perm_desc,$vMod."_")!==false){
					$permArray[$vMod][$vPerm->perm_id]=$vPerm->perm_desc;
				}
			}			
		}
		$data['aContent']=$permArray;
		$data['roleName']=$roleName;
		
	}else{	
	
		$view = 'role_list';
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
					$data = $mRole->doMultiAction( $params );
					/* Write DB Activity Logs */
					TOOLS::log('role', $contentAction, '5', $this->user->user_id, "Editors, Ids: ".implode("','", $_POST['select_ids'])."" );
	
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
	
				if($contentModel=='role' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
					$data = $mRole->doAction( $params );
					/* Write DB Activity Logs */
					TOOLS::log('role', $contentAction, '5', $this->user->user_id, "Role, Id: ".$contentId."" );
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
	
		$data['aContent'] = $mRole->getAllRoles($params );
	
		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mRole->getTotalCount();
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "role?action=view&page={page}";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		/* Pagination End */
		}
}
/* render view */
$oCms->view( $view, $data );