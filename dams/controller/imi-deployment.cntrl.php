<?php    //IMI DEPLOYMENT 
ob_start();
#error_reporting(E_ALL);
#ini_set('display_errors', '1');
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$view = 'imi-deployment_all_list';   
$oDeployment = new deployment();
$oSong = new song();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$imiConfig=array(9,10,11,12);//config ids related to imi deployments
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
					$deploymentId=(int)$_POST['deploymentId'];
					
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$albumData[0]->album_name,'songTitle'=>$songData[0]->song_name,'limit'=>25));
					$file_0808m=NULL;
					$data_0808m=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=11 AND status=1"));
					$file_0808m_arr=NULL;
					if(!empty($data_0808m)){
						if(sizeof($data_0808m)==1){
							$oFile_0808m=$data_0808m[0]->path;
							if($oFile_0808m){ 
								$file_0808m="0808m_".$totalFileName.".wav";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_0808m,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_0808m)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_0808m as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_0808m_arr=$arrOfFile;
						}	
					}
					$file_0808m40S=NULL;
					$data_0808m40S=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=9 AND status=1"));
					$file_0808m40S_arr=NULL;
					if(!empty($data_0808m40S)){
						if(sizeof($data_0808m40S)==1){
							$oFile_0808m40S=$data_0808m40S[0]->path;
							if($oFile_0808m40S){
								$file_0808m40S="0808m40S_".$totalFileName.".wav";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_0808m40S,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_0808m40S)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_0808m40S as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_0808m40S_arr=$arrOfFile;
						}	
					}
					$file_1616m=NULL;
					$data_1616m=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=10 AND status=1"));
					$file_1616m_arr=NULL;
					if(!empty($data_1616m)){
						if(sizeof($data_1616m)==1){
							$oFile_1616m=$data_1616m[0]->path;
							if($oFile_1616m){
								$file_1616m="1616m_".$totalFileName.".wav";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_1616m,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_1616m)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_1616m as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_1616m_arr=$arrOfFile;
						}	
					}
					$file_0808mFull=NULL;
					$data_0808mFull=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=12 AND status=1"));
					$file_0808mFull_arr=NULL;
					if(!empty($data_0808mFull)){
						if(sizeof($data_0808mFull)==1){
							$oFile_0808mFull=$data_0808mFull[0]->path;
							if($oFile_0808mFull){
								$file_0808mFull="0808mFull_".$totalFileName.".wav";
								if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_0808mFull,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_0808mFull)){
									#echo "done";
								}else{
									#echo "error";
								}
							}
						}else{
							$arrOfFile=array();
							foreach($data_0808mFull as $fVal){
								$arrOfFile[$fVal->id]=$fVal->path;
							}
							$file_0808mFull_arr=$arrOfFile;
						}	
					}
					$providers_details = NULL;
					$providers_details = array('0808m'=>$file_0808m ,'0808m40S'=>$file_0808m40S , '1616m'=>$file_1616m ,'0808mFull' =>$file_0808mFull,'coid'=>$coidFix,'cpid'=>$cpidFix,'clid'=>$clidFix,'startDate'=>date('Y-m-d'),'endDate'=>$endDateFix,'exclusive'=>$exclusiveFix,'clano'=>$clanoFix,'file_0808m_arr'=>$file_0808m_arr,'file_0808m40S_arr'=>$file_0808m40S_arr,'file_0808mFull_arr'=>$file_0808mFull_arr,'file_1616m_arr'=>$file_1616m_arr);
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
								'searchKey' => $starcastAlbumString,
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
					TOOLS::log('Song added to IMI Deployment', $action, '22', (int)$this->user->user_id, "Deployment Id: ".$deployed."" );
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					header('Location: '.SITEPATH.'imi-deployment?action=edit&id='.$deploymentId.'&do=manage');
					exit;
				}
			}					
		}
		$view = 'imi-deployment_list';
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
			$oPage->url = "imi-deployment?action=edit&do=song&srcSong=$srcSong&srcIsrc=$srcIsrc&srcAlbum=$srcAlbum&autosuggestalbum_hddn=$autosuggestalbum_hddn&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcSongId=$srcSongId&submitBtn=Search&page={page}";
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
			$file_0808m=$_POST['0808m'];
			$file_0808m40s=$_POST['0808m40s'];
			$file_1616m=$_POST['1616m'];
			$file_0808mfull=$_POST['0808mfull'];
			$deploymentId = (int)$_POST['deploymentId'];
			$providerCode = $_POST['providerCode'];

			$file_0808m="";
			$file_0808m40s="";
			$file_1616m="";
			$file_0808mfull="";
			if(!empty($primaryId)){
				foreach($primaryId as $pId){
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$album[$pId],'songTitle'=>$songTitle[$pId],'limit'=>25));
					if($_FILES['file_0808m40s']['name'][$pId]){
						$uFileName=$_FILES['file_0808m40s']['name'][$pId];
						$tmpName=$_FILES['file_0808m40s']['tmp_name'][$pId];
						$fileSize=$_FILES['file_0808m40s']['size'][$pId];
						$folderPath="/8b64k8000hzm40s/".substr($isrc[$pId],-2)."/";
						$fileName="9-".$isrc[$pId].".wav";
						$sTempAudioPath	= "wav".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize0808m40s=$fileSize;
						$succ=1;
						if($fileSize0808m40s>313){
							$succ=0;
							$aError[]="Please upload 0808m40S file of proper size for ".$songTitle[$pId].".";
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=9 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/9v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("wav"),
										"size" =>"313",
										"oSize" => $fileSize, 
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy="0808m40S_".$totalFileName.".wav";
							$file_0808m40S=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>9,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}
					}elseif(!empty($_POST['file_0808m40S_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_0808m40S_rad_'.$pId];
							$file_0808m40S="0808m40S_".$totalFileName.".wav";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_0808m40S)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_0808m40S=$_POST['hidden_file_0808m40s'][$pId];
					}
					if($_FILES['file_1616m']['name'][$pId]){
						$uFileName=$_FILES['file_1616m']['name'][$pId];
						$tmpName=$_FILES['file_1616m']['tmp_name'][$pId];
						$fileSize=$_FILES['file_1616m']['size'][$pId];
						$folderPath="/16b128k8000hzm40s/".substr($isrc[$pId],-2)."/";
						$fileName="10-".$isrc[$pId].".wav";
						$sTempAudioPath	= "wav".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize1616m=$fileSize;
						$succ=1;
						if($fileSize1616m>626){
							$succ=0;
							$aError[]="Please upload 1616m file of proper size for ".$songTitle[$pId].".";
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=10 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/10v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("wav"),
										"size" =>"626",
										"oSize" => $fileSize,
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy="1616m_".$totalFileName.".wav";
							$file_1616m=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>10,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}							
						}
					}elseif(!empty($_POST['file_16168m_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_16168m_rad_'.$pId];
							$file_1616m="16168m_".$totalFileName.".wav";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_1616m)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_1616m=$_POST['hidden_file_1616m'][$pId];
					}
					if($_FILES['file_0808m']['name'][$pId]){
						$uFileName=$_FILES['file_0808m']['name'][$pId];
						$tmpName=$_FILES['file_0808m']['tmp_name'][$pId];
						$fileSize=$_FILES['file_0808m']['size'][$pId];
						$folderPath="/8b64k8000hzm60s/".substr($isrc[$pId],-2)."/";
						$fileName="11-".$isrc[$pId].".wav";
						$sTempAudioPath	= "wav".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize0808m=$fileSize;
						$succ=1;
						if($fileSize0808m>469){
							$succ=0;
							$aError[]="Please upload 0808m file of proper size for ".$songTitle[$pId].".";
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=11 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/11v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("wav"),
										"size" =>"469",
										"oSize" => $fileSize,
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy="0808m_".$totalFileName.".wav";
							$file_0808m=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>11,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}
					}elseif(!empty($_POST['file_0808m_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_0808m_rad_'.$pId];
							$file_0808m="0808m_".$totalFileName.".wav";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_0808m)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_0808m=$_POST['hidden_file_0808m'][$pId];
					}
					if($_FILES['file_0808mfull']['name'][$pId]){
						$uFileName=$_FILES['file_0808mfull']['name'][$pId];
						$tmpName=$_FILES['file_0808mfull']['tmp_name'][$pId];
						$fileSize=$_FILES['file_0808mfull']['size'][$pId];
						$folderPath="/8b64k8000hzm00s/".substr($isrc[$pId],-2)."/";
						$fileName="12-".$isrc[$pId].".wav";
						$sTempAudioPath	= "wav".$folderPath.$fileName;
						$fileSize=round($fileSize/1024);
						$fileSize0808mfull=$fileSize;
						$succ=1;
						if($fileSize0808mfull>3750){
							$aError[]="Please upload 0808mFull file of proper size for ".$songTitle[$pId].".";
							$succ=0;
						}
						if($succ){
							$tCnt=$oDeployment->getSongConfigTotalCount(array('where'=>" AND song_id=".$contentId[$pId]." AND config_id=12 AND `status`=1"));
							$cnt=(int)$tCnt;
							$v=1;
							if($cnt>0){
								$v=(int)$cnt+1;
								$sTempAudioPath=preg_replace("/\/[0-9a-z]{1,}-/","/12v".$v."-",$sTempAudioPath);
							}
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("wav"),
										"size" =>"3750",
										"oSize" => $fileSize,
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy="0808mFull_".$totalFileName.".wav";
							$file_0808mFull=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>12,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}	
					}elseif(!empty($_POST['file_0808mFull_rad_'.$pId])){
							$fileNametoDeploy=MEDIA_SERVERPATH_SONGEDITS.$_POST['file_0808mFull_rad_'.$pId];
							$file_0808mFull="0808mFull_".$totalFileName.".wav";
								if(copy($fileNametoDeploy,MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$file_0808mFull)){
									#echo "done";
								}else{
									#echo "error";
								}
					}else{
						$file_0808mFull=$_POST['hidden_file_0808mfull'][$pId];
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
					/*if($coid[$pId]=="" || $coid[$pId]=="0"){
						$aError[]="Please enter coid for ".$songTitle[$pId].".";
					}
					if($cpid[$pId]=="" || $cpid[$pId]=="0"){
						$aError[]="Please enter cpid for ".$songTitle[$pId].".";
					}*/
					if($startDate[$pId]=="" || $startDate[$pId]=="0000-00-00"){
						$aError[]="Please enter start date for ".$songTitle[$pId].".";
					}
					if($endDate[$pId]=="" || $endDate[$pId]=="0000-00-00"){
						$aError[]="Please enter end date for ".$songTitle[$pId].".";
					}
					/*if($exclusive[$pId]==""){
						$aError[]="Please enter exclusive for ".$songTitle[$pId].".";
					}*/
					if($album[$pId]==""){
						$aError[]="Please enter album for ".$songTitle[$pId].".";
					}
					/*if($clano[$pId]==""){
						$aError[]="Please enter clano for ".$songTitle[$pId].".";
					}*/
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
					if($genre[$pId]==""){
						$aError[]="Please enter genre for ".$songTitle[$pId].".";
					}
					if($starcast[$pId]==""){
						$aError[]="Please enter starcast for ".$songTitle[$pId].".";
					}
					if($lyricist[$pId]==""){
						$aError[]="Please enter lyricist for ".$songTitle[$pId].".";
					}
					if($singer[$pId]==""){
						$aError[]="Please enter singer for ".$songTitle[$pId].".";
					}
					if($isrc[$pId]==""){
						$aError[]="Please enter original code for ".$songTitle[$pId].".";
					}
					if($file_0808m==""){
						$aError[]="Please upload 0808m file for ".$songTitle[$pId];
					}
					if($file_0808m40S==""){
						$aError[]="Please upload 0808m40S file for ".$songTitle[$pId];
					}
					if($file_1616m==""){
						$aError[]="Please upload 1616m file for ".$songTitle[$pId];
					}
					if($file_0808mFull==""){
						$aError[]="Please upload 0808mFull file for ".$songTitle[$pId];
					}
					

					$providerCode = (int)$providerCode[$pId];
					if(empty($aError) && $providerCode==0){
							$myFile = MEDIA_SEVERPATH_DEPLOY."providerCode.txt";
							$myFileR = MEDIA_READ_SEVERPATH_DEPLOY."providerCode.txt";
							$fh = fopen($myFileR, 'r') or die("can't open file");
							$contents = fread($fh,filesize($myFileR));
							$providerCode=(int)$contents+1;
							fclose($fh);
							$fh = fopen($myFile, 'w') or die("can't open file");
							fwrite($fh, $providerCode);
							fclose($fh);
					}
					
					$providers_details = array("category"=>$category[$pId],"subCategory"=>$subCategory[$pId],"startDate"=>$startDate[$pId],'0808m'=>$file_0808m ,'0808m40S'=>$file_0808m40S , '1616m'=>$file_1616m ,'0808mFull' =>$file_0808mFull,"providerCode" => $providerCode,'coid'=>$coidFix,'cpid'=>$cpidFix,'clid'=>$clidFix,'endDate'=>$endDate[$pId],'exclusive'=>$exclusiveFix,'clano'=>$clanoFix);
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
						$createXML=$oDeployment->generateImiXml($params);
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>1));
					}else{
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					}
				}
				if($deployed && empty($aError)){
					TOOLS::log('Song Meta upadated to IMI Deployment', $action, '22', (int)$this->user->user_id, "Deployment Id: ".$deployed."" );
					header('Location:'.SITEPATH.'imi-deployment?action=edit&id='.$deploymentId.'&do=manage&msg=Action completed susseccfully!');
					exit;
				}
				$data['aError']=$aError;
				$view = "imi-deployment_manage";
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
			$view = "imi-deployment_manage";
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
			TOOLS::log('Generated zip file for IMI Deployment', $action, '22', (int)$this->user->user_id, "Deployment Id: ".$id."" );
			exit;		
	}
	/* Form */
	$view = 'imi-deployment_form';
	$id = (int)$_GET['id']; 
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$deploymentName	=	cms::sanitizeVariable($_POST['deploymentName']);
		if($deploymentName==""){
			$aError[]="Enter Deployment Name.";
		}
		$postData=array(
					'deploymentName'=>$deploymentName,
					'serviceProvider'=>"IMI",
					);
		if(empty($aError)){ 
			$aData = $oDeployment->saveDeployment( $postData );
			if($id){
				$aData=$id;
			}
			$folderNameToDeploy=$deploymentFolder=tools::cleaningName($deploymentName)."-".$aData;
			if(!file_exists(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy)){
				chmod(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,777);
				mkdir(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,0777);
			}
			/* Write DB Activity Logs */
			TOOLS::log('IMI Deployment', $action, '22', (int)$this->user->user_id, "Deployment Id: ".$aData."" );
			header('location:'.SITEPATH.'imi-deployment?action=edit&id='.$aData."&do=song");exit;
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

		$view = 'imi-deployment_details';
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
				TOOLS::log('IMI Deploment', $contentAction, '22', (int)$this->user->user_id, "IMI Deployment Ids: '".implode("','", $_POST['select_ids'])."' " );

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
				TOOLS::log('IMI Deployment', $contentAction, '22', (int)$this->user->user_id, "IMI Deployment, Id: ".$contentId."" );
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
	
	
	$where		 = ' AND service_provider="IMI"';
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
	$oPage->url = SITEPATH."imi-deployment?srcDeployment=$srcDeployment&srcCType=$srcCType&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );