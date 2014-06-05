<?php //song bulk upload                 
#error_reporting(E_ALL);
#ini_set("display_errors",1);
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$oSong = new song();
$oLanguage = new language();
$oAlbum = new album();
$oArtist = new artist();
$oTag = new tags();
$oRegion=new region();
$oVideo=new video();
$oImage=new image();
$action = cms::sanitizeVariable( $_GET['action'] );
global $aConfig;
$id = (int)$_GET['id']; 
if($action=="add"){
	$view = 'videobulk_form';
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
				$video_title=cms::sanitizeVariable($csv_line[0]);
				$song_isrc=cms::sanitizeVariable($csv_line[1]);
				$album_name=cms::sanitizeVariable($csv_line[2]);
				$video_language=cms::sanitizeVariable($csv_line[3]);
				$release_date =cms::sanitizeVariable($csv_line[4]);
				$video_duration=cms::sanitizeVariable($csv_line[5]);
				$subject_parody=cms::sanitizeVariable($csv_line[6]);
				$singer=cms::sanitizeVariable($csv_line[7]);
				$director=cms::sanitizeVariable($csv_line[8]);
				$lyricist=cms::sanitizeVariable($csv_line[9]);
				$starcast=cms::sanitizeVariable($csv_line[10]);
				$mimicked_star=cms::sanitizeVariable($csv_line[11]);
				$version=cms::sanitizeVariable($csv_line[12]);
				$genre=cms::sanitizeVariable($csv_line[13]);
				$mood=cms::sanitizeVariable($csv_line[14]);
				$relationship=cms::sanitizeVariable($csv_line[15]);
				$raag=cms::sanitizeVariable($csv_line[16]);
				$taal=cms::sanitizeVariable($csv_line[17]);
				$time_of_day=cms::sanitizeVariable($csv_line[18]);
				$religion=cms::sanitizeVariable($csv_line[19]);
				$saint=cms::sanitizeVariable($csv_line[20]);
				$instrument=cms::sanitizeVariable($csv_line[21]);
				$festival=cms::sanitizeVariable($csv_line[22]);
				$occasion=cms::sanitizeVariable($csv_line[23]);
				$video_file_path=cms::sanitizeVariable($csv_line[24]);
				$image_file_path=cms::sanitizeVariable($csv_line[25]);
				$status=0;
				
				if($video_title==""){
					$remark['video_title']="Enter video title!";
				}
				if($song_isrc){
					$isIsrcExit= $oSong->getTotalCount( array("where"=>"AND isrc='".$song_isrc."'") );
					if($isIsrcExit!=1){
						$remark['song_isrc']="Enter valid song ISRC!";
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
				if($video_language==""){
					$remark['video_language']="Video language is required!";
				}
				if($video_language){
					$isLang=$oLanguage->getTotalCount( array("where"=>"AND language_name='".$video_language."'") );
					if($isLang=="0"){
						$remark['video_language']="Enter valid language!";
					}
				}
				if($release_date){
					$release_date=date("Y-m-d",strtotime($release_date));
				}
				if($singer==""){
					$remark['singer'][]="Enter singer!";
				}
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
								$remark['singer'][]="Enter valid singer name for ".$sing."!";
							}
						}
					}
				}
				if($director){
					$mdArr=explode(",",$director);
					if(sizeof($mdArr)>0){
						foreach($mdArr as $md){
							$md_Arr=explode("(",$md);
							$dob=@str_replace(")","",$md_Arr[1]);
							$md_chk=@trim($md_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isMdir=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$md_chk."'".$query) );
							if($isMdir!="1"){
								$remark['director'][]="Enter valid music director name for ".$md."!";
							}
						}
					}
				}
				if($lyricist){
					$lyrArr=explode(",",$lyricist);
					if(sizeof($lyrArr)>0){
						foreach($lyrArr as $lyr){
							$lyr_Arr=explode("(",$lyr);
							$dob=@str_replace(")","",$lyr_Arr[1]);
							$lyr_chk=@trim($lyr_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isLyr=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$lyr_chk."'".$query) );
							if($isLyr!="1"){
								$remark['lyricist'][]="Enter valid lyricist name for ".$lyr."!";
							}
						}
					}
				}
				if($starcast==""){
					$remark['starcast'][]="Enter starcast!";
				}
				if($starcast){
					$starcastArr=explode(",",$starcast);
					if(sizeof($starcastArr)>0){
						foreach($starcastArr as $star){
							$star_Arr=explode("(",$star);
							$dob=@str_replace(")","",$star_Arr[1]);
							$star_chk=@trim($star_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isStar=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$star_chk."'".$query) );
							if($isStar!="1"){
								$remark['starcast'][]="Enter valid starcast name for ".$star."!";
							}
						}
					}
				}
				if($mimicked_star){
					$mStarArr=explode(",",$mimicked_star);
					if(sizeof($mStarArr)>0){
						foreach($mStarArr as $mstar){
							$mstar_Arr=explode("(",$mstar);
							$dob=@str_replace(")","",$mstar_Arr[1]);
							$mstar_chk=@trim($mstar_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isMstar=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$mstar_chk."'".$query) );
							if($isMstar!="1"){
								$remark['mimicked_star'][]="Enter valid mimicked star name for ".$mstar."!";
							}
						}
					}
				}
				if($version){
					$versionArr=explode(",",$version);
					if(sizeof($varsionArr)>0){
						foreach($versionArr as $ver){
							$isVar=$oTag->getTotalCount( array("where"=>"AND tag_name='".$ver."' AND parent_tag_id=1889") );
							if($isVar!="1"){
								$remark['version'][]="Enter valid varsion for ".$ver."!";
							}
						}
					}
				}
				if($genre){
					$genreArr=explode(",",$genre);
					if(sizeof($genreArr)>0){
						foreach($genreArr as $gen){
							$isVar=$oTag->getTotalCount( array("where"=>"AND tag_name='".$gen."' AND parent_tag_id=1688") );
							if($isVar!="1"){
								$remark['genre'][]="Enter valid genre for ".$gen."!";
							}
						}
					}
				}
				if($mood){
					$moodArr=explode(",",$mood);
					if(sizeof($moodArr)>0){
						foreach($moodArr as $moo){
							$isMood=$oTag->getTotalCount( array("where"=>"AND tag_name='".$moo."' AND parent_tag_id=1") );
							if($isMood!="1"){
								$remark['mood'][]="Enter valid mood for ".$moo."!";
							}
						}
					}
				}
				if($relationship){
					$relArr=explode(",",$relationship);
					if(sizeof($relArr)>0){
						foreach($relArr as $rel){
							$isRel=$oTag->getTotalCount( array("where"=>"AND tag_name='".$rel."' AND parent_tag_id=16") );
							if($isRel!="1"){
								$remark['relationship'][]="Enter valid relationship for ".$rel."!";
							}
						}
					}
				}
				if($raag){
					$raagArr=explode(",",$raag);
					if(sizeof($raagArr)>0){
						foreach($raagArr as $raa){
							$isRaag=$oTag->getTotalCount( array("where"=>"AND tag_name='".$raa."' AND parent_tag_id=1189") );
							if($isRaag!="1"){
								$remark['raag'][]="Enter valid raag for ".$raa."!";
							}
						}
					}
				}
				if($taal){
					$taalArr=explode(",",$taal);
					if(sizeof($taalArr)>0){
						foreach($taalArr as $taa){
							$isTaal=$oTag->getTotalCount( array("where"=>"AND tag_name='".$taa."' AND parent_tag_id=1383") );
							if($isTaal!="1"){
								$remark['taal'][]="Enter valid taal for ".$taa."!";
							}
						}
					}
				}
				if($time_of_day){
					$todArr=explode(",",$time_of_day);
					if(sizeof($todArr)>0){
						foreach($todArr as $tod){
							$isTod=$oTag->getTotalCount( array("where"=>"AND tag_name='".$tod."' AND parent_tag_id=1415") );
							if($isTod!="1"){
								$remark['time_of_day'][]="Enter valid time of the day for ".$tod."!";
							}
						}
					}
				}
				if($religion){
					$relArr=explode(",",$religion);
					if(sizeof($relArr)>0){
						foreach($relArr as $rel){
							$isRel=$oTag->getTotalCount( array("where"=>"AND tag_name='".$rel."' AND parent_tag_id=498") );
							if($isRel!="1"){
								$remark['religion'][]="Enter valid religion for ".$rel."! ";
							}
						}
					}
				}
				if($saint){
					$saintArr=explode(",",$saint);
					if(sizeof($saintArr)>0){
						foreach($saintArr as $st){
							$isSaint=$oTag->getTotalCount( array("where"=>"AND tag_name='".$st."' AND parent_tag_id=506") );
							if($isRel!="1"){
								$remark['saint'][]="Enter valid saint for ".$st."!";
							}
						}
					}
				}
				if($instrument){
					$intArr=explode(",",$instrument);
					if(sizeof($intArr)>0){
						foreach($intArr as $int){
							$isInt=$oTag->getTotalCount( array("where"=>"AND tag_name='".$int."' AND parent_tag_id=1424") );
							if($isInt!="1"){
								$remark['instrument'][]="Enter valid instrument for ".$int."!";
							}
						}
					}
				}
				if($festival){
					$festArr=explode(",",$festival);
					if(sizeof($festArr)>0){
						foreach($festArr as $fest){
							$isFest=$oTag->getTotalCount( array("where"=>"AND tag_name='".$fest."' AND parent_tag_id=29") );
							if($isFest!="1"){
								$remark['festival'][]="Enter valid festival for ".$fest."!";
							}
						}
					}
				}
				if($occasion){
					$occArr=explode(",",$occasion);
					if(sizeof($occArr)>0){
						foreach($occArr as $occ){
							$isOcc=$oTag->getTotalCount( array("where"=>"AND tag_name='".$occ."' AND parent_tag_id=487") );
							if($isOcc!="1"){
								$remark['occasion'][]="Enter valid occasion for ".$occ."!";
							}
						}
					}
				}
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$video_file_path)){
					$remark['video_file_path']="Enter valid video file path!";
				}
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$image_file_path)){
					$remark['image_file_path']="Enter valid image file path!";
				}
				$remark=json_encode($remark);
				$params=NULL;
				$params = array(
							"video_title"=>$video_title,
							"song_isrc"=>$song_isrc,
							"album_name"=>$album_name,
							"video_language"=>$video_language,
							"release_date" =>$release_date,
							"video_duration"=>$video_duration,
							"subject_parody"=>$subject_parody,
							"singer"=>$singer,
							"director"=>$director,
							"lyricist"=>$lyricist,
							"starcast"=>$starcast,
							"mimicked_star"=>$mimicked_star,
							"version"=>$version,
							"genre"=>$genre,
							"mood"=>$mood,
							"relationship"=>$relationship,
							"raag"=>$raag,
							"taal"=>$taal,
							"time_of_day"=>$time_of_day,
							"religion"=>$religion,
							"saint"=>$saint,
							"instrument"=>$instrument,
							"festival"=>$festival,
							"occasion"=>$occasion,
							"video_file_path"=>$video_file_path,
							"image_file_path"=>$image_file_path,
							"status"=>$status,
							"batch_id" => $batchId,
							"remark"=>$remark,
					);
					$res = $oVideo->saveTempBulk($params);
			}
			$aLogParam = array(
				'moduleName' => 'video bulk',
				'action' => 'add',
				'moduleId' => 33,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Uploaded videos in bulk (Batch ID-'.$batchId.')',
				'content_ids' => $batchId
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'videobulk?action=edit&bid='.$batchId);
			exit;
		}else{
			$aError=$aError;
			$data['aError']=$aError;
		}
	}
}elseif($action=="edit"){
	$view="videobulk_manage";
	$batch_id=cms::sanitizeVariable($_GET['bid']);
	if(!empty($_POST) && $_POST['submitBtn']){
		$song_isrc=($_POST['song_isrc']);
		$video_title=($_POST['video_title']);
		$video_language=($_POST['video_language']);
		$release_date =($_POST['release_date']);
		$video_duration=($_POST['video_duration']);
		$subject_parody=($_POST['subject_parody']);
		$album_name=($_POST['album_name']);
		$singer=($_POST['singer']);
		$director=($_POST['director']);
		$lyricist=($_POST['lyricist']);
		$starcast=($_POST['starcast']);
		$mimicked_star=($_POST['mimicked_star']);
		$version=($_POST['version']);
		$genre=($_POST['genre']);
		$mood=($_POST['mood']);
		$relationship=($_POST['relationship']);
		$raag=($_POST['raag']);
		$taal=($_POST['taal']);
		$time_of_day=($_POST['time_of_day']);
		$religion=($_POST['religion']);
		$saint=($_POST['saint']);
		$instrument=($_POST['instrument']);
		$festival=($_POST['festival']);
		$occasion=($_POST['occasion']);
		$video_file_path=($_POST['video_file_path']);
		$image_file_path=($_POST['image_file_path']);
		$primaryId = $_POST['primaryId'];
		$batch_id = cms::sanitizeVariable($_POST['batch_id']);
		if(!empty($primaryId)){
			foreach($primaryId as $pId){
				$remark=array();
				$videoValidPath=0;
				$imageValidPath=0;
				$video_file_path_var=$video_file_path[$pId];
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$video_file_path_var)){
					$remark['video_file_path']="Enter valid video file path!";
				}else{
					$videoValidPath=1;
				}
				$image_file_path_var=$image_file_path[$pId];
				if(!file_exists(MEDIA_SERVERPATH_TEMPFTP.$image_file_path_var)){
					$remark['image_file_path']="Enter valid image file path!";
				}else{
					$imageValidPath=1;
				}	
				$release_date_var =$release_date[$pId];
				$video_duration_var=$video_duration[$pId];
				$subject_parody_var=$subject_parody[$pId];
				$song_isrc_var=$song_isrc[$pId];
				if($song_isrc_var){
					$isIsrcExit= $oSong->getTotalCount( array("where"=>"AND isrc='".$song_isrc_var."'") );
					if($isIsrcExit!=1){
						$remark['isrc']="Enter valid song ISRC!";
					}
				}
				$video_title_var=$video_title[$pId];
				if($video_title_var==""){
					$remark['video_title']="Enter video title!";
				}
				$video_language_var=$video_language[$pId];
				if($video_language_var==""){
					$remark['video_language']="Enter video language!";
				}
				if($video_language_var){
					$isLang=$oLanguage->getTotalCount( array("where"=>"AND language_name='".$video_language_var."'") );
					if($isLang!="1"){
						$remark['video_language']="Enter valid language!";
					}
				}
				$release_date_var=$release_date[$pId];
				if($release_date_var){
					$release_date_var=date("Y-m-d",strtotime($release_date_var));
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
					if($isAlbum!="1"){
						$remark['album_name']="Enter valid album name!";
					}
				}
				$singer_var=$singer[$pId];
				if($singer_var==""){
					$remark['singer'][]="Enter singer!";
				}
				if($singer_var){
					$singArr=explode(",",$singer_var);
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
								$remark['singer'][]="Enter valid singer name for ".$sing."!";
							}
						}
					}
				}
				$director_var=$director[$pId];
				if($director_var){
					$mdArr=explode(",",$director_var);
					if(sizeof($mdArr)>0){
						foreach($mdArr as $md){
							$md_Arr=explode("(",$md);
							$dob=@str_replace(")","",$md_Arr[1]);
							$md_chk=@trim($md_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isMdir=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$md_chk."'".$query) );
							if($isMdir!="1"){
								$remark['director'][]="Enter valid music director name for ".$md."!";
							}
						}
					}
				}
				$lyricist_var=$lyricist[$pId];
				if($lyricist_var){
					$lyrArr=explode(",",$lyricist_var);
					if(sizeof($lyrArr)>0){
						foreach($lyrArr as $lyr){
							$lyr_Arr=explode("(",$lyr);
							$dob=@str_replace(")","",$lyr_Arr[1]);
							$lyr_chk=@trim($lyr_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isLyr=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$lyr_chk."'".$query) );
							if($isLyr!="1"){
								$remark['lyricist'][]="Enter valid lyricist name for ".$lyr."!";
							}
						}
					}
				}
				$starcast_var=$starcast[$pId];
				if($starcast_var==""){
					$remark['starcast'][]="Enter starcast!";
				}
				if($starcast_var){
					$starcastArr=explode(",",$starcast_var);
					if(sizeof($starcastArr)>0){
						foreach($starcastArr as $star){
							$star_Arr=explode("(",$star);
							$dob=@str_replace(")","",$star_Arr[1]);
							$star_chk=@trim($star_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isStar=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$star_chk."'".$query) );
							if($isStar!="1"){
								$remark['starcast'][]="Enter valid starcast name for ".$star."!";
							}
						}
					}
				}
				$mimicked_star_var=$mimicked_star[$pId];
				if($mimicked_star_var){
					$mStarArr=explode(",",$mimicked_star_var);
					if(sizeof($mStarArr)>0){
						foreach($mStarArr as $mstar){
							$mstar_Arr=explode("(",$mstar);
							$dob=@str_replace(")","",$mstar_Arr[1]);
							$mstar_chk=@trim($mstar_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isMstar=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$mstar_chk."'".$query) );
							if($isMstar!="1"){
								$remark['mimicked_star'][]="Enter valid mimicked star name for ".$mstar."!";
							}
						}
					}
				}
				$version_var=$version[$pId];
				if($version_var==""){
					$remark['version']="Enter version!";
				}
				if($version_var){
					$versionArr=explode(",",$version_var);
					if(sizeof($varsionArr)>0){
						foreach($versionArr as $ver){
							$isVar=$oTag->getTotalCount( array("where"=>"AND tag_name='".$ver."' AND parent_tag_id=1889") );
							if($isVar!="1"){
								$remark['version'][]="Enter valid varsion for ".$ver."!";
							}
						}
					}
				}
				$genre_var=$genre[$pId];
				if($genre_var){
					$genreArr=explode(",",$genre_var);
					if(sizeof($genreArr)>0){
						foreach($genreArr as $gen){
							$isVar=$oTag->getTotalCount( array("where"=>"AND tag_name='".$gen."' AND parent_tag_id=1688") );
							if($isVar!="1"){
								$remark['genre'][]="Enter valid genre for ".$gen."!";
							}
						}
					}
				}
				$mood_var=$mood[$pId];
				if($mood_var){
					$moodArr=explode(",",$mood_var);
					if(sizeof($moodArr)>0){
						foreach($moodArr as $moo){
							$isMood=$oTag->getTotalCount( array("where"=>"AND tag_name='".$moo."' AND parent_tag_id=1") );
							if($isMood!="1"){
								$remark['mood'][]="Enter valid mood for ".$moo."!";
							}
						}
					}
				}
				$relationship_var=$relationship[$pId];
				if($relationship_var){
					$relArr=explode(",",$relationship_var);
					if(sizeof($relArr)>0){
						foreach($relArr as $rel){
							$isRel=$oTag->getTotalCount( array("where"=>"AND tag_name='".$rel."' AND parent_tag_id=16") );
							if($isRel!="1"){
								$remark['relationship'][]="Enter valid relationship for ".$rel."!";
							}
						}
					}
				}
				$raag_var=$raag[$pId];
				if($raag_var){
					$raagArr=explode(",",$raag_var);
					if(sizeof($raagArr)>0){
						foreach($raagArr as $raa){
							$isRaag=$oTag->getTotalCount( array("where"=>"AND tag_name='".$raa."' AND parent_tag_id=1189") );
							if($isRaag!="1"){
								$remark['raag'][]="Enter valid raag for ".$raa."!";
							}
						}
					}
				}
				$taal_var=$taal[$pId];
				if($taal_var){
					$taalArr=explode(",",$taal_var);
					if(sizeof($taalArr)>0){
						foreach($taalArr as $taa){
							$isTaal=$oTag->getTotalCount( array("where"=>"AND tag_name='".$taa."' AND parent_tag_id=1383") );
							if($isTaal!="1"){
								$remark['taal'][]="Enter valid taal for ".$taa."!";
							}
						}
					}
				}
				$time_of_day_var=$time_of_day[$pId];
				if($time_of_day_var){
					$todArr=explode(",",$time_of_day_var);
					if(sizeof($todArr)>0){
						foreach($todArr as $tod){
							$isTod=$oTag->getTotalCount( array("where"=>"AND tag_name='".$tod."' AND parent_tag_id=1415") );
							if($isTod!="1"){
								$remark['time_of_day'][]="Enter valid time of the day for ".$tod."!";
							}
						}
					}
				}
				$religion_var=$religion[$pId];
				if($religion_var){
					$relArr=explode(",",$religion_var);
					if(sizeof($relArr)>0){
						foreach($relArr as $rel){
							$isRel=$oTag->getTotalCount( array("where"=>"AND tag_name='".$rel."' AND parent_tag_id=498") );
							if($isRel!="1"){
								$remark['religion'][]="Enter valid religion for ".$rel."! ";
							}
						}
					}
				}
				$saint_var=$saint[$pId];	
				if($saint_var){
					$saintArr=explode(",",$saint_var);
					if(sizeof($saintArr)>0){
						foreach($saintArr as $st){
							$isSaint=$oTag->getTotalCount( array("where"=>"AND tag_name='".$st."' AND parent_tag_id=506") );
							if($isRel!="1"){
								$remark['saint'][]="Enter valid saint for ".$st."!";
							}
						}
					}
				}
				$instrument_var=$instrument[$pId];
				if($instrument_var){
					$intArr=explode(",",$instrument_var);
					if(sizeof($intArr)>0){
						foreach($intArr as $int){
							$isInt=$oTag->getTotalCount( array("where"=>"AND tag_name='".$int."' AND parent_tag_id=1424") );
							if($isInt!="1"){
								$remark['instrument'][]="Enter valid instrument for ".$int."!";
							}
						}
					}
				}
				$festival_var=$festival[$pId];
				if($festival_var){
					$festArr=explode(",",$festival_var);
					if(sizeof($festArr)>0){
						foreach($festArr as $fest){
							$isFest=$oTag->getTotalCount( array("where"=>"AND tag_name='".$fest."' AND parent_tag_id=29") );
							if($isFest!="1"){
								$remark['festival'][]="Enter valid festival for ".$fest."!";
							}
						}
					}
				}
				$occasion_var=$occasion[$pId];
				if($occasion_var){
					$occArr=explode(",",$occasion_var);
					if(sizeof($occArr)>0){
						foreach($occArr as $occ){
							$isOcc=$oTag->getTotalCount( array("where"=>"AND tag_name='".$occ."' AND parent_tag_id=487") );
							if($isOcc!="1"){
								$remark['occasion'][]="Enter valid occasion for ".$occ."!";
							}
						}
					}
				}
				$remarkArr=$remark;
				$remark=json_encode($remark);
				$status=0;
				if(empty($remarkArr)){
					$status=1;
				}
				$params=NULL;
				$params = array(
							"song_isrc"=>$song_isrc_var,
							"video_title"=>$video_title_var,
							"video_language"=>$video_language_var,
							"release_date" =>$release_date_var,
							"video_duration"=>$video_duration_var,
							"subject_parody"=>$subject_parody_var,
							"album_name"=>$album_name_var,
							"singer"=>$singer_var,
							"director"=>$director_var,
							"lyricist"=>$lyricist_var,
							"starcast"=>$starcast_var,
							"mimicked_star"=>$mimicked_star_var,
							"version"=>$version_var,
							"genre"=>$genre_var,
							"mood"=>$mood_var,
							"relationship"=>$relationship_var,
							"raag"=>$raag_var,
							"taal"=>$taal_var,
							"time_of_day"=>$time_of_day_var,
							"religion"=>$religion_var,
							"saint"=>$saint_var,
							"instrument"=>$instrument_var,
							"festival"=>$festival_var,
							"occasion"=>$occasion_var,
							"video_file_path"=>$video_file_path_var,
							"image_file_path"=>$image_file_path_var,
							"batch_id" => $batch_id,
							"remark"=>$remark,
							"id" => $pId,
							"status" => $status,
					);
					$res = $oVideo->saveTempBulk($params);
			}
		}
		header('location:'.SITEPATH.'videobulk?action=edit&bid='.$batch_id);
		exit;
	}
	if(!empty($_POST) && $_POST['gotodb']){
		$song_isrc=($_POST['song_isrc']);
		$video_title=($_POST['video_title']);
		$video_language=($_POST['video_language']);
		$release_date =($_POST['release_date']);
		$video_duration=($_POST['video_duration']);
		$subject_parody=($_POST['subject_parody']);
		$album_name=($_POST['album_name']);
		$singer=($_POST['singer']);
		$director=($_POST['director']);
		$lyricist=($_POST['lyricist']);
		$starcast=($_POST['starcast']);
		$mimicked_star=($_POST['mimicked_star']);
		$version=($_POST['version']);
		$genre=($_POST['genre']);
		$mood=($_POST['mood']);
		$relationship=($_POST['relationship']);
		$raag=($_POST['raag']);
		$taal=($_POST['taal']);
		$time_of_day=($_POST['time_of_day']);
		$religion=($_POST['religion']);
		$saint=($_POST['saint']);
		$instrument=($_POST['instrument']);
		$festival=($_POST['festival']);
		$occasion=($_POST['occasion']);
		$video_file_path=($_POST['video_file_path']);
		$image_file_path=($_POST['image_file_path']);
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
				$videoValidPath=0;
				$imageValidPath=0;
				$video_file_path_var=$video_file_path[$pId];
				if(file_exists(MEDIA_SERVERPATH_TEMPFTP.$video_file_path_var)){
					$videoValidPath=1;
				}else{
					$remark['video_file_path']="Enter valid video file path!";					
				}
				$image_file_path_var=$image_file_path[$pId];
				if(file_exists(MEDIA_SERVERPATH_TEMPFTP.$image_file_path_var)){
					$imageValidPath=1;
				}else{
					$remark['image_file_path']="Enter valid image file path!";					
				}	
				$release_date_var =$release_date[$pId];
				$video_duration_var=$video_duration[$pId];
				$subject_parody_var=$subject_parody[$pId];
				$song_isrc_var=$song_isrc[$pId];
				if($song_isrc_var){
					$isIsrcExit= $oSong->getAllSongs( array("where"=>"AND isrc='".$song_isrc_var."'") );
					if($isIsrcExit[0]->song_id>0){
						$song_id=$isIsrcExit[0]->song_id;
					}else{
						$remark['song_isrc']="Enter valid song ISRC!";
					}
				}
				$video_title_var=$video_title[$pId];
				if($video_title_var==""){
					$remark['video_title']="Enter video title!";
				}
				$video_language_var=$video_language[$pId];
				if($video_language_var==""){
					$remark['video_language']="Enter video language!";
				}
				if($video_language_var){
					$isLang=$oLanguage->getAllLanguages( array("where"=>"AND language_name='".$video_language_var."'") );
					if($isLang[0]->language_id>0){
						$language_id=$isLang[0]->language_id;
					}else{
						$remark['video_language']="Enter valid language!";
					}
				}
				$release_date_var=$release_date[$pId];
				if($release_date_var){
					$release_date_var=date("Y-m-d",strtotime($release_date_var));
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
				$singer_var=$singer[$pId];
				if($singer_var==""){
					$remark['singer'][]="Enter singer!";
				}
				$artistRoleKeyArray=array();
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
								$artistRoleKeyArray[$isSinger[0]->artist_id]=$aConfig['artist_type']['Singer'];								
							}else{
								$remark['singer'][]="Enter valid singer name for ".$sing."!";
							}
						}
					}
				}
				$director_var=$director[$pId];
				if($director_var){
					$mdArr=explode(",",$director_var);
					$mdirectorHiddenArr=array();
					if(sizeof($mdArr)>0){
						foreach($mdArr as $md){
							$md_Arr=explode("(",$md);
							$dob=@str_replace(")","",$md_Arr[1]);
							$md_chk=@trim($md_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isMdir=$oArtist->getAllArtists( array("where"=>"AND artist_name='".$md_chk."'".$query) );
							if($isMdir[0]->artist_id>0){
								$mdirectorHiddenArr[]=$isMdir[0]->artist_id;
								$roleStr="";
								if($artistRoleKeyArray[$isMdir[0]->artist_id]){
									$roleStr=$artistRoleKeyArray[$isMdir[0]->artist_id]."|";
								}
								$artistRoleKeyArray[$isMdir[0]->artist_id]=$roleStr.$aConfig['artist_type']['Director'];
							}else{
								$remark['director'][]="Enter valid director name for ".$md."!";								
							}
						}
					}
				}
				$lyricist_var=$lyricist[$pId];
				if($lyricist_var){
					$lyrArr=explode(",",$lyricist_var);
					$lyricistHiddenArr=array();
					if(sizeof($lyrArr)>0){
						foreach($lyrArr as $lyr){
							$lyr_Arr=explode("(",$lyr);
							$dob=@str_replace(")","",$lyr_Arr[1]);
							$lyr_chk=@trim($lyr_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isLyr=$oArtist->getAllArtists( array("where"=>"AND artist_name='".$lyr_chk."'".$query) );
							if($isLyr[0]->artist_id>0){
								$lyricistHiddenArr[]=$isLyr[0]->artist_id;								
								$roleStr="";
								if($artistRoleKeyArray[$isLyr[0]->artist_id]){
									$roleStr=$artistRoleKeyArray[$isLyr[0]->artist_id]."|";
								}
								$artistRoleKeyArray[$isLyr[0]->artist_id]=$roleStr.$aConfig['artist_type']['Lyricist'];
							}else{
								$remark['lyricist'][]="Enter valid lyricist name for ".$lyr."!";
							}
						}
					}
				}
				$starcast_var=$starcast[$pId];
				if($starcast_var==""){
					$remark['starcast'][]="Enter starcast!";
				}
				if($starcast_var){
					$starcastArr=explode(",",$starcast_var);
					$starcastHiddenArr=array();
					if(sizeof($starcastArr)>0){
						foreach($starcastArr as $star){
							$star_Arr=explode("(",$star);
							$dob=@str_replace(")","",$star_Arr[1]);
							$star_chk=@trim($star_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isStar=$oArtist->getAllArtists( array("where"=>"AND artist_name='".$star_chk."'".$query) );
							if($isStar[0]->artist_id>0){
								$starcastHiddenArr[]=$isStar[0]->artist_id;
								$roleStr="";
								if($artistRoleKeyArray[$isStar[0]->artist_id]){
									$roleStr=$artistRoleKeyArray[$isStar[0]->artist_id]."|";
								}
								$artistRoleKeyArray[$isStar[0]->artist_id]=$roleStr.$aConfig['artist_type']['Starcast'];
							}else{
								$remark['starcast'][]="Enter valid starcast name for ".$star."!";								
							}
						}
					}
				}
				$mimicked_star_var=$mimicked_star[$pId];
				if($mimicked_star_var){
					$mStarArr=explode(",",$mimicked_star_var);
					$mstarcastHiddenArr=array();
					if(sizeof($mStarArr)>0){
						foreach($mStarArr as $mstar){
							$mstar_Arr=explode("(",$mstar);
							$dob=@str_replace(")","",$mstar_Arr[1]);
							$mstar_chk=@trim($mstar_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isMstar=$oArtist->getAllArtists( array("where"=>"AND artist_name='".$mstar_chk."'".$query) );
							if($isMstar[0]->artist_id>0){
								$mstarcastHiddenArr[]=$isMstar[0]->artist_id;
								$roleStr="";
								if($artistRoleKeyArray[$isMstar[0]->artist_id]){
									$roleStr=$artistRoleKeyArray[$isMstar[0]->artist_id]."|";
								}
								$artistRoleKeyArray[$isMstar[0]->artist_id]=$roleStr.$aConfig['artist_type']['Mimicked Star'];
							}else{
								$remark['mimicked_star'][]="Enter valid mimicked star name for ".$mstar."!";								
							}
						}
					}
				}
				$version_var=$version[$pId];
				if($version_var==""){
					$remark['version'][]="Enter version!";
				}
				$versionHiddenArr=array();
				if($version_var){
					$versionArr=explode(",",$version_var);
					if(sizeof($versionArr)>0){
						foreach($versionArr as $ver){
							$isVar=$oTag->getAllTags( array("where"=>"AND tag_name='".$ver."' AND parent_tag_id=1889") );
							$aKey=array_keys($isVar);
							if($isVar[$aKey[0]]->tag_id>0){
								$versionHiddenArr[]=$isVar[$aKey[0]]->tag_id;	
							}else{
								$remark['version'][]="Enter valid version for ".$ver."!";
							}
						}
					}
				}
				$genre_var=$genre[$pId];
				if($genre_var){
					$genreArr=explode(",",$genre_var);
					$genreHiddenArr=array();
					if(sizeof($genreArr)>0){
						foreach($genreArr as $gen){
							$isGen=$oTag->getAllTags( array("where"=>"AND tag_name='".$gen."' AND parent_tag_id=1688") );
							$aKey=array_keys($isGen);
							if($isGen[$aKey[0]]->tag_id>0){
								$genreHiddenArr[]=$isGen[$aKey[0]]->tag_id;
							}else{
								$remark['genre'][]="Enter valid genre for ".$gen."!";
							}
						}
					}
				}
				$mood_var=$mood[$pId];
				if($mood_var){
					$moodArr=explode(",",$mood_var);
					$moodHiddenArr=array();
					if(sizeof($moodArr)>0){
						foreach($moodArr as $moo){
							$isMood=$oTag->getAllTags( array("where"=>"AND tag_name='".$moo."' AND parent_tag_id=1") );
							$aKey=array_keys($isMood);
							if($isMood[$aKey[0]]->tag_id>0){
								$moodHiddenArr[]=$isMood[$aKey[0]]->tag_id;
							}else{
								$remark['mood'][]="Enter valid mood for ".$moo."!";
							}
						}
					}
				}
				$relationship_var=$relationship[$pId];
				if($relationship_var){
					$relArr=explode(",",$relationship_var);
					$relationHiddenArr=array();
					if(sizeof($relArr)>0){
						foreach($relArr as $rel){
							$isRel=$oTag->getAllTags( array("where"=>"AND tag_name='".$rel."' AND parent_tag_id=16") );
							$aKey=array_keys($isRel);
							if($isRel[$aKey[0]]->tag_id>0){
								$relationHiddenArr[]=$isRel[$aKey[0]]->tag_id;
							}else{
								$remark['relationship'][]="Enter valid relationship for ".$rel."!";								
							}
						}
					}
				}
				$raag_var=$raag[$pId];
				if($raag_var){
					$raagArr=explode(",",$raag_var);
					$raagHiddenArr=array();
					if(sizeof($raagArr)>0){
						foreach($raagArr as $raa){
							$isRaag=$oTag->getAllTags( array("where"=>"AND tag_name='".$raa."' AND parent_tag_id=1189") );
							$aKey=array_keys($isRaag);
							if($isRaag[$aKey[0]]->tag_id>0){
								$raagHiddenArr[]=$isRaag[$aKey[0]]->tag_id;
							}else{
								$remark['raag'][]="Enter valid raag for ".$raa."!";
							}
						}
					}
				}
				$taal_var=$taal[$pId];
				if($taal_var){
					$taalArr=explode(",",$taal_var);
					$taalHiddenArr=array();
					if(sizeof($taalArr)>0){
						foreach($taalArr as $taa){
							$isTaal=$oTag->getAllTags( array("where"=>"AND tag_name='".$taa."' AND parent_tag_id=1383") );
							$aKey=array_keys($isTaal);
							if($isTaal[$aKey[0]]->tag_id>0){
								$taalHiddenArr[]=$isTaal[$aKey[0]]->tag_id;
							}else{
								$remark['taal'][]="Enter valid taal for ".$taa."!";
							}
						}
					}
				}
				$time_of_day_var=$time_of_day[$pId];
				if($time_of_day_var){
					$todArr=explode(",",$time_of_day_var);
					$todHiddenArr=array();
					if(sizeof($todArr)>0){
						foreach($todArr as $tod){
							$isTod=$oTag->getAllTags( array("where"=>"AND tag_name='".$tod."' AND parent_tag_id=1415") );
							$aKey=array_keys($isTod);
							if($isTod[$aKey[0]]->tag_id>0){
								$todHiddenArr[]=$isTod[$aKey[0]]->tag_id;
							}else{
								$remark['time_of_day'][]="Enter valid time of day for ".$tod."!";
							}
						}
					}
				}
				$religion_var=$religion[$pId];
				if($religion_var){
					$relArr=explode(",",$religion_var);
					if(sizeof($relArr)>0){
						$relHiddenArr=array();
						foreach($relArr as $rel){
							$isRel=$oTag->getAllTags( array("where"=>"AND tag_name='".$rel."' AND parent_tag_id=498") );
							$aKey=array_keys($isRel);
							if($isRel[$aKey[0]]->tag_id>0){
								$relHiddenArr[]=$isRel[$aKey[0]]->tag_id;
							}else{
								$remark['religion'][]="Enter valid religion for ".$rel."! ";
							}
						}
					}
				}
				$saint_var=$saint[$pId];	
				if($saint_var){
					$saintArr=explode(",",$saint_var);
					if(sizeof($saintArr)>0){
						$saintHiddenArr=array();
						foreach($saintArr as $st){
							$isSaint=$oTag->getAllTags( array("where"=>"AND tag_name='".$st."' AND parent_tag_id=506") );
							$aKey=array_keys($isSaint);
							if($isSaint[$aKey[0]]->tag_id>0){
								$saintHiddenArr[]=$isSaint[$aKey[0]]->tag_id;
							}else{
								$remark['saint'][]="Enter valid saint for ".$st."!";
							}
						}
					}
				}
				$instrument_var=$instrument[$pId];
				if($instrument_var){
					$intArr=explode(",",$instrument_var);
					if(sizeof($intArr)>0){
						$intHiddenArr=array();
						foreach($intArr as $int){
							$isInt=$oTag->getAllTags( array("where"=>"AND tag_name='".$int."' AND parent_tag_id=1424") );
							$aKey=array_keys($isInt);
							if($isInt[$aKey[0]]->tag_id>0){
								$intHiddenArr[]=$isInt[$aKey[0]]->tag_id;
							}else{
								$remark['instrument'][]="Enter valid instrument for ".$int."!";
							}
						}
					}
				}
				$festival_var=$festival[$pId];
				if($festival_var){
					$festArr=explode(",",$festival_var);
					$festHiddenArr=array();
					if(sizeof($festArr)>0){
						foreach($festArr as $fest){
							$isFest=$oTag->getAllTags( array("where"=>"AND tag_name='".$fest."' AND parent_tag_id=29") );
							$aKey=array_keys($isFest);
							if($isFest[$aKey[0]]->tag_id>0){
								$festHiddenArr[]=$isFest[$aKey[0]]->tag_id;
							}else{
								$remark['festival'][]="Enter valid festival for ".$fest."!";
							}
						}
					}
				}
				$occasion_var=$occasion[$pId];
				if($occasion_var){
					$occArr=explode(",",$occasion_var);
					$occasionHiddenArr=array();
					if(sizeof($occArr)>0){
						foreach($occArr as $occ){
							$isOcc=$oTag->getAllTags( array("where"=>"AND tag_name='".$occ."' AND parent_tag_id=487") );
							$aKey=array_keys($isOcc);
							if($isOcc[$aKey[0]]->tag_id>0){
								$occasionHiddenArr[]=$isOcc[$aKey[0]]->tag_id;
							}else{
								$remark['occasion'][]="Enter valid occasion for ".$occ."!";
							}
						}
					}
				}
				if($imageValidPath==1){
					$sourcePath=MEDIA_SERVERPATH_TEMPFTP.$image_file_path_var;
					$pathinfo=pathinfo($sourcePath);
					$fExt=$pathinfo['extension'];
					$cleanFileName	= TOOLS::cleanFileName($pathinfo['filename'], true);
					$sNewDirPath 	= TOOLS::getImagePath($cleanFileName);
					$fileName=$sNewDirPath.$cleanFileName.".".$fExt;
					$destinationPath=MEDIA_SEVERPATH_IMAGE.$sNewDirPath.$cleanFileName.".".$fExt;
					tools::createDir($destinationPath);
					if(!file_exists($destinationPath)){
						if(copy($sourcePath,$destinationPath)){
								$params = array(
									'imageName' 	=> $video_title_var, 
									'imageDesc' 	=> "", 
									'imageType' 	=> 1, 
									'imageFile'     => $fileName,
									'status' 		=> 1, 
								  );
								$aImg = $oImage->saveImage( $params );
						}else{
							$remark['image_file_path']="Error in copy image file";
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
							"song_isrc"=>$song_isrc_var,
							"video_title"=>$video_title_var,
							"video_language"=>$video_language_var,
							"release_date" =>$release_date_var,
							"video_duration"=>$video_duration_var,
							"subject_parody"=>$subject_parody_var,
							"album_name"=>$album_name_var,
							"singer"=>$singer_var,
							"director"=>$director_var,
							"lyricist"=>$lyricist_var,
							"starcast"=>$starcast_var,
							"mimicked_star"=>$mimicked_star_var,
							"version"=>$version_var,
							"genre"=>$genre_var,
							"mood"=>$mood_var,
							"relationship"=>$relationship_var,
							"raag"=>$raag_var,
							"taal"=>$taal_var,
							"time_of_day"=>$time_of_day_var,
							"religion"=>$religion_var,
							"saint"=>$saint_var,
							"instrument"=>$instrument_var,
							"festival"=>$festival_var,
							"occasion"=>$occasion_var,
							"video_file_path"=>$video_file_path_var,
							"image_file_path"=>$image_file_path_var,
							"batch_id" => $batch_id,
							"remark"=>$remark,
							"id" => $pId,
							"status" => $status,
					);
					$res = $oVideo->saveTempBulk($params);
					if($status==1){//final move to song_mstr
						$postData=array(
							'videoName'=>$video_title_var,
							'status'=>0,
							'languageIds'=>$language_id,
							'releaseDate'=>$release_date_var,
							'videoDuration' => $video_duration_var,
							'subjectParody' => $subject_parody_var,
							'albumId' => $album_id,
							'songId' => $song_id,
							'image'      => $fileName,
						);
						$aData = $oVideo->saveVideo( $postData );
						if($aData){
							$logMsg="Created video.";
							if($artistRoleKeyArray){ 
								$oData=$oVideo->mapArtistVideo(array('videoId'=>(int)$aData,'artistRoleKeyArray'=>$artistRoleKeyArray));					
							}
							$tagIds=array_merge((array)$versionHiddenArr,(array)$genreHiddenArr,(array)$moodHiddenArr,(array)$relationHiddenArr,(array)$raagHiddenArr,(array)$taalHiddenArr,(array)$todHiddenArr,(array)$relHiddenArr,(array)$saintHiddenArr,(array)$intHiddenArr,(array)$festHiddenArr,(array)$occasionHiddenArr);
							if($tagIds){
								$tData=$oVideo->mapTagVideo(array('videoId'=>(int)$aData,'tagIds'=>$tagIds));
							}
							if($album_id){
								$lData=$oVideo->mapAlbumVideo(array('videoId'=>(int)$aData,'albumIds'=>array($album_id)));
							}
							if($song_id){
								$sData=$oVideo->mapSongVideo(array('videoId'=>(int)$aData,'songKeyArray'=>array($song_id)));
							}
							if($aImg){
								$oData=$oImage->mapVideoImage(array('imageId'=>$aImg,'videoIds'=>array($aData)));
								$oAlbData=$oImage->mapAlbumImage(array('imageId'=>$aImg,'albumIds'=>array($album_id)));
							}
							if($videoValidPath==1){
								$sourcePath=MEDIA_SERVERPATH_TEMPFTP.$video_file_path_var;
								$pathinfo=pathinfo($sourcePath);
								$fExt=$pathinfo['extension'];
								$fileToSave=tools::getVideoPathByTitle($video_title_var,$fExt,$aData);
								$destinationPath=MEDIA_SERVERPATH_VIDEORAW."/".$fileToSave;
								tools::createDir($destinationPath);
								if(file_exists($sourcePath)){
									if(copy($sourcePath,$destinationPath)){
										$uData=$oVideo->upVideoFilePath(array('videoId'=>(int)$aData,'videoFilePath'=>$fileToSave));	
									}else{
										$remark['video_file_path']="Error in copy file";
									}
								}else{
									$remark['video_file_path']="Enter valid file path!";
								}	
							}
							$aLogParam = array(
								'moduleName' => 'video',
								'action' => "add",
								'moduleId' => 15,
								'editorId' => $this->user->user_id,
								'remark'	=>	$logMsg.' (ID-'.(int)$aData.')',
								'content_ids' => (int)$aData
							);
							TOOLS::writeActivityLog( $aLogParam );	
							$oVideo->updateGoToDbBulk(array('id'=>$pId));
						}
					}
			}
			$msg="";
			if(!in_array(0,$statusArr)){
				#$oVideo->updateGoToDbBulk(array('batch_id'=>$batch_id));
				$msg="&msg=Action completed successfully!";
			}
		}
		header('location:'.SITEPATH.'videobulk?action=edit&bid='.$batch_id.$msg);
		exit;
	}
	$params = array(
				'start' => 0, 
				'limit' => 10000, 
				'where' => ' AND batch_id="'.$batch_id.'"', 
			  ); 
	$aSongData = $oVideo->getAllBulkVideos( $params );
	$data['aContent']=$aSongData;
}else{
	$view = 'videobulk_list';
	$lisData = getlist( $oVideo ,$this);
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
}
function getlist( $oVideo,$users=NULL){
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
	
	$data['aContent'] = $oVideo->getAllBulkVideos( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oVideo->getTotalBulkCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "videobulk?action=view&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}	
/* render view */
$oCms->view( $view, $data );