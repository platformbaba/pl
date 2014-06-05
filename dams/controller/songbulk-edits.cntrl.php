<?php     //song edits (cuts)       
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$view = 'songbulk-edits_form';
$oSong = new song();
$oDeployment=new deployment();
$action = cms::sanitizeVariable( $_GET['action'] );
global $aConfig;
if( $action == 'add' || $action == 'edit' ){ #print_r($_FILES);
		if(sizeof($_POST)>0){
			$i=0;
			$isrcs=cms::sanitizeVariable($_POST['isrcs']);
			if($isrcs==""){
				$aError[]="Please enter song isrc!";
			}
			if($isrcs){
			$isrcsArr=explode(",",$isrcs);
			$songidArr=array();	
				if($isrcsArr){
					foreach($isrcsArr as $isrc){
						$isIsrcExit= $oSong->getAllSongs( array("where"=>"AND isrc='".$isrc."'") );
						if($isIsrcExit[0]->song_id>0){
							$songidArr[$isrc]=$isIsrcExit[0]->song_id;
						}else{
							$aError[]="Enter valid Song ISRC for ".$isrc."!";
						}
					}
				}
			}
			if(empty($aError)){
				$file_list = listDirectory(MEDIA_SERVERPATH_TEMPFTP."song-edits/");
				if($file_list){
					foreach($file_list as $dirPath){
						if($isrcsArr){
							foreach($isrcsArr as $isrc){
								$dirParhArr=explode("_",$dirPath);
								$sizeof=sizeof($dirParhArr);
								$configIdStr=$dirParhArr[$sizeof-1];
								$configId=str_replace("/","",$configIdStr);
								$params = array(
											'limit'	  => 1,  
											'start'   => 0,  
											'where'	  => " AND song_edit_id=".$configId,
										  );
								$dataConfig = $oSong->getAllSongsConfig($params );
								$format=strtolower($dataConfig[0]->format);
								if(file_exists($dirPath.$isrc.".".$format)){
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
									$destinationPath=MEDIA_SERVERPATH_SONGEDITS.$sTempAudioPath;
									$sourcePath=$dirPath.$isrc.".".$format;
									tools::createDir($destinationPath);
									$song_id=$songidArr[$isrc];
									if(copy($sourcePath,$destinationPath)){
										$dData=$oDeployment->song_mstr_config_rel(array('songId'=>$song_id,'configId'=>$configId,'path'=>$sTempAudioPath,'version'=>1));
										unlink($sourcePath);
									}
								}	
							}
						}
					}
				}
			}
			if(empty($aError)){
				$aLogParam = array(
					'moduleName' => 'song bulk edits',
					'action' => 'add',
					'moduleId' => 36,
					'editorId' => $this->user->user_id,
					'remark'	=>	'Song edits uploaded for ISRCs - '.$isrcs,
					'content_ids' => $song_id
				);
				TOOLS::writeActivityLog( $aLogParam );
				header('location:'.SITEPATH.'songbulk-edits?action=add&msg=Action completed successfully!.');
			}
		}
		$data['aContent']=$isrcs;
		$data['aError']=$aError;
}
/* render view */
$oCms->view( $view, $data );
function listDirectory($dir){
	$result = array();
	$root = scandir($dir);
	foreach($root as $value) {
	  if($value === '.' || $value === '..') {
		continue;
	  }
	  if(is_dir("$dir$value")) {
		$result[] = "$dir$value/";
	  }
	  foreach(listDirectory("$dir$value/") as $value)
	  {
		$result[] = $value;
	  }
	}
	return $result;
}