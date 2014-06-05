<?php 
/**
 * The Video Model does the back-end Work for the Video Controller
 */
class video
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all Video 
	*@Param: array()
	********************************************/
	public function getAllVideos( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY video_id DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		$where .= " AND status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT * FROM `video_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}

	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$where = " AND status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		$this->sSql = "SELECT count(1) as cnt FROM `video_mstr` WHERE 1 $where ";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}


	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		$this->sSql = "UPDATE `video_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND video_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		global $aConfig;
		$sQuery="";
		$next=$aConfig['flow'][$a['contentActionValue']]['next'];
		$prev=$aConfig['flow'][$a['contentActionValue']]['prev'];
		if($next!="" && isset($prev)){
			$sQuery=" AND ( status=".$next." OR  status=".$prev." )";
		}elseif($next!=""){
			$sQuery=" AND  status=".$next." ";
		}elseif($prev!=""){
			$sQuery=" AND  status=".$prev." ";
		}
		$limit = count($a['contentIds']);
		$this->sSql = "UPDATE `video_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND video_id IN(".implode(',', $a['contentIds']).")
						$sQuery
						LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of Video
	* @param: string 
	**********************************************/
	public function checkVideoExist($videoName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND video_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `video_mstr` WHERE video_name = '".$this->oMysqli->secure($videoName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update Video
	* @param: array 
	**********************************************/
	public function saveVideo( array $a = array() ){
		if($a){
			$videoId=$a['videoId'];
			$videoName=$a['videoName'];
			$status=(int)$a['status'];
			$languageIds=$a['languageIds'];
			$releaseDate=$a['releaseDate'];
			$videoDuration=$a['videoDuration'];
			$videoTempo=$a['videoTempo'];
			$subjectParody=$a['subjectParody'];
			$videoFilePath=$a['videoFilePath'];
			$region=$a['region'];
			$image=$a['image'];
			
			if((int)$videoId>0){
				$this->sSql = "UPDATE `video_mstr` SET `video_name`='".$this->oMysqli->secure($videoName)."',`image`= '".$image."', `language_id`='".$this->oMysqli->secure($languageIds)."' , `video_duration`='".$this->oMysqli->secure($videoDuration)."',`release_date`='".$this->oMysqli->secure($releaseDate)."',`origin_state_id`='".$this->oMysqli->secure($region)."',`tempo`='".$this->oMysqli->secure($videoTempo)."',`subject_parody`='".$this->oMysqli->secure($subjectParody)."',update_date=NOW() WHERE video_id = ".(int)$videoId." LIMIT 1";
			}else{
				$this->sSql = "INSERT INTO `video_mstr` (`video_name`,`video_file`,`image`,`language_id`,`video_duration`,`release_date`,`insert_date`, `origin_state_id`,`tempo`,`subject_parody`) VALUES ('".$this->oMysqli->secure($videoName)."', '".$videoFilePath."', '".$image."', '".$this->oMysqli->secure($languageIds)."', '".$this->oMysqli->secure($videoDuration)."', '".$this->oMysqli->secure($releaseDate)."', NOW() , '".$this->oMysqli->secure($region)."', '".$this->oMysqli->secure($videoTempo)."', '".$this->oMysqli->secure($subjectParody)."' )";
			
			}
			$statusid = $this->oMysqli->query( $this->sSql );
			return $statusid;
		}
	}
	
	/**********************************************
	*Will Update Youtube Video ID
	* @param: array 
	**********************************************/
	public function updateYoutubeId( array $a = array() ){
		if($a){
			$videoId=$a['videoId'];
			$youTubeId=$a['youTubeId'];
			
			if((int)$videoId>0){
				$this->sSql = "UPDATE `video_mstr` SET `youtube_id`='".$this->oMysqli->secure($youTubeId)."' WHERE video_id = ".(int)$videoId." LIMIT 1";
				$statusid = $this->oMysqli->query( $this->sSql );
			}
			
			return $statusid;
		}
	}	
	/*********************************************
	* Will map artist and role with video 
	* @Param: array()
	**********************************************/
	public function mapArtistVideo( array $a = array() ){
		if($a){
			$videoId=(int)$a['videoId'];
			$artistRoleKeyArray=$a['artistRoleKeyArray'];
			if($videoId){
				$this->sSql = "DELETE FROM artist_video WHERE video_id='".$videoId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistRoleKeyArray){
				foreach($artistRoleKeyArray as $kAR=>$vAR){ 
					$this->sSql = "INSERT INTO artist_video (`video_id`,`artist_id`,`artist_role`) VALUES ('".$videoId."','".$kAR."',".$vAR.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map artist and role with video 
	* @Param: array()
	**********************************************/
	public function getArtistVideoMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM artist_video WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Will map Tags with video 
	* @Param: array()
	**********************************************/
	public function mapTagVideo( array $a = array() ){
		if($a){
			$videoId=(int)$a['videoId'];
			$tagIdsArray=$a['tagIds'];
			if($videoId){
				$this->sSql = "DELETE FROM video_tags WHERE video_id='".$videoId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($tagIdsArray){
				foreach($tagIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO video_tags (`video_id`,`tag_id`) VALUES ('".$videoId."',".$vT.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map tags with video 
	* @Param: array()
	**********************************************/
	public function getTagVideoMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM video_tags WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
		/*********************************************
	* Will map Tags with video 
	* @Param: array()
	**********************************************/
	public function mapAlbumVideo( array $a = array() ){
		if($a){
			$videoId=(int)$a['videoId'];
			$albumIdsArray=$a['albumIds'];
			if($videoId){
				$this->sSql = "DELETE FROM album_video WHERE video_id='".$videoId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($albumIdsArray){
				foreach($albumIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO album_video (`video_id`,`album_id`) VALUES ('".$videoId."',".$vT.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map album with video 
	* @Param: array()
	**********************************************/
	public function getAlbumVideoMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM album_video WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	
	/*********************************************
	* Get all videos by ID
	* param: array
	*		 id: video Id

	*********************************************/

	public function getVideoById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND video_id IN(".$a['ids'].")";
			}	
			 $this->sSql="SELECT `video_id`,`video_name`,`image`,`video_file`,`language_id`,`video_duration`,`youtube_id`,`release_date` FROM video_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}
	/*********************************************
	* Will map Song with Video 
	* @Param: array()
	**********************************************/
	public function mapSongVideo( array $a = array() ){
		if($a){
			$videoId=(int)$a['videoId'];
			$songKeyArray=$a['songKeyArray'];
			if($videoId){
				$this->sSql = "DELETE FROM song_video WHERE video_id='".$videoId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($songKeyArray){
				foreach($songKeyArray as $kAR=>$vAR){ 
					$this->sSql = "INSERT INTO song_video (`song_id`,`video_id`) VALUES (".$vAR.",'".$videoId."')";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get Songs 
	* @Param: array()
	**********************************************/
	public function getSongVideoMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM song_video WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Get all Video Edits
	* Param: videoId
	*********************************************/
	public function getVideoEdits( $videoId ){
		$this->sSql="SELECT `video_id`,`config_id`, `path`, `insert_date` FROM video_mstr_config_rel WHERE status!='-1' AND video_id='".(int)$videoId."'";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	/*********************************************
	* Get all Video Edits Config
	*********************************************/
	public function getVideoEditsConfig( array $a=array() ){
		$this->sSql="SELECT * FROM video_edit_config WHERE `status`!='-1';";
		$data=$this->oMysqli->query($this->sSql);
		$retData = null;
		if( $data!='-1' ){
			foreach( $data as $k=>$vv ){
				$retData[$vv->video_edit_id]['data'] = $vv;
				$retData[$vv->video_edit_id]['str']  = 'Format: '.$vv->format.', Dimension: '.$vv->dimension.', Frame Rate: '.$vv->frame_rate .', Video Codec:'.$vv->video_codec.',  Video Bitrate:'.$vv->video_bitrate.', Audio Codec:'.$vv->audio_codec.', Audio Bitrate:'.$vv->audio_bitrate.', Sample Rate:'.$vv->sample_rate.', File Size:'.$vv->file_size_limit.', Duration:'.$vv->duration;
			}
		}
		return $retData;
	}
	/********************************************
	* Will returns all video 
	*@Param: array()
	********************************************/
	public function getAllVideosConfig( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY video_edit_id ASC '; $where ='';$includes ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}

		$where .= " AND status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		$this->sSql = "SELECT * FROM `video_edit_config` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/*********************************************
	* Will UPDATE VIDEO FILE PATH given records
	* @Param: array()
	**********************************************/
	public function upVideoFilePath( array $a = array() ){
		$this->sSql = "UPDATE `video_mstr` SET `video_file`='".$this->oMysqli->secure($a['videoFilePath'])."' WHERE status!='-1' AND video_id='".(int)$a['videoId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	public function saveTempBulk( array $a= array() ){
		$video_title=$this->oMysqli->secure($a['video_title']);
		$album_name=$this->oMysqli->secure($a['album_name']);
		$song_isrc=$this->oMysqli->secure($a['song_isrc']);
		$video_language=$this->oMysqli->secure($a['video_language']);
		$release_date =$this->oMysqli->secure($a['release_date']);
		$video_duration=$this->oMysqli->secure($a['video_duration']);
		$subject_parody=$this->oMysqli->secure($a['subject_parody']);
		$singer=$this->oMysqli->secure($a['singer']);
		$director=$this->oMysqli->secure($a['director']);
		$lyricist=$this->oMysqli->secure($a['lyricist']);
		$starcast=$this->oMysqli->secure($a['starcast']);
		$mimicked_star=$this->oMysqli->secure($a['mimicked_star']);
		$version=$this->oMysqli->secure($a['version']);
		$genre=$this->oMysqli->secure($a['genre']);
		$mood=$this->oMysqli->secure($a['mood']);
		$relationship=$this->oMysqli->secure($a['relationship']);
		$raag=$this->oMysqli->secure($a['raag']);
		$taal=$this->oMysqli->secure($a['taal']);
		$time_of_day=$this->oMysqli->secure($a['time_of_day']);
		$religion=$this->oMysqli->secure($a['religion']);
		$saint=$this->oMysqli->secure($a['saint']);
		$instrument=$this->oMysqli->secure($a['instrument']);
		$festival=$this->oMysqli->secure($a['festival']);
		$occasion=$this->oMysqli->secure($a['occasion']);
		$video_file_path=$this->oMysqli->secure($a['video_file_path']);
		$image_file_path=$this->oMysqli->secure($a['image_file_path']);
		$remarks=$this->oMysqli->secure($a['remark']);
		$batch_id = $this->oMysqli->secure($a['batch_id']);
		$id = $this->oMysqli->secure($a['id']);
		$status=$this->oMysqli->secure($a['status']);
		
		if($id>0){
			$this->sSql="
UPDATE `video_bulk_temp` SET	`video_title` = '".$video_title."' , 	`song_isrc` = '".$song_isrc."' , 	`video_language` = '".$video_language."' , 	`release_date` = '".$release_date."' , 	`video_duration` = '".$video_duration."' , 	`subject_parody` = '".$subject_parody."' , 	`album_name` = '".$album_name."' , 	`singer` = '".$singer."' , 	`director` = '".$director."' , 	`lyricist` = '".$lyricist."' , 	`starcast` = '".$starcast."' , 	`mimicked_star` = '".$mimicked_star."' , 	`version` = '".$version."' , 	`genre` = '".$genre."' , 	`mood` = '".$mood."' , 	`relationship` = '".$relationship."' , 	`raag` = '".$raag."' , 	`taal` = '".$taal."' , 	`time_of_day` = '".$time_of_day."' , 	`religion` = '".$religion."' , 	`saint` = '".$saint."' , 	`instrument` = '".$instrument."' , 	`festival` = '".$festival."' , 	`occasion` = '".$occasion."' , 	`video_file_path` = '".$video_file_path."' , 	`image_file_path` = '".$image_file_path."' , 	`update_date` = now() , 	`remarks` = '".$remarks."' , 	`batch_id` = '".$batch_id."',`status`='".$status."'		WHERE	`id` = '".$id."' LIMIT 1";
		}else{		
			$this->sSql = "
insert into `video_bulk_temp` 	(`video_title`, 	`song_isrc`, 	`video_language`, 	`release_date`, 	`video_duration`, 	`subject_parody`, 	`album_name`, `singer`, 	`director`, 	`lyricist`, 	`starcast`, 	`mimicked_star`, 	`version`, 	`genre`, 	`mood`, 	`relationship`, 	`raag`, 	`taal`, 	`time_of_day`, 	`religion`, 	`saint`, 	`instrument`, 	`festival`, 	`occasion`, 	`video_file_path`, `image_file_path`,	`status`, 	`insert_date`, 	`remarks`, `batch_id` 	)
	values
	('".$video_title."', 	'".$song_isrc."', 	'".$video_language."', 	'".$release_date."', 	'".$video_duration."', 	'".$subject_parody."', '".$album_name."', '".$singer."', 	'".$director."', 	'".$lyricist."', 	'".$starcast."', '".$mimicked_star."', 	'".$version."', 	'".$genre."', 	'".$mood."', 	'".$relationship."', 	'".$raag."', 	'".$taal."', 	'".$time_of_day."', 	'".$religion."', 	'".$saint."', 	'".$instrument."', 	'".$festival."', 	'".$occasion."', 	'".$video_file_path."','".$image_file_path."', 	0, 	now(), 	'".$remarks."', '".$batch_id."'	);";
		}
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns all BulkSong 
	*@Param: array()
	********************************************/
	public function getAllBulkVideos( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY sm.id DESC '; $where ='';$includes ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}

		$where .= " AND sm.status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		$this->sSql = "SELECT * FROM `video_bulk_temp` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	

		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	function getTotalBulkCount( array $a = array() ){
		$where = " AND status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}
		$this->sSql = "SELECT COUNT(DISTINCT batch_id) as cnt FROM `video_bulk_temp` sm WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	function updateGoToDbBulk( array $a = array() ){
		$id=$a['id'];
		$this->sSql = "UPDATE `video_bulk_temp` SET gotodb='1',update_date=now() WHERE id='".$id."'";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
/*
	*	Add/edit video rights
	*/
	public function addVideoRights(array $a=array()) {
		if($a){
		
			$videoId=$this->oMysqli->secure($a['videoId']);
			$isCtype=$this->oMysqli->secure($a['is_owned']);
			$banner_id=$this->oMysqli->secure($a['banner_id']);
			$territory_in=$this->oMysqli->secure($a['territory_in']);
			$territory_ex=$this->oMysqli->secure($a['territory_ex']);
			$start_date=$this->oMysqli->secure($a['start_date']);
			$end_date=$this->oMysqli->secure($a['end_date']);
			$physical_rights=$this->oMysqli->secure($a['physical_rights']);
			$is_exclusive=$this->oMysqli->secure((int)$a['is_exclusive']);
			$publishing_rights= $a['publishing_rights'];
			$digital_rights= $a['digital_rights'];

			
				$this->sSql = "INSERT INTO `video_rights` (`video_id`,`is_owned`,`banner_id`,`territory_in`,`territory_ex`,`start_date`,`expiry_date`,`physical_rights`,`publishing_rights`,`digital_rights`,`is_exclusive`,`insert_date`) VALUES ('".$videoId."','".$isCtype."','".$banner_id."','".$territory_in."','".$territory_ex."','".$start_date."','".$end_date."','".$physical_rights."',".$publishing_rights.",".$digital_rights.",".$is_exclusive.",now()) ON DUPLICATE KEY UPDATE `is_owned`='".$isCtype."',`banner_id`='".$banner_id."',`territory_in`='".$territory_in."',`territory_ex`='".$territory_ex."',`start_date`='".$start_date."',`expiry_date`='".$end_date."',`physical_rights`='".$physical_rights."',`publishing_rights`=".$publishing_rights.",`digital_rights`=".$digital_rights.",`is_exclusive`='".$is_exclusive."'";			
							
		//	echo $this->sSql;
			$data=$this->oMysqli->query($this->sSql);
			
			/*if( $legal_status==2 ){
				$up_sql = "UPDATE video_mstr SET `status`=2 WHERE video_id='".$videoId." AND `status`=0 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}else if( $legal_status==0 ){
				$up_sql = "UPDATE video_mstr SET `status`=0 WHERE video_id='".$videoId." 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}	*/		
			
			return $data;
		}
	}
	/*********************************************
	* Get map rights with video 
	* @Param: array()
	**********************************************/
	public function getRightsByVideoId( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM video_rights WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}

public function __toString(){
        return $this->sSql;
    }
}