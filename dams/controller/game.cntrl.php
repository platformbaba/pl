<?php    //game     
set_time_limit(0);
ini_set('memory_limit','5120M');
$view = 'game_list';
$oGame = new game();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'legal') );
$id = (int)$_GET['id']; 

if( $action == 'add' || $action == 'edit' ){
	
	$oLanguage = new language();
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
	$view = 'game_form';
	$id = (int)$_GET['id']; 

	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$gameName	=	cms::sanitizeVariable($_POST['gameName']);
		$status	=	cms::sanitizeVariable($_POST['status']);
		$releaseDate=	cms::sanitizeVariable($_POST['releaseDate']);
		$gameFilePath = cms::sanitizeVariable($_POST['gameFilePath']);
		$gameDuration=	(int)$_POST['gameDuration'];
		$gameTempo	=	cms::sanitizeVariable($_POST['gameTempo']);
		$subjectParody=	cms::sanitizeVariable($_POST['subjectParody']);
		$region		=	cms::sanitizeVariable($_POST['region']);
		$languageIds=	cms::sanitizeVariable($_POST['languageIds']);
		$version    = $_POST['version'];
		$genre    	= $_POST['genre'];
		$mood    	= $_POST['mood'];
		$relationship    = $_POST['relationship'];
	//	$raag    	= $_POST['raag'];
		$raag    	= '';
	//	$taal    	= $_POST['taal'];
		$taal    	= '';
		$timeofday  = $_POST['timeofday'];
		$religion   = $_POST['religion'];
		$saint    	= $_POST['saint'];
		$instrument = $_POST['instrument'];
		$festival   = $_POST['festival'];
		$occasion   = $_POST['occasion'];
		$oPicImageId=(int)$_POST['oPicImageId'];
		$picname =	cms::sanitizeVariable($_POST['oPic']);		
		$singerHidden = trim($_POST['singerHidden'],",");
		$directorHidden = trim($_POST['directorHidden'],",");
		$lyricistHidden = trim($_POST['lyricistHidden'],",");
		//$poetHidden   = trim($_POST['poetHidden'],",");
		$poetHidden   = '';
		$starcastHidden   = trim($_POST['starcastHidden'],",");
		$mstarcastHidden   = trim($_POST['mstarcastHidden'],",");
		$albumHidden   = trim($_POST['albumHidden'],",");
		$songHidden     = trim($_POST['songHidden'],",");
		$rawFileVal = 	cms::sanitizeVariable($_POST['rawFileVal']);
						
		$singerHiddenArr=array();
		if($singerHidden){
			$singerHiddenArr=explode(",",$singerHidden);
		}
		$lyricistHiddenArr=array();
		if($lyricistHidden){
			$lyricistHiddenArr=explode(",",$lyricistHidden);
		}
		$directorHiddenArr=array();
		if($directorHidden){
			$directorHiddenArr=explode(",",$directorHidden);
		}
		$poetHiddenArr=array();
		/*if($poetHidden){
			$poetHiddenArr=explode(",",$poetHidden);
		}*/
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
		$songHiddenArr=array();
		if($songHidden){
			$songHiddenArr=explode(",",$songHidden);
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

		$directorHiddensData = explode('|',trim($_POST['directorHiddensData'],"|"));
		$directorNameArr=array();
		if($directorHiddensData){
			foreach($directorHiddensData as $directorHiddensData){
				$directorNameData = explode(":",$directorHiddensData);
				if($directorNameData[0] && in_array($directorNameData[0],$directorHiddenArr)){
					$directorNameArr[$directorNameData[0]]=$directorNameData[1];
					$artistRoleArray[$directorNameData[0]]=$aConfig['artist_type']['Director'];					
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

		/*$poetHiddensData = explode('|',trim($_POST['poetHiddensData'],"|"));
		$poetNameArr=array();
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
				if(in_array($kR,$directorHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Director'];
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
				/*if(in_array($kR,$poetHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Poet'];
				}*/
			}
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
			$aError[]="Please Select Album.";
		}
		
		if($releaseDate==''){
			$aError[]="Please Select Release Date.";
		}
		if($languageIds==''){
			$aError[]="Please Select Language.";
		}		
		if($gameName==""){
			$aError[]="Enter Game Name.";
		}
		if($gameDuration==0){
			$aError[]="Enter Game Duration.";
		}
		$rF=0;
		if($rawFileVal){
			$pathinfo=pathinfo($rawFileVal);
			$fExt=$pathinfo['extension'];
			if(!in_array($fExt,array('mov','avi'))){ //'3gp','mp4','wav','flv'
				$aError[]="Browsed file is not of specified extension.";
			}else{
				$rF=1;
			}
		}
		/*if($gameFilePath==""){
			$aError[]="Please enter Audio File Path or Upload Audio File.";
		}*/
		if(empty($starcastHiddenArr)){
			$aError[]="Please Select Starcast.";
		}
		if(empty($singerHiddenArr)){
			$aError[]="Please Select Singer.";
		}
		if(empty($directorHiddenArr)){
			$aError[]="Please Select Director.";
		}
		if(empty($lyricistHiddenArr)){
			$aError[]="Please Select Lyricist.";
		}
/*		if(empty($version)){
			$aError[]="Please Select Version.";
		}
		if(empty($genre)){
			$aError[]="Please Select Genre.";
		}
		if(empty($mood)){
			$aError[]="Please Select Mood.";
		}
		if($region==0){
			$aError[]="Please Select Region.";
		}*/
		$postData=array(
					'gameId'=>$id,
					'gameName'=>$gameName,
					'status'=>$status,
					'languageIds'=>$languageIds,
					'releaseDate'=>$releaseDate,
					'gameDuration' => $gameDuration,
					'gameTempo'=>$gameTempo,
					'subjectParody' => $subjectParody,
					#'gameFilePath' => $gameFilePath,
					'singerNameArr'=>$singerNameArr,
					'singerId' => $singerHidden,
					'singerNameStr'=>$_POST['singerHiddensData'],
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$_POST['starcastHiddensData'],
					'directorNameArr'=>$directorNameArr,
					'directorId' => $directorHidden,
					'directorNameStr'=>$_POST['directorHiddensData'],
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
					'songNameArr'=>$songNameArr,
					'songId' => $songHidden,
					'songNameStr'=>$_POST['songHiddensData'],
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
					'image'      => $picname,
					);

		if(empty($aError)){ 
			$aData = $oGame->saveGame( $postData );
			$logMsg="Created game.";
			if($id){
				$aData=$id;
				$logMsg="Edited game information.";
			}
			if($aData){
				if($rF){
					$fileToSave=tools::getGamePathByTitle($gameName,$fExt,$aData);
					$destinatonFile=MEDIA_SERVERPATH_VIDEORAW."/".$fileToSave;
					tools::createDir($destinatonFile);
					if(copy($rawFileVal,$destinatonFile)){
						$uData=$oGame->upGameFilePath(array('gameId'=>(int)$aData,'gameFilePath'=>$fileToSave));	
						#unlink($rawFileVal);
					}/*else{print_r(error_get_last());
						$aError[]="Failed to copy browsed file.";
					}*/
				}
				if( $gameFilePath != '' ){
					$pathInfo = pathinfo(MEDIA_SEVERPATH_TEMP.$gameFilePath);
					$fExt=$pathInfo['extension'];
					$fileToSave=tools::getGamePathByTitle($gameName,$fExt,$aData);
					$sourceFile = MEDIA_SEVERPATH_TEMP.$gameFilePath;
					$newFile 	= MEDIA_SERVERPATH_VIDEORAW.$fileToSave;
					TOOLS::createDir( $newFile );
					if(copy($sourceFile, $newFile)){
						$uData=$oGame->upGameFilePath(array('gameId'=>(int)$aData,'gameFilePath'=>$fileToSave));	
						unlink($sourceFile);
					}
				}
				if($artistRoleKeyArray){ 
					$oData=$oGame->mapArtistGame(array('gameId'=>(int)$aData,'artistRoleKeyArray'=>$artistRoleKeyArray));					
				}
				$tagIds=array_merge((array)$version,(array)$genre,(array)$mood,(array)$relationship,(array)$raag,(array)$taal,(array)$timeofday,(array)$religion,(array)$saint,(array)$instrument,(array)$festival,(array)$occasion);
				if($tagIds){
					$tData=$oGame->mapTagGame(array('gameId'=>(int)$aData,'tagIds'=>$tagIds));
				}
				if($albumHiddenArr){
					$lData=$oGame->mapAlbumGame(array('gameId'=>(int)$aData,'albumIds'=>$albumHiddenArr));
				}
				if($songNameArr){
					$sData=$oGame->mapSongGame(array('gameId'=>(int)$aData,'songKeyArray'=>$songHiddenArr));
				}
				if($oPicImageId){
					$oImage = new image();
					$oData=$oImage->mapGameImage(array('imageId'=>$oPicImageId,'gameIds'=>array($aData)));
				}	
			}
			
			/* Send Mail Notification start*/
			if($action == 'add'){
				$oMailParam = array(
						'moduleName' => 'game',
						'action' => $action,
						'moduleId' => 15,
						'editorId' => $this->user->user_id,
						'content_ids' => $aData
					);
				$oNotification->sendNotification( $oMailParam );
				
			}
			/* Send Mail Notification end*/
			
			/* Write DB Activity Logs */
			#TOOLS::log('game', $action, '15', (int)$this->user->user_id, "Game, Id: ".$aData."" );
			$aLogParam = array(
				'moduleName' => 'game',
				'action' => $action,
				'moduleId' => 15,
				'editorId' => $this->user->user_id,
				'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
				'content_ids' => (int)$aData
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'game?msg=Data saved successfully');exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
	if($id > 0){
		/* Get Language Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'where' => ' AND game_id="'.$id.'"', 
				  ); 
		$aGameData = $oGame->getAllGames( $params );
		
		$artistGameMapData=$oGame->getArtistGameMap(array('where'=> " AND game_id=".$id));

		$artistIdArray=array();
		$artistIdMapArray=array();
		if($artistGameMapData){
			foreach($artistGameMapData as $vMap){
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
		$directorNameArr=array();
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
				if(($aConfig['artist_type']['Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Director']){
					$directorHiddenArr[]=$vArt->artist_id;
					$directorNameArr[$vArt->artist_id]=$vArt->artist_name;
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
		$directorHidden="";
		if($directorHiddenArr){
			$directorHidden=implode(",",$directorHiddenArr);
		}
		$lyricistHidden="";
		if($lyricistHiddenArr){
			$lyricistHidden=implode(",",$lyricistHiddenArr);
		}
		$poetHidden="";
		/*if($poetHiddenArr){
			$poetHidden=implode(",",$poetHiddenArr);
		}*/
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
		
		$albumGameMapData=$oGame->getAlbumGameMap(array('where'=> " AND game_id=".$id));
		
		$albumHiddenArr=array();
		if($albumGameMapData){
			foreach($albumGameMapData as $album){
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
				$songGameMapData=$oGame->getSongGameMap(array('where'=> " AND game_id=".$id));
		$songHiddenArr=array();
		if($songGameMapData){
			foreach($songGameMapData as $song){
				$songHiddenArr[]=$song->song_id;
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
			foreach($songData as $aD){
				$songNameStr.=$aD->song_id.":".$aD->song_name."|";
				$songHiddenArr[]=$aD->song_id;
				$songNameArr[$aD->song_id]=$aD->song_name;
			}	
		}

		$tagGameMapData=$oGame->getTagGameMap(array('where'=> " AND game_id=".$id));
		$tagGameMapArr=array();
		if($tagGameMapData){
			foreach($tagGameMapData as $tag){
				$tagGameMapArr[]=$tag->tag_id;
			}
		}
		$data['aContent']= array( 
					'gameId'=>$id,
					'gameName'=>$aGameData[0]->game_name,
					'status'=>$aGameData[0]->status,
					'languageIds'=>$aGameData[0]->language_id,
					'releaseDate'=>$aGameData[0]->release_date,
					'gameDuration' => $aGameData[0]->game_duration,
					'gameTempo'=>$aGameData[0]->tempo,
					'subjectParody' => $aGameData[0]->subject_parody,
					'gameFilePath' => $aGameData[0]->game_file,
					'singerNameArr'=>$singerNameArr,
					'singerId' => $singerHidden,
					'singerNameStr'=>$artistNameStr,
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$artistNameStr,
					'directorNameArr'=>$directorNameArr,
					'directorId' => $directorHidden,
					'directorNameStr'=>$artistNameStr,
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
					'songNameArr'=>$songNameArr,
					'songId' => $songHidden,
					'songNameStr'=>$songNameStr,
					'region' => $aGameData[0]->origin_state_id,
					'version'    => $tagGameMapArr,
					'genre'    	=> $tagGameMapArr,
					'mood'    	=>$tagGameMapArr,
					'relationship'  => $tagGameMapArr,
					'raag'    	 => $tagGameMapArr,
					'taal'    	 => $tagGameMapArr,
					'timeofday'  => $tagGameMapArr,
					'religion'   => $tagGameMapArr,
					'saint'    	 => $tagGameMapArr,
					'instrument' => $tagGameMapArr,
					'festival'   => $tagGameMapArr,
					'occasion'   => $tagGameMapArr,
					'image'      => $aGameData[0]->image,
					);
	}
}else{
	if( $do == 'showedits' ){
		/* List all available Edits for this game start */
		$view = 'game_edits';
		$lisData = $oGame->getGameEdits( $id );
		$data['aContent']	 	 = $lisData;
		$data['aEditConfig']	 = $oGame->getGameEditsConfig();
		/* render view */
		$oCms->view( $view, $data );
		exit;
		/* List all available Edits for this game end */
	}
	/*
	* To display game details start	
	*/
	/*
	* To display rights popup start	
	*/
	if($do=='rights'){
	
		$view = 'game_rights';
		if(!empty($_POST) && isset($_POST)){
		
		    $territory_arr = array();
			$territory_ex_arr = array();
			
			$gameRightId = cms::sanitizeVariable( $_POST['gameRightId'] );
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
					'gameRightId'=>$gameRightId,
					'gameId'=>$id,
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
				$mData=$oGame->addGameRights($postData);
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
									'moduleName' => 'game rights',
									'action' => $action,
									'moduleId' => 15,
									'editorId' => $this->user->user_id,
									'remark'	=>	'Edited Game rights information. (ID-'.$id.')',
									'content_ids' => (int)$id
								);
				TOOLS::writeActivityLog( $aLogParam );
								
				//TOOLS::log('game rights', $action, '14', $this->user->user_id, "Game, Id: ".(int)$mData."" );
				//header("location:".$refferer."&msg=Action completed successfully.");
			}
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;			
			
		}else {
		
			$params=array(
					'where' => " AND game_id=".$id,
					);
					
			
			$dataRightsByGameId=$oGame->getRightsByGameId($params);
			$publishingRights = $dataRightsByGameId[0]->publishing_rights;
			$digitalRights = $dataRightsByGameId[0]->digital_rights;

			
			
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
			
		
			if($dataRightsByGameId){
				$edtData=array(
					
						'gameId'=>$dataRightsByGameId[0]->game_id,
						'is_owned'=>$dataRightsByGameId[0]->is_owned,
						'banner_id'=>$dataRightsByGameId[0]->banner_id,
						'territory_in'=>$dataRightsByGameId[0]->territory_in,
						'territory_ex'=>$dataRightsByGameId[0]->territory_ex,
						'start_date'=>$dataRightsByGameId[0]->start_date,
						'end_date'=>$dataRightsByGameId[0]->expiry_date,
						'physical_rights'=>$dataRightsByGameId[0]->physical_rights,
						'publishing_rights'=>$pubRightStr,
						'digital_rights'=>$digiRightStr,
						'is_exclusive'=>$dataRightsByGameId[0]->is_exclusive,
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
	* To display game details start	
	*/
	
	if($do=='details'){
		$view = 'game_details';
		
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
		/*$rParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1189",
			   );
		$raagList=$mTags->getAllTags($rParams);*/
		$raagList = '';
		
		/*$tParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY tag_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1 AND parent_tag_id=1383",
			   );
		$taalList=$mTags->getAllTags($tParams);*/
		
		$taalList= '';
		
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
					'where' => ' AND game_id="'.$id.'"', 
				  ); 
		$aGameData = $oGame->getAllGames( $params );
		
		$artistGameMapData=$oGame->getArtistGameMap(array('where'=> " AND game_id=".$id));

		$artistIdArray=array();
		$artistIdMapArray=array();
		if($artistGameMapData){
			foreach($artistGameMapData as $vMap){
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
		$directorNameArr=array();
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
				if(($aConfig['artist_type']['Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Director']){
					$directorHiddenArr[]=$vArt->artist_id;
					$directorNameArr[$vArt->artist_id]=$vArt->artist_name;
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
		$directorHidden="";
		if($directorHiddenArr){
			$directorHidden=implode(",",$directorHiddenArr);
		}
		$lyricistHidden="";
		if($lyricistHiddenArr){
			$lyricistHidden=implode(",",$lyricistHiddenArr);
		}
		$poetHidden="";
		/*if($poetHiddenArr){
			$poetHidden=implode(",",$poetHiddenArr);
		}*/
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
		
		$albumGameMapData=$oGame->getAlbumGameMap(array('where'=> " AND game_id=".$id));
		
		$albumHiddenArr=array();
		if($albumGameMapData){
			foreach($albumGameMapData as $album){
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
		
		$songGameMapData=$oGame->getSongGameMap(array('where'=> " AND game_id=".$id));
		$songHiddenArr=array();
		if($songGameMapData){
			foreach($songGameMapData as $song){
				$songHiddenArr[]=$song->song_id;
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
			foreach($songData as $aD){
				$songNameStr.=$aD->song_id.":".$aD->song_name."|";
				$songHiddenArr[]=$aD->song_id;
				$songNameArr[$aD->song_id]=$aD->song_name;
			}	
		}
		
		$tagGameMapData=$oGame->getTagGameMap(array('where'=> " AND game_id=".$id));
		$tagGameMapArr=array();
		if($tagGameMapData){
			foreach($tagGameMapData as $tag){
				$tagGameMapArr[]=$tag->tag_id;
			}
		}
		$data['aContent']= array( 
					'gameId'=>$id,
					'gameName'=>$aGameData[0]->game_name,
					'status'=>$aGameData[0]->status,
					'languageIds'=>$aGameData[0]->language_id,
					'releaseDate'=>$aGameData[0]->release_date,
					'gameDuration' => $aGameData[0]->game_duration,
					'gameTempo'=>$aGameData[0]->tempo,
					'subjectParody' => $aGameData[0]->subject_parody,
					'gameFilePath' => $aGameData[0]->game_file,
					'singerNameArr'=>$singerNameArr,
					'singerId' => $singerHidden,
					'singerNameStr'=>$artistNameStr,
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$artistNameStr,
					'directorNameArr'=>$directorNameArr,
					'directorId' => $directorHidden,
					'directorNameStr'=>$artistNameStr,
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
					'songNameArr'=>$songNameArr,
					'songId' => $songHidden,
					'songNameStr'=>$songNameStr,
					'region' => $aGameData[0]->origin_state_id,
					'version'    => $tagGameMapArr,
					'genre'    	=> $tagGameMapArr,
					'mood'    	=>$tagGameMapArr,
					'relationship'  => $tagGameMapArr,
					'raag'    	=> $tagGameMapArr,
					'taal'    	=> $tagGameMapArr,
					'timeofday'  => $tagGameMapArr,
					'religion'   => $tagGameMapArr,
					'saint'    	=> $tagGameMapArr,
					'instrument' => $tagGameMapArr,
					'festival'   => $tagGameMapArr,
					'occasion'   => $tagGameMapArr,
					'image' => $aGameData[0]->image,
					);
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display game details start	
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
				$data = $oGame->doMultiAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'game',
						'action' => $contentAction,
						'moduleId' => 15,
						'editorId' => $this->user->user_id,
						'content_ids' => $_POST['select_ids']
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('game', $contentAction, '4', (int)$this->user->user_id, "Game, Ids: '".implode("','", $_POST['select_ids'])."' " );
				$aLogParam = array(
					'moduleName' => 'game',
					'action' => $contentAction,
					'moduleId' => 15,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' game.',
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

			if($contentModel=='game' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oGame->doAction( $params );
				
				/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'game',
						'action' => $contentAction,
						'moduleId' => 15,
						'editorId' => $this->user->user_id,
						'content_ids' => $contentId
					);
					$oNotification->sendNotification( $oMailParam );
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('game', $contentAction, '4', (int)$this->user->user_id, "Game, Id: ".$contentId."" );
				$aLogParam = array(
					'moduleName' => 'game',
					'action' => $contentAction,
					'moduleId' => 15,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' game. (ID-'.$contentId.')',
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

//	print_r($oGame);
	$lisData = getlist( $oGame ,$this);
	$data['qcPendingTotal']	 = $lisData['qcPendingTotal'];
	$data['legalPendingTotal']	 = $lisData['legalPendingTotal'];	
	$data['publishPendingTotal']	 = $lisData['publishPendingTotal'];		
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
	
}

function getlist( $oGame,$users=NULL ){
	global $oMysqli;
	
	$oTags = new tags();
	$aTags = $oTags->getAllTags( array('onlyParent'=>true,'where' => " AND tag_access&2=2") );
	/* Search Param start */
	$srcGame = cms::sanitizeVariable( $_GET['srcGame'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcIsrc = cms::sanitizeVariable( $_GET['srcIsrc'] );
	$srcSrtDate = cms::sanitizeVariable( $_GET['srcSrtDate'] ); 
	$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
	$srcLang = cms::sanitizeVariable( $_GET['srcLang'] );
	$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
	$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
	$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
	$srcRtTag = cms::sanitizeVariable( $_GET['srcRtTag'] );
	$srcGameId = cms::sanitizeVariable( $_GET['srcGameId'] );
	$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
	$autosuggestalbum_hddn = cms::sanitizeVariable( $_GET['autosuggestalbum_hddn'] );
	$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
	$autosuggestartist_hddn = cms::sanitizeVariable( $_GET['autosuggestartist_hddn'] );
	$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
	$srcTxtTag = cms::sanitizeVariable( $_GET['srcTxtTag'] );
	$autosuggesttag_hddn = cms::sanitizeVariable( $_GET['autosuggesttag_hddn'] );
	
	
	$where		 = '';
	if( $srcGame != '' ){
		$where .= ' AND game_name like "'.$oMysqli->secure($srcGame).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	if( $srcGameId != '' ){
		$where .= ' AND game_id="'.$oMysqli->secure($srcGameId).'"';
	}
	if( $srcLang != '' ){
		$where .= ' AND language_id="'.$oMysqli->secure($srcLang).'"';
	}
	if( $srcSrtDate != '' && $srcEndDate != ''  ){
		$where .= ' AND release_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcSrtDate != ''){
		$where .= ' AND release_date >= "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcEndDate != ''){
		$where .= ' AND release_date <= "'.$oMysqli->secure($srcEndDate).'"';
	}
	if( $srcAlbum != '' &&  $autosuggestalbum_hddn !=""){
		$oGame = new game();
		$param = array( "where" => " AND album_id =".$autosuggestalbum_hddn );
		$gameIdList = $oGame->getAlbumGameMap($param);
		if($gameIdList){
			$gameIdListArr=NULL;
			foreach($gameIdList as $gameVal){		
				$gameIdListArr[]= $gameVal->game_id;
			}
			if(!empty($gameIdListArr)){
				$gameIdListStr = implode(",",$gameIdListArr);
				$where .= ' AND game_id IN ('.$gameIdListStr.')';	
			}
		}else{
			$where .= ' AND game_id =0';
		}
	}
	if( $srcArtist != '' && $autosuggestartist_hddn !=""){
		$oGame = new game();
		$param = array( "where" => " AND artist_id =".$autosuggestartist_hddn );
		$gameIdList = $oGame->getArtistGameMap($param);
		if($gameIdList){
			$gameIdListArr=NULL;
			foreach($gameIdList as $gameVal){		
				$gameIdListArr[]= $gameVal->game_id;
			}
			if(!empty($gameIdListArr)){
				$gameIdListStr = implode(",",$gameIdListArr);
				$where .= ' AND game_id IN ('.$gameIdListStr.')';	
			}
		}else{
			$where .= ' AND game_id =0';
		}
	}
	if( $srcTag != '' &&  $autosuggesttag_hddn !=""){
		$param = array( "where" => " AND tag_id =".$autosuggesttag_hddn );
		$gameIdList = $oGame->getTagGameMap($param);
		if($gameIdList){
			$gameIdListArr=NULL;
			foreach($gameIdList as $gameVal){		
				$gameIdListArr[]= $gameVal->game_id;
			}
			if(!empty($gameIdListArr)){
				$gameIdListStr = implode(",",$gameIdListArr);
				$where .= ' AND game_id IN ('.$gameIdListStr.')';	
			}
		}else{
			$where .= ' AND game_id = 0';
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

		
	$data['aSearch']['srcGame'] = $srcGame;
	$data['aSearch']['srcCType'] 	= $srcCType;
	$data['aSearch']['srcIsrc'] 	= $srcIsrc;
	$data['aSearch']['srcGameId'] 	= $srcGameId;
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
		$qcPendingTotal=$oGame->getTotalCount( $qcparams );
		$data['qcPendingTotal'] 	= $qcPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		$qcparams=array("where" =>" AND status=2");
		$legalPendingTotal=$oGame->getTotalCount( $qcparams );
		$data['legalPendingTotal'] 	= $legalPendingTotal;
	}
	if ($users->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
		$qcparams=array("where" =>" AND status=3");
		$publishPendingTotal=$oGame->getTotalCount( $qcparams );
		$data['publishPendingTotal'] 	= $publishPendingTotal;
	}
	/* Show Game as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => '',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oGame->getAllGames( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oGame->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "game?action=view&srcGame=$srcGame&srcCType=$srcCType&srcIsrc=$srcIsrc&srcSrtDate=$srcSrtDate&srcEndDate=$srcEndDate&srcLang=$srcLang&srcAlbum=$srcAlbum&autosuggestalbum_hddn=$autosuggestalbum_hddn&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcTag=$srcTag&srcRtTag=$srcRtTag&autosuggesttag_hddn=$autosuggesttag_hddn&srcGameId=$srcGameId&submitBtn=Search&do=".$_GET['do']."&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */
	/* Show Game as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );