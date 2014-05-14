<?php

class playlist_db extends base_db{

	protected $_default_arr = array("playlist_id","playlist_name","image","language_id","language_name");
	protected $_includes_arr = array();
	protected $_criteria_arr = array("language_id","type");
	
	public function __construct($oMysqli){
		parent::__construct($oMysqli);
	}
	
	public function getdetails(){
		$playlist_id = $this->messenger["query"]["id"];
		if( is_numeric($playlist_id) ){
			$this->sSql = "SELECT playlist_id,playlist_name,image,pmstr.language_id,language_name,pmstr.content_type
						   FROM	playlist_mstr pmstr
						   LEFT JOIN language_mstr lmstr ON (pmstr.language_id=lmstr.language_id)
						   WHERE pmstr.status=1 AND playlist_id =".$playlist_id;
			$res = $this->oMysqli->query($this->sSql);
			
			if( sizeof($res)==1 && $res!=-1){
					
				$resValue = $res[0];
				$playlist = new playlist_db_dto();
				$playlist->setplaylist_id($resValue->playlist_id);
				$playlist->setplaylist_name($resValue->playlist_name);
				$playlist->setlanguage_id($resValue->language_id);
				$playlist->setlanguage_name($resValue->language_name);
				$playlist->setplaylist_image($resValue->image);
				if(key_exists($resValue->content_type , $this->aConfig['playlist_content_type'])){
					$playlist->setplaylist_type($this->aConfig['playlist_content_type'][$resValue->content_type]);
					if($resValue->content_type ==4){ 		// 4 => Song
						$playlist->setplaylist_content($this->getAudioPlaylistContent($resValue->playlist_id));
					}else if($resValue->content_type ==15){ // 15 => Video
						$playlist->setplaylist_content($this->getVideoPlaylistContent($resValue->playlist_id));
					}else if($resValue->content_type ==17){ // 17 => Image
						$playlist->setplaylist_content($this->getImagePlaylistContent($resValue->playlist_id));
					}
				}
				$container =  new container_db_dto();
				$container->setdata($playlist);
				return $container->to_array();
				
			}else throw new Exception("This playlist id dosn't exists");
				
			}else throw new Exception("Invalid playlist id");
			
	}
	
	public function get_all_playlists(){
		$container = new container_db_dto();
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];
		$orderBy = "";
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY pm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}
		$where   = ' WHERE pm.status = 1 ';
		$this->apply_where_criteria($where);
		$this->sSql = 'SELECT COUNT(pm.playlist_id) AS cnt
						FROM `playlist_mstr` pm '.$where.' '.$orderBy ." LIMIT $start, $limit";
		$this->apply_includes();
		
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		$data = array();
		if(sizeof($res)>0 && $res!=-1){
			$container->settotal_count($res[0]->cnt);
			$this->sSql = 'SELECT  playlist_id,playlist_name,image,language_id,content_type
						FROM `playlist_mstr` pm '.$where.' '.$orderBy ." LIMIT $start, $limit";
			$this->apply_includes();
			$res = $this->oMysqli->query($this->sSql);
			if(sizeof($res)>0 && $res!=-1){
				$data = array();
				foreach($res as $resValue){
					$playlist = new playlist_db_dto();
					$playlist->setplaylist_id($resValue->playlist_id);
					$playlist->setplaylist_name($resValue->playlist_name);
					$playlist->setlanguage_id($resValue->language_id);
					$playlist->setplaylist_image($resValue->image);
					if(key_exists($resValue->content_type , $this->aConfig['playlist_content_type'])){
						$playlist->setplaylist_type($this->aConfig['playlist_content_type'][$resValue->content_type]);
					}
					$data[]=$playlist;
				}
				$container =  new container_db_dto();
				$container->setdata($data);
			}
			
		}
		return $container->to_array();
	}	


	/*
	 * 
	 * These are helper functions*
	 * 
	 */
	 	
	private function getAudioPlaylistContent($playlist_id){
		if($playlist_id){
			$container =  new container_db_dto();
			$limit   = (int)$this->messenger["query"]["limit"];
			$start   = (int)$this->messenger["query"]["start"];
			$orderBy = "";
			if(	$this->messenger['query']['sf'] != '' ){
				$orderBy = " ORDER BY sm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
			}
			$this->sSql = "SELECT COUNT(*) AS cnt FROM
							playlist_song ps INNER JOIN playlist_mstr pmstr ON (pmstr.playlist_id = ps.playlist_id)
							INNER JOIN song_mstr sm ON (sm.song_id = ps.song_id)
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id
							WHERE pmstr.status = 1 AND sm.status=1 AND ps.playlist_id =".$playlist_id;
							
			$res = $this->oMysqli->query($this->sSql);
			if($res!=-1 && sizeof($res)>0){
				$container->settotal_count($res[0]->cnt);
			}else{
				return null;
			}
			
			$this->sSql = "SELECT sm.song_id,sm.song_name,sm.audio_file ,sm.language_id,
						 	 sm.song_duration,sm.isrc,sm.release_date,lm.language_name
							FROM
							playlist_song ps INNER JOIN playlist_mstr pmstr ON (pmstr.playlist_id = ps.playlist_id)
							INNER JOIN song_mstr sm ON (sm.song_id = ps.song_id)
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id	
							WHERE pmstr.status = 1 AND sm.status=1 AND ps.playlist_id =".$playlist_id.' '.$orderBy ." LIMIT $start, $limit";
			$res = $this->oMysqli->query($this->sSql);
		
			if($res!=-1 && sizeof($res)>0){
			
				$data = array();
				$audio_ids_arr=array();
				foreach($res as $resValue){
					$audio = new audio_db_dto();
					$audio->setaudio_id($resValue->song_id);
					$audio_ids_arr[]=$resValue->song_id;
					$audio->setaudio_name($resValue->song_name);
					$audio->setaudio_file($resValue->audio_file);
					$audio->setaudio_isrc($resValue->isrc);
					$audio->setaudio_release_date($resValue->release_date);
					$audio->setaudio_language_id($resValue->language_id);		
					$audio->setaudio_language_name($resValue->language_name);
					$audio->setaudio_duration($resValue->song_duration);
					$data[] = $audio;	
					
				}
				
				$audio_image_map = $this->oCommon->getImagesForAudio($audio_ids_arr);
				$artist_song_map = $this->oCommon->getArtistsForAudio($audio_ids_arr);
				
				foreach($data as $audio){
					if(key_exists($audio->getaudio_id() ,$artist_song_map))
						$audio->setaudio_artist($artist_song_map[$audio->getaudio_id()]);
					if(key_exists($audio->getaudio_id() ,$audio_image_map)){
						$audio->setaudio_image($audio_image_map[$audio->getaudio_id()]);
					}		
				}
				
				$container->setdata($data);
				return $container;	
			
			}else throw new Exception("This playlist id dosn't exists");
			
			
		}else
			throw new Exception("invalid playlist id");
	}
	
	private function getVideoPlaylistContent($playlist_id){
		if($playlist_id){
			$container =  new container_db_dto();
			$limit   = (int)$this->messenger["query"]["limit"];
			$start   = (int)$this->messenger["query"]["start"];
			$orderBy = "";
			if(	$this->messenger['query']['sf'] != '' ){
				$orderBy = " ORDER BY sm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
			}
			$this->sSql = "SELECT count(*) as cnt from
							playlist_video ps inner join playlist_mstr pmstr on(pmstr.playlist_id = ps.playlist_id)
							inner join video_mstr sm on (sm.video_id = ps.video_id)
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id
							where pmstr.status = 1 and sm.status=1 and ps.playlist_id =".$playlist_id;
			$res = $this->oMysqli->query($this->sSql);
			if($res!=-1 && sizeof($res)>0){
				$container->settotal_count($res[0]->cnt);
			}else{
				return null;
			}
				
			$this->sSql = "SELECT sm.video_id,sm.video_name,sm.image
							from
							playlist_video ps inner join playlist_mstr pmstr on(pmstr.playlist_id = ps.playlist_id)
							inner join video_mstr sm on (sm.video_id = ps.video_id)
							LEFT JOIN `language_mstr` lm ON sm.language_id=lm.language_id
							where pmstr.status = 1 and sm.status=1 and ps.playlist_id =".$playlist_id.' '.$orderBy ." LIMIT $start, $limit";;
			$res = $this->oMysqli->query($this->sSql);
	
			if($res!=-1 && sizeof($res)>0){
					
				$data = array();
				foreach($res as $r){
					$video = new video_db_dto();
					$video->setvideo_id($r->video_id);
					$video->setvideo_name($r->video_name);
					$video->setvideo_image($r->image);
					/* $video->setvideo_language();
					$video->setvideo_duration();
					$video->setvideo_release_date();
					$video->setvideo_file();
					$video->setvideo_tempo();
					$video->setvideo_artist(); */
					
					$data[]=$video;
				}
	
	
				$container->setdata($data);
				return $container;
					
			}else throw new Exception("This playlist id dosn't exists");
				
				
		}else
			throw new Exception("invalid playlist id");
	}
	
	private function getImagePlaylistContent($playlist_id){
		if($playlist_id){
			$container =  new container_db_dto();
			$limit   = (int)$this->messenger["query"]["limit"];
			$start   = (int)$this->messenger["query"]["start"];
			$orderBy = "";
			if(	$this->messenger['query']['sf'] != '' ){
				$orderBy = " ORDER BY sm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
			}
			$this->sSql = "SELECT count(ps.image_id) as cnt from
							playlist_image ps inner join playlist_mstr pmstr on(pmstr.playlist_id = ps.playlist_id)
							inner join image_mstr sm on (sm.image_id = ps.image_id)
							where pmstr.status = 1 and sm.status=1 and ps.playlist_id =".$playlist_id;
			$res = $this->oMysqli->query($this->sSql);
			if($res!=-1 && sizeof($res)>0){
				$container->settotal_count($res[0]->cnt);
			}else{
				return null;
			}
	
			$this->sSql = "SELECT ps.image_id,image_name,image_desc,image_file
							from
							playlist_image ps inner join playlist_mstr pmstr on(pmstr.playlist_id = ps.playlist_id)
							inner join image_mstr sm on (sm.image_id = ps.image_id)
							where pmstr.status = 1 and sm.status=1 and ps.playlist_id =".$playlist_id.' '.$orderBy ." LIMIT $start, $limit";;
			$res = $this->oMysqli->query($this->sSql);
	
			if($res!=-1 && sizeof($res)>0){
					
				$data = array();
				foreach($res as $r){
					$video = array();
					$video['image_id']=$r->image_id;
					$video['image_name']=$r->image_name;
					$video['image_desc']=$r->image_desc;
					$video['image_file']=$r->image_file;
				
						
					$data[]=$video;
				}
	
	
				$container->setdata($data);
				return $container;
					
			}else throw new Exception("This playlist id dosn't exists");
	
	
		}else
			throw new Exception("invalid playlist id");
	}
		
	private function apply_where_criteria(&$where){
		
		if(isset($this->req_criteria_arr["language_id"])){
			$where = $where." and pm.language_id=".$this->req_criteria_arr["language_id"];
		}
		
		if(isset($this->req_criteria_arr["type"])){
			$val = $this->oCommon->getplaylistcontenttype($this->req_criteria_arr["type"]);
			if($val){
				$where = $where." and pm.content_type=".$val;
			}
		}
	}
	
	private function apply_includes(){
	
	
	
	}

}
?>