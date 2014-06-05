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
$oText = new text();
$oLanguage=new language();
$action = cms::sanitizeVariable( $_GET['action'] );
global $aConfig;
$id = (int)$_GET['id']; 
if($action=="add"){
	$view = 'textbulk_form';
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
				$text_title=cms::sanitizeVariable($csv_line[0]);
				$text_type=cms::sanitizeVariable($csv_line[1]);
				$text_language=cms::sanitizeVariable($csv_line[2]);
				$text_description=cms::sanitizeVariable($csv_line[3]);
				$album_name=cms::sanitizeVariable($csv_line[4]);
				$artist_name=cms::sanitizeVariable($csv_line[5]);
				$file_path=cms::sanitizeVariable($csv_line[6]);
				$status=0;
				
				if($text_title==""){
					$remark['text_title']="Text title required!";
				}
				if($text_type==""){
					$remark['text_type']="Text type required!";
				}
				if($text_type){
					if(!array_key_exists(strtolower($text_type),$aConfig['text_type'])){
						$remark['text_type']="Enter valid Text type!";
					}
				}
				if($text_language==""){
					$remark['text_language']="Text language required!";
				}
				if($text_language){
					$isLang=$oLanguage->getTotalCount( array("where"=>"AND language_name='".$text_language."'") );
					if($isLang!="1"){
						$remark['text_language']="Enter valid text language!";
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
							"text_title"=>$text_title,
							"text_type"=>$text_type,
							"text_language"=>$text_language,
							"text_description"=>$text_description,
							"album_name" =>$album_name,
							"artist_name"=>$artist_name,
							"file_path"=>$file_path,
							"status"=>0,
							"batch_id" => $batchId,
							"remark"=>$remark,
					);
					$res = $oText->saveTempBulk($params);
			}
			$aLogParam = array(
				'moduleName' => 'text bulk',
				'action' => 'add',
				'moduleId' => 35,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Uploaded texts in bulk (Batch ID-'.$batchId.')',
				'content_ids' => $batchId
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'textbulk?action=edit&bid='.$batchId);
			exit;
		}else{
			$aError=$aError;
			$data['aError']=$aError;
		}
	}
}elseif($action=="edit"){
	$view="textbulk_manage";
	$batch_id=cms::sanitizeVariable($_GET['bid']);
	if(!empty($_POST) && $_POST['submitBtn']){
		$text_title=$_POST['text_title'];
		$text_type=$_POST['text_type'];
		$text_language=$_POST['text_language'];
		$text_description=$_POST['text_description'];
		$album_name=$_POST['album_name'];
		$artist_name=$_POST['artist_name'];
		$file_path=$_POST['file_path'];
		$primaryId = $_POST['primaryId'];
		$batch_id = cms::sanitizeVariable($_POST['batch_id']);

		if(!empty($primaryId)){
			foreach($primaryId as $pId){
				$remark=array();
				$validPath=0;
				$text_title_var=$text_title[$pId];
				if($text_title_var==""){
					$remark['text_title']="Text title required!";
				}
				$text_description_var=$text_description[$pId];
				$text_type_var=$text_type[$pId];
				if($text_type_var==""){
					$remark['text_type']="Text type required!";
				}
				if($text_type_var){
					if(!array_key_exists(strtolower($text_type_var),$aConfig['text_type'])){
						$remark['text_type']="Enter valid Text type!";
					}
				}
				$text_language_var=$text_language[$pId];
				if($text_language_var==""){
					$remark['text_language']="Text language required!";
				}
				if($text_language_var){
					$isLang=$oLanguage->getTotalCount( array("where"=>"AND language_name='".$text_language_var."'") );
					if($isLang!="1"){
						$remark['text_language']="Enter valid text language!";
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
							"text_title"=>$text_title_var,
							"text_type"=>$text_type_var,
							"text_language"=>$text_language_var,
							"text_description"=>$text_description_var,
							"album_name" =>$album_name_var,
							"artist_name"=>$artist_name_var,
							"file_path"=>$file_path_var,
							"batch_id" => $batch_id,
							"remark"=>$remark,
							"id" => $pId,
							"status" => $status,
					);
					$res = $oText->saveTempBulk($params);
			}
		}
		header('location:'.SITEPATH.'textbulk?action=edit&bid='.$batch_id);
		exit;
	}
	if(!empty($_POST) && $_POST['gotodb']){
		$text_title=$_POST['text_title'];
		$text_type=$_POST['text_type'];
		$text_language=$_POST['text_language'];
		$text_description=$_POST['text_description'];
		$album_name=$_POST['album_name'];
		$artist_name=$_POST['artist_name'];
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
				$text_description_var=$text_description[$pId];
				$text_title_var=$text_title[$pId];
				if($text_title_var==""){
					$remark['text_title']="Text title required!";
				}
				$text_type_var=$text_type[$pId];
				if($text_type_var==""){
					$remark['text_type']="Text type required!";
				}
				if($text_type_var){
					if(array_key_exists(strtolower($text_type_var),$aConfig['text_type'])){
						$text_type_id=$aConfig['text_type'][strtolower($text_type_var)];
					}else{
						$remark['text_type']="Enter valid Text type!";
					}
				}
				$text_language_var=$text_language[$pId];
				if($text_language_var){
					$isLang=$oLanguage->getAllLanguages( array("where"=>"AND language_name='".$text_language_var."'") );
					if($isLang[0]->language_id>0){
						$language_id=$isLang[0]->language_id;
					}else{
						$remark['language']="Enter valid language!";
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
					$destinationPath=MEDIA_SEVERPATH_DOC.$sNewDirPath.$cleanFileName.".".$fExt;
					tools::createDir($destinationPath);
					if(!file_exists($destinationPath)){
						if(copy($sourcePath,$destinationPath)){
								
						}else{
							$remark['file_path']="Error in copy text file";
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
							"text_title"=>$text_title_var,
							"text_type"=>$text_type_var,
							"text_language"=>$text_language_var,
							"text_description"=>$text_description_var,
							"album_name" =>$album_name_var,
							"artist_name"=>$artist_name_var,
							"file_path"=>$file_path_var,
							"batch_id" => $batch_id,
							"remark"=>$remark,
							"id" => $pId,
							"status" => $status,
					);
					$res = $oText->saveTempBulk($params);
					if($status==1){//final move to song_mstr
						$postData=array(
							'textName' 	=> $text_title_var, 
							'textDesc' 	=> $text_description_var,
							'txtFileName' => $fileName, 
							'textType' => $text_type_id, 
							'languageIds' => $language_id,
							'status'      => $status,
							);
						$aData = $oText->saveText( $postData );
						if($aData){
							$logMsg="Created text.";
							if($singerHiddenArr){ 
								$oData=$oText->mapArtistText(array('textId'=>(int)$aData,'artistIds'=>$singerHiddenArr));					
							}
							
							if($album_id){
								$lData=$oText->mapAlbumText(array('textId'=>(int)$aData,'albumIds'=>array($album_id)));
							}	
							$aLogParam = array(
								'moduleName' => 'Text',
								'action' => 'add',
								'moduleId' => 19,
								'editorId' => $this->user->user_id,
								'remark'	=> $logMsg." (ID-".$aData.")",
								'content_ids' => $aData
							);
							TOOLS::writeActivityLog( $aLogParam );	
							$oText->updateGoToDbBulk(array('id'=>$pId));
						}
					}
			}
			$msg="";
			if(!in_array(0,$statusArr)){
				$msg="&msg=Action completed successfully!";
			}
		}
		header('location:'.SITEPATH.'textbulk?action=edit&bid='.$batch_id.$msg);
		exit;
	}
	$params = array(
				'start' => 0, 
				'limit' => 10000, 
				'where' => ' AND batch_id="'.$batch_id.'"', 
			  ); 
	$aSongData = $oText->getAllBulkTexts( $params );
	$data['aContent']=$aSongData;
}else{
	$view = 'textbulk_list';
	$lisData = getlist( $oText ,$this);
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
}
function getlist( $oText,$users=NULL){
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
	
	$data['aContent'] = $oText->getAllBulkTexts( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oText->getTotalBulkCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "textbulk?action=view&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}	
/* render view */
$oCms->view( $view, $data );