<?php 
//this is common controller for ajax          
$action = cms::sanitizeVariable( $_GET['action'] ); 
$action = ($action==''?'view':$action); 
$cType = cms::sanitizeVariable( $_GET['c'] );
global $aConfig;
if($action == 'view'){
		$query = cms::sanitizeVariable($_GET['query']);
		$type = cms::sanitizeVariable($_GET['type']);
		$id = cms::sanitizeVariable($_GET['id']);
		$aJson['query'] = $query;
		$aJson['suggestions'] = '';
		$cnt=0;
		$typeStr="";
		 
		if(strtolower($type)=="addtoplaylist"){
			$oPlaylist=new playlist();
			$playlistId=(int)$_POST['playlistId'];
			$songIds=cms::sanitizeVariable($_POST['songId']);
			$ctype=cms::sanitizeVariable($_POST['ctype']);
			$songIdArr=explode(",",$songIds);
			if($songIdArr){
				if($ctype==15){	$s="Videos";}elseif($ctype==17){$s="Images";}else{$s="Songs";}
				$sData=$oPlaylist->mapSongPlaylist(array('playlistId'=>(int)$playlistId,'songKeyArray'=>$songIdArr,'ctype'=>$ctype));
				$aLogParam = array(
					'moduleName' => 'playlist',
					'action' => 'Add',
					'moduleId' => 29,
					'editorId' => TOOLS::getEditorId(),
					'remark'	=>	$s.' (ID-'.$songIds.') added to playlist. (ID-'.(int)$playlistId.')',
					'content_ids' => (int)$playlistId
				);
				TOOLS::writeActivityLog( $aLogParam );
				echo 1;
			}else{
				echo 0;
			}	 
			exit; 
		}elseif(strtolower($type)=="rmimisong"){
			$mDeployment=new deployment();
			$aRes = $mDeployment->deleteDeployDetails(array('id'=>(int)$_POST['id']));
			if($aRes){
				$aFileStr=$_POST['afile'];
				$aFileArr=explode(",",$aFileStr);
				if($aFileArr){
					foreach($aFileArr as $link){
						@unlink($link);
					}
				}
				$xFileStr=$_POST['xfile'];	
				if($xFileStr){
					@unlink($xFileStr);
				}
				echo "1";
			}else{
				echo "0";
			}
			exit;
		}elseif(strtolower($type)=="catalogue"){
			$mCatalogue=new catalogue();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY catalogue_name ASC',  
						'start'   => 0,  
						'where'   => " AND catalogue_name LIKE '".$query."%' $typeStr",
					  );
			$aCatalogueSuggest = $mCatalogue->getAllCatalogues($params);
			if($aCatalogueSuggest){
				foreach($aCatalogueSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->catalogue_name;
					$aJson['suggestionsIds'][] = $suggest->catalogue_id;
					$aList[$suggest->catalogue_id] = $suggest->catalogue_name;
					$cnt++;
				}	
			}
		}elseif( $type=="calendar" ){
			$aJson['content'] = CALENDAR::showCalendar( array('mm_yyyy'=>$query, 'ajax'=>true) );
		}else if($type=="tag"){
			if($id){
				$typeStr =" AND parent_tag_id=".$id;
			}	
			$mTag=new tags();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY tag_name ASC',  
						'start'   => 0,  
						'where'   => " AND tag_name LIKE '".$query."%' $typeStr",
					  );
			$aTagSuggest = $mTag->getAllTags($params);
			if($aTagSuggest){
				foreach($aTagSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->tag_name;
					$aJson['suggestionsIds'][] = $suggest->tag_id;
					$aList[$suggest->tag_id] = $suggest->tag_name;
					$cnt++;
				}	
			}
		}elseif($type=="uploadify"){
			ini_set('memory_limit','5120M');
			
			if($cType=="video"){ 
				$fileData = $_FILES['Filedata'];
				$response['status'] = 'ERROR';
				$response['msg'] = 'Please Select File';
				$response['post'] = $_POST;
				$response['file'] = $fileData['name'];
				$videoName = $_POST['videoName'];
				$pathInfo = pathinfo($fileData['name']);
				$allowedFiles = array('mov','mp4','avi');
				$aError = array();
				if($videoName==""){
					$aError[] = "Please enter Video Name.";
				}
				if(!in_array(strtolower($pathInfo['extension']),$allowedFiles)){
					$aError[] = "File types Allowed : ". implode(',',$allowedFiles);
				}
				if(count($aError) == 0){
					$fExt=$pathInfo['extension'];
					$newName=tools::getVideoPathByTitle($videoName,$fExt,time());
					$fileToSave=$newName;
					$newPath="videos/raw/".$fileToSave;
					tools::createDir(MEDIA_SEVERPATH_TEMP.$newPath);
					move_uploaded_file($fileData['tmp_name'], MEDIA_SEVERPATH_TEMP.$newPath);
					$response['status'] = 'OK';
					$response['filepath'] = $newPath;
					$response['filename'] = $newName;
					$response['msg'] = 'File Uploaded Successfully.';
				}else{
					$response['msg'] =  implode(chr(10),$aError);
				}
				echo json_encode($response);
			}elseif($cType=="song"){ 
				$fileData = $_FILES['Filedata'];
				$response['status'] = 'ERROR';
				$response['msg'] = 'Please Select File';
				$response['post'] = $_POST;
				$response['file'] = $fileData['name'];
				$isrc = $_POST['isrc'];
				$pathInfo = pathinfo($fileData['name']);
				$allowedFiles = array('wav');
				$aError = array();
				if($isrc==""){
					$aError[] = "Please enter ISRC.";
				}
				if(!in_array(strtolower($pathInfo['extension']),$allowedFiles)){
					$aError[] = "File types Allowed : ". implode(',',$allowedFiles);
				}
				if(count($aError) == 0){
					$newName=$isrc.".".$pathInfo['extension'];
					$cleanFileName	= TOOLS::cleanFileName($newName, true);
					#$newPath 	= 'songs/edits/mp4/full/'.TOOLS::getSongPath($isrc);
					$fExt="wav";
					$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
					$newPath="songs/raw/".$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
					tools::createDir(MEDIA_SEVERPATH_TEMP.$newPath);
					move_uploaded_file($fileData['tmp_name'], MEDIA_SEVERPATH_TEMP.$newPath);
					$response['status'] = 'OK';
					$response['filepath'] = $newPath;
					$response['filename'] = $newName;
					$response['msg'] = 'File Uploaded Successfully.';
				}else{
					$response['msg'] =  implode(chr(10),$aError);
				}
				echo json_encode($response);
			
			}else if($cType=="song_mp4"){
				$fileData = $_FILES['Filedata'];
				$response['status'] = 'ERROR';
				$response['msg'] = 'Please Select File';
				$response['post'] = $_POST;
				$response['file'] = $fileData['name'];
				$isrc = $_POST['isrc'];
				$pathInfo = pathinfo($fileData['name']);
				$allowedFiles = array('mp4');
				$aError = array();
				if($isrc==""){
					$aError[] = "Please enter ISRC.";
				}
				if(!in_array(strtolower($pathInfo['extension']),$allowedFiles)){
					$aError[] = "File types Allowed : ". implode(',',$allowedFiles).'>>> '.$pathInfo['extension'];
				}
				if(count($aError) == 0){
					$newName=$isrc.".".$pathInfo['extension'];
					$cleanFileName	= TOOLS::cleanFileName($newName, true);
					#$newPath 	= 'songs/edits/mp4/full/'.TOOLS::getSongPath($isrc);
					$fExt="mp4";
					$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
					$newPath="songs/raw/".$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
					tools::createDir(MEDIA_SEVERPATH_TEMP.$newPath);
					move_uploaded_file($fileData['tmp_name'], MEDIA_SEVERPATH_TEMP.$newPath);
					$response['status'] = 'OK';
					$response['filepath'] = $newPath;
					$response['filename'] = $newName;
					$response['msg'] = 'File Uploaded Successfully.';
				}else{
					$response['msg'] =  implode(chr(10),$aError);
				}
				echo json_encode($response);
			}else if($cType=="song_mp3"){
				$fileData = $_FILES['Filedata'];
				$response['status'] = 'ERROR';
				$response['msg'] = 'Please Select File';
				$response['post'] = $_POST;
				$response['file'] = $fileData['name'];
				$isrc = $_POST['isrc'];
				$pathInfo = pathinfo($fileData['name']);
				$allowedFiles = array('mp3');
				$aError = array();
				if($isrc==""){
					$aError[] = "Please enter ISRC.";
				}
				if(!in_array(strtolower($pathInfo['extension']),$allowedFiles)){
					$aError[] = "File types Allowed : ". implode(',',$allowedFiles);
				}
				if(count($aError) == 0){
					$newName=$isrc.".".$pathInfo['extension'];
					$cleanFileName	= TOOLS::cleanFileName($newName, true);
					#$newPath 	= 'songs/edits/mp4/full/'.TOOLS::getSongPath($isrc);
					$fExt="mp3";
					$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
					$newPath="songs/raw/".$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
					tools::createDir(MEDIA_SEVERPATH_TEMP.$newPath);
					move_uploaded_file($fileData['tmp_name'], MEDIA_SEVERPATH_TEMP.$newPath);
					$response['status'] = 'OK';
					$response['filepath'] = $newPath;
					$response['filename'] = $newName;
					$response['msg'] = 'File Uploaded Successfully.';
				}else{
					$response['msg'] =  implode(chr(10),$aError);
				}
				echo json_encode($response);
			}
			exit;
		}elseif($type=="banner"){
			$mBanner=new banner();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY banner_name ASC',  
						'start'   => 0,  
						'where'   => " AND banner_name LIKE '".$query."%' $typeStr",
					  );
			$aBannerSuggest = $mBanner->getAllBanners($params);
			if($aBannerSuggest){
				foreach($aBannerSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->banner_name;
					$aJson['suggestionsIds'][] = $suggest->banner_id;
					$aList[$suggest->banner_id] = $suggest->banner_name;
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="packalbum"){
			$mAlbum=new album();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY album_name ASC',  
						'start'   => 0,  
						//'where'   => " AND (content_type&16)=16 AND album_name LIKE '".$query."%' $typeStr",
						'where'   => " AND album_name LIKE '".$query."%' $typeStr",
					  );
			$aAlbumSuggest = $mAlbum->getAllAlbums($params);
			if($aAlbumSuggest){
				foreach($aAlbumSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->album_name." (".$suggest->music_release_date.")";
					$aJson['suggestionsIds'][] = $suggest->album_id;
					$aList[$suggest->album_id] = $suggest->album_name." (".$suggest->music_release_date.")";
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="album"){
			$mAlbum=new album();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY album_name ASC',  
						'start'   => 0,  
						'where'   => " AND album_name LIKE '".$query."%' $typeStr",
					  );
			$aAlbumSuggest = $mAlbum->getAllAlbums($params);
			if($aAlbumSuggest){
				foreach($aAlbumSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->album_name." (".$suggest->music_release_date.")";
					$aJson['suggestionsIds'][] = $suggest->album_id;
					$aList[$suggest->album_id] = $suggest->album_name." (".$suggest->music_release_date.")";
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="video"){
			$mVideo=new video();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY video_name ASC',  
						'start'   => 0,  
						'where'   => " AND video_name LIKE '".$query."%' $typeStr",
					  );
			$aVideoSuggest = $mVideo->getAllVideos($params);
			if($aVideoSuggest){
				foreach($aVideoSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->video_name;
					$aJson['suggestionsIds'][] = $suggest->video_id;
					$aList[$suggest->video_id] = $suggest->video_name;
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="image"){
			$mImage=new image();
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY image_name ASC',  
						'start'   => 0,  
						'where'   => " AND image_name LIKE '".$query."%' $typeStr",
					  );
			$aImageSuggest = $mImage->getAllImages($params);
			if($aImageSuggest){
				foreach($aImageSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->image_name."@@".$suggest->image_file;
					$aJson['suggestionsIds'][] = $suggest->image_id;
					$aList[$suggest->image_id] = $suggest->image_name."@@".$suggest->image_file;
					
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="song"){
			$mSong=new song();
			$params = array(
						'limit'	  => 10,  
						'orderby' => 'ORDER BY song_name ASC',  
						'start'   => 0,  
						'where'   => " AND song_name LIKE '".$query."%' $typeStr",
					  );
			$aSongSuggest = $mSong->getAllSongs($params);
			if($aSongSuggest){
				foreach($aSongSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->song_name;
					$aJson['suggestionsIds'][] = $suggest->song_id;
					$aList[$suggest->song_id][] = $suggest->song_name;
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="playlist"){
			$mPlaylist=new playlist();
			$params = array(
						'limit'	  => 10,  
						'orderby' => 'ORDER BY playlist_name ASC',  
						'start'   => 0,  
						'where'   => " AND content_type=4 AND playlist_name LIKE '".$query."%' $typeStr",
					  );
			$aSongSuggest = $mPlaylist->getAllPlaylists($params);
			if($aSongSuggest){
				foreach($aSongSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->playlist_name;
					$aJson['suggestionsIds'][] = $suggest->playlist_id;
					$aList[$suggest->playlist_id][] = $suggest->playlist_name;
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="videoplaylist"){
			$mPlaylist=new playlist();
			$params = array(
						'limit'	  => 10,  
						'orderby' => 'ORDER BY playlist_name ASC',  
						'start'   => 0,  
						'where'   => " AND content_type=15 AND playlist_name LIKE '".$query."%' $typeStr",
					  );
			$aSongSuggest = $mPlaylist->getAllPlaylists($params);
			if($aSongSuggest){
				foreach($aSongSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->playlist_name;
					$aJson['suggestionsIds'][] = $suggest->playlist_id;
					$aList[$suggest->playlist_id][] = $suggest->playlist_name;
					$cnt++;
				}	
			}
		}elseif(strtolower($type)=="imageplaylist"){
			$mPlaylist=new playlist();
			$params = array(
						'limit'	  => 10,  
						'orderby' => 'ORDER BY playlist_name ASC',  
						'start'   => 0,  
						'where'   => " AND content_type=17 AND playlist_name LIKE '".$query."%' $typeStr",
					  );
			$aSongSuggest = $mPlaylist->getAllPlaylists($params);
			if($aSongSuggest){
				foreach($aSongSuggest as $suggest){
					$aJson['suggestions'][] = $suggest->playlist_name;
					$aJson['suggestionsIds'][] = $suggest->playlist_id;
					$aList[$suggest->playlist_id][] = $suggest->playlist_name;
					$cnt++;
				}	
			}
		}else{
			$mArtist=new artist();
			if($type){
				$type=$aConfig['artist_type'][ucwords($type)];
				$typeStr=" AND (artist_role&".$type.")=".$type;
			}
			$params = array(
						'limit'	  => 20,  
						'orderby' => 'ORDER BY artist_name ASC',  
						'start'   => 0,  
						'where'   => " AND artist_name LIKE '".$query."%' $typeStr",
					  );
			$aArtistSuggest = $mArtist->getAllArtists($params);
			if($aArtistSuggest){
				foreach($aArtistSuggest as $suggest){
					$dobStr=($suggest->artist_dob!="")?"(".$suggest->artist_dob.")":"";
					$aJson['suggestions'][] = $suggest->artist_name." ".$dobStr;
					$aJson['suggestionsIds'][] = $suggest->artist_id;
					$aList[$suggest->artist_id] = $suggest->artist_name." ".$dobStr;
					$cnt++;
				}	
			}
		}
		$aJson['option'] = $aList;
	    $aJson['count'] = $cnt;	
		echo json_encode($aJson);
		exit;	
}