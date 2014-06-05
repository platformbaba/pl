<?php    
$action = cms::sanitizeVariable( $_GET['action'] );
$mLabel=new label();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$action = ($action==''?'view':$action);
if( $action == 'add' ){
	$aError=array();
	$view = 'label_form';
	if(!empty($_POST) && isset($_POST)){
		$labelName=cms::sanitizeVariable($_POST['labelName']);
		$status=cms::sanitizeVariable($_POST['status']);
	
		if($labelName==""){
			$aError[]="Enter label Name!";
		}
		$isLabelExist=$mLabel->checkLabelExist($labelName);
		if((int)$isLabelExist[0]->cnt>0){
			$aError[]="Label name already exist!";
		}
		$postData=array(
					'labelName'=>$labelName,
					'status'=>$status,
					);
		if(empty($aError)){
			$mData=$mLabel->addLabel($postData);
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('label', $action, '8', $this->user->user_id, "Label, Id: ".(int)$mData."" );
				header("location:".SITEPATH."label?action=view&msg=Action completed successfully.");
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}
if( $action == 'edit' ){
	$view = 'label_form';
	$id = cms::sanitizeVariable((int)$_GET['id'] );
	if(!empty($_POST) && isset($_POST)){
		$labelName=cms::sanitizeVariable($_POST['labelName']);
		$status=cms::sanitizeVariable($_POST['status']);
		
		if($labelName==""){
			$aError[]="Enter Label Name!";
		}
		$isLabelExist=$mLabel->checkLabelExist($labelName);
		if((int)$isLabelExist[0]->cnt>0){
			$aError[]="Label name already exist!";
		}
		$postData=array(
					'id' => $id,
					'labelName'=>$labelName,
					'status'=>$status,
					);
		if(empty($aError)){
			$mData=$mLabel->editLabel($postData);
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('label', $action, '8', $this->user->user_id, "Labels, Ids: ".$id."" );
				header("location:".SITEPATH."label?action=view&msg=Action completed successfully.");
				exit;
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}else{
		$aData=$mLabel->getLabelById(array('ids'=>$id));
		$edtData=array(
					'id'=>$id,
					'labelName'=>$aData[0]->label_name,
					'status'=>$aData[0]->status,
					);
		$data['aContent']=$edtData;
	}
}
if($action == 'view'){
	$view = 'label_list';
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
					$data = $mLabel->doMultiAction( $params );
					/* Write DB Activity Logs */
					TOOLS::log('label', $contentAction, '8', $this->user->user_id, "Labels, Ids: ".implode("','", $_POST['select_ids'])."" );
	
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

				if($contentModel=='label' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mLabel->doAction($params );
					/* Write DB Activity Logs */
					TOOLS::log('label', $contentAction, '8', $this->user->user_id, "Labels, Id: ".$contentId."" );
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
		/* Search Param start */
		$srcLabel = cms::sanitizeVariable( $_GET['srcLabel'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$where		 = '';
		if( $srcLabel != '' ){
			$where .= ' AND label_name like "'.$oMysqli->secure($srcLabel).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		$data['aSearch']['srcLabel'] = $srcLabel;
		$data['aSearch']['srcCType'] 	= $srcCType;
		/* Search Param end */
		/* Show Language as List Start */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => 'ORDER BY insert_date DESC',  
					'start'   => $start,  
				  	'where'   => $where,
				  );
	
		$data['aContent'] = $mLabel->getAllLabels($params );
	
		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mLabel->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "label?action=view&page={page}&srcLabel=$srcLabel&srcCType=$srcCType&submitBtn=Search";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
}
/* render view */
$oCms->view( $view, $data );