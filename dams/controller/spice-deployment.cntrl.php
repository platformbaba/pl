<?php   //SPICE DEPLOYMENT 
ob_start(); 
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
#error_reporting(E_ALL);
#ini_set('display_errors', '1');
$view = 'spice-deployment_all_list';   
$oDeployment = new deployment();
$oSong = new song();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$imiConfig=array(9,10,11,12);//config ids related to spice deployments
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'legal') );
$id = (int)$_GET['id']; 
$coidFix=429;
$cpidFix=1302;
$clidFix=905;
$endDateFix='2014-03-31';
$exclusiveFix='TRUE';
$clanoFix='407ESare';
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
	$deploymentFolder=tools::cleaningName($data['aDeployment'][0]->deployment_name)."-".$data['aDeployment'][0]->deployment_id;
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
					if(!$songData[0]->release_date){
						$releaseYear=$albumYear;
					}
					$deploymentId=(int)$_POST['deploymentId'];
					
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$albumData[0]->album_name,'songTitle'=>$songData[0]->song_name,'limit'=>25));
					
					$providers_details = NULL;
					$providers_details = array('TerritoryCode'=>'WW','Pline_Text'=>'Saregama' , 'Pline_Year'=>$releaseYear ,'Cline_Text' =>'Saregama','Cline_Year'=>$releaseYear,'label'=>'Saregama');
					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => $songData[0]->song_name,
								'language' => $language,
								'album' => ucwords(strtolower($albumData[0]->album_name)),
								'keyArtist' => $singerString,
								'musicDirector' => $mDirectorString,
								'searchKey' => $starcastAlbumString,
								'keyDirector' => $directorString,
								'keyProducer' => $producerString,
								'releaseYear' => $releaseYear,
								'albumYear' => $albumYear,
								'genre' => "Bollywood",
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
					TOOLS::log('Song added to Spice Deployment', $action, '24', (int)$this->user->user_id, "Deployment Id: ".$deployed."" );
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					header('Location: '.SITEPATH.'spice-deployment?action=edit&id='.$deploymentId.'&do=manage');
					exit;
				}
			}					
		}
		$view = 'spice-deployment_list';
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
			$oPage->url = "spice-deployment?action=edit&do=song&srcSong=$srcSong&srcIsrc=$srcIsrc&srcAlbum=$srcAlbum&autosuggestalbum_hddn=$autosuggestalbum_hddn&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcSongId=$srcSongId&submitBtn=Search&page={page}";
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
			$label=$_POST['label'];
			$album=$_POST['album'];
			$musicDirector=$_POST['musicDirector'];
			$keyDirector=$_POST['keyDirector'];
			$releaseYear=$_POST['releaseYear'];
			$genre=$_POST['genre'];
			$starcast=$_POST['starcast'];
			$lyricist=$_POST['lyricist'];
			$singer=$_POST['singer'];
			$label=$_POST['label'];
			$isrc=$_POST['isrc'];
			$deploymentId = (int)$_POST['deploymentId'];
			$providerCode = $_POST['providerCode'];

			$file_0808m="";
			$file_0808m40s="";
			$file_1616m="";
			$file_0808mfull="";
			if(!empty($primaryId)){
				foreach($primaryId as $pId){
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$album[$pId],'songTitle'=>$songTitle[$pId],'limit'=>25));
					if($songTitle[$pId]==""){
						$aError[]="Please enter title.";
					}
					if($language[$pId]==""){
						$aError[]="Please enter title".$songTitle[$pId].".";
					}
					if($album[$pId]==""){
						$aError[]="Please enter album for ".$songTitle[$pId].".";
					}
					if($musicDirector[$pId]==""){
						$aError[]="Please enter music director for ".$songTitle[$pId].".";
					}
					if($keyDirector[$pId]==""){
						$aError[]="Please enter director for ".$songTitle[$pId].".";
					}
					if($releaseYear[$pId]=="" || $releaseYear[$pId]=="0000"){
						$aError[]="Please enter release year for ".$songTitle[$pId].".";
					}
					if($genre[$pId]==""){
						$aError[]="Please enter genre for ".$songTitle[$pId].".";
					}
					if($starcast[$pId]==""){
						$aError[]="Please enter filmstar for ".$songTitle[$pId].".";
					}
					if($lyricist[$pId]==""){
						$aError[]="Please enter lyricist for ".$songTitle[$pId].".";
					}
					if($singer[$pId]==""){
						$aError[]="Please enter artist for ".$songTitle[$pId].".";
					}
					if($label[$pId]==""){
						$aError[]="Please enter label for ".$songTitle[$pId].".";
					}
					if($isrc[$pId]==""){
						$aError[]="Please enter isrc for ".$songTitle[$pId].".";
					}

					$providers_details = array('TerritoryCode'=>'WW','Pline_Text'=>'Saregama' , 'Pline_Year'=>$releaseYear[$pId] ,'Cline_Text' =>'Saregama','Cline_Year'=>$releaseYear[$pId],'label'=>$label[$pId]);
				
					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => ucwords(strtolower($songTitle[$pId])),
								'language' => $language[$pId],
								'album' => ucwords(strtolower($album[$pId])),
								'keyArtist' => $keyArtist[$pId],
								'musicDirector' => $musicDirector[$pId],
								'keyDirector' => $keyDirector[$pId],
								'keyProducer' => $keyProducer[$pId],
								'releaseYear' => $releaseYear[$pId],
								'genre' => $genre[$pId],
								'starcast' => $starcast[$pId],
								'lyricist' => $lyricist[$pId],
								'singer' => $singer[$pId],
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
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>1));
					}else{
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					}
				}
				if($deployed && empty($aError)){
					TOOLS::log('Song Meta upadated to Spice Deployment', $action, '24', (int)$this->user->user_id, "Deployment Id: ".$deployed."" );
					header('Location:'.SITEPATH.'spice-deployment?action=edit&id='.$deploymentId.'&do=manage&msg=Action completed susseccfully!');
					exit;
				}
				$data['aError']=$aError;
				$view = "spice-deployment_manage";
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
			$view = "spice-deployment_manage";
			$limit	= 100;
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
	elseif($do=="xls"){
			$view = "spice-deployment_manage";
			$limit	= 10000;
			$start	= 0;
			$params = array(
						'limit'	  => $limit,  
						'orderby' => '  ORDER BY id asc',  
						'start'   => $start,  
						'where'	  => " AND deployment_id=".$id,
					  );
			$dataContent = $oDeployment->getDeploymentsDetails( $params );
			if($dataContent){
				$sPreviousAlbumName = "";
				$iFlag = 1;
				$iIncrementedValue = 1;
				$sExcelRow = "Date_Time\tUpload_Indicator\tResource_Type\tISRC\tAlbum_Title\tAlbum_SubTitle\tInstrumental\tResource_Reference\tLanguage\tPline_Text\tPline_Year\tCline_Text\tCline_Year\tGenre\tParentalWarningType\tTerritoryCode\tTitle\tEffective_Date\tArtis\tLabel\tContent_Provider\tSub_CP\tTechnical_Reference\tTechnical Name \t \n";

				foreach($dataContent as $kData=>$vData){
					$providers_details=json_decode($vData->providers_details,true);
					$sISRC      = $vData->isrc;
					$sLanguage  = ucwords(strtolower($vData->language));
					$sSong      = ucwords(strtolower($vData->title));
					$sFlm_title = ucwords(strtolower($vData->album));
					$sAlb_title = ucwords(strtolower($vData->album));
					$sArtist    = ucwords(strtolower($vData->singer));
					$sMusicdr   = ucwords(strtolower($vData->music_director));
					$sLyricist  = ucwords(strtolower($vData->lyricist));
					$sFilmstar  = ucwords(strtolower($vData->starcast));
					$sDirector  = ucwords(strtolower($vData->director));
					$sGenre  = ucwords(strtolower($vData->genre));
					$sYear  = ucwords(strtolower($vData->release_year));
					$sLabel     = ucwords(strtolower($providers_details['label']));
					$sTerritory = $providers_details['TerritoryCode'];
					
					$sSingerConcat = "";
					if(strstr($sArtist,",")){
						$sExplodedSinger = explode(',',$sArtist);
						foreach($sExplodedSinger as $sExplodedSingerVal){
							$sSingerConcat .= ucwords(strtolower($sExplodedSingerVal))."{Singer}|";
						}
					}else{
						$sSingerConcat .= ucwords(strtolower($sArtist))."{Singer}|";
					}
				
					$sMusicdrConcat = "";
					if(strstr($sMusicdr,"/")){
						$sExplodedMusicdr = explode(',',$sMusicdr);
						foreach($sExplodedMusicdr as $sExplodedMusicdrVal){
							$sMusicdrConcat .= ucwords(strtolower($sExplodedMusicdrVal))."{Composer}|";
						}
					}else{
						$sMusicdrConcat .= ucwords(strtolower($sMusicdr))."{Composer}|";
				
					}
				
					$sLyricistConcat = "";
					if(strstr($sLyricist,",")){
						$sExplodedLyricist = explode(',',$sLyricist);
						foreach($sExplodedLyricist as $sExplodedLyricistVal){
							$sLyricistConcat .= ucwords(strtolower($sExplodedLyricistVal))."{Lyricist}|";
						}
					}else{
						$sLyricistConcat .= ucwords(strtolower($sLyricist))."{Lyricist}|";
					}
					
					$sFilmstarConcat = "";
					if(strstr($sFilmstar,",")){
						$sExplodedFilmstar = explode(',',$sFilmstar);
						foreach($sExplodedFilmstar as $sExplodedFilmstarVal){
							$sFilmstarConcat .= ucwords(strtolower($sExplodedFilmstarVal))."{Performer}|";
						}
					}else{
						$sFilmstarConcat .= ucwords(strtolower($sFilmstar))."{Performer}|";
					}
				
					$sArtists = substr($sSingerConcat.$sMusicdrConcat.$sLyricistConcat.$sFilmstarConcat,0,-1);
					$sPerformer = substr($sFilmstarConcat,0,-1);
					
					if($sPreviousAlbumName == $sAlb_title || $iFlag == 1){

						$sExcelRow .= ""."\t";
						$sExcelRow .= "Insert"."\t";
						$sExcelRow .= "Music"."\t";
						$sExcelRow .= $sISRC."\t";
						$sExcelRow .= $sAlb_title."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $iIncrementedValue."\t";
						$sExcelRow .= $sLanguage."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sYear."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sYear."\t";
						$sExcelRow .= $sGenre."\t";
						$sExcelRow .= "0"."\t";
						$sExcelRow .= $sTerritory."\t";
						$sExcelRow .= $sSong."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $sArtists."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= "36|38|37|5|4|74|54|57|56|67|66|68|63|65|42|13|55|12|10|84|76|85|87"."\t";
						$sExcelRow .= "TR36_".$sISRC.".wav|TR38_".$sISRC.".wav|TR37_".$sISRC.".wav|TR5_".$sISRC.".mp3|TR4_".$sISRC.".mp3|TR74_".$sISRC.".mp3|TR54_".$sISRC.".mp3|TR57_".$sISRC.".mp3|TR56_".$sISRC.".mp3|TR67_".$sISRC.".3gp|TR66_".$sISRC.".3gp|TR68_".$sISRC.".3gp|TR63_".$sISRC.".m4a|TR65_".$sISRC.".m4a|TR42_".$sISRC.".wav|TR13_".$sISRC.".wav|TR55_".$sISRC.".wav|TR12_".$sISRC.".wav|TR10_".$sISRC.".mp3|TR84_".$sISRC.".wav|TR76_".$sISRC.".amr|TR85_".$sISRC.".wav|TR87_".$sISRC.".wav"."\t";
						$sExcelRow .="\n";
						$sPreviousAlbumName = $sAlb_title;
						$sPreviousYear = $sYear;
						$iFlag = 0;
						$iIncrementedValue = $iIncrementedValue+1;

						$sPreviousLanguage = $sLanguage;
						$sPreviousLabel = $sLabel;
						$sPreviousGenre = $sGenre;
						$sPreviousPerformer =$sPerformer;
					}else{

						$sExcelRow .= ""."\t";
						$sExcelRow .= "Insert"."\t";
						$sExcelRow .= "Image"."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $sPreviousAlbumName."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $iIncrementedValue."\t";
						$sExcelRow .= $sPreviousLanguage."\t";
						$sExcelRow .= $sPreviousLabel."\t";
						$sExcelRow .= $sPreviousYear."\t";
						$sExcelRow .= $sPreviousLabel."\t";
						$sExcelRow .= $sPreviousYear."\t";
						$sExcelRow .= $sGenre."\t";
						$sExcelRow .= "0"."\t";
						$sExcelRow .= $sTerritory."\t";
						$sExcelRow .= $sPreviousAlbumName."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $sPreviousPerformer."\t";
						$sExcelRow .= $sPreviousLabel."\t";
						$sExcelRow .= $sPreviousLabel."\t";
						$sExcelRow .= $sPreviousLabel."\t";
						$sExcelRow .= "21"."\t";
						$sExcelRow .= $sPreviousAlbumName.".jpg"."\t";
						$sExcelRow .="\n";
						$sPreviousAlbumName = $sAlb_title;
						$iFlag = 0;
						$iIncrementedValue = 1;
						
						$sExcelRow .= "\n";
				
						$sExcelRow .= ""."\t";
						$sExcelRow .= "Insert"."\t";
						$sExcelRow .= "Music"."\t";
						$sExcelRow .= $sISRC."\t";
						$sExcelRow .= $sAlb_title."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $iIncrementedValue."\t";
						$sExcelRow .= $sLanguage."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sYear."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sYear."\t";
						$sExcelRow .= $sGenre."\t";
						$sExcelRow .= "0"."\t";
						$sExcelRow .= $sTerritory."\t";
						$sExcelRow .= $sSong."\t";
						$sExcelRow .= ""."\t";
						$sExcelRow .= $sArtists."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= $sLabel."\t";
						$sExcelRow .= "36|38|37|5|4|74|54|57|56|67|66|68|63|65|42|13|55|12|10|84|76|85|87"."\t";
						$sExcelRow .= "TR36_".$sISRC.".wav|TR38_".$sISRC.".wav|TR37_".$sISRC.".wav|TR5_".$sISRC.".mp3|TR4_".$sISRC.".mp3|TR74_".$sISRC.".mp3|TR54_".$sISRC.".mp3|TR57_".$sISRC.".mp3|TR56_".$sISRC.".mp3|TR67_".$sISRC.".3gp|TR66_".$sISRC.".3gp|TR68_".$sISRC.".3gp|TR63_".$sISRC.".m4a|TR65_".$sISRC.".m4a|TR42_".$sISRC.".wav|TR13_".$sISRC.".wav|TR55_".$sISRC.".wav|TR12_".$sISRC.".wav|TR10_".$sISRC.".mp3|TR84_".$sISRC.".wav|TR76_".$sISRC.".amr|TR85_".$sISRC.".wav|TR87_".$sISRC.".wav"."\t";
						$sExcelRow .="\n";
						$sPreviousAlbumName = $sAlb_title;
						$sPreviousYear = $sYear;
						$iIncrementedValue = $iIncrementedValue+1;
						
						$sPreviousLanguage = $sLanguage;
						$sPreviousLabel = $sLabel;
						$sPreviousGenre = $sGenre;
						$sPreviousPerformer =$sPerformer;
					}
				}
				/* for last album*/
				$sExcelRow .= ""."\t";
				$sExcelRow .= "Insert"."\t";
				$sExcelRow .= "Image"."\t";
				$sExcelRow .= ""."\t";
				$sExcelRow .= $sPreviousAlbumName."\t";
				$sExcelRow .= ""."\t";
				$sExcelRow .= ""."\t";
				$sExcelRow .= $iIncrementedValue."\t";
				$sExcelRow .= $sLanguage."\t";
				$sExcelRow .= $sLabel."\t";
				$sExcelRow .= $sPreviousYear."\t";
				$sExcelRow .= $sLabel."\t";
				$sExcelRow .= $sPreviousYear."\t";
				$sExcelRow .= $sGenre."\t";
				$sExcelRow .= "0"."\t";
				$sExcelRow .= $sTerritory."\t";
				$sExcelRow .= $sPreviousAlbumName."\t";
				$sExcelRow .= ""."\t";
				$sExcelRow .= $sPerformer."\t";
				$sExcelRow .= $sLabel."\t";
				$sExcelRow .= $sLabel."\t";
				$sExcelRow .= $sLabel."\t";
				$sExcelRow .= "21"."\t";
				$sExcelRow .= $sPreviousAlbumName.".jpg"."\t";
				$sExcelRow .="\n";
			}
			
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
			$deploymentFolder=tools::removeSpChars(str_replace(" ","",ucwords(strtolower($data['aDeployment'][0]->deployment_name))))."-".$data['aDeployment'][0]->deployment_id;
			
			TOOLS::log('Generated xls file for Spice Deployment', $action, '24', (int)$this->user->user_id, "Deployment Id: ".$id."" );
			$filename = $deploymentFolder.".xls";
			header('Content-type: application/ms-excel');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $sExcelRow;
			exit;
	}
	/* Form */
	$view = 'spice-deployment_form';
	$id = (int)$_GET['id']; 
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$deploymentName	=	cms::sanitizeVariable($_POST['deploymentName']);
		if($deploymentName==""){
			$aError[]="Enter Deployment Name.";
		}
		$postData=array(
					'deploymentName'=>$deploymentName,
					'serviceProvider'=>"SPICE",
					);
		if(empty($aError)){ 
			$aData = $oDeployment->saveDeployment( $postData );
			if($id){
				$aData=$id;
			}
			$folderNameToDeploy=$deploymentFolder=tools::removeSpChars(str_replace(" ","",ucwords(strtolower($deploymentName))))."-".$aData;
			if(!file_exists(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy)){
				chmod(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,777);
				mkdir(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,0777);
			}
			/* Write DB Activity Logs */
			TOOLS::log('Spice Deployment', $action, '24', (int)$this->user->user_id, "Deployment Id: ".$aData."" );
			header('location:'.SITEPATH.'spice-deployment?action=edit&id='.$aData."&do=song");exit;
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
		$deploymentFolder=tools::cleaningName($data['aDeployment'][0]->deployment_name)."-".$data['aDeployment'][0]->deployment_id;

		$view = 'spice-deployment_details';
		$limit	= 10000;
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
				TOOLS::log('Spice Deploment', $contentAction, '24', (int)$this->user->user_id, "Spice Deployment Ids: '".implode("','", $_POST['select_ids'])."' " );

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
				TOOLS::log('Spice Deployment', $contentAction, '24', (int)$this->user->user_id, "Spice Deployment Id: ".$contentId."" );
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
	
	
	$where		 = ' AND service_provider="SPICE"';
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
	$oPage->url = SITEPATH."spice-deployment?srcDeployment=$srcDeployment&srcCType=$srcCType&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );