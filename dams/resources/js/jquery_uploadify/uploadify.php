<?php

require_once "../includes/config.php";
require_once "../includes/tools.php";
require_once "../includes/utility.php";

error_reporting(1);
$videoFile = $_FILES['Filedata'];
$folder = $_POST['folder'];

$response['status'] = 'ERROR';
$response['msg'] = 'Please Select File';
$response['post'] = $_POST;
$response['file'] = $videoFile['name'];

if(!empty($videoFile['name'])){
	
	$pathInfo = pathinfo($videoFile['name']);
	$allowedFiles = array('3gp','mp4', 'avi', 'flv');
	//$allowedFiles = array('3gp');
	
	$aError = array();
	
	if(!in_array(strtolower($pathInfo['extension']),$allowedFiles)){
		$aError[] = "File types Allowed : ". implode(',',$allowedFiles);
	}
	
	//
	//if($videoFile['size'] > 4194304 /*32MB*/){
	//	$aError[] = "Max File Size Allowed is 32 MB";
	//}
	
	if(count($aError) == 0){
		#echo 'FN:'.$pathInfo['filename'];
		$newName = md5($pathInfo['filename'].date('His')).'.'.$pathInfo['extension'];
		
		$hashPath = date('dmY')."/";
		
		$newPath = trim($folder,'/').'/'.$hashPath.$newName;
		
		createFolderRecursively($cnf['media_severpath'].$newPath);
		
		if(move_uploaded_file($videoFile['tmp_name'], $cnf['media_severpath'].$newPath)){
			$response['status'] = 'OK';
			#http://scms.in.com/in-media/video.php?file=22022012/db1ed31d34092d2cb3f1de7574d80ade.flv			
			$response['filepath'] = $cnf['mediaurl']."video.php?file=".$newPath;
			$response['filename'] = $newName;
			$response['msg'] = 'File Uploaded Successfully.';
			videouploadlogs($response['msg'].$cnf['media_severpath'].$newPath);
			#$response['test'] = "ssh stremaning@172.30.50.120  /Users/stremaning/video_incom/convert_api_incom_new.sh ".$newName." ".$response['filepath'];
			$resp = shell_exec("ssh stremaning@172.30.50.120 /Users/stremaning/vod_incom/vod_api_incom.sh $newName ".$response['filepath']);
			videouploadlogs("Converting ".$response['filepath']." response=>".$resp);
			//$response['rep'] = $resp;
			if(stristr($resp,'The Eagle Has Landed')) {
				$response['convertStatus'] = '1'; //converted successfully
			}else{
				$response['convertStatus'] = '2'; //conversion failed
			}
			
			$response['resp'] = $resp;
		}else{
			$response['msg'] = $msg.$cnf['media_severpath'].trim($folder,'/').'/'.$hashPath.'#File Uploaded Error.';	
			videouploadlogs($response['msg']);
		}
	}else{
		$response['msg'] =  implode(chr(10),$aError);
		videouploadlogs($response['msg']);
	}
}

echo json_encode($response);
	
?>