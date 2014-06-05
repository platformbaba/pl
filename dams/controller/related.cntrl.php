<?php       
/*
*	$cType - ContentId from where this pop up called.
*	$relatedCType - which related content type to be shown.
*	$id - Contentid
*	For any new related content combination, need to change in config.php
*/
$action = cms::sanitizeVariable( $_GET['action'] );
$action = ($action==''?'view':$action);

$cType  		= ((int)$_REQUEST['cType'] == 0 ? '14':(int)$_REQUEST['cType']);
$relatedCType 	= ((int)$_REQUEST['relatedCType'] == 0 ? '4':(int)$_REQUEST['relatedCType']);
$id		= (int)$_REQUEST['id'];
$view = 'related_pop';

$postButton = ( (isset($_POST['postButton']) && $_POST['postButton'] !='') ? $_POST['postButton']:'');
$showHeadArr = array();
$aExtraContent = array();
switch( $cType ){
	case '4':
		$oSong = new song();
		/* Song Contents Start */
		
		switch( $relatedCType ){
			case '15':
			/* Song Video Content start */
			$oVideo=new video();
				$showHeadArr = array( 'head'=> array('Id', 'Image', 'Video Name', 'Insert Date'), 
									  'body'=> array('video_id', 'image', 'video_name', 'insert_date'), 
									  'field_id'=>'video_id',
									  'remove_button'=>true,
									  'rank'=>false 
									);
			
				if(!empty($_POST) && isset($_POST)){
					if($postButton == 'removeContent'){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'selectIds' => $select_ids,
										'contentId'  => $id,
									);
						if(sizeof($select_ids)>0){
							$mData=$oImage->removeImageMap($postData, 13);
							/* Write DB Activity Logs */
							TOOLS::log('artist', "edit", '13', $this->user->user_id, " Removed Image for artist Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}			
				}
								
				$mapData=$oVideo->getSongVideoMap(array('where'=> " AND song_id=".$id." "));
				
				$videoArr=array();
				if($mapData){
					foreach($mapData as $videos){
						$videoArr[]=$videos->video_id;
					}
				}
				
				if($videoArr){
					$videoArrStr = implode(",",$videoArr);			
					$limit	= 100000;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(video_id,".$videoArrStr.")",  
								'start'   => $start,  
								'where'	  => " AND video_id IN(".$videoArrStr.")",
							  );
					
					$oContentList = $oVideo->getAllVideos( $params );
				}
			/* Song Video Content end */
			break;
		}
		/* Song Contents End */
		break;
	case '13':
		$oArtist = new artist();
		/* Artist Contents Start */
		
		switch( $relatedCType ){
			case '14':
				$oAlbum = new album();
				/* Artist Album Contents */
				$showHeadArr = array( 'head'=> array('Album Id', 'Album Name', 'Release Date'), 
									  'body'=> array('album_id', 'album_name', 'title_release_date'), 
									  'extra_head'=> array('Artist Role'), 
									  'extra_body'=> array('artist_role_display'), 
									  'field_id'=>'album_id', 
									  'rank'=>false, 
									  'remove_button'=>false
									);
										
				$artistAlbumData=$oAlbum->getArtistAlbumMap(array('where'=> " AND artist_id=".$id." "));
				$albumArr=array();
				if($artistAlbumData){
					foreach($artistAlbumData as $album){
						$albumArr[]=$album->album_id;
						$artistTypeContentArr[$album->album_id]['artist_role']=$album->artist_role;
						$aRoleArr=$oArtist->getArtistTypeByValue($album->artist_role);
						$artistTypeContentArr[$album->album_id]['artist_role_display']= (sizeof($aRoleArr)>0)?implode(" ,",$aRoleArr):"";
					}
				}
				
				if($albumArr){
					$albumIdStr = implode(",",$albumArr);			
					$limit	= 100000;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(album_id,".$albumIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND album_id IN(".$albumIdStr.")",
							  );
					
					$oContentList = $oAlbum->getAllAlbums( $params );
				}
				
				if($oContentList){
					$aExtraContent = $artistTypeContentArr;					
				}
			break;
			case '4':
				$oSong = new song();
				/* Artist Song Contents */
				$showHeadArr = array( 'head'=> array('Song Name', 'ISRC'), 
									  'body'=> array('song_name', 'isrc'), 
									  'extra_head'=> array('Artist Role'), 
									  'extra_body'=> array('artist_role_display'), 
									  'field_id'=>'song_id', 
									  'rank'=>false, 
									  'remove_button'=>false
									);
										
				$artistSongData=$oSong->getArtistSongMap(array('where'=> " AND artist_id=".$id." "));
				$songArr=array();
				if($artistSongData){
					foreach($artistSongData as $song){
						$songArr[]=$song->song_id;
						$artistTypeContentArr[$song->song_id]['artist_role']=$song->artist_role;
						$aRoleArr=$oArtist->getArtistTypeByValue($song->artist_role);
						$artistTypeContentArr[$song->song_id]['artist_role_display']= (sizeof($aRoleArr)>0)?implode(" ,",$aRoleArr):"";
					}
				}
				
				if($songArr){
					$songIdStr = implode(",",$songArr);			
					$limit	= 100000;
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
					$aExtraContent = $artistTypeContentArr;					
				}
			
			break;
			case '17':
				$oImage=new image();
				/* Artist Image Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Image', 'Image Name', 'Insert Date'), 
									  'body'=> array('image_id', 'image_file', 'image_name', 'insert_date'), 
									  'field_id'=>'image_id',
									  'remove_button'=>true,									  
									  'rank'=>false 
									);
			
				if(!empty($_POST) && isset($_POST)){
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'selectIds' => $select_ids,
										'contentId'  => $id,
									);
						if(sizeof($select_ids)>0){
							$mData=$oImage->removeImageMap($postData, 13);
							/* Write DB Activity Logs */
							TOOLS::log('artist', "edit", '13', $this->user->user_id, " Removed Image for artist Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}			
				}
								
				$imageMapData=$oImage->getImageMap(array('where'=> " AND content_id=".$id." AND content_type=13 "));
				
				$imageArr=array();
				if($imageMapData){
					foreach($imageMapData as $images){
						$imageArr[]=$images->image_id;
					}
				}
				
				if($imageArr){
					$imageIdStr = implode(",",$imageArr);			
					$limit	= 100000;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(image_id,".$imageIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND image_id IN(".$imageIdStr.")",
							  );
					
					$oContentList = $oImage->getAllImages( $params );
				}
			break;		
		}
		/* Artist Contents End */
		break;
	case '14':
		$mAlbum=new album();
		/* Album Contents */
		switch( $relatedCType ){
			case '4':
				$oSong = new song();
				/* Album Song Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Song Name', 'ISRC', 'Insert Date'), 
									  'body'=> array('song_id', 'song_name', 'isrc', 'insert_date'), 
									  'field_id'=>'song_id', 
									  'remove_button'=>true,
									  'add_song'=>true,
									  'rank'=>true 
									);
									
				
				if(!empty($_POST) && isset($_POST)){
					if( $_POST['addSongBtn'] == 'Add' ){
						$sel_song_id = (int)$_POST['autosuggestsong_hddn'];
						$srcSong = $_POST['srcSong'];
												
						if($sel_song_id>0){
							$postData =array(
										'songId' => $sel_song_id,
										'albumId'  => $id,
									);
							$mData=$oSong->mapSingleAlbumSong($postData);
							/* Write DB Activity Logs */
							TOOLS::log('album', "edit", '14', $this->user->user_id, " Added Song Id ".$sel_song_id." for album Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}
					}
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'selectIds' => $select_ids,
										'albumId'  => $id,
									);
						if(sizeof($select_ids)>0){
							$mData=$mAlbum->removeAlbumSong($postData);
							/* Write DB Activity Logs */
							TOOLS::log('album', "edit", '14', $this->user->user_id, " Removed Songs for album Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}elseif( $postButton == 'orderRank' ){
						$contentRank = $_POST['contentRank'];
						
						$postData =array(
										'songRank' => $contentRank,
										'albumId'  => $id,
									);
						if(sizeof($contentRank)>0){
							
							$mData=$mAlbum->mapAlbumSongRank($postData);
							
							/* Write DB Activity Logs */
							TOOLS::log('album', "edit", '14', $this->user->user_id, "Ranked Songs for album Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}
					}			
				}
				
				
				$albumSongMapData=$oSong->getAlbumSongMap(array('where'=> " AND album_id=".$id." ORDER BY rank ASC"));
				$songArr=array();
				if($albumSongMapData){
					foreach($albumSongMapData as $song){
						$songArr[]=$song->song_id;
						$contentRankArr[$song->song_id]=$song->rank;
					}
				}
				
				if($songArr){
					$songIdStr = implode(",",$songArr);			
					$limit	= 100000;
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
							$contentRankArr[$sList->song_id]=(int)$contentRankArr[$sList->song_id];
					}
					
				}
			
			break;
			case '15':
				$oVideo=new video();
				/* Album Video Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Video Name', 'Insert Date'), 
									  'body'=> array('video_id', 'video_name', 'insert_date'), 
									  'field_id'=>'video_id',
									  'remove_button'=>true,									  
									  'rank'=>true 
									);
				if(!empty($_POST) && isset($_POST)){
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'selectIds' => $select_ids,
										'albumId'  => $id,
									);
						if(sizeof($select_ids)>0){
							$mData=$mAlbum->removeAlbumVideo($postData);
							/* Write DB Activity Logs */
							TOOLS::log('album', "edit", '14', $this->user->user_id, " Removed Videos for album Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}elseif( $postButton == 'orderRank' ){
						$contentRank = $_POST['contentRank'];
						
						$postData =array(
										'videoRank' => $contentRank,
										'albumId'  => $id,
									);
						if(sizeof($contentRank)>0){
							$mData=$mAlbum->mapAlbumVideoRank($postData);
							/* Write DB Activity Logs */
							TOOLS::log('album', "edit", '14', $this->user->user_id, "Ranked Videos for album Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}
					}			
				}

				$albumVideoMapData=$oVideo->getAlbumVideoMap(array('where'=> " AND album_id=".$id." ORDER BY rank ASC"));
				
				$videoArr=array();
				if($albumVideoMapData){
					foreach($albumVideoMapData as $video){
						$videoArr[]=$video->video_id;
						$contentRankArr[$video->video_id]=$video->rank;
					}
				}
				
				if($videoArr){
					$videoIdStr = implode(",",$videoArr);			
					$limit	= 100000;
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
							$contentRankArr[$sList->video_id]=(int)$contentRankArr[$sList->video_id];
					}
				}
					
			break;
			case '17':
				$oImage=new image();
				/* Album Video Contents */
				$showHeadArr = array( 'head'=> array('Id', 'Image', 'Image Name', 'Insert Date'), 
									  'body'=> array('image_id', 'image_file', 'image_name', 'insert_date'), 
									  'field_id'=>'image_id', 
									  'remove_button'=>true,
									  'rank'=>false 
									);
			
				if(!empty($_POST) && isset($_POST)){
					if( $postButton == 'removeContent' ){
						$select_ids = $_POST['select_ids'];
						$postData =array(
										'selectIds' => $select_ids,
										'contentId'  => $id,
									);
						if(sizeof($select_ids)>0){
							$mData=$oImage->removeImageMap($postData, 14);
							/* Write DB Activity Logs */
							TOOLS::log('album', "edit", '14', $this->user->user_id, " Removed Image for album Id: ".(int)$id."" );
							$aSuccess[] = 'Data saved successfully.';
						}			
					}			
				}
				
				
				$albumImageMapData=$oImage->getImageMap(array('where'=> " AND content_id=".$id." AND content_type=14 "));
				
				$imageArr=array();
				if($albumImageMapData){
					foreach($albumImageMapData as $images){
						$imageArr[]=$images->image_id;
					}
				}
				
				if($imageArr){
					$imageIdStr = implode(",",$imageArr);			
					$limit	= 100000;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => " ORDER BY FIELD(image_id,".$imageIdStr.")",  
								'start'   => $start,  
								'where'	  => " AND image_id IN(".$imageIdStr.")",
							  );
					
					$oContentList = $oImage->getAllImages( $params );
				}
				
							
			break;
			
		}
		
	break;
}

$data['aError']   		= $aError;
$data['aSuccess']       = $aSuccess;

$data['aContentRank']   = $contentRankArr;
$data['aContent']       = $oContentList;
$data['aExtraContent']  = $aExtraContent;

$data['showHeadArr']   	= $showHeadArr;
$data['cType']			= $cType;
$data['relatedCType']	= $relatedCType;
$data['id']				= $id;



/* render view */
$oCms->view( $view, $data );