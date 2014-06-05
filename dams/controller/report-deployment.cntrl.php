<?php    //REPORT DEPLOYMENT  
ob_start();
#error_reporting(E_ALL);
#ini_set('display_errors', '1');
$view = 'report-deployment_list';   
$action = ($_GET['action'])?cms::sanitizeVariable( $_GET['action'] ):"view";
$do		= cms::sanitizeVariable( $_GET['do'] );
if($action == 'view'){
	$lisData = getlist( $oSong );
	$data['aContent']	 = $lisData['aContent'];
	$data['aEditors']	 = $lisData['aEditors'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['aSearch']	 = $lisData['aSearch'];
}
function getlist( $oSong ){  
	global $oMysqli;
	global $aConfig;
	$oDeployment=new deployment();
	$oEditor = new editor();
	/* Search Param start */
	$srcDeployment = cms::sanitizeVariable( $_GET['srcDeployment'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$srcIsrc	 = cms::sanitizeVariable( $_GET['srcIsrc'] );
	$srcDepType	 = cms::sanitizeVariable( $_GET['srcDepType'] );
	$srcSong	 = cms::sanitizeVariable( $_GET['srcSong'] );
	$srcSrtDate  = cms::sanitizeVariable( $_GET['srcSrtDate'] );
	$srcEndDate  = cms::sanitizeVariable( $_GET['srcEndDate'] );
	$srcUser  = cms::sanitizeVariable( $_GET['srcUser'] );
		
	if( $srcDeployment != '' ){
		$where .= ' AND deployment_name like "'.$oMysqli->secure($srcDeployment).'%"';
	}
	if( $srcDepType != "" ){
		$where .= ' AND dm.service_provider ="'.$oMysqli->secure($srcDepType).'"';
	}
	if( $srcIsrc != '' ){
		$where .= ' AND dd.isrc ="'.$oMysqli->secure($srcIsrc).'"';
	}
	if( $srcSong != '' ){
		$where .= ' AND dd.title like "'.$oMysqli->secure($srcSong).'%"';
	}
	if( $srcSrtDate != '' && $srcEndDate != ''  ){
		$where .= ' AND dm.insert_date BETWEEN "'.$oMysqli->secure($srcSrtDate).'" AND "'.$oMysqli->secure($srcEndDate).'"';
	}elseif($srcSrtDate != ''){
		$where .= ' AND dm.insert_date >= "'.$oMysqli->secure($srcSrtDate).'"';
	}elseif($srcEndDate != ''){
		$where .= ' AND dm.insert_date <= "'.$oMysqli->secure($srcEndDate).'"';
	}
	if( $srcUser > 0 ){
		$where .= ' AND dm.editor_id ="'.$oMysqli->secure($srcUser).'"';
	}
	$where .= ' AND dd.content_type ="4"';//for songs
	
	$data['aSearch']['srcDeployment'] = $srcDeployment;
	$data['aSearch']['srcDepType'] 	= $srcDepType;
	$data['aSearch']['srcIsrc'] 	= $srcIsrc;
	$data['aSearch']['srcSong'] 	= $srcSong;
	$data['aSearch']['srcSrtDate'] 	= $srcSrtDate;
	$data['aSearch']['srcEndDate'] 	= $srcEndDate;
	/* Search Param end */
	$eparams=array(
			"limit" => 10000,
			"where" => " AND status=1",
		);
	$data['aEditors'] = $oEditor->getAllEditors( $eparams );

	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => '  ORDER BY dd.id desc',  
				'start'   => $start,  
				'where'	  => $where,
			  );
	$data['aContent'] = $oDeployment->getDeploymentsReport( $params );
	#echo $oDeployment;
	/* Show Song as List Start */
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oDeployment->getTotalDRCount( array('orderby' => '  ORDER BY dd.id desc',  'where'	  => $where,) );#echo $oDeployment;
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = SITEPATH."report-deployment?action=view&srcDepType=$srcDepType&srcDeployment=$srcDeployment&srcCType=$srcCType&srcSong=$srcSong&srcIsrc=$srcIsrc&srcEndDate=$srcEndDate&srcSrtDate=$srcSrtDate&srcUser=$srcUser&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}
/* render view */
$oCms->view( $view, $data );