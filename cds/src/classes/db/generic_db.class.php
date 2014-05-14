<?php

class generic_db extends base_db{


	protected $messenger;
	protected $oMysqli; 
	protected $sSql;
	protected $aConfig;

	
	public function __construct($oMysqli){
		parent::__construct($oMysqli);
		global $messenger,$aConfig;
		$this->messenger=&$messenger;
	
		$this->oMysqli=$oMysqli;
		$this->aConfig = $aConfig;
	
	
	}

	public function getdetails(){
	}	
	
	
	public function get_all_languages(){	
		
			$lang_sql = "SELECT language_id,language_name FROM language_mstr WHERE status=1";
			
			$this->sSql = $lang_sql;	
			$res = $this->oMysqli->query($this->sSql);
			$lang_arr= array();			
			if(sizeof($res) >0){
			
				foreach($res as $resValue){
					$lang_arr[$resValue->language_id] = $resValue->language_name;
				}
				
				
			}
		return $lang_arr;
		
	}	
	
	public function get_all_labels(){
			$label_sql = "SELECT label_id,label_name FROM label_mstr WHERE status=1";
			
			$this->sSql = $label_sql;	
			$res = $this->oMysqli->query($this->sSql);
			$label_arr= array();			
			if(sizeof($res) >0){
			
				foreach($res as $resValue){
					$label_arr[$resValue->label_id] = $resValue->label_name;
				}
				
				
			}
		return $label_arr;
	
	}	
	
	public function get_all_artist_roles(){
		return array_keys($this->aConfig["artist_type"]);
		
	}	
	public function get_all_album_types(){
		return array_keys($this->aConfig["album_type"]);
	
	}
	public function get_all_album_content_types(){
		return array_keys($this->aConfig["album_content_type"]);
	
	}
	
	public function get_all_album_tags(){
	
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];

	
		$tag_sql = "SELECT mstr.tag_id , mstr.tag_name AS tag_value, pmstr.tag_name AS tag_name ,atag.album_id AS album_id
						FROM album_tags atag INNER JOIN tags_mstr mstr ON (atag.tag_id = mstr.tag_id )
						INNER JOIN tags_mstr pmstr ON (pmstr.tag_id = mstr.parent_tag_id)
						WHERE mstr.status=1 LIMIT $start, $limit";
			$this->sSql = $tag_sql;	
			$res = $this->oMysqli->query($this->sSql);
			$tag_arr= array();
			if(sizeof($res) >0){
			$tag = array();
				foreach ($res as $resValue){
					
					$tag["tag_id"]=$resValue->tag_id;
					$tag["tag_name"]=$resValue->tag_name;
					$tag["tag_value"]=$resValue->tag_value;
					if(!key_exists($resValue->album_id,$tag_arr))
						$tag_arr[$resValue->album_id] = array();
					$tag_arr[$resValue->album_id][] = $tag;
				}
			}
			return $tag_arr;
		
	}	

	public function get_all_audio_tags(){
	
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];
	
		$tag_sql = "SELECT mstr.tag_id , mstr.tag_name AS tag_value, pmstr.tag_name AS tag_name ,stag.song_id AS song_id
						FROM song_tags stag INNER JOIN tags_mstr mstr ON (stag.tag_id = mstr.tag_id )
						INNER JOIN tags_mstr pmstr ON (pmstr.tag_id = mstr.parent_tag_id)
						WHERE mstr.status=1 group by mstr.tag_id LIMIT $start, $limit";
			$this->sSql = $tag_sql;	
			$res = $this->oMysqli->query($this->sSql);
			$tag_arr= array();
			if(sizeof($res) >0){
			$tag = array();
				foreach ($res as $resValue){
					$tag["tag_id"]=$resValue->tag_id;
					$tag["tag_name"]=$resValue->tag_name;
					$tag["tag_value"]=$resValue->tag_value;
					$tag_arr[] = $tag;
				}
			}
			return $tag_arr;
	
	}
	
	public function get_all_album_banners(){
		
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];

		$orderBy = "";
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY bm.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}

	
		$container = new container_db_dto();
		$banner_cnt_sql = "SELECT COUNT(banner_id) AS cnt FROM banner_mstr WHERE status=1";
					
		$this->sSql = $banner_cnt_sql;	
		$res = $this->oMysqli->query($this->sSql);

		$total = 0;
		if(sizeof($res)>0){
			$container->settotal_count($res[0]->cnt);
		}

		$banner_sql = "SELECT bm.banner_id,bm.banner_name FROM banner_mstr bm where bm.status=1 $orderBy LIMIT $start,$limit";
					
			$this->sSql = $banner_sql;	
			$res = $this->oMysqli->query($this->sSql);
			$banner_arr= array();
			if(sizeof($res) >0){
			$banner = array();
				foreach ($res as $resValue){					
					$banner["banner_id"]   = $resValue->banner_id;
					$banner["banner_name"] = $resValue->banner_name;
					
					$banner_arr[] = $banner;
				}
			}
	
		$container->setdata($banner_arr);
		return $container->to_array();
	
	}
	
	public function get_all_film_rating(){
	
		$container = new container_db_dto();
			$film_sql = "SELECT DISTINCT(film_rating) FROM album_mstr WHERE status=1";					
			$res = $this->oMysqli->query($film_sql);
			$film_arr= array();
			if(sizeof($res) >0){
			$film = array();
				foreach ($res as $resValue){					
					$film["film_rating"] = $resValue->film_rating;					
					$film_arr[] = $film;
				}
			}	
		$container->setdata($film_arr);
		return $container->to_array();
	}
	
	public function get_all_album_grade(){
	
		$container = new container_db_dto();

			$grade_sql = "SELECT DISTINCT(grade) FROM album_mstr WHERE status=1";					
			$res = $this->oMysqli->query($grade_sql);
			$grade_arr= array();
			if(sizeof($res) >0){
			$grade = array();
				foreach ($res as $resValue){					
					$grade["grade"] = $resValue->grade;					
					$grade_arr[] = $grade;
				}
			}	
		$container->setdata($grade_arr);
		return $container->to_array();
	}
	
	
	
}