<?php
$view = 'language_list';
$oLanguage = new language();

$action = cms::sanitizeVariable( $_GET['action'] );
if( $action == 'add' || $action == 'edit' ){
	/* Form */
	$view = 'language_form';
	$id = (int)$_GET['id']; 

	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
		
		$languageName	=	cms::sanitizeVariable($_POST['languageName']);
		
		if($languageName==""){
			$aError[]="Enter Language";
		}
		$isLanguageExist = $oLanguage->checkLanguageExist($languageName);
		if( $isLanguageExist>0 ){
			$aError[]="Language already Exist!";
		}
		
		$params = array(
					'languageName' => $languageName, 
				 );
		if(empty($aError)){
			
			$id = $oLanguage->saveLanguage( $params );

			/* Write DB Activity Logs */
			TOOLS::log('language', $action, '2', (int)$this->user->user_id, "Languages, Id: ".$id."" );
			
			$data['aSuccess'] = 'Data saved successfully.';
			header('location:'.SITEPATH.'language?msg=Data saved successfully');			
		}else{
			$data['aError'] = $aError;
		}
		$data['aContent'] = $params;
	}else if($action == 'edit'){
		/* Get Language Data */	
		$params = array(
					'start' => 0, 
					'limit' => 1, 
					'status' => $status, 
					'where' => " AND language_id= '".$id."'"
				  ); 
		$aLanguageData = $oLanguage->getAllLanguages( $params );
		$data['aContent']['languageName'] = $aLanguageData[0]->language_name;
		$data['aContent']['status']		  = $aLanguageData[0]->status;
	}
	$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );

}else{

	
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
				$data = $oLanguage->doMultiAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('language', $contentAction, '2', (int)$this->user->user_id, "Languages, Ids: '".implode("','", $_POST['select_ids'])."' " );

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

			if($contentModel=='language' && $contentId > 0 && $contentActionValue !=''){
				$params = array(
							'contentId' => $contentId, 
							'contentAction' => $contentAction, 
							'contentActionValue' => $contentActionValue, 
						  );
				$data = $oLanguage->doAction( $params );
				/* Write DB Activity Logs */
				TOOLS::log('language', $contentAction, '2', (int)$this->user->user_id, "Languages, Id: ".$contentId."" );
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
	
	
	$lisData = getlist( $oLanguage );
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount']	 = $lisData['iTotalCount'];
	$data['aSearch']	 = $lisData['aSearch'];
}

function getlist( $oLanguage ){
	global $oMysqli;
	/* Search Param start */
	$srcLanguage = cms::sanitizeVariable( $_GET['srcLanguage'] );
	$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );
	$where		 = '';
	if( $srcLanguage != '' ){
		$where .= ' AND language_name like "'.$oMysqli->secure($srcLanguage).'%"';
	}
	if( $srcCType != '' ){
		$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
		$where .= ' AND status ="'.$srcCtypeVal.'" ';
	}
	$data['aSearch']['srcLanguage'] = $srcLanguage;
	$data['aSearch']['srcCType'] 	= $srcCType;
	/* Search Param end */
	$orderBy = TOOLS::getSortbyQueryString( array( 'default_field'=>'language_name', 'default_sort'=>'ASC', 'field'=>'language_name' ) );
	
	/* Show Language as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => $orderBy,  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oLanguage->getAllLanguages( $params );
	
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oLanguage->getTotalCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "language?action=view&srcLanguage=$srcLanguage&srcCType=$srcCType&page={page}&sort=".$_GET['sort'];
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */

	/* Show Language as List End */
	
	return $data;
}

/* render view */
$oCms->view( $view, $data );