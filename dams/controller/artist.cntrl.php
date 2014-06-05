<?php         
$action = cms::sanitizeVariable( $_GET['action'] );
$mArtist=new artist();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$do = cms::sanitizeVariable( $_GET['do'] );
$id = cms::sanitizeVariable((int)$_GET['id'] );
$action = ($action==''?'view':$action);
$oImage = new image();
if( $action == 'add' ){
	$aError=array();
	$view = 'artist_form';
	if(!empty($_POST) && isset($_POST)){
		$artistName=cms::sanitizeVariable($_POST['artistName']);
		$status=cms::sanitizeVariable($_POST['status']);
		$content=cms::sanitizeVariable($_POST['content']);
		$gender=cms::sanitizeVariable($_POST['gender']);
		$dob=cms::sanitizeVariable($_POST['dob']);
		$dod=cms::sanitizeVariable($_POST['dod']);
		$alias=cms::sanitizeVariable($_POST['alias']);
		$oPicImageId=(int)$_POST['oPicImageId'];
			
		if($artistName==""){
			$aError[]="Enter artist Name!";
		}
		$isArtistExist=$mArtist->checkArtistExist(array('aName'=>$artistName,'dob'=>$dob));
		if((int)$isArtistExist[0]->cnt>0){
			$aError[]="Artist name already exist!";
		}
		if(sizeof($_POST['role'])==0){
			$aError[]="Select role!";
		}
		$picname ="";
		if($_FILES['pic']['name']!=""){ 
			$ret = TOOLS::saveImage($_FILES['pic']);
			$picname =	$ret['image'];	
		}else{
			$picname =	cms::sanitizeVariable($_POST['oPic']);	
		}
		if($_POST['role']){
			$sRole=implode("|",$_POST['role']);
		}
		$postData=array( 
				'artistName'=>$artistName,
				'status'=>$status,
				'role' => $_POST['role'],
				'image'=>$picname,
				'content'=> htmlentities($content),
				'gender' => $gender,
				'dob' => $dob,
				'dod' => $dod,
				'sRole' => $sRole,
				'alias' => $alias,
			);
		if(empty($aError)){ 
			$mData=$mArtist->addArtist($postData);
			if($mData){
				if($oPicImageId){
					$oData=$oImage->mapArtistImage(array('imageId'=>$oPicImageId,'albumIds'=>array($mData)));
				}
				/* Write DB Activity Logs */
				#TOOLS::log('artist', $action, '13', $this->user->user_id, "Artist, Id: ".(int)$mData."" );
				$aLogParam = array(
					'moduleName' => 'Artist',
					'action' => $action,
					'moduleId' => 13,
					'editorId' => $this->user->user_id,
					'remark'	=> "Created artist. (ID-".$mData.")",
					'content_ids' => $mData
				);
				TOOLS::writeActivityLog( $aLogParam );
				header("location:".SITEPATH."artist?action=view&msg=Action completed successfully.");exit;
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}
if( $action == 'edit' ){
	$view = 'artist_form';

	if(!empty($_POST) && isset($_POST)){
		$artistName=cms::sanitizeVariable($_POST['artistName']);
		$status=cms::sanitizeVariable($_POST['status']);
		$content=$_POST['content'];
		$gender=cms::sanitizeVariable($_POST['gender']);
		$dob=cms::sanitizeVariable($_POST['dob']);
		$dod=cms::sanitizeVariable($_POST['dod']);
		$alias=cms::sanitizeVariable($_POST['alias']);
		$oPicImageId = 	(int)$_POST['oPicImageId'];
		
		if($artistName==""){
			$aError[]="Enter artist Name!";
		}
		$isArtistExist=$mArtist->checkArtistExist(array('aName'=>$artistName,'dob'=>$dob));
		if((int)$isArtistExist[0]->cnt>0){
			$aError[]="Artist name already exist!";
		}
		if(sizeof($_POST['role'])==0){
			$aError[]="Select role!";
		}
		$picname ="";
		if($_FILES['pic']['name']!=""){ 
			$ret = TOOLS::saveImage($_FILES['pic']);
			$picname =	$ret['image'];	
		}else{
			$picname =	$_POST['oPic'];	
		}
		if($_POST['role']){
			$sRole=implode("|",$_POST['role']);
		}
		$postData=array(
					'id' => $id,
					'artistName'=>$artistName,
					'status'=>$status,
					'role' => $_POST['role'],
					'image'=>$picname,
					'content'=> $content,
					'gender' => $gender,
					'dob' => $dob,
					'dod' => $dod,
					'sRole' => $sRole,
					'alias' => $alias,
					);
		if(empty($aError)){
			$mData=$mArtist->editArtist($postData);
			if($oPicImageId){
				$oData=$oImage->mapArtistImage(array('imageId'=>$oPicImageId,'artistIds'=>array($id)));
			}
			/* Write DB Activity Logs */
				#TOOLS::log('artist', $action, '13', $this->user->user_id, "Artists, Id: ".$id."" );
				$aLogParam = array(
					'moduleName' => 'Artist',
					'action' => $action,
					'moduleId' => 13,
					'editorId' => $this->user->user_id,
					'remark'	=> "Edited artist information. (ID-".$id.")",
					'content_ids' => $id
				);
				TOOLS::writeActivityLog( $aLogParam );
				header("location:".SITEPATH."artist?action=view&msg=Action completed successfully.");
				exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}else{
		$aData=$mArtist->getArtistById(array('ids'=>$id));
		$roleVal=$aData[0]->artist_role;
		$roleArr=array();
		$artist_type=$mArtist->getArtistType();
		foreach($artist_type as $kAT => $vAT){
			if(($roleVal&$vAT)==$vAT){
				$roleArr[]=$vAT;
			}
		}
		$edtData=array( 
					'id'=>$id,
					'artistName'=>$aData[0]->artist_name,
					'status'=>$aData[0]->status,
					'role' => $roleArr,
					'image'=>$aData[0]->artist_image,
					'content'=> htmlentities($aData[0]->artist_biography),
					'gender' => $aData[0]->artist_gender,
					'dob' => $aData[0]->artist_dob,
					'dod' => $aData[0]->artist_dod,
					'alias' => $aData[0]->alias,
					);
		$data['aContent']=$edtData;
	}
}
if($action == 'view'){
	$view = 'artist_list';
	
	/*
	* To display artist details start	
	*/
	if($do=='details'){
		$view = 'artist_details';
		
		$aData=$mArtist->getArtistById(array('ids'=>$id));
		$roleVal=$aData[0]->artist_role;
		$roleArr=array();
		$artist_type=$mArtist->getArtistType();
		foreach($artist_type as $kAT => $vAT){
			if(($roleVal&$vAT)==$vAT){
				$roleArr[]=$vAT;
			}
		}
		$dtData=array( 
					'id'=>$id,
					'artistName'=>$aData[0]->artist_name,
					'status'=>$aData[0]->status,
					'role' => $roleArr,
					'image'=>$aData[0]->artist_image,
					'content'=> htmlentities($aData[0]->artist_biography),
					'gender' => $aData[0]->artist_gender,
					'dob' => $aData[0]->artist_dob,
					'dod' => $aData[0]->artist_dod,
					'alias' => $aData[0]->alias,
					);
		$data['aContent']=$dtData;
	
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display artist details end	
	*/
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
					$data = $mArtist->doMultiAction( $params );
					/* Write DB Activity Logs */
					#TOOLS::log('artist', $contentAction, '13', $this->user->user_id, "Artists, Ids: ".implode("','", $_POST['select_ids'])."" );
					$aLogParam = array(
						'moduleName' => 'Artist',
						'action' => $contentAction,
						'moduleId' => 13,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." artist.",
						'content_ids' => $_POST['select_ids']
					);
					TOOLS::writeActivityLog( $aLogParam );
					header("location:".SITEPATH."artist?action=view&msg=Action completed successfully.");
					exit;
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

				if($contentModel=='artist' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mArtist->doAction($params );
					/* Write DB Activity Logs */
					#TOOLS::log('artist', $contentAction, '13', $this->user->user_id, "Artists, Id: ".$contentId."" );
					$aLogParam = array(
						'moduleName' => 'Artist',
						'action' => $contentAction,
						'moduleId' => 13,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." artist. (ID-".$contentId.")",
						'content_ids' => $contentId
					);
					TOOLS::writeActivityLog( $aLogParam );
					/* Saved */
					header("location:".SITEPATH."artist?action=view&msg=Action completed successfully.");
					exit;
				}else{
					/* Error occured */
					$data['aError'][] = 'Error: Please try again.';
				}
				/* Single Action End */
			}
		}
		/* Publish/Draft/Delete Action End */
	
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$srcArType = cms::sanitizeVariable( $_GET['srcArType'] );
		
		$where		 = '';
		if( $srcArtist != '' ){
			$where .= ' AND artist_name like "'.$oMysqli->secure($srcArtist).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		if( $srcArType != '' ){
			$where .= ' AND artist_role&'.$srcArType.'='.$srcArType;
		}
 
		$data['aSearch']['srcArtist'] 	= $srcArtist;
		$data['aSearch']['srcCType'] 	= $srcCType;
		$data['aSearch']['srcArType'] 	= $srcArType;
		$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'artist_id', 'default_sort'=>'DESC', 'field'=>$_GET['field'] ) );
		
		/* Show Language as List Start */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => $orderBy,  
					'start'   => $start,  
					'where'   => $where
				  );
	
		$data['aContent'] = $mArtist->getAllArtists($params );
		$allContent=$data['aContent'];
		if($allContent){
			foreach($allContent as $kAll=>$vAll){
				$aRoleArr=NULL;
				$aRoleArr=$mArtist->getArtistTypeByValue($vAll->artist_role);
				$data['aRole'][$vAll->artist_role]= (sizeof($aRoleArr)>0)?implode(" ,",$aRoleArr):"";
			}
		}
		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mArtist->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "artist?action=view&srcArtist=$srcArtist&srcCType=$srcCType&srcArType=$srcArType&submitBtn=Search&page={page}&sort=".$_GET['sort']."&field=".$_GET['field'];
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
}
/* render view */
$oCms->view( $view, $data );