<?php 
error_reporting(0);
$view = 'image_list';
$oImage = new image();
$oTags = new tags();
$do = cms::sanitizeVariable( $_GET['do'] );
$action = cms::sanitizeVariable( $_GET['action'] );
$id = (int)$_GET['id'];

$tagParam = array(
		'where' => " AND parent_tag_id= '1903'" // This is for Image Category Only[Parent ID => 1903 in Tag Master Table].	
	);
$imageCategory = $oTags->getAllTags( $tagParam );

if( $action == 'add' || $action == 'edit' ){
	/* Form */
	$view = 'image_form';
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		
		$imageName	    =	cms::sanitizeVariable($_POST['imageName']);
		$imageDesc	    =	cms::sanitizeVariable($_POST['imageDesc']);
		$imageType		=   (int)$_POST['imageType'];
		$imageCategory	=   (int)$_POST['imageCategory'];
				
		$status			=	cms::sanitizeVariable($_POST['status']);
		
		$artistHidden   = trim($_POST['artistHidden'],",");
		$albumHidden   = trim($_POST['albumHidden'],",");
		$songHidden     = trim($_POST['songHidden'],",");
		
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
		$songHiddenArr=array();
		if($songHidden){
			$songHiddenArr=explode(",",$songHidden);
		}
		$songHiddensData = explode('|',trim($_POST['songHiddensData'],"|"));
		$songNameArr=array();
		if($songHiddensData){
			foreach($songHiddensData as $songHiddensData){
				$songNameData = explode(":",$songHiddensData);
				if($songNameData[0] && in_array($songNameData[0],$songHiddenArr)){
					$songNameArr[$songNameData[0]]=$songNameData[1];
									
				}
			}
		}
		
		if( empty($albumHiddenArr) ){
			$aError[]="Select Album.";
		}
		if($imageName==""){
			$aError[]="Enter Image Name.";
		}
		if($imageType==""){
			$aError[]="Please Select Image Type.";
		}
		if($imageCategory==""){
			$aError[]="Please Select Image Category.";
		}

		$picname ="";
		
		if(sizeof($_FILES)>0 && !empty($_FILES) && $_FILES["pic"]["name"]!=""){
			$ret = TOOLS::saveImage($_FILES['pic']);
			
			$picname =	$ret['image'];	
		}else{
			$picname = cms::sanitizeVariable($_POST['oPic']);
		}
				
		$params = array(
					'imageName' 	=> $imageName, 
					'imageDesc' 	=> $imageDesc, 
					'imageType' 	=> $imageType, 
					'imageCategory' => $imageCategory,
					'imageFile'		=> $picname,
					'status' 		=> $status, 
					'albumNameArr'	=> $albumNameArr,
					'albumId'		=> $albumHidden,
					'albumNameStr'	=> $_POST['albumHiddensData'],
					'artistNameArr'	=> $artistNameArr,
					'artistId'		=> $artistHidden,
					'artistNameStr'	=> $_POST['artistHiddensData'],
					'songNameArr'	=>$songNameArr,
					'songId' 		=> $songHidden,
					'songNameStr'	=>$_POST['songHiddensData'],

				  );
			  
		if(empty($aError)){
			
			$aData = $oImage->saveImage( $params );
			$logMsg="Created image.";
			if($id){
				$aData=$id;
				$logMsg="Edited image information.";
			}
			if($aData){
				if($artistHiddenArr){ 
					$oData=$oImage->mapArtistImage(array('imageId'=>(int)$aData,'artistIds'=>$artistHiddenArr));					
				}
				
				if($albumHiddenArr){
					$lData=$oImage->mapAlbumImage(array('imageId'=>(int)$aData,'albumIds'=>$albumHiddenArr));
				}
				
				if($songHiddenArr){
					$sData=$oImage->mapSongImage(array('imageId'=>(int)$aData,'songIds'=>$songHiddenArr));
				}	
				
			}
			
			/* Send Mail Notification start*/
			if($action == 'add'){
				$oMailParam = array(
						'moduleName' => 'image',
						'action' => $action,
						'moduleId' => 17,
						'editorId' => $this->user->user_id,
						'content_ids' => $aData
					);
				$oNotification->sendNotification( $oMailParam );
				
			}
			/* Send Mail Notification end*/
			
			/* Write DB Activity Logs */
			#TOOLS::log('Image', $action, '17', (int)$this->user->user_id, "Images, Id: ".$id."" );
			$aLogParam = array(
					'moduleName' => 'image',
					'action' => $action,
					'moduleId' => 17,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($logMsg).' (ID-'.$aData.')',
					'content_ids' => $aData
				);
			TOOLS::writeActivityLog( $aLogParam );
			$data['aSuccess'] = 'Data saved successfully.';
			header('location:'.SITEPATH.'image?msg=Data saved successfully');			
		}else{
			$data['aError'] = $aError;
		}
		$data['aContent'] = $params;
		
	}else if($action == 'edit'){
		/* Get Image Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'status' => $status, 
					'where' => " AND image_id= '".$id."'"
				  ); 
		$aImageData = $oImage->getAllImages( $params ); 
				
		$artistImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=13 AND image_id=".$id));
		
		$artistHiddenArr=array();
		
		if( !empty($artistImageMapData) ){
			foreach($artistImageMapData as $artist){
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
		
		$albumImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=14 AND image_id=".$id));
		
		$albumHiddenArr=array();
		if($albumImageMapData){
			foreach($albumImageMapData as $album){
				$albumHiddenArr[]=$album->content_id;
			}
		}
		
		$songImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=4 AND image_id=".$id));
		
		$songHiddenArr=array();
		if($songImageMapData){
			foreach($songImageMapData as $songD){
				$songHiddenArr[]=$songD->content_id;
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
		
		$songHidden="";
		if($songHiddenArr){
			$songHidden=implode(",",$songHiddenArr);
		}
		$mSong=new song();
		$songHiddenIn="0";
		if($songHidden){
			$songHiddenIn=$songHidden;
		}
		
		$songNameArr=array();
		$songNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY song_name ASC',  
				'start'   => 0,  
				'where'   => " AND song_id IN (".$songHiddenIn.")",
		   );
		$songData=$mSong->getAllSongs($bParams);
		
		if($songData){
			foreach($songData as $sD){
				$songNameStr.=$sD->song_id.":".$sD->song_name."|";
				$songHiddenArr[]=$sD->song_id;
				$songNameArr[$sD->song_id]=$sD->song_name;
			}	
		}
		
		$data['aContent'] = array(
								'imageName'=>$aImageData[0]->image_name,
								'imageDesc'=>$aImageData[0]->image_desc,
								'imageType'=>$aImageData[0]->image_type,
								'imageCategory'=>$aImageData[0]->image_tag_id,
								'imageFile'=>$aImageData[0]->image_file,
								'status'=>$aImageData[0]->status,
								'albumNameArr'=>$albumNameArr,
								'albumId' => $albumHidden,
								'albumNameStr'=>$albumNameStr,
								'artistNameArr'=>$artistNameArr,
								'artistId' => $artistHidden,
								'artistNameStr'=>$artistNameStr,
								'songNameArr'=>$songNameArr,
								'songId' => $songHidden,
								'songNameStr'=>$songNameStr,
							);
		
	}
	$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
	$data['image_type'] 	= TOOLS::getImageTypes();
	$data['imageCategory'] 	= $imageCategory;
	

}else{

/*
	* To display rights popup start	
	*/
	if($do=='rights'){
	
		$view = 'image_rights';
		if(!empty($_POST) && isset($_POST)){
		
		    $territory_arr = array();
			$territory_ex_arr = array();
			
			$imageRightId = cms::sanitizeVariable( $_POST['imageRightId'] );
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
					'imageRightId'=>$imageRightId,
					'imageId'=>$id,
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
				$mData=$oImage->addImageRights($postData);
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
									'moduleName' => 'image rights',
									'action' => $action,
									'moduleId' => 17,
									'editorId' => $this->user->user_id,
									'remark'	=>	'Edited Image rights information. (ID-'.$id.')',
									'content_ids' => (int)$id
								);
				TOOLS::writeActivityLog( $aLogParam );
								
				//TOOLS::log('image rights', $action, '17', $this->user->user_id, "Image, Id: ".(int)$mData."" );
				//header("location:".$refferer."&msg=Action completed successfully.");
			}
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;			
			
		}else {
		
			$params=array(
					'where' => " AND image_id=".$id,
					);
					
			
			$dataRightsByImageId=$oImage->getRightsByImageId($params);
			$publishingRights = $dataRightsByImageId[0]->publishing_rights;
			$digitalRights = $dataRightsByImageId[0]->digital_rights;

			
			
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
			
		
			if($dataRightsByImageId){
				$edtData=array(
					
						'imageId'=>$dataRightsByImageId[0]->image_id,
						'is_owned'=>$dataRightsByImageId[0]->is_owned,
						'banner_id'=>$dataRightsByImageId[0]->banner_id,
						'territory_in'=>$dataRightsByImageId[0]->territory_in,
						'territory_ex'=>$dataRightsByImageId[0]->territory_ex,
						'start_date'=>$dataRightsByImageId[0]->start_date,
						'end_date'=>$dataRightsByImageId[0]->expiry_date,
						'physical_rights'=>$dataRightsByImageId[0]->physical_rights,
						'publishing_rights'=>$pubRightStr,
						'digital_rights'=>$digiRightStr,
						'is_exclusive'=>$dataRightsByImageId[0]->is_exclusive,
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
	
	if( $do == 'details' ){
		$view = 'image_details';
		/* Get Image Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'where' => " AND image_id= '".$id."'"
				  ); 
		$aImageData = $oImage->getAllImages( $params ); 
				
		$artistImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=13 AND image_id=".$id));
		
		$artistHiddenArr=array();
		
		if( !empty($artistImageMapData) ){
			foreach($artistImageMapData as $artist){
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
		
		$albumImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=14 AND image_id=".$id));
		
		$albumHiddenArr=array();
		if($albumImageMapData){
			foreach($albumImageMapData as $album){
				$albumHiddenArr[]=$album->content_id;
			}
		}
		
		$songImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=4 AND image_id=".$id));
		
		$songHiddenArr=array();
		if($songImageMapData){
			foreach($songImageMapData as $songD){
				$songHiddenArr[]=$songD->content_id;
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
		
		$songHidden="";
		if($songHiddenArr){
			$songHidden=implode(",",$songHiddenArr);
		}
		$mSong=new song();
		$songHiddenIn="0";
		if($songHidden){
			$songHiddenIn=$songHidden;
		}
		
		$songNameArr=array();
		$songNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY song_name ASC',  
				'start'   => 0,  
				'where'   => " AND song_id IN (".$songHiddenIn.")",
		   );
		$songData=$mSong->getAllSongs($bParams);
		
		if($songData){
			foreach($songData as $sD){
				$songNameStr.=$sD->song_id.":".$sD->song_name."|";
				$songHiddenArr[]=$sD->song_id;
				$songNameArr[$sD->song_id]=$sD->song_name;
			}	
		}
		
		$data['aContent'] = array(
								'imageId'=>$aImageData[0]->image_id,
								'imageName'=>$aImageData[0]->image_name,
								'imageDesc'=>$aImageData[0]->image_desc,
								'imageType'=>$aImageData[0]->image_type,
								'imageCategory'=>$aImageData[0]->image_tag_id,
								'imageFile'=>$aImageData[0]->image_file,
								'status'=>$aImageData[0]->status,
								'albumNameArr'=>$albumNameArr,
								'albumId' => $albumHidden,
								'albumNameStr'=>$albumNameStr,
								'artistNameArr'=>$artistNameArr,
								'artistId' => $artistHidden,
								'artistNameStr'=>$artistNameStr,
								'songNameArr'=>$songNameArr,
								'songId' => $songHidden,
								'songNameStr'=>$songNameStr,
							);
							
		$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
		$data['image_type'] 	= TOOLS::getImageTypes();
		$data['imageCategory'] 	= $imageCategory;
		/* render view */
		$oCms->view( $view, $data );
		exit;
		
	}else if( $do == 'showedits' ){
		/* List all available Edits for this image start */
		$view = 'image_edits';
		$lisData = $oImage->getImageEdits( $id );

		$data['aContent']	 	 = $lisData;
		$data['aEditConfig']	 = $oImage->getImageEditsConfig();
			
		/* render view */
		$oCms->view( $view, $data );
		exit;
		/* List all available Edits for this image end */
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
				$data = $oImage->doMultiAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'image',
						'action' => $contentAction,
						'moduleId' => 17,
						'editorId' => $this->user->user_id,
						'content_ids' => $_POST['select_ids']
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('Image', $contentAction, '17', (int)$this->user->user_id, "Images, Ids: '".implode("','", $_POST['select_ids'])."' " );
				$aLogParam = array(
					'moduleName' => 'image',
					'action' => $contentAction,
					'moduleId' => 17,
					'editorId' => $this->user->user_id,
					'remark'	=> ucfirst($contentAction) ." image.",
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

			if($contentModel=='image' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oImage->doAction( $params );
								
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'image',
						'action' => $contentAction,
						'moduleId' => 17,
						'editorId' => $this->user->user_id,
						'content_ids' => $contentId
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('Image', $contentAction, '17', (int)$this->user->user_id, "Images, Id: ".$contentId."" );
				$aLogParam = array(
					'moduleName' => 'image',
					'action' => $contentAction,
					'moduleId' => 17,
					'editorId' => $this->user->user_id,
					'remark'	=> ucfirst($contentAction) ." image. (ID-".$contentId.")",
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

	
	$lisData = getlist( $oImage,$this);
	$data['qcPendingTotal']	 = $lisData['qcPendingTotal'];
	$data['legalPendingTotal']	 = $lisData['legalPendingTotal'];	
	$data['publishPendingTotal']	 = $lisData['publishPendingTotal'];		
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
	$data['image_type']  = TOOLS::getImageTypes();
	$data['imageCategory']  = $imageCategory;
}

function getlist( $oImage ,$users=NULL ){
	global $oMysqli;
	/* Search Param start */
	$srcImage = cms::sanitizeVariable( $_GET['srcImage'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcImgType	 = (int)$_GET['srcImgType'];
	$srcImageCategory	 = (int)$_GET['srcImageCategory'];
	$where		 = '';
	if( $srcImage != '' ){
		$where .= ' AND image_name like "'.$oMysqli->secure($srcImage).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	if( $srcImageCategory != '' ){
		$where .= ' AND image_tag_id ="'.$srcImageCategory.'" ';
	}

	if( $srcImgType>0 ){ $where .= ' AND image_type&'.$srcImgType.' ='.$srcImgType.' '; }
	$data['aSearch']['srcImage'] 	= $srcImage;
	$data['aSearch']['srcCType'] 	= $srcCType;
	$data['aSearch']['srcImgType'] 	= $srcImgType;
	$data['aSearch']['srcImageCategory'] 	= $srcImageCategory;
	/* Search Param end */
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
		$qcPendingTotal=$oImage->getTotalCount( $qcparams );
		$data['qcPendingTotal'] 	= $qcPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		$qcparams=array("where" =>" AND status=2");
		$legalPendingTotal=$oImage->getTotalCount( $qcparams );
		$data['legalPendingTotal'] 	= $legalPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
		$qcparams=array("where" =>" AND status=3");
		$publishPendingTotal=$oImage->getTotalCount( $qcparams );
		$data['publishPendingTotal'] 	= $publishPendingTotal;
	}
	/* Show Image as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => 'ORDER BY image_id DESC',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oImage->getAllImages( $params );
	
	#echo $oImage;
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oImage->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "image?action=view&srcImage=$srcImage&srcCType=$srcCType&srcImgType=$srcImgType&do=".$_GET['do']."&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */

	/* Show Image as List End */
	
	return $data;
}

/* render view */
$oCms->view( $view, $data );