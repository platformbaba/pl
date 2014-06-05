<?php //radiostation     
 
$action = cms::sanitizeVariable( $_GET['action'] );
$mRadio=new radiostation();
$mArtist=new artist();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$action = ($action==''?'view':$action);
$id=(int)$_GET['id'];
$do = cms::sanitizeVariable( $_GET['do'] );
	   
$oLanguage = new language();	   
$lParams = array(
			'limit'	  => 10000,  
			'orderby' => 'ORDER BY language_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
	
$languageList=$oLanguage->getAllLanguages($lParams);

  
#print_r($languageList);

if( $action == 'add' || $action == 'edit'){
		$aError   = array();
		$aSuccess = array();
		$view     = 'radiostation_form';
		
		if(!empty($_POST) && isset($_POST)){
	
			$radioStationName = cms::sanitizeVariable( $_POST['radiostation_name'] );
			$languageIds = (int)cms::sanitizeVariable( $_POST['languageIds'] );
			$stationType = $_POST['stationType'];
			$preview_url = cms::sanitizeVariable($_POST['preview_url']);
			$content_url = cms::sanitizeVariable($_POST['content_url']);
			$description = cms::sanitizeVariable($_POST['description']);
			$oPicImageId = (int)$_POST['oPicImageId'];
			$picname	 =	cms::sanitizeVariable($_POST['oPic']);
			$artistHidden   = trim($_POST['artistHidden'],",");

		$artistHiddenArr=array();
		if($artistHidden){
			$artistHiddenArr=explode(",",$artistHidden);
		}

		$artistHiddensData = explode('|',trim($_POST['artistHiddensData'],"|"));
		$artistNameArr=array();
		if($artistHiddensData){
			foreach($artistHiddensData as $artistHiddensData){
				$artistNameData = explode(":",$artistHiddensData);
				if($artistNameData[0] && in_array($artistNameData[0],$artistHiddenArr)){
					$artistNameArr[$artistNameData[0]]=$artistNameData[1];
				}
			}
		}


		$isStationExist=$mRadio->checkRadioStationExist($radioStationName);
		if((int)$isStationExist[0]->cnt>0){
			$aError[]="Radio Station name already exist!";
		}

		if($radioStationName==''){
			$aError[]="Please Insert Radio Title.";
		}
		if($languageIds==''){
			$aError[]="Please Select Language Name.";
		}


			$postData=array(
				'station_id'=>$id,
				'radioStationName'=>$radioStationName,
				'languageIds' => $languageIds,
				'stationType'=>$stationType,
				'preview_url'=>$preview_url,
				'content_url'=>$content_url,
				'description'=>$description,
				'artistNameArr'	=> $artistNameArr,
				'artistId_db'	=> $artistHiddenArr[0],
				'artistId'		=> $artistHidden,
				'artistNameStr'	=> $_POST['artistHiddensData'],
				'image'=>$picname,
				
			);
			//print_r($postData);exit;
			if(empty($aError)){
				$mData=$mRadio->addRadioStation($postData);
				$logMsg="Created RadioStation.";
				if($id){
					$mData=$id;
					$logMsg="Edited RadioStation information.";
				}
				
				
			if($mData){
				$oImage=new image();
				if($oPicImageId){
					$oData=$oImage->mapRadioStationImage(array('imageId'=>$oPicImageId,'radioIds'=>array($mData)));
				}			
				
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
					'moduleName' => 'RadioStation',
					'action' => $action,
					'moduleId' => 39,
					'editorId' => $this->user->user_id,
					'remark'	=> $logMsg." (ID-".$mData.")",
					'content_ids' => $mData
				);
				TOOLS::writeActivityLog( $aLogParam );
				header("location:".SITEPATH."radiostation?action=view&msg=Action completed successfully.");exit;
			}
		}		
			
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;
			//$data['language_arr']= $languageList;	

		}


	
		if($id){
		
		$artistNameArr=array();
		$artistNameStr="";
		$aData=$mRadio->getRadioStationById(array('ids'=>$id));

		$bParams = array(
				'limit'	  => 1,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$aData[0]->artist_id.")",
		   );
	
		$artistData=$mArtist->getAllArtists($bParams);
		
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}
	
				$edtData=array(
					'stationId'=>$aData[0]->station_id,
					'radioName' => $aData[0]->name,
					'languageIds' => $aData[0]->language_id,
					'contentUrl' => $aData[0]->content_url,
					'previewUrl' => $aData[0]->preview_url,				
					'description' => $aData[0]->description,
					'RadioType' => $aData[0]->type,						
					'artistId'=>$aData[0]->artist_id,
					'artistNameArr'=>$artistNameArr,
					'image'=>$aData[0]->image,
				);
			
			
		}

		$data['aContent']=$edtData;
		$data['languageList']= $languageList;
}	
		
if($action == 'view'){
	/* To display radio station details start	
	*/
	if($do=='details'){
		$view = 'radiosration_details';
		
		$aData=$mRadio->getRadioStationById(array('ids'=>$id));
		
				$bParams = array(
				'limit'	  => 1,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$aData[0]->artist_id.")",
		   );
	
		$artistData=$mArtist->getAllArtists($bParams);		
		$artistName = $artistData[0]->artist_name;

			$edtData=array(
					'stationId'=>$aData[0]->station_id,
					'radioName' => $aData[0]->name,
					'languageIds' => $aData[0]->language_id,
					'contentUrl' => $aData[0]->content_url,
					'previewUrl' => $aData[0]->preview_url,				
					'description' => $aData[0]->description,
					'RadioType' => $aData[0]->type,						
					'artistId'=>$aData[0]->artist_id,
					'artistName'=>$artistName,
					'image'=>$aData[0]->image,
				);
			
		$data['aContent']=$edtData;
		$data['languageList']= $languageList;

		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display radiostation details start	
	*/
		$view = 'radiostation_list';
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
					$data = $mRadio->doMultiAction( $params );
					/* Write DB Activity Logs */
	
					$aLogParam = array(
						'moduleName' => 'Radio Station',
						'action' => $contentAction,
						'moduleId' => 39,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." Radio Station.",
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

				if($contentModel=='radiostation' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mRadio->doAction($params );
					/* Write DB Activity Logs */
					$aLogParam = array(
						'moduleName' => 'RadioStation',
						'action' => $contentAction,
						'moduleId' => 39,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." Radiostation. (ID-".$contentId.")",
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
		$srcRstation = cms::sanitizeVariable( $_GET['srcRstation'] );
		$srcSType	 = cms::sanitizeVariable( $_GET['srcSType'] );
		$where		 = '';
		if( $srcRstation != '' ){
			$where .= ' AND name LIKE "'.$oMysqli->secure($srcRstation).'%"';
		}
		if( $srcSType != '' ){
			$where .= ' AND type ="'.$srcSType.'" ';
		}
		$data['aSearch']['srcRstation'] = $srcRstation;
		$data['aSearch']['srcSType'] 	= $srcSType;
		/* Search Param end */
		/* Show Language as List Start */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => 'ORDER BY station_id DESC',  
					'start'   => $start,  
				  	'where'   => $where,
				  );
	
		$data['aContent'] = $mRadio->getAllRadioStation($params);
		$data['languageList']= $languageList;

		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $mRadio->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "radiostation?action=view&page={page}&srcRadioStation=$srcRadioStation&srcSType=$srcSType&submitBtn=Search";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
		
		

}
/* render view */
$oCms->view( $view, $data );