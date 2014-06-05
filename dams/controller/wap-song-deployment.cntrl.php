<?php    //WAP SONG DEPLOYMENT    
ob_start();
#error_reporting(E_ALL);
#ini_set('display_errors', '1');
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$view = 'wap-song-deployment_all_list';   
$oDeployment = new deployment();
$oSong = new song();
$mTags=new tags();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$wsConfig=array(27,30,20,26,29,28,21);//config ids related to wap deployments
$id = (int)$_GET['id']; 
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
			$albumId = (int)$_POST['albumId'];
			if($selectedIds){
				foreach($selectedIds as $contentId){
					$contentId = $contentId;
					$starcastAlbumString="";
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
					if($albumId==0){
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
					$primeArtistString="";
					if($artistData){
						foreach($artistData as $aData){
							if(in_array($aData->artist_id,$singerArr)){
								$singerString .= $aData->artist_name.",";
								if($primeArtistString==""){
									$primeArtistString=$aData->artist_name;
								}
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
					$searchString="";					
					$searchString=ucwords(strtolower($albumData[0]->album_name)).",".ucwords(strtolower($songData[0]->song_name));
					if($mDirectorString){
						$searchString.=",".ucwords(strtolower($mDirectorString));
					}
					if($singerString){
						$searchString.=",".ucwords(strtolower($singerString));
					}
					if($lyricistString){
						$searchString.=",".ucwords(strtolower($lyricistString));
					}
					if($starcastString){
						$searchString.=",".ucwords(strtolower($starcastString));
					}
					$tagSongMapData=$oSong->getTagSongMap(array('where'=> " AND song_id=".$contentId));
					$tagSongMapArr=array();
					if($tagSongMapData){
						foreach($tagSongMapData as $tag){
							$tagSongMapArr[]=$tag->tag_id;
						}
					}
					if($tagSongMapArr[0]){
						$tagIdStr=implode(",",$tagSongMapArr);
						$gParams = array(
									'limit'	  => 100000,  
									'orderby' => 'ORDER BY tag_name ASC',  
									'start'   => 0,  
									'where'   => " AND status=1 AND tag_id IN (".$tagIdStr.") AND parent_tag_id=1688",
							   );
						$genreList=$mTags->getAllTags($gParams);
						$genreListArr=array();
						if($genreList){
							foreach($genreList as $kGenre=>$vGenre){
									$genreListArr[]=ucwords($vGenre->tag_name);
							}
							if($genreListArr){
								$genreListStr=implode(",",$genreListArr);
							}
							if($genreListStr){
								$searchString.=",".ucwords(strtolower($genreListStr));
							}
						}
						$mParams = array(
									'limit'	  => 100000,  
									'orderby' => 'ORDER BY tag_name ASC',  
									'start'   => 0,  
									'where'   => " AND status=1 AND tag_id IN (".$tagIdStr.") AND parent_tag_id=1",
							   );
						$moodList=$mTags->getAllTags($mParams);
						$moodListArr=array();
						foreach($moodList as $kMood=>$vMood){
								$moodListArr[]=ucwords($vMood->tag_name);
						}
						if($moodListArr){
							$moodListStr=implode(",",$moodListArr);
						}
					}
					$file_wappreview=0;
					$data_wappreview=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=27 AND status=1"));
					$file_wappreview_arr=NULL;
					if(!empty($data_wappreview)){
						if(sizeof($data_wappreview)==1){
							$oFile_wappreview=$data_wappreview[0]->path;
							if($oFile_wappreview){ 
								$file_wappreview=$oFile_wappreview;
							}
						}
					}
					$file_webpreview=0;
					$data_webpreview=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=30 AND status=1"));
					$file_webpreview_arr=NULL;
					if(!empty($data_webpreview)){
						if(sizeof($data_webpreview)==1){
							$oFile_webpreview=$data_webpreview[0]->path;
							if($oFile_webpreview){
								$file_webpreview=$oFile_webpreview;
							}
						}
					}
					$file_amr=0;
					$data_amr=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=20 AND status=1"));
					$file_amr_arr=NULL;
					if(!empty($data_amr)){
						if(sizeof($data_amr)==1){
							$oFile_amr=$data_amr[0]->path;
							if($oFile_amr){
								$file_amr=$oFile_amr;
							}
						}
					}
					$file_awb=0;
					$data_awb=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=26 AND status=1"));
					$file_awb_arr=NULL;
					if(!empty($data_awb)){
						if(sizeof($data_awb)==1){
							$oFile_awb=$data_awb[0]->path;
							if($oFile_awb){
								$file_awb=$oFile_awb;
							}
						}
					}
					$file_1mb=0;
					$data_1mb=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=29 AND status=1"));
					$file_1mb_arr=NULL;
					if(!empty($data_1mb)){
						if(sizeof($data_1mb)==1){
							$oFile_1mb=$data_1mb[0]->path;
							if($oFile_1mb){
								$file_1mb=$oFile_1mb;
							}
						}
					}
					$file_wma=0;
					$data_wma=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=28 AND status=1"));
					$file_wma_arr=NULL;
					if(!empty($data_wma)){
						if(sizeof($data_wma)==1){
							$oFile_wma=$data_wma[0]->path;
							if($oFile_wma){
								$file_wma=$oFile_wma;
							}
						}
					}
					$file_hq=0;
					$data_hq=$oDeployment->getSongEditConfigRel(array("where" => " AND song_id=".$contentId." AND config_id=21 AND status=1"));
					$file_hq_arr=NULL;
					if(!empty($data_hq)){
						if(sizeof($data_hq)==1){
							$oFile_hq=$data_hq[0]->path;
							if($oFile_hq){
								$file_hq=$oFile_hq;
							}
						}
					}
					$vendorId=1;
					$label="Saregama";
					$rights=1;
					$distributionRights=1;
					$providers_details = NULL;
					$providers_details = array('wappreview'=>$file_wappreview ,'webpreview'=>$file_webpreview , 'amr'=>$file_amr ,'awb' =>$file_awb,'1mb' =>$file_1mb,'wma' =>$file_wma,'hq' =>$file_hq,"vendorId"=>$vendorId,"label"=>$label,"rights"=>$rights,"distributionRights"=>$distributionRights,"mood"=>$moodListStr,"vendor"=>$vendorId,"category"=>1,"display"=>ucwords(strtolower($songData[0]->song_name)));
					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => ucwords(strtolower($songData[0]->song_name)),
								'language' => $language,
								'category' => "",
								'subCategory' => ucwords(strtolower($albumData[0]->album_name)),
								'album' => ucwords(strtolower($albumData[0]->album_name)),
								'keyArtist' => $primeArtistString,
								'musicDirector' => $mDirectorString,
								'searchKey' => $searchString,
								'keyDirector' => $directorString,
								'keyProducer' => $producerString,
								'releaseYear' => $releaseYear,
								'albumYear' => $albumYear,
								'genre' => ucwords(strtolower($genreListStr)),
								'starcast' => $starcastString,
								'lyricist' => $lyricistString,
								'singer' => $singerString,
								'isrc' => $songData[0]->isrc,
								'deploymentId' => $deploymentId,
								'contentId' => $contentId,
								'contentType' => '4',
								'providerDetails' => $providers_details_str,
					);
					$deployed = $oDeployment->addToDeployment($params);
				}
				if($deployed){
					$aLogParam = array(
						'moduleName' => 'WAP Song Deployment',
						'action' => $action,
						'moduleId' => 37,
						'editorId' => $this->user->user_id,
						'remark'	=>	'Song added to Wap Song Deployment.(ID-'.(int)$deploymentId.')',
						'content_ids' => (int)$deploymentId
					);
					TOOLS::writeActivityLog( $aLogParam );
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
					header('Location: '.SITEPATH.'wap-song-deployment?action=edit&id='.$deploymentId.'&do=manage');
					exit;
				}
			}					
		}
		$view = 'wap-song-deployment_list';
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
			$album=$_POST['album'];
			$keyArtist=$_POST['keyArtist'];
			$musicDirector=$_POST['musicDirector'];
			$searchKey=$_POST['searchKey'];
			$keyDirector=$_POST['keyDirector'];
			$keyProducer=$_POST['keyProducer'];
			$releaseYear=$_POST['releaseYear'];
			$genre=$_POST['genre'];
			$mood=$_POST['mood'];
			$starcast=$_POST['starcast'];
			$lyricist=$_POST['lyricist'];
			$singer=$_POST['singer'];
			$isrc=$_POST['isrc'];
			$wappreview=$_POST['wappreview'];
			$webpreview=$_POST['webpreview'];
			$vendor=$_POST['vendor'];
			$rights=$_POST['rights'];
			$label=$_POST['label'];
			$distributionRights=$_POST['distributionRights'];
			$display=$_POST['display'];
			$amr=$_POST['amr'];
			$awb=$_POST['awb'];
			$f1mb=$_POST['1mb'];
			$hq=$_POST['hq'];
			$wma=$_POST['wma'];
			$deploymentId = (int)$_POST['deploymentId'];
			$providerCode = $_POST['providerCode'];

			if(!empty($primaryId)){
				foreach($primaryId as $pId){
					if($category[$pId]=="" || $category[$pId]=="0"){
						$aError[]="Please enter category for ".$songTitle[$pId].".";
					}
					if($album[$pId]==""){
						$aError[]="Please enter subcategory for ".$songTitle[$pId].".";
					}
					if($songTitle[$pId]==""){
						$aError[]="Please enter description for ".$songTitle[$pId].".";
					}
					if($searchKey[$pId]==""){
						$aError[]="Please enter search keywords for ".$songTitle[$pId].".";
					}
					if($vendor[$pId]==""){
						$aError[]="Please enter vandor for ".$songTitle[$pId].".";
					}
					if($rights[$pId]==""){
						$aError[]="Please enter rights for ".$songTitle[$pId].".";
					}
					if($language[$pId]==""){
						$aError[]="Please enter language for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$wappreview[$pId])){
						$aError[]="Enter valid wap preview file path for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$webpreview[$pId])){
						$aError[]="Enter valid web preview file path for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$amr[$pId])){
						$aError[]="Enter valid amr file path for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$awb[$pId])){
						$aError[]="Enter valid awb file path for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$f1mb[$pId])){
						$aError[]="Enter valid  1 mb file path for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$wma[$pId])){
						$aError[]="Enter valid wma file path for ".$songTitle[$pId].".";
					}
					if(!file_exists(MEDIA_SERVERPATH_SONGEDITS.$hq[$pId])){
						$aError[]="Enter valid hq file path for ".$songTitle[$pId].".";
					}
					if(empty($aError)){
						$status=1;
					}else{
						$status=0;
					}
					$providers_details = array('wappreview'=>$wappreview[$pId] ,'webpreview'=>$webpreview[$pId] , 'amr'=>$amr[$pId] ,'awb' =>$awb[$pId],'1mb' =>$f1mb[$pId],'wma' =>$wma[$pId],'hq' =>$hq[$pId],"vendorId"=>$vendor[$pId],"label"=>$label[$pId],"rights"=>$rights[$pId],"distributionRights"=>$distributionRights[$pId],"mood"=>$mood[$pId],"vendor"=>$vendor[$pId],"category"=>$category[$pId],"display"=>$display[$pId],"status"=>$status);

					$providers_details_str=json_encode($providers_details);

					$params=NULL;
					$params = array(
								'songTitle' => ucwords(strtolower($songTitle[$pId])),
								'language' => $language[$pId],
								'category' => $category[$pId],
								'subCategory' => $subCategory[$pId],
								'album' => ucwords(strtolower($album[$pId])),
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
								'deploymentFolder' => "",
					);
					$deployed = $oDeployment->addToDeployment($params);
				}
				if(empty($aError)){
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>1));
				}else{
					$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>0));
				}
				if($deployed && empty($aError)){
					$aLogParam = array(
						'moduleName' => 'WAP Song Deployment',
						'action' => $action,
						'moduleId' => 37,
						'editorId' => $this->user->user_id,
						'remark'	=>	'Song Meta upadated to Wap Song Deployment.(ID-'.(int)$deploymentId.')',
						'content_ids' => (int)$deploymentId
					);
					TOOLS::writeActivityLog( $aLogParam );
					header('Location:'.SITEPATH.'wap-song-deployment?action=edit&id='.$deploymentId.'&do=manage&msg=Action completed susseccfully!');
					exit;
				}
				$data['aError']=$aError;
				$view = "wap-song-deployment_manage";
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
			$view = "wap-song-deployment_manage";
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
	elseif($do=="wap"){
		/* WAP  OF instantiation */
		$oMysqliWap = new mysqliDb('wapdb');
		$limit	= 1;
		$start	= 0;
		$params = array(
					'limit'	  => $limit,  
					'orderby' => '  ORDER BY id asc',  
					'start'   => $start,  
					'where'	  => " AND deployment_id=".$id,
				  );
		$allContent = $oDeployment->getDeploymentsDetails( $params );
		/*WAP FTP CONNECTION*/
		$ftp_server='180.179.108.53';
		$ftp_user_name='srgmcms';
		$ftp_user_pass='password4srgmcms';
		try{
			// set up basic connection
			$conn_id = ftp_connect($ftp_server);
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			ftp_pasv($conn_id, true);
		}catch(Exception $e){
			$msg=$e->getMessage();
		}
		if($allContent){
			$aError=array();
			foreach($allContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
				$type_id = 15;
				$category_id= $providerDetails['category'];
				$sub_cat= $showData->album;
				$wap_preview= "";
				$web_preview= "";
				$description= $showData->title;
				$search= $showData->search_key;
				$vendor_id= $providerDetails['vendor'];
				$valid_upto= "";
				$added_on= date("Y-m-d H:i:s");
				$disp_name= $providerDetails['display'];
				$active= 1;
				$song_id= 0;
				$actoractress= $showData->starcast;
				$releaseyear= $showData->release_year;
				$genre= $showData->genre;
				$mood= $providerDetails['mood'];
				$musicdirector= $showData->music_director;
				$musiclabel= $providerDetails['label'];
				$rights= $providerDetails['rights'];
				$singermusician= $showData->singer;
				$cost_ptr= "P1";
				$ext= 0;
				$language= $showData->language;
				$lyricist= $showData->lyricist;
				$producer= $showData->producer;
				$director= $showData->director;
				$distribution_rights= $providerDetails['distributionRights'];
				$primary_artist= $showData->keyartist;
				$isrc_code= $showData->isrc;
				
				$postData=array(
					'type_id'=>$type_id, 
					'category_id'=>$category_id, 
					'sub_cat'=>$sub_cat, 
					'wap_preview'=>$wap_preview, 
					'web_preview'=>$web_preview, 
					'description'=>$description, 
					'search'=>$search, 
					'vendor_id'=>$vendor_id, 
					'valid_upto'=>$valid_upto, 
					'added_on'=>$added_on, 
					'disp_name'=>$disp_name, 
					'active'=>$active, 
					'song_id'=>$song_id, 
					'actoractress'=>$actoractress, 
					'releaseyear'=>$releaseyear, 
					'genre'=>$genre, 
					'mood'=>$mood, 
					'musicdirector'=>$musicdirector, 
					'musiclabel'=>$musiclabel, 
					'rights'=>$rights, 
					'singermusician'=>$singermusician, 
					'cost_ptr'=>$cost_ptr, 
					'ext'=>$ext, 
					'language'=>$language, 
					'lyricist'=>$lyricist, 
					'producer'=>$producer, 
					'director'=>$director, 
					'distribution_rights'=>$distribution_rights, 
					'primary_artist'=>$primary_artist, 
					'isrc_code'=>$isrc_code,
					'conn' => $oMysqliWap,
					);
				$aDData = $oDeployment->saveToWAP( $postData );
				if($aDData>0){
					$wap_preview="fla".$aDData."_wap.mp3";
					$web_preview="fla".$aDData."_wap.wma";
					$cont_id=$aDData;
					$amr="fla".$aDData.".amr";
					$awb="fla".$aDData.".awb";
					$f1mb="fla".$aDData.".mp3";
					$wma="fla".$aDData.".wma";
					$hq="fla".$aDData.".mp3";
					
					$dst_dir="song_edits/".$wap_preview;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['wappreview'];
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
						 $msg= "1";
						} else {
						 $aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}
					$dst_dir="song_edits/".$web_preview;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['webpreview'];
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
						 	$msg= "";
						} else {
						 $aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}					
					$upParam=array('wap_preview'=>$wap_preview,
									'web_preview'=>$web_preview,
									'cont_id'=>$cont_id,
									'conn'=>$oMysqliWap,
								   );	
					$oDeployment->updateToWAP( $upParam );
					
					$dst_dir="song_edits/".$amr;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['amr'];
					
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
	 						$fileSizeAmr=filesize($src_dir);
							$fParam1=array(
										'CONT_ID'=>$aDData,
										'GROUP_ID'=>158,
										'DISPLAY_NAME'=>$disp_name."FLA",
										'FILE_NAME'=>$amr,
										'FILE_SIZE'=>$fileSizeAmr,
										'conn'=>$oMysqliWap,
									);
							$oDeployment->insertToWAPFLA( $fParam1 );
						} else {
						 	$aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}
					
					$dst_dir="song_edits/".$awb;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['awb'];
					
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
						 	$fileSizeAwb=filesize($src_dir);
							$fParam2=array(
										'CONT_ID'=>$aDData,
										'GROUP_ID'=>159,
										'DISPLAY_NAME'=>$disp_name."FLA",
										'FILE_NAME'=>$awb,
										'FILE_SIZE'=>$fileSizeAwb,
										'conn'=>$oMysqliWap,
									);
							$oDeployment->insertToWAPFLA( $fParam2 );
						} else {
							 $aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}
										
					$dst_dir="song_edits/".$f1mb;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['1mb'];
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
						 	$fileSize1mb=filesize($src_dir);
							$fParam3=array(
										'CONT_ID'=>$aDData,
										'GROUP_ID'=>271,
										'DISPLAY_NAME'=>$disp_name."FLA",
										'FILE_NAME'=>$f1mb,
										'FILE_SIZE'=>$fileSize1mb,
										'conn'=>$oMysqliWap,
									);
							$oDeployment->insertToWAPFLA( $fParam3 );
						} else {
						 	$aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}
					
					$dst_dir="song_edits/".$wma;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['wma'];
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
						 	$fileSizeWma=filesize($src_dir);
							$fParam4=array(
										'CONT_ID'=>$aDData,
										'GROUP_ID'=>384,
										'DISPLAY_NAME'=>$disp_name."FLA",
										'FILE_NAME'=>$wma,
										'FILE_SIZE'=>$fileSizeWma,
										'conn'=>$oMysqliWap,
									);
							$oDeployment->insertToWAPFLA( $fParam4 );		
						} else {
						 	$aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}
					
					$dst_dir="song_edits/".$hq;
					$src_dir=MEDIA_SERVERPATH_SONGEDITS.$providerDetails['hq'];
					#@ftp_mkdir($conn_id, $dst_dir);
					try{
						if (ftp_put($conn_id, $dst_dir, $src_dir, FTP_ASCII)) {
		 					$fileSizeHq=filesize($src_dir);
							$fParam5=array(
										'CONT_ID'=>$aDData,
										'GROUP_ID'=>299,
										'DISPLAY_NAME'=>$disp_name."FLA",
										'FILE_NAME'=>$hq,
										'FILE_SIZE'=>$fileSizeHq,
										'conn'=>$oMysqliWap,
									);
							$oDeployment->insertToWAPFLA( $fParam5 );		
						} else {
						 	$aError[]= "There was a problem while uploading $file\n";
						}
					}catch(Exception $e){
						$aError[]=$e->getMessage();
					}
				}
			}
		}		
		if(empty($aError)){
			$aLogParam = array(
				'moduleName' => 'WAP Song Deployment',
				'action' => $action,
				'moduleId' => 37,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Files deployed to wap server for WAP songs Deployment (ID-'.(int)$id.')',
				'content_ids' => (int)$id
			);
			TOOLS::writeActivityLog( $aLogParam );
			$oDeployment->doAction(array("contentActionValue"=>1,"contentId"=>$id));
			echo 1;
		}else{
			print_r($aError);
		}
		exit;
	}
	/* Form */
	$view = 'wap-song-deployment_form';
	$id = (int)$_GET['id']; 
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$deploymentName	=	cms::sanitizeVariable($_POST['deploymentName']);
		if($deploymentName==""){
			$aError[]="Enter Deployment Name.";
		}
		$postData=array(
					'deploymentName'=>$deploymentName,
					'serviceProvider'=>"WAPSONG",
					);
		if(empty($aError)){ 
			$aData = $oDeployment->saveDeployment( $postData );
			if($id){
				$aData=$id;
			}
			$folderNameToDeploy=$deploymentFolder=tools::cleaningName($deploymentName)."-".$aData;
			/* Write DB Activity Logs */
			$aLogParam = array(
				'moduleName' => 'wap song deployment',
				'action' => $action,
				'moduleId' => 37,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Wap Song Deployment created.(ID-'.(int)$aData.')',
				'content_ids' => (int)$aData
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'wap-song-deployment?action=edit&id='.$aData."&do=song");exit;
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

		$view = 'wap-song-deployment_details';
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
	
	
	$where		 = ' AND service_provider="WAPSONG"';
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
	$oPage->url = SITEPATH."wap-song-deployment?srcDeployment=$srcDeployment&srcCType=$srcCType&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );