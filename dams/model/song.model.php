<?php  
/**
 * The Song Model does the back-end Work for the Song Controller
 */
class song
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all Song 
	*@Param: array()
	********************************************/
	public function getAllSongs( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY sm.song_id DESC '; $where ='';$includes ='';

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
		if( isset($a['includes']) && $a['includes'] != ''){
			$includes=$a['includes'];
		}
		if( isset($a['join']) && $a['join']==1){
			$this->sSql = "SELECT sm.song_name, sm.audio_file,sm.insert_date,sm.isrc,sm.song_id,am.album_name,GROUP_CONCAT(asm.artist_id) AS artist_id,GROUP_CONCAT(ams.artist_name ) AS artist_name,sm.status,sm.release_date,sm.tempo,sm.song_duration
							FROM `song_mstr` sm
							LEFT JOIN album_mstr am ON sm.album_id = am.album_id AND  am.status=1
							LEFT JOIN artist_song asm ON sm.song_id = asm.song_id AND 8&asm.artist_role=8
							LEFT JOIN artist_mstr ams ON ams.artist_id = asm.artist_id AND ams.status=1 
							WHERE 1 $where  
							GROUP BY sm.song_id
							$orderBy LIMIT $start, $limit";
		}else{
			$this->sSql = "SELECT * FROM `song_mstr` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	
		}
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
		$this->sSql = "SELECT count(1) as cnt FROM `song_mstr` sm WHERE 1 $where ";
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
		$this->sSql = "UPDATE `song_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND song_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		global $aConfig;
		$limit = count($a['contentIds']);
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
		$this->sSql = "UPDATE `song_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND song_id IN(".implode(',', $a['contentIds']).") 
						$sQuery  
						LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of Song
	* @param: string 
	**********************************************/
	public function checkSongExist($songName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND song_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `song_mstr` WHERE song_name = '".$this->oMysqli->secure($songName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update Song
	* @param: array 
	**********************************************/
	public function saveSong( array $a = array() ){
		if($a){
			$songId=$a['songId'];
			$songName=$a['songName'];
			$status=(int)$a['status'];
			$isrc =$a['isrc'];
			$languageIds=$a['languageIds'];
			$releaseDate=$a['releaseDate'];
			$songDuration=$a['songDuration'];
			$songTempo=$a['songTempo'];
			$subjectParody=$a['subjectParody'];
			$audioFilePath=$a['audioFilePath'];
			$region=$a['region'];
			$oAlbumId=$a['oAlbumId'];
			$grade=$this->oMysqli->secure($a['grade']);
			if( $audioFilePath != '' ){
				$audioFilePath = str_replace('songs/', '', $audioFilePath);
			}
			
			if((int)$songId>0){
				$upSqlPart = '';
				if( $audioFilePath != '' ){ $upSqlPart = " , `audio_file`= '".$audioFilePath."' "; }
				$this->sSql = "UPDATE `song_mstr` SET `song_name`='".$this->oMysqli->secure($songName)."' $upSqlPart , `language_id`='".$this->oMysqli->secure($languageIds)."' , `song_duration`='".$this->oMysqli->secure($songDuration)."',`release_date`='".$this->oMysqli->secure($releaseDate)."',`isrc`='".$this->oMysqli->secure($isrc)."',`origin_state_id`='".$this->oMysqli->secure($region)."',`tempo`='".$this->oMysqli->secure($songTempo)."',`subject_parody`='".$this->oMysqli->secure($subjectParody)."',update_date=NOW(),album_id='".$oAlbumId."',`grade`='".$grade."' WHERE song_id = ".(int)$songId." LIMIT 1";
			}else{
				$this->sSql = "INSERT INTO `song_mstr` (`song_name`,`audio_file`,`language_id`,`song_duration`,`release_date`,`isrc`,`insert_date`, `origin_state_id`,`tempo`,`subject_parody`,album_id,`grade`) VALUES ('".$this->oMysqli->secure($songName)."', '".$audioFilePath."', '".$this->oMysqli->secure($languageIds)."', '".$this->oMysqli->secure($songDuration)."', '".$this->oMysqli->secure($releaseDate)."', '".$this->oMysqli->secure($isrc)."', NOW() , '".$this->oMysqli->secure($region)."', '".$this->oMysqli->secure($songTempo)."', '".$this->oMysqli->secure($subjectParody)."' ,'".$oAlbumId."','".$grade."')";
			
			}
			$statusid = $this->oMysqli->query( $this->sSql );
			return $statusid;
		}
	}
	/*********************************************
	* Will map artist and role with song 
	* @Param: array()
	**********************************************/
	public function mapArtistSong( array $a = array() ){
		if($a){
			$songId=(int)$a['songId'];
			$artistRoleKeyArray=$a['artistRoleKeyArray'];
			if($songId){
				$this->sSql = "DELETE FROM artist_song WHERE song_id='".$songId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistRoleKeyArray){
				foreach($artistRoleKeyArray as $kAR=>$vAR){ 
					$this->sSql = "INSERT INTO artist_song (`song_id`,`artist_id`,`artist_role`) VALUES ('".$songId."','".$kAR."',".$vAR.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map artist and role with song 
	* @Param: array()
	**********************************************/
	public function getArtistSongMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM artist_song WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}

	/*********************************************
	* Will map Tags with song 
	* @Param: array()
	**********************************************/
	public function mapTagSong( array $a = array() ){
		if($a){
			$songId=(int)$a['songId'];
			$tagIdsArray=$a['tagIds'];
			if($songId){
				$this->sSql = "DELETE FROM song_tags WHERE song_id='".$songId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($tagIdsArray){
				foreach($tagIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO song_tags (`song_id`,`tag_id`) VALUES ('".$songId."',".$vT.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map tags with song 
	* @Param: array()
	**********************************************/
	public function getTagSongMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM song_tags WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Will map Tags with song 
	* @Param: array()
	**********************************************/
	public function mapAlbumSong( array $a = array() ){
		if($a){
			$songId=(int)$a['songId'];
			$albumIdsArray=$a['albumIds'];
			if($songId){
				$this->sSql = "DELETE FROM song_album WHERE song_id='".$songId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($albumIdsArray){
				foreach($albumIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO song_album (`song_id`,`album_id`) VALUES ('".$songId."',".$vT.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	
	/*********************************************
	* Will map Single Album with song 
	* @Param: array()
	**********************************************/
	public function mapSingleAlbumSong( array $a = array() ){
		if($a){
			$songId=(int)$a['songId'];
			$albumId=(int)$a['albumId'];
			
			if( $songId > 0 && $albumId > 0 ){
				$this->sSql = "INSERT IGNORE INTO song_album (`song_id`,`album_id`) VALUES ('".$songId."',".$albumId.")";
				$res = $this->oMysqli->query($this->sSql);
			}
		}
	}
	
	/*********************************************
	* Get map album with song 
	* @Param: array()
	**********************************************/
	public function getAlbumSongMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM song_album WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	
	/*********************************************
	* Will return Lyrics
	* param: array
	*		 id: song Id
	*********************************************/
	public function getLyrics( array $a= array() ){
		$lyrics = '';
		if((int)$a['id']>0){
			$this->sSql = "SELECT song_id, lyrics, insert_date FROM lyrics_mstr WHERE song_id='".$a['id']."' LIMIT 1";
			$res=$this->oMysqli->query( $this->sSql );
			if($res[0]){ $lyrics = $res[0]->lyrics; }
		}
		return $lyrics;
	}
	
	
	/*********************************************
	* Will save Lyrics
	* param: array
	*		 id: song Id
	*		 lyrics: Lyrics
	*********************************************/
	public function saveLyrics( array $a= array() ){
		$res = null;
		if((int)$a['id']>0){
			$this->sSql = "INSERT INTO lyrics_mstr( song_id, lyrics, insert_date ) VALUES ( '".$a['id']."', '".$this->oMysqli->secure($a['lyrics'])."', NOW() ) ON DUPLICATE KEY UPDATE lyrics='".$this->oMysqli->secure($a['lyrics'])."' ";
			$res = $this->oMysqli->query( $this->sSql );
		}
		return $res;
	}
	
	
	/*********************************************
	* Get all songs by ID
	* param: array
	*		 id: song Id

	*********************************************/

	public function getSongById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND song_id IN(".$a['ids'].")";
			}	
			$this->sSql="SELECT `song_id`,`song_name` FROM song_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}
	
	/*********************************************
	* Get all Song Edits
	* Param: SongId
	*********************************************/
	public function getSongEdits( $songId ){
		$this->sSql="SELECT `id`,`song_id`,`config_id`, `path`, `insert_date` FROM song_mstr_config_rel WHERE status!='-1' AND song_id='".(int)$songId."'";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	
	/*********************************************
	* Get all Song Edits Config
	*********************************************/
	public function getSongEditsConfig( array $a=array() ){
		$this->sSql="SELECT * FROM song_edit_config WHERE `status`!='-1';";
		$data=$this->oMysqli->query($this->sSql);
		$retData = null;
		if( $data!='-1' ){
			foreach( $data as $k=>$vv ){
				$retData[$vv->song_edit_id]['data'] = $vv;
				$retData[$vv->song_edit_id]['str']  = 'Format: '.$vv->format.', Sample Size: '.$vv->sample_size.', Audio Bitrate: '.$vv->audio_bitrate.', Sample Rate: '.$vv->sample_rate.', Audio Channel: '.$vv->audio_channel.', Duration Limit: '.$vv->duration_limit.', Codec: '.$vv->codec;
			}
		}
		return $retData;
	}
	/********************************************
	* Will returns all Song 
	*@Param: array()
	********************************************/
	public function getAllSongsConfig( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY song_edit_id ASC '; $where ='';$includes ='';

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
		$this->sSql = "SELECT * FROM `song_edit_config` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns all Song 
	*@Param: array()
	********************************************/
	public function getAllSongsCrbt( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY song_edit_id ASC '; $where ='';$includes ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}

		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		$this->sSql = "SELECT * FROM `song_crbt` WHERE 1 $where $orderBy LIMIT $start, $limit";	
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	public function getFieldSongCrbt(){
		$this->sSql = "SHOW COLUMNS FROM song_crbt";	
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/*********************************************
	* Will save CRBT of perticular edit
	* param: array
	*		 id: song Id,config id
	*********************************************/
	public function saveCrbts( array $a= array() ){
		$res = null;
		$fields=$a['fieldStr'];
		$fieldsVal="'".$a['valStr']."'";
		$fieldeqval=trim($a['keyval'],",");
		if((int)$a['song_id']>0 && (int)$a['song_edit_id']>0){
			$this->sSql = "INSERT INTO song_crbt( song_id, song_edit_id, ".$fields." ) VALUES ( '".$a['song_id']."', '".$a['song_edit_id']."' , ".$fieldsVal." ) ON DUPLICATE KEY UPDATE $fieldeqval ";
			$res = $this->oMysqli->query( $this->sSql );
		}
		return $res;
	}
	
	
	/*
	*	Add/edit song rights
	*/
	public function addSongRights(array $a=array()) {
		if($a){
		
			$songId=$this->oMysqli->secure($a['songId']);
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


			
				$this->sSql = "INSERT INTO `song_rights` (`song_id`,`is_owned`,`banner_id`,`territory_in`,`territory_ex`,`start_date`,`expiry_date`,`physical_rights`,`publishing_rights`,`digital_rights`,`is_exclusive`,`insert_date`) VALUES ('".$songId."','".$isCtype."','".$banner_id."','".$territory_in."','".$territory_ex."','".$start_date."','".$end_date."','".$physical_rights."',".$publishing_rights.",".$digital_rights.",".$is_exclusive.",now()) ON DUPLICATE KEY UPDATE `is_owned`='".$isCtype."',`banner_id`='".$banner_id."',`territory_in`='".$territory_in."',`territory_ex`='".$territory_ex."',`start_date`='".$start_date."',`expiry_date`='".$end_date."',`physical_rights`='".$physical_rights."',`publishing_rights`=".$publishing_rights.",`digital_rights`=".$digital_rights.",`is_exclusive`='".$is_exclusive."'";			
			
			
		//	echo $this->sSql;
			$data=$this->oMysqli->query($this->sSql);
			
			/*if( $legal_status==2 ){
				$up_sql = "UPDATE song_mstr SET `status`=2 WHERE song_id='".$songId." AND `status`=0 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}else if( $legal_status==0 ){
				$up_sql = "UPDATE song_mstr SET `status`=0 WHERE song_id='".$songId." 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}	*/		
			
			return $data;
		}
	}
	/*********************************************
	* Get map rights with song 
	* @Param: array()
	**********************************************/
	public function getRightsBySongId( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM song_rights WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	
/*		save in temp table
	*/
	public function saveTempBulk( array $a= array() ){
		$isrc=$this->oMysqli->secure($a['isrc']);
		$song_title=$this->oMysqli->secure($a['song_title']);
		$song_language=$this->oMysqli->secure($a['song_language']);
		$release_date =$this->oMysqli->secure($a['release_date']);
		$track_duration=$this->oMysqli->secure($a['track_duration']);
		$song_tempo=$this->oMysqli->secure($a['song_tempo']);
		$subject_parody=$this->oMysqli->secure($a['subject_parody']);
		$file_path=$this->oMysqli->secure($a['file_path']);
		$album_name=$this->oMysqli->secure($a['album_name']);
		$singer=$this->oMysqli->secure($a['singer']);
		$music_director=$this->oMysqli->secure($a['music_director']);
		$lyricist=$this->oMysqli->secure($a['lyricist']);
		#$poet=$this->oMysqli->secure($a['poet']);
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
		$region=$this->oMysqli->secure($a['region']);
		$grade=$this->oMysqli->secure($a['grade']);
		$remarks=$this->oMysqli->secure($a['remark']);
		$batch_id = $this->oMysqli->secure($a['batch_id']);
		$id = $this->oMysqli->secure($a['id']);
		$status=$this->oMysqli->secure($a['status']);
		
		if($id>0){
			$this->sSql="
UPDATE `song_bulk_temp` SET	`song_title` = '".$song_title."' , 	`isrc` = '".$isrc."' , 	`song_language` = '".$song_language."' , 	`release_date` = '".$release_date."' , 	`track_duration` = '".$track_duration."' , 	`song_tempo` = '".$song_tempo."' , 	`subject_parody` = '".$subject_parody."' , 	`file_path` = '".$file_path."' , 	`album_name` = '".$album_name."' , 	`singer` = '".$singer."' , 	`music_director` = '".$music_director."' , 	`lyricist` = '".$lyricist."' , 	`starcast` = '".$starcast."' , 	`mimicked_star` = '".$mimicked_star."' , 	`version` = '".$version."' , 	`genre` = '".$genre."' , 	`mood` = '".$mood."' , 	`relationship` = '".$relationship."' , 	`raag` = '".$raag."' , 	`taal` = '".$taal."' , 	`time_of_day` = '".$time_of_day."' , 	`religion` = '".$religion."' , 	`saint` = '".$saint."' , 	`instrument` = '".$instrument."' , 	`festival` = '".$festival."' , 	`occasion` = '".$occasion."' , 	`region` = '".$region."' , 	`grade` = '".$grade."' , 	`update_date` = now() , 	`remarks` = '".$remarks."' , 	`batch_id` = '".$batch_id."',`status`='".$status."'		WHERE	`id` = '".$id."' LIMIT 1";		
		}else{		
			$this->sSql = "
insert into `song_bulk_temp` 	(`song_title`, 	`isrc`, 	`song_language`, 	`release_date`, 	`track_duration`, 	`song_tempo`, 	`subject_parody`, 	`file_path`, 	`album_name`, `singer`, 	`music_director`, 	`lyricist`, 	`starcast`, 	`mimicked_star`, 	`version`, 	`genre`, 	`mood`, 	`relationship`, 	`raag`, 	`taal`, 	`time_of_day`, 	`religion`, 	`saint`, 	`instrument`, 	`festival`, 	`occasion`, 	`region`, 	`status`, 	`insert_date`, 	`remarks`, `batch_id` ,`grade`	)
	values
	('".$song_title."', 	'".$isrc."', 	'".$song_language."', 	'".$release_date."', 	'".$track_duration."', 	'".$song_tempo."', 	'".$subject_parody."', 	'".$file_path."', '".$album_name."', '".$singer."', 	'".$music_director."', 	'".$lyricist."', 	'".$starcast."', '".$mimicked_star."', 	'".$version."', 	'".$genre."', 	'".$mood."', 	'".$relationship."', 	'".$raag."', 	'".$taal."', 	'".$time_of_day."', 	'".$religion."', 	'".$saint."', 	'".$instrument."', 	'".$festival."', 	'".$occasion."', 	'".$region."', 	0, 	now(), 	'".$remarks."', '".$batch_id."' , '".$grade."'	);";
		}
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns all BulkSong 
	*@Param: array()
	********************************************/
	public function getAllBulkSongs( array $a = array() ){
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
		$this->sSql = "SELECT * FROM `song_bulk_temp` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	

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
		$this->sSql = "SELECT COUNT(DISTINCT batch_id) as cnt FROM `song_bulk_temp` sm WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	function updateGoToDbBulk( array $a = array() ){
		$id=$a['id'];
		$this->sSql = "UPDATE `song_bulk_temp` SET gotodb='1',update_date=now() WHERE id='".$id."'";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	public function __toString(){
        return $this->sSql;
    }
	
}