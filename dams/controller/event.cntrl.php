<?php 
$view = 'event_list';
$oEvent = new event();
global $aConfig;

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
$do		= cms::sanitizeVariable( $_GET['do'] );

if( $action == 'add' || $action == 'edit' ){
	/* Form */
	$view = 'event_form';
	$id = (int)$_GET['id'];
	

	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		
		$eventName	 = cms::sanitizeVariable($_POST['eventName']);
		$eventDesc	 = trim($_POST['eventDesc']);
		$languageIds = cms::sanitizeVariable($_POST['languageIds']);
		$eventType   = cms::sanitizeVariable($_POST['eventType']);
		$srcSrtDate  = cms::sanitizeVariable($_POST['srcSrtDate']);
		$srcEndDate  = cms::sanitizeVariable($_POST['srcEndDate']);
 		
		$artistHidden = trim($_POST['artistHidden'],",");
		
		$artistHiddenArr=array();
		if($artistHidden){
			$artistHiddenArr=explode(",",$artistHidden); //ARTIST
		}


//ARTIST
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
//PLAYLIST		
		$playlistHidden = trim($_POST['playlistHidden'],",");
		
		$playlistHiddenArr=array();
		if($playlistHidden){
			$playlistHiddenArr=explode(",",$playlistHidden); //ARTIST
		}



		$playlistHiddensData = explode('|',trim($_POST['playlistHiddensData'],"|"));
		$playlistNameArr=array();
		if($playlistHiddensData){
			foreach($playlistHiddensData as $playlistHiddensData){
				$playlistNameData = explode(":",$playlistHiddensData);
				if($playlistNameData[0] && in_array($playlistNameData[0],$playlistHiddenArr)){
					$playlistNameArr[$playlistNameData[0]]=$playlistNameData[1];
				}
			}
		}
//VIDEOPLAYLIST		
		$videoplaylistHidden = trim($_POST['videoplaylistHidden'],",");
		
		$videoplaylistHiddenArr=array();
		if($videoplaylistHidden){
			$videoplaylistHiddenArr=explode(",",$videoplaylistHidden); //ARTIST
		}



		$videoplaylistHiddensData = explode('|',trim($_POST['videoplaylistHiddensData'],"|"));
		$videoplaylistNameArr=array();
		if($videoplaylistHiddensData){
			foreach($videoplaylistHiddensData as $videoplaylistHiddensData){
				$videoplaylistNameData = explode(":",$videoplaylistHiddensData);
				if($videoplaylistNameData[0] && in_array($videoplaylistNameData[0],$videoplaylistHiddenArr)){
					$videoplaylistNameArr[$videoplaylistNameData[0]]=$videoplaylistNameData[1];
									
				}
			}
		}
//IMAGEPLAYLIST		
		$imageplaylistHidden = trim($_POST['imageplaylistHidden'],",");
		
		$imageplaylistHiddenArr=array();
		if($imageplaylistHidden){
			$imageplaylistHiddenArr=explode(",",$imageplaylistHidden); //ARTIST
		}

		$imageplaylistHiddensData = explode('|',trim($_POST['imageplaylistHiddensData'],"|"));
		$imageplaylistNameArr=array();
		if($imageplaylistHiddensData){
			foreach($imageplaylistHiddensData as $imageplaylistHiddensData){
				$imageplaylistNameData = explode(":",$imageplaylistHiddensData);
				if($imageplaylistNameData[0] && in_array($imageplaylistNameData[0],$imageplaylistHiddenArr)){
					$imageplaylistNameArr[$imageplaylistNameData[0]]=$imageplaylistNameData[1];
									
				}
			}
		}

######################ERROR CHECKING##############################	
		if($eventName==""){
			$aError[]="Enter Event Name.";
		}
		if($eventType=="0"){
			$aError[]="Select Event Type.";
		}
		if($srcSrtDate==""){
			$aError[]="Select Event Start Date.";
		}

		$params = array(
					'eventName'  => $eventName,  
					'eventDesc'  => $eventDesc,
					'languageIds' => $languageIds,
					'eventType'  => $eventType,
					'srcSrtDate' => $srcSrtDate, 
					'srcEndDate' => $srcEndDate,
					'artistNameArr'=>$artistNameArr,
					'artistId' => $artistHidden,
					'artistNameStr'=>$_POST['artistHiddensData'],
					'playlistNameArr'=>$playlistNameArr,
					'playlistId' => $playlistHidden,
					'playlistNameStr'=>$_POST['playlistHiddensData'],
					'videoplaylistNameArr'=>$videoplaylistNameArr,
					'videoplaylistId' => $videoplaylistHidden,
					'videoplaylistNameStr'=>$_POST['videoplaylistHiddensData'],
					'imageplaylistNameArr'=>$imageplaylistNameArr,
					'imageplaylistId' => $imageplaylistHidden,
					'imageplaylistNameStr'=>$_POST['imageplaylistHiddensData'],
				  );
		
			if(empty($aError)){				
				$aData = $oEvent->saveEvent( $params );
				$logMsg="Created event.";
				if($id){
					$aData=$id;
					$logMsg="Edited event information.";
				}
				if($artistHidden){
					$atData =  $oEvent->mapArtistEvent(array('eventId'=>(int)$aData,'artistIds'=>$artistHiddenArr));
				}
				$fullArray=array_merge((array)$playlistHiddenArr,(array)$videoplaylistHiddenArr,(array)$imageplaylistHiddenArr);
				if($fullArray){
					$plData =  $oEvent->mapPlaylistEvent(array('eventId'=>(int)$aData,'playlistIds'=>$fullArray));
				}
			/* Write DB Activity Logs */
			#TOOLS::log('Event', $action, '20', (int)$this->user->user_id, "Event, Id: ".$id."" );
			$aLogParam = array(
								'moduleName' => 'event',
								'action' => $action,
								'moduleId' => 20,
								'editorId' => $this->user->user_id,
								'remark'	=>	$logMsg.' (ID-'.$aData.')',
								'content_ids' => (int)$aData
							);
			TOOLS::writeActivityLog( $aLogParam );

			$data['aSuccess'] = 'Data saved successfully.';
			header('location:'.SITEPATH.'event?msg=Data saved successfully');			
		
			}else{
				$data['aError'] = $aError;
			}
			$data['aContent'] = $params;
			
		}else if($action == 'edit'){
		
#########################POP Up comes here.############	
	
# Geting All data on Edit.
		$artistHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=13 AND event_id=".$id) );//Artist
		$artistHiddenArr = array();	
		
		if( !empty($artistHiddenMapData) ){		
			foreach($artistHiddenMapData as $artist){
				$artistHiddenArr[] = $artist->content_id;
			
			}
		}

		$artistHidden ='';
		if($artistHiddenArr){
			$artistHidden=implode(",",$artistHiddenArr); //ARTIST
		}
		
		$eArtist = new artist();		
		$artistHiddenIn	= "0";		

		if($artistHidden){
			$artistHiddenIn=$artistHidden;
		}
		$artistNameArr=array();
		$artistNameStr="";


##ARTIST
		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$artistHiddenIn.")",
		   );
		   
		$artistData=$eArtist->getAllArtists($eParams);
		
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}

		$playlistHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=29 AND event_id=".$id) );//Artist
		$playlistHiddenArr = array();	
		
		if( !empty($playlistHiddenMapData) ){		
			foreach($playlistHiddenMapData as $playlist){
				$playlistHiddenArr[] = $playlist->content_id;
			}
		}

		$playlistHidden ='';
		if($playlistHiddenArr){
			$playlistHidden=implode(",",$playlistHiddenArr); //ARTIST
		}
		
		$ePlaylist = new playlist();		
		$playlistHiddenIn	= "0";		

		if($playlistHidden){
			$playlistHiddenIn=$playlistHidden;
		}

##PLAYLIST
		$playlistNameArr=array();
		$playlistNameStr="";

		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY playlist_name ASC',  
				'start'   => 0,  
				'where'   => " AND content_type=4 AND playlist_id IN (".$playlistHiddenIn.")",
		   );
		   
		$playlistData=$ePlaylist->getAllPlaylists($eParams);
		if($playlistData){
			$playlistHiddenArr=array();
			foreach($playlistData as $aD){
				$playlistNameStr.=$aD->playlist_id.":".$aD->playlist_name."|";
				$playlistHiddenArr[]=$aD->playlist_id;
				$playlistNameArr[$aD->playlist_id]=$aD->playlist_name;
			}
			$playlistHidden=implode(",",$playlistHiddenArr);		
		}
##VIDEOPLAYLIST		
		$videoplaylistNameArr=array();
		$videoplaylistNameStr="";

		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY playlist_name ASC',  
				'start'   => 0,  
				'where'   => " AND content_type=15 AND playlist_id IN (".$playlistHiddenIn.")",
		   );
		   
		$videoplaylistData=$ePlaylist->getAllPlaylists($eParams);
		
		if($videoplaylistData){
			foreach($videoplaylistData as $aD){
				$videoplaylistNameStr.=$aD->playlist_id.":".$aD->playlist_name."|";
				$videoplaylistHiddenArr[]=$aD->playlist_id;
				$videoplaylistNameArr[$aD->playlist_id]=$aD->playlist_name;
			}
			$videoplaylistHidden=implode(",",$videoplaylistHiddenArr);	
		}
##IMAGEPLAYLIST		
		$imageplaylistNameArr=array();
		$imageplaylistNameStr="";

		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY playlist_name ASC',  
				'start'   => 0,  
				'where'   => " AND content_type=17 AND playlist_id IN (".$playlistHiddenIn.")",
		   );
		   
		$imageplaylistData=$ePlaylist->getAllPlaylists($eParams);
		
		if($imageplaylistData){
			foreach($imageplaylistData as $aD){
				$imageplaylistNameStr.=$aD->playlist_id.":".$aD->playlist_name."|";
				$imageplaylistHiddenArr[]=$aD->playlist_id;
				$imageplaylistNameArr[$aD->playlist_id]=$aD->playlist_name;
			}
			$imageplaylistHidden=implode(",",$imageplaylistHiddenArr);	
		}

# Geting All data on Edit END.

/* Get Full Mstr Event Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'status' => $status, 
					'where' => " AND event_id= '".$id."'"
				  ); 
				  
		$aEventData = $oEvent->getAllEvents( $params ); 
		$data['aContent'] = array(
								'event_id'=>$aEventData[0]->event_id,
								'eventName'=>$aEventData[0]->event_name,
								'eventDesc'=>$aEventData[0]->event_desc,
								'eventType'=>$aEventData[0]->event_type,
								'srcSrtDate' =>$aEventData[0]->start_date,
								'srcEndDate' =>$aEventData[0]->end_date,
								'languageIds' =>$aEventData[0]->language_id,
								'artistNameArr'=>$artistNameArr,
								'artistId' => $artistHidden,
								'artistNameStr'=>$artistNameStr,
								'playlistNameArr'=>$playlistNameArr,
								'playlistId' => $playlistHidden,
								'playlistNameStr'=>$playlistNameStr,
								'videoplaylistNameArr'=>$videoplaylistNameArr,
								'videoplaylistId' => $videoplaylistHidden,
								'videoplaylistNameStr'=>$videoplaylistNameStr,
								'imageplaylistNameArr'=>$imageplaylistNameArr,
								'imageplaylistId' => $imageplaylistHidden,
								'imageplaylistNameStr'=>$imageplaylistNameStr,							
							);

	}
/* Get Full Mstr Event Data END */	
	
	$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
	$data['calendar_event']	= TOOLS::getEventsTypes();
	
}else{
		if($do=='details'){
			$id = (int)$_GET['id'];
			$view = 'event_details';

		# Geting All data on Edit.
		$artistHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=13 AND event_id=".$id) );//Artist
		$artistHiddenArr = array();	
		
		if( !empty($artistHiddenMapData) ){		
			foreach($artistHiddenMapData as $artist){
				$artistHiddenArr[] = $artist->content_id;
			
			}
		}

		$artistHidden ='';
		if($artistHiddenArr){
			$artistHidden=implode(",",$artistHiddenArr); //ARTIST
		}
		
		$eArtist = new artist();		
		$artistHiddenIn	= "0";		

		if($artistHidden){
			$artistHiddenIn=$artistHidden;
		}
		$artistNameArr=array();
		$artistNameStr="";

##ARTIST
		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$artistHiddenIn.")",
		   );
		   
		$artistData=$eArtist->getAllArtists($eParams);
		
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}
##SONG PLAYLIST
		$playlistHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=29 AND event_id=".$id) );//Artist
		$playlistHiddenArr = array();	
		
		if( !empty($playlistHiddenMapData) ){		
			foreach($playlistHiddenMapData as $playlist){
				$playlistHiddenArr[] = $playlist->content_id;
			}
		}

		$playlistHidden ='';
		if($playlistHiddenArr){
			$playlistHidden=implode(",",$playlistHiddenArr); //ARTIST
		}
		
		$ePlaylist = new playlist();		
		$playlistHiddenIn	= "0";		

		if($playlistHidden){
			$playlistHiddenIn=$playlistHidden;
		}
		$playlistNameArr=array();
		$playlistNameStr="";

		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY playlist_name ASC',  
				'start'   => 0,  
				'where'   => " AND content_type=4 AND playlist_id IN (".$playlistHiddenIn.")",
		   );
		   
		$playlistData=$ePlaylist->getAllPlaylists($eParams);
		
		if($playlistData){
			foreach($playlistData as $aD){
				$playlistNameStr.=$aD->playlist_id.":".$aD->playlist_name."|";
				$playlistHiddenArr[]=$aD->playlist_id;
				$playlistNameArr[$aD->playlist_id]=$aD->playlist_name;
			}	
		}

		$videoplaylistNameArr=array();
		$videoplaylistNameStr="";

		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY playlist_name ASC',  
				'start'   => 0,  
				'where'   => " AND content_type=15 AND playlist_id IN (".$playlistHiddenIn.")",
		   );
		   
		$videoplaylistData=$ePlaylist->getAllPlaylists($eParams);
		
		if($videoplaylistData){
			foreach($videoplaylistData as $aD){
				$videoplaylistNameStr.=$aD->playlist_id.":".$aD->playlist_name."|";
				$videoplaylistHiddenArr[]=$aD->playlist_id;
				$videoplaylistNameArr[$aD->playlist_id]=$aD->playlist_name;
			}	
		}
		
		$imageplaylistNameArr=array();
		$imageplaylistNameStr="";

		$eParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY playlist_name ASC',  
				'start'   => 0,  
				'where'   => " AND content_type=15 AND playlist_id IN (".$playlistHiddenIn.")",
		   );
		   
		$imageplaylistData=$ePlaylist->getAllPlaylists($eParams);
		
		if($imageplaylistData){
			foreach($imageplaylistData as $aD){
				$imageplaylistNameStr.=$aD->playlist_id.":".$aD->playlist_name."|";
				$imageplaylistHiddenArr[]=$aD->playlist_id;
				$imageplaylistNameArr[$aD->playlist_id]=$aD->playlist_name;
			}	
		}

# Geting All data on Edit END.

		$params = array(
					'start' => 0,
					'limit' => 1,
					'status' => $status,
					'where' => " AND event_id= '".$id."'"
			  );

		$aEventData = $oEvent->getAllEvents( $params );

		$data['aContent'] = array(
							'eventName'=>$aEventData[0]->event_name,
							'eventDesc'=>$aEventData[0]->event_desc,
							'eventType'=>$aEventData[0]->event_type,
							'languageIds'=>$aEventData[0]->language_id,
							'srcSrtDate' =>$aEventData[0]->start_date,
							'srcEndDate' =>$aEventData[0]->end_date,
							'artistNameArr'=>$artistNameArr,
							'artistId' => $artistHidden,
							'artistNameStr'=>$artistNameStr,
							'playlistNameArr'=>$playlistNameArr,
							'playlistId' => $playlistHidden,
							'playlistNameStr'=>$playlistNameStr,
							'videoplaylistNameArr'=>$videoplaylistNameArr,
							'videoplaylistId' => $playlistHidden,
							'videoplaylistNameStr'=>$videoplaylistNameStr,							
							'imageplaylistNameArr'=>$imageplaylistNameArr,
							'imageplaylistId' => $playlistHidden,
							'imageplaylistNameStr'=>$imageplaylistNameStr,							
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
				$data = $oEvent->doMultiAction( $params );
				/* Write DB Activity Logs */
				#TOOLS::log('Text', $contentAction, '20', (int)$this->user->user_id, "Events, Ids: '".implode("','", $_POST['select_ids'])."' " );
				$aLogParam = array(
					'moduleName' => 'event',
					'action' => $contentAction,
					'moduleId' => 29,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' event. (ID-'.implode("','", $_POST['select_ids']).')',
					'content_ids' => $contentId,
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

			if($contentModel=='event' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oEvent->doAction( $params );
								
				/* Write DB Activity Logs */
				#TOOLS::log('Event', $contentAction, '20', (int)$this->user->user_id, "Events, Id: ".$contentId."" );
				$aLogParam = array(
					'moduleName' => 'event',
					'action' => $contentAction,
					'moduleId' => 29,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' event. (ID-'.$contentId.')',
					'content_ids' => $contentId,
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
	
	$lisData = getlist( $oEvent );
	
//	print_r($oEvent);
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['aSearch']	 = $lisData['aSearch'];
	$data['calendar_event']  = TOOLS::getEventsTypes();
	
}

function getlist( $oEvent ){
	global $oMysqli;
	/* Search Param start */
	$srcText	 = cms::sanitizeVariable( $_GET['srcText'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcTxtType	 = (int)$_GET['srcTxtType'];
	$srcSrtDate  = cms::sanitizeVariable( $_GET['srcSrtDate'] );
	$srcEndDate  = cms::sanitizeVariable( $_GET['srcEndDate'] );
	$languageIds	 = (int)$_GET['languageIds'];
	$srcArtist	 = cms::sanitizeVariable( $_GET['srcArtist'] );
	$autosuggestartist_hddn = cms::sanitizeVariable( $_GET['autosuggestartist_hddn'] );

	$where = '';
	
	if($srcArtist!='' && $autosuggestartist_hddn!=''){
		
		 $aparam = array("where"=>" AND content_id=".$autosuggestartist_hddn);
		 $getAllArtistIds  = $oEvent->getAllEventMap($aparam);
		 
		
		if($getAllArtistIds){
			$artistIdArr = array(); 
		 foreach($getAllArtistIds as $ArtistIdVal){
			 $artistIdArr[] = $ArtistIdVal->event_id;
		 }
		 
		 if(!empty($artistIdArr)){
		  	$ArtistIds = implode(",",$artistIdArr);
			  $where .= " AND event_id IN($ArtistIds)";
		  }
		  
		  }else{			  
			  $where .= " AND event_id =0";
		  }
	}
	
	if( $srcText != '' ){
		$where .= ' AND event_name like "'.$oMysqli->secure($srcText).'%"';
	}
	if( $languageIds != '' ){
		$where .= ' AND language_id='.$oMysqli->secure($languageIds);
	}
	if( $srcSrtDate != '' && $srcEndDate != ''  ){
		$where .= ' AND start_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcEndDate).'"';
	}elseif($srcSrtDate != ''){
		$where .= ' AND start_date = "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcEndDate != ''){
		$where .= ' AND end_date = "'.$oMysqli->secure($srcEndDate).'"';
	}
	
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	
	
	if( $srcTxtType>0 ){ $where .= ' AND event_type&'.$srcTxtType.' ='.$srcTxtType.' '; }
	
	//echo $where;
	
	$data['aSearch']['srcText'] 	= $srcText;
	$data['aSearch']['srcCType'] 	= $srcCType;
	$data['aSearch']['srcTxtType'] 	= $srcTxtType;
	$data['aSearch']['srcSrtDate']  = $srcSrtDate;
	$data['aSearch']['srcEndDate']  = $srcEndDate;
	$data['aSearch']['languageIds'] = $languageIds;
	$data['aSearch']['srcArtist'] 	= $srcArtist;
	$data['aSearch']['autosuggestartist_hddn'] 	= $autosuggestartist_hddn;

	/* Search Param end */
	
	/* Show Event as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => 'ORDER BY insert_date DESC',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oEvent->getAllEvents( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oEvent->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "event?action=view&srcText=$srcText&languageIds=$languageIds&srcCType=$srcCType&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcTxtType=$srcTxtType&srcSrtDate=$srcSrtDate&srcEndDate=$srcEndDate&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */

	/* Show Event as List End */
	
	return $data;
}

/* render view */
$oCms->view( $view, $data );