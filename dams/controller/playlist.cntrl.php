<?php     //playlist     
set_time_limit(0);
ini_set('memory_limit','5120M');
$view = 'playlist_list';
$oPlaylist = new playlist();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$id = (int)$_GET['id']; 
$ctype = (int)$_GET['ctype'];
if( $action == 'add'){
	if( $do == 'addto'){
		$view = 'playlist_addto';
		$params=array(
					"limit" => "1000",
					"orderby" => " ORDER BY insert_date DESC",
					"where" => " AND user_id=".TOOLS::getEditorId()." AND content_type=".$ctype,
				);
		$data['aContent']=$oPlaylist->getAllPlaylists($params);
		$oCms->view( $view, $data );
		exit;
	}
	/* Form */
	$view = 'playlist_form';
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		$playlistName	=	cms::sanitizeVariable($_POST['playlistName']);
		if($playlistName==""){
			$aError[]="Enter Playlist Name.";
		}
		$postData=array(
					'playlistId'=>$id,
					'playlistName'=>$playlistName,
					'userID'=>TOOLS::getEditorId(),
					'ctype'=>$ctype,
					);

		if(empty($aError)){ 
			$aData = $oPlaylist->savePlaylist( $postData );
			$logMsg="Created playlist.";
			if($id){
				$aData=$id;
				$logMsg="Edited playlist information.";
			}
			/* Write DB Activity Logs */
			$aLogParam = array(
				'moduleName' => 'playlist',
				'action' => $action,
				'moduleId' => 29,
				'editorId' => $this->user->user_id,
				'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
				'content_ids' => (int)$aData
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'playlist?action=add&song_id='.$_GET['song_id'].'&isPlane=1&do=addto&ctype='.$ctype.'&msg=Data saved successfully');
			exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
}elseif($action == 'edit'){
	if($id > 0){
		if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
			$playlistName	=	cms::sanitizeVariable($_POST['playlistName']);
			$songIds = $_POST['songIds'];
			$oPicImageId=(int)$_POST['oPicImageId'];
			$picname =	cms::sanitizeVariable($_POST['oPic']);
			$languageIds=cms::sanitizeVariable($_POST['languageIds']);
			$ctype=cms::sanitizeVariable($_POST['ctype']);
			
			if($playlistName==""){
				$aError[]="Enter Playlist Name.";
			}
			if(empty($songIds)){
				$aError[]="Please add content to playlist.";
			}
			$postData=array(
						'playlistId'=>$id,
						'playlistName'=>$playlistName,
						'userID'=>TOOLS::getEditorId(),
						'image'=>$picname,
						'languageId'=>$languageIds,
						'ctype'=>$ctype,
					  );
			if(empty($aError)){ 
				$aData = $oPlaylist->savePlaylist( $postData );
					$aData=$id;
					$logMsg="Edited playlist information.";
					$oPlaylist->mapSongPlaylist(array('playlistId'=>$id,'songKeyArray'=>$songIds,'manage'=>1,'ctype'=>$ctype));
				/* Write DB Activity Logs */
				$aLogParam = array(
					'moduleName' => 'playlist',
					'action' => $action,
					'moduleId' => 29,
					'editorId' => $this->user->user_id,
					'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
					'content_ids' => (int)$aData
				);
				TOOLS::writeActivityLog( $aLogParam );
				header('location:'.SITEPATH.'playlist?action=view&msg=Data saved successfully');
				exit;
			}
			$data['aContent']=$postData;
			$data['aError']=$aError;
		}
		$view = 'playlist_manage';
		/* Get Language Data */	
		$mLanguage=new language();
		$lParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY language_name ASC',  
					'start'   => 0,  
					'where'   => " AND status=1",
			   );
		$languageList=$mLanguage->getAllLanguages($lParams);
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'where' => ' AND playlist_id="'.$id.'"', 
				  ); 
		$aPlaylistData = $oPlaylist->getAllPlaylists( $params );
		$ctype=$aPlaylistData[0]->content_type;
		$songPlaylistMapData=$oPlaylist->getSongPlaylistMap(array('where'=> " AND playlist_id=".$id, "orderBy"=>" ORDER BY rank ASC","ctype"=>$ctype));

		if($ctype==15){
			$songHiddenArr=array();
			if($songPlaylistMapData){
				foreach($songPlaylistMapData as $song){
					$songHiddenArr[]=$song->video_id;
				}
			}
			$songHidden="";
			if($songHiddenArr){
				$songHidden=implode(",",$songHiddenArr);
			}
			$mSong=new video();
			$songHiddenIn="0";
			if($songHidden){
				$songHiddenIn=$songHidden;
			}
			$songNameArr=array();
			$songNameStr="";
			$bParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY FIELD (video_id,'.$songHidden.')',  
					'start'   => 0,  
					'where'   => " AND video_id IN (".$songHiddenIn.")",
			   );
			$songData=$mSong->getAllVideos($bParams);

			if($songData){
				foreach($songData as $aD){
					$songNameStr.=$aD->video_id.":".$aD->video_name."|";
					$songHiddenArr[]=$aD->video_id;
					$songNameArr[$aD->video_id]=$aD->video_name;
				}	
			}
		}elseif($ctype==17){
			$songHiddenArr=array();
			if($songPlaylistMapData){
				foreach($songPlaylistMapData as $song){
					$songHiddenArr[]=$song->image_id;
				}
			}
			$songHidden="";
			if($songHiddenArr){
				$songHidden=implode(",",$songHiddenArr);
			}
			$mSong=new image();
			$songHiddenIn="0";
			if($songHidden){
				$songHiddenIn=$songHidden;
			}
			$songNameArr=array();
			$songNameStr="";
			$bParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY FIELD (image_id,'.$songHidden.')',  
					'start'   => 0,  
					'where'   => " AND image_id IN (".$songHiddenIn.")",
			   );
			$songData=$mSong->getAllImages($bParams);

			if($songData){
				foreach($songData as $aD){
					$songNameStr.=$aD->image_id.":".$aD->image_name."|";
					$songHiddenArr[]=$aD->image_id;
					$songImageArr[$aD->image_id]=$aD->image_file;
					$songNameArr[$aD->image_id]=$aD->image_name;
				}	
			}
		}else{
			$songHiddenArr=array();
			if($songPlaylistMapData){
				foreach($songPlaylistMapData as $song){
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
					'orderby' => 'ORDER BY FIELD (song_id,'.$songHidden.')',  
					'start'   => 0,  
					'where'   => " AND song_id IN (".$songHiddenIn.")",
			   );
			$songData=$mSong->getAllSongs($bParams);
			if($songData){
				foreach($songData as $aD){
					$songNameStr.=$aD->song_id.":".$aD->song_name."|";
					$songHiddenArr[]=$aD->song_id;
					$songImageArr[$aD->song_id]="";
					$songNameArr[$aD->song_id]=$aD->song_name;
				}	
			}
		}	
		$data['languageList']=$languageList;
		$data['aContent']= array( 
					'playlistId'=>$id,
					'playlistName'=>$aPlaylistData[0]->playlist_name,
					'songNameArr'=>$songNameArr,
					'songId' => $songHidden,
					'songNameStr'=>$songNameStr,
					'songImageArr'=>$songImageArr,
					'image' => $aPlaylistData[0]->image,
					'languageIds' => $aPlaylistData[0]->language_id,
					'ctype' => $aPlaylistData[0]->content_type,
					'userId' => $aPlaylistData[0]->user_id,
					);
	}
}else{
	/*
	* To display playlist details start	
	*/
	if($do=='details'){
		$view = 'playlist_details';
		
		/* Get Language Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'where' => ' AND playlist_id="'.$id.'"', 
				  ); 
		$aPlaylistData = $oPlaylist->getAllPlaylists( $params );

		$oLanguage = new language();
		$lParams = array(
				'limit'	  => 1000,  
				'orderby' => 'ORDER BY language_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1 AND language_id=".(int)$aPlaylistData[0]->language_id,
		   );
		$languageList=$oLanguage->getAllLanguages($lParams);
		$ctype=(int)$aPlaylistData[0]->content_type;

		$songPlaylistMapData=$oPlaylist->getSongPlaylistMap(array('where'=> " AND playlist_id=".$id,"ctype"=>$ctype));
		if($ctype==15){
			$songHiddenArr=array();
			if($songPlaylistMapData){
				foreach($songPlaylistMapData as $song){
					$songHiddenArr[]=$song->video_id;
				}
			}
			$songHidden="";
			if($songHiddenArr){
				$songHidden=implode(",",$songHiddenArr);
			}
			$mSong=new video();
			$songHiddenIn="0";
			if($songHidden){
				$songHiddenIn=$songHidden;
			}
			$songNameArr=array();
			$songNameStr="";
			$bParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY FIELD (video_id,'.$songHidden.')',  
					'start'   => 0,  
					'where'   => " AND video_id IN (".$songHiddenIn.")",
			   );
			$songData=$mSong->getAllVideos($bParams);
			if($songData || sizeof($songData)>0 ){
				foreach($songData as $aD){
					$songNameStr.=$aD->video_id.":".$aD->video_name."|";
					$songHiddenArr[]=$aD->video_id;
					$songNameArr[$aD->video_id]=$aD->video_name;
				}	
			}
		}elseif($ctype==17){
			$songHiddenArr=array();
			if($songPlaylistMapData){
				foreach($songPlaylistMapData as $song){
					$songHiddenArr[]=$song->image_id;
				}
			}
			$songHidden="";
			if($songHiddenArr){
				$songHidden=implode(",",$songHiddenArr);
			}
			$mSong=new image();
			$songHiddenIn="0";
			if($songHidden){
				$songHiddenIn=$songHidden;
			}
			$songNameArr=array();
			$songNameStr="";
			$bParams = array(
					'limit'	  => 100000,  
					'orderby' => 'ORDER BY FIELD (image_id,'.$songHidden.')',  
					'start'   => 0,  
					'where'   => " AND image_id IN (".$songHiddenIn.")",
			   );
			$songData=$mSong->getAllImages($bParams);

			if($songData){
				foreach($songData as $aD){
					$songNameStr.=$aD->image_id.":".$aD->image_name."|";
					$songHiddenArr[]=$aD->image_id;
					$songImageArr[$aD->image_id]=$aD->image_file;
					$songNameArr[$aD->image_id]=$aD->image_name;
				}	
			}
		}else{
			$songHiddenArr=array();
			if($songPlaylistMapData){
				foreach($songPlaylistMapData as $song){
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
					'orderby' => 'ORDER BY FIELD (song_id,'.$songHidden.')',  
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
		}
		$data['aContent']= array(
					'playlistId'=>$id,
					'playlistName'=>$aPlaylistData[0]->playlist_name,
					'status'=>$aPlaylistData[0]->status,
					'languageName'=>$languageList[0]->language_name,
					'image' => $aPlaylistData[0]->image,
					'songNameArr'=>$songNameArr,
					'songId' => $songHidden,
					'songNameStr'=>$songNameStr,
					'songImageArr'=>$songImageArr,
					'userId' => $aPlaylistData[0]->user_id,
					);
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display playlist details start	
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
				$data = $oPlaylist->doMultiAction( $params );
				/* Write DB Activity Logs */
				#TOOLS::log('playlist', $contentAction, '4', (int)$this->user->user_id, "Playlist, Ids: '".implode("','", $_POST['select_ids'])."' " );
				$aLogParam = array(
					'moduleName' => 'playlist',
					'action' => $contentAction,
					'moduleId' => 29,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' playlist.',
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

			if($contentModel=='playlist' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oPlaylist->doAction( $params );
				/* Write DB Activity Logs */
				#TOOLS::log('playlist', $contentAction, '4', (int)$this->user->user_id, "Playlist, Id: ".$contentId."" );
				$aLogParam = array(
					'moduleName' => 'playlist',
					'action' => $contentAction,
					'moduleId' => 29,
					'editorId' => $this->user->user_id,
					'remark'	=>	ucfirst($contentAction).' playlist. (ID-'.$contentId.')',
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

//	print_r($oPlaylist);
	$lisData = getlist( $oPlaylist ,$this);
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
	
}

function getlist( $oPlaylist,$users=NULL ){
	global $oMysqli;
	/* Search Param start */
	
	$srcPlaylistId = cms::sanitizeVariable( $_GET['srcPlaylistId'] );
	$srcPlaylist = cms::sanitizeVariable( $_GET['srcPlaylist'] );
	#$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcSrtDate = cms::sanitizeVariable( $_GET['srcSrtDate'] ); 
	$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
	$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
	$srcLang = cms::sanitizeVariable( $_GET['srcLang'] );
	$srcCtype = cms::sanitizeVariable( $_GET['srcCtype'] );
		
	$where		 = '';
	if( $srcPlaylist != '' ){
		$where .= ' AND playlist_name like "'.$oMysqli->secure($srcPlaylist).'%"';
	}
	/*if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}*/
	if( $srcCtype != '' ){
		$where .= ' AND content_type ="'.$srcCtype.'" ';
	}
	if( $srcLang != '' ){
		$where .= ' AND language_id="'.$oMysqli->secure($srcLang).'"';
	}
	if( $srcPlaylistId != '' ){
		$where .= ' AND playlist_id="'.$oMysqli->secure($srcPlaylistId).'"';
	}
	if( $srcSrtDate != '' && $srcEndDate != ''  ){
		$where .= ' AND insert_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcEndDate).'"';
	}elseif($srcSrtDate != ''){
		$where .= ' AND insert_date >= "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcEndDate != ''){
		$where .= ' AND insert_date <= "'.$oMysqli->secure($srcEndDate).'"';
	}
	$mLanguage=new language();
	$lParams = array(
				'limit'	  => 100000,  
				'orderby' => 'ORDER BY language_name ASC',  
				'start'   => 0,  
				'where'   => " AND status=1",
		   );
	$languageList=$mLanguage->getAllLanguages($lParams);
	$data['aSearch']['languageList']=$languageList;
	$data['aSearch']['srcLang']=$srcLang;
	$data['aSearch']['srcPlaylist'] = $srcPlaylist;
	$data['aSearch']['srcCType'] 	= $srcCType;
	$data['aSearch']['srcPlaylistId'] 	= $srcPlaylistId;
	$data['aSearch']['srcSrtDate'] 	= $srcSrtDate;
	$data['aSearch']['srcEndDate'] 	= $srcEndDate;
	$data['aSearch']['srcCtype'] 	= $srcCtype;
	/* Search Param end */
	/* Show Playlist as List Start */
	#$where  .=" AND user_id=".TOOLS::getEditorId();
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => '',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oPlaylist->getAllPlaylists( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oPlaylist->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "playlist?action=view&srcPlaylist=$srcPlaylist&srcCType=$srcCType&srcIsrc=$srcIsrc&srcSrtDate=$srcSrtDate&srcEndDate=$srcEndDate&srcLang=$srcLang&autosuggesttag_hddn=$autosuggesttag_hddn&srcPlaylistId=$srcPlaylistId&submitBtn=Search&do=".$_GET['do']."&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */
	/* Show Playlist as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );