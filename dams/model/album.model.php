<?php
/* album management */
class album
{
 	protected $sSql;
	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }
	// insert a new album
	public function addAlbum(array $a=array()) {
		if($a){
			$albumName= $a['albumName'];
			$status = $a['status'];
			$labelIds = $a['labelIds'];
			$languageIds = $a['languageIds'];
			$bannerIds = $a['bannerIds'];
			$primaryArtist = $a['primaryArtist'];
			$musicReleaseDate = $a['musicReleaseDate'];
			$titleReleaseDate = $a['titleReleaseDate'];
			$albumDescription = $a['albumDescription'];
			$albumExcerpt = $a['albumExcerpt'];
			$albumType = $a['albumTypeStr'];
			$albumContentType = $a['albumContentTypeStr'];
			$artistId = $a['artistId'];
			$couplingIds = $a['couplingIds'];
			$showName= $a['showName'];
			$broadcastYear=(int)$a['broadCastYear'];
			$grade = $a['grade'];
			$isSubtitle =$a['isSubtitle'];
			$filmRating = $a['filmRating'];
			$image = $a['image'];
			$catalogueId = $a['catalogueIds'];
			
			$this->sSql = "INSERT INTO `album_mstr`(`album_name`,`language_id`,`label_id`,`insert_date`,`music_release_date`,`album_type`,`title_release_date`,`album_desc`,`album_excerpt`,`album_image`,`artist_id`,`coupling_ids`,update_date,show_name,broadcast_year,grade,is_subtitle,film_rating,catalogue_id,`content_type`)VALUES('".$this->oMysqli->secure($albumName)."','".(int)$languageIds."','".(int)$labelIds."',now(),'".$this->oMysqli->secure($musicReleaseDate)."',".$albumType.",'".$this->oMysqli->secure($titleReleaseDate)."','".$this->oMysqli->secure($albumDescription)."','".$this->oMysqli->secure($albumExcerpt)."','".$image."','".(int)$artistId."','".$this->oMysqli->secure($couplingIds)."',now(),'".$showName."','".$broadcastYear."','".$grade."','".$isSubtitle."','".$filmRating."','".$catalogueId."',".$albumContentType.")";
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}
	public function checkAlbumExist($album){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND id!=".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM album_mstr WHERE album_name = '".$this->oMysqli->secure($album)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	// edit a album
	public function editAlbum(array $a=array()) {
		if($a){
			$albumId=$a['albumId'];
			$albumName= $a['albumName'];
			$status = $a['status'];
			$labelIds = $a['labelIds'];
			$languageIds = $a['languageIds'];
			$bannerIds = $a['bannerIds'];
			$primaryArtist = $a['primaryArtist'];
			$musicReleaseDate = $a['musicReleaseDate'];
			$titleReleaseDate = $a['titleReleaseDate'];
			$albumDescription = $a['albumDescription'];
			$albumExcerpt = $a['albumExcerpt'];
			$albumType = $a['albumTypeStr'];
			$albumContentType = $a['albumContentTypeStr'];
			$artistId = $a['artistId'];
			$couplingIds = $a['couplingIds'];
			$showName= $a['showName'];
			$broadcastYear=(int)$a['broadCastYear'];
			$grade = $a['grade'];
			$isSubtitle =$a['isSubtitle'];
			$filmRating = $a['filmRating'];
			$image = $a['image'];
			$catalogueId = $a['catalogueIds'];
			
			$this->sSql = "UPDATE album_mstr SET album_name='".$this->oMysqli->secure($albumName)."',language_id='".$this->oMysqli->secure($languageIds)."',label_id='".$this->oMysqli->secure($labelIds)."',music_release_date='".$this->oMysqli->secure($musicReleaseDate)."',album_type=".$albumType.",title_release_date='".$this->oMysqli->secure($titleReleaseDate)."',album_desc='".$this->oMysqli->secure($albumDescription)."',album_excerpt='".$this->oMysqli->secure($albumExcerpt)."',album_image='".$image."',artist_id='".(int)$artistId."',coupling_ids='".$this->oMysqli->secure($couplingIds)."',update_date=now(),show_name='".$this->oMysqli->secure($showName)."',broadcast_year='".$broadcastYear."',`grade`='".$grade."',`is_subtitle`='".$isSubtitle."',`film_rating`='".$filmRating."',`catalogue_id`='".$catalogueId."', `content_type`=".$albumContentType." WHERE album_id='".$albumId."' LIMIT 1";
			
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}
	public function getAlbumById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND album_id IN(".$a['ids'].")";
			}	
			$this->sSql="SELECT `album_id`,`album_name`,`language_id`,`label_id`,`insert_date`,`status`,`music_release_date`,`album_type`,`title_release_date`,`album_desc`,`album_excerpt`,`album_image`,`artist_id`,`coupling_ids`,`update_date`,`show_name`,`broadcast_year`,`grade`,`is_subtitle`,`film_rating`,`catalogue_id`,`content_type` FROM album_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}
	public function getAllAlbums(array $a=array()){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY insert_date DESC '; $where ='';
		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderby = $a['orderby'];
		}
		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
		 $this->sSql = "SELECT album_id,album_name,insert_date,status,language_id,label_id,music_release_date,title_release_date,album_image,`catalogue_id`,`album_type`,`content_type`,`coupling_ids` FROM `album_mstr` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY insert_date DESC '; $where ='';

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderby = $a['orderby'];
		}
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
		
		$this->sSql = "SELECT count(1) as cnt FROM `album_mstr` WHERE status!='-1' $where";
		$res = $this->oMysqli->query($this->sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	/*********************************************
	* Will map artist and role with album 
	* @Param: array()
	**********************************************/
	public function mapArtistAlbum( array $a = array() ){
		if($a){
			#$this->oMysqli->query("START TRANSACTION");
			$albumId=(int)$a['albumId'];
			$artistRoleKeyArray=$a['artistRoleKeyArray'];
			if($albumId){
				$this->sSql = "DELETE FROM artist_album WHERE album_id='".$albumId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistRoleKeyArray){
				foreach($artistRoleKeyArray as $kAR=>$vAR){ 
					$this->sSql = "INSERT INTO artist_album (`album_id`,`artist_id`,`artist_role`) VALUES ('".$albumId."','".$kAR."',".$vAR.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			/*if($res){
				$this->oMysqli->query("COMMIT");
			}else{
				$this->oMysqli->query("ROLLBACK");
			}*/
		}
	}
	/*********************************************
	* Get map artist and role with album 
	* @Param: array()
	**********************************************/
	public function getArtistAlbumMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM artist_album WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Will map banner with album 
	* @Param: array()
	**********************************************/
	public function mapBannerAlbum( array $a = array() ){
		if($a){
			$albumId=(int)$a['albumId'];
			$bannerIdsArray=$a['bannerIds'];
			if($albumId){
				$this->sSql = "DELETE FROM album_banner WHERE album_id='".$albumId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($bannerIdsArray){
				foreach($bannerIdsArray as $kB=>$vB){ 
					$this->sSql = "INSERT INTO album_banner (`album_id`,`banner_id`) VALUES ('".$albumId."',".$vB.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map banners with album 
	* @Param: array()
	**********************************************/
	public function getBannerAlbumMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM album_banner WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Will map Tags with album 
	* @Param: array()
	**********************************************/
	public function mapTagAlbum( array $a = array() ){
		if($a){
			$albumId=(int)$a['albumId'];
			$tagIdsArray=$a['tagIds'];
			if($albumId){
				$this->sSql = "DELETE FROM album_tags WHERE album_id='".$albumId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($tagIdsArray){
				foreach($tagIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO album_tags (`album_id`,`tag_id`) VALUES ('".$albumId."',".$vT.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Get map tags with album 
	* @Param: array()
	**********************************************/
	public function getTagAlbumMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM album_tags WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		$this->sSql = "UPDATE `album_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND album_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($this->sSql);
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
		$this->sSql = "UPDATE `album_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND album_id IN(".implode(',', $a['contentIds']).") 
						$sQuery  
						LIMIT $limit";
		$res = $this->oMysqli->query($this->sSql);
	}
	/*
		Get All Album Type
	*/
	public function getAlbumType(array $a = array()){
		global $aConfig;
		return $aConfig['album_type'];
	}
	/*
		Get All Album Type by value
	*/
	public function getAlbumTypeByValue($val){
		global $aConfig;
		$albumTypeArr=$aConfig['album_type'];
		$roleArr=array();
		foreach($albumTypeArr as $kAT => $vAT){
			if(($val&$vAT)==$vAT){
				$roleArr[]=$kAT;
			}		
		}
		return $roleArr;
	}
	/*
	*	Add/edit album rights
	*/
	public function addAlbumRights(array $a=array()) {
		if($a){
		
			$albumId=$this->oMysqli->secure($a['albumId']);
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

	
			$this->sSql = "INSERT INTO `album_rights` (`album_id`,`is_owned`,`banner_id`,`territory_in`,`territory_ex`,`start_date`,`expiry_date`,`physical_rights`,`publishing_rights`,`digital_rights`,`is_exclusive`,`insert_date`) VALUES ('".$albumId."','".$isCtype."','".$banner_id."','".$territory_in."','".$territory_ex."','".$start_date."','".$end_date."','".$physical_rights."',".$publishing_rights.",".$digital_rights.",".$is_exclusive.",now()) ON DUPLICATE KEY UPDATE `is_owned`='".$isCtype."',`banner_id`='".$banner_id."',`territory_in`='".$territory_in."',`territory_ex`='".$territory_ex."',`start_date`='".$start_date."',`expiry_date`='".$end_date."',`physical_rights`='".$physical_rights."',`publishing_rights`=".$publishing_rights.",`digital_rights`=".$digital_rights.",`is_exclusive`='".$is_exclusive."'";					
			
		//	echo $this->sSql;
			$data=$this->oMysqli->query($this->sSql);
			
			/*if( $legal_status==2 ){
				$up_sql = "UPDATE album_mstr SET `status`=2 WHERE album_id='".$albumId." AND `status`=0 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}else if( $legal_status==0 ){
				$up_sql = "UPDATE album_mstr SET `status`=0 WHERE album_id='".$albumId." 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}	*/		
			
			return $data;
		}
	}
	public function __toString(){
        return $this->sSql;
    }
	/*********************************************
	* Get map rights with album 
	* @Param: array()
	**********************************************/
	public function getRightsByAlbumId( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM album_rights WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	/*********************************************
	* Update song rank of album 
	* @Param: array()
	**********************************************/
	public function mapAlbumSongRank( array $a = array() ){
		if( !empty($a) ){
			if($a['songRank']){
				foreach($a['songRank'] as $rK=>$rV){
					$this->sSql = "UPDATE song_album SET rank='".(int)$rV."' WHERE song_id='".(int)$rK."' AND album_id='".(int)$a['albumId']."' LIMIT 1";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			return $res;
		}
	}
	
/*********************************************
* Update video rank of album 
* @Param: array()
**********************************************/
	public function mapAlbumVideoRank( array $a = array() ){
		if($a){
			if($a['videoRank']){
				foreach($a['videoRank'] as $rK=>$rV){
					$this->sSql = "UPDATE album_video SET rank='".(int)$rV."' WHERE video_id='".(int)$rK."' AND album_id='".(int)$a['albumId']."' LIMIT 1";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			return $res;
		}
	}
	
	/*********************************************
	* Update song rank of album 
	* @Param: array()
	**********************************************/
	public function removeAlbumSong( array $a = array() ){
		if($a){
			if($a['selectIds']){
				foreach($a['selectIds'] as $rK=>$rV){
					$this->sSql = "DELETE FROM song_album WHERE song_id='".(int)$rV."' AND album_id='".(int)$a['albumId']."' LIMIT 1";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			return $res;
		}
	}

	/*********************************************
	* Update video rank of album 
	* @Param: array()
	**********************************************/
	public function removeAlbumVideo( array $a = array() ){
		if($a){
			if($a['selectIds']){
				foreach($a['selectIds'] as $rK=>$rV){
					$this->sSql = "DELETE FROM album_video WHERE video_id='".(int)$rV."' AND album_id='".(int)$a['albumId']."' LIMIT 1";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			return $res;
		}
	}	
	/*********************************************
	* Map album to avoid duplications 
	* @Param: array()
	**********************************************/
	public function mapAlbumToOriginal( array $a = array() ){
		if($a){
			if($a['mAlbumId'] && $a['albumId']){
					foreach($a['mAlbumId'] as $mK=>$mV){
												
						$sSql = "SELECT song_id FROM song_album WHERE album_id='".(int)$mV."'";
						$res = $this->oMysqli->query($sSql);
						if( $res ){
							foreach( $res as $data ){
								$sSql = "DELETE FROM song_album WHERE album_id='".(int)$a['albumId']."' AND song_id='".$data->song_id."' LIMIT 1";
								$resd = $this->oMysqli->query($sSql);
							}
						
							$this->sSql = "UPDATE song_album SET album_id='".(int)$a['albumId']."' WHERE album_id='".(int)$mV."'";
							$res = $this->oMysqli->query($this->sSql);
						}
						
						$sSql = "SELECT artist_id FROM artist_album WHERE album_id='".(int)$mV."'";
						$res = $this->oMysqli->query($sSql);
						if( $res ){
							foreach( $res as $data ){
								$sSql = "DELETE FROM artist_album WHERE album_id='".(int)$a['albumId']."' AND artist_id='".$data->artist_id."' LIMIT 1";
								$resd = $this->oMysqli->query($sSql);
							}
						
							$this->sSql = "UPDATE artist_album SET album_id='".(int)$a['albumId']."' WHERE album_id='".(int)$mV."'";
							$res = $this->oMysqli->query($this->sSql);
						}
												
						$this->sSql ="DELETE FROM album_mstr WHERE album_id=".$mV." LIMIT 1";
						$res = $this->oMysqli->query($this->sSql);
			
					}
			}
			return $res;
		}
	}
	/*
		save in temp table
	*/
	public function saveTempBulk( array $a= array() ){
		$album_name=$this->oMysqli->secure($a['album_name']);
		$catalogue=$this->oMysqli->secure($a['catalogue']);
		$language=$this->oMysqli->secure($a['language']);
		$label =$this->oMysqli->secure($a['label']);
		$content_type=$this->oMysqli->secure($a['content_type']);
		$title_release_date=$this->oMysqli->secure($a['title_release_date']);
		$music_release_date=$this->oMysqli->secure($a['music_release_date']);
		$banner=$this->oMysqli->secure($a['banner']);
		$primary_artist=$this->oMysqli->secure($a['primary_artist']);
		$starcast=$this->oMysqli->secure($a['starcast']);
		$director=$this->oMysqli->secure($a['director']);
		$producer=$this->oMysqli->secure($a['producer']);
		$writer=$this->oMysqli->secure($a['writer']);
		$lyricist=$this->oMysqli->secure($a['lyricist']);
		$music_director=$this->oMysqli->secure($a['music_director']);
		$album_type=$this->oMysqli->secure($a['album_type']);
		$album_description=$this->oMysqli->secure($a['album_description']);
		$coupling_ids=$this->oMysqli->secure($a['coupling_ids']);
		$tv_channel=$this->oMysqli->secure($a['tv_channel']);
		$radio_station=$this->oMysqli->secure($a['radio_station']);
		$show_name=$this->oMysqli->secure($a['show_name']);
		$year_broadcast=$this->oMysqli->secure($a['year_broadcast']);
		$grade=$this->oMysqli->secure($a['grade']);
		$film_rating=$this->oMysqli->secure($a['film_rating']);
		$artwork_file_path=$this->oMysqli->secure($a['artwork_file_path']);
		$batch_id=$this->oMysqli->secure($a['batch_id']);
		$remarks=$this->oMysqli->secure($a['remarks']);
		$id = $this->oMysqli->secure($a['id']);
		$status=$this->oMysqli->secure($a['status']);
		
		if($id>0){
			$this->sSql="UPDATE `album_bulk_temp` 	SET	`album_name` = '".$album_name."' , 	`catalogue` = '".$catalogue."' , 	`language` = '".$language."' , 	`label` = '".$label."' , 	`content_type` = '".$content_type."' , 	`title_release_date` = '".$title_release_date."' , 	`music_release_date` = '".$music_release_date."' , 	`banner` = '".$banner."' , 	`primary_artist` = '".$primary_artist."' , `starcast` = '".$starcast."' , 	`director` = '".$director."' , 	`producer` = '".$producer."' , 	`writer` = '".$writer."',`lyricist`='".$lyricist."',`music_director`='".$music_director."' , 	`album_type` = '".$album_type."' , 	`album_description` = '".$album_description."' , 	`coupling_ids` = '".$coupling_ids."' , 	`tv_channel` = '".$tv_channel."' , 	`radio_station` = '".$radio_station."' , 	`show_name` = '".$show_name."' , 	`year_broadcast` = '".$year_broadcast."' , 	`grade` = '".$grade."' , 	`film_rating` = '".$film_rating."' , 	`artwork_file_path` = '".$artwork_file_path."' , 	`status` = '".$status."' ,`update_date` = NOW() , 	`batch_id` = '".$batch_id."' , 	`remarks` = '".$remarks."'		WHERE	`id` = '".$id."'  LIMIT 1";		
		}else{		
			$this->sSql = "
INSERT INTO `album_bulk_temp` 	(`album_name`, 	`catalogue`, 	`language`, 	`label`, 	`content_type`, 	`title_release_date`, 	`music_release_date`, 	`banner`, 	`primary_artist`, 	`starcast`, 	`director`, 	`producer`, 	`writer`,`lyricist`,`music_director`,`album_type`, 	`album_description`, 	`coupling_ids`, 	`tv_channel`, 	`radio_station`, 	`show_name`, 	`year_broadcast`, 	`grade`, 	`film_rating`, `artwork_file_path`, 	`status`, 	`insert_date`, 	`batch_id`, 	`remarks`	)	VALUES	( 	'".$album_name."', 	'".$catalogue."', 	'".$language."', 	'".$label."', 	'".$content_type."', 	'".$title_release_date."', 	'".$music_release_date."', 	'".$banner."', 	'".$primary_artist."', 	'".$starcast."', 	'".$director."', 	'".$producer."', 	'".$writer."','".$lyricist."','".$music_director."','".$album_type."', 	'".$album_description."', 	'".$coupling_ids."', 	'".$tv_channel."', 	'".$radio_station."', 	'".$show_name."', 	'".$year_broadcast."', 	'".$grade."', 	'".$film_rating."', 	'".$artwork_file_path."', 	'".$status."', 	NOW(), '".$batch_id."', 	'".$remarks."'	);";
		}
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns all BulkSong 
	*@Param: array()
	********************************************/
	public function getAllBulkAlbums( array $a = array() ){
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
		$this->sSql = "SELECT * FROM `album_bulk_temp` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	

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
		$this->sSql = "SELECT COUNT(DISTINCT batch_id) as cnt FROM `album_bulk_temp` sm WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	function updateGoToDbBulk( array $a = array() ){
		$id=$a['id'];
		$this->sSql = "UPDATE `album_bulk_temp` SET gotodb='1',update_date=now() WHERE id='".$id."'";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	
	function legalExpireAlbumsCount( array $a = array() ){
		
		$where = " ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}
		$this->sSql = "SELECT COUNT(DISTINCT album_id) AS cnt FROM `album_rights` WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
		
	function legalExpireAlbums( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY album_id DESC '; $where ='';$includes ='';

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

		$this->sSql ="SELECT album_id,expiry_date FROM `album_rights` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	
	}	
}
?>