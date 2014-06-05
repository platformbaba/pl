<?php     //playlist 
    
set_time_limit(0);
ini_set('memory_limit','5120M');
$view = 'radio_addprogram_list';
$pRadio = new radioprogram();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
$ChannelId = (int)$_GET['id'];
$eid	   =(int) $_GET['eid'];
global $aConfig;

	$paramsPro=array(
		"limit" => "1000",
	);
	
	$data['pData']=$pRadio->getAllRadioProgram($paramsPro);
	
if( $action == 'add' || $action == 'edit'){


	if( $do == 'addto'){
		$view = 'radio_addprogram_addto';
		$params=array(
					"limit" => "1000",
					"where" => " AND channel_id=".$ChannelId,
				);
		
		$data['aContent']=$pRadio->getAllRadioProgram($params);
		$oCms->view( $view, $data );
		exit;
	}
	if( $do == 'draft'){
		//$view = 'radio_addprogram_addto';
		$pRadio->deletePrograomFromChannel(array('eid'=>$eid));
			
		/* Write DB Activity Logs */
		$aLogParam = array(
			'moduleName' => 'RadioProram',
			'action' => 'draft',
			'moduleId' => 40,
			'editorId' => $this->user->user_id,
			'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
			'content_ids' => (int)$aData
		);
		TOOLS::writeActivityLog( $aLogParam );
		header('location:'.SITEPATH.'radio_addprogram?action=add&id='.$_GET['id'].'&isPlane=1&do=addto&chName='.$_GET['chName'].'&msg=Data Deleted successfully');
		exit;
		
	
	}	
	/* Form */
	
	$view = 'radio_addprogram_form';
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){	
	
		$radioProgram	=	cms::sanitizeVariable($_POST['radioProgram']);
		$duration	=	cms::sanitizeVariable($_POST['duration']);
		
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
		
		if($radioProgram==""){
			$aError[]="Please Select Radio Program.";
		}
		$postData=array(
					'program_id'=>$eid,
					'channelId'=>$ChannelId,
					'radioProgram'=>$radioProgram,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'duration'=>$duration,
					'startTime'=>$startTimeH.":".$startTimeM.":".$startTimeS,
					'endTime'=>$endTimeH.":".$endTimeM.":".$endTimeS,
					);
					
		#print_r($postData);	exit;
				

		if(empty($aError)){ 
			$aData = $pRadio->addRadioPrograms( $postData );
			$logMsg="Channel Added.";
			if($eid){
				$aData=$eid;
				$logMsg="Edited Channel information.";
			}
			/* Write DB Activity Logs */
			$aLogParam = array(
				'moduleName' => 'RadioProram',
				'action' => $action,
				'moduleId' => 40,
				'editorId' => $this->user->user_id,
				'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
				'content_ids' => (int)$aData
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'radio_addprogram?action=add&id='.$_GET['id'].'&isPlane=1&do=addto&chName='.$_GET['chName'].'&msg=Data saved successfully');
			exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
	

		if($eid>0){	
		
		$getPData=$pRadio->getChannelProgramById(array('ids'=> $eid));
		
		$startTime = explode(":",$getPData[0]->start_time);
		$endTime = explode(":",$getPData[0]->end_time);
		
		$startTimeH = $startTime[0];
		$startTimeM = $startTime[1];
		$startTimeS = $startTime[2];

		$endTimeH = $endTime[0];
		$endTimeM = $endTime[1];
		$endTimeS = $endTime[2];

		$data['aContent']= array( 					
					'channel_id'=>$getPData[0]->channel_id,
					'program_id'=>$getPData[0]->program_id,
					'startDate'=>$getPData[0]->start_date,
					'endDate'=>$getPData[0]->end_date,
					'startTimeH'=>$startTimeH,
					'startTimeM'=>$startTimeM,
					'startTimeS'=>$startTimeS,
					'endTimeH'=>$endTimeH,
					'endTimeM'=>$endTimeM,
					'endTimeS'=>$endTimeS,
					'duration'=>$getPData[0]->duration,
					);
		
		}
	
	
	
}

/* render view */
$oCms->view( $view, $data );