<?php 
$view = 'dashboard';
$oDashboard = new dashboard();
$oEditor = new editor();

$do		= cms::sanitizeVariable( $_GET['do'] );

if( $do == 'activity' || $do == 'activity-pop' ){
	global $aConfig;
	$cType  		= ((int)$_REQUEST['cType'] == 0 ? '0':(int)$_REQUEST['cType']);
	$id				= (int)$_REQUEST['id'];
	$srcUser		= cms::sanitizeVariable( $_GET['srcUser'] );
	$srcSction		= cms::sanitizeVariable( $_GET['srcSction'] );
	$srcActivity		= cms::sanitizeVariable( $_GET['srcActivity'] );
	$srcSrtDate = cms::sanitizeVariable( $_GET['srcSrtDate'] ); 
	$srcEndDate = cms::sanitizeVariable( $_GET['srcEndDate'] ); 
	
	/* Activity Page */
	$view = 'dashboard_activity';
	
	$isPlane = '0';
	if( $do == 'activity-pop' ){
		$view = 'dashboard_activity_pop';
		$isPlane = '1';
	}
	
	$where = '';
	if( $id > 0 ){ $where .= ' AND content_id='.$id; }
	if( $cType > 0 ){ $where .= ' AND module_id='.$cType; }
	if( $srcUser > 0 ){ $where .= ' AND editor_id='.$srcUser; }
	if( $srcSction > 0 ){ $where .= ' AND module_id='.$srcSction; }
	if( $srcActivity != "" ){ $where .= ' AND action="'.$srcActivity.'"'; }

	if( $srcSrtDate != '' && $srcEndDate != ''  ){
		$where .= ' AND activity_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcEndDate).'"';
	}elseif($srcSrtDate != ''){
		$where .= ' AND activity_date >= "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcEndDate != ''){
		$where .= ' AND activity_date <= "'.$oMysqli->secure($srcEndDate).'"';
	}
	$params=array(
				"limit" => 10000,
				"where" => " AND status=1".$where,
			);
	$data['aEditors'] = $oEditor->getAllEditors( $params );
	
	$data['aSections'] = $aConfig['module'];
	
	$data['aActivity'] = array("Add","Edit","Delete","View","Legal-approve","Qc-approve","Publish");

	/* Show Language as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => '',  
				'start'   => $start,  
				'where'   => $where,  
			  );
		
	$data['aContent'] = $oDashboard->getAllContents( $params );
	
	/* All Editor Array */
	$data['aEditors'] = $oEditor->getAllEditors();

	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oDashboard->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "dashboard?action=view&isPlane=".$isPlane."&do=".$do."&id=".$id."&cType=".$cType."srcUser=".$srcUser."srcSction=".$srcSction."srcActivity=".$srcActivity."&srcSrtDate=".$srcSrtDate."&srcEndDate=".$srcEndDate."&page={page}";

	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */

	$data['cType']			= $cType;
	$data['id']				= $id;
	
}else{
	/* Dashboard Page */
	$oSong = new song(); 
	$oAlbum = new album(); 
	$oVideo = new video(); 
	$oArtist = new artist();
	$oImage = new image();
	$oText = new text();
	$mCatalogue=new catalogue();
	
	$total_param = array( 'where'=>" AND status=1" );
	$true=1;
	$publish_param = array( 'where'=> " AND status=3" ); 
	$data['dashboard']['publish'] = array();
	if ($this->user->hasPrivilege("album_publish")){
		$data['dashboard']['publish']['albums']	= $oAlbum->getTotalCount( $publish_param );
		if($data['dashboard']['publish']['albums']){
			$true=2;
		}
	}
	if ($this->user->hasPrivilege("song_publish")){
		$data['dashboard']['publish']['songs']	= $oSong->getTotalCount( $publish_param );
		if($data['dashboard']['publish']['songs']){
			$true=2;
		}
	}
	if ($this->user->hasPrivilege("video_publish")){
		$data['dashboard']['publish']['videos']	= $oVideo->getTotalCount( $publish_param );
		if($data['dashboard']['publish']['videos']){
			$true=2;
		}
	}
	if ($this->user->hasPrivilege("image_publish")){
		$data['dashboard']['publish']['images']	= $oImage->getTotalCount( $publish_param );
		if($data['dashboard']['publish']['images']){
			$true=2;
		}
	}
	if ($this->user->hasPrivilege("text_publish")){
		$data['dashboard']['publish']['text']	= $oText->getTotalCount( $publish_param );
		if($data['dashboard']['publish']['text']){
			$true=2;
		}
	}
	if($true==1){
		$data['dashboard']['publish']=array();
		$legal_param = array( 'where'=> " AND status=2" ); 
		$data['dashboard']['legal'] = array();
		if ($this->user->hasPrivilege("album_legal")){
			$data['dashboard']['legal']['albums']	= $oAlbum->getTotalCount( $legal_param );
			if($data['dashboard']['legal']['albums']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("song_legal")){
			$data['dashboard']['legal']['songs']	= $oSong->getTotalCount( $legal_param );
			if($data['dashboard']['legal']['songs']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("video_legal")){
			$data['dashboard']['legal']['videos']	= $oVideo->getTotalCount( $legal_param );
			if($data['dashboard']['legal']['videos']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("image_legal")){
			$data['dashboard']['legal']['images']	= $oImage->getTotalCount( $legal_param );
			if($data['dashboard']['legal']['images']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("text_legal")){
			$data['dashboard']['legal']['text']	= $oText->getTotalCount( $legal_param );
			if($data['dashboard']['legal']['text']){
				$true=2;
			}
		}
	}
	if($true==1){
		$data['dashboard']['legal']=array();
		$qc_param = array( 'where'=> " AND status=0" ); 
		$data['dashboard']['qc'] = array();
		if ($this->user->hasPrivilege("album_qc")){
			$data['dashboard']['qc']['albums']	= $oAlbum->getTotalCount( $qc_param );
			if($data['dashboard']['qc']['albums']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("song_qc")){
			$data['dashboard']['qc']['songs']	= $oSong->getTotalCount( $qc_param );
			if($data['dashboard']['qc']['songs']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("video_qc")){
			$data['dashboard']['qc']['videos']	= $oVideo->getTotalCount( $qc_param );
			if($data['dashboard']['qc']['videos']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("image_qc")){
			$data['dashboard']['qc']['images']	= $oImage->getTotalCount( $qc_param );
			if($data['dashboard']['qc']['images']){
				$true=2;
			}
		}
		if ($this->user->hasPrivilege("text_qc")){
			$data['dashboard']['qc']['text']	= $oText->getTotalCount( $qc_param );
			if($data['dashboard']['qc']['text']){
				$true=2;
			}
		}
	}
	if($true==1){
		$data['dashboard']['qc']=array();
		$today_param = array( 'where'=>" AND status=1 AND DATE(insert_date)='".date('Y-m-d')."'" );	
		$data['dashboard']['today']['songs']	= $oSong->getTotalCount( $today_param ); 
		$data['dashboard']['today']['albums']	= $oAlbum->getTotalCount( $today_param );
		$data['dashboard']['today']['videos']	= $oVideo->getTotalCount( $today_param ); 
		$data['dashboard']['today']['artist']	= $oArtist->getTotalCount( $today_param ); 
		$data['dashboard']['today']['images']	= $oImage->getTotalCount( $today_param ); 
		$data['dashboard']['today']['text']		= $oText->getTotalCount( $today_param );
	}
	

		
	$data['dashboard']['total']['songs'] 	= $oSong->getTotalCount( $total_param );  
	$data['dashboard']['total']['albums']	= $oAlbum->getTotalCount( $total_param ); 
	$data['dashboard']['total']['videos']	= $oVideo->getTotalCount( $total_param ); 
	$data['dashboard']['total']['artist']	= $oArtist->getTotalCount( $total_param ); 
	$data['dashboard']['total']['images']	= $oImage->getTotalCount( $total_param ); 
	$data['dashboard']['total']['text']		= $oText->getTotalCount( $total_param ); 
## Album Release
	$album_param = array(
						'where'=>' AND title_release_date > NOW() ',
						'orderby'=>' ORDER BY title_release_date ASC',
						'limit'=>8
						);
	$data['dashboard']['upcoming']['albums'] = $oAlbum->getAllAlbums( $album_param ); 
## Album Expire (Before one week alert)

	$expire_album_arr = array();
	$album_expire_date_arr = array();
	$album_param_ex = array(
						'where'=>' AND `expiry_date` = DATE_ADD(CURDATE(), INTERVAL 1 WEEK)  ',
						'orderby'=>' ORDER BY insert_date DESC',
						'limit'=>10
						);
	$data['dashboard']['legal_expire'] = $oAlbum->legalExpireAlbums($album_param_ex); 
	
		if(!empty($data['dashboard']['legal_expire'])){
		
		for($i=0;$i<count($data['dashboard']['legal_expire']);$i++){	
			array_push($expire_album_arr,$data['dashboard']['legal_expire'][$i]->album_id);
			array_push($album_expire_date_arr,$data['dashboard']['legal_expire'][$i]->expiry_date);
		
		}
		
		$data['dashboard']['legal']['albums'] = $oAlbum->getAlbumById(array('ids'=>implode(',',$expire_album_arr)));
		$data['dashboard']['legal']['albums_expire'] = $album_expire_date_arr;
	}	
## Catalouge Expire (Before one week alert)

	$expire_catalouge_arr = array();
	$catalouge_param_ex = array(
						'where'=>' AND `expiry_date` = DATE_ADD(CURDATE(), INTERVAL 1 WEEK)  ',
						'orderby'=>' ORDER BY insert_date DESC',
						'limit'=>10
						);
	$data['dashboard']['legal_catalouge'] = $mCatalogue->legalExpireCatalogue($catalouge_param_ex); 					
	if(!empty($data['dashboard']['legal_catalouge'])){					
		$data['dashboard']['legal_catalouge']['catalouge'] = $mCatalogue->legalExpireCatalogue($catalouge_param_ex); 
	}
	
}
/* render view */
$oCms->view( $view, $data );