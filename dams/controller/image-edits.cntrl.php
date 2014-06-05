<?php     //song edits (cuts)      
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
$view = 'image-edits_form';
$oImage = new image();
$oDeployment=new deployment();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$id = (int)$_GET['id']; 
if( $action == 'add' || $action == 'edit' ){ #print_r($_FILES);
		if(sizeof($_POST)>0 && sizeof($_FILES)>0){
			$i=0;
			$image_id=cms::sanitizeVariable($_POST['image_id']);
			$image_name=cms::sanitizeVariable($_POST['image_name']);
			foreach($_FILES as $file){
				foreach($file['name'] as $configId=>$fName){
					if($fName){
						$limit	= 1;
						$start	= 0;
						$params = array(
									'limit'	  => $limit,  
									'start'   => $start,  
									'where'	  => " AND image_edit_id=".$configId,
								  );
						$dataConfig = $oImage->getAllImagesConfig($params );
						$format=$dataConfig[0]->format;
						$dimension=$dataConfig[0]->dimension;
						$file_size_limit=$dataConfig[0]->file_size;

						$uFileName=$file['name'][$configId];
						$tmpName=$file['tmp_name'][$configId];
						$fileSize=$file['size'][$configId];
						$fileSize=round($fileSize/1024);
						$totalFileName=tools::cleaningName($image_name);
						$folderPath="/".$dimension."/".tools::getImagePathChar(array('title'=>$image_name,'length'=>2))."/";
						$fileName=$totalFileName."-".$image_id."-".$configId."-".$dimension.".".$format;
						$sTempAudioPath	= $format.$folderPath.$fileName;
						
						if($fileSize>$file_size_limit){
							$data['aError'][]="Please upload ".$dimension." file of proper size.";
						}
						if(empty($data['aError'])){
							$params = NULL;
							$params = array( "uFile" => $uFileName,
										"file" => $fileName,
										"oFile"	  => $sTempAudioPath,
										"tmpFile" => $tmpName,
										"ext" => array($format),
										"size" =>$file_size_limit,
										"oSize" => $fileSize,
										);
							$return=tools::saveImageEdits($params);
							if(empty($return['error'])){
								$dData=$oDeployment->image_mstr_config_rel(array('imageId'=>$image_id,'configId'=>$configId,'path'=>$sTempAudioPath,'version'=>1));
								TOOLS::log('Image edits added to '.$_GET['image_name'], $action, '27', (int)$this->user->user_id, "Image Id: ".$image_id."" );
								$data['aSuccess'][]="Action completed susseccfully!";
							}else{
								$data['aError']=$return;
							}
						}
					}
					$i++;
				}
			}
		}
		$data['aContent']=NULL;
		$lisData = $oImage->getImageEdits($id );
		if(sizeof($lisData)>0 && $lisData){
			foreach($lisData as $lisData){
				$data['aContent'][$lisData->config_id] 	 = $lisData;
			}
		}	
		$data['aEditConfig']	 = $oImage->getImageEditsConfig();
}
/* render view */
$oCms->view( $view, $data );