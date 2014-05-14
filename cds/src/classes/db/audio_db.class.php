<?php
class audio_db extends base_db{

	protected $_default_arr = array("audio_id","audio_name","audio_language","audio_rel_dt","audio_album",
									"audio_duration","audio_isrc","audio_tags","audio_artist");
	protected $_includes_arr = array("audio_tempo","audio_sub_parody","audio_label","audio_lyrics");
	protected $_criteria_arr = array("audio_language_id","audio_label_id","audio_rel_dt");
	
	//TODO so and sf breaks the code
	public function __construct($oMysqli){
		parent::__construct($oMysqli);
	}

	public function getdetails(){

		$audio_id = $this->messenger["query"]["id"];		
		
		if(is_numeric($audio_id)){
				
			$this->sSql = "SELECT sm.song_id,sm.song_name,sm.audio_file,sm.album_id,am.album_name,sm.language_id,sm.song_duration,sm.isrc,sm.release_date,
								  lm.language_name @@@tempo@@@ @@@subject_parody@@@ @@@label@@@
							FROM `song_mstr` sm 
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id
							LEFT JOIN `album_mstr` am ON sm.album_id=am.album_id
							WHERE sm.status = 1 and song_id=".trim($audio_id);
			$this->apply_includes();
			$res = $this->oMysqli->query($this->sSql);		
	
			if(sizeof($res)==1 && $res!=-1){
			
				foreach($res as $resValue){
					$audio = new audio_db_dto();
					$audio->setaudio_id($resValue->song_id);
					$audio->setaudio_name($resValue->song_name);
					$audio->setaudio_file($resValue->audio_file);
					$audio->setaudio_album_id($resValue->album_id);
					$audio->setaudio_album_name($resValue->album_name);
					$audio->setaudio_isrc($resValue->isrc);
					$audio->setaudio_release_date($resValue->release_date);
					$audio->setaudio_language_id($resValue->language_id);		
					$audio->setaudio_language_name($resValue->language_name);
					$audio->setaudio_duration($resValue->song_duration);
					$audio_image= $this->oCommon->getImagesForAudio($resValue->song_id);
					if(key_exists($resValue->song_id,$audio_image))
						$audio->setaudio_image($audio_image[$resValue->song_id]);
				
					if(in_array("audio_tempo",$this->req_includes_arr)){
						$audio->setaudio_tempo($resValue->tempo);
					}
					if(in_array("audio_sub_parody",$this->req_includes_arr)){
						$audio->setaudio_subject_parody($resValue->subject_parody);
					}
					
					if(in_array("audio_label",$this->req_includes_arr)){
						$audio->setaudio_label_id($resValue->label_id);
						$audio->setaudio_label_name($this->oCommon->getLabelName($resValue->label_id));
					}
					if(in_array("audio_lyrics",$this->req_includes_arr)){
						$audio_lyrics_arr = $this->oCommon->getAudioLyrics($audio_id);
						
						if($audio_lyrics_arr!=null && key_exists($audio_id,$audio_lyrics_arr))
							$audio->setaudio_lyrics($audio_lyrics_arr[$audio_id]);
					}
					if(in_array("audio_tags",$this->req_includes_arr)){
						$audio_tags_arr = $this->oCommon->getAudioTags($audio_id);
						if($audio_tags_arr!=null && key_exists($audio_id,$audio_tags_arr))
							$audio->setaudio_tags($audio_tags_arr[$audio_id]);	
					}			

					$artist_audio_map = $this->oCommon->getArtistsForAudio($audio_id);
					if(key_exists($audio_id,$artist_audio_map))
						$audio->setaudio_artist($artist_audio_map[$audio_id]);
					
				}
				
				$container =  new container_db_dto();
				$container->setdata($audio);
				return $container->to_array();	
				
			}else throw new Exception("Illegal query");
		
		}else throw new Exception("Please insert only numeric audio ID");
		
	}
	
	public function get_all_audio(){
		
		$container = new container_db_dto();
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];
		$orderBy = "";
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY sm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}
		$where   = ' WHERE sm.status = 1 ';
		$this->apply_where_criteria($where);
		$this->sSql = 'SELECT count(sm.song_id) as cnt
						FROM `song_mstr` sm
						INNER JOIN `language_mstr` lm ON sm.language_id=lm.language_id '.$where;
		$this->apply_includes();
		
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		$data = array();
		if(sizeof($res)>0 && $res!=-1){
			$container->settotal_count($res[0]->cnt);
		
			$this->sSql = 'SELECT sm.song_id,sm.song_name,sm.audio_file,sm.album_id,am.album_name,sm.language_id,sm.audio_file,sm.song_duration,sm.isrc,
							sm.release_date,
							lm.language_name @@@tempo@@@ @@@subject_parody@@@ @@@label@@@
							FROM `song_mstr` sm
							INNER JOIN `language_mstr` lm ON sm.language_id=lm.language_id 
							INNER JOIN `album_mstr` am ON sm.album_id=am.album_id '.$where .' '.$orderBy ." LIMIT $start, $limit";
							
							
			$this->apply_includes();
			
			$res = $this->oMysqli->query($this->sSql);
			$audio_ids_arr = array();
			
			if(sizeof($res)>0){
				foreach ($res as $resValue){
					$audio = new audio_db_dto();
					$audio->setaudio_id($resValue->song_id);
					$audio_ids_arr[] = $resValue->song_id;
					$audio->setaudio_name($resValue->song_name);
					$audio->setaudio_file($resValue->audio_file);
					$audio->setaudio_album_id($resValue->album_id);
					$audio->setaudio_album_name($resValue->album_name);
					$audio->setaudio_isrc($resValue->isrc);
					$audio->setaudio_release_date($resValue->release_date);
					$audio->setaudio_language_id($resValue->language_id);
					$audio->setaudio_language_name($resValue->language_name);
					if(in_array("audio_tempo",$this->req_includes_arr)){
						$audio->setaudio_tempo($resValue->tempo);
					}
					if(in_array("audio_sub_parody",$this->req_includes_arr)){
						$audio->setaudio_subject_parody($resValue->subject_parody);
					}
					if(in_array("audio_label",$this->req_includes_arr)){
						$audio->setaudio_label_id($resValue->label_id);
						$audio->setaudio_label_name($this->oCommon->getLabelName($resValue->label_id));
					}
					
	
					$data[] = $audio;
				}
				
				$audio_image_map = $this->oCommon->getImagesForAudio($audio_ids_arr);
				$artist_song_map = $this->oCommon->getArtistsForAudio($audio_ids_arr);
				$audio_tag_map = array();
				$audio_lyrics_map = array();
				
				if(in_array("audio_tags",$this->req_includes_arr))
					$audio_tag_map = $this->oCommon->getAudioTags($audio_ids_arr);
	
	
				if(in_array("audio_lyrics",$this->req_includes_arr))
					$audio_lyrics_map = $this->oCommon->getAudioLyrics($audio_ids_arr);
	
					
				foreach($data as $audio){
					if(key_exists($audio->getaudio_id() , $audio_tag_map))
						$audio->setaudio_tags($audio_tag_map[$audio->getaudio_id()]);
					if(key_exists($audio->getaudio_id() ,$artist_song_map))
						$audio->setaudio_artist($artist_song_map[$audio->getaudio_id()]);
					if(key_exists($audio->getaudio_id() ,$audio_image_map)){
						$audio->setaudio_image($audio_image_map[$audio->getaudio_id()]);
					}
					if(key_exists($audio->getaudio_id() ,$audio_lyrics_map)){
						$audio->setaudio_lyrics($audio_lyrics_map[$audio->getaudio_id()]);
					}	
		
				}
			}
		}
		
		$container->setdata($data);
		return $container->to_array();
	}
	
	public function get_audio_images(){
		//TODO Exception
	}
	
	public function get_audio_videos(){	
	
		$audio_id	 = $this->messenger["query"]["id"];
		
		if(!is_numeric($audio_id))
			 throw new Exception("invalid Id");
			
		$container = new container_db_dto();		
		$audio = new audio_db_dto();
		
		
		$audio->setaudio_video($this->oCommon->getVideosForAudio($audio_id));

		$data[] = $audio;
		
		$container->setdata($data);
		return $container->to_array();

	
	}

	public function get_audio_by_tag(){
	
		
		$tag_id	 = $this->messenger["query"]["id"];
		$tagIds = explode(",",urldecode($tag_id));		
		$IdChk = $this->oCommon->IsNumericarr($tagIds);

		if($IdChk===false)
			throw new Exception("Invalid Id");

	
		$container = new container_db_dto();
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];
	
	
		$condition='';
		if(is_array($tagIds)){
			if(sizeof($tagIds) >1){
				$condition = ' t.tag_id IN ( '.implode (',', $tagIds).')';
			}else{
				$condition = ' t.tag_id = '.trim($tagIds[0]);
			}
		}else{

			$condition = ' t.tag_id= '.trim($tagIds);
		}
	
	
		$orderBy = "";
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY sm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}
		$where   = ' where sm.status = 1 ';
		$this->apply_where_criteria($where);
		$this->sSql = "SELECT count(sm.song_id) as cnt
		FROM `song_mstr` sm
		INNER JOIN `language_mstr` lm ON sm.language_id=lm.language_id
		INNER JOIN `song_tags` t ON sm.song_id=t.song_id
		INNER JOIN `album_mstr` am ON sm.album_id=am.album_id  $where  AND $condition";
	
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		if(sizeof($res)>0){
			$container->settotal_count($res[0]->cnt);
		}
	
	
		$this->sSql = "SELECT t.tag_id,sm.song_id,sm.song_name,sm.album_id,am.album_name,am.album_image,sm.language_id,sm.audio_file,sm.song_duration,sm.isrc,sm.release_date,
		lm.language_name @@@tempo@@@ @@@subject_parody@@@ @@@label@@@
		FROM `song_mstr` sm
		INNER JOIN `language_mstr` lm ON sm.language_id=lm.language_id
		INNER JOIN `song_tags` t ON sm.song_id=t.song_id
		INNER JOIN `album_mstr` am ON sm.album_id=am.album_id  $where  AND $condition $orderBy LIMIT $start, $limit";
	
	
		$this->apply_includes();
		$res = $this->oMysqli->query($this->sSql);
		$audio_ids_arr = array();
		$data = array();
		if(sizeof($res)>0){
			foreach ($res as $resValue){
				$audio = new audio_db_dto();
				$audio->setaudio_id($resValue->song_id);
				$audio_ids_arr[] = $resValue->song_id;
				$audio->setaudio_name($resValue->song_name);
				$audio->setaudio_album_id($resValue->album_id);
				$audio->setaudio_album_name($resValue->album_name);
				$audio->setaudio_album_img($resValue->album_image);
				$audio->setaudio_isrc($resValue->isrc);
				$audio->setaudio_release_date($resValue->release_date);
				$audio->setaudio_language_id($resValue->language_id);
				$audio->setaudio_language_name($resValue->language_name);
				if(in_array("audio_tempo",$this->req_includes_arr)){
					$audio->setaudio_tempo($resValue->tempo);
				}
				if(in_array("audio_sub_parody",$this->req_includes_arr)){
					$audio->setaudio_subject_parody($resValue->subject_parody);
				}
				if(in_array("audio_label",$this->req_includes_arr)){
					$audio->setaudio_label_id($resValue->label_id);
					$audio->setaudio_label_name($this->oCommon->getLabelName($resValue->label_id));
				}
	
	
				$data[] = $audio;
			}
				
			$artist_song_map = $this->oCommon->getArtistsForAudio($audio_ids_arr);
			$audio_tag_map = array();
			$audio_lyrics_map = array();


			if(in_array("audio_tags",$this->req_includes_arr)){
				$audio_tag_map = $this->oCommon->getAudioTags($audio_ids_arr);
			}
	
			if(in_array("audio_lyrics",$this->req_includes_arr))
				$audio_lyrics_map = $this->oCommon->getAudioLyrics($audio_ids_arr);
	
	
			foreach($data as $audio){

				if(key_exists($audio->getaudio_id() , $audio_tag_map))
					$audio->setaudio_tags($audio_tag_map[$audio->getaudio_id()]);
				if(key_exists($audio->getaudio_id() ,$artist_song_map))
					$audio->setaudio_artist($artist_song_map[$audio->getaudio_id()]);
				if(key_exists($audio->getaudio_id() ,$audio_lyrics_map)){
					$audio->setaudio_lyrics($audio_lyrics_map[$audio->getaudio_id()]);
				}
	
			}
		}
	
		$container->setdata($data);
		return $container->to_array();
	}
	

	/*
	 * 
	 * These are helper functions*
	 * 
	 */
	
	public function getAudioForAlbum($albumIds){
		// no pagination required here
		
		if($albumIds){
			$audio_sql = "SELECT sa.song_id as audio_id, sm.song_name as audio_name,lm.language_id,lm.language_name ,sa.album_id,
						sm.song_duration as audio_duration ,sm.release_date, sm.isrc as audio_isrc @@@tempo@@@ @@@subject_parody@@@ @@@label@@@
						FROM song_album sa LEFT JOIN song_mstr sm ON sa.song_id=sm.song_id
						LEFT JOIN language_mstr lm ON lm.language_id=sm.language_id
						WHERE sm.status = 1 AND sa.album_id ";
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
			
			$this->apply_where_criteria($where);
			$this->sSql = $audio_sql.' '.$where;
			$this->apply_includes();
			$res = $this->oMysqli->query($this->sSql);
			
			$audio_arr = array();
			$audio_ids_arr = array();
			if(sizeof($res)>0){
				foreach($res as $resValue){
					$audio = new audio_db_dto();
					$audio->setaudio_id($resValue->audio_id);
					$audio_ids_arr[] = $resValue->audio_id;
					$audio->setaudio_name($resValue->audio_name);
					$audio->setaudio_isrc($resValue->audio_isrc);
					$audio->setaudio_language_id($resValue->language_id);
					$audio->setaudio_language_name($resValue->language_name);
					$audio->setaudio_release_date($resValue->release_date);
					if(in_array("audio_tempo",$this->req_includes_arr)){
						$audio->setaudio_tempo($resValue->tempo);
					}
					if(in_array("audio_sub_parody",$this->req_includes_arr)){
						$audio->setaudio_subject_parody($resValue->subject_parody);
					}
					if(in_array("audio_label",$this->req_includes_arr)){
						$audio->setaudio_label_id($resValue->label_id);
						$audio->setaudio_label_name($this->oCommon->getLabelName($resValue->label_id));
					}
					
						
					if(!key_exists($resValue->album_id,$audio_arr))
						$audio_arr[$resValue->album_id] = array();
					$audio_arr[$resValue->album_id][] = $audio;
				}
				
				$artist_song_map = $this->oCommon->getArtistsForAudio($audio_ids_arr);
				$audio_tag_map = array();
				$audio_lyrics_arr = array();
				if(in_array("audio_tags",$this->req_includes_arr))
					$audio_tag_map = $this->oCommon->getAudioTags($audio_ids_arr);
				if(in_array("audio_lyrics",$this->req_includes_arr)){
					$audio_lyrics_arr = $this->oCommon->getAudioLyrics($audio_ids_arr);
					
				}
					
			foreach($audio_arr as $album){
				
				
				foreach($album as $audio){
					
						if(key_exists($audio->getaudio_id() , $audio_tag_map)){
							$audio->setaudio_tags($audio_tag_map[$audio->getaudio_id()]);
						}	
						
						if(key_exists($audio->getaudio_id() ,$artist_song_map)){
							$audio->setaudio_artist($artist_song_map[$audio->getaudio_id()]);
						}
						
						if(key_exists($audio->getaudio_id() ,$audio_lyrics_arr)){
							$audio->setaudio_lyrics($audio_lyrics_arr[$audio->getaudio_id()]);
							
						}
					}
				
			}
			return $audio_arr;
		}
	}
}
	
	public function getAudioForArtist($artist_id){	
		
		if($artist_id){
			$container = new container_db_dto();
			$limit   = (int)$this->messenger["query"]["limit"];
			$start   = (int)$this->messenger["query"]["start"];
			$orderBy = "";
			if(	$this->messenger['query']['sf'] != '' ){
				$orderBy = " ORDER BY sm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
			}
			$where   = ' where sm.status = 1 and ars.artist_id = '.$artist_id.' ';
			$this->apply_where_criteria($where);
			$this->sSql = 'SELECT count(sm.song_id) as cnt
							FROM `song_mstr` sm
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id  
							LEFT JOIN `artist_song` ars ON ars.song_id =sm.song_id '.$where;
			$res = $this->oMysqli->query($this->sSql);
			if($res!=-1){
				$container->settotal_count($res[0]->cnt);
				$this->sSql = 'SELECT sm.song_id,sm.song_name,sm.audio_file,sm.album_id,sm.language_id,sm.audio_file,sm.song_duration,sm.isrc,sm.release_date,
							lm.language_name @@@tempo@@@ @@@subject_parody@@@ @@@label@@@
							FROM `song_mstr` sm
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id
							LEFT JOIN `artist_song` ars ON ars.song_id =sm.song_id '.$where.' '.$orderBy ." LIMIT $start, $limit";
				$this->apply_includes();
				$res = $this->oMysqli->query($this->sSql);
				$audio_arr = array();
				$audio_ids_arr = array();
				if(sizeof($res)>0){
					foreach($res as $resValue){
						$audio = new audio_db_dto();
						$audio->setaudio_id($resValue->song_id);
						$audio_ids_arr[] = $resValue->song_id;
						$audio->setaudio_name($resValue->song_name);
						$audio->setaudio_file($resValue->audio_file);
						$audio->setaudio_isrc($resValue->isrc);
						$audio->setaudio_language_id($resValue->language_id);
						$audio->setaudio_language_name($resValue->language_name);
						$audio->setaudio_release_date($resValue->release_date);
						if(in_array("audio_tempo",$this->req_includes_arr)){
							$audio->setaudio_tempo($resValue->tempo);
						}
						if(in_array("audio_sub_parody",$this->req_includes_arr)){
							$audio->setaudio_subject_parody($resValue->subject_parody);
						}
						if(in_array("audio_label",$this->req_includes_arr)){
							$audio->setaudio_label_id($resValue->label_id);
							$audio->setaudio_label_name($this->oCommon->getLabelName($resValue->label_id));
						}
						$audio_arr[] = $audio;
					}
					$artist_song_map = $this->oCommon->getArtistsForAudio($audio_ids_arr);
					$audio_tag_map = array();
					$audio_lyrics_arr = array();
					if(in_array("audio_tags",$this->req_includes_arr))
						$audio_tag_map = $this->oCommon->getAudioTags($audio_ids_arr);
					if(in_array("audio_lyrics",$this->req_includes_arr)){
						$audio_lyrics_arr = $this->oCommon->getAudioLyrics($audio_ids_arr);
					}
						
					foreach($audio_arr as $audio){
						if(key_exists($audio->getaudio_id() ,$artist_song_map))
							$audio->setaudio_artist($artist_song_map[$audio->getaudio_id()]);
						if(key_exists($audio->getaudio_id() , $audio_tag_map))
								$audio->setaudio_tags($audio_tag_map[$audio->getaudio_id()]);
						if(key_exists($audio->getaudio_id() ,$audio_lyrics_arr))
								$audio->setaudio_lyrics($audio_lyrics_arr[$audio->getaudio_id()]);
					}
					$container->setData($audio_arr);
				
				}
			}
			return $container->to_array();
		}else{
			return null;
			
		}
	}	

   
	
	private function apply_includes(){
	

			if(in_array("audio_tempo",$this->req_includes_arr)){
				$this->sSql = str_replace("@@@tempo@@@",", sm.tempo",$this->sSql);
			}else{
				$this->sSql = str_replace("@@@tempo@@@","",$this->sSql);
			}
			if(in_array("audio_sub_parody",$this->req_includes_arr)){
				$this->sSql = str_replace("@@@subject_parody@@@",", sm.subject_parody",$this->sSql);
			}else{
				$this->sSql = str_replace("@@@subject_parody@@@","",$this->sSql);
			}
			if(in_array("audio_label",$this->req_includes_arr)){
				$this->sSql = str_replace("@@@label@@@",", sm.label_id",$this->sSql);
			}else{
				$this->sSql = str_replace("@@@label@@@","",$this->sSql);
			}
		
	}
	
	
	private function apply_where_criteria(&$where){
		
		if(isset($this->req_criteria_arr["audio_language_id"])){
			$where = $where." and lm.language_id='".$this->req_criteria_arr["audio_language_id"]."'";
		}
		
		if(isset($this->req_criteria_arr["audio_rel_dt--<"])){
			$where = $where." and sm.release_date < '".$this->req_criteria_arr["audio_rel_dt--<"]."'";
		}
		
		if(isset($this->req_criteria_arr["audio_rel_dt-->"])){
			$where = $where." and sm.release_date > '".$this->req_criteria_arr["audio_rel_dt-->"]."'";
		}
		if(isset($this->req_criteria_arr["audio_label_id"])){
			$where = $where." and sm.label_id='".$this->req_criteria_arr["audio_label_id"]."'";
		}	
	}
	

}
?>