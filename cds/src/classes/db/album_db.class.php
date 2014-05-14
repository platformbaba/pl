<?php

class album_db extends base_db{

	protected $_default_arr = array("album_id","album_name","album_language","album_language_id","album_label",
									"title_rel_dt","album_image","album_artist","album_type","music_rel_dt",
									"broadcast_year","content_type","film_rating","grade"
	);
	protected $_includes_arr = array("album_description","album_excerpt","album_tags","album_banner");
	protected $_criteria_arr = array("album_language_id","title_rel_dt","album_type","music_rel_dt","broadcast_year","content_type",
								"film_rating","grade");
	
	public function __construct($oMysqli){
		parent::__construct($oMysqli);
	}
	
	public function getdetails($wrapInContainer=true){
	
		$album_id = $this->messenger["query"]["id"];
		if( is_numeric($album_id) ){
			
					
			$this->sSql = "SELECT am.broadcast_year,am.content_type,am.film_rating,am.grade,
							am.music_release_date,am.album_id,am.album_name,lm.language_name,lm.language_id,
							am.music_release_date,am.title_release_date,am.album_image,am.catalogue_id,
							am.album_type,lb.label_name  @@@album_desc@@@ @@@album_excerpt@@@ 
							FROM `album_mstr` am 
							INNER JOIN language_mstr lm ON lm.language_id=am.language_id
							INNER JOIN label_mstr lb ON lb.label_id=am.label_id and am.status=1
							WHERE album_id =".trim($album_id);
			
			$this->apply_includes();
			$res = $this->oMysqli->query($this->sSql);
		
			if( sizeof($res)==1 && $res!=-1){
					
				$resValue = $res[0];
				$album = new album_db_dto();
				$album->setalbum_id($resValue->album_id);
				$album->setalbum_name($resValue->album_name);
				$album->setalbum_language($resValue->language_name);
				$album->setalbum_language_id($resValue->language_id);
				$album->setalbum_label($resValue->label_name);
				$album->setalbum_music_rel_dt($resValue->music_release_date);
				$album->setalbum_type($this->oCommon->getalbumtype($resValue->album_type));
				
				$album->setalbum_broadcast_year($resValue->broadcast_year);
				$album->setalbum_content_type($this->oCommon->getalbumcontenttype($resValue->content_type));
				$album->setalbum_film_rating($resValue->film_rating);
				$album->setalbum_grade($resValue->grade);
				
				$album->setalbum_title_rel_dt($resValue->title_release_date);
				$artist_arr = $this->oCommon->getArtistForAlbum($album_id);
				$album->setalbum_df_image($resValue->album_image);
				
				if(key_exists($resValue->album_id,$artist_arr))
					$album->setalbum_artist($artist_arr[$resValue->album_id]);
				if(in_array("album_description",$this->req_includes_arr)){
					$album->setalbum_description($resValue->album_desc);
				}
				if(in_array("album_excerpt",$this->req_includes_arr)){
					$album->setalbum_excerpt($resValue->album_excerpt);
				}

				if(in_array("album_banner",$this->req_includes_arr)){
				
					$banner_arr = $this->oCommon->getAlbumBanner($album_id);
					if(key_exists($resValue->album_id,$banner_arr)){
						$album->setalbum_banners($banner_arr[$resValue->album_id]);
						}
				}
				
				if(in_array("album_tags",$this->req_includes_arr)){
					$tag_arr = $this->oCommon->getAlbumTags($album_id);
					if(key_exists($resValue->album_id,$tag_arr)){
						$album->setalbum_tags($tag_arr[$resValue->album_id]);
						}
				}
				if($wrapInContainer){
					$container =  new container_db_dto();
					$container->setdata($album);
					return $container->to_array();
				}else{
					return $album;
				}
						
			}else throw new Exception("This album ID dosn't exists");
		 
		}else throw new Exception("Invalid album ID");
	}
	
	public function get_all_albums(){

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
		$this->sSql = "SELECT count(am.album_id) as cnt FROM `album_mstr` am
						INNER JOIN language_mstr lm ON lm.language_id=am.language_id AND lm.status=1
						INNER JOIN label_mstr lb ON lb.label_id=am.label_id ".$where;
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		if(sizeof($res)>0 && $res!=-1){
			$container->settotal_count($res[0]->cnt);
		}
		
		$this->sSql = "	SELECT am.broadcast_year,am.content_type,am.film_rating,am.grade,lm.language_id,
						am.music_release_date , am.album_id,am.album_name,lm.language_name,am.music_release_date,am.title_release_date,am.album_image,am.catalogue_id,
						am.album_type,lb.label_name  @@@album_desc@@@ @@@album_excerpt@@@
						FROM `album_mstr` am
						INNER JOIN language_mstr lm ON lm.language_id=am.language_id AND lm.status=1
						INNER JOIN label_mstr lb ON lb.label_id=am.label_id ".$where." ".$orderBy ." LIMIT $start, $limit";
		$this->apply_includes();
		
		$res = $this->oMysqli->query($this->sSql);
		$data = array();
		$album_ids_arr = array();
		if(sizeof($res)>0 && $res!=-1){
			foreach ($res as $resValue){
				$album = new album_db_dto();
				$album->setalbum_id($resValue->album_id);
				$album_ids_arr[] = $resValue->album_id;
				$album->setalbum_name($resValue->album_name);
				$album->setalbum_language($resValue->language_name);
				$album->setalbum_language_id($resValue->language_id);
				$album->setalbum_music_rel_dt($resValue->music_release_date);
				$album->setalbum_label($resValue->label_name);
				$album->setalbum_type($this->oCommon->getalbumtype($resValue->album_type));
				$album->setalbum_broadcast_year($resValue->broadcast_year);
				$album->setalbum_content_type($this->oCommon->getalbumcontenttype($resValue->content_type));
				$album->setalbum_film_rating($resValue->film_rating);
				$album->setalbum_grade($resValue->grade);
				$album->setalbum_title_rel_dt($resValue->title_release_date);
				$album->setalbum_df_image($resValue->album_image);
				if(in_array("album_description",$this->req_includes_arr)){
					$album->setalbum_description($resValue->album_desc);
				}
				if(in_array("album_excerpt",$this->req_includes_arr)){
					$album->setalbum_excerpt($resValue->album_excerpt);
				}
				$data[]=$album;
			}
				
			$artist_album_map = $this->oCommon->getArtistForAlbum($album_ids_arr);
			
			$album_tag_map = array();
			if(in_array("album_tags",$this->req_includes_arr)){
				$album_tag_map = $this->oCommon->getAlbumTags($album_ids_arr);
			}

			$banner_arr_map = array();
			if(in_array("album_banner",$this->req_includes_arr)){			
				$banner_arr_map = $this->oCommon->getAlbumBanner($album_ids_arr);
			}
				
			foreach($data as $album){
				$id = $album->getalbum_id();
				if(key_exists($id,$artist_album_map))
					$album->setalbum_artist($artist_album_map[$id]);
				if(key_exists($id,$album_tag_map))
					$album->setalbum_tags($album_tag_map[$id]);
				if(key_exists($id,$banner_arr_map))
					$album->setalbum_banners($banner_arr_map[$id]);
					
			}
		}
		$container->setdata($data);
		
		return $container->to_array();
	} 
	
	
	public function get_album_audio(){
		
		$album_audio = null;
		$album_id	 = $this->messenger["query"]["id"];
		if(isset($album_id) && is_numeric($album_id)){
			$audioclass =new audio_db($this->oMysqli);
			$album = $this->getdetails(false);
			$song_info = $audioclass->getAudioForAlbum($album_id);
			if(key_exists($album_id,$song_info)){
				$album_audio= $song_info[$album_id];
				$album->setalbum_audio($album_audio);
			}
			
		}else{
			throw new Exception("Invalid album id");
		}
		$container = new container_db_dto();
		$container->setdata($album);
		return $container->to_array();
	}
	
	public function get_album_images(){
		$album = null;
		$album_id	 = $this->messenger["query"]["id"];
		if(isset($album_id) && is_numeric($album_id)){
			$album_images = $this->oCommon->getImagesForAlbum($album_id);
			if($album_images!=null && key_exists($album_id,$album_images))
				$album_img=$album_images[$album_id];
		}else{
			throw new Exception("Invalid album id");
		}
		$container = new container_db_dto();
		$container->setdata($album_img);
		return $container->to_array();
		
	}
	
	public function get_album_videos(){
		$album = null;
		$album_id	 = $this->messenger["query"]["id"];
		if(isset($album_id) && is_numeric($album_id)){
			$album_videos = $this->oCommon->getVideosForAlbum($album_id);
			
			if($album_videos!=null && key_exists($album_id,$album_videos))
				$album = $album_videos[$album_id];
		}else{
			throw new Exception("Invalid album id");
		}
		$container = new container_db_dto();
		$container->setdata($album);
		return $container->to_array();
		
		
	}
	
	public function get_album_by_tag(){
	
		$container = new container_db_dto();
		$tag_id	 = $this->messenger["query"]["id"];
		$tagIds = explode(",",urldecode($tag_id));
	
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
		$where   = ' where am.status = 1 ';
		$this->apply_where_criteria($where);
		$this->sSql = "SELECT count(t.album_id) as cnt
					FROM `album_tags` t
					INNER JOIN `album_mstr` am ON am.album_id=t.album_id
					INNER JOIN `language_mstr` lm ON am.language_id=lm.language_id $where  AND $condition";
	
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		if(sizeof($res)>0){
			$container->settotal_count($res[0]->cnt);
		}
	
						
		$this->sSql = "SELECT am.broadcast_year,am.content_type,am.film_rating,am.grade, 
		am.music_release_date,t.tag_id,am.album_id,am.album_name,am.language_id,lm.language_name,
		lb.label_name,am.album_image,am.title_release_date,am.catalogue_id,am.album_type @@@album_desc@@@ @@@album_excerpt@@@
		FROM `album_tags` t
		LEFT JOIN `album_mstr` am ON am.album_id=t.album_id
		LEFT JOIN `language_mstr` lm ON am.language_id=lm.language_id
		LEFT JOIN label_mstr lb ON lb.label_id=am.label_id $where AND $condition $orderBy LIMIT $start, $limit";
		 

		$this->apply_includes();
		$res = $this->oMysqli->query($this->sSql);
		$data = array();
		$album_ids_arr = array();
		if(sizeof($res)>0 && $res!=-1){
			foreach ($res as $resValue){
				$album = new album_db_dto();
				$album->setalbum_id($resValue->album_id);
				$album_ids_arr[] = $resValue->album_id;
				$album->setalbum_name($resValue->album_name);
				$album->setalbum_language($resValue->language_name);
				$album->setalbum_language_id($resValue->language_id);
				$album->setalbum_music_rel_dt($resValue->music_release_date);
				$album->setalbum_label($resValue->label_name);
				$album->setalbum_type($this->oCommon->getalbumtype($resValue->album_type));
				$album->setalbum_broadcast_year($resValue->broadcast_year);
				$album->setalbum_content_type($this->oCommon->getalbumcontenttype($resValue->content_type));
				$album->setalbum_film_rating($resValue->film_rating);
				$album->setalbum_grade($resValue->grade);
				$album->setalbum_title_rel_dt($resValue->title_release_date);
				$album->setalbum_df_image($resValue->album_image);				
				if(in_array("album_description",$this->req_includes_arr)){
					$album->setalbum_description($resValue->album_desc);
				}
				if(in_array("album_excerpt",$this->req_includes_arr)){
					$album->setalbum_excerpt($resValue->album_excerpt);
				}
				$data[]=$album;
			}
					
			
			$album_tag_map = array();
			$artist_album_map = array();
			$artist_album_map = $this->oCommon->getArtistForAlbum($album_ids_arr);
			
			if(in_array("album_tags",$this->req_includes_arr))
				$album_tag_map = $this->oCommon->getAlbumTags($album_ids_arr);
	
			$banner_arr_map = array();
			if(in_array("album_banner",$this->req_includes_arr)){			
				$banner_arr_map = $this->oCommon->getAlbumBanner($album_ids_arr);
			}
				
			foreach($data as $album){
				$id = $album->getalbum_id();
				if(key_exists($id,$artist_album_map))
					$album->setalbum_artist($artist_album_map[$id]);
				if(key_exists($id,$album_tag_map))
					$album->setalbum_tags($album_tag_map[$id]);
				if(key_exists($id,$banner_arr_map))
					$album->setalbum_banners($banner_arr_map[$id]);
					
			}
		}
		$container->setdata($data);
		
		return $container->to_array();
	}
	
	public function get_album_by_banner(){
	
		$container = new container_db_dto();
		$banner_id = $this->messenger["query"]["id"];
		if($banner_id){
			$where = " WHERE aban.banner_id = ".$banner_id;
			
			 $this->sSql = "SELECT am.broadcast_year,am.content_type,am.film_rating,am.grade,am.album_id,am.album_name,am.language_id,
						lm.language_name,lb.label_name,am.album_image,am.title_release_date,am.music_release_date,
								 am.catalogue_id,am.album_type @@@album_desc@@@ @@@album_excerpt@@@
					FROM `album_mstr` am 
					LEFT JOIN `album_banner` aban ON aban.album_id=am.album_id
					LEFT JOIN `language_mstr` lm ON am.language_id=lm.language_id
					LEFT JOIN label_mstr lb ON am.label_id=lb.label_id ".$where;		
		$this->apply_includes();
		$res = $this->oMysqli->query($this->sSql);
		$data = array();
		$album_ids_arr = array();
		
		if(sizeof($res)>0 && $res!=-1){
		
			$container->settotal_count(count($res));
			
			foreach ($res as $resValue){
				$album = new album_db_dto();
				$album->setalbum_id($resValue->album_id);
				$album_ids_arr[] = $resValue->album_id;
				$album->setalbum_name($resValue->album_name);
				$album->setalbum_language($resValue->language_name);
				$album->setalbum_music_rel_dt($resValue->music_release_date);
				$album->setalbum_label($resValue->label_name);
				$album->setalbum_type($resValue->album_type);
				$album->setalbum_title_rel_dt($resValue->title_release_date);
				$album->setalbum_df_image($resValue->album_image);
				$album->setalbum_broadcast_year($resValue->broadcast_year);
				$album->setalbum_content_type($this->oCommon->getalbumcontenttype($resValue->content_type));
				$album->setalbum_film_rating($resValue->film_rating);
				$album->setalbum_grade($resValue->grade);
				if(in_array("album_description",$this->req_includes_arr)){
					$album->setalbum_description($resValue->album_desc);
				}
				if(in_array("album_excerpt",$this->req_includes_arr)){
					$album->setalbum_excerpt($resValue->album_excerpt);
				}
				$data[]=$album;
			}
				
			$artist_album_map = $this->oCommon->getArtistForAlbum($album_ids_arr);
			$album_tag_map = array();
			$album_banner_map = array();
			
			if(in_array("album_tags",$this->req_includes_arr)){
				$album_tag_map = $this->oCommon->getAlbumTags($album_ids_arr);
			}

			if(in_array("album_banner",$this->req_includes_arr)){
					$album_banner_map = $this->oCommon->getAlbumBanner($album_ids_arr);
				}
				
			foreach($data as $album){
				$id = $album->getalbum_id();
				if(key_exists($id,$artist_album_map))
					$album->setalbum_artist($artist_album_map[$id]);
				if(key_exists($id,$album_tag_map))
					$album->setalbum_tags($album_tag_map[$id]);
				if(key_exists($id,$album_banner_map))
					$album->setalbum_banners($album_banner_map[$id]);
					
			}
		}


		$container->setdata($data);		
		return $container->to_array();
						
		}	
		else
		throw new Exception("invalid banner id");
		
				
	}
	
	/*
	 * These are local functions
	 * 
	 */
	
	public function getAlbumsForArtist($artist_id,$artist_role){
		if($artist_id){
			$container = new container_db_dto();
			
			$limit   = (int)$this->messenger["query"]["limit"];
			$start   = (int)$this->messenger["query"]["start"];
			$orderBy = "";
			if(	$this->messenger['query']['sf'] != '' ){
				$orderBy = " ORDER BY am.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
			}
			$where   = ' where am.status = 1 and aa.artist_id = '.$artist_id;
			if($artist_role!=null && key_exists($artist_role,$this->aConfig['artist_type'])){
				$artist_role_id = $this->aConfig['artist_type'][$artist_role];
				if($artist_role_id)
					$where = $where." and aa.artist_role & ".$artist_role_id."=".$artist_role_id;
				
			}
			$this->apply_where_criteria($where);
			$this->sSql = "select count(aa.album_id) as cnt
						from artist_album aa left join album_mstr am on am.album_id=aa.album_id
						left join language_mstr lm on lm.language_id=am.language_id 
						LEFT JOIN label_mstr lb ON lb.label_id=am.label_id 
						".$where;
			
			
			
			$res = $this->oMysqli->query($this->sSql);
			if($res!=-1 and sizeof($res)>0){
				$container->settotal_count($res[0]->cnt);
				$this->sSql = "SELECT am.broadcast_year,am.content_type,am.film_rating,am.grade,lm.language_id,
						am.music_release_date,am.album_id,am.album_name,lm.language_name,am.music_release_date,am.title_release_date,am.album_image,
					am.album_type,lb.label_name  @@@album_desc@@@ @@@album_excerpt@@@
					from artist_album aa left join album_mstr am on am.album_id=aa.album_id
						left join language_mstr lm on lm.language_id=am.language_id 
						LEFT JOIN label_mstr lb ON lb.label_id=am.label_id 
						".$where." ".$orderBy ." LIMIT $start, $limit";
				$this->apply_includes();
				$res = $this->oMysqli->query($this->sSql);
				$data = array();
				$album_ids_arr = array();
				if(sizeof($res)>0 && $res!=-1){
					foreach ($res as $resValue){
						$album = new album_db_dto();
						$album->setalbum_id($resValue->album_id);
						$album_ids_arr[] = $resValue->album_id;
						$album->setalbum_name($resValue->album_name);
						$album->setalbum_language($resValue->language_name);
						$album->setalbum_language_id($resValue->language_id);
						$album->setalbum_music_rel_dt($resValue->music_release_date);
						$album->setalbum_label($resValue->label_name);
						$album->setalbum_type($this->oCommon->getalbumtype($resValue->album_type));
						$album->setalbum_title_rel_dt($resValue->title_release_date);
						$album->setalbum_df_image($resValue->album_image);
						$album->setalbum_broadcast_year($resValue->broadcast_year);
						$album->setalbum_content_type($this->oCommon->getalbumcontenttype($resValue->content_type));
						$album->setalbum_film_rating($resValue->film_rating);
						$album->setalbum_grade($resValue->grade);
						if(in_array("album_description",$this->req_includes_arr)){
							$album->setalbum_description($resValue->album_desc);
						}
						if(in_array("album_excerpt",$this->req_includes_arr)){
							$album->setalbum_excerpt($resValue->album_excerpt);
						}
						$data[]=$album;
					}
					$artist_album_map=array();
					$artist_album_map = $this->oCommon->getArtistForAlbum($album_ids_arr);
					$album_tag_map = array();
					if(in_array("album_tags",$this->req_includes_arr)){
						$album_tag_map = $this->oCommon->getAlbumTags($album_ids_arr);
					}
				
					foreach($data as $album){
						$id = $album->getalbum_id();
						if(key_exists($id,$artist_album_map))
							$album->setalbum_artist($artist_album_map[$id]);
						if(key_exists($id,$album_tag_map))
							$album->setalbum_tags($album_tag_map[$id]);
							
					}
				}
				$container->setdata($data);
				
				return $container->to_array();
			}
		}
		
	}
		
	private function apply_where_criteria(&$where){
		
		if(isset($this->req_criteria_arr["album_language_id"])){
			$where = $where." and lm.language_id='".$this->req_criteria_arr["album_language_id"]."'";
		}
		
		if(isset($this->req_criteria_arr["film_rating"])){
			$where = $where." and am.film_rating='".$this->req_criteria_arr["film_rating"]."'";
		}
		if(isset($this->req_criteria_arr["grade"])){
			$where = $where." and am.grade='".$this->req_criteria_arr["grade"]."'";
		}
	
		if(isset($this->req_criteria_arr["title_rel_dt--<"])){
			$where = $where." and am.title_release_date < '".$this->req_criteria_arr["title_rel_dt--<"]."'";
		}
		if(isset($this->req_criteria_arr["title_rel_dt-->"])){
			$where = $where." and am.title_release_date > '".$this->req_criteria_arr["title_rel_dt-->"]."'";
		}
		
		if(isset($this->req_criteria_arr["music_rel_dt--<"])){
			$where = $where." and am.music_release_date < '".$this->req_criteria_arr["music_rel_dt--<"]."'";
		}
		if(isset($this->req_criteria_arr["music_rel_dt-->"])){
			$where = $where." and am.music_release_date > '".$this->req_criteria_arr["music_rel_dt-->"]."'";
		}
		if(isset($this->req_criteria_arr["broadcast_year"])){
			$where = $where." and am.broadcast_year = ".$this->req_criteria_arr["broadcast_year"];
		}
		
		if(isset($this->req_criteria_arr["broadcast_year--<"])){
			$where = $where." and am.broadcast_year < ".$this->req_criteria_arr["broadcast_year--<"];
		}
		if(isset($this->req_criteria_arr["broadcast_year-->"])){
			$where = $where." and am.broadcast_year > ".$this->req_criteria_arr["broadcast_year-->"];
		}
		
		if(isset($this->req_criteria_arr["album_type"])){
			if(key_exists($this->req_criteria_arr["album_type"],$this->aConfig['album_type'])){
				$val = $this->aConfig['album_type'][$this->req_criteria_arr["album_type"]];
				$where = $where." and am.album_type & $val = $val";
			}
		}
		
		if(isset($this->req_criteria_arr["content_type"])){
			$val = $this->aConfig['album_content_type'][$this->req_criteria_arr["content_type"]];
			$where = $where." and am.content_type & $val = $val";
		}
	}
	
	private function apply_includes(){
	
		if(in_array("album_description",$this->req_includes_arr)){
			$this->sSql = str_replace("@@@album_desc@@@",", am.album_desc",$this->sSql);
		}else{
			$this->sSql = str_replace("@@@album_desc@@@","",$this->sSql);
		}
		if(in_array("album_excerpt",$this->req_includes_arr)){
			$this->sSql = str_replace("@@@album_excerpt@@@",", am.album_excerpt",$this->sSql);
		}else{
			$this->sSql = str_replace("@@@album_excerpt@@@","",$this->sSql);
		}
	
	}

}
?>