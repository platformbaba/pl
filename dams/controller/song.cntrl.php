<?php    //song     
set_time_limit(0); 
ini_set('memory_limit','5120M');
$view = 'song_list';
$oSong = new song();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'legal') );
$id = (int)$_GET['id']; 

if( $action == 'add' || $action == 'edit' ){
	
	$oLanguage = new language();
	$mAlbum = new album();
	$mTags=new tags();
	$vParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1889",
		   );
	$versionList=$mTags->getAllTags($vParams);
	$gParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1688",
		   );
	$genreList=$mTags->getAllTags($gParams);
	$mParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1",
		   );
	$moodList=$mTags->getAllTags($mParams);
	$rParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=16",
		   );
	$relationshipList=$mTags->getAllTags($rParams);
	$rParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1189",
		   );
	$raagList=$mTags->getAllTags($rParams);
	$tParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1383",
		   );
	$taalList=$mTags->getAllTags($tParams);
	$tParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1415",
		   );
	$timeofdayList=$mTags->getAllTags($tParams);
	$iParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=1424",
		   );
	$instrumentList=$mTags->getAllTags($iParams);
	$rParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=498",
		   );
	$religionList=$mTags->getAllTags($rParams);
	$sParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=506",
		   );
	$saintList=$mTags->getAllTags($sParams);
	$fParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=29",
		   );
	$festivalList=$mTags->getAllTags($fParams);
	$oParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY tag_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND parent_tag_id=487",
		   );
	$occasionList=$mTags->getAllTags($oParams);
	$lParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY language_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1",
		   );
	
	$languageList=$oLanguage->getAllLanguages($lParams);
	$mRegion=new region();
	$rParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY region_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1",
		   );
	$regionList=$mRegion->getAllRegions($rParams);

	$data['versionList']=$versionList;
	$data['genreList']=$genreList;
	$data['moodList']=$moodList;
	$data['relationshipList']=$relationshipList;
	$data['raagList']=$raagList;
	$data['taalList']=$taalList;
	$data['timeofdayList']=$timeofdayList;
	$data['instrumentList']=$instrumentList;
	$data['religionList']=$religionList;
	$data['saintList']=$saintList;
	$data['festivalList']=$festivalList;
	$data['occasionList']=$occasionList;
	$data['languageList']=$languageList;
	$data['regionList']=$regionList;
	/* Form */
	$view = 'song_form';
	$id = (int)$_GET['id']; 

	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$songName	=	cms::sanitizeVariable($_POST['songName']);
		$status	=	cms::sanitizeVariable($_POST['status']);
		$isrc	=	cms::sanitizeVariable($_POST['isrc']);
		$releaseDate=	cms::sanitizeVariable($_POST['releaseDate']);
		
		$audioFilePath = cms::sanitizeVariable($_POST['audioFilePath']);
		$audioFilePath_mp4 = cms::sanitizeVariable($_POST['audioFilePath_mp4']);
		$audioFilePath_mp3 = cms::sanitizeVariable($_POST['audioFilePath_mp3']);
		
		$songDuration=	(int)$_POST['songDuration'];
		$songTempo	=	cms::sanitizeVariable($_POST['songTempo']);
		$subjectParody=	cms::sanitizeVariable($_POST['subjectParody']);
		$region		=	cms::sanitizeVariable($_POST['region']);
		$languageIds=	cms::sanitizeVariable($_POST['languageIds']);
		$version    = $_POST['version'];
		$genre    	= $_POST['genre'];
		$mood    	= $_POST['mood'];
		$relationship    = $_POST['relationship'];
		$raag    	= $_POST['raag'];
		$taal    	= $_POST['taal'];
		$timeofday  = $_POST['timeofday'];
		$religion   = $_POST['religion'];
		$saint    	= $_POST['saint'];
		$instrument = $_POST['instrument'];
		$festival   = $_POST['festival'];
		$occasion   = $_POST['occasion'];
		$rawFileVal = 	cms::sanitizeVariable($_POST['rawFileVal']);
		$grade 		= 	cms::sanitizeVariable($_POST['grade']);
		
		$singerHidden = trim($_POST['singerHidden'],",");
		$mdirectorHidden = trim($_POST['mdirectorHidden'],",");
		$lyricistHidden = trim($_POST['lyricistHidden'],",");
		$poetHidden   = trim($_POST['poetHidden'],",");
		$starcastHidden   = trim($_POST['starcastHidden'],",");
		$mstarcastHidden   = trim($_POST['mstarcastHidden'],",");
		$albumHidden   = trim($_POST['albumHidden'],",");
		
						
		$singerHiddenArr=array();
		if($singerHidden){
			$singerHiddenArr=explode(",",$singerHidden);
		}
		$lyricistHiddenArr=array();
		if($lyricistHidden){
			$lyricistHiddenArr=explode(",",$lyricistHidden);
		}
		$mdirectorHiddenArr=array();
		if($mdirectorHidden){
			$mdirectorHiddenArr=explode(",",$mdirectorHidden);
		}
		$poetHiddenArr=array();
		if($poetHidden){
			$poetHiddenArr=explode(",",$poetHidden);
		}
		$starcastHiddenArr=array();
		if($starcastHidden){
			$starcastHiddenArr=explode(",",$starcastHidden);
		}
		$mstarcastHiddenArr=array();
		if($mstarcastHidden){
			$mstarcastHiddenArr=explode(",",$mstarcastHidden);
		}
		$albumHiddenArr=array();
		if($albumHidden){
			$albumHiddenArr=explode(",",$albumHidden);
		}

		$singerHiddensData = explode('|',trim($_POST['singerHiddensData'],"|"));
		$singerNameArr=array();
		if($singerHiddensData){
			foreach($singerHiddensData as $singerHiddensData){
				$singerNameData = explode(":",$singerHiddensData);
				if($singerNameData[0] && in_array($singerNameData[0],$singerHiddenArr)){
					$singerNameArr[$singerNameData[0]]=$singerNameData[1];
					$artistRoleArray[$singerNameData[0]]=$aConfig['artist_type']['Singer'];
				}
			}
		}

		$mdirectorHiddensData = explode('|',trim($_POST['mdirectorHiddensData'],"|"));
		$mdirectorNameArr=array();
		if($mdirectorHiddensData){
			foreach($mdirectorHiddensData as $mdirectorHiddensData){
				$mdirectorNameData = explode(":",$mdirectorHiddensData);
				if($mdirectorNameData[0] && in_array($mdirectorNameData[0],$mdirectorHiddenArr)){
					$mdirectorNameArr[$mdirectorNameData[0]]=$mdirectorNameData[1];
					$artistRoleArray[$mdirectorNameData[0]]=$aConfig['artist_type']['Music Director'];					
				}
			}
		}

		$lyricistHiddensData = explode('|',trim($_POST['lyricistHiddensData'],"|"));
		$lyricistNameArr=array();
		if($lyricistHiddensData){
			foreach($lyricistHiddensData as $lyricistHiddensData){
				$lyricistNameData = explode(":",$lyricistHiddensData);
				if($lyricistNameData[0] && in_array($lyricistNameData[0],$lyricistHiddenArr)){
					$lyricistNameArr[$lyricistNameData[0]]=$lyricistNameData[1];
					$artistRoleArray[$lyricistNameData[0]]=$aConfig['artist_type']['Lyricist'];					
				}
			}
		}

		$poetNameArr=array();
		/*$poetHiddensData = explode('|',trim($_POST['poetHiddensData'],"|"));
		if($poetHiddensData){
			foreach($poetHiddensData as $poetHiddensData){
				$poetNameData = explode(":",$poetHiddensData);
				if($poetNameData[0] && in_array($poetNameData[0],$poetHiddenArr)){
					$poetNameArr[$poetNameData[0]]=$poetNameData[1];
					$artistRoleArray[$poetNameData[0]]=$aConfig['artist_type']['Poet'];										
				}
			}
		}*/
		$starcastHiddensData = explode('|',trim($_POST['starcastHiddensData'],"|"));
		$starcastNameArr=array();
		if($starcastHiddensData){
			foreach($starcastHiddensData as $starcastHiddensData){
				$starcastNameData = explode(":",$starcastHiddensData);
				if($starcastNameData[0] && in_array($starcastNameData[0],$starcastHiddenArr)){
					$starcastNameArr[$starcastNameData[0]]=$starcastNameData[1];
					$artistRoleArray[$starcastNameData[0]]=$aConfig['artist_type']['Starcast'];										
				}
			}
		}
		$mstarcastHiddensData = explode('|',trim($_POST['mstarcastHiddensData'],"|"));
		$mstarcastNameArr=array();
		if($mstarcastHiddensData){
			foreach($mstarcastHiddensData as $mstarcastHiddensData){
				$mstarcastNameData = explode(":",$mstarcastHiddensData);
				if($mstarcastNameData[0] && in_array($mstarcastNameData[0],$mstarcastHiddenArr)){
					$mstarcastNameArr[$mstarcastNameData[0]]=$mstarcastNameData[1];
					$artistRoleArray[$mstarcastNameData[0]]=$aConfig['artist_type']['Mimicked Star'];										
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

		$artistRoleKeyArray=array();
		if($artistRoleArray){
			foreach($artistRoleArray as $kR=>$vR){
				if(in_array($kR,$starcastHiddenArr)){
					$artistRoleKeyArray[$kR]=$aConfig['artist_type']['Starcast'];
				}
				if(in_array($kR,$mdirectorHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Music Director'];
				}
				if(in_array($kR,$singerHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Singer'];
				}
				if(in_array($kR,$lyricistHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Lyricist'];
				}
				if(in_array($kR,$mstarcastHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Mimicked Star'];
				}
				if(in_array($kR,$poetHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Poet'];
				}
			}
		}
		
		if( empty($albumHiddenArr) ){
			$aError[]="Please select Album.";
		}
		if($songName==""){
			$aError[]="Enter Song Name.";
		}
		if($languageIds==""){
			$aError[]="Please select Language.";
		}
		if($releaseDate==""){
			$aError[]="Please select Release Date.";
		}				
		if($isrc==""){
			$aError[]="Enter Song ISRC.";
		}
		if($songDuration==0){
			$aError[]="Enter Song Duration.";
		}
		if($rawFileVal){
			$pathinfo=pathinfo($rawFileVal);
			$fExt=$pathinfo['extension'];
			if(!in_array($fExt,array('mp3','mp4','wav'))){
				$aError[]="Browsed file is not of specified extension.";
			}else{
				$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
				$destinatonFile=MEDIA_SERVERPATH_SONGRAW.$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
				tools::createDir($destinatonFile);
				if(copy($rawFileVal,$destinatonFile)){
					#unlink($rawFileVal);					
				}else{print_r(error_get_last());
					$aError[]="Failed to copy browsed file.";
				}
			}
		}
		/*
		if($audioFilePath==""){
			$aError[]="Please enter Audio File Path or Upload Audio File.";
		}
		*/
		if(empty($singerHiddenArr)){
			$aError[]="Please Select Singer.";
		}
		if(empty($mdirectorHiddenArr)){
			$aError[]="Please Select Music Director.";
		}
		if(empty($version)){
			$aError[]="Please Select Version.";
		}
		if(empty($genre)){
			$aError[]="Please Select Genre.";
		}
		if(empty($mood)){
			$aError[]="Please Select Mood.";
		}
		/*if($region==0){
			$aError[]="Please Select Region.";
		}*/
		$oAlbumId=0;
		if($albumHiddenArr){
			$abParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY album_name ASC',  
					'start'   => 0,  
					'where'   => " AND album_id IN (".implode(",",$albumHiddenArr).") AND 2&album_type=2",
			   );
			$albumData=$mAlbum->getAllAlbums($abParams);
			$oAlbumId=$albumData[0]->album_id;
		}

		/* Move Uploaded Files Start */
		if( $audioFilePath != '' ){
			$fExt="wav";
			$sourceFile = MEDIA_SEVERPATH_TEMP.$audioFilePath;
			$newFile 	= MEDIA_SEVERPATH.$audioFilePath;
			TOOLS::createDir( MEDIA_SEVERPATH.$audioFilePath );
			if(copy($sourceFile, $newFile)){
				$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
				unlink($sourceFile);
			}
		}
		if( $audioFilePath_mp4 != '' ){
			$fExt="mp4";
			$sourceFile = MEDIA_SEVERPATH_TEMP.$audioFilePath_mp4;
			$newFile 	= MEDIA_SEVERPATH.$audioFilePath_mp4;
			TOOLS::createDir( MEDIA_SEVERPATH.$audioFilePath_mp4 );
			if(copy($sourceFile, $newFile)){
				$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
			}
		}
		if( $audioFilePath_mp3 != '' ){
			$fExt="mp3";
			$sourceFile = MEDIA_SEVERPATH_TEMP.$audioFilePath_mp3;
			$newFile 	= MEDIA_SEVERPATH.$audioFilePath_mp3;
			TOOLS::createDir( MEDIA_SEVERPATH.$audioFilePath_mp3 );
			if(copy($sourceFile, $newFile)){
				$fileToSave=$fExt."/".tools::getSongPath($isrc).$isrc.".".$fExt;
			}
		}
		/* Move Uploaded Files End */

		$postData=array(
					'songId'=>$id,
					'songName'=>$songName,
					'status'=>$status,
					'isrc' => $isrc,
					'languageIds'=>$languageIds,
					'releaseDate'=>$releaseDate,
					'songDuration' => $songDuration,
					'songTempo'=>$songTempo,
					'subjectParody' => $subjectParody,
					'audioFilePath' => $fileToSave,
					'singerNameArr'=>$singerNameArr,
					'singerId' => $singerHidden,
					'singerNameStr'=>$_POST['singerHiddensData'],
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$_POST['starcastHiddensData'],
					'mdirectorNameArr'=>$mdirectorNameArr,
					'mdirectorId' => $mdirectorHidden,
					'mdirectorNameStr'=>$_POST['mdirectorHiddensData'],
					'lyricistNameArr'=>$lyricistNameArr,
					'lyricistId' => $lyricistHidden,
					'lyricistNameStr'=>$_POST['lyricistHiddensData'],
					'mstarcastNameArr'=>$mstarcastNameArr,
					'mstarcastId' => $mstarcastHidden,
					'mstarcastNameStr'=>$_POST['mstarcastHiddensData'],
					'poetNameArr'=>$poetNameArr,
					'poetId' => $poetHidden,
					'poetNameStr'=>$_POST['poetHiddensData'],
					'albumNameArr'=>$albumNameArr,
					'albumId' => $albumHidden,
					'albumNameStr'=>$_POST['albumHiddensData'],
					'region' => $region,
					'version'    => $version,
					'genre'    	=> $genre,
					'mood'    	=>$mood,
					'relationship'  => $relationship,
					'raag'    	=> $raag,
					'taal'    	=> $taal,
					'timeofday'  => $timeofday,
					'religion'   => $religion,
					'saint'    	=> $saint,
					'instrument' => $instrument,
					'festival'   => $festival,
					'occasion'   => $occasion,
					'oAlbumId'   => $oAlbumId,
					'grade' 	 => $grade,
					);
		if(empty($aError)){
			$aData = $oSong->saveSong( $postData );
			$logMsg="Created song.";
			if($id){
				$aData=$id;
				$logMsg="Edited song information.";
			}
			if($aData){
				if($artistRoleKeyArray){ 
					$oData=$oSong->mapArtistSong(array('songId'=>(int)$aData,'artistRoleKeyArray'=>$artistRoleKeyArray));					
				}
				$tagIds=array_merge((array)$version,(array)$genre,(array)$mood,(array)$relationship,(array)$raag,(array)$taal,(array)$timeofday,(array)$religion,(array)$saint,(array)$instrument,(array)$festival,(array)$occasion);
				if($tagIds){
					$tData=$oSong->mapTagSong(array('songId'=>(int)$aData,'tagIds'=>$tagIds));
				}
				if($albumHiddenArr){
					$lData=$oSong->mapAlbumSong(array('songId'=>(int)$aData,'albumIds'=>$albumHiddenArr));
				}	
			}
			
			/* Send Mail Notification start*/
			if($action == 'add'){
				$oMailParam = array(
						'moduleName' => 'song',
						'action' => $action,
						'moduleId' => 4,
						'editorId' => $this->user->user_id,
						'content_ids' => (int)$aData
					);
				$oNotification->sendNotification( $oMailParam );
				
			}
			/* Send Mail Notification end*/
			
			/* Write DB Activity Logs */
			#TOOLS::log('song', $action, '4', (int)$this->user->user_id, "Song Id: ".$aData."" );
			$aLogParam = array(
				'moduleName' => 'song',
				'action' => $action,
				'moduleId' => 4,
				'editorId' => $this->user->user_id,
				'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
				'content_ids' => (int)$aData
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'song?msg=Data saved successfully');exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
	if($id > 0){
		/* Get Language Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'where' => ' AND song_id="'.$id.'"', 
				  ); 
		$aSongData = $oSong->getAllSongs( $params );
		
		$artistSongMapData=$oSong->getArtistSongMap(array('where'=> " AND song_id=".$id));

		$artistIdArray=array();
		$artistIdMapArray=array();
		if($artistSongMapData){
			foreach($artistSongMapData as $vMap){
				$artistIdArray[]=$vMap->artist_id;
				$artistIdMapArray[$vMap->artist_id]=$vMap->artist_role;	
			}	
		}
		$artistIdStr="0";
		if($artistIdArray){
			$artistIdStr=implode(",",$artistIdArray);
		}

		$mArtist=new artist();
		$mArtistArray=NULL;
		if($artistIdStr){
			$mArtistArray=$mArtist->getArtistById(array('ids'=>$artistIdStr));
		}
		$artistNameStr="";
		$mArtistArrayWithId=array();
		$singerNameArr=array();
		$starcastNameArr=array();
		$mstarcastNameArr=array();
		$mdirectorNameArr=array();
		$lyricistNameArr=array();
		$poetNameArr=array(); 
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $vArt){
				$mArtistArrayWithId[$vArt->artist_id]=$vArt;
				$artistNameStr.=$vArt->artist_id.":".$vArt->artist_name."|";
				if(($aConfig['artist_type']['Singer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Singer']){
					$singerHiddenArr[]=$vArt->artist_id;
					$singerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Music Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Music Director']){
					$mdirectorHiddenArr[]=$vArt->artist_id;
					$mdirectorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Lyricist']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Lyricist']){
					$lyricistHiddenArr[]=$vArt->artist_id;
					$lyricistNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				/*if(($aConfig['artist_type']['Poet']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Poet']){
					$poetHiddenArr[]=$vArt->artist_id;
					$poetNameArr[$vArt->artist_id]=$vArt->artist_name;
				}*/
				if(($aConfig['artist_type']['Starcast']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Starcast']){
					$starcastHiddenArr[]=$vArt->artist_id;
					$starcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Mimicked Star']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Mimicked Star']){
					$mstarcastHiddenArr[]=$vArt->artist_id;
					$mstarcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
			}
		}
		$singerHidden="";
		if($singerHiddenArr){
			$singerHidden=implode(",",$singerHiddenArr);
		}
		$mdirectorHidden="";
		if($mdirectorHiddenArr){
			$mdirectorHidden=implode(",",$mdirectorHiddenArr);
		}
		$lyricistHidden="";
		if($lyricistHiddenArr){
			$lyricistHidden=implode(",",$lyricistHiddenArr);
		}
		$poetHidden="";
		if($poetHiddenArr){
			$poetHidden=implode(",",$poetHiddenArr);
		}
		$starcastHidden="";
		if($starcastHiddenArr){
			$starcastHidden=implode(",",$starcastHiddenArr);
		}
		$mstarcastHidden="";
		if($mstarcastHiddenArr){
			$mstarcastHidden=implode(",",$mstarcastHiddenArr);
		}
		
		$artistNameArr=array();
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $mArtistArray){
					$artistNameArr[$aData[0]->artist_id]=$mArtistArrayWithId[$aData[0]->artist_id]->artist_name;
			}
		}
		
		$albumSongMapData=$oSong->getAlbumSongMap(array('where'=> " AND song_id=".$id));
		
		$albumHiddenArr=array();
		if($albumSongMapData){
			foreach($albumSongMapData as $album){
				$albumHiddenArr[]=$album->album_id;
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
		
		$tagSongMapData=$oSong->getTagSongMap(array('where'=> " AND song_id=".$id));
		$tagSongMapArr=array();
		if($tagSongMapData){
			foreach($tagSongMapData as $tag){
				$tagSongMapArr[]=$tag->tag_id;
			}
		}
		$data['aContent']= array( 
					'songId'=>$id,
					'songName'=>$aSongData[0]->song_name,
					'status'=>$aSongData[0]->status,
					'isrc' => $aSongData[0]->isrc,
					'languageIds'=>$aSongData[0]->language_id,
					'releaseDate'=>$aSongData[0]->release_date,
					'songDuration' => $aSongData[0]->song_duration,
					'songTempo'=>$aSongData[0]->tempo,
					'subjectParody' => $aSongData[0]->subject_parody,
					'audioFilePath' => $aSongData[0]->audio_file,
					'singerNameArr'=>$singerNameArr,
					'singerId' => $singerHidden,
					'singerNameStr'=>$artistNameStr,
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$artistNameStr,
					'mdirectorNameArr'=>$mdirectorNameArr,
					'mdirectorId' => $mdirectorHidden,
					'mdirectorNameStr'=>$artistNameStr,
					'lyricistNameArr'=>$lyricistNameArr,
					'lyricistId' => $lyricistHidden,
					'lyricistNameStr'=>$artistNameStr,
					'mstarcastNameArr'=>$mstarcastNameArr,
					'mstarcastId' => $mstarcastHidden,
					'mstarcastNameStr'=>$artistNameStr,
					'poetNameArr'=>$poetNameArr,
					'poetId' => $poetHidden,
					'poetNameStr'=>$artistNameStr,
					'albumNameArr'=>$albumNameArr,
					'albumId' => $albumHidden,
					'albumNameStr'=>$albumNameStr,
					'region' => $aSongData[0]->origin_state_id,
					'version'    => $tagSongMapArr,
					'genre'    	=> $tagSongMapArr,
					'mood'    	=>$tagSongMapArr,
					'relationship'  => $tagSongMapArr,
					'raag'    	=> $tagSongMapArr,
					'taal'    	=> $tagSongMapArr,
					'timeofday'  => $tagSongMapArr,
					'religion'   => $tagSongMapArr,
					'saint'    	=> $tagSongMapArr,
					'instrument' => $tagSongMapArr,
					'festival'   => $tagSongMapArr,
					'occasion'   => $tagSongMapArr,
					'grade'		=> 	$aSongData[0]->grade,
					);
	}
}else{
	
	
	/* Lyrics add/edit start */
	if( $do == 'lyrics' ){
		$view = 'song_lyrics_form';
		$songLyrics = '';
		if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
			$songLyrics = $_POST['songLyrics'];
		
			$refferer = cms::sanitizeVariable( $_POST['refferer'] );
			$params = array( 'id'=>$id , 'lyrics'=>$songLyrics );
			$songLyrics = $oSong->saveLyrics( $params );
			/* Write DB Activity Logs */
			#TOOLS::log('song lyrics', $action, '4', $this->user->user_id, "Song, Id: ".(int)$id."" );
			$aLogParam = array(
				'moduleName' => 'song lyrics',
				'action' => "Edit",
				'moduleId' => 4,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Edited song lyrics. (ID-'.(int)$id.')',
				'content_ids' => (int)$id
			);
			TOOLS::writeActivityLog( $aLogParam );

			header("location:".$refferer."&msg=Data saved successfully.");
			
		}else{
			$params = array( 'id'=>$id );
			$songLyrics = $oSong->getLyrics( $params );
		}
		$data['aContent']['songLyrics'] = $songLyrics;
		$data['aError'] = $aError;
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/* Lyrics add/edit end */
	
	/*
	* To display rights popup start	
	*/
	if($do=='rights'){
	
		$view = 'song_rights';
		if(!empty($_POST) && isset($_POST)){
		
		    $territory_arr = array();
			$territory_ex_arr = array();
			
			$songRightId = cms::sanitizeVariable( $_POST['songRightId'] );
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
					'songRightId'=>$songRightId,
					'songId'=>$id,
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
				$mData=$oSong->addSongRights($postData);
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
									'moduleName' => 'song rights',
									'action' => $action,
									'moduleId' => 4,
									'editorId' => $this->user->user_id,
									'remark'	=>	'Edited Song rights information. (ID-'.$id.')',
									'content_ids' => (int)$id
								);
				TOOLS::writeActivityLog( $aLogParam );
								
				//TOOLS::log('song rights', $action, '4', $this->user->user_id, "Song, Id: ".(int)$mData."" );
				//header("location:".$refferer."&msg=Action completed successfully.");
			}
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;			
			
		}else {
		
			$params=array(
					'where' => " AND song_id=".$id,
					);
					
			
			$dataRightsBySongId=$oSong->getRightsBySongId($params);
			$publishingRights = $dataRightsBySongId[0]->publishing_rights;
			$digitalRights = $dataRightsBySongId[0]->digital_rights;

			
			
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
			
		
			if($dataRightsBySongId){
				$edtData=array(
					
						'songId'=>$dataRightsBySongId[0]->song_id,
						'is_owned'=>$dataRightsBySongId[0]->is_owned,
						'banner_id'=>$dataRightsBySongId[0]->banner_id,
						'territory_in'=>$dataRightsBySongId[0]->territory_in,
						'territory_ex'=>$dataRightsBySongId[0]->territory_ex,
						'start_date'=>$dataRightsBySongId[0]->start_date,
						'end_date'=>$dataRightsBySongId[0]->expiry_date,
						'physical_rights'=>$dataRightsBySongId[0]->physical_rights,
						'publishing_rights'=>$pubRightStr,
						'digital_rights'=>$digiRightStr,
						'is_exclusive'=>$dataRightsBySongId[0]->is_exclusive,
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
	
	/*
	* To display song details start	
	*/
	if($do=='details'){
		$view = 'song_details';
		
		$mTags=new tags();
		$vParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1889",
			   );
		$versionList=$mTags->getAllTags($vParams);
		$gParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1688",
			   );
		$genreList=$mTags->getAllTags($gParams);
		$mParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1",
			   );
		$moodList=$mTags->getAllTags($mParams);
		$rParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=16",
			   );
		$relationshipList=$mTags->getAllTags($rParams);
		$rParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1189",
			   );
		$raagList=$mTags->getAllTags($rParams);
		$tParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1383",
			   );
		$taalList=$mTags->getAllTags($tParams);
		$tParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1415",
			   );
		$timeofdayList=$mTags->getAllTags($tParams);
		$iParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1424",
			   );
		$instrumentList=$mTags->getAllTags($iParams);
		$rParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=498",
			   );
		$religionList=$mTags->getAllTags($rParams);
		$sParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=506",
			   );
		$saintList=$mTags->getAllTags($sParams);
		$fParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=29",
			   );
		$festivalList=$mTags->getAllTags($fParams);
		$oParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=487",
			   );
		$occasionList=$mTags->getAllTags($oParams);
		$lParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY language_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1",
			   );
		$oLanguage = new language();
		$languageList=$oLanguage->getAllLanguages($lParams);
		$mRegion=new region();
		$rParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY region_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1",
			   );
		$regionList=$mRegion->getAllRegions($rParams);

		$data['versionList']=$versionList;
		$data['genreList']=$genreList;
		$data['moodList']=$moodList;
		$data['relationshipList']=$relationshipList;
		$data['raagList']=$raagList;
		$data['taalList']=$taalList;
		$data['timeofdayList']=$timeofdayList;
		$data['instrumentList']=$instrumentList;
		$data['religionList']=$religionList;
		$data['saintList']=$saintList;
		$data['festivalList']=$festivalList;
		$data['occasionList']=$occasionList;
		$data['languageList']=$languageList;
		$data['regionList']=$regionList;

		
		/* Get Language Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'where' => ' AND song_id="'.$id.'"', 
				  ); 
		$aSongData = $oSong->getAllSongs( $params );
		
		$artistSongMapData=$oSong->getArtistSongMap(array('where'=> " AND song_id=".$id));

		$artistIdArray=array();
		$artistIdMapArray=array();
		if($artistSongMapData){
			foreach($artistSongMapData as $vMap){
				$artistIdArray[]=$vMap->artist_id;
				$artistIdMapArray[$vMap->artist_id]=$vMap->artist_role;	
			}	
		}
		$artistIdStr="0";
		if($artistIdArray){
			$artistIdStr=implode(",",$artistIdArray);
		}

		$mArtist=new artist();
		$mArtistArray=NULL;
		if($artistIdStr){
			$mArtistArray=$mArtist->getArtistById(array('ids'=>$artistIdStr));
		}
		$artistNameStr="";
		$mArtistArrayWithId=array();
		$singerNameArr=array();
		$starcastNameArr=array();
		$mstarcastNameArr=array();
		$mdirectorNameArr=array();
		$lyricistNameArr=array();
		$poetNameArr=array(); 
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $vArt){
				$mArtistArrayWithId[$vArt->artist_id]=$vArt;
				$artistNameStr.=$vArt->artist_id.":".$vArt->artist_name."|";
				if(($aConfig['artist_type']['Singer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Singer']){
					$singerHiddenArr[]=$vArt->artist_id;
					$singerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Music Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Music Director']){
					$mdirectorHiddenArr[]=$vArt->artist_id;
					$mdirectorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Lyricist']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Lyricist']){
					$lyricistHiddenArr[]=$vArt->artist_id;
					$lyricistNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				/*if(($aConfig['artist_type']['Poet']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Poet']){
					$poetHiddenArr[]=$vArt->artist_id;
					$poetNameArr[$vArt->artist_id]=$vArt->artist_name;
				}*/
				if(($aConfig['artist_type']['Starcast']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Starcast']){
					$starcastHiddenArr[]=$vArt->artist_id;
					$starcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Mimicked Star']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Mimicked Star']){
					$mstarcastHiddenArr[]=$vArt->artist_id;
					$mstarcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
			}
		}
		$singerHidden="";
		if($singerHiddenArr){
			$singerHidden=implode(",",$singerHiddenArr);
		}
		$mdirectorHidden="";
		if($mdirectorHiddenArr){
			$mdirectorHidden=implode(",",$mdirectorHiddenArr);
		}
		$lyricistHidden="";
		if($lyricistHiddenArr){
			$lyricistHidden=implode(",",$lyricistHiddenArr);
		}
		$poetHidden="";
		if($poetHiddenArr){
			$poetHidden=implode(",",$poetHiddenArr);
		}
		$starcastHidden="";
		if($starcastHiddenArr){
			$starcastHidden=implode(",",$starcastHiddenArr);
		}
		$mstarcastHidden="";
		if($mstarcastHiddenArr){
			$mstarcastHidden=implode(",",$mstarcastHiddenArr);
		}
		
		$artistNameArr=array();
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $mArtistArray){
					$artistNameArr[$aData[0]->artist_id]=$mArtistArrayWithId[$aData[0]->artist_id]->artist_name;
			}
		}
		
		$albumSongMapData=$oSong->getAlbumSongMap(array('where'=> " AND song_id=".$id));
		
		$albumHiddenArr=array();
		if($albumSongMapData){
			foreach($albumSongMapData as $album){
				$albumHiddenArr[]=$album->album_id;
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
		
		$tagSongMapData=$oSong->getTagSongMap(array('where'=> " AND song_id=".$id));
		$tagSongMapArr=array();
		if($tagSongMapData){
			foreach($tagSongMapData as $tag){
				$tagSongMapArr[]=$tag->tag_id;
			}
		}
		$data['aContent']= array( 
					'songId'=>$id,
					'songName'=>$aSongData[0]->song_name,
					'status'=>$aSongData[0]->status,
					'isrc' => $aSongData[0]->isrc,
					'languageIds'=>$aSongData[0]->language_id,
					'releaseDate'=>$aSongData[0]->release_date,
					'songDuration' => $aSongData[0]->song_duration,
					'songTempo'=>$aSongData[0]->tempo,
					'subjectParody' => $aSongData[0]->subject_parody,
					'audioFilePath' => $aSongData[0]->audio_file,
					'singerNameArr'=>$singerNameArr,
					'singerId' => $singerHidden,
					'singerNameStr'=>$artistNameStr,
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$artistNameStr,
					'mdirectorNameArr'=>$mdirectorNameArr,
					'mdirectorId' => $mdirectorHidden,
					'mdirectorNameStr'=>$artistNameStr,
					'lyricistNameArr'=>$lyricistNameArr,
					'lyricistId' => $lyricistHidden,
					'lyricistNameStr'=>$artistNameStr,
					'mstarcastNameArr'=>$mstarcastNameArr,
					'mstarcastId' => $mstarcastHidden,
					'mstarcastNameStr'=>$artistNameStr,
					'poetNameArr'=>$poetNameArr,
					'poetId' => $poetHidden,
					'poetNameStr'=>$artistNameStr,
					'albumNameArr'=>$albumNameArr,
					'albumId' => $albumHidden,
					'albumNameStr'=>$albumNameStr,
					'region' => $aSongData[0]->origin_state_id,
					'version'    => $tagSongMapArr,
					'genre'    	=> $tagSongMapArr,
					'mood'    	=>$tagSongMapArr,
					'relationship'  => $tagSongMapArr,
					'raag'    	=> $tagSongMapArr,
					'taal'    	=> $tagSongMapArr,
					'timeofday'  => $tagSongMapArr,
					'religion'   => $tagSongMapArr,
					'saint'    	=> $tagSongMapArr,
					'instrument' => $tagSongMapArr,
					'festival'   => $tagSongMapArr,
					'occasion'   => $tagSongMapArr,
					'grade'		=> 	$aSongData[0]->grade,
					);
		/* render view */
		$oCms->view( $view, $data );
		exit;
	
	}else if( $do == 'showedits' ){
		/* List all available Edits for this song start */
		$view = 'song_edits';
		$lisData = $oSong->getSongEdits( $id );
		$data['aContent']	 	 = $lisData;
		$data['aEditConfig']	 = $oSong->getSongEditsConfig();
			
		/* render view */
		$oCms->view( $view, $data );
		exit;
		/* List all available Edits for this song end */
	}else if( $do == 'crbt' ){
		$fieldArr=$oSong->getFieldSongCrbt();
		$data['aField']=$fieldArr;
		$config_id=(int)$_GET['config_id'];
		$song_name=cms::sanitizeVariable($_GET['song_name']);
		/* List all available crbt for this song start */
		if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
			unset($fieldArr[0]);unset($fieldArr[1]);
			$keyval="";
			foreach($fieldArr as $kk=>$vv){
				$operatorArray[$vv->Field]=cms::sanitizeVariable($_POST[$vv->Field]);
				$keyval .= $vv->Field."='".cms::sanitizeVariable($_POST[$vv->Field])."',";
			}
			$keyval=trim($keyval);
			$valStr=implode("','",$operatorArray);
			$fieldStr=implode(",",array_keys($operatorArray));
			$params = array( 'song_id'=>$id , 'song_edit_id'=>$config_id, 'valStr'=>$valStr, 'fieldStr'=>$fieldStr, 'keyval'=>$keyval );
			$crbts=$oSong->saveCrbts($params);
			$aLogParam = array(
				'moduleName' => 'song',
				'action' => "Edit",
				'moduleId' => 4,
				'editorId' => $this->user->user_id,
				'remark'	=> 'CRBT added to  song. (ID-'.$id.')',
				'content_ids' => $id
			);
			TOOLS::writeActivityLog( $aLogParam );
			/* Saved */
			$data['aSuccess'][] = 'Data saved successfully.';

		}
		$view = 'song_crbt';
		$params = array(
					'limit'	  => 100,  
					'start'   => 0,  
					'where'	  => ' AND song_id='.$id.' AND song_edit_id='.$config_id,
				  );
		$lisData = $oSong->getAllSongsCrbt( $params );
		$data['aContent']	 	 = $lisData;
		$data['aSongName']	 = cms::sanitizeVariable( $song_name );
		$data['aPath']	 = cms::sanitizeVariable( $_GET['path'] );	
		/* render view */
		$oCms->view( $view, $data );
		exit;
		/* List all available crbt for this song end */
	}else if($do=="depldetl"){
			$view = 'song-deployment-details';
			$oDeployment=new deployment();
			$where = ' AND dd.content_id = "'.$oMysqli->secure($id).'"';
			$limit	= 100;
			$start	= 0;
			$params = array(
						'limit'	  => $limit,  
						'orderby' => '  ORDER BY dd.id asc',  
						'start'   => $start,  
						'where'	  => $where,
					  );
			$data['aContent'] = $oDeployment->getDeploymentsReport( $params );
			$oCms->view( $view, $data );
			exit;			
	}
	/*
	* To display song details end	
	*/
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
				$data = $oSong->doMultiAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'song',
						'action' => $contentAction,
						'moduleId' => 4,
						'editorId' => $this->user->user_id,
						'content_ids' => $_POST['select_ids']
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				//TOOLS::log('song', $contentAction, '4', (int)$this->user->user_id, "Song, Ids: '".implode("','", $_POST['select_ids'])."' " );
				$aLogParam = array(
					'moduleName' => 'song',
					'action' => $contentAction,
					'moduleId' => 4,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' song.',
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

			if($contentModel=='song' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oSong->doAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'song',
						'action' => $contentAction,
						'moduleId' => 4,
						'editorId' => $this->user->user_id,
						'content_ids' => $contentId
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('song', $contentAction, '4', (int)$this->user->user_id, "Song, Id: ".$contentId."" );
				$aLogParam = array(
					'moduleName' => 'song',
					'action' => $contentAction,
					'moduleId' => 4,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' song. (ID-'.$contentId.')',
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

	$lisData = getlist( $oSong ,$this);
	$data['qcPendingTotal']	 = $lisData['qcPendingTotal'];
	$data['legalPendingTotal']	 = $lisData['legalPendingTotal'];	
	$data['publishPendingTotal']	 = $lisData['publishPendingTotal'];		
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
	$data['aEditConfig']	 = $lisData['aEditConfig'];

}

function getlist( $oSong,$users=NULL){
	global $oMysqli;

	$oTags = new tags();
	$aTags = $oTags->getAllTags( array('onlyParent'=>true,'where' => " AND tag_access&2=2") );
	/* Search Param start */
	$srcSong = cms::sanitizeVariable( $_GET['srcSong'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcIsrc = cms::sanitizeVariable( $_GET['srcIsrc'] );
	$srcSrtDate = cms::sanitizeVariable( $_GET['srcSrtDate'] ); 
	$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
	$srcLang = cms::sanitizeVariable( $_GET['srcLang'] );
	$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
	$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
	$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
	$srcRtTag = cms::sanitizeVariable( $_GET['srcRtTag'] );
	$srcSongId = cms::sanitizeVariable( $_GET['srcSongId'] );
	$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
	$autosuggestalbum_hddn = cms::sanitizeVariable( $_GET['autosuggestalbum_hddn'] );
	$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
	$autosuggestartist_hddn = cms::sanitizeVariable( $_GET['autosuggestartist_hddn'] );
	$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
	$srcTxtTag = cms::sanitizeVariable( $_GET['srcTxtTag'] );
	$autosuggesttag_hddn = cms::sanitizeVariable( $_GET['autosuggesttag_hddn'] );
	$srcSongEditId = cms::sanitizeVariable( $_GET['srcSongEditId'] );
		
	$where		 = '';
	if( $srcSong != '' ){
		$where .= ' AND sm.song_name like "%'.$oMysqli->secure($srcSong).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND sm.status ="'.$srcCtypeVal.'" ';
	}
	if( $srcIsrc != '' ){
		$where .= ' AND sm.isrc="'.$oMysqli->secure($srcIsrc).'"';
	}
	if( $srcSongId != '' ){
		$where .= ' AND sm.song_id="'.$oMysqli->secure($srcSongId).'"';
	}
	if( $srcLang != '' ){
		$where .= ' AND sm.language_id="'.$oMysqli->secure($srcLang).'"';
	}
	if( $srcSrtDate != '' && $srcEndDate != ''  ){
		$where .= ' AND sm.release_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcSrtDate != ''){
		$where .= ' AND sm.release_date >= "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcEndDate != ''){
		$where .= ' AND sm.release_date <= "'.$oMysqli->secure($srcEndDate).'"';
	}
	if( $srcAlbum != '' &&  $autosuggestalbum_hddn !=""){
		$oSong = new song();
		$param = array( "where" => " AND album_id =".$autosuggestalbum_hddn );
		$songIdList = $oSong->getAlbumSongMap($param);
		if($songIdList){
			$songIdListArr=NULL;
			foreach($songIdList as $songVal){		
				$songIdListArr[]= $songVal->song_id;
			}
			if(!empty($songIdListArr)){
				$songIdListStr = implode(",",$songIdListArr);
				$where .= ' AND sm.song_id IN ('.$songIdListStr.')';	
			}
		}else{
			$where .= ' AND sm.song_id =0';
		}
	}
	if( $srcArtist != '' && $autosuggestartist_hddn !=""){
		$oSong = new song();
		$param = array( "where" => " AND artist_id =".$autosuggestartist_hddn );
		$songIdList = $oSong->getArtistSongMap($param);
		if($songIdList){
			$songIdListArr=NULL;
			foreach($songIdList as $songVal){		
				$songIdListArr[]= $songVal->song_id;
			}
			if(!empty($songIdListArr)){
				$songIdListStr = implode(",",$songIdListArr);
				$where .= ' AND sm.song_id IN ('.$songIdListStr.')';	
			}
		}else{
			$where .= ' AND sm.song_id =0';
		}
	}
	if( $srcTag != '' &&  $autosuggesttag_hddn !=""){
		$param = array( "where" => " AND tag_id =".$autosuggesttag_hddn );
		$songIdList = $oSong->getTagSongMap($param);
		if($songIdList){
			$songIdListArr=NULL;
			foreach($songIdList as $songVal){		
				$songIdListArr[]= $songVal->song_id;
			}
			if(!empty($songIdListArr)){
				$songIdListStr = implode(",",$songIdListArr);
				$where .= ' AND sm.song_id IN ('.$songIdListStr.')';	
			}
		}else{
			$where .= ' AND sm.song_id = 0';
		}
	}
	
	if($srcSongEditId>0 || $srcSongEditId!=""){
		$oDeployment=new deployment();
		$getSongEditConfigRel=$oDeployment->getSongEditConfigRel(array("where" => " AND config_id=".$srcSongEditId." AND status=1"));	
		$songIdArr=array();
		if(sizeof($getSongEditConfigRel)>0){
			foreach($getSongEditConfigRel as $sc){
				$songIdArr[]=$sc->song_id;
			}
			if(sizeof($songIdArr)>0){
				$songIdStr = implode(",",$songIdArr);
				$where .= ' AND sm.song_id IN ('.$songIdStr.')';
			}
		}else{
			$where .= ' AND sm.song_id =0';
		}
	}

	$oLanguage = new language();
	$lParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY language_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
	$languageList=$oLanguage->getAllLanguages($lParams);
		
	$data['aSearch']['srcSong'] = $srcSong;
	$data['aSearch']['srcCType'] 	= $srcCType;
	$data['aSearch']['srcIsrc'] 	= $srcIsrc;
	$data['aSearch']['srcSongId'] 	= $srcSongId;
	$data['aSearch']['srcLang'] 	= $srcLang;
	$data['aSearch']['languageList'] 	= $languageList;	
	$data['aSearch']['srcSrtDate'] 	= $srcSrtDate;
	$data['aSearch']['srcEndDate'] 	= $srcEndDate;
	$data['aSearch']['srcAlbum'] 	= $srcAlbum;
	$data['aSearch']['autosuggestalbum_hddn'] 	= $autosuggestalbum_hddn;
	$data['aSearch']['srcArtist'] 	= $srcArtist;
	$data['aSearch']['autosuggestartist_hddn'] 	= $autosuggestartist_hddn;
	$data['aSearch']['tagsList'] 	= $aTags;
	$data['aSearch']['srcTag'] 	= $srcTag;
	$data['aSearch']['srcRtTag'] 	= $srcRtTag;
	$data['aSearch']['srcTxtTag'] 	= $srcTxtTag;
	$data['aSearch']['autosuggesttag_hddn'] 	= $autosuggesttag_hddn;
	$data['aSearch']['srcSongEditId'] 	= $srcSongEditId;
	
	$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'song_id', 'default_sort'=>'DESC', 'field'=>$_GET['field'] ) );
	/* Search Param end */

	if($_GET['do']=="qclist" && $users->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
		$where=" AND sm.status=0";
	}
	if($_GET['do']=="legallist" && $users->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		$where=" AND sm.status=2";
	}
	if($_GET['do']=="publishlist" && $users->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
		$where=" AND sm.status=3";
	}	
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
		$qcparams=array("where" =>" AND status=0");
		$qcPendingTotal=$oSong->getTotalCount( $qcparams );
		$data['qcPendingTotal'] 	= $qcPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		$qcparams=array("where" =>" AND status=2");
		$legalPendingTotal=$oSong->getTotalCount( $qcparams );
		$data['legalPendingTotal'] 	= $legalPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
		$qcparams=array("where" =>" AND status=3");
		$publishPendingTotal=$oSong->getTotalCount( $qcparams );
		$data['publishPendingTotal'] 	= $publishPendingTotal;
	}
	
	/* Show Song as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => $orderBy,  
				'start'   => $start,  
				'where'	  => $where,
				'join'    => 1,
			  );
	
	$data['aContent'] = $oSong->getAllSongs( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oSong->getTotalCount( $params );
	#echo ' >>>> '.$oSong->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "song?action=view&srcSong=$srcSong&srcCType=$srcCType&srcIsrc=$srcIsrc&srcSrtDate=$srcSrtDate&srcEndDate=$srcEndDate&srcLang=$srcLang&srcAlbum=$srcAlbum&autosuggestalbum_hddn=$autosuggestalbum_hddn&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcTag=$srcTag&srcRtTag=$srcRtTag&autosuggesttag_hddn=$autosuggesttag_hddn&srcSongId=$srcSongId&submitBtn=Search&srcSongEditId=$srcSongEditId&sort=".$_GET['sort']."&field=".$_GET['field']."&do=".$_GET['do']."&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	$data['aEditConfig']	 = $oSong->getSongEditsConfig();
	#print_r($data['aEditConfig']);
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );