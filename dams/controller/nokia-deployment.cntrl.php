<?php    //NOKIA DEPLOYMENT       
ob_start();
set_time_limit(0);
#error_reporting(E_ALL);
#ini_set('display_errors', '1');
$view = 'nokia-deployment_all_list';   
$oDeployment = new deployment();
$oSong = new song();
$oImage = new image();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$nokiaConfig=array(24);//config ids related to nokia deployments
$id = (int)$_GET['id'];  
$genreArray=array(
				"Hindi"=>array(
							"Film"=>"Bollywood",
							"Non Film" => array("Pop Album"=>"Indipop & Remix",
												"Remix"=>"Indipop & Remix",
												"Indian / Hindustani Classical"=>"Hindustani Classical",
												"Devotional"=>"Devotional",
												"Bhajan"=>"Devotional",
												"Bhakti"=>"Devotional",
												"Ghazals"=>"Ghazals",
												"Sufi"=>"Ghazals",
												),
						),
				"Tamil"=>array(
							"Film"=>array("Devotional"=>"South Devotional",
											"Bhajan"=>"South Devotional",
											"Bhakti"=>"South Devotional",
											"Indian / Hindustani Classical"=>"Carnatic Classical",
											),
							"Non Film" => array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),	
						),
				"Malayalam"=>array(
							"Film"=>array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),
							"Non Film" => array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),	
						),
				"Telugu"=>array(
							"Film"=>array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),
							"Non Film" => array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),
						),
				"Kannada"=>array(
							"Film"=>array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),
							"Non Film" => array("Devotional"=>"South Devotional",
												"Bhajan"=>"South Devotional",
												"Bhakti"=>"South Devotional",
												"Indian / Hindustani Classical"=>"Carnatic Classical",
												),	
						),
				"Bengali"=>array(
							"Film"=>"Bengali",
							"Non Film" => "Bengali",	
						),
				"Bhojpuri"=>array(
							"Film"=>"Bhojpuri",
							"Non Film" => "Bhojpuri",	
						),
				"Marathi"=>array(
							"Film"=>"Marathi",
							"Non Film" => "Marathi",	
						),
				"Punjabi"=>array(
							"Film"=>"Punjabi",
							"Non Film" => "Punjabi",	
						),
				"Gujarati"=>array(
							"Film"=>"Gujarati",
							"Non Film" => "Gujarati",	
						),
				"Oriya"=>array(
							"Film"=>"Oriya",
							"Non-Film" => "Oriya",	
						),
				"Rajasthani"=>array(
							"Film"=>"Rajasthani",
							"Non Film" => "Rajasthani",	
						),
				"Other"=>array(
							"Film"=>"Regional/Others",
							"Non Film" => "Regional/Others",	
						),																								
			);
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
			$albumId=(int)$_GET['autosuggestalbum_hddn'];
			$selectedIds=$_POST['select_ids'];
			$deploymentId = (int)$_POST['deploymentId'];
			if($selectedIds){
				$inc=1;
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
					if($albumId>0){
						$albumId=$albumId;
					}else{
						$albumIds=$oSong->getAlbumSongMap(array("where" => " AND song_id=".$contentId." ORDER BY album_id ASC LIMIT 1"));
						$albumId=$albumIds[0]->album_id;
					}	
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
					$couplingIdStr=$albumData[0]->coupling_ids;
					$couplingIdArr=explode(",",$couplingIdStr);
					$couplingId=$couplingIdArr[0];
					$folderNameToDeploy=$couplingId;
					if($inc==1){
							if(!file_exists(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy)){
								mkdir(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,0777);
								chmod(MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy,777);							
							}
							$imageSongMap=$oImage->getImageMap(array("where" => " AND content_id=".$albumId." AND content_type=14"));
							$imageId=0;
							if(!empty($imageSongMap)){
								$imageId=$imageSongMap[0]->image_id;
							}
							$file_1400x1400=NULL;
							$data_1400x1400=$oDeployment->getImageConfigRel(array("where" => " AND image_id=".$imageId." AND config_id=7 AND status=1"));
							$file_jpg1400x1400_arr=NULL;
							if(!empty($data_1400x1400)){
								if(sizeof($data_1400x1400)>0){
									$oFile_1400x1400=$data_1400x1400[0]->path;
									if($oFile_1400x1400){
										$file_1400x1400="Packshot.jpg";
										if(copy(MEDIA_SERVERPATH_IMAGEEDITS.$oFile_1400x1400,MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy."/".$file_1400x1400)){
											#echo "done";
										}else{
											#echo "error";
										}
									}
								}/*else{
									$arrOfFile=array();
									foreach($data_50x50 as $fVal){
										$arrOfFile[$fVal->id]=$fVal->path;
									}
									$file_WapPreviewGif5050_arr=$arrOfFile;
								}*/	
							}
							$totalFileName=strtoupper($songData[0]->isrc);
							$file_full=NULL;
							$data_full=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=24 AND status=1"));
							$file_full_arr=NULL;
							if(!empty($data_full)){
								if(sizeof($data_full)>0){
									$oFile_full=$data_full[0]->path;
									if($oFile_full){ 
										$file_full=$totalFileName.".wav";
										if(copy(MEDIA_SERVERPATH_SONGEDITS.$oFile_full,MEDIA_SEVERPATH_DEPLOY.$folderNameToDeploy."/".$file_full)){
											#echo "done";
										}else{
											#echo "error";
										}
									}
								}else{
									$arrOfFile=array();
									foreach($data_full as $fVal){
										$arrOfFile[$fVal->id]=$fVal->path;
									}
									$file_full_arr=$arrOfFile;
								}	
							}
						}
						$albumType=$albumData[0]->album_type;
						$isFilm = ((1&$albumType)==1)?"Film":"Non Film";
						$isCompilation = ((2&$albumType)==2)?"":"Compilation";
						$tagSongMapData=$oSong->getTagSongMap(array('where'=> " AND song_id=".$contentId));
						$tagSongMapArr=array();
						if($tagSongMapData){
							foreach($tagSongMapData as $tag){
								$tagSongMapArr[]=$tag->tag_id;
							}
							if($tagSongMapArr){
								$mTags=new tags();
								$vParams = array(
											'limit'	  => 100,  
											'orderby' => 'ORDER BY tag_id ASC',  
											'start'   => 0,  
											'where'   => " AND status=1 AND parent_tag_id='1688' AND tag_id IN(".implode(",",$tagSongMapArr).")",
									   );
								$genreList=$mTags->getAllTags($vParams);
							}
							if($isFilm=="Film" && ucfirst($language)=="Hindi"){
								$genreName=$genreArray[ucfirst($language)][$isFilm];
							}elseif(($isFilm=="Film" || $isFilm=="Non Film") && ucfirst($language)!="Hindi" && array_key_exists(ucfirst($language),$genreArray)){
								$genreName=ucfirst($language);
							}
							if($genreList){
								foreach($genreList as $genVal){ 
									if(array_key_exists($genVal->tag_name,$genreArray[ucfirst($language)][$isFilm])){
										$genreName=$genreArray[ucfirst($language)][$isFilm][$genVal->tag_name];
									}		
								}
							}
						}
						if(!$genreName){
							$genreName="Regional/Others";
						}
						$bannerName="";
						$bannerAlbumMapData=$oAlbum->getBannerAlbumMap(array('where'=> " AND album_id=".$albumId));
						$bannerHiddenArr=array();
						if($bannerAlbumMapData){
							foreach($bannerAlbumMapData as $banner){
								$bannerId=$banner->banner_id;
								break;
							}
						}
						if($bannerId){
							$mBanner=new banner();
							$bParams = array(
									'limit'	  => 1,  
									'orderby' => 'ORDER BY banner_name ASC',  
									'start'   => 0,  
									'where'   => " AND status=1 AND banner_id='".$bannerId."'",
							   );
							$bannerData=$mBanner->getAllBanners($bParams);
							$bannerName=$bannerData[0]->banner_name;
						}

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
					$releaseYear = ($songData[0]->release_date)?date("Ymd",strtotime($songData[0]->release_date)):"";
					$albumYear = ($albumData[0]->title_release_date)?date("Ymd",strtotime($albumData[0]->title_release_date)):"";
					$deploymentId=(int)$_POST['deploymentId'];
					
					if($isFilm=="Film"){
						$keyArtist=$mDirectorString;
						if(sizeof($mDirectorArr)>1){
							$keyArtist="Various Artists";
						}
					}else{
						$keyArtist=$singerString;
						if(sizeof($singerArr)>1){
							$keyArtist="Various Artists";
						}
					}
					$duration=$songData[0]->song_duration;
					$pos=strpos($duration,":");
					if($pos===FALSE){
						$duration=tools::format_time($duration);
					}

					$providers_details = NULL;
					$providers_details = array('file'=>$file_full,'fileFullArr'=>$file_full_arr,'duration'=>$duration,'file_1400x1400'=>$file_1400x1400,"isCompilation"=>$isCompilation,"banner"=>$bannerName,"copyright"=>"Saregama","publish"=>"Saregama","label"=>"Saregama","rightTo"=>"Saregama","territory"=>"Global","PPID"=>$folderNameToDeploy,"subGenre"=>$isFilm);
					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => $songData[0]->song_name,
								'language' => $language,
								'album' => ucwords(strtolower($albumData[0]->album_name)),
								'keyArtist' => $keyArtist,
								'musicDirector' => $mDirectorString,
								'keyDirector' => $directorString,
								'keyProducer' => $producerString,
								'releaseYear' => $releaseYear,
								'albumYear' => $albumYear,
								'genre' => $genreName,
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
					$inc++;
				}
				if($deployed){
					$aLogParam = array(
						'moduleName' => 'Nokia Deployment',
						'action' => 'add',
						'moduleId' => 31,
						'editorId' => $this->user->user_id,
						'remark'	=>	'Songs added to NOKIA Deployment. (ID-'.(int)$deployed.')',
						'content_ids' => (int)$deployed
					);
					TOOLS::writeActivityLog( $aLogParam );
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					header('Location: '.SITEPATH.'nokia-deployment?action=edit&id='.$deploymentId.'&do=manage');
					exit;
				}
			}					
		}
		$view = 'nokia-deployment_list';
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
			$oPage->url = "nokia-deployment?action=edit&do=song&srcSong=$srcSong&srcIsrc=$srcIsrc&srcAlbum=$srcAlbum&autosuggestalbum_hddn=$autosuggestalbum_hddn&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcSongId=$srcSongId&submitBtn=Search&page={page}";
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
			$isrc=$_POST['isrc'];
			$ppid=$_POST['ppid'];
			$language=$_POST['language'];
			$genre=$_POST['genre'];
			$subgenre=$_POST['subgenre'];
			$compilation=$_POST['compilation'];
			$album=$_POST['album'];
			$keyArtist=$_POST['keyArtist'];
			$songTitle=$_POST['songTitle'];
			$singer=$_POST['singer'];
			$musicDirector=$_POST['musicDirector'];
			$lyricist=$_POST['lyricist'];
			$banner=$_POST['banner'];
			$keyProducer=$_POST['keyProducer'];
			$keyDirector=$_POST['keyDirector'];
			$copyright=$_POST['copyright'];
			$publish=$_POST['publish'];
			$label=$_POST['label'];
			$rightto=$_POST['rightto'];
			$releaseYear=$_POST['releaseYear'];
			$territory=$_POST['territory'];
			$duration=$_POST['duration'];
			$file_full=$_POST['file_full'];
			$ppid=$_POST['ppid'];
			$deploymentId = (int)$_POST['deploymentId'];
			$deploymentFolder=$ppid[$primaryId[0]];
			$file_full="";
			$file_1400x1400="";
			
			if($_FILES['file_1400x1400']['name'][$pId]){
				$uFileName=$_FILES['file_1400x1400']['name'];
				$tmpName=$_FILES['file_1400x1400']['tmp_name'];
				$fileSize=$_FILES['file_1400x1400']['size'];
				$folderPath=$deploymentFolder;
				$fileName="Packshot.jpg";
				$sTempAudioPath	= MEDIA_SEVERPATH_DEPLOY.$folderPath."/".$fileName;
				list($width, $height, $type, $attr) = getimagesize($tmpName);
				$succ=1;
				if($width!=1400 && $height!=1400){
					$aError[]="Please upload 1400x1400 jpg file of proper dimension!";
					$succ=0;
				}
				if($succ){
					$params = array( "uFile" => $uFileName,
								"file" => $fileName,
								"oFile"	  => $sTempAudioPath,
								"tmpFile" => $tmpName,
								"ext" => array("jpg"),
								);
					$return=tools::uploadFiles($params);
					if(($return['error'])){
						$aError[]=$return['error']." for 1400x1400 jpg file upload.";
					}else{
						$file_1400x1400=$fileName;
					}
				}	
			}else{
				$file_1400x1400=$_POST['hidden_file_1400x1400'];
			}
			if($file_1400x1400==""){
				$aError[]="Please upload 1400x1400 jpg image file!";
			}
			if(!empty($primaryId)){
				foreach($primaryId as $pId){
					$totalFileName=tools::deployedFileName(array('albumTitle'=>$album[$pId],'songTitle'=>$songTitle[$pId],'limit'=>25));
					if($_FILES['file_full']['name'][$pId]){
						$uFileName=$_FILES['file_full']['name'][$pId];
						$tmpName=$_FILES['file_full']['tmp_name'][$pId];
						$fileSize=$_FILES['file_full']['size'][$pId];
						$folderPath="/16b1411k44100hzs00s/".substr($isrc[$pId],-2)."/";
						$fileName="24-".$isrc[$pId].".wav";
						$sTempAudioPath	= "wav".$folderPath.$fileName;
						$succ=1;
						if($succ){
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array("wav"),
										"size" =>"31300",
										);
							$return=tools::saveAudioEdits($params);
							$fileNametoDeploy=strtoupper($isrc[$pId]).".wav";
							$file_full=$fileNametoDeploy;
							if(empty($return['error'])){
								if(copy($return['audio'],MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$fileNametoDeploy)){
									#echo "done";
								}else{
									#echo "error";
								}
								$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$contentId[$pId],'configId'=>24,'path'=>$sTempAudioPath,'version'=>$v));
							}else{
								$aError[]=$return['error']." for ".$songTitle[$pId];
							}
						}
					}else{
						$file_full=$_POST['hidden_file_full'][$pId];
					}
					if($file_full==""){
						$aError[]="Please upload audio file for ".$songTitle[$pId];
					}
					$providers_details = array('file'=>$file_full,'fileFullArr'=>$file_full_arr,'duration'=>$duration[$pId],'file_1400x1400'=>$file_1400x1400,"isCompilation"=>$compilation[$pId],"banner"=>$banner[$pId],"copyright"=>$copyright[$pId],"publish"=>$publish[$pId],"label"=>$label[$pId],"rightTo"=>$rightto[$pId],"territory"=>$territory[$pId],"PPID"=>$ppid[$pId],"subGenre"=>$subgenre[$pId]);
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
								'albumYear' => $releaseYear[$pId],
								'genre' => $genre[$pId],
								'starcast' => $starcastAlbumString,
								'lyricist' => $lyricist[$pId],
								'singer' => $singer[$pId],
								'isrc' => $isrc[$pId],
								'deploymentId' => $deploymentId,
								'contentId' => $contentId[$pId],
								'contentType' => '4',
								'ddId' => $pId,
								'providerDetails' => $providers_details_str,
					);
					$deployed = $oDeployment->addToDeployment($params);
					if(empty($aError)){
						#$createXML=$oDeployment->generateImiXml($params);
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>1));
					}else{
						$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					}
				}
				if(empty($aError)){
					$aLogParam = array(
						'moduleName' => 'Nokia Deployment',
						'action' => 'edit',
						'moduleId' => 31,
						'editorId' => $this->user->user_id,
						'remark'	=>	'Song Meta updated to NOKIA Deployment. (ID-'.(int)$deploymentId.')',
						'content_ids' => (int)$deploymentId
					);
					TOOLS::writeActivityLog( $aLogParam );
					header('Location:'.SITEPATH.'nokia-deployment?action=edit&id='.$deploymentId.'&do=manage&msg=Action completed susseccfully!');
					exit;
				}
				$data['aError']=$aError;
				$view = "nokia-deployment_manage";
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
			$view = "nokia-deployment_manage";
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
	}elseif($do=="xml"){
			$limit	= 1000;
			$start	= 0;
			$params = array(
						'limit'	  => $limit,  
						'orderby' => '  ORDER BY id asc',  
						'start'   => $start,  
						'where'	  => " AND deployment_id=".$id,
					  );
			$allContent = $oDeployment->getDeploymentsDetails( $params );
			$providerDetails=json_decode($allContent[0]->providers_details,true);
			$deploymentFolder=$providerDetails['PPID'];
			$source_dir = MEDIA_READ_SEVERPATH_DEPLOY.$deploymentFolder."/";
			$xml_file = MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/bundle.xml";
			$xml_file_r = MEDIA_READ_SEVERPATH_DEPLOY.$deploymentFolder."/bundle.xml";
			$file_list = tools::createDir($xml_file);
			@unlink($xml_file);

			$album = ucwords($allContent[0]->album);
			$language = ucwords($allContent[0]->language);
			$trackCount=sizeof($allContent);
			$rightto=ucfirst($providerDetails['rightTo']);
			$ppId=$providerDetails['PPID'];
			$packshot=$providerDetails['file_1400x1400'];
			$cline=ucfirst($providerDetails['copyright']);
			$pline=ucfirst($providerDetails['publish']);
			$label=ucfirst($providerDetails['label']);
			$genre=$allContent[0]->genre;
			$releaseDate=$allContent[0]->album_year;
			$territory=ucfirst($providerDetails['territory']);
			$year=date("Y");
						
			if($allContent){
				$top.='<?xml version="1.0" encoding="UTF-8" ?>
<collection cLine="(C) '.$year.' '.$pline.'" explicitLyrics="false" genre="'.$genre.'" label="'.$label.'" od2VersionNumber="3.0" originalReleaseDate="'.$releaseDate.'" pLine="(P) '.$year.' '.$cline.'" packshot="Packshot.jpg" parentalAdvisory="0" partnerProductId="'.$ppId.'" primaryRightsHolder="'.$rightto.'" title="'.$album.'" trackCount="'.$trackCount.'">
<offerings><offering priceBand="T1" promoDate="'.$year.'" releaseDate="'.$year.'" territory="Global"><usage type="AlaCarte" /></offering></offerings>';
				
				$track="";
				$artistsArr=array();
				$t=1;
				foreach($allContent as $k=>$v){
					$providerDetails=json_decode($v->providers_details,true);
					$singerStr=$v->singer;
					$singerArr=explode(",",$singerStr);
					$mdirectorStr=$v->music_director;
					$mdirectorArr=explode(",",$mdirectorStr);
					$lyricistStr=$v->lyricist;
					$lyricistArr=explode(",",$lyricistStr);
					$directorStr=$v->director;
					$directorArr=explode(",",$directorStr);
					$producerStr=$v->producer;
					$producerArr=explode(",",$producerStr);
					
					$track .='<track duration="'.$providerDetails['duration'].'" explicitLyrics="false" genre="'.$v->genre.'" isrc="'.$v->isrc.'" parentalAdvisory="0" title="'.addslashes($v->title).'" trackSequence="'.$t.'"><offerings><offering priceBand="T1" territory="'.$providerDetails['territory'].'"><usage type="AlaCarte" /></offering></offerings><artists>';
					$track.='<artist role="Performer" knownAs="'.$v->keyartist.'" isPrimary="true" />';
					$artistsArr[]=htmlentities('<artist role="Performer" knownAs="'.$v->keyartist.'" isPrimary="true" />');
					if($singerArr[0]){
						foreach($singerArr as $singer){
							$track.='<artist role="Singer" knownAs="'.$singer.'" isPrimary="false" countryOfOrigin="IN" />';
							$artistsArr[]=htmlentities('<artist role="Singer" knownAs="'.$singer.'" isPrimary="false" countryOfOrigin="IN" />');
						}
					}
					if($mdirectorArr[0]){
						foreach($mdirectorArr as $mdirector){
							$track.='<artist role="Composer" knownAs="'.$mdirector.'" isPrimary="false" countryOfOrigin="IN" />';
							$artistsArr[]=htmlentities('<artist role="Composer" knownAs="'.$mdirector.'" isPrimary="false" countryOfOrigin="IN" />');
						}
					}
					if($lyricistArr[0]){
						foreach($lyricistArr as $lyricist){
							$track.='<artist role="Lyricist" knownAs="'.$lyricist.'" isPrimary="false"  countryOfOrigin="IN" />';
							$artistsArr[]=htmlentities('<artist role="Lyricist" knownAs="'.$lyricist.'" isPrimary="false"  countryOfOrigin="IN" />');
						}
					}
					if($directorArr[0]){
						foreach($directorArr as $director){
							$track.='<artist role="Director" knownAs="'.$director.'" isPrimary="false" countryOfOrigin="IN" />';
							$artistsArr[]=htmlentities('<artist role="Director" knownAs="'.$director.'" isPrimary="false" countryOfOrigin="IN" />');
						}
					}
					if($producerArr[0]){
						foreach($producerArr as $producer){
							$track.='<artist role="Producer" knownAs="'.$producer.'" isPrimary="false"  countryOfOrigin="IN" />';
							$artistsArr[]=htmlentities('<artist role="Producer" knownAs="'.$producer.'" isPrimary="false"  countryOfOrigin="IN" />');
						}
					}
					$track.='</artists><avMediaItems><avMediaItem bitrate="1411" format="WAV" length="Full" name="'.$providerDetails['file'].'" /> </avMediaItems></track>';
					$t++;
				}
			}
			$artistsArr=array_unique($artistsArr);
			$artStr.='<artists>';
			foreach($artistsArr as $k=>$v){
				$artStr.=html_entity_decode($v);
			}
			$artStr.='<artist role="Language" knownAs="'.$language.'" isPrimary="false" countryOfOrigin="IN"/>';
			if($label){
				$artStr.='<artist role="Label" knownAs="'.$label.'"  isPrimary="false" countryOfOrigin="IN"/>';
			}
			$artStr.='</artists><volumes totalNumberOfVolumes="1"><volume sequenceNumber="1"><tracks>';			
			$footer='</tracks></volume></volumes></collection>';
				
			$xmlBody=$top.$artStr.$track.$footer;
			$xml_msg_in = fopen($xml_file,"w");
			fwrite($xml_msg_in,$xmlBody); 
			fclose($xml_msg_in);
			$updateReady=$oDeployment->updateReady(array('deploymentId'=>$id,'isReady'=>2));
			$aLogParam = array(
				'moduleName' => 'Nokia Deployment',
				'action' => 'edit',
				'moduleId' => 31,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Generated xml file for NOKIA Deployment. (ID-'.(int)$id.')',
				'content_ids' => (int)$id
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('Location:'.SITEPATH.'nokia-deployment?action=edit&id='.$id.'&do=manage&msg=XML file generated susseccfully!');
			exit;		
	}elseif($do=="ftp"){
		$limit	= 1;
		$start	= 0;
		$params = array(
					'limit'	  => $limit,  
					'orderby' => '  ORDER BY id asc',  
					'start'   => $start,  
					'where'	  => " AND deployment_id=".$id,
				  );
		$allContent = $oDeployment->getDeploymentsDetails( $params );
		$providerDetails=json_decode($allContent[0]->providers_details,true);
		$deploymentFolder=$providerDetails['PPID'];
		$source_dir = MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/";
		if($deploymentFolder!="" && isset($deploymentFolder)){
			$params=array("ftp_server"=>"180.179.108.53",
						  "ftp_user_name"=>"srgmcms",
						  "ftp_user_pass"=>"password4srgmcms",
						  "dst_dir"=>"nokia_deployment/".$deploymentFolder,
						  "src_dir"=>$source_dir,
						  "mov_dir"=>"nokia_final/".$deploymentFolder,
						  );
			$deploy=tools::ftpUploadFolder($params);
			if($deploy==1){
				$aLogParam = array(
					'moduleName' => 'Nokia Deployment',
					'action' => $action,
					'moduleId' => 31,
					'editorId' => $this->user->user_id,
					'remark'	=>	'Folder deployed to nokia ftp for NOKIA Deployment (ID-'.(int)$id.')',
					'content_ids' => (int)$id
				);
				TOOLS::writeActivityLog( $aLogParam );
			}
		}else{
			$deploy="Deployment Directory does not exist!";
		}
		echo $deploy;
		exit;
	}
	/* Form */
	$view = 'nokia-deployment_form';
	$id = (int)$_GET['id']; 
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$deploymentName	=	cms::sanitizeVariable($_POST['deploymentName']);
		if($deploymentName==""){
			$aError[]="Enter Deployment Name.";
		}
		$postData=array( 
					'deploymentName'=>$deploymentName,
					'serviceProvider'=>"NOKIA",
					);
		if(empty($aError)){ 
			$aData = $oDeployment->saveDeployment( $postData );
			if($id){
				$aData=$id;
			}
			$folderNameToDeploy=$deploymentFolder=tools::cleaningName($deploymentName)."-".$aData;
			/* Write DB Activity Logs */
			$aLogParam = array(
				'moduleName' => 'Nokia Deployment',
				'action' => 'add',
				'moduleId' => 31,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Created new Nokia deployment. (ID-'.(int)$aData.')',
				'content_ids' => (int)$aData
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'nokia-deployment?action=edit&id='.$aData."&do=song");exit;
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

		$view = 'nokia-deployment_details';
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
				$aLogParam = array(
					'moduleName' => 'Nokia Deployment',
					'action' => $contentAction,
					'moduleId' => 31,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' NOKIA Deployment. (ID-'.implode("','", $_POST['select_ids']).')',
					'content_ids' => implode("','", $_POST['select_ids'])
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

			if($contentModel=='deployment' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oDeployment->doAction( $params );
				/* Write DB Activity Logs */
				$aLogParam = array(
					'moduleName' => 'Nokia Deployment',
					'action' => $contentAction,
					'moduleId' => 31,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' NOKIA Deployment. (ID-'.$contentId.')',
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
	
	$where		 = ' AND service_provider="NOKIA"';
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
	$oPage->url = SITEPATH."nokia-deployment?srcDeployment=$srcDeployment&srcCType=$srcCType&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );