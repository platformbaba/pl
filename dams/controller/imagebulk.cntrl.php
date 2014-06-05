<?php //song bulk upload                
#error_reporting(E_ALL);
#ini_set("display_errors",1);
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$oSong = new song();
$oAlbum = new album();
$oArtist = new artist();
$oImage = new image();
$action = cms::sanitizeVariable( $_GET['action'] );
global $aConfig;
$id = (int)$_GET['id']; 
if($action=="add"){
	$view = 'imagebulk_form';
	if(!empty($_POST)){
		$fileData = $_FILES['csv'];
		$pathInfo = pathinfo($fileData['name']);
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
		$errorArray=array();
		if(empty($aError[0])){
			$file = fopen(MEDIA_SEVERPATH_TEMP."bulk/".$newName,"r");
			$csvData=array();
			$i=0;
			while($csv_line = fgetcsv($file)){
				$i++;
				if($i==1){
					continue;
				}
				$remark=array();				
				$image_title=cms::sanitizeVariable($csv_line[0]);
				$image_type=cms::sanitizeVariable($csv_line[1]);
				$image_description=cms::sanitizeVariable($csv_line[2]);
				$album_name=cms::sanitizeVariable($csv_line[3]);
				$artist_name=cms::sanitizeVariable($csv_line[4]);
				$song_isrc =cms::sanitizeVariable($csv_line[5]);
				$file_path=cms::sanitizeVariable($csv_line[6]);
				$status=0;
				
				if($image_title==""){
					$remark['image_title']="Image title required!";
				}
				if($image_type==""){
					$remark['image_type']="Image type required!";
				}
				if($image_type){
					if(!array_key_exists(ucwords($image_type),$aConfig['image_type'])){
						$remark['image_type']="Enter valid Image type!";
					}
				}
				if($song_isrc){
					$isIsrcExit= $oSong->getTotalCount( array("where"=>"AND isrc='".$song_isrc."'") );
					if($isIsrcExit!=1){
						$remark['song_isrc']="Enter valid Song ISRC!";
					}
				}
				if($album_name==""){
					$remark['album_name']="Enter album name!";
				}
				if($album_name){
					$album_name_Arr=explode("(",$album_name);
					$album_release_date=@str_replace(")","",$album_name_Arr[1]);
					$query="";
					$album_name_chk=@trim($album_name_Arr[0]);
					if($album_release_date && $album_release_date!="0000-00-00"){
						$album_release_date=date("Y-m-d",strtotime($album_release_date));
						$query=" AND music_release_date='".$album_release_date."'";
					}
					$isAlbum=$oAlbum->getTotalCount( array("where"=>"AND album_name='".$album_name_chk."' ".$query) );	
					if($isAlbum=="0"){
						$remark['album_name']="Enter valid album name!";
					}
				}
				$singer=$artist_name;
				if($singer){
					$singArr=explode(",",$singer);
					if(sizeof($singArr)>0){
						foreach($singArr as $sing){
							$sing_name_Arr=explode("(",$sing);
							$dob=@str_replace(")","",$sing_name_Arr[1]);
							$sing_chk=@trim($sing_name_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isSinger=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$sing_chk."'".$query) );
							if($isSinger!="1"){
								$remark['artist_name'][]="Enter valid artist name for ".$sing."!";
							}
						}
					}
				}
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$file_path)){
					$remark['file_path']="Enter valid file path!";
				}
								
				$remark=json_encode($remark);
				$params=NULL;
				$params = array(
							"image_title"=>$image_title,
							"image_type"=>$image_type,
							"image_description"=>$image_description,
							"album_name" =>$album_name,
							"artist_name"=>$artist_name,
							"song_isrc"=>$song_isrc,
							"file_path"=>$file_path,
							"status"=>0,
							"batch_id" => $batchId,
							"remark"=>$remark,
					);
					$res = $oImage->saveTempBulk($params);
			}
			$aLogParam = array(
				'moduleName' => 'image bulk',
				'action' => 'add',
				'moduleId' => 34,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Uploaded images in bulk (Batch ID-'.$batchId.')',
				'content_ids' => $batchId
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'imagebulk?action=edit&bid='.$batchId);
			exit;
		}else{
			$aError=$aError;
			$data['aError']=$aError;
		}
	}
}elseif($action=="edit"){
	$view="imagebulk_manage";
	$batch_id=cms::sanitizeVariable($_GET['bid']);
	if(!empty($_POST) && $_POST['submitBtn']){
		$image_title=$_POST['image_title'];
		$image_type=$_POST['image_type'];
		$image_description=$_POST['image_description'];
		$album_name=$_POST['album_name'];
		$artist_name=$_POST['artist_name'];
		$song_isrc =$_POST['song_isrc'];
		$file_path=$_POST['file_path'];
		$primaryId = $_POST['primaryId'];
		$batch_id = cms::sanitizeVariable($_POST['batch_id']);

		if(!empty($primaryId)){
			foreach($primaryId as $pId){
				$remark=array();
				$validPath=0;
				$image_title_var=$image_title[$pId];
				if($image_title_var==""){
					$remark['image_title']="Image title required!";
				}
				$image_description_var=$image_description[$pId];
				$image_type_var=$image_type[$pId];
				if($image_type_var==""){
					$remark['image_type']="Image type required!";
				}
				if($image_type_var){
					if(!array_key_exists(ucwords($image_type_var),$aConfig['image_type'])){
						$remark['image_type']="Enter valid Image type!";
					}
				}
				$song_isrc_var=$song_isrc[$pId];
				if($song_isrc_var){
					$isIsrcExit= $oSong->getTotalCount( array("where"=>"AND isrc='".$song_isrc_var."'") );
					if($isIsrcExit!=1){
						$remark['song_isrc']="Enter valid Song ISRC!";
					}
				}
				$album_name_var=$album_name[$pId];
				if($album_name_var==""){
					$remark['album_name']="Enter album name!";
				}
				if($album_name_var){
					$album_name_Arr=explode("(",$album_name_var);
					$album_release_date=@str_replace(")","",$album_name_Arr[1]);
					$query="";
					$album_name_chk=@trim($album_name_Arr[0]);
					if($album_release_date && $album_release_date!="0000-00-00"){
						$album_release_date=date("Y-m-d",strtotime($album_release_date));
						$query=" AND music_release_date='".$album_release_date."'";
					}
					$isAlbum=$oAlbum->getTotalCount( array("where"=>"AND album_name='".$album_name_chk."' ".$query) );	
					if($isAlbum=="0"){
						$remark['album_name']="Enter valid album name!";
					}
				}
				$artist_name_var=$artist_name[$pId];
				$singer=$artist_name_var;
				if($singer){
					$singArr=explode(",",$singer);
					if(sizeof($singArr)>0){
						foreach($singArr as $sing){
							$sing_name_Arr=explode("(",$sing);
							$dob=@str_replace(")","",$sing_name_Arr[1]);
							$sing_chk=@trim($sing_name_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isSinger=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$sing_chk."'".$query) );
							if($isSinger!="1"){
								$remark['artist_name'][]="Enter valid artist name for ".$sing."!";
							}
						}
					}
				}
				$file_path_var=$file_path[$pId];
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$file_path_var)){
					$remark['file_path']="Enter valid file path!";
				}
				
				$remarkArr=$remark;
				$remark=json_encode($remark);
				$status=0;
				if(empty($remarkArr)){
					$status=1;
				}
				$params=NULL;
				$params = array(
							"image_title"=>$image_title_var,
							"image_type"=>$image_type_var,
							"image_description"=>$image_description_var,
							"album_name" =>$album_name_var,
							"artist_name"=>$artist_name_var,
							"song_isrc"=>$song_isrc_var,
							"file_path"=>$file_path_var,
							"batch_id" => $batch_id,
							"remark"=>$remark,
							"id" => $pId,
							"status" => $status,
					);
					$res = $oImage->saveTempBulk($params);
			}
		}
		header('location:'.SITEPATH.'imagebulk?action=edit&bid='.$batch_id);
		exit;
	}
	if(!empty($_POST) && $_POST['gotodb']){
		$image_title=$_POST['image_title'];
		$image_type=$_POST['image_type'];
		$image_description=$_POST['image_description'];
		$album_name=$_POST['album_name'];
		$artist_name=$_POST['artist_name'];
		$song_isrc =$_POST['song_isrc'];
		$file_path=$_POST['file_path'];
		$statusArr=$_POST['status'];
		$gotodbArr=$_POST['gotodb'];
		$primaryId = $_POST['primaryId'];
		$batch_id = cms::sanitizeVariable($_POST['batch_id']);
		if(!empty($primaryId)){
			foreach($primaryId as $pId){
				if($gotodbArr[$pId]==1){
					continue;
				}
				$remark=array();
				$validPath=0;
				$file_path_var=$file_path[$pId];
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$file_path_var)){
					$remark['file_path']="Enter valid file path!";
				}else{
					$validPath=1;
				}
				$image_description_var=$image_description[$pId];
				$image_title_var=$image_title[$pId];
				if($image_title_var==""){
					$remark['image_title']="Image title required!";
				}
				$image_type_var=$image_type[$pId];
				if($image_type_var==""){
					$remark['image_type']="Image type required!";
				}
				if($image_type_var){
					if(array_key_exists(ucwords($image_type_var),$aConfig['image_type'])){
						$image_type_id=$aConfig['image_type'][ucwords($image_type_var)];
					}else{
						$remark['image_type']="Enter valid Image type!";
					}
				}
				$song_isrc_var=$song_isrc[$pId];
				if($song_isrc_var){
					$isIsrcExit= $oSong->getAllSongs( array("where"=>"AND isrc='".$song_isrc_var."'") );
					if($isIsrcExit[0]->song_id>0){
						$song_id=$isIsrcExit[0]->song_id;
					}else{
						$remark['song_isrc']="Enter valid song ISRC!";
					}
				}
				$album_name_var=$album_name[$pId];
				if($album_name_var==""){
					$remark['album_name']="Enter album name!";
				}
				if($album_name_var){
					$album_name_Arr=explode("(",$album_name_var);
					$album_release_date=@str_replace(")","",$album_name_Arr[1]);
					$query="";
					$album_name_chk=@trim($album_name_Arr[0]);
					if($album_release_date && $album_release_date!="0000-00-00"){
						$album_release_date=date("Y-m-d",strtotime($album_release_date));
						$query=" AND music_release_date='".$album_release_date."'";
					}	
					$isAlbum=$oAlbum->getAllAlbums( array("where"=>"AND album_name='".$album_name_chk."' ".$query) );
					if($isAlbum[0]->album_id>0){
						$album_id=$isAlbum[0]->album_id;
					}else{
						$remark['album_name']="Enter valid album name!";
					}
				}
				$artist_name_var=$artist_name[$pId];
				$singer_var=$artist_name_var;
				if($singer_var){
					$singArr=explode(",",$singer_var);
					$singerHiddenArr=array();
					if(sizeof($singArr)>0){
						foreach($singArr as $sing){
							$sing_name_Arr=explode("(",$sing);
							$dob=@str_replace(")","",$sing_name_Arr[1]);
							$sing_chk=@trim($sing_name_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isSinger=$oArtist->getAllArtists( array("where"=>"AND artist_name='".$sing_chk."'".$query) );
							if($isSinger[0]->artist_id>0){
								$singerHiddenArr[]=$isSinger[0]->artist_id;
							}else{
								$remark['artist_name'][]="Enter valid artist name for ".$sing."!";
							}
						}
					}
				}
				if($validPath==1){
					$sourcePath=MEDIA_SERVERPATH_TEMPFTP.$file_path_var;
					$pathinfo=pathinfo($sourcePath);
					$fExt=$pathinfo['extension'];
					$cleanFileName	= TOOLS::cleanFileName($pathinfo['filename'], true);
					$sNewDirPath 	= TOOLS::getImagePath($cleanFileName);
					$fileName=$sNewDirPath.$cleanFileName.".".$fExt;
					$destinationPath=MEDIA_SEVERPATH_IMAGE.$sNewDirPath.$cleanFileName.".".$fExt;
					tools::createDir($destinationPath);
					if(!file_exists($destinationPath)){
						if(copy($sourcePath,$destinationPath)){
								
						}else{
							$remark['file_path']="Error in copy image file";
						}
					}	
				}
				$remarkArr=$remark;
				$remark=json_encode($remark);
				$status=0;
				if(empty($remarkArr)){
					$status=1;
				}
				$statusArr[]=$status;
				$params=NULL;
				$params = array(
							"image_title"=>$image_title_var,
							"image_type"=>$image_type_var,
							"image_description"=>$image_description_var,
							"album_name" =>$album_name_var,
							"artist_name"=>$artist_name_var,
							"song_isrc"=>$song_isrc_var,
							"file_path"=>$file_path_var,
							"batch_id" => $batch_id,
							"remark"=>$remark,
							"id" => $pId,
							"status" => $status,
					);
					$res = $oImage->saveTempBulk($params);
					if($status==1){//final move to song_mstr
						$postData=array(
							'imageName' 	=> $image_title_var, 
							'imageDesc' 	=> $image_description_var, 
							'imageType' 	=> $image_type_id, 
							'imageFile'		=> $fileName,
							'status' 		=> $status, 
							);
						$aData = $oImage->saveImage( $postData );
						if($aData){
							$logMsg="Created image.";
							if($singerHiddenArr){ 
								$oData=$oImage->mapArtistImage(array('imageId'=>(int)$aData,'artistIds'=>$singerHiddenArr));					
							}
							if($album_id){
								$lData=$oImage->mapAlbumImage(array('imageId'=>(int)$aData,'albumIds'=>array($album_id)));
							}
							
							if($song_id){
								$sData=$oImage->mapSongImage(array('imageId'=>(int)$aData,'songIds'=>array($song_id)));
							}
							$aLogParam = array(
								'moduleName' => 'image',
								'action' => $action,
								'moduleId' => 17,
								'editorId' => $this->user->user_id,
								'remark'	=>	ucfirst($logMsg).' (ID-'.$aData.')',
								'content_ids' => $aData
							);
							TOOLS::writeActivityLog( $aLogParam );	
							$oImage->updateGoToDbBulk(array('id'=>$pId));
						}
					}
			}
			$msg="";
			if(!in_array(0,$statusArr)){
				#$oImage->updateGoToDbBulk(array('batch_id'=>$batch_id));
				$msg="&msg=Action completed successfully!";
			}
		}
		header('location:'.SITEPATH.'imagebulk?action=edit&bid='.$batch_id.$msg);
		exit;
	}
	$params = array(
				'start' => 0, 
				'limit' => 10000, 
				'where' => ' AND batch_id="'.$batch_id.'"', 
			  ); 
	$aSongData = $oImage->getAllBulkImages( $params );
	$data['aContent']=$aSongData;
}else{
	$view = 'imagebulk_list';
	$lisData = getlist( $oImage ,$this);
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
}
function getlist( $oImage,$users=NULL){
	global $oMysqli;
	/* Search Param start */
	$where		 = '';
	/* Show Song as List Start */
	$limit	= MAX_DISPLAY_COUNT;
	$page	= (int)$_GET['page'];
	$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
	$params = array(
				'limit'	  => $limit,  
				'orderby' => " GROUP BY batch_id ORDER BY batch_id DESC ",  
				'start'   => $start,  
				'where'	  => $where,
			  );
	
	$data['aContent'] = $oImage->getAllBulkImages( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oImage->getTotalBulkCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "imagebulk?action=view&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}	
/* render view */
$oCms->view( $view, $data );