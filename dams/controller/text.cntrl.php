<?php
$view = 'text_list';
$oText = new text();


	$lParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY language_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1",
		   );
		
		$oLanguage = new language();	
    	$languageList=$oLanguage->getAllLanguages($lParams);
		$data['languageList']=$languageList;

$action = cms::sanitizeVariable( $_GET['action'] );
$do = cms::sanitizeVariable( $_GET['do'] );
$id = (int)$_GET['id']; 

if( $action == 'add' || $action == 'edit' ){
	/* Form */
	$view = 'text_form';

	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$status	    =	cms::sanitizeVariable($_POST['status']);
		$textName	    =	cms::sanitizeVariable($_POST['textName']);
		$textDesc	    =	trim($_POST['textDesc']);
		$languageIds    =   cms::sanitizeVariable($_POST['languageIds']);
		$textType       =   cms::sanitizeVariable($_POST['textType']);
		
		$artistHidden   = trim($_POST['artistHidden'],",");
		$albumHidden   = trim($_POST['albumHidden'],",");
 		
		$artistHiddenArr=array();
		if($artistHidden){
			$artistHiddenArr=explode(",",$artistHidden);
		}
		$albumHiddenArr=array();
		if($albumHidden){
			$albumHiddenArr=explode(",",$albumHidden);
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
		$albumHiddensData = explode('|',trim($_POST['albumHiddensData'],"|"));
		$albumNameArr=array();
		if($albumHiddensData){
			foreach($albumHiddensData as $albumHiddensData){
				$albumNameData = explode(":",$albumHiddensData);
				if($albumNameData[0] && in_array($albumNameData[0],$albumHiddenArr)){
					$albumNameArr[$albumNameData[0]]=$albumNameData[1];
				}
			}
		}
		
		
		if( empty($albumHiddenArr) ){
			$aError[]="Select Album.";
		}
		if($textName==""){
			$aError[]="Enter Text Title.";
		}
		if($textType==""){
			$aError[]="Please Select Text Type.";
		}
		if($languageIds==""){
			$aError[]="Please Select Language Name.";
		}
		

		$pic_file_name = '';
		
		if(sizeof($_FILES)>0 && !empty($_FILES) && $_FILES["txt_file"]["name"]!=""){
			$ret = TOOLS::saveDocument($_FILES['txt_file']);
			
			$txt_file_name =	$ret['doc'];	
		}else{
			$txt_file_name = cms::sanitizeVariable($_POST['otxt_file']);
		}

		$params = array(
					'textName' 	=> $textName, 
					'textDesc' 	=> strip_tags($textDesc), 
					'txtFileName' => $txt_file_name, 
					'textType' => $textType, 
					'albumNameArr'	=> $albumNameArr,
					'albumId'		=> $albumHidden,
					'albumNameStr'	=> $_POST['albumHiddensData'],
					'artistNameArr'	=> $artistNameArr,
					'artistId'		=> $artistHidden,
					'artistNameStr'	=> $_POST['artistHiddensData'],
					'languageIds' => $languageIds,
					'status'      => $status,
				  );
		
		if(empty($aError)){
			
			$aData = $oText->saveText( $params );
			$logMsg="Created text.";
			if($id){
				$aData=$id;
				$logMsg="Edited text information.";
			}else{
				$id=$aData;
			}
			if($aData){
				if($artistHiddenArr){ 
					$oData=$oText->mapArtistText(array('textId'=>(int)$aData,'artistIds'=>$artistHiddenArr));					
				}
				
				if($albumHiddenArr){
					$lData=$oText->mapAlbumText(array('textId'=>(int)$aData,'albumIds'=>$albumHiddenArr));
				}	
				
			}
			
			
			/* Send Mail Notification start*/
			if($action == 'add'){
				$oMailParam = array(
						'moduleName' => 'Text',
						'action' => $action,
						'moduleId' => 19,
						'editorId' => $this->user->user_id,
						'content_ids' => $id
					);
				$oNotification->sendNotification( $oMailParam );
				
			}
			/* Send Mail Notification end*/
			
			
			/* Write DB Activity Logs */
			#TOOLS::log('Text', $action, '19', (int)$this->user->user_id, "Text, Id: ".$id."" );
			$aLogParam = array(
					'moduleName' => 'Text',
					'action' => $action,
					'moduleId' => 19,
					'editorId' => $this->user->user_id,
					'remark'	=> $logMsg." (ID-".$id.")",
					'content_ids' => $id
				);
			TOOLS::writeActivityLog( $aLogParam );
			$data['aSuccess'] = 'Data saved successfully.';
			header('location:'.SITEPATH.'text?msg=Data saved successfully');exit;
		}else{
			$data['aError'] = $aError;
		}
		$data['aContent'] = $params;
		
	}else if($action == 'edit'){
		/* Get Text Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					//'file_type' => $status, 
					'where' => " AND text_id= '".$id."'"
				  ); 
		$aTextData = $oText->getAllTexts( $params ); 
				
		$artistTextMapData=$oText->getTextMap(array('where'=> " AND content_type=13 AND text_id=".$id));
		
		$artistHiddenArr=array();
		
		if( !empty($artistTextMapData) ){
			foreach($artistTextMapData as $artist){
				$artistHiddenArr[]=$artist->content_id;
			}
		}
		
		$artistHidden="";
		if($artistHiddenArr){
			$artistHidden=implode(",",$artistHiddenArr);
		}
		$mArtist=new artist();
		$artistHiddenIn="0";
		if($artistHidden){
			$artistHiddenIn=$artistHidden;
		}
		
		$artistNameArr=array();
		$artistNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$artistHiddenIn.")",
		   );
		$artistData=$mArtist->getAllArtists($bParams);
		
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}
		
		$albumTextMapData=$oText->getTextMap(array('where'=> " AND content_type=14 AND text_id=".$id));
		
		$albumHiddenArr=array();
		if($albumTextMapData){
			foreach($albumTextMapData as $album){
				$albumHiddenArr[]=$album->content_id;
			}
		}
		
		$albumHidden="";
		if($albumHiddenArr){
			$albumHidden=implode(",",$albumHiddenArr);
		}
		$mAlbum=new album();
		$albumHiddenIn="0";
		if($albumHidden){
			$albumHiddenIn=$albumHidden;
		}
		
		$albumNameArr=array();
		$albumNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY album_name ASC',  
				'start'   => 0,  
				'where'   => " AND album_id IN (".$albumHiddenIn.")",
		   );
		$albumData=$mAlbum->getAllAlbums($bParams);
		
		if($albumData){
			foreach($albumData as $aD){
				$albumNameStr.=$aD->album_id.":".$aD->album_name."|";
				$albumHiddenArr[]=$aD->album_id;
				$albumNameArr[$aD->album_id]=$aD->album_name;
			}	
		}

	
	$data['aContent'] = array(
								'textName'=>$aTextData[0]->text_name,
								'textDesc'=>$aTextData[0]->text_desc,
								'textFile'=>$aTextData[0]->file_path,
								'albumNameArr'=>$albumNameArr,
								'albumId' => $albumHidden,
								'albumNameStr'=>$albumNameStr,
								'artistNameArr'=>$artistNameArr,
								'artistId' => $artistHidden,
								'artistNameStr'=>$artistNameStr,
								'languageIds'=>$aTextData[0]->language_id,
								'status'=>$aTextData[0]->status,
							);
	}
	$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
	$data['text_type'] 	= TOOLS::getTextTypes();
	
	

}else{
	
/*
	* To display rights popup start	
	*/
	if($do=='rights'){
	
		$view = 'text_rights';
		if(!empty($_POST) && isset($_POST)){
		
		    $territory_arr = array();
			$territory_ex_arr = array();
			
			$isCtype = (int)cms::sanitizeVariable( $_POST['Ctype'] );
			$bannerId=$_POST['banner'];
			$territory_arr = $_POST['territory'];
			$territory_ex_arr = $_POST['territory_ex']; 
			$StartDate = cms::sanitizeVariable( $_POST['StartDate'] );
			$EndDate = cms::sanitizeVariable( $_POST['EndDate'] );
			$isExlclusive = (int)cms::sanitizeVariable( $_POST['isExlclusive'] );
			$isPhysical =  (int)cms::sanitizeVariable( $_POST['isPhysical'] );
			
			
			$isExlclusive = ($isExlclusive==1) ? 1 : 0;
			$isPhysical =	($isPhysical==1) ? 1 : 0;
		
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
			
			if($isCtype==2 && $bannerId==''){
				$aError[]="Please Select Banner!";
			}
			
			
			if($StartDate=="" || $StartDate=='0000-00-00'){
				$aError[]="Enter Start Date!";
			}

			if($isCtype==1)
				$bannerId = 0;
			else
				$bannerId = $bannerId;
				
			$postData=array(
					'textId'=>$id,
					'is_owned'=>$isCtype,
					'banner_id'=>$bannerId,
					'territory_in'=>$territoryStr,
					'territory_ex'=>$territory_exStr,
					'start_date'=>$StartDate,
					'end_date'=>$EndDate,
					'physical_rights'=>$isPhysical,
					'is_exclusive'=>$isExlclusive,
					'publishing_rights'=>$pubRightStr,
					'digital_rights'=>$digiRightStr,
					);
					
			if(empty($aError)){
				$mData=$oText->addTextRights($postData);
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
									'moduleName' => 'text rights',
									'action' => $action,
									'moduleId' => 19,
									'editorId' => $this->user->user_id,
									'remark'	=>	'Edited Text rights information. (ID-'.$id.')',
									'content_ids' => (int)$id
								);
				TOOLS::writeActivityLog( $aLogParam );
								
				//TOOLS::log('text rights', $action, '19', $this->user->user_id, "Text, Id: ".(int)$mData."" );
				//header("location:".$refferer."&msg=Action completed successfully.");
			}
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;			
			
		}else {
		
			$params=array(
					'where' => " AND text_id=".$id,
					);
					
			
			$dataRightsByTextId=$oText->getRightsByTextId($params);
			
			$publishingRights = $dataRightsByTextId[0]->publishing_rights;
			$digitalRights = $dataRightsByTextId[0]->digital_rights;
			
					
			
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
			
		
			if($dataRightsByTextId){
				$edtData=array(
						'textId'=>$dataRightsByTextId[0]->text_id,
						'is_owned'=>$dataRightsByTextId[0]->is_owned,
						'banner_id'=>$dataRightsByTextId[0]->banner_id,
						'territory_in'=>$dataRightsByTextId[0]->territory_in,
						'territory_ex'=>$dataRightsByTextId[0]->territory_ex,
						'start_date'=>$dataRightsByTextId[0]->start_date,
						'end_date'=>$dataRightsByTextId[0]->expiry_date,
						'physical_rights'=>$dataRightsByTextId[0]->physical_rights,
						'publishing_rights'=>$pubRightStr,
						'digital_rights'=>$digiRightStr,
						'is_exclusive'=>$dataRightsByTextId[0]->is_exclusive,
					);
					
					
				$data['aContent']=$edtData;
				
			}
		}		
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display rights popup end	
	*/			
		#########################POP Up comes here.############	
		if($do=='details'){
			/* Get Text Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					//'file_type' => $status, 
					'where' => " AND text_id= '".$id."'"
				  ); 
		$aTextData = $oText->getAllTexts( $params ); 
				
		$artistTextMapData=$oText->getTextMap(array('where'=> " AND content_type=13 AND text_id=".$id));
		
		$artistHiddenArr=array();
		
		if( !empty($artistTextMapData) ){
			foreach($artistTextMapData as $artist){
				$artistHiddenArr[]=$artist->content_id;
			}
		}
		
		$artistHidden="";
		if($artistHiddenArr){
			$artistHidden=implode(",",$artistHiddenArr);
		}
		$mArtist=new artist();
		$artistHiddenIn="0";
		if($artistHidden){
			$artistHiddenIn=$artistHidden;
		}
		
		$artistNameArr=array();
		$artistNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$artistHiddenIn.")",
		   );
		$artistData=$mArtist->getAllArtists($bParams);
		
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}
		
		$albumTextMapData=$oText->getTextMap(array('where'=> " AND content_type=14 AND text_id=".$id));
		
		$albumHiddenArr=array();
		if($albumTextMapData){
			foreach($albumTextMapData as $album){
				$albumHiddenArr[]=$album->content_id;
			}
		}
		
		$albumHidden="";
		if($albumHiddenArr){
			$albumHidden=implode(",",$albumHiddenArr);
		}
		$mAlbum=new album();
		$albumHiddenIn="0";
		if($albumHidden){
			$albumHiddenIn=$albumHidden;
		}
		
		$albumNameArr=array();
		$albumNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY album_name ASC',  
				'start'   => 0,  
				'where'   => " AND album_id IN (".$albumHiddenIn.")",
		   );
		$albumData=$mAlbum->getAllAlbums($bParams);
		
		if($albumData){
			foreach($albumData as $aD){
				$albumNameStr.=$aD->album_id.":".$aD->album_name."|";
				$albumHiddenArr[]=$aD->album_id;
				$albumNameArr[$aD->album_id]=$aD->album_name;
			}	
		}

			
			$view = 'text_details';
			$data['aContent'] = array(
							'textId'=>$aTextData[0]->text_id,
							'textName'=>$aTextData[0]->text_name,
							'textDesc'=>$aTextData[0]->text_desc,
							'textType'=>$aTextData[0]->text_type,
							'textFile'=>$aTextData[0]->file_path,
							'languageIds'=>$aTextData[0]->language_id,
							'albumNameArr'=>$albumNameArr,
							'albumId' => $albumHidden,
							'albumNameStr'=>$albumNameStr,
							'artistNameArr'=>$artistNameArr,
							'artistId' => $artistHidden,
							'artistNameStr'=>$artistNameStr,

							);
			$oCms->view( $view, $data );
			exit;
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
				$data = $oText->doMultiAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'Text',
						'action' => $contentAction,
						'moduleId' => 19,
						'editorId' => $this->user->user_id,
						'content_ids' => $_POST['select_ids']
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('Text', $contentAction, '19', (int)$this->user->user_id, "Texts, Ids: '".implode("','", $_POST['select_ids'])."' " );
				$aLogParam = array(
					'moduleName' => 'Text',
					'action' => $contentAction,
					'moduleId' => 19,
					'editorId' => $this->user->user_id,
					'remark'	=> ucfirst($contentAction) ." text.",
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

			if($contentModel=='text' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oText->doAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'Text',
						'action' => $contentAction,
						'moduleId' => 19,
						'editorId' => $this->user->user_id,
						'content_ids' => $contentId
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('Text', $contentAction, '19', (int)$this->user->user_id, "Texts, Id: ".$contentId."" );
				$aLogParam = array(
					'moduleName' => 'Text',
					'action' => $contentAction,
					'moduleId' => 19,
					'editorId' => $this->user->user_id,
					'remark'	=> ucfirst($contentAction) ." text. (ID-".$contentId.")",
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
	
	
	$lisData = getlist( $oText ,$this);
	$data['qcPendingTotal']	 = $lisData['qcPendingTotal'];
	$data['legalPendingTotal']	 = $lisData['legalPendingTotal'];	
	$data['publishPendingTotal']	 = $lisData['publishPendingTotal'];		
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
	$data['text_type']  = TOOLS::getTextTypes();
	
	
	
}

function getlist( $oText ,$users=NULL){
	global $oMysqli;
	/* Search Param start */
	$srcText = cms::sanitizeVariable( $_GET['srcText'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcTxtType	 = (int)$_GET['srcTxtType'];
	$languageIds	 = (int)$_GET['languageIds'];
	$where		 = '';
	if( $srcText != '' ){
		$where .= ' AND text_name like "'.$oMysqli->secure($srcText).'%"';
	}
	if( $languageIds != '' ){
		$where .= ' AND language_id='.$oMysqli->secure($languageIds);
	}

	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	if( $srcTxtType>0 ){ $where .= ' AND text_type&'.$srcTxtType.' ='.$srcTxtType.' '; }
	$data['aSearch']['srcText'] 	= $srcText;
	$data['aSearch']['srcCType'] 	= $srcCType;
	$data['aSearch']['srcTxtType'] 	= $srcTxtType;
	
	$data['aSearch']['languageIds'] = $languageIds;
	/* Search Param end */
	if($_GET['do']=="qclist" && $users->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
		$where=" AND status=0";
	}
	if($_GET['do']=="legallist" && $users->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		$where=" AND status=2";
	}
	if($_GET['do']=="publishlist" && $users->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
		$where=" AND status=3";
	}	
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
		$qcparams=array("where" =>" AND status=0");
		$qcPendingTotal=$oText->getTotalCount( $qcparams );
		$data['qcPendingTotal'] 	= $qcPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		$qcparams=array("where" =>" AND status=2");
		$legalPendingTotal=$oText->getTotalCount( $qcparams );
		$data['legalPendingTotal'] 	= $legalPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
		$qcparams=array("where" =>" AND status=3");
		$publishPendingTotal=$oText->getTotalCount( $qcparams );
		$data['publishPendingTotal'] 	= $publishPendingTotal;
	}
	/* Show Text as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => 'ORDER BY insert_date DESC',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oText->getAllTexts( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oText->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "Text?action=view&srcText=$srcText&srcCType=$srcCType&srcTxtType=$srcTxtType&do=".$_GET['do']."&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */

	/* Show Text as List End */
	
	return $data;
}

/* render view */
$oCms->view( $view, $data );