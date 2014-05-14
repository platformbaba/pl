<?php

class artist_db extends base_db{
	
	protected $_default_arr = array("artist_id","artist_name","artist_role","artist_image",
									"artist_dob","artist_gender","artist_dod");
	protected $_includes_arr = array("artist_biography");
	protected $_criteria_arr = array("artist_gender","artist_dob","artist_dod","artist_role");
	
	public function __construct($oMysqli){
		
		parent::__construct($oMysqli);
	}

	
	public function getdetails($wrapInContainer=true){
		
		$artist_id	 = $this->messenger["query"]["id"];
		if(is_numeric($artist_id)){
			$this->sSql = 'SELECT `artist_id`,`artist_name`,`artist_role`,`artist_image`,`artist_dob`,
							`artist_dod`, `artist_gender` @@@artist_biography@@@
							FROM `artist_mstr`
							WHERE `status`=1 AND `artist_id`='.$artist_id;
			$this->apply_includes();
			$res = $this->oMysqli->query($this->sSql);
		
			if(sizeof($res)==1){
				$resValue = $res[0];
				$artist =  new artist_db_dto();
				$artist->setartist_id($resValue->artist_id);
				$artist->setartist_name($resValue->artist_name);
				$artist->setartist_role($this->oCommon->getartistrolearr($resValue->artist_role));
				$artist->setartist_image($resValue->artist_image);
				$artist->setartist_dob($resValue->artist_dob);
				
				$gender = ($resValue->artist_gender == 1) ? "Male" : "Female";
				
				$artist->setartist_gender($gender);
				$artist->setartist_dod($resValue->artist_dod);
				if(in_array("artist_biography",$this->req_includes_arr)){
					$artist->setartist_biography($resValue->artist_biography);
				}
				if($wrapInContainer){
					$container =  new container_db_dto();
					$container->setdata($artist);
					return $container->to_array();
				}else{
					return $artist;
				}
				
			}else{
				throw new Exception("Invalid Artist Id");
			}
			
		}else{
			throw new Exception("Invalid Artist Id");
		}
		
	}

	public function get_all_artists(){
		
		$container = new container_db_dto();
		
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];
		$orderBy = "";
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY am.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}
		$where   = ' where am.status = 1 ';
		$this->apply_where_criteria($where);
		// this is only for count
		$this->sSql = "SELECT count(am.artist_id) as cnt FROM `artist_mstr` am ".$where;
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		if(sizeof($res)>0){
			$container->settotal_count($res[0]->cnt);
		}
		
		$this->sSql = "SELECT artist_id,artist_name,artist_role,artist_image,artist_dob,artist_dod,artist_gender @@@artist_biography@@@ 
						FROM `artist_mstr` am ".$where." ".$orderBy ." LIMIT $start, $limit";
		
		$this->apply_includes();
		$res = $this->oMysqli->query($this->sSql);
		$data = array();
		if(sizeof($res)>0){
			foreach ($res as $resValue){
				$artist = new artist_db_dto();
				$artist->setartist_id($resValue->artist_id);
				$artist->setartist_name($resValue->artist_name);
				$artist->setartist_role($this->oCommon->getartistrolearr($resValue->artist_role));
				$artist->setartist_image($resValue->artist_image);
				$artist->setartist_dob($resValue->artist_dob);				
				$artist->setartist_gender($resValue->artist_gender);				
				$artist->setartist_dod($resValue->artist_dod);
				if(in_array("artist_biography",$this->req_includes_arr)){
					$artist->setartist_biography($resValue->artist_biography);
				}
				$data[] = $artist;
			}
		
		}
		$container->setdata($data);
		return $container->to_array();
		
	}
	
	public function get_artist_audio(){
		$artist_id	 = $this->messenger["query"]["id"];
		$data=null;
		if(is_numeric($artist_id)){
			$audioclass =new audio_db($this->oMysqli);
			$data = $audioclass->getAudioForArtist($artist_id);
		}else{ 
			throw new Exception("invalid artist id got : ".$artist_id);
		}	
		return $data;
		
	}
	
	public function get_artist_album(){
		$artist_id	 = $this->messenger["query"]["id"];
		$artist_role = null;
		if(isset($this->req_criteria_arr["artist_role"])){
			$artist_role = $this->req_criteria_arr["artist_role"];
		}
		$data = null;
		if($artist_id){
			$albumclass = new album_db($this->oMysqli);
			$data = $albumclass->getAlbumsForArtist($artist_id,$artist_role);
		}else 
			throw new Exception("invalid artist id");
		return $data;
		
	}
	
	public function get_artist_images(){
	
		$container = new container_db_dto();
		$artist_id = (int)$this->messenger["query"]["id"];
	
		$this->sSql = "SELECT `image_id` FROM image_map WHERE content_type=13 AND content_id=".$artist_id; //content_type=>13 (Artist) 
		$res = $this->oMysqli->query($this->sSql); 
			
		$total = 0;			
		$artist_imageids_arr = array();
		$data =array();
		
		if(sizeof($res)>0){		
			$container->settotal_count(count($res));
			
			foreach ($res as $resValue){			
				$artist_imageids_arr[] = $resValue->image_id;
			}			
				$data = $this->oCommon->getImagesForArtistMap($artist_imageids_arr);
				
		}	
	
		$container->setdata($data);
		return $container->to_array();

	
	}
	
	
	public function get_artist_videos(){
		
		$container = new container_db_dto();
		$artist_id = (int)$this->messenger["query"]["id"];

		$this->sSql = "SELECT `video_id`,`artist_role` FROM `artist_video` WHERE `artist_id`=".$artist_id;		
		$res = $this->oMysqli->query($this->sSql);
		
		$total = 0;
		$artist_videoids_arr = array();
		$data =array();
		
		if(sizeof($res)>0){		
			$container->settotal_count(count($res));
			
			foreach ($res as $resValue){			
				$artist_videoids_arr[] = $resValue->video_id;
			}			
				$data = $this->oCommon->getVideoForArtist($artist_videoids_arr);
		}
	
	
		$container->setdata($data);
		return $container->to_array();
	}
	
	/**
	 * 
	 * 
	 */
	private function apply_includes(){
		if(in_array("artist_biography",$this->req_includes_arr)){
			$this->sSql = str_replace("@@@artist_biography@@@",", artist_biography",$this->sSql);
		}else{
			$this->sSql = str_replace("@@@artist_biography@@@","",$this->sSql);
		}
	}
	
	private function apply_where_criteria(&$where){
		
		if(isset($this->req_criteria_arr["artist_gender"])){
			$where = $where." and am.artist_gender='".$this->req_criteria_arr["artist_gender"]."'";
		}
		
		if(isset($this->req_criteria_arr["artist_dob--<"])){
			$where = $where." and am.artist_dob < '".$this->req_criteria_arr["artist_dob--<"]."'";
		}
		
		if(isset($this->req_criteria_arr["artist_dob-->"])){
			$where = $where." and am.artist_dob > '".$this->req_criteria_arr["artist_dob-->"]."'";
		}
		
		if(isset($this->req_criteria_arr["artist_dod--<"])){
			$where = $where." and am.artist_dod < '".$this->req_criteria_arr["artist_dod--<"]."'";
		}
		
		if(isset($this->req_criteria_arr["artist_dod-->"])){
			$where = $where." and am.artist_dod > '".$this->req_criteria_arr["artist_dod-->"]."'";
		}
		
		if(isset($this->req_criteria_arr["artist_role"])){
			if(isset($this->aConfig['artist_type'][$this->req_criteria_arr["artist_role"]])){
				$role = $this->aConfig['artist_type'][$this->req_criteria_arr["artist_role"]];
				$where = $where."and am.artist_role & $role = $role";
			}
		}
	}
}
?>