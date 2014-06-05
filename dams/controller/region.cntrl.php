<?php     
$action = cms::sanitizeVariable( $_GET['action'] );
$mRegion=new region();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$action = ($action==''?'view':$action);
if( $action == 'add' ){
	$aError=array();
	$view = 'region_form';
	$params = array(
				'where'   => ' AND status=1',
				'limit'	  => 1000,  
				'orderby' => ' ORDER BY language_name ASC',  
				'start'   => 0,  
			  );
	$oLanguage=new language();		  
	$data['languageList'] = $oLanguage->getAllLanguages( $params );

	if(!empty($_POST) && isset($_POST)){
		$regionName=cms::sanitizeVariable($_POST['regionName']);
		$status=cms::sanitizeVariable($_POST['status']);
	
		if($regionName==""){
			$aError[]="Enter region Name!";
		}
		$isRegionExist=$mRegion->checkRegionExist($regionName);
		if((int)$isRegionExist[0]->cnt>0){
			$aError[]="Region name already exist!";
		}
		$postData=array(
					'regionName'=>$regionName,
					'status'=>$status,
					);
		if(empty($aError)){ 
			$mData=$mRegion->addRegion($postData);
			$iData=$mRegion->mapRegionLanguage(array('regionId'=>(int)$mData,'languageArr'=>$_POST['languageId']));
			if($mData){
				/* Write DB Activity Logs */
				TOOLS::log('region', $action, '11', $this->user->user_id, "Region, Id: ".(int)$mData."" );
				header("location:".SITEPATH."region?action=view&msg=Action completed successfully.");
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}
if( $action == 'edit' ){
	$view = 'region_form';
	$id = cms::sanitizeVariable((int)$_GET['id'] );
	$params = array(
				'where'   => ' AND status=1',
				'limit'	  => 1000,  
				'orderby' => ' ORDER BY language_name ASC',  
				'start'   => 0,  
			  );
	$oLanguage=new language();		  
	$data['languageList'] = $oLanguage->getAllLanguages( $params );
	$languageByRegion=$mRegion->getLanguagesByRegion(array('regionId'=>$id));
	$languageByRegionArr=array();
	if($languageByRegion){
		foreach($languageByRegion as $v){
			$languageByRegionArr[]=$v->language_id;
		}
	}
	if(!empty($_POST) && isset($_POST)){
		$regionName=cms::sanitizeVariable($_POST['regionName']);
		$status=cms::sanitizeVariable($_POST['status']);
		
		if($regionName==""){
			$aError[]="Enter Region Name!";
		}
		$isRegionExist=$mRegion->checkRegionExist($regionName);
		if((int)$isRegionExist[0]->cnt>0){
			$aError[]="Region name already exist!";
		}
		$postData=array(
					'id' => $id,
					'regionName'=>$regionName,
					'status'=>$status,
					'languageId'=>$_POST['languageId'],
					);
		if(empty($aError)){
			$mData=$mRegion->editRegion($postData);
			$iData=$mRegion->mapRegionLanguage(array('regionId'=>$id,'languageArr'=>$_POST['languageId']));
				/* Write DB Activity Logs */
				TOOLS::log('region', $action, '8', $this->user->user_id, "Regions, Ids: ".$id."" );
				header("location:".SITEPATH."region?action=view&msg=Action completed successfully.");
				exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}else{
		$aData=$mRegion->getRegionById(array('ids'=>$id));
		$edtData=array(
					'id'=>$id,
					'regionName'=>$aData[0]->region_name,
					'status'=>$aData[0]->status,
					'languageId'=>$languageByRegionArr
					);
		$data['aContent']=$edtData;
	}
}
if($action == 'view'){
	$view = 'region_list';
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
					$data = $mRegion->doMultiAction( $params );
					/* Write DB Activity Logs */
					TOOLS::log('region', $contentAction, '8', $this->user->user_id, "Regions, Ids: ".implode("','", $_POST['select_ids'])."" );
	
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

				if($contentModel=='region' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mRegion->doAction($params );
					/* Write DB Activity Logs */
					TOOLS::log('region', $contentAction, '8', $this->user->user_id, "Regions, Id: ".$contentId."" );
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
		$srcRegion = cms::sanitizeVariable( $_GET['srcRegion'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$where		 = '';
		if( $srcRegion != '' ){
			$where .= ' AND region_name like "'.$oMysqli->secure($srcRegion).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		$data['aSearch']['srcRegion'] = $srcRegion;
		$data['aSearch']['srcCType'] 	= $srcCType;
		/* Search Param end */
		$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'insert_date', 'default_sort'=>'DESC', 'field'=>'region_name' ) );		
		
		/* Show Language as List Start */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => $orderBy,  
					'start'   => $start,  
					'where'   => $where,
				  );
	
		$data['aContent'] = $mRegion->getAllRegions($params );
	
		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mRegion->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "region?action=view&page={page}&srcRegion=$srcRegion&srcCType=$srcCType&submitBtn=Search&sort=".$_GET['sort'];
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
}
/* render view */
$oCms->view( $view, $data );