<?php
$view = 'pack_list';
$oPack = new packs();
$oTags = new tags();

$action = cms::sanitizeVariable( $_GET['action'] );
$do = cms::sanitizeVariable( $_GET['do'] );
$id = (int)$_GET['id']; 
$tagParam = array(
		'where' => " AND parent_tag_id= '10113'" // This is for PAck Category Only[Parent ID => 10113 in Tag Master Table].	
	);
$catList = $oTags->getAllTags( $tagParam );

if( $action == 'add' || $action == 'edit' ){
	/* Form */
	$view = 'pack_form';
	$id = (int)$_GET['id']; 
	
	$oLanguage = new language();
	$lParams = array(
				'limit'	  => 100,  
				'orderby' => 'ORDER BY language_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1",
		   );
	$languageList=$oLanguage->getAllLanguages($lParams);
	
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		
		$packName		=	cms::sanitizeVariable($_POST['packName']);
		$catIds			=	(int)$_POST['catIds'];
		$oPicImageId	=	(int)$_POST['oPicImageId'];
		$languageIds	=	(int)$_POST['languageIds'];
		$image 			=	cms::sanitizeVariable($_POST['oPic']);
		$packDescription=	cms::sanitizeVariable($_POST['packDescription']);
		
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
		
		$albumHidden   = trim($_POST['albumHidden'],",");
		$albumHiddenArr=array();
		if($albumHidden){
			$albumHiddenArr=explode(",",$albumHidden);
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
		
		
		if($packName==""){
			$aError[]="Enter Pack Name";
		}
		$isPackExist = $oPack->checkPackExist($packName);
		if( $isPackExist>0 ){
			$aError[]="Pack already Exist!";
		}
		if($catIds==0){
			$aError[]="Select pack category.";
		}
		if(sizeof($artistHiddenArr) == 0 ){
			$aError[]="Select artist.";
		}
		if(sizeof($albumNameArr) == 0 ){
			$aError[]="Select pack albums.";
		}
		
		$params = array(
					'packName' 		=>	$packName, 
					'packDesc' 		=>	$packDescription, 
					'languageIds'	=>	$languageIds, 
					'catIds' 		=>	$catIds, 
					'artistNameArr'	=>	$artistNameArr,
					'artistId' 		=> 	$artistHidden,
					'artistNameStr'	=>	$_POST['artistHiddensData'],
					'image'			=>	$image,
					'albumNameArr'	=>	$albumNameArr,
					'albumId' 		=> 	$albumHidden,
					'albumNameStr'	=>	$_POST['albumHiddensData'],
				 );
		if(empty($aError)){
			
			$id = $oPack->savePack( $params );
			
			if( $id>0 ){
				/* Map pack artist */ 
				$tData = $oPack->mapPackArtist(array('packId'=>(int)$id,'artistIds'=>$artistHiddenArr));
				
				/* Map pack album */
				$tData = $oPack->mapPackAlbum(array('packId'=>(int)$id,'albumIds'=>$albumHiddenArr));
			}
			
			/* Write DB Activity Logs */
			TOOLS::log('packs', $action, '41', (int)$this->user->user_id, "Pack, Id: ".$id."" );
			
			$data['aSuccess'] = 'Data saved successfully.';
			header('location:'.SITEPATH.'packs?msg=Data saved successfully');			
		}else{
			$data['aError'] = $aError;
		}
		$data['aContent'] = $params;
	}else if($action == 'edit'){
		/* Get Pack Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'status' => $status, 
					'where' => " AND pack_id= '".$id."'"
				  ); 
		$aPackData = $oPack->getAllPacks( $params );
		
		$artistTextMapData=$oPack->getPackArtistMap(array('where'=> " AND pack_id=".$id));
		$artistHiddenArr=array();
		if( !empty($artistTextMapData) ){
			foreach($artistTextMapData as $artist){
				$artistHiddenArr[]=$artist->artist_id;
			}
		}
		$artistHidden="";
		if($artistHiddenArr){
			$artistHidden=implode(",",$artistHiddenArr);
		}
		$mArtist=new artist();
		$artistHiddenIn="0";
		if($artistHidden){
			$artistHiddenIn=$artistHidden;
		}
		$artistNameArr=array();
		$artistNameStr="";
		$bParams = array(
				'limit'	  => 1000,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$artistHiddenIn.")",
		   );
		$artistData=$mArtist->getAllArtists($bParams);
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}
		
		$albumTextMapData=$oPack->getPackAlbumMap(array('where'=> " AND pack_id=".$id));
		$albumHiddenArr=array();
		if($albumTextMapData){
			foreach($albumTextMapData as $album){
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
				'limit'	  => 1000,  
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
			
		$data['aContent']['packName'] 		= $aPackData[0]->pack_name;
		$data['aContent']['catIds'] 		= $aPackData[0]->cat_id;
		$data['aContent']['image'] 		= $aPackData[0]->image;
		$data['aContent']['packDescription']= $aPackData[0]->pack_desc;
		$data['aContent']['status']			= $aPackData[0]->status;
		$data['aContent']['languageIds']	= $aPackData[0]->language_id;
		$data['aContent']['artistNameArr']	= $artistNameArr;
		$data['aContent']['artistId'] 		= $artistHidden;
		$data['aContent']['artistNameStr']	= $artistNameStr;
		
		$data['aContent']['albumNameArr']	= $albumNameArr;
		$data['aContent']['albumId'] 		= $albumHidden;
		$data['aContent']['albumNameStr']	= $albumNameStr;
		
	}
	$data['languageList']	= $languageList;
	$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );

}else{
	
	
		#########################POP Up comes here.############	
		if($do=='details'){
			/* Get Tag Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					//'file_type' => $status, 
					'where' => " AND pack_id= '".$id."'"
				  ); 
		$aPackData = $oPack->getAllPacks( $params ); 
		
		$artistTextMapData=$oPack->getPackArtistMap(array('where'=> " AND pack_id=".$id));
		$artistHiddenArr=array();
		if( !empty($artistTextMapData) ){
			foreach($artistTextMapData as $artist){
				$artistHiddenArr[]=$artist->artist_id;
			}
		}
				
		$artistHidden="";
		if($artistHiddenArr){
			$artistHidden=implode(",",$artistHiddenArr);
		}
		$mArtist=new artist();
		$artistHiddenIn="0";
		if($artistHidden){
			$artistHiddenIn=$artistHidden;
		}
		
		$artistNameArr=array();
		$artistNameStr="";
		$bParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY artist_name ASC',  
				'start'   => 0,  
				'where'   => " AND artist_id IN (".$artistHiddenIn.")",
		   );
		$artistData=$mArtist->getAllArtists($bParams);
		
		if($artistData){
			foreach($artistData as $aD){
				$artistNameStr.=$aD->artist_id.":".$aD->artist_name."|";
				$artistHiddenArr[]=$aD->artist_id;
				$artistNameArr[$aD->artist_id]=$aD->artist_name;
			}	
		}
		
		$albumTextMapData=$oPack->getPackAlbumMap(array('where'=> " AND pack_id=".$id));
		
		$albumHiddenArr=array();
		if($albumTextMapData){
			foreach($albumTextMapData as $album){
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
		
			
			$view = 'pack_details';
			$data['aContent']['packId'] 		= $aPackData[0]->pack_id;
			$data['aContent']['packName'] 		= $aPackData[0]->pack_name;
			$data['aContent']['catIds'] 		= $aPackData[0]->cat_id;
			$data['aContent']['image'] 			= $aPackData[0]->image;
			$data['aContent']['packDescription']= $aPackData[0]->pack_desc;
			$data['aContent']['status']			= $aPackData[0]->status;
			$data['aContent']['artistNameArr']	= $artistNameArr;
			$data['aContent']['artistId'] 		= $artistHidden;
			$data['aContent']['artistNameStr']	= $artistNameStr;
						
			$data['aContent']['albumNameArr']	= $albumNameArr;
			$data['aContent']['albumId'] 		= $albumHidden;
			$data['aContent']['albumNameStr']	= $albumNameStr;
			
			$data['catList']					= $catList;
			$oCms->view( $view, $data );
			exit;
			
		}
	
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
				$data = $oPack->doMultiAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('packs', $contentAction, '41', (int)$this->user->user_id, "Packs, Ids: '".implode("','", $_POST['select_ids'])."' " );

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

			if($contentModel=='packs' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oPack->doAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('packs', $contentAction, '41', (int)$this->user->user_id, "Packs, Id: ".$contentId."" );
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
	
	
	$lisData = getlist( $oPack );
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount']	 = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
}

function getlist( $oPack ){
	global $oMysqli;
	/* Search Param start */
	$srcPack = cms::sanitizeVariable( $_GET['srcPack'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$where		 = '';
	if( $srcPack != '' ){
		$where .= ' AND pack_name like "'.$oMysqli->secure($srcPack).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	$data['aSearch']['srcPack'] = $srcPack;
	$data['aSearch']['srcCType'] 	= $srcCType;
	/* Search Param end */
	$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'pack_name', 'default_sort'=>'ASC', 'field'=>'pack_name' ) );
	
	/* Show Pack as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => $orderBy,  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oPack->getAllPacks( $params );
	
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oPack->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "packs?action=view&srcPack=$srcPack&page={page}&sort=".$_GET['sort'];
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */

	/* Show Pack as List End */
	
	return $data;
}

$data['catList']					= $catList;

/* render view */
$oCms->view( $view, $data );