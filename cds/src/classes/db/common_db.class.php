<?php

class common_db {
	protected $messenger;
	protected $oMysqli; 
	protected $sSql;
	protected $aConfig;
	protected $song_label_map = array();
	
	public static function getCommonInstance($oMysqli){
		static $inst = null;
		if ($inst === null) {
			$inst = new common_db($oMysqli);
		}
		return $inst;
	}
	
	private function __construct($oMysqli){
		global $messenger,$aConfig;
		$this->messenger=&$messenger;
		
		$this->oMysqli=$oMysqli;
		$this->aConfig = $aConfig;

		
	}

	public function IsNumericarr($arr){
		if(!is_array($arr)){
			return false;
		}
		else{
			foreach($arr as $ar){
				if(!is_numeric($ar)){
					return false;
					exit;
				}
			}
			return true;
		}
	}
	
	public function getplaylistcontenttype($value){
		if( $value){
			foreach( $this->aConfig['playlist_content_type'] as $kkk=>$vvv ){
				if( $value == $vvv )
					return $kkk;
			}
		}
	}
	
	public function getalbumcontenttype($value){
		$ret_arr = array();
		if( $value > 0 ){
			foreach( $this->aConfig['album_content_type'] as $kkk=>$vvv ){
				if( ($value & $vvv) == $vvv ){
					$ret_arr[]=$kkk;
				}
			}
		}
		return $ret_arr;
	}
	
	public function getalbumtype($value){
		$ret_arr = array();
		if( $value > 0 ){
			foreach( $this->aConfig['album_type'] as $kkk=>$vvv ){
				if( ($value & $vvv) == $vvv ){
					$ret_arr[]=$kkk;
				}
			}
		}
		return $ret_arr;
	}
	
	public function getartistrolearr($dbArtistType){
		
		$ret_arr = array();
		if( $dbArtistType > 0 ){
			foreach( $this->aConfig['artist_type'] as $kkk=>$vvv ){
				if( ($dbArtistType & $vvv) == $vvv ){
					$ret_arr[]=$kkk;
				}
			}
		}
		return $ret_arr;
	}
	
	public function getAudioLyrics($audioIds){
		
		if($audioIds){
			 $lyrics_sql = "SELECT song_id,lyrics FROM lyrics_mstr WHERE song_id";
			$where='';
			if(is_array($audioIds)){
				if(sizeof($audioIds) >1){
					$where = ' IN ( '.implode (',', $audioIds).')';
				}else{
					$where = ' = '.trim($audioIds[0]);
				}
			}else{ 
					$where = ' = '.trim($audioIds);
			}
			
			$this->sSql = $lyrics_sql." ".$where;
	
			$res = $this->oMysqli->query($this->sSql);
			$lyrics_arr= array();			
			if(sizeof($res) >0){
			
				foreach($res as $resValue){
					$lyrics_arr[$resValue->song_id] = strip_tags($resValue->lyrics);
				}
				
				
			}
			return $lyrics_arr;
		}
		
		
	}
	
	
	public function getAudioTags($audioIds){
	
		if($audioIds){
			$tag_sql = 'SELECT pmstr.tag_id as id , mstr.tag_id ,atag.song_id, mstr.tag_name as tag_value, pmstr.tag_name as tag_name
						FROM song_tags atag INNER JOIN tags_mstr mstr ON (atag.tag_id = mstr.tag_id )
						INNER JOIN tags_mstr pmstr ON (pmstr.tag_id = mstr.parent_tag_id)
						WHERE mstr.status=1 and atag.song_id ';
			
			$where='';
			if(is_array($audioIds)){
				if(sizeof($audioIds) >1){
					$where = ' in ( '.implode (',', $audioIds).')';
				}else{
					$where = ' = '.trim($audioIds[0]);
				}
			}else{
				$where = ' = '.trim($audioIds);
			}
			
			 $this->sSql = $tag_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			
			$tag_arr= array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$tag = array();
					$tag["tag_name"]=$resValue->tag_name;
					$tag["tag_value"]=$resValue->tag_value;
					$tag["tag_id"]=$resValue->tag_id;
					if(!key_exists($resValue->song_id,$tag_arr))
						$tag_arr[$resValue->song_id] = array();
					$tag_arr[$resValue->song_id][] = $tag;
				}
			}
			return $tag_arr;
		}
	}


	// what is this ??
/*	public function getTagsAudio($tagIds){
			$limit   = (int)$this->messenger["query"]["limit"];
			$start   = (int)$this->messenger["query"]["start"];

		if($tagIds){
						
						$tag_sql = 'SELECT t.tag_id ,t.song_id, sm.song_id,sm.song_name,sm.language_id,sm.album_id,am.album_name,sm.label_id
						FROM song_tags t INNER JOIN song_mstr sm ON (t.song_id = sm.song_id )
						INNER JOIN `album_mstr` am ON sm.album_id=am.album_id WHERE t.tag_id';
			
			$where='';
			if(is_array($tagIds)){
				if(sizeof($tagIds) >1){
					$where = ' IN ( '.implode (',', $tagIds).')';
				}else{
					$where = ' = '.trim($tagIds[0]). " LIMIT $start,$limit";
				}
			}else{
					$where = ' = '.trim($tagIds). " LIMIT $start,$limit";
			}
			
			 $this->sSql = $tag_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			
			$tag_arr= array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$tag = array();
					$tag["song_id"]=$resValue->song_id;
					$tag["song_name"]=$resValue->song_name;
					$tag["language_id"]=$resValue->language_id;
					$tag["album_id"]=$resValue->album_id;
					$tag["album_name"]=$resValue->album_name;
					$tag["label_id"]=$resValue->label_id;					
					$tag["tag_id"]=$resValue->tag_id;
					
					if(!key_exists($resValue->song_id,$tag_arr))
						$tag_arr[$resValue->song_id] = array();
					$tag_arr[$resValue->song_id][] = $tag;
				}
			}
			return $tag_arr;
		}
	}*/
	
	public function getAlbumTags($albumIds){
		if($albumIds){
			$tag_sql = 'SELECT mstr.tag_id , mstr.tag_name AS tag_value, pmstr.tag_name AS tag_name ,atag.album_id AS album_id
						FROM album_tags atag INNER JOIN tags_mstr mstr ON (atag.tag_id = mstr.tag_id )
						INNER JOIN saregama_db.tags_mstr pmstr ON (pmstr.tag_id = mstr.parent_tag_id)
						WHERE mstr.status=1 and atag.album_id';
				
			$where='';
			if(is_array($albumIds)){
				if(sizeof($albumIds) >1){
					$where = ' in ( '.implode (',', $albumIds).')';
				}else{
					$where = ' = '.trim($albumIds[0]);
				}
			}else{
				$where = ' = '.trim($albumIds);
			}
				
			$this->sSql = $tag_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$tag_arr= array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$tag = array();
					$tag["tag_name"]=$resValue->tag_name;
					$tag["tag_value"]=$resValue->tag_value;
					if(!key_exists($resValue->album_id,$tag_arr))
						$tag_arr[$resValue->album_id] = array();
					$tag_arr[$resValue->album_id][] = $tag;
				}
			}
			return $tag_arr;
		}
	}
	
	public function getArtistForAlbum($album_ids){

		if($album_ids){
			$sql = 'SELECT am.artist_name , am.artist_id , aa.artist_role ,aa.album_id 
					FROM artist_mstr am INNER JOIN artist_album aa ON am.artist_id = aa.artist_id 
					WHERE am.status=1 AND aa.album_id ';
			$where = '';
			if(is_array($album_ids)){
				if(sizeof($album_ids) >1){
					$where = ' IN ( '.implode (',', $album_ids).')';
				}else{
					$where = ' = '.trim($album_ids[0]);
				}
			}else{
				$where = ' = '.trim($album_ids);
			}
			$this->sSql = $sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$artist_arr= array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$artist = new artist_db_dto();
					$artist->setartist_id($resValue->artist_id);
					$artist->setartist_name($resValue->artist_name);
					$artist->setartist_role($this->getartistrolearr($resValue->artist_role));
					if(!key_exists($resValue->album_id,$artist_arr))
						 $artist_arr[$resValue->album_id] = array();
					$artist_arr[$resValue->album_id][] = $artist;
				}
			}
			return $artist_arr;
		}else{
			
		}
	}
	
	public function getArtistForVideo($video_ids){

		if($video_ids){
			$sql = 'SELECT am.artist_name , am.artist_id , av.artist_role ,av.video_id 
					FROM artist_mstr am INNER JOIN artist_video av ON am.artist_id = av.artist_id 
					WHERE am.status=1 AND av.video_id ';
			$where = '';
			if(is_array($video_ids)){
				if(sizeof($video_ids) >1){
					$where = ' IN ( '.implode (',', $video_ids).')';
				}else{
					$where = ' = '.trim($video_ids[0]);
				}
			}else{
				$where = ' = '.trim($video_ids);
			}
			$this->sSql = $sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$artist_arr= array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$artist = new artist_db_dto();
					$artist->setartist_id($resValue->artist_id);
					$artist->setartist_name($resValue->artist_name);
					$artist->setartist_role($this->getartistrolearr($resValue->artist_role));
					if(!key_exists($resValue->video_id,$artist_arr))
						 $artist_arr[$resValue->video_id] = array();
					$artist_arr[$resValue->video_id][] = $artist;
				}
			}
			return $artist_arr;
		}else{
			
		}
	}
	
	public function getArtistsForAudio($song_ids){
	

		if($song_ids){
			
			$sql = 'SELECT am.artist_id,am.artist_name,ars.artist_role,ars.song_id
			FROM artist_song ars INNER JOIN artist_mstr am ON  am.artist_id = ars.artist_id
			WHERE am.status=1 AND ars.song_id  ';
			$where = '';
			if(is_array($song_ids)){
				if(sizeof($song_ids) >1){
					$where = ' in ( '.implode (',', $song_ids).')';
				}else{
					$where = ' = '.trim($song_ids[0]);
				}
			}else{
				$where = ' = '.trim($song_ids);
			}
			$this->sSql = $sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$artist_arr = array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$artist = new artist_db_dto();
					$artist->setartist_id($resValue->artist_id);
					$artist->setartist_name($resValue->artist_name);
					$artist->setartist_role($this->getartistrolearr($resValue->artist_role));
					if(!key_exists($resValue->song_id,$artist_arr))
						 $artist_arr[$resValue->song_id] = array();
					$artist_arr[$resValue->song_id][] = $artist;
				}
			}
			return $artist_arr;
		}
	}

	public function getVideoForArtist($video_ids){

	$limit     = (int)$this->messenger["query"]["limit"];
	$start     = (int)$this->messenger["query"]["start"];

		$orderBy = '';
		
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY ".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}
	
		if($video_ids){
					
			$sql = "SELECT vm.video_id,vm.video_name,lm.language_name,vm.video_duration,vm.tempo,vm.video_file,vm.image,vm.release_date
						FROM `video_mstr` vm
						INNER JOIN language_mstr lm ON lm.language_id=vm.language_id AND lm.status=1
						INNER JOIN artist_video av ON  av.video_id=vm.video_id
						WHERE av.artist_id";
					
			
			$where = '';
			if(is_array($video_ids)){
				if(sizeof($video_ids) >1){
					$where = ' IN ( '.implode (',', $video_ids).')';
				}else{
					$where = ' = '.trim($video_ids[0]);
				}
			}else{
					$where = ' = '.trim($video_ids);
			}
			
			$this->sSql = $sql.' '.$where.' '.$orderBy.' LIMIT '.$start.','.$limit;			
			
			$res = $this->oMysqli->query($this->sSql);
			$video_arr = array();
			$data = array();
			if(sizeof($res)>0 && $res!=-1){
				foreach ($res as $resValue){
				$video = new video_db_dto();
				$video->setvideo_id($resValue->video_id);
				$video_ids_arr[] = $resValue->video_id;
				$video->setvideo_name($resValue->video_name);
				$video->setvideo_language($resValue->language_name);
				$video->setvideo_image($resValue->image);
				$video->setvideo_release_date($resValue->release_date);
				$video->setvideo_file($resValue->video_file);
				$video->setvideo_tempo($resValue->tempo);
				
				$data[]=$video;
				
				}
			
			$artist_video_map = common_db::getArtistForVideo($video_ids_arr);			
			foreach($data as $video){
				$id = $video->getvideo_id();
				
				if(key_exists($id,$artist_video_map))
					$video->setvideo_artist($artist_video_map[$id]);
					
			}
	
			}
		
		return $data;

		}
	}		

	public function getImagesForAudio($song_ids){
		if($song_ids){
			$sql = 'SELECT am.album_id,am.album_image,sm.song_id 
					FROM song_mstr AS sm,album_mstr AS am
					WHERE am.status=1 AND sm.status=1 AND sm.album_id=am.album_id AND sm.song_id  ';
			$where = '';
			if(is_array($song_ids)){
				if(sizeof($song_ids) >1){
					$where = ' in ( '.implode (',', $song_ids).')';
				}else{
					$where = ' = '.trim($song_ids[0]);
				}
			}else{
				$where = ' = '.trim($song_ids);
			}
			$this->sSql = $sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$image_arr = array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					if($resValue->album_image){
						$image_arr[$resValue->song_id] = MEDIA_SITEPATH_IMAGE.$resValue->album_image;
					}	
				}
			}
			return $image_arr;
		}
	}
	
	public function getVideosForAudio($song_ids){
		
		if($song_ids){
			$video_sql = 'SELECT vm.video_id,sv.song_id,vm.video_name,vm.video_file,vm.image,vm.video_duration,vm.tempo,
								vm.subject_parody,vm.release_date,vm.origin_state_id,lm.language_name 
						FROM video_mstr vm 
						LEFT JOIN song_video sv ON (vm.video_id=sv.video_id)
						LEFT JOIN language_mstr lm ON (lm.language_id=vm.language_id)
						WHERE sv.song_id';			
				
			$where='';
			if(is_array($song_ids)){
				if(sizeof($song_ids) >1){
					$where = ' IN ( '.implode (',', $song_ids).')';
				}else{
					$where = ' = '.trim($song_ids[0]);
				}
			}else{
				$where = ' = '.trim($song_ids);
			}
				
			$this->sSql = $video_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$video_arr= array();
			if(sizeof($res) >0){
				$videos = array();
				foreach ($res as $resValue){

					$videos["video_id"]=$resValue->video_id;
					$videos["video_name"]=$resValue->video_name;
					$videos["video_file"]=$resValue->video_file;
					$videos["video_img"]=$resValue->image;
					$videos["video_duration"]=$resValue->video_duration;
					$videos["tempo"]=$resValue->tempo;
					$videos["subject_parody"]=$resValue->subject_parody;
					$videos["release_date"]=$resValue->release_date;
					$videos["origin_state_id"]=$resValue->origin_state_id;					
					if(!key_exists($resValue->video_id,$video_arr))
						$video_arr[$resValue->video_id] = array();
					$video_arr[$resValue->song_id][] = $videos;
				}
			}
			return $video_arr;
		}
	} 
	
	public function getImagesForAlbum($albumIds){
		if($albumIds){
			$album_img_sql = 'SELECT album_id,album_image FROM album_mstr  WHERE album_id';	
				
			$where='';
			if(is_array($albumIds)){
				if(sizeof($albumIds) >1){
					$where = ' IN ( '.implode (',', $albumIds).')';
				}else{
					$where = ' = '.trim($albumIds[0]);
				}
			}else{
				$where = ' = '.trim($albumIds);
			}
				
			$this->sSql = $album_img_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$album_img = array();
			if(sizeof($res) >0 && $res!=-1){
				foreach ($res as $resValue){	
						$album_img[$resValue->album_id]=$resValue->album_image;
					}
			}
			return $album_img;
		}
	}
	
	public function getVideosForAlbum($albumIds){
		if($albumIds){
			$album_video_sql = 'SELECT vm.video_id,av.album_id,vm.video_name,vm.video_file,vm.image,vm.video_duration,vm.tempo,
										vm.subject_parody,vm.release_date,vm.origin_state_id,lm.language_name 
								FROM video_mstr vm 
								LEFT JOIN album_video av ON (vm.video_id=av.video_id)
								LEFT JOIN language_mstr lm ON (lm.language_id=vm.language_id)
								WHERE av.album_id';
					
			$where='';
			if(is_array($albumIds)){
				if(sizeof($albumIds) >1){
					$where = ' IN ( '.implode (',', $albumIds).')';
				}else{
					$where = ' = '.trim($albumIds[0]);
				}
			}else{
				$where = ' = '.trim($albumIds);
			}
				
			$this->sSql = $album_video_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$video_arr= array();
			if(sizeof($res) >0){
				$videos = array();
				$i=0;
				foreach ($res as $resValue){	
					$videos["video_id"]=$resValue->video_id;
					$videos["video_name"]=$resValue->video_name;
					$videos["video_file"]=$resValue->video_file;
					$videos["video_img"]=$resValue->image;
					$videos["video_duration"]=$resValue->video_duration;
					$videos["tempo"]=$resValue->tempo;
					$videos["subject_parody"]=$resValue->subject_parody;
					$videos["release_date"]=$resValue->release_date;
					$videos["origin_state_id"]=$resValue->origin_state_id;
					
					$video_arr[$resValue->album_id][$i] = $videos;
					$i++;
				}
			}
			return $video_arr;
		}
	}
	
	public function getImagesForArtist($artistIds){
		if($artistIds){
			$artist_sql = 'SELECT artist_id,artist_image FROM artist_mstr WHERE artist_id';
				
			$where='';
			if(is_array($artistIds)){
				if(sizeof($artistIds) >1){
					$where = ' IN ( '.implode (',', $artistIds).')';
				}else{
					$where = ' = '.trim($artistIds[0]);
				}
			}else{
				$where = ' = '.trim($artistIds);
			}
				
			$this->sSql = $artist_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$artist_img_arr= array();
			if(sizeof($res) >0){
	
				foreach ($res as $resValue){
					$artist_img_arr[$resValue->artist_id] = MEDIA_SITEPATH_IMAGE.$resValue->artist_image;
				}
			}
			return $artist_img_arr;
		}
	}
	
	public function getPlaylistForEvent($event_id){	

		if($event_id){		
							
		$sql = 'SELECT em.event_id,emap.content_id as playlist_id,emap.content_type,pm.playlist_name,pm.image,pm.content_type as pl_content_type
						FROM event_mstr em
						LEFT JOIN event_map emap ON (em.event_id=emap.event_id)
						INNER JOIN playlist_mstr pm ON (pm.playlist_id=emap.content_id) AND emap.content_type=29
						WHERE em.status=0 AND em.event_id';
			$where = '';
			if(is_array($event_id)){
				if(sizeof($event_id) >1){
					$where = ' in ( '.implode (',', $event_id).')';
				}else{
					$where = ' = '.trim($event_id[0]);
				}
			}else{
				$where = ' = '.trim($event_id);
			}
			$this->sSql = $sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			
			$playlist_arr = array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$playlist = new playlist_db_dto();
					$playlist->setplaylist_id($resValue->playlist_id);
					$playlist->setplaylist_name($resValue->playlist_name);
					$playlist->setplaylist_image($resValue->image);
					$playlist->setplaylist_type($this->aConfig["playlist_content_type"][$resValue->pl_content_type]);
					$playlist_arr[] = $playlist;
				
				}
			}
			return $playlist_arr;
		}
	}
	
	
	public function getArtistForEvent($event_id){	

		if($event_id){		
							
		$sql = 'SELECT em.event_id,emap.content_id as artist_id,emap.content_type,am.artist_name,am.artist_image
						FROM event_mstr em
						LEFT JOIN event_map emap ON (em.event_id=emap.event_id)
						inner JOIN artist_mstr am ON (am.artist_id=emap.content_id) AND emap.content_type=13
						WHERE em.status=0 AND em.event_id';
			$where = '';
			if(is_array($event_id)){
				if(sizeof($event_id) >1){
					$where = ' in ( '.implode (',', $event_id).')';
				}else{
					$where = ' = '.trim($event_id[0]);
				}
			}else{
				$where = ' = '.trim($event_id);
			}
			$this->sSql = $sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			
			$artist_arr = array();
			if(sizeof($res) >0){
				foreach ($res as $resValue){
					$artist = new artist_db_dto();
					$artist->setartist_id($resValue->artist_id);
					$artist->setartist_name($resValue->artist_name);
					$artist->setartist_image($resValue->artist_image);
					$artist_arr[] = $artist;
				}
			}
			return $artist_arr;
		}
	}
	
	
	// what is this ??
	public function getImagesForArtistMap($artistImgIds){
	
		if($artistImgIds){
			$artist_img_sql = 'SELECT image_id,image_file FROM image_mstr WHERE image_id';
				
			$where='';
			if(is_array($artistImgIds)){
				if(sizeof($artistImgIds) >1){
					$where = ' IN ( '.implode (',', $artistImgIds).')';
				}else{
					$where = ' = '.trim($artistImgIds[0]);
				}
			}else{
				$where = ' = '.trim($artistImgIds);
			}
				
			$this->sSql = $artist_img_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$artist_img_arr= array();
			if(sizeof($res) >0){			
				foreach ($res as $resValue){
					$artist_img_arr[$resValue->image_id] = MEDIA_SITEPATH_IMAGE.$resValue->image_file;
				}
			}
			return $artist_img_arr;
		}
	}
	
	public function getVideosForArtist($artistIds){
		if($artistIds){
			$artist_video_sql = 'SELECT vm.video_id,vm.video_name,vm.image FROM video_mstr vm INNER JOIN artist_video av ON (vm.video_id=av.video_id)
						  WHERE av.artist_id';
		
				
			$where='';
			if(is_array($artistIds)){
				if(sizeof($artistIds) >1){
					$where = ' IN ( '.implode (',', $artistIds).')';
				}else{
					$where = ' = '.trim($artistIds[0]);
				}
			}else{
				$where = ' = '.trim($artistIds);
			}
				
			$this->sSql = $artist_video_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$video_arr= array();
			if(sizeof($res) >0){
				$videos = array();
				foreach ($res as $resValue){
	
					$videos["video_id"]=$resValue->video_id;
					$videos["video_name"]=$resValue->video_name;
					$videos["video_img"]=$resValue->image;
					
					if(!key_exists($resValue->video_id,$video_arr))
						$video_arr[$resValue->video_id] = array();
					$video_arr[$resValue->video_id][] = $videos;
				}
			}
			return $video_arr;
		}
	}
	
	public function getLanguageName($id){
			$this->sSql = "SELECT `language_name` FROM `language_mstr` WHERE status=1 AND language_id=".trim($id);
			return $res = $this->oMysqli->query($this->sSql);
	}
	
	public function checkRole($role){
	
		global $aConfig_arr;
	
				if(($aConfig_arr['Director']&$role)==$aConfig_arr['Director']){
					$roleArry[]="Director";
				}
				if(($aConfig_arr['Producer']&$role)==$aConfig_arr['Producer']){
					$roleArry[]="Producer";
				}
				if(($aConfig_arr['Starcast']&$role)==$aConfig_arr['Starcast']){
					$roleArry[]="Starcast";
				}
				if(($aConfig_arr['Music Director']&$role)==$aConfig_arr['Music Director']){
					$roleArry[]="Music Director";
				}
				if(($aConfig_arr['Lyricist']&$role)==$aConfig_arr['Lyricist']){
					$roleArry[]="Lyricist";
				}
				if(($aConfig_arr['Singer']&$role)==$aConfig_arr['Singer']){
					$roleArry[]="Singer";
				}
				if(($aConfig_arr['Poet']&$role)==$aConfig_arr['Poet']){
					$roleArry[]="Poet";
				}
				
			return 	$roleArry;
	}
	
	public function getAlbumBanner($albumIds){
	
		if($albumIds){
			$album_banner_sql = 'SELECT bm.banner_id,bm.banner_name,ab.album_id FROM banner_mstr bm LEFT JOIN album_banner ab ON (bm.banner_id=ab.banner_id) WHERE ab.album_id';					  		
			$where='';
			if(is_array($albumIds)){
				if(sizeof($albumIds) >1){
					$where = ' IN ( '.implode (',', $albumIds).')';
				}else{
					$where = ' = '.trim($albumIds[0]);
				}
			}else{
				$where = ' = '.trim($albumIds);
			}
				
			$this->sSql = $album_banner_sql.' '.$where;
			$res = $this->oMysqli->query($this->sSql);
			$banner_arr= array();
			if(sizeof($res) >0){
				$banner = array();
				foreach ($res as $resValue){
	
					$banner["banner_id"]=$resValue->banner_id;
					$banner["banner_name"]=$resValue->banner_name;
					
					if(!key_exists($resValue->banner_id,$banner_arr))
						$banner_arr[$resValue->album_id] = array();
					$banner_arr[$resValue->album_id][] = $banner;
				}
			}
			return $banner_arr;
		}
	
	
	}
	
	public function getLabelName($labelId){
		if(key_exists($labelId,$this->song_label_map)){
			return $this->song_label_map[$labelId];
		}
		$label_sql = "SELECT label_name FROM label_mstr WHERE label_id = ".trim($labelId);
		$res = $this->oMysqli->query($label_sql);
		if(sizeof($res)>0){
			$this->song_label_map[$labelId] = $res[0]->label_name;
			return $res[0]->label_name;
		}
	}

	public function __toString(){
		return $this->sSql;
	}
	
	private function __clone(){
	
	}
	
}
?>