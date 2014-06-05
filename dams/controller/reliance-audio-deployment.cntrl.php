<?php     //Reliance Audio DEPLOYMENT 
ob_start();
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$view = 'reliance-audio-deployment_all_list';   
$oDeployment = new deployment();
$oSong = new song();
$oImage = new image();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$imiConfig=array(20,21,22,23);//config ids related to imi deployments
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'legal') );
$id = (int)$_GET['id']; 
$endDateFix='2014-03-31';
$startDateFix=date('Y-m-d');
$clanoFix='667SAR';
if( $action == 'add' || $action == 'edit' ){
	$limit	= 1;
	$page	= 1;
	$start	= 0;
	$where  = " AND deployment_id=".$id;
	$params = array(
				'limit'	  => $limit,  
				'orderby' => '',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	$data['aDeployment'] = $oDeployment->getAllDeployments($params);
	$deploymentFolder=tools::deploymentFolderName(array('name'=>$data['aDeployment'][0]->deployment_name))."-".$data['aDeployment'][0]->deployment_id;
	if($do=="song"){
		if(!empty($_POST)){
			$oArtist = new artist();
			$oLanguage = new language();
			$oAlbum = new album();
			
			$selectedIds=$_POST['select_ids'];
			$deploymentId = (int)$_POST['deploymentId'];
			
			if($selectedIds){
				foreach($selectedIds as $contentId){
					$contentId = $contentId;
					
					$where = " AND song_id=".$contentId;
					$limit	= 1;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => '',  
								'start'   => $start,  
								'where'	  => $where,
							  );
					$songData = $oSong->getAllSongs( $params );
					
					$params = array(
								'start' => 0, 
								'limit' => 1, 
								'status' => $status, 
								'where' => " AND language_id= '".$songData[0]->language_id."'",
							  ); 
					$aLanguageData = $oLanguage->getAllLanguages( $params );
					$language = $aLanguageData[0]->language_name;
					$albumIds=$oSong->getAlbumSongMap(array("where" => " AND song_id=".$contentId." ORDER BY album_id ASC LIMIT 1"));
					$albumId=$albumIds[0]->album_id;
					$where = " AND album_id=".$albumId;
					$limit	= 1;
					$start	= 0;
					$params = array(
								'limit'	  => $limit,  
								'orderby' => '',  
								'start'   => $start,  
								'where'	  => $where,
							  );
					
					$albumData = $oAlbum->getAllAlbums( $params );
					$artistIds=$oSong->getArtistSongMap(array("where" => " AND song_id=".$contentId));
					$singerArr=array();
					$mDirectorArr=array();
					$lyricistArr=array();
					$starcastArr=array();
					if($artistIds){
						foreach($artistIds as $aId){
							if(($aConfig['artist_type']['Singer']&$aId->artist_role)==$aConfig['artist_type']['Singer']){
								$singerArr[]=$aId->artist_id;
							}
							if(($aConfig['artist_type']['Music Director']&$aId->artist_role)==$aConfig['artist_type']['Music Director']){
								$mDirectorArr[]=$aId->artist_id;
							}
							if(($aConfig['artist_type']['Lyricist']&$aId->artist_role)==$aConfig['artist_type']['Lyricist']){
								$lyricistArr[]=$aId->artist_id;
							}
							if(($aConfig['artist_type']['Starcast']&$aId->artist_role)==$aConfig['artist_type']['Starcast']){
								$starcastArr[]=$aId->artist_id;
							}
						}	
					}
					$allArtistIds=array_merge($singerArr,$mDirectorArr,$lyricistArr,$starcastArr);
					if($allArtistIds){
						$where = " AND artist_id IN (".implode(',',$allArtistIds).")";
						$limit	= 10000;
						$start	= 0;
						$params = array(
									'limit'	  => $limit,  
									'start'   => $start,  
									'where'   => $where
								  );
					
						$artistData = $oArtist->getAllArtists($params );
					}
					$singerString="";
					$mDirectorString="";
					$lyricistString="";
					$starcastString="";
					if($artistData){
						foreach($artistData as $aData){
							if(in_array($aData->artist_id,$singerArr)){
								$singerString .= $aData->artist_name.",";
							}
							if(in_array($aData->artist_id,$mDirectorArr)){
								$mDirectorString .= $aData->artist_name.",";
							}
							if(in_array($aData->artist_id,$lyricistArr)){
								$lyricistString .= $aData->artist_name.",";
							}
							if(in_array($aData->artist_id,$starcastArr)){
								$starcastString .= $aData->artist_name.",";
							}
						}
					}
					$singerString=rtrim($singerString,",");
					$mDirectorString=rtrim($mDirectorString,",");
					$lyricistString=rtrim($lyricistString,",");
					$starcastString=rtrim($starcastString,",");
					
					$albumArtistIds=$oAlbum->getArtistAlbumMap(array('where' => " AND album_id=".$albumId));
					
					$directorArr=array();
					$producerArr=array();
					$starcastAlbumArr=array();
					
					if($albumArtistIds){
						foreach($albumArtistIds as $aId){
							if(($aConfig['artist_type']['Director']&$aId->artist_role)==$aConfig['artist_type']['Director']){
								$directorArr[]=$aId->artist_id;
							}
							if(($aConfig['artist_type']['Producer']&$aId->artist_role)==$aConfig['artist_type']['Producer']){
								$producerArr[]=$aId->artist_id;
							}
							if(($aConfig['artist_type']['Starcast']&$aId->artist_role)==$aConfig['artist_type']['Starcast']){
								$starcastAlbumArr[]=$aId->artist_id;
							}
						}	
					}
					$allArtistIds=array_merge($directorArr,$producerArr,$starcastAlbumArr);
					if($allArtistIds){
						$where = " AND artist_id IN (".implode(',',$allArtistIds).")";
						$limit	= 10000;
						$start	= 0;
						$params = array(
									'limit'	  => $limit,  
									'start'   => $start,  
									'where'   => $where
								  );
					
						$artistData = $oArtist->getAllArtists($params );
					}
					$directorString="";
					$producerString="";
					$starcastAlbumString="";
					
					foreach($artistData as $aData){
						if(in_array($aData->artist_id,$directorArr)){
							$directorString .= $aData->artist_name.",";
						}
						if(in_array($aData->artist_id,$producerArr)){
							$producerString .= $aData->artist_name.",";
						}
						if(in_array($aData->artist_id,$starcastAlbumArr)){
							$starcastAlbumString .= $aData->artist_name.",";
						}
					}
					$directorString=rtrim($directorString,",");
					$producerString=rtrim($producerString,",");
					$starcastAlbumString=rtrim($starcastAlbumString,",");
					$releaseYear = ($songData[0]->release_date)?date("Y",strtotime($songData[0]->release_date)):"";
					$albumYear = ($albumData[0]->title_release_date)?date("Y",strtotime($albumData[0]->title_release_date)):"";
					if(!$albumData[0]->release_date){
						$releaseYear=$albumYear;
					}
					$albumType=$albumData[0]->album_type;
					$isFilm = ((1&$albumType)==1)?"Film":"Non Film";
					$deploymentId=(int)$_POST['deploymentId'];
					
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$albumData[0]->album_name,'songTitle'=>$songData[0]->song_name,'limit'=>25));
					$data_168000m25s=NULL;
					$data_168000m25s=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=22 AND status=1"));
					$file_168000m25s_arr=NULL;
					if(!empty($data_168000m25s)){
						if(sizeof($data_168000m25s)==1){
							$oFile_168000m25s=$data_168000m25s[0]->path;
							if($oFile_168000m25s){ 
								$file_168000m25s=$totalFileName."_prev.amr";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_168000m25s,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_168000m25s)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_168000m25s as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_168000m25s_arr=$arrOfFile;
						}	
					}
					$file_1622050s25s=NULL;
					$data_1622050s25s=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=23 AND status=1"));
					$file_1622050s25s_arr=NULL;
					if(!empty($data_1622050s25s)){
						if(sizeof($data_1622050s25s)==1){
							$oFile_1622050s25s=$data_1622050s25s[0]->path;
							if($oFile_1622050s25s){
								$file_1622050s25s=$totalFileName."_prev.mp3";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_1622050s25s,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_1622050s25s)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_1622050s25s as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_1622050s25s_arr=$arrOfFile;
						}	
					}
					$file_1644100s00s=NULL;
					$data_1644100s00s=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=21 AND status=1"));
					$file_1644100s00s_arr=NULL;
					if(!empty($data_1644100s00s)){
						if(sizeof($data_1644100s00s)==1){
							$oFile_1644100s00s=$data_1644100s00s[0]->path;
							if($oFile_1644100s00s){
								$file_1644100s00s=$totalFileName.".mp3";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_1644100s00s,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_1644100s00s)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_1644100s00s as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_1644100s00s_arr=$arrOfFile;
						}	
					}
					$file_168000m00s=NULL;
					$data_168000m00s=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=20 AND status=1"));
					$file_168000m00s_arr=NULL;
					if(!empty($data_168000m00s)){
						if(sizeof($data_168000m00s)==1){
							$oFile_168000m00s=$data_168000m00s[0]->path;
							if($oFile_168000m00s){
								$file_168000m00s=$totalFileName.".amr";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_168000m00s,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_168000m00s)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_168000m00s as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_168000m00s_arr=$arrOfFile;
						}	
					}
					$imageSongMap=$oImage->getImageMap(array("where" => " AND content_id=".$contentId." AND content_type=4"));
					$imageId=0;
					if(!empty($imageSongMap)){
						$imageId=$imageSongMap[0]->image_id;
					}
					$file_50x50=NULL;
					$data_50x50=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=1 AND status=1"));
					$file_WapPreviewGif5050_arr=NULL;
					if(!empty($data_50x50)){
						if(sizeof($data_50x50)==1){
							$oFile_50x50=$data_50x50[0]->path;
							if($oFile_50x50){
								$file_50x50=$totalFileName."_50x50.gif";
								if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_50x50,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_50x50)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_50x50 as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_WapPreviewGif5050_arr=$arrOfFile;
						}	
					}
					$file_101x80=NULL;
					$data_101x80=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=2 AND status=1"));
					$file_WapPreviewGif10180_arr=NULL;
					if(!empty($data_101x80)){
						if(sizeof($data_101x80)==1){
							$oFile_101x80=$data_101x80[0]->path;
							if($oFile_101x80){
								$file_101x80=$totalFileName."_101x80.gif";
								if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_101x80,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_101x80)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_101x80 as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_WapPreviewGif10180_arr=$arrOfFile;
						}	
					}
					$file_96x96=NULL;
					$data_96x96=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=3 AND status=1"));
					$file_WapPreviewGif9696_arr=NULL;
					if(!empty($data_96x96)){
						if(sizeof($data_96x96)==1){
							$oFile_96x96=$data_96x96[0]->path;
							if($oFile_96x96){
								$file_96x96=$totalFileName."_96x96.gif";
								if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_96x96,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_96x96)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_96x96 as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_WapPreviewGif9696_arr=$arrOfFile;
						}	
					}
					$file_140x140=NULL;
					$data_140x140=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=4 AND status=1"));
					$file_WapPreviewGif140140_arr=NULL;
					if(!empty($data_140x140)){
						if(sizeof($data_140x140)==1){
							$oFile_140x140=$data_140x140[0]->path;
							if($oFile_140x140){
								$file_140x140=$totalFileName."_140x140.jpg";
								if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_140x140,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_140x140)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_140x140 as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_WapPreviewGif140140_arr=$arrOfFile;
						}	
					}
					$file_300x300=NULL;
					$data_300x300=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=5 AND status=1"));
					$file_FlaObj300300Jpg_arr=NULL;
					if(!empty($data_300x300)){
						if(sizeof($data_300x300)==1){
							$oFile_300x300=$data_300x300[0]->path;
							if($oFile_300x300){
								$file_300x300=$totalFileName."_300x300.jpg";
								if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_300x300,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_300x300)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_300x300 as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_FlaObj300300Jpg_arr=$arrOfFile;
						}	
					}
					$file_500x500=NULL;
					$data_500x500=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=6 AND status=1"));
					$file_FlaObj500500Jpg_arr=NULL;
					if(!empty($data_500x500)){
						if(sizeof($data_500x500)==1){
							$oFile_500x500=$data_500x500[0]->path;
							if($oFile_500x500){
								$file_500x500=$totalFileName."_500x500.jpg";
								if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_500x500,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_500x500)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_500x500 as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_FlaObj500500Jpg_arr=$arrOfFile;
						}	
					}

					$providers_details = NULL;
					$providers_details = array('startDate'=>$startDateFix,'endDate'=>$endDateFix,'clano'=>$clanoFix,'file_WapPreviewAmr_arr'=>$file_168000m25s_arr,'file_WapPreviewMp3_arr'=>$file_1622050s25s_arr,'file_FlaObjMp3_arr'=>$file_1644100s00s_arr,'file_FlaObjAmr_arr'=>$file_168000m00s_arr,"isFilm"=>$isFilm,'WapPreviewAmr'=>$file_168000m25s,'WapPreviewMp3'=>$file_1622050s25s,'FlaObjMp3'=>$file_1644100s00s,'FlaObjAmr'=>$file_168000m00s,'WapPreviewGif5050'=>$file_50x50 ,'WebPreviewGif10180'=>$file_101x80 , 'WebPreviewGif9696'=>$file_96x96 ,'FlaObj140140Jpg' =>$file_140x140,'FlaObj300300Jpg' =>$file_300x300,'FlaObj500500Jpg' =>$file_500x500,'file_WapPreviewGif5050_arr'=>$file_WapPreviewGif5050_arr,'file_WebPreviewGif10180_arr'=>$file_WebPreviewGif10180_arr,'file_WebPreviewGif9696_arr'=>$file_WebPreviewGif9696_arr,'file_FlaObj140140Jpg_arr'=>$file_FlaObj140140Jpg_arr,'file_FlaObj300300Jpg_arr'=>$file_FlaObj300300Jpg_arr,'file_FlaObj500500Jpg_arr'=>$file_FlaObj500500Jpg_arr,'copyright'=>'Saregama','label'=>'Saregama');
					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => $songData[0]->song_name,
								'language' => $language,
								'category' => "",
								'subCategory' => "",
								'coid' => "",
								'cpid' => "",
								'clid' => "",
								'startDate' => "",
								'endDate' => "",
								'exclusive' => "",
								'album' => ucwords(strtolower($albumData[0]->album_name)),
								'clano' => "",
								'keyArtist' => $singerString,
								'musicDirector' => $mDirectorString,
								'searchKey' => $albumData[0]->album_name.",".$starcastAlbumString.",".$language,
								'keyDirector' => $directorString,
								'keyProducer' => $producerString,
								'releaseYear' => $releaseYear,
								'albumYear' => $albumYear,
								'genre' => "",
								'starcast' => $starcastAlbumString,
								'lyricist' => $lyricistString,
								'singer' => $singerString,
								'isrc' => $songData[0]->isrc,
								'deploymentId' => $deploymentId,
								'contentId' => $contentId,
								'contentType' => '4',
								'ddId' => "",
								'providerDetails' => $providers_details_str,
					);
					$deployed = $oDeployment->addToDeployment($params);
				}
				if($deployed){
					TOOLS::log('Song added to Reliance Audio Deployment', $action, '23', (int)$this->user->user_id, "Deployment Id: ".$deployed."" );
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					header('Location: '.SITEPATH.'reliance-audio-deployment?action=edit&id='.$deploymentId.'&do=manage');
					exit;
				}
			}					
		}
		$view = 'reliance-audio-deployment_list';
		$id = (int)$_GET['id']; 
		$limit	= 1;
		$page	= 1;
		$start	= 0;
		$where  = " AND deployment_id=".$id;
		$params = array(
					'limit'	  => $limit,  
					'orderby' => '',  
					'start'   => $start,  
					'where'	  => $where,
				  );
		$data['aDeployment'] = $oDeployment->getAllDeployments($params);
		
		/* Search Param start */
		$srcSong = cms::sanitizeVariable( $_GET['srcSong'] );
		$srcIsrc = cms::sanitizeVariable( $_GET['srcIsrc'] );
		$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$srcSongId = cms::sanitizeVariable( $_GET['srcSongId'] );
		$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
		$autosuggestalbum_hddn = cms::sanitizeVariable( $_GET['autosuggestalbum_hddn'] );
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$autosuggestartist_hddn = cms::sanitizeVariable( $_GET['autosuggestartist_hddn'] );
	
		
		$where		 = '';
		if( $srcSong != '' ){
			$where .= ' AND song_name like "'.$oMysqli->secure($srcSong).'%"';
		}
		if( $srcIsrc != '' ){
			$where .= ' AND isrc="'.$oMysqli->secure($srcIsrc).'"';
		}
		if( $srcSongId != '' ){
			$where .= ' AND song_id="'.$oMysqli->secure($srcSongId).'"';
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
					$where .= ' AND song_id IN ('.$songIdListStr.')';	
				}
			}else{
				$where .= ' AND song_id =0';
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
					$where .= ' AND song_id IN ('.$songIdListStr.')';	
				}
			}else{
				$where .= ' AND song_id =0';
			}
		}
	
		$data['aSearch']['srcSong'] = $srcSong;
		$data['aSearch']['srcIsrc'] 	= $srcIsrc;
		$data['aSearch']['srcSongId'] 	= $srcSongId;
		$data['aSearch']['srcLang'] 	= $srcLang;
		$data['aSearch']['srcAlbum'] 	= $srcAlbum;
		$data['aSearch']['autosuggestalbum_hddn'] 	= $autosuggestalbum_hddn;
		$data['aSearch']['srcArtist'] 	= $srcArtist;
		$data['aSearch']['autosuggestartist_hddn'] 	= $autosuggestartist_hddn;
	
		/* Search Param end */
		/* Show Song as List Start */
		$data['aContent']="";
		if($where){
			$limit	= MAX_DISPLAY_COUNT;
			$page	= (int)$_GET['page'];
			$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
			$params = array(
						'limit'	  => $limit,  
						'orderby' => '',  
						'start'   => $start,  
						'where'	  => $where,
					  );
			
			$data['aContent'] = $oSong->getAllSongs( $params );
			/* Pagination Start */
			$oPage = new Paging();
			$oPage->total = $oSong->getTotalCount( $params );
			$oPage->page = $page;
			$oPage->limit = MAX_DISPLAY_COUNT;
			$oPage->url = "reliance-audio-deployment?action=edit&do=song&srcSong=$srcSong&srcIsrc=$srcIsrc&srcAlbum=$srcAlbum&autosuggestalbum_hddn=$autosuggestalbum_hddn&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcSongId=$srcSongId&submitBtn=Search&page={page}";
			$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
			$data['sPaging'] = $oPage->render();
		}
		$oCms->view( $view, $data );
		exit;
	}
	elseif($do=="manage"){
		if(!empty($_POST) && isset($_POST) && $_POST['submitBtn']){
			$aError =array();
			$primaryId = $_POST['primaryId'];
			$contentId = $_POST['contentId'];
			$songTitle=$_POST['songTitle'];
			$language=$_POST['language'];
			$category=$_POST['category'];
			$subCategory=$_POST['subCategory'];
			$coid=$_POST['coid'];
			$cpid=$_POST['cpid'];
			$clid=$_POST['clid'];
			$startDate=$_POST['startDate'];
			$endDate=$_POST['endDate'];
			$exclusive=$_POST['exclusive'];
			$album=$_POST['album'];
			$clano=$_POST['clano'];
			$keyArtist=$_POST['keyArtist'];
			$musicDirector=$_POST['musicDirector'];
			$searchKey=$_POST['searchKey'];
			$keyDirector=$_POST['keyDirector'];
			$keyProducer=$_POST['keyProducer'];
			$releaseYear=$_POST['releaseYear'];
			$albumYear=$_POST['albumYear'];
			$genre=$_POST['genre'];
			$starcast=$_POST['starcast'];
			$lyricist=$_POST['lyricist'];
			$singer=$_POST['singer'];
			$isrc=$_POST['isrc'];
			$label=$_POST['label'];
			$copyright=$_POST['copyright'];
			$file_0808m=$_POST['0808m'];
			$file_0808m40s=$_POST['0808m40s'];
			$file_1616m=$_POST['1616m'];
			$file_0808mfull=$_POST['0808mfull'];
			$deploymentId = (int)$_POST['deploymentId'];
			$providerCode = $_POST['providerCode'];
			$filmNonfilm = $_POST['filmNonfilm'];
			
			$file_168000m25s="";
			$file_1622050s25s="";
			$file_1644100s00s="";
			$file_168000m00s="";
			$file_50x50="";
			$file_101x80="";
			$file_96x96="";
			$file_140x140="";
			$file_300x300="";
			$file_500x500="";					
			if(!empty($primaryId)){
				foreach($primaryId as $pId){
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$album[$pId],'songTitle'=>$songTitle[$pId],'limit'=>35));
					$imageSongMap=$oImage->getImageMap(array("where" => " AND content_id=".$contentId[$pId]." AND content_type=4"));
					$imageId=0;
					if(!empty($imageSongMap)){
						$imageId=$imageSongMap[0]->image_id;
					}
					if($_FILES['file_WapPreviewAmr']['name'][$pId]){
						$uFileName=$_FILES['file_WapPreviewAmr']['name'][$pId];
						$tmpName=$_FILES['file_WapPreviewAmr']['tmp_name'][$pId];
						$fileSize=$_FILES['file_WapPreviewAmr']['size'][$pId];
						$folderPath="/16b12k8000hzm25s/".substr($isrc[$pId],-2)."/";
						$fileName="22-".$isrc[$pId].".amr";
						$sTempAudioPath	= "amr".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize168000m25s=$fileSize;
						$succ=1;
						if($fileSize168000m25s>40){
							$succ=0;
							$aError[]="Please upload Wap Preview amr file of proper size for ".$songTitle[$pId].".";
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=22 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/22v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("amr"),
										"size" =>"40",
										"oSize" => $fileSize, 
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy=$totalFileName."_prev.amr";
							$file_168000m25s=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>22,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}
					}elseif(!empty($_POST['file_WapPreviewAmr_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_WapPreviewAmr_rad_'.$pId];
							$file_168000m25s=$totalFileName."_prev.amr";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_168000m25s)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_168000m25s=$_POST['hidden_file_WapPreviewAmr'][$pId];
					}
					if($_FILES['file_WapPreviewMp3']['name'][$pId]){
						$uFileName=$_FILES['file_WapPreviewMp3']['name'][$pId];
						$tmpName=$_FILES['file_WapPreviewMp3']['tmp_name'][$pId];
						$fileSize=$_FILES['file_WapPreviewMp3']['size'][$pId];
						$folderPath="/16b64k22050hzs25s/".substr($isrc[$pId],-2)."/";
						$fileName="23-".$isrc[$pId].".mp3";
						$sTempAudioPath	= "mp3".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize1622050s25s=$fileSize;
						$succ=1;
						if($fileSize1622050s25s>200){
							$succ=0;
							$aError[]="Please upload Wap/Web Preview mp3 file of proper size for ".$songTitle[$pId].".";
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=23 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/23v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("mp3"),
										"size" =>"200",
										"oSize" => $fileSize,
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy=$totalFileName."_prev.mp3";
							$file_1622050s25s=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>23,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}							
						}
					}elseif(!empty($_POST['file_WapPreviewMp3_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_WapPreviewMp3_rad_'.$pId];
							$file_1622050s25s=$totalFileName."_prev.mp3";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_1622050s25s)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_1622050s25s=$_POST['hidden_file_WapPreviewMp3'][$pId];
					}
					if($_FILES['file_FlaObjMp3']['name'][$pId]){
						$uFileName=$_FILES['file_FlaObjMp3']['name'][$pId];
						$tmpName=$_FILES['file_FlaObjMp3']['tmp_name'][$pId];
						$fileSize=$_FILES['file_FlaObjMp3']['size'][$pId];
						$folderPath="/16b128k44100hzs00s/".substr($isrc[$pId],-2)."/";
						$fileName="21-".$isrc[$pId].".mp3";
						$sTempAudioPath	= "mp3".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize1644100s00s=$fileSize;
						$succ=1;
						if($fileSize1644100s00s>7500){
							$succ=0;
							$aError[]="Please upload FLA Object Mp3 file of proper size for ".$songTitle[$pId].".";
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=21 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/21v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("mp3"),
										"size" =>"7500",
										"oSize" => $fileSize,
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy=$totalFileName.".mp3";
							$file_1644100s00s=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>21,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}
					}elseif(!empty($_POST['file_FlaObjMp3_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_FlaObjMp3_rad_'.$pId];
							$file_1644100s00s=$totalFileName.".mp3";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_1644100s00s)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_1644100s00s=$_POST['hidden_file_FlaObjMp3'][$pId];
					}
					if($_FILES['file_FlaObjAmr']['name'][$pId]){
						$uFileName=$_FILES['file_FlaObjAmr']['name'][$pId];
						$tmpName=$_FILES['file_FlaObjAmr']['tmp_name'][$pId];
						$fileSize=$_FILES['file_FlaObjAmr']['size'][$pId];
						$folderPath="/16b12.80k8000hzm00s/".substr($isrc[$pId],-2)."/";
						$fileName="20-".$isrc[$pId].".amr";
						$sTempAudioPath	= "amr".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize168000m00s=$fileSize;
						$succ=1;
						if($fileSize168000m00s>750){
							$aError[]="Please upload FLA Object amr file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=20 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/20v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("amr"),
										"size" =>"750",
										"oSize" => $fileSize,
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy=$totalFileName.".amr";
							$file_168000m00s=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>20,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_FlaObjAmr_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_FlaObjAmr_rad_'.$pId];
							$file_168000m00s=$totalFileName.".amr";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_168000m00s)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_168000m00s=$_POST['hidden_file_FlaObjAmr'][$pId];
					}
					
					if($_FILES['file_WapPreviewGif5050']['name'][$pId]){
						$uFileName=$_FILES['file_WapPreviewGif5050']['name'][$pId];
						$tmpName=$_FILES['file_WapPreviewGif5050']['tmp_name'][$pId];
						$fileSize=$_FILES['file_WapPreviewGif5050']['size'][$pId];
						$folderPath="/50x50/".tools::getImagePathChar(array('title'=>$totalFileName,'length'=>2))."/";
						$fileName=$totalFileName."-".$imageId."-1-50x50.gif";
						$sTempAudioPath	= "gif".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize50x50=$fileSize;
						$succ=1;
						if($fileSize50x50>3){
							$aError[]="Please upload Wap Preview gif(50x50) file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							/*$tCnt=$oDeployment->getSongImageTotalCount(array('where'=>" AND image_id=".$imageId." AND config_id=1 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								#$sTempAudioPath=preg_replace("[-.*-]","-1v".$v."-",$sTempAudioPath);
								$sTempAudioPath=str_replace("-".$imageId."-1-","-".$imageId."-1v".$v."-",$sTempAudioPath);
							}*/
							$fileNametoDeploy=$totalFileName."_50x50.gif";
							$fileName=fileNametoDeploy;
							$sTempAudioPath	= MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy;
							
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("gif"),
										"size" =>"2",
										"oSize" => $fileSize,
										);
							$return=tools::uploadFiles($params);
							
							if(empty($return['error'])){
								/*if(copy($return['image'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->image_mstr_config_rel(array('imageId'=>$imageId,'configId'=>1,'path'=>$sTempAudioPath,'version'=>$v));*/
								$file_50x50=$fileNametoDeploy;
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_WapPreviewGif5050_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_IMAGEEDITS.$_POST['file_WapPreviewGif5050_rad_'.$pId];
							$file_50x50=$totalFileName."_50x50.gif";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_50x50)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_50x50=$_POST['hidden_file_WapPreviewGif5050'][$pId];
					}
					if($_FILES['file_WebPreviewGif10180']['name'][$pId]){ 
						$uFileName=$_FILES['file_WebPreviewGif10180']['name'][$pId];
						$tmpName=$_FILES['file_WebPreviewGif10180']['tmp_name'][$pId];
						$fileSize=$_FILES['file_WebPreviewGif10180']['size'][$pId];
						$folderPath="/101x80/".tools::getImagePathChar(array('title'=>$totalFileName,'length'=>2))."/";
						$fileName=$totalFileName."-2-101x80.gif";
						$sTempAudioPath	= "gif".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize101x80=$fileSize;
						$succ=1;
						if($fileSize101x80>15){
							$aError[]="Please upload Wap Preview gif(101x80) file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							/*$tCnt=$oDeployment->getSongImageTotalCount(array('where'=>" AND image_id=".$imageId." AND config_id=2 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								#$sTempAudioPath=preg_replace("[-.*-]","-2v".$v."-",$sTempAudioPath);
								$sTempAudioPath=str_replace("-".$imageId."-2-","-".$imageId."-2v".$v."-",$sTempAudioPath);
							}*/
							$fileNametoDeploy=$totalFileName."_101x80.gif";
							$fileName=$fileNametoDeploy;
							$sTempAudioPath=MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("gif"),
										"size" =>"15",
										"oSize" => $fileSize,
										);
							$return=tools::uploadFiles($params);
							
							if(empty($return['error'])){
								/*if(copy($return['image'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->image_mstr_config_rel(array('imageId'=>$imageId,'configId'=>2,'path'=>$sTempAudioPath,'version'=>$v));*/
								$file_101x80=$fileNametoDeploy;
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_WebPreviewGif10180_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_IMAGEEDITS.$_POST['file_WebPreviewGif10180_rad_'.$pId];
							$file_101x80=$totalFileName."_101x80.gif";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_101x80)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_101x80=$_POST['hidden_file_WebPreviewGif10180'][$pId];
					}
					if($_FILES['file_WebPreviewGif9696']['name'][$pId]){
						$uFileName=$_FILES['file_WebPreviewGif9696']['name'][$pId];
						$tmpName=$_FILES['file_WebPreviewGif9696']['tmp_name'][$pId];
						$fileSize=$_FILES['file_WebPreviewGif9696']['size'][$pId];
						$folderPath="/96x96/".tools::getImagePathChar(array('title'=>$totalFileName,'length'=>2))."/";
						$fileName=$totalFileName."-3-96x96.gif";
						$sTempAudioPath	= "gif".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize96x96=$fileSize;
						$succ=1;
						if($fileSize96x96>15){
							$aError[]="Please upload Wap Preview gif(96x96) file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							/*$tCnt=$oDeployment->getSongImageTotalCount(array('where'=>" AND image_id=".$imageId." AND config_id=3 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								#$sTempAudioPath=preg_replace("[-.*-]","-3v".$v."-",$sTempAudioPath);
								$sTempAudioPath=str_replace("-".$imageId."-3-","-".$imageId."-3v".$v."-",$sTempAudioPath);
							}*/
							$fileNametoDeploy=$totalFileName."_96x96.gif";
							$fileName=$fileNametoDeploy;
							$sTempAudioPath=MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("gif"),
										"size" =>"15",
										"oSize" => $fileSize,
										);
							$return=tools::uploadFiles($params);
							if(empty($return['error'])){
								/*if(copy($return['image'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->image_mstr_config_rel(array('imageId'=>$imageId,'configId'=>3,'path'=>$sTempAudioPath,'version'=>$v));*/
								$file_96x96=$fileNametoDeploy;
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_WebPreviewGif9696_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_IMAGEEDITS.$_POST['file_WebPreviewGif9696_rad_'.$pId];
							$file_96x96=$totalFileName."_96x96.gif";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_96x96)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_96x96=$_POST['hidden_file_WebPreviewGif9696'][$pId];
					}
					
					if($_FILES['file_FlaObj140140Jpg']['name'][$pId]){
						$uFileName=$_FILES['file_FlaObj140140Jpg']['name'][$pId];
						$tmpName=$_FILES['file_FlaObj140140Jpg']['tmp_name'][$pId];
						$fileSize=$_FILES['file_FlaObj140140Jpg']['size'][$pId];
						$folderPath="/140x140/".tools::getImagePathChar(array('title'=>$totalFileName,'length'=>2))."/";
						$fileName=$totalFileName."-4-140x140.jpg";
						$sTempAudioPath	= "jpg".$folderPath.$fileName;
						$sTempAudioPath	= MEDIA_SEVERPATH_DEPLOY.$folderPath."/".$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize140x140=$fileSize;
						$succ=1;
						if($fileSize140x140>50){
							$aError[]="Please upload FLA Object 140x140 jpg file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							/*$tCnt=$oDeployment->getSongImageTotalCount(array('where'=>" AND image_id=".$imageId." AND config_id=4 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								#$sTempAudioPath=preg_replace("[-.*-]","-4v".$v."-",$sTempAudioPath);
								$sTempAudioPath=str_replace("-".$imageId."-4-","-".$imageId."-4v".$v."-",$sTempAudioPath);
							}*/
							#### uploaded file save to deployment folder only
							$fileNametoDeploy=$totalFileName."_140x140.jpg";
							$fileName=fileNametoDeploy;
							$sTempAudioPath=MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("jpg"),
										"size" =>"50",
										"oSize" => $fileSize,
										);
							$return=tools::uploadFiles($params);
							if(empty($return['error'])){
								$file_140x140=$fileNametoDeploy;
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_FlaObj140140Jpg_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_IMAGEEDITS.$_POST['file_FlaObj140140Jpg_rad_'.$pId];
							$file_140x140=$totalFileName."_140x140.jpg";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_140x140)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_140x140=$_POST['hidden_file_FlaObj140140Jpg'][$pId];
					}
					
					if($_FILES['file_FlaObj300300Jpg']['name'][$pId]){
						$uFileName=$_FILES['file_FlaObj300300Jpg']['name'][$pId];
						$tmpName=$_FILES['file_FlaObj300300Jpg']['tmp_name'][$pId];
						$fileSize=$_FILES['file_FlaObj300300Jpg']['size'][$pId];
						$folderPath="/300x300/".tools::getImagePathChar(array('title'=>$totalFileName,'length'=>2))."/";
						$fileName=$totalFileName."-5-300x300.jpg";
						$sTempAudioPath	= "jpg".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize300x300=$fileSize;
						$succ=1;
						if($fileSize300x300>150){
							$aError[]="Please upload FLA Object 300x300 jpg file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							/*$tCnt=$oDeployment->getSongImageTotalCount(array('where'=>" AND image_id=".$imageId." AND config_id=5 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								#$sTempAudioPath=preg_replace("[-.*-]","-5v".$v."-",$sTempAudioPath);
								$sTempAudioPath=str_replace("-".$imageId."-5-","-".$imageId."-5v".$v."-",$sTempAudioPath);
							}*/
							$fileNametoDeploy=$totalFileName."_300x300.jpg";
							$fileName=fileNametoDeploy;
							$sTempAudioPath=MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("jpg"),
										"size" =>"150",
										"oSize" => $fileSize,
										);
							$return=tools::uploadFiles($params);

							if(empty($return['error'])){
								/*if(copy($return['image'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->image_mstr_config_rel(array('imageId'=>$imageId,'configId'=>5,'path'=>$sTempAudioPath,'version'=>$v));
								*/
								$file_300x300=$fileNametoDeploy;
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_FlaObj300300Jpg_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_IMAGEEDITS.$_POST['file_FlaObj300300Jpg_rad_'.$pId];
							$file_300x300=$totalFileName."_300x300.jpg";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_300x300)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_300x300=$_POST['hidden_file_FlaObj300300Jpg'][$pId];
					}
					
					if($_FILES['file_FlaObj500500Jpg']['name'][$pId]){
						$uFileName=$_FILES['file_FlaObj500500Jpg']['name'][$pId];
						$tmpName=$_FILES['file_FlaObj500500Jpg']['tmp_name'][$pId];
						$fileSize=$_FILES['file_FlaObj500500Jpg']['size'][$pId];
						$folderPath="/500x500/".tools::getImagePathChar(array('title'=>$totalFileName,'length'=>2))."/";
						$fileName=$totalFileName."-6-500x500.jpg";
						$sTempAudioPath	= "jpg".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize500x500=$fileSize;
						$succ=1;
						if($fileSize500x500>150){
							$aError[]="Please upload FLA Object 500x500 jpg file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							/*$tCnt=$oDeployment->getSongImageTotalCount(array('where'=>" AND image_id=".$imageId." AND config_id=6 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								#$sTempAudioPath=preg_replace("[-.*-]","-6v".$v."-",$sTempAudioPath);
								$sTempAudioPath=str_replace("-".$imageId."-6-","-".$imageId."-6v".$v."-",$sTempAudioPath);
							}*/
							$fileNametoDeploy=$totalFileName."_500x500.jpg";
							$fileName=fileNametoDeploy;
							$sTempAudioPath=MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("jpg"),
										"size" =>"450",
										"oSize" => $fileSize,
										);
							$return=tools::uploadFiles($params);
							if(empty($return['error'])){
								/*if(copy($return['image'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->image_mstr_config_rel(array('imageId'=>$imageId,'configId'=>6,'path'=>$sTempAudioPath,'version'=>$v));*/
								$file_500x500=$fileNametoDeploy;
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_FlaObj500500Jpg_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_IMAGEEDITS.$_POST['file_FlaObj500500Jpg_rad_'.$pId];
							$file_500x500=$totalFileName."_500x500.jpg";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_500x500)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_500x500=$_POST['hidden_file_FlaObj500500Jpg'][$pId];
					}
					
					if($songTitle[$pId]==""){
						$aError[]="Please enter title.";
					}
					if($language[$pId]==""){
						$aError[]="Please enter title".$songTitle[$pId].".";
					}
					if($category[$pId]=="" || $category[$pId]=="0"){
						$aError[]="Please enter category for ".$songTitle[$pId].".";
					}
					if($subCategory[$pId]=="" || $subCategory[$pId]=="0"){
						$aError[]="Please enter sub-category for ".$songTitle[$pId].".";
					}
					if($startDate[$pId]=="" || $startDate[$pId]=="0000-00-00"){
						$aError[]="Please enter start date for ".$songTitle[$pId].".";
					}
					if($endDate[$pId]=="" || $endDate[$pId]=="0000-00-00"){
						$aError[]="Please enter end date for ".$songTitle[$pId].".";
					}
					if($album[$pId]==""){
						$aError[]="Please enter album for ".$songTitle[$pId].".";
					}
					if($keyArtist[$pId]==""){
						$aError[]="Please enter key artist for ".$songTitle[$pId].".";
					}
					if($musicDirector[$pId]==""){
						$aError[]="Please enter music director for ".$songTitle[$pId].".";
					}
					if($musicDirector[$pId]==""){
						$aError[]="Please enter music director for ".$songTitle[$pId].".";
					}
					if($searchKey[$pId]==""){
						$aError[]="Please enter search key for ".$songTitle[$pId].".";
					}
					if($keyDirector[$pId]==""){
						$aError[]="Please enter key director for ".$songTitle[$pId].".";
					}
					if($keyProducer[$pId]==""){
						$aError[]="Please enter key producer for ".$songTitle[$pId].".";
					}
					if($releaseYear[$pId]=="" || $releaseYear[$pId]=="0000"){
						$aError[]="Please enter release year for ".$songTitle[$pId].".";
					}
					if($albumYear[$pId]=="" || $albumYear[$pId]=="0000"){
						$aError[]="Please enter album year for ".$songTitle[$pId].".";
					}
					if($starcast[$pId]==""){
						$aError[]="Please enter starcast for ".$songTitle[$pId].".";
					}
					if($lyricist[$pId]==""){
						$aError[]="Please enter lyricist for ".$songTitle[$pId].".";
					}
					if($isrc[$pId]==""){
						$aError[]="Please enter original code for ".$songTitle[$pId].".";
					}
					if($label[$pId]==""){
						$aError[]="Please enter label for ".$songTitle[$pId].".";
					}
					if($copyright[$pId]==""){
						$aError[]="Please enter copyright for ".$songTitle[$pId].".";
					}
					if($file_168000m25s==""){
						$aError[]="Please upload Wap Preview amr file for ".$songTitle[$pId];
					}
					if($file_1622050s25s==""){
						$aError[]="Please upload Wap/Web Preview mp3 file for ".$songTitle[$pId];
					}
					if($file_1644100s00s==""){
						$aError[]="Please upload FLA Object Mp3 file for ".$songTitle[$pId];
					}
					if($file_168000m00s==""){
						$aError[]="Please upload FLA Object amr file for ".$songTitle[$pId];
					}
					if($file_50x50==""){
						$aError[]="Please upload Wap Preview gif(50x50) file for ".$songTitle[$pId];
					}
					if($file_101x80==""){
						$aError[]="Please upload Web Preview gif(101x80) file for ".$songTitle[$pId];
					}
					if($file_96x96==""){
						$aError[]="Please upload Web Preview gif(96x96) file for ".$songTitle[$pId];
					}
					
					if($file_140x140==""){
						$aError[]="Please upload FLA Object 140x140 jpg file for ".$songTitle[$pId];
					}
					if($file_300x300==""){
						$aError[]="Please upload FLA Object 300x300 jpg file for ".$songTitle[$pId];
					}
					if($file_500x500==""){
						$aError[]="Please upload FLA Object 500x500 jpg file for ".$songTitle[$pId];
					}
					
					$providers_details = array("category"=>$category[$pId],"subCategory"=>$subCategory[$pId],"startDate"=>$startDate[$pId],'WapPreviewAmr'=>$file_168000m25s,'WapPreviewMp3'=>$file_1622050s25s,'FlaObjMp3'=>$file_1644100s00s,'FlaObjAmr'=>$file_168000m00s,'WapPreviewGif5050'=>$file_50x50 ,'WebPreviewGif10180'=>$file_101x80 , 'WebPreviewGif9696'=>$file_96x96 ,'FlaObj140140Jpg' =>$file_140x140,'FlaObj300300Jpg' =>$file_300x300,'FlaObj500500Jpg' =>$file_500x500,"copyright" => $copyright[$pId],"label"=>$label[$pId],'endDate'=>$endDate[$pId],'clano'=>$clanoFix,'isFilm'=>$filmNonfilm[$pId]);
					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => ucwords(strtolower($songTitle[$pId])),
								'language' => $language[$pId],
								'category' => $category[$pId],
								'subCategory' => $subCategory[$pId],
								'coid' => $coid[$pId],
								'cpid' => $cpid[$pId],
								'clid' => $clid[$pId],
								'startDate' => $startDate[$pId],
								'endDate' => $endDate[$pId],
								'exclusive' => $exclusive[$pId],
								'album' => ucwords(strtolower($album[$pId])),
								'clano' => $clano[$pId],
								'keyArtist' => $keyArtist[$pId],
								'musicDirector' => $musicDirector[$pId],
								'searchKey' => $searchKey[$pId],
								'keyDirector' => $keyDirector[$pId],
								'keyProducer' => $keyProducer[$pId],
								'releaseYear' => $releaseYear[$pId],
								'albumYear' => $albumYear[$pId],
								'genre' => $genre[$pId],
								'starcast' => $starcast[$pId],
								'lyricist' => $lyricist[$pId],
								'singer' => $keyArtist[$pId],
								'isrc' => $isrc[$pId],
								'deploymentId' => $deploymentId,
								'contentId' => $contentId[$pId],
								'contentType' => '4',
								'ddId' => $pId,
								'providerDetails' => $providers_details_str,
								'deploymentFolder' => MEDIA_SEVERPATH_DEPLOY.$deploymentFolder,
					);
					$deployed = $oDeployment->addToDeployment($params);
					if(empty($aError)){
						$createXML=$oDeployment->generateRelianceAudioXml($params);
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>1));
					}else{
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					}
				}
				if($deployed && empty($aError)){
					TOOLS::log('Song Meta upadated to Reliance Audio Deployment', $action, '23', (int)$this->user->user_id, "Deployment Id: ".$deployed."" );
					header('Location:'.SITEPATH.'reliance-audio-deployment?action=edit&id='.$deploymentId.'&do=manage&msg=Action completed susseccfully!');
					exit;
				}
				$data['aError']=$aError;
				$view = "reliance-audio-deployment_manage";
				$limit	= 1000;
				$start	= 0;
				$params = array(
							'limit'	  => $limit,  
							'orderby' => '  ORDER BY id asc',  
							'start'   => $start,  
							'where'	  => " AND deployment_id=".$id,
						  );
				$data['aContent'] = $oDeployment->getDeploymentsDetails( $params );
				$oCms->view( $view, $data );
			}						
		}else{	
			$view = "reliance-audio-deployment_manage";
			$limit	= 1000;
			$start	= 0;
			$params = array(
						'limit'	  => $limit,  
						'orderby' => '  ORDER BY id asc',  
						'start'   => $start,  
						'where'	  => " AND deployment_id=".$id,
					  );
			$data['aContent'] = $oDeployment->getDeploymentsDetails( $params );
			$oCms->view( $view, $data );
		}
		exit;
	}
	elseif($do=="zip"){
			$source_dir = MEDIA_READ_SEVERPATH_DEPLOY.$deploymentFolder."/";
			$zip_file = MEDIA_SEVERPATH_DEPLOY.$deploymentFolder.".zip";
			$zip_file_r = MEDIA_READ_SEVERPATH_DEPLOY.$deploymentFolder.".zip";
			$file_list = tools::listDirectory($source_dir);
			@unlink($zip_file); 
			$zip = new ZipArchive();
			if ($zip->open($zip_file, ZIPARCHIVE::CREATE) === true) {
			  foreach ($file_list as $file) {
				if ($file !== $zip_file) {
				  $zip->addFile($file, substr($file, strlen($source_dir)));
				}
			  }
			  $zip->close();
			}
			$size = filesize($zip_file_r);
			sleep(2);
			header("Pragma: no-cache"); 
			header("Expires: 0");
			header("Content-Type: application/zip");
			header("Content-Disposition: attachment; filename=\"".$deploymentFolder.".zip\"");
			header("Content-Length: ".$size );
			readfile($zip_file_r);
			TOOLS::log('Generated zip file for Reliance Audio Deployment', $action, '23', (int)$this->user->user_id, "Deployment Id: ".$id."" );
			exit;		
	}
	/* Form */
	$view = 'reliance-audio-deployment_form';
	$id = (int)$_GET['id']; 
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$deploymentName	=	cms::sanitizeVariable($_POST['deploymentName']);
		if($deploymentName==""){
			$aError[]="Enter Deployment Name.";
		}
		$postData=array(
					'deploymentName'=>$deploymentName,
					'serviceProvider'=>"RELIANCEAUDIO",
					);
		if(empty($aError)){ 
			$aData = $oDeployment->saveDeployment( $postData );
			if($id){
				$aData=$id;
			}
			$folderNameToDeploy=$deploymentFolder=tools::deploymentFolderName(array('name'=>$deploymentName))."-".$aData;
			#tools::removeSpChars(str_replace(" ","",ucwords(strtolower($deploymentName))))."-".$aData;
			if(!file_exists(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy)){
				chmod(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,777);
				mkdir(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,0777);
			}
			/* Write DB Activity Logs */
			TOOLS::log('Relince Audio  Deployment', $action, '23', (int)$this->user->user_id, "Deployment Id: ".$aData."" );
			header('location:'.SITEPATH.'reliance-audio-deployment?action=edit&id='.$aData."&do=song");
			exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}else{
	/*
	* To display song details start	
	*/
	if($do=='details'){
		$limit	= 1;
		$page	= 1;
		$start	= 0;
		$where  = " AND deployment_id=".$id;
		$params = array(
					'limit'	  => $limit,  
					'orderby' => '',  
					'start'   => $start,  
					'where'	  => $where,
				  );
		$data['aDeployment'] = $oDeployment->getAllDeployments($params);
		$deploymentFolder=tools::deploymentFolderName(array('name'=>$data['aDeployment'][0]->deployment_name))."-".$data['aDeployment'][0]->deployment_id;
		#tools::cleaningName($data['aDeployment'][0]->deployment_name)."-".$data['aDeployment'][0]->deployment_id;

		$view = 'reliance-audio-deployment_details';
		$limit	= 1000;
		$start	= 0;
		$params = array(
					'limit'	  => $limit,  
					'orderby' => '  ORDER BY id asc',  
					'start'   => $start,  
					'where'	  => " AND deployment_id=".$id,
				  );
		$data['aContent'] = $oDeployment->getDeploymentsDetails( $params );
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display song details start	
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
				$data = $oDeployment->doMultiAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('Reliance Audio Deploment', $contentAction, '23', (int)$this->user->user_id, "Reliance Audio Deployment Ids: '".implode("','", $_POST['select_ids'])."' " );

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

			if($contentModel=='deployment' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oDeployment->doAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('Reliance Audio Deployment', $contentAction, '23', (int)$this->user->user_id, "Reliance Audio Deployment Id: ".$contentId."" );
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

//	print_r($oSong);
	$lisData = getlist( $oSong );
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['aSearch']	 = $lisData['aSearch'];
}

function getlist( $oSong ){
	global $oMysqli;
	$oDeployment=new deployment();

	/* Search Param start */
	$srcDeployment = cms::sanitizeVariable( $_GET['srcDeployment'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	
	
	$where		 = ' AND service_provider="RELIANCEAUDIO"';
	if( $srcDeployment != '' ){
		$where .= ' AND deployment_name like "'.$oMysqli->secure($srcDeployment).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	
	$data['aSearch']['srcDeployment'] = $srcDeployment;
	$data['aSearch']['srcCType'] 	= $srcCType;
	/* Search Param end */
	
	/* Show Song as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => '',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oDeployment->getAllDeployments( $params );
	
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oDeployment->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = SITEPATH."reliance-audio-deployment?srcDeployment=$srcDeployment&srcCType=$srcCType&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );