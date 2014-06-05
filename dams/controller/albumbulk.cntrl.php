<?php //song bulk upload                  
#error_reporting(E_ALL);
#ini_set("display_errors",1);
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit','5120M');
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
$oLanguage = new language();
$oAlbum = new album();
$oArtist = new artist();
$oTag = new tags();
$oLabel = new label();
$oCatalogue=new catalogue();
$oBanner=new banner();
$oImage=new image();
$action = cms::sanitizeVariable( $_GET['action'] );
$do		= cms::sanitizeVariable( $_GET['do'] );
global $aConfig;
$albumTypeArray=array("film","non-film","compile");
$id = (int)$_GET['id']; 
if($action=="add"){
	$view = 'albumbulk_form';
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
				$album_name=cms::sanitizeVariable($csv_line[0]);
				$catalogue=cms::sanitizeVariable($csv_line[1]);
				$language=cms::sanitizeVariable($csv_line[2]);
				$label=cms::sanitizeVariable($csv_line[3]);
				$content_type=cms::sanitizeVariable($csv_line[4]);
				$title_release_date=cms::sanitizeVariable($csv_line[5]);
				$music_release_date=cms::sanitizeVariable($csv_line[6]);
				$banner=cms::sanitizeVariable($csv_line[7]);
				$primary_artist=cms::sanitizeVariable($csv_line[8]);
				$starcast=cms::sanitizeVariable($csv_line[9]);
				$director=cms::sanitizeVariable($csv_line[10]);
				$producer=cms::sanitizeVariable($csv_line[11]);
				$writer=cms::sanitizeVariable($csv_line[12]);
				$lyricist=cms::sanitizeVariable($csv_line[13]);
				$music_director=cms::sanitizeVariable($csv_line[14]);
				$album_type=cms::sanitizeVariable($csv_line[15]);
				$album_description=cms::sanitizeVariable($csv_line[16]);
				$coupling_ids=cms::sanitizeVariable($csv_line[17]);
				$tv_channel=cms::sanitizeVariable($csv_line[18]);
				$radio_station=cms::sanitizeVariable($csv_line[19]);
				$show_name=cms::sanitizeVariable($csv_line[20]);
				$year_broadcast=cms::sanitizeVariable($csv_line[21]);
				$grade=cms::sanitizeVariable($csv_line[22]);
				$film_rating=cms::sanitizeVariable($csv_line[23]);
				$artwork_file_path=cms::sanitizeVariable($csv_line[24]);
				$status=0;
				if(!file_exists(MEDIA_READ_SERVERPATH_TEMPFTP.$artwork_file_path)){
					$remark['artwork_file_path']="Enter valid file path!";
				}
				if($album_name==""){
					$remark['album_name']="Album Name is required!";
				}
				if($catalogue==""){
					$remark['catalogue']="Enter catalogue!";
				}
				if($catalogue){
					$isCatalogue= $oCatalogue->getTotalCount( array("where"=>"AND catalogue_name='".$catalogue."'") );
					if($isCatalogue!=1){
						$remark['catalogue']="Enter valid catalogue!";
					}
				}
				if($language==""){
					$remark['language']="Enter language!";
				}
				if($language){
					$isLang=$oLanguage->getTotalCount( array("where"=>"AND language_name='".$language."'") );
					if($isLang!="1"){
						$remark['language']="Enter valid language!";
					}
				}
				if($label==""){
					$remark['label']="Enter label!";
				}
				if($label){
					$isLabel=$oLabel->getTotalCount( array("where"=>"AND label_name='".$label."'") );
					if($isLabel!="1"){
						$remark['label']="Enter valid label!";
					}
				}
				if($content_type==""){
					$remark['content_type']="Enter content type!";
				}
				if($content_type){
					if(!in_array(ucfirst($content_type),$aConfig['album_content_type'])){
						$remark['content_type']="Enter valid content type!";
					}
				}
				if($title_release_date){
					$title_release_date=date("Y-m-d",strtotime($title_release_date));
				}
				if($music_release_date==""){
					$remark['music_release_date']="Enter music release date!";
				}
				if($music_release_date){
					$music_release_date=date("Y-m-d",strtotime($music_release_date));
				}
				if($album_name){
					$album_release_date=$music_release_date;
					$query="";
					$album_name_chk=$album_name;
					if($album_release_date && $album_release_date!="0000-00-00"){
						$album_release_date=date("Y-m-d",strtotime($album_release_date));
						$query=" AND music_release_date='".$album_release_date."'";
					}
					$isAlbum=$oAlbum->getTotalCount( array("where"=>"AND album_name='".$album_name_chk."' ".$query) );	
					if($isAlbum>0){
						$remark['album_name']="Enter valid album name!";
					}
				}
				if($album_type==""){
					$remark['album_type'][]="Enter album type!";
				}
				$f==2;
				$album_type_var=$album_type;
				if($album_type_var){
					$albumTypeStr="2|";
					$albumTypeArr=explode(",",$album_type_var);						
					if(sizeof($albumTypeArr)>0){
						foreach($albumTypeArr as $at){
							if(in_array(strtolower($at),$albumTypeArray)){
								if(strtolower($at)=='film'){
									$f=1;
								}
							}else{
								$remark['album_type'][]="Enter valid album type for ".$at."!";
							}
						}
					}
				}
				if($banner==""  && $f==1){
					$remark['banner'][]="Enter banner!";
				}
				if($banner){
					$bannerArr=explode(",",$banner);
					if(sizeof($bannerArr)>0){
						foreach($bannerArr as $ban){
							$isBanner= $oBanner->getTotalCount( array("where"=>"AND banner_name='".$ban."'") );
							if($isBanner!=1){
								$remark['banner'][]="Enter valid banner name for ".$ban."!";
							}
						}
					}		
				}
				if(primary_artist){
					$primary_artist_Arr=explode("(",$primary_artist);
					$dob=@str_replace(")","",$primary_artist_Arr[1]);
					$primary_artist_chk=@trim($primary_artist_Arr[0]);
					$query="";
					if($dob && $dob!="0000-00-00"){
						$dob=date("Y-m-d",strtotime($dob));
						$query=" AND artist_dob='".$dob."'";
					}
					$isPrimaryArtist=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$primary_artist_chk."'".$query) );
					if($isPrimaryArtist!="1"){
						$remark['primary_artist']="Enter valid primary_artist name for ".$primary_artist."!";
					}
				}
				if($starcast==""  && $f==1){
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
				if($director==""  && $f==1){
					$remark['director'][]="Enter director!";
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
								$remark['director'][]="Enter valid director name for ".$md."!";
							}
						}
					}
				}
				if($producer==""  && $f==1){
					$remark['producer'][]="Enter producer!";
				}
				if($producer){
					$prodArr=explode(",",$producer);
					if(sizeof($prodArr)>0){
						foreach($prodArr as $prod){
							$prod_Arr=explode("(",$prod);
							$dob=@str_replace(")","",$prod_Arr[1]);
							$prod_chk=@trim($prod_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isProd=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$prod_chk."'".$query) );
							if($isProd!="1"){
								$remark['producer'][]="Enter valid producer name for ".$prod."!";
							}
						}
					}
				}
				if($writer){
					$wriArr=explode(",",$writer);
					if(sizeof($wriArr)>0){
						foreach($wriArr as $wri){
							$wri_Arr=explode("(",$wri);
							$dob=@str_replace(")","",$wri_Arr[1]);
							$wri_chk=@trim($wri_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isWri=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$wri_chk."'".$query) );
							if($isWri!="1"){
								$remark['writer'][]="Enter valid writer name for ".$wri."!";
							}
						}
					}
				}
				if($music_director){
					$mdArr=explode(",",$music_director);
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
								$remark['music_director'][]="Enter valid music director name for ".$md."!";
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
				if($album_description==""){
					$remark['album_description']="Enter album description!";
				}
				if($tv_channel){
					$tv_channelArr=explode(",",$tv_channel);
					if(sizeof($tv_channelArr)>0){
						foreach($tv_channelArr as $tv){
							$isTv=$oTag->getTotalCount( array("where"=>"AND tag_name='".$tv."' AND parent_tag_id=1466") );
							if($isTv!="1"){
								$remark['tv_channel'][]="Enter valid tv channel for ".$tv."!";
							}
						}
					}
				}
				if($radio_station){
					$radio_stationArr=explode(",",$radio_station);
					if(sizeof($radio_stationArr)>0){
						foreach($radio_stationArr as $rs){
							$isVar=$oTag->getTotalCount( array("where"=>"AND tag_name='".$rs."' AND parent_tag_id=1635") );
							if($isVar!="1"){
								$remark['genre'][]="Enter valid radio station for ".$rs."!";
							}
						}
					}
				}
				if($year_broadcast){
					$year_broadcast=date("Y",strtotime($year_broadcast));
				}
				if($grade==""){
					$remark['grade']="Enter grade!";
				}
				if($grade){
					if(!in_array($grade,$aConfig['grade'])){
						$remark['grade']="Enter valid grade!";
					}
				}
				if($film_rating){
					if(!in_array($film_rating,$aConfig['film_rating'])){
						$remark['film_rating']="Enter valid film rating!";
					}
				}

				$remark=json_encode($remark);
				$params=NULL;
				$params = array(
							"album_name"=>$album_name,
							"catalogue"=>$catalogue,
							"language"=>$language,
							"label" =>$label,
							"content_type"=>$content_type,
							"title_release_date"=>$title_release_date,
							"music_release_date"=>$music_release_date,
							"banner"=>$banner,
							"primary_artist"=>$primary_artist,
							"starcast"=>$starcast,
							"director"=>$director,
							"producer"=>$producer,
							"writer"=>$writer,
							"music_director"=>$music_director,
							"lyricist"=>$lyricist,							
							"album_type"=>$album_type,
							"album_description"=>$album_description,
							"coupling_ids"=>$coupling_ids,
							"tv_channel"=>$tv_channel,
							"radio_station"=>$radio_station,
							"show_name"=>$show_name,
							"year_broadcast"=>$year_broadcast,
							"grade"=>$grade,
							"film_rating"=>$film_rating,
							"artwork_file_path"=>$artwork_file_path,
							"status"=>$status,
							"batch_id" => $batchId,
							"remarks"=>$remark,
					);
					$res = $oAlbum->saveTempBulk($params);
			}
			$aLogParam = array(
				'moduleName' => 'album bulk',
				'action' => 'add',
				'moduleId' => 18,
				'editorId' => $this->user->user_id,
				'remark'	=>	'Uploaded album in bulk (Batch ID-'.$batchId.')',
				'content_ids' => $batchId
			);
			TOOLS::writeActivityLog( $aLogParam );
			header('location:'.SITEPATH.'albumbulk?action=edit&bid='.$batchId);
			exit;
		}else{
			$aError=$aError;
			$data['aError']=$aError;
		}
	}
}elseif($action=="edit"){
	$view="albumbulk_manage";
	$batch_id=cms::sanitizeVariable($_GET['bid']);
	if(!empty($_POST) && $_POST['submitBtn']){
		$album_name=($_POST['album_name']);
		$catalogue=($_POST['catalogue']);
		$language=($_POST['language']);
		$label=($_POST['label']);
		$content_type=$_POST['content_type'];
		$title_release_date=($_POST['title_release_date']);
		$music_release_date=($_POST['music_release_date']);
		$banner=$_POST['banner'];
		$primary_artist=($_POST['primary_artist']);
		$starcast=($_POST['starcast']);
		$director=($_POST['director']);
		$producer=($_POST['producer']);
		$writer=($_POST['writer']);
		$lyricist=($_POST['lyricist']);
		$music_director=($_POST['music_director']);
		$album_type=($_POST['album_type']);
		$album_description=($_POST['album_description']);
		$coupling_ids=($_POST['coupling_ids']);
		$tv_channel=($_POST['tv_channel']);
		$radio_station=($_POST['radio_station']);
		$show_name=($_POST['show_name']);
		$year_broadcast=($_POST['year_broadcast']);
		$grade=($_POST['grade']);
		$film_rating=($_POST['film_rating']);
		$file_path=($_POST['artwork_file_path']);
		$primaryId = $_POST['primaryId'];
		$batch_id = ($_POST['batch_id']);
		if(!empty($primaryId)){
			foreach($primaryId as $pId){
				$remark=array();
				$validPath=0;
				$file_path_var=$file_path[$pId];
				if(!file_exists(MEDIA_READ_SERVERPATH_TEMPFTP.$file_path_var)){
					$remark['artwork_file_path']="Enter valid file path!";
				}else{
					$validPath=1;
				}
				$status=0;
				$f==2;
				$album_type_var=$album_type[$pId];
				if($album_type_var){
					$albumTypeStr="2|";
					$albumTypeArr=explode(",",$album_type_var);						
					if(sizeof($albumTypeArr)>0){
						foreach($albumTypeArr as $at){
							if(in_array(strtolower($at),$albumTypeArray)){
								if(strtolower($at)=='film'){
									$f=1;
								}
							}else{
								$remark['album_type'][]="Enter valid album type for ".$at."!";
							}
						}
					}
				}
				$album_name_var=$album_name[$pId];
				if($album_name_var==""){
					$remark['album_name']="Album Name is required!";
				}
				$catalogue_var=$catalogue[$pId];
				if($catalogue_var==""){
					$remark['catalogue']="Enter catalogue!";
				}
				if($catalogue_var){
					$isCatalogue= $oCatalogue->getTotalCount( array("where"=>"AND catalogue_name='".$catalogue_var."'") );
					if($isCatalogue!=1){
						$remark['catalogue']="Enter valid catalogue!";
					}
				}
				$language_var=$language[$pId];
				if($language_var==""){
					$remark['language']="Enter language!";
				}
				if($language_var){
					$isLang=$oLanguage->getTotalCount( array("where"=>"AND language_name='".$language_var."'") );
					if($isLang!="1"){
						$remark['language']="Enter valid language!";
					}
				}
				$label_var=$label[$pId];
				if($label_var){
					$isLabel=$oLabel->getTotalCount( array("where"=>"AND label_name='".$label_var."'") );
					if($isLabel!="1"){
						$remark['label']="Enter valid label!";
					}
				}
				$content_type_var=$content_type[$pId];
				if($content_type_var==""){
					$remark['content_type']="Enter content type!";
				}
				if($content_type_var){
					$content_type_Arr=explode(",",$content_type_var);
					if($content_type_Arr){
						foreach($content_type_Arr as $content_type_str){
							if(!in_array(ucfirst($content_type_str),$aConfig['album_content_type'])){
								$remark['content_type']="Enter valid content type ".$content_type_str."!";
							}
						}
					}
				}
				$title_release_date_var=$title_release_date[$pId];
				if($title_release_date_var){
					$title_release_date_var=date("Y-m-d",strtotime($title_release_date_var));
				}
				$music_release_date_var=$music_release_date[$pId];
				if($music_release_date_var==""){
					$remark['music_release_date']="Enter music release date!";
				}
				if($music_release_date_var){
					$music_release_date_var=date("Y-m-d",strtotime($music_release_date_var));
				}
				if($album_name_var){
					$album_release_date=$music_release_date_var;
					$query="";
					$album_name_chk=$album_name_var;
					if($album_release_date && $album_release_date!="0000-00-00"){
						$album_release_date=date("Y-m-d",strtotime($album_release_date));
						$query=" AND music_release_date='".$album_release_date."'";
					}
					$isAlbum=$oAlbum->getTotalCount( array("where"=>"AND album_name='".$album_name_chk."' ".$query) );	
					if($isAlbum>0){
						$remark['album_name']="Enter valid album name!";
					}
				}
				$banner_var=$banner[$pId];
				if($banner==""  && $f==1){
					$remark['banner'][]="Enter banner!";
				}
				if($banner){
					$bannerArr=explode(",",$banner_var);
					if(sizeof($bannerArr)>0){
						foreach($bannerArr as $ban){
							$isBanner= $oBanner->getTotalCount( array("where"=>"AND banner_name='".$ban."'") );
							if($isBanner!=1){
								$remark['banner'][]="Enter valid banner name for ".$ban."!";
							}
						}
					}		
				}
				$primary_artist_var=$primary_artist[$pId];
				if(primary_artist_var){
					$primary_artist_Arr=explode("(",$primary_artist_var);
					$dob=@str_replace(")","",$primary_artist_Arr[1]);
					$primary_artist_chk=@trim($primary_artist_Arr[0]);
					$query="";
					if($dob && $dob!="0000-00-00"){
						$dob=date("Y-m-d",strtotime($dob));
						$query=" AND artist_dob='".$dob."'";
					}
					$isPrimaryArtist=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$primary_artist_chk."'".$query) );
					if($isPrimaryArtist!="1"){
						$remark['primary_artist']="Enter valid primary_artist name for ".$primary_artist_var."!";
					}
				}
				$starcast_var=$starcast[$pId];
				if($starcast_var==""  && $f==1){
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
				$director_var=$director[$pId];
				if($director_var==""  && $f==1){
					$remark['director'][]="Enter director!";
				}
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
								$remark['director'][]="Enter valid director name for ".$md."!";
							}
						}
					}
				}
				$producer_var=$producer[$pId];
				if($producer_var==""  && $f==1){
					$remark['producer'][]="Enter producer!";
				}
				if($producer_var){
					$prodArr=explode(",",$producer_var);
					if(sizeof($prodArr)>0){
						foreach($prodArr as $prod){
							$prod_Arr=explode("(",$prod);
							$dob=@str_replace(")","",$prod_Arr[1]);
							$prod_chk=@trim($prod_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isProd=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$prod_chk."'".$query) );
							if($isProd!="1"){
								$remark['producer'][]="Enter valid producer name for ".$prod."!";
							}
						}
					}
				}
				$writer_var=$writer[$pId];
				if($writer_var){
					$wriArr=explode(",",$writer_var);
					if(sizeof($wriArr)>0){
						foreach($wriArr as $wri){
							$wri_Arr=explode("(",$wri);
							$dob=@str_replace(")","",$wri_Arr[1]);
							$wri_chk=@trim($wri_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isWri=$oArtist->getTotalCount( array("where"=>"AND artist_name='".$wri_chk."'".$query) );
							if($isWri!="1"){
								$remark['writer'][]="Enter valid writer name for ".$wri."!";
							}
						}
					}
				}
				$music_director_var=$music_director[$pId];
				if($music_director){
					$mdArr=explode(",",$music_director_var);
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
								$remark['music_director'][]="Enter valid music director name for ".$md."!";
							}
						}
					}
				}
				$lyricist_var=$lyricist[$pId];
				if($lyricist){
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
				$album_description_var=$album_description[$pId];
				if($album_description==""){
					$remark['album_description']="Enter album description!";
				}
				$coupling_ids_var=$coupling_ids[$pId];
				$tv_channel_var=$tv_channel[$pId];
				if($tv_channel_var){
					$tv_channelArr=explode(",",$tv_channel_var);
					if(sizeof($tv_channelArr)>0){
						foreach($tv_channelArr as $tv){
							$isTv=$oTag->getTotalCount( array("where"=>"AND tag_name='".$tv."' AND parent_tag_id=1466") );
							if($isTv!="1"){
								$remark['tv_channel'][]="Enter valid tv channel for ".$tv."!";
							}
						}
					}
				}
				$radio_station_var=$radio_station[$pId];
				if($radio_station_var){
					$radio_stationArr=explode(",",$radio_station_var);
					if(sizeof($radio_stationArr)>0){
						foreach($radio_stationArr as $rs){
							$isVar=$oTag->getTotalCount( array("where"=>"AND tag_name='".$rs."' AND parent_tag_id=1635") );
							if($isVar!="1"){
								$remark['genre'][]="Enter valid radio station for ".$rs."!";
							}
						}
					}
				}
				$year_broadcast_var=$year_broadcast[$pId];
				if($year_broadcast_var){
					$year_broadcast_var=date("Y",strtotime($year_broadcast_var));
				}
				$grade_var=$grade[$pId];
				if($grade_var==""){
					$remark['grade']="Enter grade!";
				}
				$grade_var=$grade[$pId];
				if($grade_var){
					if(!in_array($grade_var,$aConfig['grade'])){
						$remark['grade']="Enter valid grade!";
					}
				}
				$film_rating_var=$film_rating[$pId];
				if($film_rating_var){
					if(!in_array($film_rating_var,$aConfig['film_rating'])){
						$remark['film_rating']="Enter valid film rating!";
					}
				}
				$show_name_var=$show_name[$pId];
				$remarkArr=$remark;
				$remark=json_encode($remark);
				$status=0;
				if(empty($remarkArr)){
					$status=1;
				}
				$params=NULL;
				$params = array(
							"album_name"=>$album_name_var,
							"catalogue"=>$catalogue_var,
							"language"=>$language_var,
							"label" =>$label_var,
							"content_type"=>$content_type_var,
							"title_release_date"=>$title_release_date_var,
							"music_release_date"=>$music_release_date_var,
							"banner"=>$banner_var,
							"primary_artist"=>$primary_artist_var,
							"starcast"=>$starcast_var,
							"director"=>$director_var,
							"producer"=>$producer_var,
							"writer"=>$writer_var,
							"lyricist"=>$lyricist_var,
							"music_director"=>$music_director_var,
							"album_type"=>$album_type_var,
							"album_description"=>$album_description_var,
							"coupling_ids"=>$coupling_ids_var,
							"tv_channel"=>$tv_channel_var,
							"radio_station"=>$radio_station_var,
							"show_name"=>$show_name_var,
							"year_broadcast"=>$year_broadcast_var,
							"grade"=>$grade_var,
							"film_rating"=>$film_rating_var,
							"artwork_file_path"=>$file_path_var,
							"status"=>$status,
							"batch_id" => $batch_id,
							"remarks"=>$remark,
							"id" => $pId,
					);
					$res = $oAlbum->saveTempBulk($params);
			}
		}
		header('location:'.SITEPATH.'albumbulk?action=edit&bid='.$batch_id);
		exit;
	}
	if(!empty($_POST) && $_POST['gotodb']){
		$album_name=($_POST['album_name']);
		$catalogue=($_POST['catalogue']);
		$language=($_POST['language']);
		$label=($_POST['label']);
		$content_type=$_POST['content_type'];
		$title_release_date=($_POST['title_release_date']);
		$music_release_date=($_POST['music_release_date']);
		$banner=$_POST['banner'];
		$primary_artist=($_POST['primary_artist']);
		$starcast=($_POST['starcast']);
		$director=($_POST['director']);
		$producer=($_POST['producer']);
		$writer=($_POST['writer']);
		$album_type=($_POST['album_type']);
		$album_description=($_POST['album_description']);
		$coupling_ids=($_POST['coupling_ids']);
		$tv_channel=($_POST['tv_channel']);
		$radio_station=($_POST['radio_station']);
		$show_name=($_POST['show_name']);
		$year_broadcast=($_POST['year_broadcast']);
		$grade=($_POST['grade']);
		$film_rating=($_POST['film_rating']);
		$file_path=($_POST['artwork_file_path']);
		$primaryId = $_POST['primaryId'];
		$batch_id = ($_POST['batch_id']);
		$statusArr=$_POST['status'];
		$gotodbArr=$_POST['gotodb'];
		if(!empty($primaryId)){
			foreach($primaryId as $pId){
				if($gotodbArr[$pId]==1){
					continue;
				}
				$remark=array();
				$validPath=0;
				$file_path_var=$file_path[$pId];
				if(!file_exists(MEDIA_READ_SERVERPATH_TEMPFTP.$file_path_var)){
					$remark['artwork_file_path']="Enter valid file path!";
				}else{
					$validPath=1;
				}
				$status=0;
				$f=2;
				$album_type_var=$album_type[$pId];
				if($album_type_var){
					$albumTypeStr="2|";
					$albumTypeArr=explode(",",$album_type_var);						
					if(sizeof($albumTypeArr)>0){
						foreach($albumTypeArr as $at){
							if(in_array(strtolower($at),$albumTypeArray)){
								if(strtolower($at)=='film'){
									$albumTypeStr.="1|";
									$f=1;
								}
								if(strtolower($at)=='compile'){
									$albumTypeStr.=str_replace("2|","",$albumTypeStr);
								}
							}else{
								$remark['album_type'][]="Enter valid album type for ".$at."!";
							}
						}
					}
				}
				$albumTypeStr=trim($albumTypeStr,"|");

				$album_name_var=$album_name[$pId];
				if($album_name_var==""){
					$remark['album_name']="Album Name is required!";
				}
				$catalogue_var=$catalogue[$pId];
				if($catalogue_var==""){
					$remark['catalogue']="Enter catalogue!";
				}
				if($catalogue_var){
					$isCata=$oCatalogue->getAllCatalogues( array("where"=>"AND catalogue_name='".$catalogue_var."'") );
					if($isCata[0]->catalogue_id>0){
						$catalogue_id=$isCata[0]->catalogue_id;
					}else{
						$remark['catalogue']="Enter valid catalogue!";
					}
				}
				$language_var=$language[$pId];
				if($language_var==""){
					$remark['language']="Language is required!";
				}
				if($language_var){
					$isLang=$oLanguage->getAllLanguages( array("where"=>"AND language_name='".$language_var."'") );
					if($isLang[0]->language_id>0){
						$language_id=$isLang[0]->language_id;
					}else{
						$remark['language']="Enter valid language!";
					}
				}
				$label_var=$label[$pId];
				if($label_var==""){
					$remark['label']="Enter label!";
				}
				if($label_var){
					$isLabel=$oLabel->getAllLabels( array("where"=>"AND label_name='".$label_var."'") );
					if($isLabel[0]->label_id>0){
						$label_id=$isLabel[0]->label_id;
					}else{
						$remark['label']="Enter valid label!";
					}
				}
				$content_type_var=$content_type[$pId];
				if($content_type_var==""){
					$remark['content_type']="Enter content type!";
				}
				$content_type_pipe="";
				if($content_type_var){
					$content_type_Arr=explode(",",$content_type_var);
					$keyValAlbumContentType=array_flip($aConfig['album_content_type']);
					if($content_type_Arr){
						foreach($content_type_Arr as $content_type_str){
							if(in_array(ucfirst($content_type_str),$aConfig['album_content_type'])){
								$contentTypeKey=$keyValAlbumContentType[ucfirst($content_type_str)];
								$content_type_pipe.=$contentTypeKey."|";
							}else{
								$remark['content_type']="Enter valid content type ".$content_type_str."!";							
							}
						}
					}
				}
				$content_type_pipe=trim($content_type_pipe,"|");
				$title_release_date_var=$title_release_date[$pId];
				if($title_release_date_var){
					$title_release_date_var=date("Y-m-d",strtotime($title_release_date_var));
				}
				$music_release_date_var=$music_release_date[$pId];
				if($music_release_date_var==""){
					$remark['music_release_date']="Enter music release date!";
				}
				if($music_release_date_var){
					$music_release_date_var=date("Y-m-d",strtotime($music_release_date_var));
				}
				if($album_name_var){
					$album_release_date=$music_release_date_var;
					$query="";
					$album_name_chk=$album_name_var;
					if($album_release_date && $album_release_date!="0000-00-00"){
						$album_release_date=date("Y-m-d",strtotime($album_release_date));
						$query=" AND music_release_date='".$album_release_date."'";
					}
					$isAlbum=$oAlbum->getTotalCount( array("where"=>"AND album_name='".$album_name_chk."' ".$query) );	
					if($isAlbum>0){
						$remark['album_name']="Enter valid album name!";
					}
				}
				$banner_var=$banner[$pId];
				if($banner_var=="" && $f==1){
					$remark['banner']="Enter banner!";
				}
				$banner_id=array();
				if($banner){
					$bannerArr=explode(",",$banner_var);
					if(sizeof($bannerArr)>0){
						foreach($bannerArr as $ban){
							$isBanner= $oBanner->getAllBanners( array("where"=>"AND banner_name='".$ban."'") );
							if($isBanner[0]->banner_id>0){
								$banner_id[]=$isBanner[0]->banner_id;
							}else{
								$remark['banner'][]="Enter valid banner name for ".$ban."!";
							}
						}
					}		
				}
				$primary_artist_var=$primary_artist[$pId];
				if(primary_artist_var){
					$primary_artist_Arr=explode("(",$primary_artist_var);
					$dob=@str_replace(")","",$primary_artist_Arr[1]);
					$primary_artist_chk=@trim($primary_artist_Arr[0]);
					$query="";
					if($dob && $dob!="0000-00-00"){
						$dob=date("Y-m-d",strtotime($dob));
						$query=" AND artist_dob='".$dob."'";
					}
					$isPrimaryArtist=$oArtist->getAllArtists( array("where"=>" AND artist_name='".$primary_artist_chk."'".$query) );
					if($isPrimaryArtist[0]->artist_id>0){
						$primary_artist_id=$isPrimaryArtist[0]->artist_id;
					}else{
						$remark['primary_artist']="Enter valid primary artist name for ".$primary_artist_var."!";
					}
				}
				$starcast_var=$starcast[$pId];
				if($starcast_var=="" && $f==1){
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
							$isStar=$oArtist->getAllArtists( array("where"=>" AND artist_role&1=1 AND artist_name='".$star_chk."'".$query) );
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
				$director_var=$director[$pId];
				if($director_var=="" && $f==1){
					$remark['director'][]="Enter director!";
				}
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
							$isMdir=$oArtist->getAllArtists( array("where"=>" AND artist_role&16=16 AND artist_name='".$md_chk."'".$query) );
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
				$producer_var=$producer[$pId];
				if($producer_var=="" && $f==1){
					$remark['producer'][]="Enter producer!";
				}
				if($producer_var){
					$producerArr=explode(",",$producer_var);
					$producerHiddenArr=array();
					if(sizeof($producerArr)>0){
						foreach($producerArr as $prod){
							$prod_Arr=explode("(",$prod);
							$dob=@str_replace(")","",$prod_Arr[1]);
							$prod_chk=@trim($prod_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isProd=$oArtist->getAllArtists( array("where"=>" AND artist_role&32=32 AND artist_name='".$prod_chk."'".$query) );
							if($isProd[0]->artist_id>0){
								$producerHiddenArr[]=$isProd[0]->artist_id;
								$roleStr="";
								if($artistRoleKeyArray[$isProd[0]->artist_id]){
									$roleStr=$artistRoleKeyArray[$isProd[0]->artist_id]."|";
								}
								$artistRoleKeyArray[$isProd[0]->artist_id]=$roleStr.$aConfig['artist_type']['Producer'];
							}else{
								$remark['producer'][]="Enter valid producer name for ".$prod."!";								
							}
						}
					}
				}
				$writer_var=$writer[$pId];
				if($writer_var){
					$writerArr=explode(",",$writer_var);
					$writerHiddenArr=array();
					if(sizeof($writerArr)>0){
						foreach($writerArr as $wri){
							$wri_Arr=explode("(",$wri);
							$dob=@str_replace(")","",$wri_Arr[1]);
							$wri_chk=@trim($wri_Arr[0]);
							$query="";
							if($dob && $dob!="0000-00-00"){
								$dob=date("Y-m-d",strtotime($dob));
								$query=" AND artist_dob='".$dob."'";
							}
							$isWri=$oArtist->getAllArtists( array("where"=>" AND artist_role&64=64 AND artist_name='".$star_chk."'".$query) );
							if($isWri[0]->artist_id>0){
								$writerHiddenArr[]=$isWri[0]->artist_id;
								$roleStr="";
								if($artistRoleKeyArray[$isWri[0]->artist_id]){
									$roleStr=$artistRoleKeyArray[$isWri[0]->artist_id]."|";
								}
								$artistRoleKeyArray[$isWri[0]->artist_id]=$roleStr.$aConfig['artist_type']['Writer'];
							}else{
								$remark['writer'][]="Enter valid writer name for ".$wri."!";								
							}
						}
					}
				}
				$music_director_var=$music_director[$pId];
				if($music_director_var){
					$mdArr=explode(",",$music_director_var);
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
								$artistRoleKeyArray[$isMdir[0]->artist_id]=$roleStr.$aConfig['artist_type']['Music Director'];
							}else{
								$remark['music_director'][]="Enter valid music director name for ".$md."!";								
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
				$album_description_var=$album_description[$pId];
				if($album_description_var==""){
					$remark['album_description']="Enter album description!";
				}
				$coupling_ids_var=$coupling_ids[$pId];
				$tv_channel_var=$tv_channel[$pId];
				if($tv_channel_var){
					$tv_channelArr=explode(",",$tv_channel_var);
					if(sizeof($tv_channelArr)>0){
						foreach($tv_channelArr as $tv){
							$isTv=$oTag->getAllTags( array("where"=>"AND tag_name='".$tv."' AND parent_tag_id=1466") );
							$aKey=array_keys($isTv);
							if($isTv[$aKey[0]]->tag_id>0){
								$tv_channelHiddenArr[]=$isTv[$aKey[0]]->tag_id;	
							}else{
								$remark['tv_channel'][]="Enter valid tv channel for ".$ver."!";
							}
						}
					}
				}
				$radio_station_var=$radio_station[$pId];
				if($radio_station_var){
					$radio_stationArr=explode(",",$radio_station_var);
					if(sizeof($radio_stationArr)>0){
						foreach($radio_stationArr as $rs){
							$isVar=$oTag->getAllTags( array("where"=>"AND tag_name='".$rs."' AND parent_tag_id=1635") );
							$aKey=array_keys($isVar);
							if($isVar[$aKey[0]]->tag_id>0){
								$radio_stationHiddenArr[]=$isVar[$aKey[0]]->tag_id;	
							}else{
								$remark['tv_channel'][]="Enter valid tv channel for ".$rs."!";
							}
						}
					}
				}
				$year_broadcast_var=$year_broadcast[$pId];
				if($year_broadcast_var){
					$year_broadcast_var=date("Y",strtotime($year_broadcast_var));
				}
				$grade_var=$grade[$pId];
				if($grade_var==""){
					$remark['grade']="Enter grade!";
				}
				$grade_var=$grade[$pId];
				if($grade_var){
					if(!in_array($grade_var,$aConfig['grade'])){
						$remark['grade']="Enter valid grade!";
					}
				}
				$film_rating_var=$film_rating[$pId];
				if($film_rating_var){
					if(!in_array($film_rating_var,$aConfig['film_rating'])){
						$remark['film_rating']="Enter valid film rating!";
					}
				}
				$show_name_var=$show_name[$pId];
				if($validPath==1){
					$sourcePath=MEDIA_READ_SERVERPATH_TEMPFTP.$file_path_var;
					$pathinfo=pathinfo($sourcePath);
					$fExt=$pathinfo['extension'];
					$cleanFileName	= TOOLS::cleanFileName($pathinfo['filename'], true);
					$sNewDirPath 	= TOOLS::getImagePath($cleanFileName);
					$fileName=$sNewDirPath.$cleanFileName.".".$fExt;
					$destinationPath=MEDIA_SEVERPATH_IMAGE.$sNewDirPath.$cleanFileName.".".$fExt;
					tools::createDir($destinationPath);
					if(!file_exists($destinationPath)){
						if(copy(MEDIA_READ_SERVERPATH_TEMPFTP.$file_path_var,$destinationPath)){
								$params = array(
									'imageName' 	=> $album_name_var, 
									'imageDesc' 	=> "", 
									'imageType' 	=> 1, 
									'imageFile'     => $fileName,
									'status' 		=> 1, 
								  );
								$aImg = $oImage->saveImage( $params );
						}else{
							$remark['file_path']="Error in copy file";
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
							"album_name"=>$album_name_var,
							"catalogue"=>$catalogue_var,
							"language"=>$language_var,
							"label" =>$label_var,
							"content_type"=>$content_type_var,
							"title_release_date"=>$title_release_date_var,
							"music_release_date"=>$music_release_date_var,
							"banner"=>$banner_var,
							"primary_artist"=>$primary_artist_var,
							"starcast"=>$starcast_var,
							"director"=>$director_var,
							"producer"=>$producer_var,
							"writer"=>$writer_var,
							"lyricist"=>$lyricist_var,
							"music_director"=>$music_director_var,
							"album_type"=>$album_type_var,
							"album_description"=>$album_description_var,
							"coupling_ids"=>$coupling_ids_var,
							"tv_channel"=>$tv_channel_var,
							"radio_station"=>$radio_station_var,
							"show_name"=>$show_name_var,
							"year_broadcast"=>$year_broadcast_var,
							"grade"=>$grade_var,
							"film_rating"=>$film_rating_var,
							"artwork_file_path"=>$file_path_var,
							"status"=>$status,
							"batch_id" => $batch_id,
							"remarks"=>$remark,
							"id" => $pId,
						);
					$res = $oAlbum->saveTempBulk($params);
					if($status==1){//final move to song_mstr
						$postData=array(
							'albumName'=>$album_name_var,
							'status'=>0,
							'labelIds' => $label_id,
							'languageIds'=>$language_id,
							'catalogueIds'=> $catalogue_id,
							'artistId' => $primary_artist_id,
							'musicReleaseDate' => $music_release_date_var,
							'titleReleaseDate' => $title_release_date_var,
							'albumDescription' => $album_description_var,
							'albumExcerpt' => "",
							'albumType' => $albumTypeStr,
							'couplingIds' => $coupling_ids_var,
							'albumTypeStr' => $content_type_pipe,
							'albumContentTypeStr' => $content_type_pipe,
							'showName' => $show_name_var,
							'broadCastYear'=>$year_broadcast_var,
							'grade' =>$grade_var,
							'isSubtitle'=>"",
							'filmRating' => $film_rating_var,
							'image'=>$fileName,
						);
						$aData = $oAlbum->addAlbum( $postData );	
						if($aData){
							if($artistRoleKeyArray){ 
								$oData=$oAlbum->mapArtistAlbum(array('albumId'=>(int)$aData,'artistRoleKeyArray'=>$artistRoleKeyArray));
							}
							if($banner_id){
								$bData=$oAlbum->mapBannerAlbum(array('albumId'=>(int)$aData,'bannerIds'=>$banner_id));
							}
							$tagIds=array_merge($tv_channelHiddenArr,$radio_stationHiddenArr);
							$tData=$oAlbum->mapTagAlbum(array('albumId'=>(int)$aData,'tagIds'=>$tagIds));
							if($aImg){
								$oData=$oImage->mapAlbumImage(array('imageId'=>$aImg,'albumIds'=>array($aData)));
							}
							$aLogParam = array(
								'moduleName' => 'album',
								'action' => 'add',
								'moduleId' => 14,
								'editorId' => $this->user->user_id,
								'remark'	=>	'Created Album from bulk upload. (ID-'.(int)$aData.')',
								'content_ids' => (int)$aData,
							);
							TOOLS::writeActivityLog( $aLogParam );	
							$oAlbum->updateGoToDbBulk(array('id'=>$pId));
						}
					}
			}
			$msg="";
			if(!in_array(0,$statusArr)){
				$msg="&msg=Action completed successfully!";
			}
		}
		header('location:'.SITEPATH.'albumbulk?action=edit&bid='.$batch_id.$msg);
		exit;
	}
	$params = array(
				'start' => 0, 
				'limit' => 10000, 
				'where' => ' AND batch_id="'.$batch_id.'"', 
			  ); 
	$aSongData = $oAlbum->getAllBulkAlbums( $params );
	$data['aContent']=$aSongData;
}else{
	$view = 'albumbulk_list';
	$lisData = getlist( $oAlbum ,$this);
	$data['aContent']	 = $lisData['aContent'];
	$data['sPaging']	 = $lisData['sPaging'];
	$data['iTotalCount'] = $lisData['iTotalCount'];
}
function getlist( $oAlbum,$users=NULL){
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
	
	$data['aContent'] = $oAlbum->getAllBulkAlbums( $params );
	/* Pagination Start */
	$oPage = new Paging();
	$oPage->total = $oAlbum->getTotalBulkCount( $params );
	$oPage->page = $page;
	$oPage->limit = MAX_DISPLAY_COUNT;
	$oPage->url = "albumbulk?action=view&page={page}";
	$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
	$data['sPaging'] = $oPage->render();
	$data['iTotalCount'] = $oPage->total;
	/* Pagination End */
	/* Show Song as List End */
	return $data;
}	
/* render view */
$oCms->view( $view, $data );
