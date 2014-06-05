<?php    
$action = cms::sanitizeVariable( $_GET['action'] );
$mBanner=new banner();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$action = ($action==''?'view':$action);
if( $action == 'add' ){
	$aError=array();
	$view = 'banner_form';
	if(!empty($_POST) && isset($_POST)){
		$bannerName=cms::sanitizeVariable($_POST['bannerName']);
		$status=cms::sanitizeVariable($_POST['status']);
	
		if($bannerName==""){
			$aError[]="Enter Banner Name!";
		}
		$isBannerExist=$mBanner->checkBannerExist($bannerName);
		if((int)$isBannerExist[0]->cnt>0){
			$aError[]="Banner name already exist!";
		}
		$postData=array(
					'bannerName'=>$bannerName,
					'status'=>$status,
					);
		if(empty($aError)){
			$mData=$mBanner->addBanner($postData);
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('banner', $action, '8', $this->user->user_id, "Banner, Id: ".(int)$mData."" );
				header("location:".SITEPATH."banner?action=view&msg=Action completed successfully.");
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}
if( $action == 'edit' ){
	$view = 'banner_form';
	$id = cms::sanitizeVariable((int)$_GET['id'] );
	if(!empty($_POST) && isset($_POST)){
		$bannerName=cms::sanitizeVariable($_POST['bannerName']);
		$status=cms::sanitizeVariable($_POST['status']);
		
		if($bannerName==""){
			$aError[]="Enter Banner Name!";
		}
		$isBannerExist=$mBanner->checkBannerExist($bannerName);
		if((int)$isBannerExist[0]->cnt>0){
			$aError[]="Banner name already exist!";
		}
		$postData=array(
					'id' => $id,
					'bannerName'=>$bannerName,
					'status'=>$status,
					);
		if(empty($aError)){
			$mData=$mBanner->editBanner($postData);
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('banner', $action, '8', $this->user->user_id, "Banners, Ids: ".$id."" );
				header("location:".SITEPATH."banner?action=view&msg=Action completed successfully.");
				exit;
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}else{
		$aData=$mBanner->getBannerById(array('ids'=>$id));
		$edtData=array( 
					'id'=>$id,
					'bannerName'=>$aData[0]->banner_name,
					'status'=>$aData[0]->status,
					);
		$data['aContent']=$edtData;
	}
}
if($action == 'view'){
	$view = 'banner_list';
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
					$data = $mBanner->doMultiAction( $params );
					/* Write DB Activity Logs */
					TOOLS::log('banner', $contentAction, '8', $this->user->user_id, "Banners, Ids: ".implode("','", $_POST['select_ids'])."" );
	
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

				if($contentModel=='banner' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mBanner->doAction($params );
					/* Write DB Activity Logs */
					TOOLS::log('banner', $contentAction, '8', $this->user->user_id, "Banners, Id: ".$contentId."" );
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
		$srcBanner = cms::sanitizeVariable( $_GET['srcBanner'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$where		 = '';
		if( $srcBanner != '' ){
			$where .= ' AND banner_name like "'.$oMysqli->secure($srcBanner).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		$data['aSearch']['srcBanner'] = $srcBanner;
		$data['aSearch']['srcCType'] 	= $srcCType;
		/* Search Param end */
		
		$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'insert_date', 'default_sort'=>'DESC', 'field'=>'banner_name' ) );
		
		/* Show Banner as List Start */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => $orderBy,  
					'start'   => $start,
					'where'   => $where,  
				  );
	
		$data['aContent'] = $mBanner->getAllBanners($params );
	
		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mBanner->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "banner?action=view&page={page}&srcBanner=$srcBanner&srcCType=$srcCType&submitBtn=Search&sort=".$_GET['sort'];
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
}
/* render view */
$oCms->view( $view, $data );