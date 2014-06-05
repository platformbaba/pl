<?php     //song edits (cuts)      
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$view = 'song-edits_form';
$oSong = new song();
$oDeployment=new deployment();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$id = (int)$_GET['id']; 
if( $action == 'add' || $action == 'edit' ){ #print_r($_FILES);
		if(sizeof($_POST)>0 && sizeof($_FILES)>0){
			$i=0;
			$isrc=cms::sanitizeVariable($_POST['isrc']);
			$song_id=cms::sanitizeVariable($_POST['song_id']);
			foreach($_FILES as $file){ #print_r($file['name']);
				foreach($file['name'] as $configId=>$fName){
					if($fName){
						$limit	= 1;
						$start	= 0;
						$params = array(
									'limit'	  => $limit,  
									'start'   => $start,  
									'where'	  => " AND song_edit_id=".$configId,
								  );
						$dataConfig = $oSong->getAllSongsConfig($params );
						$format=$dataConfig[0]->format;
						$audio_bitrate=$dataConfig[0]->audio_bitrate;
						$sample_rate=$dataConfig[0]->sample_rate;
						$sample_size=$dataConfig[0]->sample_size;
						$audio_channel=$dataConfig[0]->audio_channel;
						$duration_limit=$dataConfig[0]->duration_limit;
						$file_size_limit=$dataConfig[0]->file_size_limit;
						$folderName=$sample_size."b".$audio_bitrate."k".$sample_rate."hz".substr(strtolower($audio_channel),0,1).$duration_limit."s";
						$folderPath="/".$folderName."/".substr($isrc,-2)."/";
						$fileName=$configId."-".$isrc.".".strtolower($format);
						$sTempAudioPath	= strtolower($format).$folderPath.$fileName;
						$uFileName=$file['name'][$configId];
						$tmpName=$file['tmp_name'][$configId];
						$fileSize=$file['size'][$configId];
						$fileSize=round($fileSize/1024);
						$params = NULL;
						$params = array( "uFile" => $uFileName,
									"file" => $fileName,
									"oFile"	  => $sTempAudioPath,
									"tmpFile" => $tmpName,
									"ext" => array(strtolower($format)),
									"size" =>$file_size_limit,
									"oSize" => $fileSize,
								 );
						$return=tools::saveAudioEdits($params);
						if(empty($return['error'])){
							$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$song_id,'configId'=>$configId,'path'=>$sTempAudioPath,'version'=>1));
							TOOLS::log('Song edits added to '.$_GET['song_name'], $action, '25', (int)$this->user->user_id, "Song Id: ".$song_id."" );
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
		$lisData = $oSong->getSongEdits($id );
		if(sizeof($lisData)>0 && $lisData){
			foreach($lisData as $lisData){
				$data['aContent'][$lisData->config_id] 	 = $lisData;
			}
		}	
		$data['aEditConfig']	 = $oSong->getSongEditsConfig();
}
/* render view */
$oCms->view( $view, $data );