<?php //catalogue     
 
$action = cms::sanitizeVariable( $_GET['action'] );
$mCatalogue=new catalogue();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$action = ($action==''?'view':$action);
$id=(int)$_GET['id'];
$do = cms::sanitizeVariable( $_GET['do'] );

$mBanner=new banner();
$bParams = array(
			'limit'	  => 1000,  
			'orderby' => 'ORDER BY banner_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
	   
  
$bannerList=$mBanner->getAllBanners($bParams);	

if( $action == 'add' || $action == 'edit'){
		$aError   = array();
		$aSuccess = array();
		$view     = 'catalogue_form';
		
		if(!empty($_POST) && isset($_POST)){

		    $territory_arr    = array();
			$territory_ex_arr = array();
	
			$isCtype = (int)cms::sanitizeVariable( $_POST['Ctype'] );
			$catalogueName = cms::sanitizeVariable( $_POST['catalogueName'] );
			$bannerId = $_POST['banner'];
			$territory_arr = $_POST['territory'];
			$territory_ex_arr = $_POST['territory_ex']; 
			$StartDate = cms::sanitizeVariable( $_POST['StartDate'] );
			$EndDate = cms::sanitizeVariable( $_POST['EndDate'] );
			$agreementId = cms::sanitizeVariable( $_POST['agreementId'] );			
			$internalContactDetails = cms::sanitizeVariable( $_POST['internalContactDetails'] );
			$contactDetails =  cms::sanitizeVariable( $_POST['contactDetails'] );
			
			$isExlclusive = ((int)cms::sanitizeVariable( $_POST['isExlclusive'] )==1) ? 1 : 0;
			$isPhysical =	((int)cms::sanitizeVariable( $_POST['isPhysical'] )==1) ? 1 : 0;

			if(!empty($_POST['pubRight'])){
				$pubRightStr=implode("|",$_POST['pubRight']);
			}else{
				$pubRightStr = 0;
			}
			$pubRightStr = $pubRightStr;
	
			if(!empty($_POST['digiRight'])){
				$digiRightStr=implode("|",$_POST['digiRight']);
			}else{
				$digiRightStr = 0;
			}
			
			$digiRightStr = $digiRightStr;

		if(!empty($territory_arr)){
				
			if(in_array(0,$territory_arr)){ // All Countries. 
			
				$territoryStr = 0;
			}
			else{
			
				$territoryStr = implode(',',$territory_arr);
			}
		}else{
			$territoryStr ='';
			
		}	
		
		if(!empty($territory_ex_arr)){		
			$territory_exStr = implode(',',$territory_ex_arr);
		}else{
			
			$territory_exStr = '';
		}


			if($isCtype==2 && $bannerId==''){
				$aError[]="Please Select Banner!";
			}
			if($StartDate=="" || $StartDate=='0000-00-00'){
				$aError[]="Enter Start Date!";
			}
			if($catalogueName==""){
				$aError[]="Enter Catalogue Title!";
			}
			/*if($agreementId==""){
				$aError[]="Enter Agreement Id!";
			}*/


			if($isCtype==1)
				$bannerId = 0;
			else
				$bannerId = $bannerId;
			
			
			
			$agreementFile ="";
			$agreementFile = cms::sanitizeVariable($_POST['oFile']);
			if($_FILES['agreementFile']['name']!=""){
				$ret = TOOLS::saveDocument($_FILES['agreementFile']);
				if(empty($ret['error'])){
					$agreementFile = $ret['doc'];	
				}
			}
			/*if($ret['error']){
				$aError[]=$ret['error'];
			}*/

			$postData=array(
				'catalogue_id'=>$id,
				'is_owned'=>$isCtype,
				'catalogueName' => $catalogueName,
				'banner_id'=>$bannerId,
				'territory_in'=>$territoryStr,
				'territory_ex'=>$territory_exStr,
				'start_date'=>$StartDate,
				'end_date'=>$EndDate,
				'agreementId' => $agreementId,
				'agreementFile' => $agreementFile,								
				'internalContactDetails' => $internalContactDetails,
				'contactDetails' => $contactDetails,
				'is_exclusive'=>$isExlclusive,
				'physical_rights'=>$isPhysical,
				'publishing_rights'=>$pubRightStr,
				'digital_rights'=>$digiRightStr,
				'status' => 0
			);

			if(empty($aError)){
				$mData=$mCatalogue->addCatalogue($postData);
				$logMsg="Created catalogue.";
				if($id){
					$mData=$id;
					$logMsg="Edited catalogue information.";
				}
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				#TOOLS::log('catalogue', $action, '21', $this->user->user_id, "Catalogue Id: ".(int)$mData."" );
				$aLogParam = array(
					'moduleName' => 'Catalogue',
					'action' => $action,
					'moduleId' => 21,
					'editorId' => $this->user->user_id,
					'remark'	=> $logMsg." (ID-".$mData.")",
					'content_ids' => $mData
				);
				TOOLS::writeActivityLog( $aLogParam );
				header("location:".SITEPATH."catalogue?action=view&msg=Action completed successfully.");exit;
			}
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;
			$data['bannerList_arr']= $bannerList;	
		
			
		}else {
		
			$data['bannerList_arr']	= $bannerList;
			if($id){
				$params=array(
					'where' => " AND catalogue_id=".$id,
				);
				$aData=$mCatalogue->getCatalogueById(array('ids'=>$id));
				$publishingRights = $aData[0]->publishing_rights;
				$digitalRights = $aData[0]->digital_rights;		
					
			
		$publishingRights_arr = array();
		$digitalRights_arr = array();
		
		if($publishingRights){				  
			$Mechanical		  = ((1&$publishingRights)==1)?$publishingRights_arr[]=1:"";
			$Performance	  = ((2&$publishingRights)==2)?$publishingRights_arr[]=2:"";
			$Synchronization  = ((4&$publishingRights)==4)?$publishingRights_arr[]=4:"";
		}
		if($publishingRights_arr){
			$pubRightStr=implode("|",$publishingRights_arr);
		}		

		if($digitalRights){				  
			$Streaming 		  = ((1&$digitalRights)==1)?$digitalRights_arr[]=1:"";
			$Downloads 		  = ((2&$digitalRights)==2)?$digitalRights_arr[]=2:"";
			$Streaming_voice  = ((4&$digitalRights)==4)?$digitalRights_arr[]=4:"";
			$Streaming_sms	  = ((8&$digitalRights)==8)?$digitalRights_arr[]=8:"";
			$Streaming_data	  = ((16&$digitalRights)==16)?$digitalRights_arr[]=16:"";
			$Download_voice	  = ((32&$digitalRights)==32)?$digitalRights_arr[]=32:"";
			$Download_sms	  = ((64&$digitalRights)==64)?$digitalRights_arr[]=64:"";
			$Download_data	  = ((128&$digitalRights)==128)?$digitalRights_arr[]=128:"";			

		}
		if($digitalRights_arr){
			$digiRightStr=implode("|",$digitalRights_arr);
		}	
			
						
				
					$edtData=array(
						'catalogueId'=>$aData[0]->catalogue_id,
						'catalogueName' => $aData[0]->catalogue_name,
						'agreementId' => $aData[0]->agreement_id,
						'agreementFile' => $aData[0]->agreement_file,			
						'contactDetails' => $aData[0]->contact_details,
						'internalContactDetails' => $aData[0]->internal_contact_details,						
						'is_owned'=>$aData[0]->is_owned,
						'banner_id'=>$aData[0]->banner_id,
						'territory_in'=>$aData[0]->territory_in,
						'territory_ex'=>$aData[0]->territory_ex,
						'start_date'=>$aData[0]->start_date,
						'end_date'=>$aData[0]->expiry_date,
						'physical_rights'=>$aData[0]->physical_rights,
						'publishing_rights'=>$pubRightStr,
						'digital_rights'=>$digiRightStr,
						'is_exclusive'=>$aData[0]->is_exclusive,
						'status'=>$status,
						'insert_date'=>$insert_date
					);
				$data['aContent']=$edtData;
				$data['bannerList_arr']	= $bannerList;
				
				
			}
		}
}				
if($action == 'view'){
	/* To display catalogue details start	
	*/
	if($do=='details'){
		$view = 'catalogue_details';
		
		$params=array(
					'where' => " AND catalogue_id=".$id,
				);
				
				
				$aData=$mCatalogue->getCatalogueById(array('ids'=>$id));
				
				$publishingRights = $aData[0]->publishing_rights;
				$digitalRights = $aData[0]->digital_rights;	
				$bannerName = ($aData[0]->banner_id==0) ? '' : $mBanner->getBannerById(array('ids'=>(int)$aData[0]->banner_id));;
			
				$publishingRights_arr = array();
				$digitalRights_arr = array();
		
		if($publishingRights){				  
			$Mechanical		  = ((1&$publishingRights)==1)?$publishingRights_arr[]=1:"";
			$Performance	  = ((2&$publishingRights)==2)?$publishingRights_arr[]=2:"";
			$Synchronization  = ((4&$publishingRights)==4)?$publishingRights_arr[]=4:"";
		}
		if($publishingRights_arr){
			$pubRightStr=implode("|",$publishingRights_arr);
		}		

		if($digitalRights){				  
			$Streaming 		  = ((1&$digitalRights)==1)?$digitalRights_arr[]=1:"";
			$Downloads 		  = ((2&$digitalRights)==2)?$digitalRights_arr[]=2:"";
			$Streaming_voice  = ((4&$digitalRights)==4)?$digitalRights_arr[]=4:"";
			$Streaming_sms	  = ((8&$digitalRights)==8)?$digitalRights_arr[]=8:"";
			$Streaming_data	  = ((16&$digitalRights)==16)?$digitalRights_arr[]=16:"";
			$Download_voice	  = ((32&$digitalRights)==32)?$digitalRights_arr[]=32:"";
			$Download_sms	  = ((64&$digitalRights)==64)?$digitalRights_arr[]=64:"";
			$Download_data	  = ((128&$digitalRights)==128)?$digitalRights_arr[]=128:"";			

		}
		if($digitalRights_arr){
			$digiRightStr=implode("|",$digitalRights_arr);
		}	
			

		$edtData=array(
				'catalogueId'=>$aData[0]->catalogue_id,
				'catalogueName' => $aData[0]->catalogue_name,
				'agreementId' => $aData[0]->agreement_id,
				'agreementFile' => $aData[0]->agreement_file,			
				
				'contactDetails' => $aData[0]->contact_details,
				'internalContactDetails' => $aData[0]->internal_contact_details,						
				'is_owned'=>$aData[0]->is_owned,
				'banner_name'=>$bannerName[0]->banner_name,
				'territory_in'=>$aData[0]->territory_in,
				'territory_ex'=>$aData[0]->territory_ex,
				
				'start_date'=>$aData[0]->start_date,
				'end_date'=>$aData[0]->expiry_date,
				'physical_rights'=>$aData[0]->physical_rights,
				'publishing_rights'=>$pubRightStr,
				'digital_rights'=>$digiRightStr,
				'is_exclusive'=>$is_exclusive
				
			);
		$data['aContent']=$edtData;
		$data['bannerList_arr']	= $bannerList;

		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display catalogue details start	
	*/
		$view = 'catalogue_list';
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
					$data = $mCatalogue->doMultiAction( $params );
					/* Write DB Activity Logs */
					#TOOLS::log('catalogue', $contentAction, '21', $this->user->user_id, "Catalogues Ids: ".implode("','", $_POST['select_ids'])."" );
					$aLogParam = array(
						'moduleName' => 'Catalogue',
						'action' => $contentAction,
						'moduleId' => 21,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." catalogue.",
						'content_ids' => $_POST['select_ids']
					);
					TOOLS::writeActivityLog( $aLogParam );
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

				if($contentModel=='catalogue' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mCatalogue->doAction($params );
					/* Write DB Activity Logs */
					#TOOLS::log('catalogue', $contentAction, '21', $this->user->user_id, "Catalogues Id: ".$contentId."" );
					$aLogParam = array(
						'moduleName' => 'Catalogue',
						'action' => $contentAction,
						'moduleId' => 21,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." catalogue. (ID-".$contentId.")",
						'content_ids' => $contentId
					);
					TOOLS::writeActivityLog( $aLogParam );
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
		$srcCatalogue = cms::sanitizeVariable( $_GET['srcCatalogue'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$where		 = '';
		if( $srcCatalogue != '' ){
			$where .= ' AND catalogue_name like "'.$oMysqli->secure($srcCatalogue).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		$data['aSearch']['srcCatalogue'] = $srcCatalogue;
		$data['aSearch']['srcCType'] 	= $srcCType;
		/* Search Param end */
		/* Show Language as List Start */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => 'ORDER BY catalogue_id DESC',  
					'start'   => $start,  
				  	'where'   => $where,
				  );
	
		$data['aContent'] = $mCatalogue->getAllCatalogues($params );

		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mCatalogue->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "catalogue?action=view&page={page}&srcCatalogue=$srcCatalogue&srcCType=$srcCType&submitBtn=Search";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
		
		

}
/* render view */
$oCms->view( $view, $data );