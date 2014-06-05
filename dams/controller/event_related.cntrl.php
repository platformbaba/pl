<?php       
/*
*	$cType - ContentId from where this pop up called.
*	$relatedCType - which related content type to be shown.
*	$id - Contentid
*	For any new related content combination, need to change in config.php
*/
$action = cms::sanitizeVariable( $_REQUEST['action'] );
$action = ($action==''?'view':$action);

$cType 	= ((int)$_REQUEST['cType'] == 0 ? '14':(int)$_REQUEST['cType']);
$Type   = ($_REQUEST['type']=='all') ? 'all' : 'save' ;
$pId 	= (int)$_REQUEST['pId'];
$relatedCType 	= ((int)$_REQUEST['relatedCType'] == 0 ? '4':(int)$_REQUEST['relatedCType']);
$id			= (int)$_REQUEST['id'];
$srcData	= cms::sanitizeVariable( $_POST['srcData'] );
$view = 'event_related_pop';

$postButton = ( (isset($_POST['postButton']) && $_POST['postButton'] !='') ? $_POST['postButton']:'');
$oEvent = new event();
$contentType = $oEvent->getAllEvents(array('where'=> " AND event_id=".$id));
$showHeadArr = array();

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
$data['playlistData'] =$playlistData;
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
$data['videoplaylistData'] =$videoplaylistData;
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
$data['imageplaylistData'] =$imageplaylistData;
## Geting Artist Ids here.
	$artistHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=13 AND event_id=".$id) );//Artist
	$artistHiddenArr = array();	
	
	if( !empty($artistHiddenMapData) ){		
		foreach($artistHiddenMapData as $artist){
			$artistHiddenArr[] = $artist->content_id;
		
		}
	}

	$artistHidden ='';
	if($artistHiddenArr){
		$artistHidden = implode(",",$artistHiddenArr); //ARTIST
		
	}else{
		$artistHidden = 0; // if there are no artist tag with event.
	}
##End

switch( $Type ){
	case 'all':
		/* Artist + Song + Video + Image Contents */
		switch( $relatedCType ){
			case '4':
				
			$oSong = new song();
				if(!empty($_POST) && isset($_POST)){
					
					if( $postButton == 'saveContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'dataIds' => $select_ids, //Song Ids
										'eventId'  => $id,
										'relatedCType'  => $relatedCType,
									);
						if(sizeof($select_ids)>0){
							$mData=$oEvent->mapAllEvent($postData);
							/* Write DB Activity Logs */
							TOOLS::log('Event song', "save", '4', $this->user->user_id, " Saved Songs for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}else if($srcData!=''){
				
					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
					
					$params = array(
								'limit'	  => $limit,  
								'start'   => $start,  
								'where'	  => ' AND song_name LIKE "'.$srcData.'%"' ,
							  );
					$oContentList = $oSong->getAllSongs( $params );
					/* Pagination Start */
					$oPage = new Paging();
					//$oPage->total = count($artistSongMapData);
					$oPage->total =$oSong->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc&srcData=$srcData";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
								/* Pagination End */		
					
					}			
			}## Post data			
				
				/* condition for existing songs in selected content start*/				
				$songHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=".$relatedCType." AND event_id=".$id) );//Song			
##songs				
				$songHiddenArr = array();	
				
				if( !empty($songHiddenMapData) ){		
					foreach($songHiddenMapData as $songs){
						$songHiddenArr[] = $songs->content_id;
					
					}
				}
		
				$songHidden ='';
				$condition = '';
				if($songHiddenArr){
					$songHidden=implode(",",$songHiddenArr); //SONG IDS
					$condition = " AND song_id NOT IN(".$songHidden.")";//existing Songs Id
				}
				/* condition for existing songs in selected content end*/


				/* Artist Song Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Song Name', 'ISRC', 'Insert Date'), 
									  'body'=> array('song_id', 'song_name', 'isrc', 'insert_date'), 
									  'field_id'=>'song_id', 
									  'rank'=>true 
									);			
				$artistSongMapData=$oSong->getArtistSongMap(array('where'=> " AND artist_id IN ($artistHidden)")); //song.model.php
			
				$songArr=array();
				
				if($artistSongMapData){
				
					foreach($artistSongMapData as $song){
						$songArr[]=$song->song_id;
						
					}
				}
				
				if($songArr && $srcData==''){ //Geting default songs start.
					 $songIdStr = implode(",",$songArr);
					
					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
			
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(song_id,".$songIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND song_id IN(".$songIdStr.") ".$condition ,
							  );
					$oContentList = $oSong->getAllSongs( $params );
					
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oSong->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
					/* Pagination End */		
					
				}//Geting default songs end.
	
			if($_REQUEST['srcData']!=''){ // After search. pagination will search.

					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
					
					$params = array(
								'limit'	  => $limit,  
								'start'   => $start,  
								'where'	  => ' AND song_name LIKE "'.$_REQUEST['srcData'].'%"' ,
							  );
					$oContentList = $oSong->getAllSongs( $params );
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oSong->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc&srcData=".$_REQUEST['srcData']."";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
								/* Pagination End */							
				}
				
				
			break;
			case '15':	
						
			$oVideo=new video();	
				if(!empty($_POST) && isset($_POST)){
					
					if( $postButton == 'saveContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'dataIds' => $select_ids, //Video Ids
										'eventId'  => $id,
										'relatedCType'  => $relatedCType,
									);
						if(sizeof($select_ids)>0){
							$mData=$oEvent->mapAllEvent($postData);
							/* Write DB Activity Logs */
							TOOLS::log('Event video', "save", '15', $this->user->user_id, " Saved Video for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}else if($srcData!=''){
				
					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
					
					$params = array(
								'limit'	  => $limit,  
								'start'   => $start,  
								'where'	  => ' AND video_name LIKE "'.$srcData.'%"' ,
							  );
					$oContentList = $oVideo->getAllVideos( $params );
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oVideo->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc&srcData=$srcData";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
								/* Pagination End */		
					
					}			
			}## Post data						
				
				/* condition for existing video in selected content start*/				
				$videoHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=".$relatedCType." AND event_id=".$id) );//Video			
##viseos				
				$videoHiddenArr = array();	
				
				if( !empty($videoHiddenMapData) ){		
					foreach($videoHiddenMapData as $videos){
						$videoHiddenArr[] = $videos->content_id;
					
					}
				}
		
				$videoHidden ='';
				$condition = '';
				if($videoHiddenArr){
					$videoHidden=implode(",",$videoHiddenArr); //VIDEO IDS
					$condition = " AND video_id NOT IN(".$videoHidden.")";//existing Video Id
				}
				/* condition for existing videos in selected content end*/

				/* Artist Video Contents */
				/* Event Video Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Video Name', 'Insert Date'), 
									  'body'=> array('video_id', 'video_name', 'insert_date'), 
									  'field_id'=>'video_id', 
									  'rank'=>true 
									);
				$artistVideoMapData=$oVideo->getArtistVideoMap(array('where'=> " AND artist_id IN ($artistHidden)")); //video.model.php
			
				$videoArr=array();
				
				if($artistVideoMapData){
				
					foreach($artistVideoMapData as $video){
						$videoArr[]=$video->video_id;
						
					}
				}
				
				if($videoArr && $srcData==''){ //Geting default video start.
					 $videoIdStr = implode(",",$videoArr);
					
					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
			
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(video_id,".$videoIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND video_id IN(".$videoIdStr.") ".$condition ,
							  );
					$oContentList = $oVideo->getAllVideos( $params );
					
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oVideo->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
					/* Pagination End */		
					
				}//Geting default videos end.
	
			if($_REQUEST['srcData']!=''){ // After search. pagination will search.

					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
					
					$params = array(
								'limit'	  => $limit,  
								'start'   => $start,  
								'where'	  => ' AND video_name LIKE "'.$_REQUEST['srcData'].'%"' ,
							  );
					$oContentList = $oVideo->getAllVideos( $params );
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oVideo->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc&srcData=".$_REQUEST['srcData']."";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
								/* Pagination End */							
				}
								
								
			break;
			case '17':
			
			$oImage = new image();
				if(!empty($_POST) && isset($_POST)){
					
					if( $postButton == 'saveContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'dataIds' => $select_ids, //Images Ids
										'eventId'  => $id,
										'relatedCType'  => $relatedCType,
									);
						if(sizeof($select_ids)>0){
							$mData=$oEvent->mapAllEvent($postData);
							/* Write DB Activity Logs */
							TOOLS::log('Event image', "save", '4', $this->user->user_id, " Saved Image for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}else if($srcData!=''){
				
					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_C\T_EVENT) : 0 );
					
					$params = array(
								'limit'	  => $limit,  
								'start'   => $start,  
								'where'	  => ' AND image_name LIKE "'.$srcData.'%"' ,
							  );
					$oContentList = $oImage->getAllImages( $params );
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oImage->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc&srcData=$srcData";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
					/* Pagination End */		
					
					}			
			}## Post data			
				
				
				
				/* condition for existing images in selected content start*/				
				$imageHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=".$relatedCType." AND event_id=".$id) );//Image			
##songs				
				$imageHiddenArr = array();	
				
				if( !empty($imageHiddenMapData) ){		
					foreach($imageHiddenMapData as $images){
						$imageHiddenArr[] = $images->content_id;
					
					}
				}
		
				$imageHidden ='';
				$condition = '';
				if($imageHiddenArr){
					$imageHidden=implode(",",$imageHiddenArr); //IMAGE IDS
					$condition = " AND image_id NOT IN(".$imageHidden.")";//existing Images Id
				}
				/* condition for existing image in selected content end*/


				/* Event Image Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Image', 'Image Name', 'Insert Date'), 
									  'body'=> array('image_id', 'image_file', 'image_name', 'insert_date'), 
									  'field_id'=>'image_id', 
									  'rank'=>false 
									);
				$artistImageMapData=$oImage->getImageMap(array('where'=> " AND content_type=13 AND content_id IN ($artistHidden)")); //image.model.php
				$imageArr=array();
				
				if($artistImageMapData){
				
					foreach($artistImageMapData as $image){
						$imageArr[]=$image->image_id;
						
					}
				}
				
				if($imageArr && $srcData==''){ //Geting default image start.
					 $imageIdStr = implode(",",$imageArr);
					
					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
			
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(image_id,".$imageIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND image_id IN(".$imageIdStr.") ".$condition ,
							  );
					$oContentList = $oImage->getAllImages( $params );
					
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oImage->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
					/* Pagination End */		
					
				}//Geting default songs end.
	
			if($_REQUEST['srcData']!=''){ // After search. pagination will search.

					$limit	= MAX_DISPLAY_COUNT_EVENT;
					$page	= (int)$_GET['page'];
					$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT_EVENT) : 0 );
					
					$params = array(
								'limit'	  => $limit,  
								'start'   => $start,  
								'where'	  => ' AND image_name LIKE "'.$_REQUEST['srcData'].'%"' ,
							  );
					$oContentList = $oImage->getAllImages( $params );
					/* Pagination Start */
					$oPage = new Paging();
					$oPage->total =$oImage->getTotalCount( $params );
					$oPage->page = $page;
					$oPage->limit = MAX_DISPLAY_COUNT_EVENT;
					$oPage->url ="event_related?action=view&isPlane=1&cType=$cType&relatedCType=$relatedCType&id=$id&type=all&page={page}&sort=asc&srcData=".$_REQUEST['srcData']."";
					$iOffset = (($page-1)*MAX_DISPLAY_COUNT_EVENT);
					$data['sPaging'] = $oPage->render();
					/* Pagination End */							
				}
				
				
			break;
			
		}
		
	break;
	case 'save' :
	switch( $relatedCType ){
			case '4':
				$oSong = new song();
				/* Event Song Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Song Name', 'ISRC', 'Insert Date'), 
									  'body'=> array('song_id', 'song_name', 'isrc', 'insert_date'), 
									  'field_id'=>'song_id', 
									  'rank'=>true 
									);
									
				
				if(!empty($_POST) && isset($_POST)){
					
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'dataIds' => $select_ids,
										'eventId' => $id,
										'relatedCType' => $relatedCType,
									);
						if(sizeof($select_ids)>0){
							$mData=$oEvent->removeAllEvent($postData); //Song Ids
							/* Write DB Activity Logs */
							TOOLS::log('song', "delete", '4', $this->user->user_id, " Removed Songs for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data delete successfully.';
						}			
					}elseif( $postButton == 'orderRank' ){
						$contentRank = $_POST['contentRank'];						
						$postData =array(
										'eventRank' => $contentRank,
										'eventId'  => $id,
									);
						if(sizeof($contentRank)>0){
							
							$mData=$oEvent->mapAllEventRank($postData);
							
							/* Write DB Activity Logs */
							TOOLS::log('event', "edit", '4', $this->user->user_id, "Ranked Songs for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}
					}			
				}
				
				
				$songHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=4 AND event_id=".$id." ORDER BY rank ASC") );//Song
				
##songs				
				$songArr = array();	
								
				if( !empty($songHiddenMapData) ){		
					foreach($songHiddenMapData as $songs){
						$songArr[] = $songs->content_id;
						$contentRankArr[$songs->content_id]=$songs->rank;
					
					}
				}
				if($songArr){
					$songIdStr = implode(",",$songArr);			
					$limit	= 200;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(song_id,".$songIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND song_id IN(".$songIdStr.")",
							  );
					
					$oContentList = $oSong->getAllSongs( $params );
				}
	
				if($oContentList){
					foreach($oContentList as $sList){
							$contentRankArr[$sList->event_id]=(int)$contentRankArr[$sList->event_id];
					}
					
				}
			
			
			break;
			case '15':
				$oVideo = new video();
				/* Event Video Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Video Name', 'Insert Date'), 
									  'body'=> array('video_id', 'video_name', 'insert_date'), 
									  'field_id'=>'video_id', 
									  'rank'=>true 
									);
									
				
				if(!empty($_POST) && isset($_POST)){
					
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'dataIds' => $select_ids,
										'eventId' => $id,
										'relatedCType' => $relatedCType,
									);
						if(sizeof($select_ids)>0){
							$mData=$oEvent->removeAllEvent($postData); //Song Ids
							/* Write DB Activity Logs */
							TOOLS::log('video', "delete", '15', $this->user->user_id, " Removed Videos for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data delete successfully.';
						}			
					}elseif( $postButton == 'orderRank' ){
						$contentRank = $_POST['contentRank'];						
						$postData =array(
										'eventRank' => $contentRank,
										'eventId'  => $id,
									);
						if(sizeof($contentRank)>0){
							
							$mData=$oEvent->mapAllEventRank($postData);
							
							/* Write DB Activity Logs */
							TOOLS::log('event', "edit", '4', $this->user->user_id, "Ranked Videos for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}
					}			
				}
				
				
				$videoHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=15 AND event_id=".$id." ORDER BY rank ASC") );//Video				
##viseos				
				$videoArr = array();	
								
				if( !empty($videoHiddenMapData) ){		
					foreach($videoHiddenMapData as $videos){
						$videoArr[] = $videos->content_id;
						$contentRankArr[$videos->content_id]=$videos->rank;
					
					}
				}

				if($videoArr){
					$videoIdStr = implode(",",$videoArr);			
					$limit	= 200;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(video_id,".$videoIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND video_id IN(".$videoIdStr.")",
							  );
					
					$oContentList = $oVideo->getAllVideos( $params );
				}
	
				if($oContentList){
					foreach($oContentList as $sList){
							$contentRankArr[$sList->event_id]=(int)$contentRankArr[$sList->event_id];
					}
					
				}
			
			
			break;
			case '17':
				$oImage = new image();
				/* Event Video Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Image', 'Image Name', 'Insert Date'), 
									  'body'=> array('image_id', 'image_file', 'image_name', 'insert_date'), 
									  'field_id'=>'image_id', 
									  'rank'=>true 
									);
									
				
				if(!empty($_POST) && isset($_POST)){
					
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'dataIds' => $select_ids,
										'eventId' => $id,
										'relatedCType' => $relatedCType,
									);
						if(sizeof($select_ids)>0){
							$mData=$oEvent->removeAllEvent($postData); //Image Ids
							/* Write DB Activity Logs */
							TOOLS::log('image', "delete", '17', $this->user->user_id, " Removed Images for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data delete successfully.';
						}			
					}elseif( $postButton == 'orderRank' ){
						$contentRank = $_POST['contentRank'];						
						$postData =array(
										'eventRank' => $contentRank,
										'eventId'  => $id,
									);
						if(sizeof($contentRank)>0){
							
							$mData=$oEvent->mapAllEventRank($postData);
							
							/* Write DB Activity Logs */
							TOOLS::log('event', "edit", '17', $this->user->user_id, "Ranked Images for Event Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}
					}			
				}
				
				
				$imageHiddenMapData = $oEvent->getAllEventMap( array('where'=> " AND content_type=17 AND event_id=".$id." ORDER BY rank ASC") );//Image				
##images				
				$imageArr = array();	
								
				if( !empty($imageHiddenMapData) ){		
					foreach($imageHiddenMapData as $images){
						$imageArr[] = $images->content_id;
						$contentRankArr[$images->content_id]=$images->rank;
					
					}
				}

				if($imageArr){
					$imageIdStr = implode(",",$imageArr);			
					$limit	= 200;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(image_id,".$imageIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND image_id IN(".$imageIdStr.")",
							  );
					
					$oContentList = $oImage->getAllImages( $params );
				}
	
				if($oContentList){
					foreach($oContentList as $sList){
							$contentRankArr[$sList->event_id]=(int)$contentRankArr[$sList->event_id];
					}
					
				}
			
					
			break;
			
		}
	
	break;		
}
	

$data['aError']   		= $aError;
$data['aSuccess']       = $aSuccess;
$data['aContentRank']   = $contentRankArr;
$data['aContent']       = $oContentList;
$data['contentType']    = $contentType[0]->event_type;
$data['aSearch']['srcData'] = $srcData;
$data['showHeadArr']   	= $showHeadArr;
$data['cType']			= $cType;
$data['relatedCType']	= $relatedCType;
$data['id']				= $id;



/* render view */
$oCms->view( $view, $data );