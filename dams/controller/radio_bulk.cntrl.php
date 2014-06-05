<?php     //playlist 
    
#error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');

$view = 'radio_addprogram_list';
$pRadio = new radioprogram();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
$ChannelId = (int)$_GET['id'];
$eid	   =(int) $_GET['eid'];

$programId_popup = (int)$_GET['programId']; //This bulk upload for Program page popup.
$pName = cms::sanitizeVariable($_GET['pName']); //This bulk upload for Program page popup.

global $aConfig;

if( $action == 'add'){	
	
	$view = 'radio_bulk_form';
	
	/* Add/Edit */
	if(!empty($_POST)){	

		$fileData = $_FILES['csv'];
		$pathInfo = pathinfo($fileData['name']);

	
		if($do=='programpop'){
			$programId = $programId_popup;
			$radioProgram = $pName;
		}else{
			$programId = $pRadio->nextChannelProgramId();//This bulk upload from Channel side.
			$radioProgram = $pathInfo['filename']."_".date("YmdHis");
		}
	
		
		$newName=$pathInfo['filename']."_".date("YmdHis").".".$pathInfo['extension'];
		$batchId=date("YmdHis"); 
		$params = array( "uFile" => $fileData['name'], 
					"file" => $newName,
					"oFile"	  => MEDIA_SEVERPATH_TEMP."bulk/".$newName,
					"tmpFile" => $fileData['tmp_name'],
					"ext" => array("csv"),
					"size" =>"",
					"oSize" => "",
					);
		$return=tools::uploadFiles($params);
		$aError[]=$return['error'];							
		if(empty($aError[0])){
			$file = fopen(MEDIA_SEVERPATH_TEMP."bulk/".$newName,"r");
			$csvData=array();
			$i=0;
			$rank = 0;
			
			while($csv_line = fgetcsv($file)){
				$i++;
				$rank++;
				
				if($i==4){
				
					$ProDate=cms::sanitizeVariable(date("Y-m-d",strtotime($csv_line[0])));
					$ProTime=cms::sanitizeVariable(date("H:i:s",strtotime($csv_line[0])));
				}
				if($i==1 || $i==2 || $i==3 || $i==4 || $i==5 ||$i==6 ){
					$rank = 0;
					continue;
				}
				
				$song_id=cms::sanitizeVariable($csv_line[0]);
				$SONG=cms::sanitizeVariable($csv_line[1]);				
				$isrc=cms::sanitizeVariable($csv_line[2]);
				$date=cms::sanitizeVariable($csv_line[10]);
			$params=NULL;	
			$params=array(
					'id'=>$eid,
					'programId'=>$programId,
					'songId'=>$song_id,
					'songRank'=>$rank,
					'songTag'=>$SONG,
					'isrc'=>$isrc,
			);
			//	print_r($params);exit;
				$aData = $pRadio->addProgramSongBulk( $params );	
				
			
		}	
			fclose($file);
			$chData=NULL;
			$chData=array(
					'channelId'=>$ChannelId,
					'radioProgram'=>$radioProgram,
					'duration'=>'500',
					'startDate'=>$ProDate,
					'endDate'=>$ProDate,
					'startTime'=>'00:00:00',
					'endTime'=>'23:59:59',
					);	
		//	print_r($chData);exit;
		if($do!='programpop') // this check for program pop bulk.						
			$cData = $pRadio->addRadioPrograms( $chData );

				
			/* Write DB Activity Logs */
			$aLogParam = array(
				'moduleName' => 'Radio Program bulk',
				'action' => 'add',
				'moduleId' => 40,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Uploaded radio program in bulk (Batch ID-'.$batchId.')',
				'content_ids' => $batchId
			);
		//	TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'radio_addprogram?action=add&id='.$_GET['id'].'&isPlane=1&do=addto&chName='.$_GET['chName'].'&msg=Data saved successfully');
			exit;
		}else{
			$aError=$aError;
			$data['aError']=$aError;

		}
		
	}
	
}
/* render view */
$oCms->view( $view, $data );