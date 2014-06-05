<?php     //playlist 
    
set_time_limit(0);
ini_set('memory_limit','5120M');
$pRadio = new radioprogram();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
$ProgramlId = (int)$_GET['id'];
$eid	   =(int) $_GET['eid'];
global $aConfig;

	$paramsPro=array(
		"limit" => "1000",
	);
	

if( $action == 'add' || $action == 'edit'){


	if( $do == 'addto'){
		$view = 'radio_addprogramsong_addto';
		$params=array(
					"limit" => "1000",
					"where" => " AND program_id=".$ProgramlId,
				);
		
		$data['aContent']=$pRadio->getAllProgramSongs($params);
		$oCms->view( $view, $data );
		exit;
	}
	if( $do == 'draft'){
		//$view = 'radio_addprogramsong_addto';
		$pRadio->deleteSongFromProgram(array('eid'=>$eid));
			
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
		header('location:'.SITEPATH.'radio_addprogramsong?action=add&id='.$_GET['id'].'&isPlane=1&do=addto&pName='.$_GET['pName'].'&msg=Data Deleted successfully');
		exit;
		
	
	}	
	/* Form */
	
	$view = 'radio_addprogramsong_form';
	/* Add/Edit */
	if(isset($_POST) && $_POST['submitBtn'] == 'Submit'){
	
	
		$programId	=	cms::sanitizeVariable($ProgramlId);
		$isrc		=	cms::sanitizeVariable($_POST['isrc']);		
		$file = cms::sanitizeVariable($_POST['file']);
		$type = cms::sanitizeVariable($_POST['sType']);
		
		if($programId==""){
			$aError[]="Please insert isrc.";
		}
		$postData=array(
					'id'=>$eid,
					'programId'=>$programId,
					'isrc'=>$isrc,
					'file'=>$file,
					'type'=>$type,
					
					);
					
		#print_r($postData);	exit;
				

		if(empty($aError)){ 
			$aData = $pRadio->addProgramSong( $postData );
			$logMsg="Songs Added.";
			if($eid){
				$aData=$eid;
				$logMsg="Edited Song information.";
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
			header('location:'.SITEPATH.'radio_addprogramsong?action=add&id='.$_GET['id'].'&isPlane=1&do=addto&pName='.$_GET['pName'].'&msg=Data saved successfully');
			exit;
		}
		$data['aContent']=$postData;
		$data['aError']=$aError;
	}
	

		if($eid>0){	
		
		$getPData=$pRadio->getProgramSongById(array('ids'=> $eid));
		

		$data['aContent']= array( 					
					'id'=>$getPData[0]->id,
					'program_id'=>$getPData[0]->program_id,
					'isrc'=>$getPData[0]->isrc,
					'sType'=>$getPData[0]->type,
					'file'=>$getPData[0]->file,
					'insertDate'=>$getPData[0]->insert_date,
					
					);
		
		}
	
	
	
}

/* render view */
$oCms->view( $view, $data );