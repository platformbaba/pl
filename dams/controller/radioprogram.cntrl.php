<?php //radioprogram 
 
$action = cms::sanitizeVariable( $_GET['action'] );
$pRadio=new radioprogram();
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$action = ($action==''?'view':$action);
$id=(int)$_GET['id'];
$do = cms::sanitizeVariable( $_GET['do'] );

	$paramsCh=array(
		"limit" => "1000",
	);
	
	$channelData=$pRadio->getAllChannels($paramsCh);
	
//print_r($channelData);

if( $action == 'add' || $action == 'edit'){
		$aError   = array();
		$aSuccess = array();
		$view     = 'radioprogram_form';
		
		if(!empty($_POST) && isset($_POST)){
	
		$radioProgram = cms::sanitizeVariable( $_POST['radioProgram'] );
		$channelId = cms::sanitizeVariable( $_POST['channelId'] );			
		$duration = (int)cms::sanitizeVariable( $_POST['duration'] );
			
		$startDate = cms::sanitizeVariable($_POST['startDate']);
		$endDate = cms::sanitizeVariable($_POST['endDate']);
		
		$startTimeH = cms::sanitizeVariable($_POST['startTimeH']);
		$startTimeM = cms::sanitizeVariable($_POST['startTimeM']);
		$startTimeS = cms::sanitizeVariable($_POST['startTimeS']);
		
		$endTimeH = cms::sanitizeVariable($_POST['endTimeH']);
		$endTimeM = cms::sanitizeVariable($_POST['endTimeM']);
		$endTimeS = cms::sanitizeVariable($_POST['endTimeS']);
		
		$startTimeH = ($startTimeH!='') ? $startTimeH : "00";
		$startTimeM = ($startTimeM!='') ? $startTimeM : "00";
		$startTimeS = ($startTimeS!='') ? $startTimeS : "00";
		
		$endTimeH = ($endTimeH!='') ? $endTimeH : "00";
		$endTimeM = ($endTimeM!='') ? $endTimeM : "00";
		$endTimeS = ($endTimeS!='') ? $endTimeS : "00";
			

		$isProgramExist=$pRadio->checkRadioProgramExist($radioProgram);
		if((int)$isProgramExist[0]->cnt>0){
			$aError[]="Radio Program name already exist!";
		}

		if($radioProgram==''){
			$aError[]="Please Insert Radio Program.";
		}

			$postData=array(
				'program_id'=>$id,
				'radioProgram'=>$radioProgram,
				'channelId'=>$channelId,
				'duration'=>$duration,
				'startDate'=>$startDate,
				'endDate'=>$endDate,
				'startTime'=>$startTimeH.":".$startTimeM.":".$startTimeS,
				'endTime'=>$endTimeH.":".$endTimeM.":".$endTimeS,

			);
			$data['aSuccess']=$aSuccess;			
			$data['aError']=$aError;			
			$data['aContent']=$postData;
			

			#print_r($postData);exit;
			if(empty($aError)){
				$mData=$pRadio->addRadioPrograms($postData);
				$logMsg="Created RadioProgram.";
				if($id){
					$mData=$id;
					$logMsg="Edited RadioProgram information.";
				}
				
				$aSuccess[] = 'data saved successfully.';
				/* Write DB Activity Logs */
				$aLogParam = array(
					'moduleName' => 'RadioProgram',
					'action' => $action,
					'moduleId' => 40,
					'editorId' => $this->user->user_id,
					'remark'	=> $logMsg." (ID-".$mData.")",
					'content_ids' => $mData
				);
				TOOLS::writeActivityLog( $aLogParam );
				header("location:".SITEPATH."radioprogram?action=view&msg=Action completed successfully.");exit;
			}
			
			

		}	$data['chData'] = $channelData;
	
		if($id){

		$getPData=$pRadio->getRadioProgramById(array('ids'=>$id));
		$startTime = explode(":",$getPData[0]->start_time);
		$endTime = explode(":",$getPData[0]->end_time);
		
		$startTimeH = $startTime[0];
		$startTimeM = $startTime[1];
		$startTimeS = $startTime[2];

		$endTimeH = $endTime[0];
		$endTimeM = $endTime[1];
		$endTimeS = $endTime[2];

		$data['chData'] = $channelData;
		$data['aContent']= array( 						
					'program_id'=>$getPData[0]->program_id,
					'channel_id'=>$getPData[0]->channel_id,
					'radioProgram'=>$getPData[0]->program_name,
					'duration'=>$getPData[0]->duration,
					'startDate'=>$getPData[0]->start_date,
					'endDate'=>$getPData[0]->end_date,
					'startTimeH'=>$startTimeH,
					'startTimeM'=>$startTimeM,
					'startTimeS'=>$startTimeS,
					'endTimeH'=>$endTimeH,
					'endTimeM'=>$endTimeM,
					'endTimeS'=>$endTimeS,
					);
		
	}


}	
		
if($action == 'view'){
	/* To display radio program details start	
	*/
	if($do=='details'){
		$view = 'radioprogram_details';
		
		$aData=$pRadio->getRadioProgramById(array('ids'=>$id));
				$edtData=array(
					'programId'=>$aData[0]->program_id,
					'channelId'=>$aData[0]->channel_id,
					'radioProgram' => $aData[0]->program_name,
					'startDate' => $aData[0]->start_date,
					'endDate' => $aData[0]->end_date,
					'starTime' => $aData[0]->start_time,
					'endTime' => $aData[0]->end_time,					
					'duration' => $aData[0]->duration,
					'insertDate' => $aData[0]->insert_date,
				);
			
		$data['aContent']=$edtData;
		$data['chData'] = $channelData;
		/* render view */
		$oCms->view( $view, $data );
		exit;
	}
	/*
	* To display radioprogram details start	
	*/
		$view = 'radioprogram_list';
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
					$data = $pRadio->doMultiAction( $params );
					/* Write DB Activity Logs */
	
					$aLogParam = array(
						'moduleName' => 'RadioProgram',
						'action' => $contentAction,
						'moduleId' => 40,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." Radio Program.",
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

				if($contentModel=='radioprogram' && $contentId > 0 && $contentActionValue !=''){
					$params = array(
								'contentId' => $contentId, 
								'contentAction' => $contentAction, 
								'contentActionValue' => $contentActionValue, 
							  );
	  
					$data = $pRadio->doAction($params );
					/* Write DB Activity Logs */
					$aLogParam = array(
						'moduleName' => 'Radio Program',
						'action' => $contentAction,
						'moduleId' => 40,
						'editorId' => $this->user->user_id,
						'remark'	=> ucfirst($contentAction)." Radioprogram. (ID-".$contentId.")",
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
		/* Search Param start */
		$radioProgram = cms::sanitizeVariable( $_GET['radioProgram'] );
		$where		 = '';
		if( $radioProgram != '' ){
			$where .= ' AND program_name LIKE "'.$oMysqli->secure($radioProgram).'%"';
		}
		$data['aSearch']['radioProgram'] = $radioProgram;
		/* Search Param end */
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => 'ORDER BY program_id DESC',  
					'start'   => $start,  
				  	'where'   => $where,
				  );
	
		$data['aContent'] = $pRadio->getAllRadioProgram($params);
		$data['chData'] = $channelData;

		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $pRadio->getTotalCount($params);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "radioprogram?action=view&page={page}&srcRadioProgram=$srcRadioProgram&submitBtn=Search";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		$data['iTotalCount'] = $oPage->total;
		/* Pagination End */
		
		

}
/* render view */
$oCms->view( $view, $data );