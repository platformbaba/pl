<?php
$view = 'tags_list';
$oTags = new tags();

$action = cms::sanitizeVariable( $_GET['action'] );
if( $action == 'add' || $action == 'edit' ){
	$aTags = $oTags->getAllTags( array('onlyParent'=>true) );
	/* Form */
	$view = 'tags_form';
	$id = (int)$_GET['id']; 

	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		
		$tagName		=	cms::sanitizeVariable($_POST['tagName']);
		$tagAlias		=	cms::sanitizeVariable($_POST['tagAlias']);
		$parentTagId	=	(int)$_POST['parentTagId'];
		$status			=	cms::sanitizeVariable($_POST['status']);
		$oPicImageId	=	(int)$_POST['oPicImageId'];
		$image 			=	cms::sanitizeVariable($_POST['oPic']);
		
		$tagAccess		= 0;
		if( !empty($_POST['tagAccess']) ){ 
			foreach( $_POST['tagAccess'] as $k=>$accesVal ){
				$tagAccess = $tagAccess|$accesVal;
			}
		}	
			
		if($tagName==""){
			$aError[]="Enter Tag Name.";
		}
		$isTagExist = $oTags->checkTagExist($tagName, $parentTagId);
		if( $isTagExist>0 ){
			$aError[]="Tag Name already Exist!";
		}

		if(empty($aError)){
			
			$params = array(
						'tagName' => $tagName, 
						'tagAlias' => $tagAlias, 
						'parentTagId' => $parentTagId,
						'tagAccess' => $tagAccess,
						'image'		=>	$image,
						'status' => $status,						
					  ); 
			$id = $oTags->saveTag( $params );

			
			TOOLS::log('tag', $action, '9', (int)$this->user->user_id, "Tag, Id: ".$id."" );
			
			$data['aSuccess'] = 'Data saved successfully.';
			header('location:'.SITEPATH.'tags?pid='.$parentTagId.'&msg=Data saved successfully');			
		}else{
			$data['aError'] = $aError;
		}
		
		$data['aContent']['tagName'] 	 = $tagName;
		$data['aContent']['tagAlias'] 	 = $tagAlias;
		$data['aContent']['parentTagId'] = $parentTagId;
		$data['aContent']['tagAccess']	 = $tagAccess;
		$data['aContent']['status']		 = $status;
		
	}else if($action == 'edit'){
		/* Get Tags Data */	
		
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'status' => $status, 
					'where' => " AND tag_id='".$id."'", 
				  ); 
		$aTagData = $oTags->getAllTags( $params );
		$data['aContent']['tagName'] 	 = $aTagData[$id]->tag_name;
		$data['aContent']['tagAlias'] 	 = $aTagData[$id]->tag_alias;
		$data['aContent']['image'] 		 = $aTagData[$id]->image;
		$data['aContent']['parentTagId'] = $aTagData[$id]->parent_tag_id;
		$data['aContent']['tagAccess']	 = $aTagData[$id]->tag_access;
		$data['aContent']['status']		 = $aTagData[$id]->status;
	}
	$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
	$data['aTags']	 	 = $aTags;
	
}else{

	
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
				$data = $oTags->doMultiAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('tag', $contentAction, '9', (int)$this->user->user_id, "Tags, Ids: '".implode("','", $_POST['select_ids'])."' " );

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

			if($contentModel=='tags' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oTags->doAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('tag', $contentAction, '9', (int)$this->user->user_id, "Tags, Id: ".$contentId."" );
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
	$lisData			= getlist( $oTags );
	$data['aContent']	 = $lisData['aContent'];
	$data['aTags']	 	 = $lisData['aTags'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount']	 = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
}

function getlist( $oTags ){
	global $oMysqli;
	
	/* Search Param start */
	$parentId    = (int)$_GET['srcPid'];
	$srcTag		 = cms::sanitizeVariable( $_GET['srcTag'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$where		 = '';
	if( $srcTag != '' ){
		$where .= ' AND tag_name like "'.$oMysqli->secure($srcTag).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	if($parentId > 0){
		$where.=" AND parent_tag_id = ".$parentId;
	}
	$data['aSearch']['srcTag']   = $srcTag;
	$data['aSearch']['srcCType'] = $srcCType;
	$data['aSearch']['srcPid']   = $parentId;
	/* Search Param end */
	$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'parent_tag_id,tag_name', 'default_sort'=>'ASC', 'field'=>'parent_tag_id,tag_name' ) );
	
	/* Show Tags as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		
	$params = array(
				'limit'	  => $limit,  
				'orderby' => $orderBy,  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oTags->getAllTags( $params );
	$data['aTags']	= $oTags->getAllTags( array('onlyParent'=>true) );
		
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oTags->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "tags?action=view&srcPid=$parentId&srcTag=$srcTag&srcCType=$srcCType&page={page}&sort=".$_GET['sort'];
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */

	/* Show Tags as List End */
	
	return $data;
}

/* render view */
$oCms->view( $view, $data );