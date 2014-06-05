<?php     //video edits (cuts)       
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
$view = 'video-edits_form';
$oVideo = new video();
$oDeployment=new deployment();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$id = (int)$_GET['id']; 
if( $action == 'add' || $action == 'edit' ){ #print_r($_FILES);
		if(sizeof($_POST)>0 && sizeof($_FILES)>0){
			$i=0;
			$video_id=cms::sanitizeVariable($_POST['video_id']);
			$video_name=cms::sanitizeVariable($_POST['video_name']);
			foreach($_FILES as $file){
				foreach($file['name'] as $configId=>$fName){
					if($fName){
						$limit	= 1;
						$start	= 0;
						$params = array(
									'limit'	  => $limit,  
									'start'   => $start,  
									'where'	  => " AND video_edit_id=".$configId,
								  );
						$dataConfig = $oVideo->getAllVideosConfig($params );
						$format=$dataConfig[0]->format;
						$dimension=$dataConfig[0]->dimension;
						$file_size_limit=$dataConfig[0]->file_size;

						$uFileName=$file['name'][$configId];
						$tmpName=$file['tmp_name'][$configId];
						$fileSize=$file['size'][$configId];
						$fileSize=round($fileSize/1024);
						$totalFileName=tools::cleaningName($video_name);
						$folderPath="/".$dimension."/".tools::getImagePathChar(array('title'=>$video_name,'length'=>2))."/";
						$fileName=$totalFileName."-".$video_id."-".$configId."-".$dimension.".".$format;
						$sTempAudioPath	= $format.$folderPath.$fileName;
						
							$params = NULL;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array($format),
										"size" =>$file_size_limit,
										"oSize" => $fileSize,
										);
							$return=tools::saveVideoEdits($params);
							if(empty($return['error'])){
								$dData=$oDeployment->video_mstr_config_rel(array('videoId'=>$video_id,'configId'=>$configId,'path'=>$sTempAudioPath,'version'=>1));
								TOOLS::log('Video edits added to '.$_GET['video_name'], $action, '28', (int)$this->user->user_id, "Video Id: ".$video_id."" );
								$data['aSuccess'][]="Action completed susseccfully!";
							}else{
								$data['aError']=$return;
							}
					}
					$i++;
				}
			}
		}
		$data['aContent']=NULL;
		$lisData = $oVideo->getVideoEdits($id );
		if(sizeof($lisData)>0 && $lisData){
			foreach($lisData as $lisData){
				$data['aContent'][$lisData->config_id] 	 = $lisData;
			}
		}	
		$data['aEditConfig']	 = $oVideo->getVideoEditsConfig();
}
/* render view */
$oCms->view( $view, $data );