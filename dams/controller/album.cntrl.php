<?php        

$view = 'album_list';      
$action = cms::sanitizeVariable( $_GET['action'] );
$action = ($action==''?'view':$action);
$do = cms::sanitizeVariable( $_GET['do'] );

$QUERY_STRINGS = cms::sanitizeVariable($_SERVER['QUERY_STRING']);

$mAlbum=new album();

global $aConfig;
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$data['QUERY_STRINGS'] = $QUERY_STRINGS;
$id = cms::sanitizeVariable((int)$_GET['id']);


$mLanguage=new language();
$lParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY language_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
$languageList=$mLanguage->getAllLanguages($lParams);


$mLabel=new label();
$lParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY label_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
$labelList=$mLabel->getAllLabels($lParams);



$mCatalogue=new catalogue();
$lParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY catalogue_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
$catalogueList=$mCatalogue->getAllCatalogues($lParams);

$mTvchannel=new tags();
$tParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY tag_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1 AND parent_tag_id=1466",
	   );
$tvchannelList=$mTvchannel->getAllTags($tParams);

$rParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY tag_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1 AND parent_tag_id=1635",
	   );
$radioList=$mTvchannel->getAllTags($rParams);

if( $action == 'add' || $action == 'edit'){
	$aError=array();
	$aSuccess=array();
	
	$view = 'album_form';
	
	if(!empty($_POST) && isset($_POST)){
		$albumName=cms::sanitizeVariable($_POST['albumName']);
		$catalogueName=cms::sanitizeVariable($_POST['catalogueName']);
		$autosuggestcatalogue_hddn=(int)$_POST['autosuggestcatalogue_hddn'];
		$status=cms::sanitizeVariable($_POST['status']);
		$labelIds=cms::sanitizeVariable($_POST['labelIds']);
		$languageIds=cms::sanitizeVariable($_POST['languageIds']);
		$catalogueIds=(int)$_POST['catalogueIds'];
		$bannerIds=$_POST['bannerIds'];
		$musicReleaseDate=cms::sanitizeVariable($_POST['musicReleaseDate']);
		$titleReleaseDate=cms::sanitizeVariable($_POST['titleReleaseDate']);
		$albumDescription=cms::sanitizeVariable($_POST['albumDescription']);
		$albumExcerpt=cms::sanitizeVariable($_POST['albumExcerpt']);
		$couplingIds=cms::sanitizeVariable($_POST['couplingIds']);
		$showName=cms::sanitizeVariable($_POST['showName']);
		$broadCastYear=cms::sanitizeVariable($_POST['broadCastYear']);
		$tvchannelIds=$_POST['tvchannelIds'];
		$radioIds=$_POST['radioIds'];
		$grade =cms::sanitizeVariable($_POST['grade']);
		$isSubtitle =cms::sanitizeVariable($_POST['isSubtitle']);
		$filmRating = cms::sanitizeVariable($_POST['filmRating']);
		$oPicImageId=(int)$_POST['oPicImageId'];
		$picname =	cms::sanitizeVariable($_POST['oPic']);
		$artistRoleArray=array();
		$albumTypeStr="0";
		$artistHidden = trim($_POST['artistHidden'],",");
		$artistHiddenArr=array();
		if($artistHidden){
			$artistHiddenArr=explode(",",$artistHidden);
		}
		$artistHiddensData = explode('|',trim($_POST['artistHiddensData'],"|"));
		$artistNameArr=array();
		if($artistHiddensData){
			foreach($artistHiddensData as $artistHiddensData){
				$artistNameData = explode(":",$artistHiddensData);
				if($artistNameData){
					$artistNameArr[$artistNameData[0]]=$artistNameData[1];
				}
			}
		}
		$starcastHidden = trim($_POST['starcastHidden'],",");
		$directorHidden = trim($_POST['directorHidden'],",");
		$producerHidden = trim($_POST['producerHidden'],",");
		$writerHidden   = trim($_POST['writerHidden'],",");
		$bannerHidden   = trim($_POST['bannerHidden'],",");
		$mdirectorHidden = trim($_POST['mdirectorHidden'],",");
		$lyricistHidden = trim($_POST['lyricistHidden'],",");

						
		$starcastHiddenArr=array();
		if($starcastHidden){
			$starcastHiddenArr=explode(",",$starcastHidden);
		}
		$producerHiddenArr=array();
		if($producerHidden){
			$producerHiddenArr=explode(",",$producerHidden);
		}
		$directorHiddenArr=array();
		if($directorHidden){
			$directorHiddenArr=explode(",",$directorHidden);
		}
		$writerHiddenArr=array();
		if($writerHidden){
			$writerHiddenArr=explode(",",$writerHidden);
		}
		$bannerHiddenArr=array();
		if($bannerHidden){
			$bannerHiddenArr=explode(",",$bannerHidden);
		}
		$lyricistHiddenArr=array();
		if($lyricistHidden){
			$lyricistHiddenArr=explode(",",$lyricistHidden);
		}
		$mdirectorHiddenArr=array();
		if($mdirectorHidden){
			$mdirectorHiddenArr=explode(",",$mdirectorHidden);
		}

		
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

		$producerHiddensData = explode('|',trim($_POST['producerHiddensData'],"|"));
		$producerNameArr=array();
		if($producerHiddensData){
			foreach($producerHiddensData as $producerHiddensData){
				$producerNameData = explode(":",$producerHiddensData);
				if($producerNameData[0] && in_array($producerNameData[0],$producerHiddenArr)){
					$producerNameArr[$producerNameData[0]]=$producerNameData[1];
					$artistRoleArray[$producerNameData[0]]=$aConfig['artist_type']['Producer'];					
				}
			}
		}

		$writerHiddensData = explode('|',trim($_POST['writerHiddensData'],"|"));
		$writerNameArr=array();
		if($writerHiddensData){
			foreach($writerHiddensData as $writerHiddensData){
				$writerNameData = explode(":",$writerHiddensData);
				if($writerNameData[0] && in_array($writerNameData[0],$writerHiddenArr)){
					$writerNameArr[$writerNameData[0]]=$writerNameData[1];
					$artistRoleArray[$writerNameData[0]]=$aConfig['artist_type']['Writer'];										
				}
			}
		}
		$bannerHiddensData = explode('|',trim($_POST['bannerHiddensData'],"|"));
		$bannerNameArr=array();
		if($bannerHiddensData){
			foreach($bannerHiddensData as $bannerHiddensData){
				$bannerNameData = explode(":",$bannerHiddensData);
				if($bannerNameData[0] && in_array($bannerNameData[0],$bannerHiddenArr)){
					$bannerNameArr[$bannerNameData[0]]=$bannerNameData[1];
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
				if(in_array($kR,$producerHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Producer'];
				}
				if(in_array($kR,$writerHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Writer'];
				}
				if(in_array($kR,$mdirectorHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Music Director'];
				}
				if(in_array($kR,$lyricistHiddenArr)){
					$roleStr="";
					if($artistRoleKeyArray[$kR]){
						$roleStr=$artistRoleKeyArray[$kR]."|";
					}
					$artistRoleKeyArray[$kR]=$roleStr.$aConfig['artist_type']['Lyricist'];
				}
			
			}
		}
		
		$album_content_type = $_POST['album_content_type'];
		$albumTypeF = $_POST['albumTypeF'];
		$albumTypeO = $_POST['albumTypeO'];
		$albumTypeD = $_POST['albumTypeD'];
		
		$albumType1 = (isset($albumTypeF)) ?  $albumTypeF."|" : ''; // film/non-film
		$albumType2 = (isset($albumTypeO)) ?  $albumTypeO."|" : ''; // Original/Compile
		$albumType3 = (isset($albumTypeD)) ?  $albumTypeD : ''; // Digital	
	
		$albumTypeStr = $albumType1.$albumType2.$albumType3;

		
		if($albumName==""){
			$aError[]="Enter album Name!";
		}
		
		if($albumTypeF=="1" && empty($bannerHiddenArr)){
			$aError[]="Please Select Banner!";
		}
		if($albumTypeF=="1" && empty($starcastNameArr)){
			$aError[]="Please Select Starcast!";
		}
		if($albumTypeF=="1" && empty($directorNameArr)){
			$aError[]="Please Select Director!";
		}
		if($albumTypeF=="1" && empty($producerNameArr)){
			$aError[]="Please Select Producer!";
		}
		
		$isAlbumExist=$mAlbum->checkAlbumExist($albumName);
		if((int)$isAlbumExist[0]->cnt>0){
			$aError[]="Album name already exist!";
		}
		if($catalogueIds==""){
			$aError[]="Please Select Catalogue!";
		}
		if($languageIds==''){
			$aError[]="Select Language!";
		}
		if($labelIds==''){
			$aError[]="Select Label!";
		}
		if(sizeof($artistHiddenArr)>1){
			$aError[]="Primary artist should be only one.";
		}
		if( empty($album_content_type) ){
			$aError[]="Select Album Content Type.";
		}
		if($musicReleaseDate=="" || $musicReleaseDate=='0000-00-00'){
			$aError[]="Enter Release Date!";
		}
		/*if($couplingIds==""){
			$aError[]="Enter coupling ids!";
		}*/
		if($albumDescription==""){
			$aError[]="Enter Album Description!";
		}
		/*if($albumExcerpt==""){
			$aError[]="Enter Album Excerpt!";
		}*/
		/*if($grade==""){
			$aError[]="Enter Album Grade!";
		}*/
		/*if($filmRating==""){
			$aError[]="Enter Film Rating!";
		}*/
		

	
		if(isset($_POST['album_content_type']) && !empty($_POST['album_content_type']) && sizeof($_POST['album_content_type'])>0){
			$albumContentTypeStr=implode("|",$_POST['album_content_type']);
		}
		
		$postData=array( 
					'albumId'=>$id,
					'albumName'=>$albumName,
					'status'=>$status,
					'labelIds' => $labelIds,
					'languageIds'=>$languageIds,
					'catalogueIds'=> $catalogueIds,
					'bannerNameArr'=>$bannerNameArr,
					'bannerId' => $bannerHidden,
					'bannerNameStr'=>$_POST['bannerHiddensData'],
					'primaryArtist' => $primaryArtist,
					'musicReleaseDate' => $musicReleaseDate,
					'titleReleaseDate' => $titleReleaseDate,
					'albumDescription' => $albumDescription,
					'albumExcerpt' => $albumExcerpt,
					'albumType' => $albumTypeStr,
					'artistNameArr'=>$artistNameArr,
					'artistId' => $artistHidden,
					'artistNameStr'=>$_POST['artistHiddensData'],
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$_POST['starcastHiddensData'],
					'directorNameArr'=>$directorNameArr,
					'directorId' => $directorHidden,
					'directorNameStr'=>$_POST['directorHiddensData'],
					'producerNameArr'=>$producerNameArr,
					'producerId' => $producerHidden,
					'producerNameStr'=>$_POST['producerHiddensData'],
					'writerNameArr'=>$writerNameArr,
					'writerId' => $writerHidden,
					'mdirectorNameArr'=>$mdirectorNameArr,
					'mdirectorId' => $mdirectorHidden,
					'mdirectorNameStr'=>$_POST['mdirectorHiddensData'],
					'lyricistNameArr'=>$lyricistNameArr,
					'lyricistId' => $lyricistHidden,
					'lyricistNameStr'=>$_POST['lyricistHiddensData'],
					'couplingIds' => $couplingIds,
					'albumTypeStr' => $albumTypeStr,
					'albumContentTypeStr' => $albumContentTypeStr,
					'tvchannelIds'=> $tvchannelIds,
					'radioIds'=> $radioIds,
					'showName' => $showName,
					'broadCastYear'=>$broadCastYear,
					'grade' =>$grade,
					'isSubtitle'=>(int)$isSubtitle,
					'filmRating' => $filmRating,
					'image'=>$picname,
					);
		#print_r($_POST);exit;
		#print_r($postData);exit;
		if(empty($aError)){
			if( $action == 'add'){
				$mData=$mAlbum->addAlbum($postData);
				$logMsg="Created Album.";
			}elseif( $action == 'edit'){
				$mData=$mAlbum->editAlbum($postData);
				$mData=$id;
				$logMsg="Edited Album Information.";
			}
			if($mData){
				$oImage=new image();
				if($artistRoleKeyArray){
					$oData=$mAlbum->mapArtistAlbum(array('albumId'=>(int)$mData,'artistRoleKeyArray'=>$artistRoleKeyArray));					
				}
				if($bannerHiddenArr){
					$bData=$mAlbum->mapBannerAlbum(array('albumId'=>(int)$mData,'bannerIds'=>$bannerHiddenArr));
				}
				#if($tvchannelIds || $radioIds){
					$tagIds=array_merge((array)$tvchannelIds,(array)$radioIds);
					$tData=$mAlbum->mapTagAlbum(array('albumId'=>(int)$mData,'tagIds'=>$tagIds));
				#}
				if($oPicImageId){
					$oData=$oImage->mapAlbumImage(array('imageId'=>$oPicImageId,'albumIds'=>array($mData)));
				}
				
				
				/* Send Mail Notification start*/
				if($action == 'add'){
					$oMailParam = array(
							'moduleName' => 'album',
							'action' => $action,
							'moduleId' => 14,
							'editorId' => $this->user->user_id,
							'content_ids' => (int)$mData
						);
					$oNotification->sendNotification( $oMailParam );
					
				}
				/* Send Mail Notification end*/
				
				/* Write DB Activity Logs */
				#TOOLS::log('album', $action, '14', $this->user->user_id, "Album, Id: ".(int)$mData."" );
				$aLogParam = array(
					'moduleName' => 'album',
					'action' => $action,
					'moduleId' => 14,
					'editorId' => $this->user->user_id,
					'remark'	=>	$logMsg.' (ID-'.(int)$mData.')',
					'content_ids' => (int)$mData
				);
				TOOLS::writeActivityLog( $aLogParam );
				header("location:".SITEPATH."album?action=view&msg=Action completed successfully.");exit;
			}
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
	/*
		When album ID pass to edit
	*/
	if((int)$id>0){
		$aData=$mAlbum->getAlbumById(array('ids'=>$id));
		$albumType =$aData[0]->album_type;
		$albumTypeArr=array();
		if($albumType){				  
			$isFilm = ((1&$albumType)==1)?$albumTypeArr[]=1:"";
			$isOriginal = ((2&$albumType)==2)?$albumTypeArr[]=2:"";
			$isDigital = ((4&$albumType)==4)?$albumTypeArr[]=4:"";
		}
		if($albumTypeArr){
			$albumTypeStr=implode("|",$albumTypeArr);
		}
		$artistAlbumMapData=$mAlbum->getArtistAlbumMap(array('where'=> " AND album_id=".$id));
		$artistIdArray=array();
		$artistIdMapArray=array();
		if($artistAlbumMapData){
			foreach($artistAlbumMapData as $vMap){
				$artistIdArray[]=$vMap->artist_id;
				$artistIdMapArray[$vMap->artist_id]=$vMap->artist_role;	
			}	
		}
		$artistIdStr="0";
		if($artistIdArray){
			$artistIdStr=implode(",",$artistIdArray);
		}
		$mArtist=new artist();
		$mArtistArray=$mArtist->getArtistById(array('ids'=>(int)$aData[0]->artist_id.",".$artistIdStr));
		$artistNameStr="";
		$mArtistArrayWithId=array();
		$starcastNameArr=array();
		$producerNameArr=array();
		$directorNameArr=array();
		$writerNameArr=array();
		$mdirectorNameArr=array();
		$lyricistNameArr=array();
		
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $vArt){
				$mArtistArrayWithId[$vArt->artist_id]=$vArt;
				$artistNameStr.=$vArt->artist_id.":".$vArt->artist_name."|";
				if(($aConfig['artist_type']['Starcast']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Starcast']){
					$starcastHiddenArr[]=$vArt->artist_id;
					$starcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Producer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Producer']){
					$producerHiddenArr[]=$vArt->artist_id;
					$producerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Director']){
					$directorHiddenArr[]=$vArt->artist_id;
					$directorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Writer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Writer']){
					$writerHiddenArr[]=$vArt->artist_id;
					$writerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Music Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Music Director']){
					$mdirectorHiddenArr[]=$vArt->artist_id;
					$mdirectorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Lyricist']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Lyricist']){
					$lyricistHiddenArr[]=$vArt->artist_id;
					$lyricistNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
			}
		}
		$starcastHidden="";
		if($starcastHiddenArr){
			$starcastHidden=implode(",",$starcastHiddenArr);
		}
		$producerHidden="";
		if($producerHiddenArr){
			$producerHidden=implode(",",$producerHiddenArr);
		}
		$directorHidden="";
		if($directorHiddenArr){
			$directorHidden=implode(",",$directorHiddenArr);
		}
		$writerHidden="";
		if($writerHiddenArr){
			$writerHidden=implode(",",$writerHiddenArr);
		}
		
		$mdirectorHidden="";
		if($mdirectorHiddenArr){
			$mdirectorHidden=implode(",",$mdirectorHiddenArr);
		}
		$lyricistHidden="";
		if($lyricistHiddenArr){
			$lyricistHidden=implode(",",$lyricistHiddenArr);
		}
		
		$artistNameArr=array();
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $mArtistArray){
					$artistNameArr[$aData[0]->artist_id]=$mArtistArrayWithId[$aData[0]->artist_id]->artist_name;
			}
		}

		
		$bannerAlbumMapData=$mAlbum->getBannerAlbumMap(array('where'=> " AND album_id=".$id));
		$bannerHiddenArr=array();
		if($bannerAlbumMapData){
			foreach($bannerAlbumMapData as $banner){
				$bannerHiddenArr[]=$banner->banner_id;
			}
		}
		$bannerHidden="";
		if($bannerHiddenArr){
			$bannerHidden=implode(",",$bannerHiddenArr);
		}
		$mBanner=new banner();
		$bannerHiddenIn="0";
		if($bannerHidden){
			$bannerHiddenIn=$bannerHidden;
		}
		$bannerNameArr=array();
		$bannerNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY banner_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND banner_id IN (".$bannerHiddenIn.")",
		   );
		$bannerData=$mBanner->getAllBanners($bParams);
		if($bannerData){
			foreach($bannerData as $bD){
				$bannerNameStr.=$bD->banner_id.":".$bD->banner_name."|";
				$bannerHiddenArr[]=$bD->banner_id;
				$bannerNameArr[$bD->banner_id]=$bD->banner_name;
			}	
		}
		
		$tagAlbumMapData=$mAlbum->getTagAlbumMap(array('where'=> " AND album_id=".$id));
		$tagAlbumMapArr=array();
		if($tagAlbumMapData){
			foreach($tagAlbumMapData as $tag){
				$tagAlbumMapArr[]=$tag->tag_id;
			}
		}
		$edtData=array( 
					'albumName' => $aData[0]->album_name,
					'status' => $aData[0]->status,
					'labelIds' => $aData[0]->label_id,
					'languageIds' => $aData[0]->language_id,
					'catalogueIds'=> $aData[0]->catalogue_id,
					'bannerNameArr' => $bannerNameArr,
					'bannerId' => $bannerHidden,
					'bannerNameStr' => $bannerNameStr,
					'primaryArtist' => (int)$aData[0]->artist_id,
					'musicReleaseDate' => $aData[0]->music_release_date,
					'titleReleaseDate' => $aData[0]->title_release_date,
					'albumDescription' => $aData[0]->album_desc,
					'albumExcerpt' => $aData[0]->album_excerpt,
					'albumContentType' => $aData[0]->content_type,
					'albumType' => $albumTypeArr,
					'artistId' => $aData[0]->artist_id,
					'artistNameStr' => $artistNameStr,
					'artistNameArr' => $artistNameArr,
					'starcastNameArr' => $starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr' => $artistNameStr,
					'directorNameArr' => $directorNameArr,
					'directorId' => $directorHidden,
					'directorNameStr' => $artistNameStr,
					'producerNameArr' => $producerNameArr,
					'producerId' => $producerHidden,
					'producerNameStr' => $artistNameStr,
					'writerNameArr' => $writerNameArr,
					'writerId' => $writerHidden,
					'writerNameStr' => $artistNameStr,
					'mdirectorNameArr'=>$mdirectorNameArr,
					'mdirectorId' => $mdirectorHidden,
					'mdirectorNameStr'=>$artistNameStr,
					'lyricistNameArr'=>$lyricistNameArr,
					'lyricistId' => $lyricistHidden,
					'lyricistNameStr'=>$artistNameStr,
					'couplingIds' => $aData[0]->coupling_ids,
					'albumTypeStr' => $albumTypeStr,
					'tvchannelIds'=> $tagAlbumMapArr,
					'radioIds'=> $tagAlbumMapArr,
					'showName' => $aData[0]->show_name,
					'broadCastYear' => $aData[0]->broadcast_year,
					'grade' => $aData[0]->grade,
					'isSubtitle' => $aData[0]->is_subtitle,
					'filmRating' => $aData[0]->film_rating,
					'image' => $aData[0]->album_image,
			   );
			   //print_r($edtData);exit;
		$data['aContent']=$edtData;
	}
	$data['languageList']=$languageList;
	$data['catalogueList']=$catalogueList;
	$data['labelList']=$labelList;
	$data['tvchannelList']=$tvchannelList;
	$data['radioList']=$radioList;
}
if($action == 'view'){
	
	
	/*
	* To display rights popup start	
	*/
	if($do=='rights'){
	
	
$mBanner=new banner();
$bParams = array(
			'limit'	  => 10000,  
			'orderby' => 'ORDER BY banner_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
 
$bannerList=$mBanner->getAllBanners($bParams);		


		$view = 'album_rights';
		if(!empty($_POST) && isset($_POST)){
		
		    $territory_arr = array();
			$territory_ex_arr = array();
			
			$albumRightId = cms::sanitizeVariable( $_POST['albumRightId'] );
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
					'albumRightId'=>$albumRightId,
					'albumId'=>$id,
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
				$mData=$mAlbum->addAlbumRights($postData);
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
									'moduleName' => 'album rights',
									'action' => $action,
									'moduleId' => 14,
									'editorId' => $this->user->user_id,
									'remark'	=>	'Edited album rights information. (ID-'.$id.')',
									'content_ids' => (int)$id
								);
				TOOLS::writeActivityLog( $aLogParam );
								
				//TOOLS::log('album rights', $action, '14', $this->user->user_id, "Album, Id: ".(int)$mData."" );
				//header("location:".$refferer."&msg=Action completed successfully.");
			}
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;
			$data['bannerList_arr']=$bannerList;			
			
		}else {
	
	
			$params=array(
					'where' => " AND album_id=".$id,
					);
					
			
			$dataRightsByAlbumId=$mAlbum->getRightsByAlbumId($params);
			$publishingRights = $dataRightsByAlbumId[0]->publishing_rights;
			$digitalRights = $dataRightsByAlbumId[0]->digital_rights;
		
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
			
		
			if($dataRightsByAlbumId){
				$edtData=array(
					
						'albumId'=>$dataRightsByAlbumId[0]->album_id,
						'is_owned'=>$dataRightsByAlbumId[0]->is_owned,
						'banner_id'=>$dataRightsByAlbumId[0]->banner_id,
						'territory_in'=>$dataRightsByAlbumId[0]->territory_in,
						'territory_ex'=>$dataRightsByAlbumId[0]->territory_ex,
						'start_date'=>$dataRightsByAlbumId[0]->start_date,
						'end_date'=>$dataRightsByAlbumId[0]->expiry_date,
						'physical_rights'=>$dataRightsByAlbumId[0]->physical_rights,
						'publishing_rights'=>$pubRightStr,
						'digital_rights'=>$digiRightStr,
						'is_exclusive'=>$dataRightsByAlbumId[0]->is_exclusive,
					);
					
					
				$data['aContent']=$edtData;
				$data['bannerList_arr']=$bannerList;
				
				
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
	* To display album details start	
	*/
	if($do=='details'){
		$view = 'album_details';
		$aData=$mAlbum->getAlbumById(array('ids'=>$id));
		$albumType =$aData[0]->album_type;
		$albumTypeArr=array();
		if($albumType){				  
			$isFilm = (($albumType&1)==1)?$albumTypeArr[]=1:"";
			$isOriginal = (($albumType&2)==2)?$albumTypeArr[]=2:"";
			$isDigital = (($albumType&4)==4)?$albumTypeArr[]=4:"";
		}
		if($albumTypeArr){
			$albumTypeStr=implode("|",$albumTypeArr);
		}
		
		$artistAlbumMapData=$mAlbum->getArtistAlbumMap(array('where'=> " AND album_id=".$id));
		$artistIdArray=array();
		$artistIdMapArray=array();
		if($artistAlbumMapData){
			foreach($artistAlbumMapData as $vMap){
				$artistIdArray[]=$vMap->artist_id;
				$artistIdMapArray[$vMap->artist_id]=$vMap->artist_role;	
			}	
		}
		$artistIdStr="0";
		if($artistIdArray){
			$artistIdStr=implode(",",$artistIdArray);
		}
		$mArtist=new artist();
		$mArtistArray=$mArtist->getArtistById(array('ids'=>(int)$aData[0]->artist_id.",".$artistIdStr));
		$artistNameStr="";
		$mArtistArrayWithId=array();
		$starcastNameArr=array();
		$producerNameArr=array();
		$directorNameArr=array();
		$writerNameArr=array();
		$mdirectorNameArr=array();
		$lyricistNameArr=array();
		
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $vArt){
				$mArtistArrayWithId[$vArt->artist_id]=$vArt;
				$artistNameStr.=$vArt->artist_id.":".$vArt->artist_name."|";
				if(($aConfig['artist_type']['Starcast']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Starcast']){
					$starcastHiddenArr[]=$vArt->artist_id;
					$starcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Producer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Producer']){
					$producerHiddenArr[]=$vArt->artist_id;
					$producerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Director']){
					$directorHiddenArr[]=$vArt->artist_id;
					$directorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Writer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Writer']){
					$writerHiddenArr[]=$vArt->artist_id;
					$writerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Music Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Music Director']){
					$mdirectorHiddenArr[]=$vArt->artist_id;
					$mdirectorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				if(($aConfig['artist_type']['Lyricist']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Lyricist']){
					$lyricistHiddenArr[]=$vArt->artist_id;
					$lyricistNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
			}
		}
		$starcastHidden="";
		if($starcastHiddenArr){
			$starcastHidden=implode(",",$starcastHiddenArr);
		}
		$producerHidden="";
		if($producerHiddenArr){
			$producerHidden=implode(",",$producerHiddenArr);
		}
		$directorHidden="";
		if($directorHiddenArr){
			$directorHidden=implode(",",$directorHiddenArr);
		}
		$writerHidden="";
		if($writerHiddenArr){
			$writerHidden=implode(",",$writerHiddenArr);
		}
		$mdirectorHidden="";
		if($mdirectorHiddenArr){
			$mdirectorHidden=implode(",",$mdirectorHiddenArr);
		}
		$lyricistHidden="";
		if($lyricistHiddenArr){
			$lyricistHidden=implode(",",$lyricistHiddenArr);
		}
		
		$artistNameArr=array();
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $mArtistArray){
					$artistNameArr[$aData[0]->artist_id]=$mArtistArrayWithId[$aData[0]->artist_id]->artist_name;
			}
		}
		
		$bannerAlbumMapData=$mAlbum->getBannerAlbumMap(array('where'=> " AND album_id=".$id));
		$bannerHiddenArr=array();
		if($bannerAlbumMapData){
			foreach($bannerAlbumMapData as $banner){
				$bannerHiddenArr[]=$banner->banner_id;
			}
		}
		$bannerHidden="";
		if($bannerHiddenArr){
			$bannerHidden=implode(",",$bannerHiddenArr);
		}
		$mBanner=new banner();
		$bannerHiddenIn="0";
		if($bannerHidden){
			$bannerHiddenIn=$bannerHidden;
		}
		$bannerNameArr=array();
		$bannerNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY banner_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND banner_id IN (".$bannerHiddenIn.")",
		   );
		$bannerData=$mBanner->getAllBanners($bParams);
		if($bannerData){
			foreach($bannerData as $bD){
				$bannerNameStr.=$bD->banner_id.":".$bD->banner_name."|";
				$bannerHiddenArr[]=$bD->banner_id;
				$bannerNameArr[$bD->banner_id]=$bD->banner_name;
			}	
		}
		
		
		
		$tagAlbumMapData=$mAlbum->getTagAlbumMap(array('where'=> " AND album_id=".$id));
		$tagAlbumMapArr=array();
		if($tagAlbumMapData){
			foreach($tagAlbumMapData as $tag){
				$tagAlbumMapArr[]=$tag->tag_id;
			}
		}
		$dtData=array(
					'albumId'=>$aData[0]->album_id,
					'albumName'=>$aData[0]->album_name,
					'status'=>$aData[0]->status,
					'labelIds' => $aData[0]->label_id,
					'languageIds'=>$aData[0]->language_id,
					'bannerNameArr'=>$bannerNameArr,
					'bannerId' => $bannerHidden,
					'bannerNameStr'=>$bannerNameStr,
					'primaryArtist' => (int)$aData[0]->artist_id,
					'musicReleaseDate' => $aData[0]->music_release_date,
					'titleReleaseDate' => $aData[0]->title_release_date,
					'albumDescription' => $aData[0]->album_desc,
					'albumExcerpt' => $aData[0]->album_excerpt,
					'albumType' => $albumTypeArr,
					'albumContentType' => $aData[0]->content_type,
					'artistId' => $aData[0]->artist_id,
					'artistNameStr'=>$artistNameStr,
					'artistNameArr'=>$artistNameArr,
					'starcastNameArr'=>$starcastNameArr,
					'starcastId' => $starcastHidden,
					'starcastNameStr'=>$artistNameStr,
					'directorNameArr'=>$directorNameArr,
					'directorId' => $directorHidden,
					'directorNameStr'=>$artistNameStr,
					'producerNameArr'=>$producerNameArr,
					'producerId' => $producerHidden,
					'producerNameStr'=>$artistNameStr,
					'writerNameArr'=>$writerNameArr,
					'writerId' => $writerHidden,
					'writerNameStr'=>$artistNameStr,
					'mdirectorNameArr'=>$mdirectorNameArr,
					'mdirectorId' => $mdirectorHidden,
					'mdirectorNameStr'=>$artistNameStr,
					'lyricistNameArr'=>$lyricistNameArr,
					'lyricistId' => $lyricistHidden,
					'lyricistNameStr'=>$artistNameStr,
					'couplingIds' => $aData[0]->coupling_ids,
					'albumTypeStr' => $albumTypeStr,
					'tvchannelIds'=> $tagAlbumMapArr,
					'radioIds'=> $tagAlbumMapArr,
					'showName' => $aData[0]->show_name,
					'broadCastYear'=>$aData[0]->broadcast_year,
					'grade' => $aData[0]->grade,
					'isSubtitle'=>$aData[0]->is_subtitle,
					'filmRating' => $aData[0]->film_rating,
					'image'=>$aData[0]->album_image,
			   );
			   #print_r($edtData);exit;
		$data['aContent']=$dtData;
		$data['languageList']=$languageList;
		$data['catalogueList']=$catalogueList;
		$data['labelList']=$labelList;
		$data['tvchannelList']=$tvchannelList;
		$data['radioList']=$radioList;
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display album details end	
	*/
	if($do=='export' ){
####################################################################################

		$oTags = new tags();
		$aTags = $oTags->getAllTags( array('onlyParent'=>true,'where' => " AND tag_access&4=4") );

		/* Search Param start */
		$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
		$autosuggestalbum_hddn = cms::sanitizeVariable( $_GET['autosuggestalbum_hddn'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$srcSrtDate = cms::sanitizeVariable( $_GET['srcSrtDate'] ); 
		$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
		$srcClgue = cms::sanitizeVariable( $_GET['srcClgue'] );
		$srcLang = cms::sanitizeVariable( $_GET['srcLang'] );
		$srcLbl = cms::sanitizeVariable( $_GET['srcLbl'] );
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
		$srcRtTag = cms::sanitizeVariable( $_GET['srcRtTag'] );
		$srcAlbumId = cms::sanitizeVariable( $_GET['srcAlbumId'] );
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$autosuggestartist_hddn = cms::sanitizeVariable( $_GET['autosuggestartist_hddn'] );
		$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
		$srcTxtTag = cms::sanitizeVariable( $_GET['srcTxtTag'] );
		$autosuggesttag_hddn = cms::sanitizeVariable( $_GET['autosuggesttag_hddn'] );
		$srcFilm = cms::sanitizeVariable( $_GET['srcFilm'] );
		$srcOriginal = cms::sanitizeVariable( $_GET['srcOriginal'] );
		//$srcDigital = cms::sanitizeVariable( $_GET['srcDigital'] );
		$album_content_type = cms::sanitizeVariable( $_GET['album_content_type'] );
		$srcEnd	 = cms::sanitizeVariable( $_GET['srcEnd'] );
		
		$where		 = '';
		if($autosuggestalbum_hddn>0){
			$where .= ' AND album_id="'.$oMysqli->secure($autosuggestalbum_hddn).'"';
		}elseif( $srcAlbum != '' ){
			$where .= ' AND album_name like "%'.$oMysqli->secure($srcAlbum).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		if( $srcAlbumId != '' ){
			$where .= ' AND album_id="'.$oMysqli->secure($srcAlbumId).'"';
		}
		if( $srcLang != '' ){
			$where .= ' AND language_id="'.$oMysqli->secure($srcLang).'"';
		}
		if( $srcClgue != '' ){
			$where .= ' AND catalogue_id="'.$oMysqli->secure($srcClgue).'"';
		}
		if( $srcLbl != '' ){
			$where .= ' AND label_id="'.$oMysqli->secure($srcLbl).'"';
		}
		if( $album_content_type != '' ){
			$where .= ' AND content_type&'.$album_content_type.'="'.$oMysqli->secure($album_content_type).'"';
		}		
		if( $srcSrtDate != '' && $srcEndDate != ''  ){
			$where .= ' AND title_release_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcEndDate).'"';
		}elseif($srcSrtDate != ''){
			$where .= ' AND title_release_date >= "'.$oMysqli->secure($srcSrtDate).'"';
		}elseif($srcEndDate != ''){
			$where .= ' AND title_release_date <= "'.$oMysqli->secure($srcEndDate).'"';
		}
	//	echo $where; exit;
		
		if( $srcArtist != '' && $autosuggestartist_hddn !=""){
			$param = array( "where" => " AND artist_id =".$autosuggestartist_hddn );
			$albumIdList = $mAlbum->getArtistAlbumMap($param);
			if($albumIdList){
				$albumIdListArr=NULL;
				foreach($albumIdList as $albumVal){		
					$albumIdListArr[]= $albumVal->album_id;
				}
				if(!empty($albumIdListArr)){
					$albumIdListStr = implode(",",$albumIdListArr);
					$where .= ' AND album_id IN ('.$albumIdListStr.')';	
				}
			}else{
				$where .= ' AND album_id =0';
			}
		}
		if( $srcTag != '' &&  $autosuggesttag_hddn !=""){
			$param = array( "where" => " AND tag_id =".$autosuggesttag_hddn );
			$albumIdList = $mAlbum->getTagAlbumMap($param);
			if($albumIdList){
				$albumIdListArr=NULL;
				foreach($albumIdList as $albumVal){		
					$albumIdListArr[]= $albumVal->album_id;
				}
				if(!empty($albumIdListArr)){
					$albumIdListStr = implode(",",$albumIdListArr);
					$where .= ' AND album_id IN ('.$albumIdListStr.')';	
				}
			}else{
				$where .= ' AND album_id = 0';
			}
		}
	
		if($srcFilm !=""){
			if($srcFilm=='1'){
				$where .= " AND album_type&1=1";
			}elseif($srcFilm=='-1'){
				$where .= " AND album_type&1!=1";
			}	
		}
		if($srcOriginal !=""){
			if($srcOriginal=='2'){
				$where .= " AND album_type&2=2";
			}elseif($srcOriginal=='-2'){
				$where .= " AND album_type&2!=2";
			}
		}

		$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'album_id', 'default_sort'=>'DESC', 'field'=>$_GET['field'] ) );
	

		if(isset($srcEnd) && strlen($srcEnd)>0 && $srcEnd<1001){			
			$limit = $srcEnd;
			 
		}else{			
			$limit = 1000;
			 
		}
		

		$params2 = array(
					'limit'	  => $limit,  
					'orderby' => $orderBy,  
					'start'   => $start,  
					'where'	  => $where,
				  );
		
		$data['aContent'] = $mAlbum->getAllAlbums($params2 );//echo $mAlbum;exit;
	
#####################################################################################

$sExcelRow = "Album Id\tAlbum Name\tLanguage Name\tLabel Name\tCatalogue Id\tMovie Release Date\tRelease Date\tAlbu Type\tBanner\tStarcast\tMusic Director\tLyricist\tDirector\tProducer\tWriter\t \n";

$mArtist=new artist();
$mBanner=new banner();
//$artistMapping_arr = array();
//print_r($artistMapping_arr);
foreach($data['aContent'] as $exlData){

#############Banner##############
		$bannerAlbumMapData=$mAlbum->getBannerAlbumMap(array('where'=> " AND album_id=".$exlData->album_id));
		$bannerHiddenArr=array();
		if($bannerAlbumMapData){
			foreach($bannerAlbumMapData as $banner){
				$bannerHiddenArr[]=$banner->banner_id;
			}
		}
		$bannerHidden="";
		if($bannerHiddenArr){
			$bannerHidden=implode(",",$bannerHiddenArr);
		}
		
		$bannerHiddenIn="0";
		if($bannerHidden){
			$bannerHiddenIn=$bannerHidden;
		}
		$bannerNameArr=array();
		$bannerNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY banner_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND banner_id IN (".$bannerHiddenIn.")",
		   );
		$bannerData=$mBanner->getAllBanners($bParams);
		if($bannerData){
			foreach($bannerData as $bD){
				$bannerNameArr[$bD->banner_id]=$bD->banner_name;
			}	
		}

#############Banner End###########

		
		$artistAlbumMapData=$mAlbum->getArtistAlbumMap(array('where'=> " AND album_id=".$exlData->album_id));
		$artistIdArray=array();
		$artistIdMapArray=array();
		$artistDataMapping_arr = array();
		
		if($artistAlbumMapData){
		
			foreach($artistAlbumMapData as $vMap){
			
				$artistIdArray[]=$vMap->artist_id;
				$artistIdMapArray[$vMap->artist_id]=$vMap->artist_role;
			}	
		}
	
	
		$artistIdStr="0";
		if($artistIdArray){
			$artistIdStr=implode(",",$artistIdArray);
		}
		
		
		$mArtistArray=$mArtist->getArtistById(array('ids'=>$artistIdStr));
		$artistNameStr="";
		$mArtistArrayWithId=array();
		$starcastNameArr=array();
		$producerNameArr=array();
		$directorNameArr=array();
		$writerNameArr=array();
		$mdirectorNameArr=array();
		$lyricistNameArr=array();
		
		if($mArtistArray && is_array($mArtistArray)){
			foreach($mArtistArray as $vArt){
			
				$mArtistArrayWithId[$vArt->artist_id]=$vArt;
				
				if(($aConfig['artist_type']['Starcast']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Starcast']){
					
					$starcastNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
				if(($aConfig['artist_type']['Producer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Producer']){
					
					$producerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
				if(($aConfig['artist_type']['Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Director']){
					
					$directorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
				if(($aConfig['artist_type']['Writer']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Writer']){
					
					$writerNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
				if(($aConfig['artist_type']['Music Director']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Music Director']){
					
					$mdirectorNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
				if(($aConfig['artist_type']['Lyricist']&$artistIdMapArray[$vArt->artist_id])==$aConfig['artist_type']['Lyricist']){
					
					$lyricistNameArr[$vArt->artist_id]=$vArt->artist_name;
				}
				
				
			}
		}

$star = '';
if(!empty($starcastNameArr)){
	foreach($starcastNameArr as $key=>$val){
	
		$star .= $val. " ,";
	}
}
$prod = '';
if(!empty($producerNameArr)){
	foreach($producerNameArr as $key=>$val){
	
		$prod .= $val. " ,";
	}
}
$dire = '';
if(!empty($directorNameArr)){
	foreach($directorNameArr as $key=>$val){
	
		$dire .= $val. " ,";
	}
}
$wri = '';
if(!empty($writerNameArr)){
	foreach($writerNameArr as $key=>$val){
	
		$wri .= $val. " ,";
	}
}
$mdir = '';
if(!empty($mdirectorNameArr)){
	foreach($mdirectorNameArr as $key=>$val){
	
		$mdir .= $val. " ,";
	}
}
$lyri = '';
if(!empty($lyricistNameArr)){
	foreach($lyricistNameArr as $key=>$val){
	
		$lyri .= $val. " ,";
	}
}
$BNmae = '';
if(!empty($bannerNameArr)){
	foreach($bannerNameArr as $banId=>$banName){
	
		$BNmae .= $banName." ,";
	}
}


$albumTypeFilm = ((1&$exlData->album_type)==1) ? "Film" : "Non Film" ;
$albumTypeCO   = ((2&$exlData->album_type)==2) ? "Compile" : "Orignal" ;

if($albumTypeFilm || $albumTypeCO){
	$albumTypeStr= $albumTypeFilm ." ,".$albumTypeCO;
}

$languageName = $mLanguage->getLanguageById(array('where'=>' AND language_id = '.$exlData->language_id));
$labelName	  = $mLabel->getLabelById(array('ids'=>$exlData->label_id));


$sExcelRow .= $exlData->album_id."\t";
$sExcelRow .= $exlData->album_name."\t";
$sExcelRow .= $languageName[0]->language_name."\t";
$sExcelRow .= $labelName[0]->label_name."\t";
$sExcelRow .= $exlData->catalogue_id."\t";
$sExcelRow .= $exlData->music_release_date."\t";
$sExcelRow .= $exlData->title_release_date."\t";
$sExcelRow .= $albumTypeStr."\t";
$sExcelRow .= trim($BNmae,","). "\t";
$sExcelRow .= trim($star,","). "\t";
$sExcelRow .= trim($mdir,",")."\t";
$sExcelRow .= trim($lyri,",")."\t";
$sExcelRow .= trim($dire,",")."\t";
$sExcelRow .= trim($prod,",")."\t";
$sExcelRow .= trim($wri,",")."\t";
$sExcelRow .= "\n";
}
						
$filename = "album_exl_".date('YmdHis').".xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $sExcelRow;
exit;
}	

		$view = 'album_list';
		/* Publish/Draft/Delete Action Start */
		if(isset($_POST) && !empty($_POST)){
			/* publish , unpublish, legal aplly to all leaf content of album end*/
			if((int)$_POST['contentId'] || !empty($_POST['select_ids'])){
				$contentAction		=	cms::sanitizeVariable( $_POST['act'] );
				if(!$contentAction){
					$contentAction		=	cms::sanitizeVariable( $_POST['contentAction'] );
				}
				$contentActionValue =	TOOLS::getContentActionValue($contentAction);

				$limit	= 10000;
				$start	= 0;
				if(!empty($_POST['select_ids'])){
					$albIds=implode(",",$_POST['select_ids']);
				}elseif((int)$_POST['contentId']){
					$albIds=(int)$_POST['contentId'];
				}
				$where = " AND album_id IN (".$albIds.")";
				$params = array(
							'limit'	  => $limit,  
							'orderby' => " ORDER BY album_id Desc",  
							'start'   => $start,  
							'where'	  => $where,
						  );
				$albumData = $mAlbum->getAllAlbums($params ); //echo $mAlbum;
				if(!empty($albumData)){
					$mSong=new song();
					$mVideo=new video();
					$mText=new text();
					$mImage=new image();
					foreach($albumData as $kAD=>$vAD){
							if((2&$vAD->album_type)==2){ // only need for original ALbums.
								$sParam=array( 'where' => " AND album_id IN (".$albIds.")", );
								$songData=$mSong->getAlbumSongMap($sParam);
								$songIds="";
								if($songData){
									foreach($songData as $vSD){
										$songIds[]=$vSD->song_id;
									}
								}
								if($songIds){
									$params = array(
												'contentIds' => $songIds, 
												'contentAction' => $contentAction, 
												'contentActionValue' => $contentActionValue, 
												);
									$data = $mSong->doMultiAction( $params );
								}
								$sParam=array( 'where' => " AND album_id IN (".$albIds.")", );
								$videoData=$mVideo->getAlbumVideoMap($sParam);
								$videoIds="";
								if($videoData){
									foreach($videoData as $vVD){
										$videoIds[]=$vVD->video_id;
									}
								}
								if($videoIds){
									$params = array(
												'contentIds' => $videoIds, 
												'contentAction' => $contentAction, 
												'contentActionValue' => $contentActionValue, 
												);
									$data = $mVideo->doMultiAction( $params );	
								}
								$sParam=array( 'where' => " AND content_id IN (".$albIds.") AND content_type='14'", );
								$textData=$mText->getTextMap($sParam);
								$textIds="";
								if($textData){
									foreach($textData as $vTD){
										$textIds[]=$vTD->text_id;
									}
								}
								if($textIds){
									$params = array(
												'contentIds' => $textIds, 
												'contentAction' => $contentAction, 
												'contentActionValue' => $contentActionValue, 
												);
									$data = $mText->doMultiAction( $params );	
								}
								$sParam=array( 'where' => " AND content_id IN (".$albIds.") AND content_type='14'", );
								$imageData=$mImage->getImageMap($sParam);
								$imageIds="";
								if($imageData){
									foreach($imageData as $vID){
										$imageIds[]=$vID->image_id;
									}
								}
								if($imageIds){
									$params = array(
												'contentIds' => $imageIds, 
												'contentAction' => $contentAction, 
												'contentActionValue' => $contentActionValue, 
												);
									$data = $mImage->doMultiAction( $params );
								}
							}
					}
				}
			}
			/* publish , unpublish, legal aplly to all leaf content of album end*/
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
					$data = $mAlbum->doMultiAction( $params );
					
					/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'album',
						'action' => $contentAction,
						'moduleId' => 14,
						'editorId' => $this->user->user_id,
						'content_ids' => $_POST['select_ids']
					);
					$oNotification->sendNotification( $oMailParam );
					/* Send Mail Notification end*/
					
					/* Write DB Activity Logs */
					#TOOLS::log('album', $contentAction, '14', $this->user->user_id, "Albums, Ids: ".implode("','", $_POST['select_ids'])."" );
					$aLogParam = array(
						'moduleName' => 'album',
						'action' => $action,
						'moduleId' => 14,
						'editorId' => $this->user->user_id,
						'remark'	=>	ucfirst($contentAction).' album.',
						'content_ids' => $_POST['select_ids']
					);
					TOOLS::writeActivityLog( $aLogParam );
					header("location:".SITEPATH."album?action=view&do=".$do."&msg=Action completed successfully.");
					exit;
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

				if($contentModel=='album' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $mAlbum->doAction($params );
					
					/* Send Mail Notification start*/
					$oMailParam = array(
						'moduleName' => 'album',
						'action' => $contentAction,
						'moduleId' => 14,
						'editorId' => $this->user->user_id,
						'content_ids' => $contentId
					);
					$oNotification->sendNotification( $oMailParam );
					/* Send Mail Notification end*/
				
					/* Write DB Activity Logs */
					#TOOLS::log('album', $contentAction, '14', $this->user->user_id, "Albums, Id: ".$contentId."" );
					/* Saved */
					/* Write DB Activity Logs */
					$aLogParam = array(
										'moduleName' => 'album',
										'action' => $contentAction,
										'moduleId' => 14,
										'editorId' => $this->user->user_id,
										'remark'	=>	ucfirst($contentAction).'ed album. (ID-'.(int)$contentId.')',
										'content_ids' => (int)$contentId
									);
					TOOLS::writeActivityLog( $aLogParam );

					header("location:".SITEPATH."album?action=view&do=".$do."&msg=Action completed successfully.");
					exit;
				}else{
					/* Error occured */
					$data['aError'][] = 'Error: Please try again.';
				}
				/* Single Action End */
			}
		}
		/* Publish/Draft/Delete Action End */

		$oTags = new tags();
		$aTags = $oTags->getAllTags( array('onlyParent'=>true,'where' => " AND tag_access&4=4") );

		/* Search Param start */
		$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
		$autosuggestalbum_hddn = cms::sanitizeVariable( $_GET['autosuggestalbum_hddn'] );
		$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
		$srcSrtDate = cms::sanitizeVariable( $_GET['srcSrtDate'] ); 
		$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
		$srcClgue = cms::sanitizeVariable( $_GET['srcClgue'] );
		$srcLang = cms::sanitizeVariable( $_GET['srcLang'] );
		$srcLbl = cms::sanitizeVariable( $_GET['srcLbl'] );
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
		$srcRtTag = cms::sanitizeVariable( $_GET['srcRtTag'] );
		$srcAlbumId = cms::sanitizeVariable( $_GET['srcAlbumId'] );
		$srcArtist = cms::sanitizeVariable( $_GET['srcArtist'] );
		$autosuggestartist_hddn = cms::sanitizeVariable( $_GET['autosuggestartist_hddn'] );
		$srcTag = cms::sanitizeVariable( $_GET['srcTag'] );
		$srcTxtTag = cms::sanitizeVariable( $_GET['srcTxtTag'] );
		$autosuggesttag_hddn = cms::sanitizeVariable( $_GET['autosuggesttag_hddn'] );
		$srcFilm = cms::sanitizeVariable( $_GET['srcFilm'] );
		$srcOriginal = cms::sanitizeVariable( $_GET['srcOriginal'] );
	//	$srcDigital = cms::sanitizeVariable( $_GET['srcDigital'] );
		$album_content_type = cms::sanitizeVariable( $_GET['album_content_type'] );
		$srcEnd	 = cms::sanitizeVariable( $_GET['srcEnd'] );
		
		$where		 = '';
		if($autosuggestalbum_hddn>0){
			$where .= ' AND album_id="'.$oMysqli->secure($autosuggestalbum_hddn).'"';
		}elseif( $srcAlbum != '' ){
			$where .= ' AND album_name like "%'.$oMysqli->secure($srcAlbum).'%"';
		}
		if( $srcCType != '' ){
			$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
			$where .= ' AND status ="'.$srcCtypeVal.'" ';
		}
		if( $srcAlbumId != '' ){
			$where .= ' AND album_id="'.$oMysqli->secure($srcAlbumId).'"';
		}
		if( $srcLang != '' ){
			$where .= ' AND language_id="'.$oMysqli->secure($srcLang).'"';
		}
		if( $srcClgue != '' ){
			$where .= ' AND catalogue_id="'.$oMysqli->secure($srcClgue).'"';
		}
		if( $srcLbl != '' ){
			$where .= ' AND label_id="'.$oMysqli->secure($srcLbl).'"';
		}
		if( $album_content_type != '' ){
			$where .= ' AND content_type&'.$album_content_type.'="'.$oMysqli->secure($album_content_type).'"';
		}		
		if( $srcSrtDate != '' && $srcEndDate != ''  ){
			$where .= ' AND title_release_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcEndDate).'"';
		}elseif($srcSrtDate != ''){
			$where .= ' AND title_release_date >= "'.$oMysqli->secure($srcSrtDate).'"';
		}elseif($srcEndDate != ''){
			$where .= ' AND title_release_date <= "'.$oMysqli->secure($srcEndDate).'"';
		}
		
		
		if( $srcArtist != '' && $autosuggestartist_hddn !=""){
			$param = array( "where" => " AND artist_id =".$autosuggestartist_hddn );
			$albumIdList = $mAlbum->getArtistAlbumMap($param);
			if($albumIdList){
				$albumIdListArr=NULL;
				foreach($albumIdList as $albumVal){		
					$albumIdListArr[]= $albumVal->album_id;
				}
				if(!empty($albumIdListArr)){
					$albumIdListStr = implode(",",$albumIdListArr);
					$where .= ' AND album_id IN ('.$albumIdListStr.')';	
				}
			}else{
				$where .= ' AND album_id =0';
			}
		}
		if( $srcTag != '' &&  $autosuggesttag_hddn !=""){
			$param = array( "where" => " AND tag_id =".$autosuggesttag_hddn );
			$albumIdList = $mAlbum->getTagAlbumMap($param);
			if($albumIdList){
				$albumIdListArr=NULL;
				foreach($albumIdList as $albumVal){		
					$albumIdListArr[]= $albumVal->album_id;
				}
				if(!empty($albumIdListArr)){
					$albumIdListStr = implode(",",$albumIdListArr);
					$where .= ' AND album_id IN ('.$albumIdListStr.')';	
				}
			}else{
				$where .= ' AND album_id = 0';
			}
		}
	
		if($srcFilm !=""){
			if($srcFilm=='1'){
				$where .= " AND album_type&1=1";
				$data['aSearch']['srcFilm'] 	= "checked";
			}elseif($srcFilm=='-1'){
				$where .= " AND album_type&1!=1";
				$data['aSearch']['srcNonFilm'] 	= "checked";
			}	
		}
		if($srcOriginal !=""){
			if($srcOriginal=='2'){
				$where .= " AND album_type&2=2";
				$data['aSearch']['srcOriginal'] 	= "checked";
			}elseif($srcOriginal=='-2'){
				$where .= " AND album_type&2!=2";
				$data['aSearch']['srcNonOriginal'] 	= "checked";
			}
		}
		
		$lParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY language_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1",
		   );
		$languageList=$mLanguage->getAllLanguages($lParams);

		$data['aSearch']['srcAlbum'] 	= $srcAlbum;
		$data['aSearch']['autosuggestalbum_hddn'] 	= $autosuggestalbum_hddn;
		$data['aSearch']['srcCType'] 	= $srcCType;
		$data['aSearch']['srcAlbumId'] 	= $srcAlbumId;
		$data['aSearch']['srcLang'] 	= $srcLang;
		$data['aSearch']['srcClgue'] 	= $srcClgue;
		$data['aSearch']['languageList'] 	= $languageList;	
		$data['aSearch']['catalogueList'] 	= $catalogueList;	
		$data['aSearch']['srcLbl'] 	= $srcLbl;
		$data['aSearch']['labelList'] 	= $labelList;	
		$data['aSearch']['srcSrtDate'] 	= $srcSrtDate;
		$data['aSearch']['srcEndDate'] 	= $srcEndDate;
		$data['aSearch']['srcArtist'] 	= $srcArtist;
		$data['aSearch']['autosuggestartist_hddn'] 	= $autosuggestartist_hddn;
		$data['aSearch']['tagsList'] 	= $aTags;
		$data['aSearch']['srcTag'] 	= $srcTag;
		$data['aSearch']['srcTxtTag'] 	= $srcTxtTag;
		$data['aSearch']['autosuggesttag_hddn'] 	= $autosuggesttag_hddn;
		$data['aSearch']['srcRtTag'] 	= $srcRtTag;
		$data['aSearch']['album_content_type'] 	= $album_content_type;
		$data['aSearch']['srcEnd'] 	= $srcEnd;
		/* Search Param end */
		$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'album_id', 'default_sort'=>'DESC', 'field'=>$_GET['field'] ) );
		
		if($_GET['do']=="qclist" && $this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
			$where=" AND status=0";
		}
		if($_GET['do']=="legallist" && $this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
			$where=" AND status=2";
		}
		if($_GET['do']=="publishlist" && $this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
			$where=" AND status=3";
		}
		if ($this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
			$qcparams=array("where" =>" AND status=0");
			$qcPendingTotal=$mAlbum->getTotalCount( $qcparams );
			$data['qcPendingTotal'] 	= $qcPendingTotal;
		}
		if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
			$qcparams=array("where" =>" AND status=2");
			$legalPendingTotal=$mAlbum->getTotalCount( $qcparams );
			$data['legalPendingTotal'] 	= $legalPendingTotal;
		}
		if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
			$qcparams=array("where" =>" AND status=3");
			$publishPendingTotal=$mAlbum->getTotalCount( $qcparams );
			$data['publishPendingTotal'] 	= $publishPendingTotal;
		}
		/* Show Language as List Start */
	
		if(isset($srcEnd) && strlen($srcEnd)>0 && $srcEnd<1001){			
			$limit = $srcEnd;
			 
		}else{			
			$limit = MAX_DISPLAY_COUNT;
			 
		}
	
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*$limit) : 0 );
		

		$params = array(
					'limit'	  => $limit,  
					'orderby' => $orderBy,  
					'start'   => $start,  
					'where'	  => $where,
				  );
				  
		$params = ($do=='export') ?  $params2 : $params;
				  
		$data['aContent'] = $mAlbum->getAllAlbums($params );// echo $mAlbum;
		/* Pagination Start */

	if(isset($srcEnd) && strlen($srcEnd)>0 && $srcEnd<1001){			
		$data['iTotalCount'] = count($data['aContent']);
		 
		}else{
		
		$oPage = new Paging();		
		$oPage->total = $mAlbum->getTotalCount($params );	
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url ="album?action=view&srcAlbum=$srcAlbum&srcCType=$srcCType&srcSrtDate=$srcSrtDate&srcEndDate=$srcEndDate&srcLang=$srcLang&srcClgue=$srcClgue&srcLbl=$srcLbl&srcArtist=$srcArtist&autosuggestartist_hddn=$autosuggestartist_hddn&srcTag=$srcTag&srcRtTag=$srcRtTag&autosuggesttag_hddn=$autosuggesttag_hddn&srcAlbumId=$srcAlbumId&srcFilm=$srcFilm&srcOriginal=$srcOriginal&album_content_type=$album_content_type&srcEnd=$srcEnd&submitBtn=Search&sort=".$_GET['sort']."&field=".$_GET['field']."&page={page}";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;

			 
	
		}
	
}

/* render view */
$oCms->view( $view, $data );