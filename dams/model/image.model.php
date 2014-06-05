<?php 
/**
 * The Image Model does the back-end Work for the Image ( Wallpaper/Animation ) Controller
 */
class image
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all image 
	*@Param: array()
	********************************************/
	public function getAllImages( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY image_id DESC '; $where ='';

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
			$where .= " AND status!='-1' ";
		
		$this->sSql = "SELECT * FROM `image_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}

	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$where ='';
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
			$where .= " AND  status!='-1' ";
		
		$this->sSql = "SELECT count(1) as cnt FROM `image_mstr` WHERE 1 $where ";
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
		if( $a['contentActionValue'] == '-1' ){
			/* Delete Mapped records */
			$this->oMysqli->query( "START TRANSACTION" );
			$this->sSql = "UPDATE `image_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND image_id='".(int)$a['contentId']."' LIMIT 1";
			if( $this->oMysqli->query( $this->sSql ) ){
				
				/* Delete Image_map records */
				$res = $this->oMysqli->query( "DELETE FROM `image_map` WHERE image_id='".(int)$a['contentId']."' " );
			
				$this->oMysqli->query( "COMMIT" );
			}else{
				$this->oMysqli->query( "ROLLBACK" );
			}
		
		}else{
			
		$this->sSql = "UPDATE `image_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND image_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
		}
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
		if( $a['contentActionValue'] == '-1' ){
			
			/* Delete Mapped records */
			$this->oMysqli->query( "START TRANSACTION" );
			$this->sSql = "UPDATE `image_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND image_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
			if( $this->oMysqli->query( $this->sSql ) ){
				
				/* Delete Image_map records */
				$res = $this->oMysqli->query( "DELETE FROM `image_map` WHERE image_id IN(".implode(',', $a['contentIds']).") " );
			
				$this->oMysqli->query( "COMMIT" );
			}else{
				$this->oMysqli->query( "ROLLBACK" );
			}
		
		}else{
			
			$this->sSql = "UPDATE `image_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND image_id IN(".implode(',', $a['contentIds']).")
							$sQuery
						 	LIMIT $limit";
			$res = $this->oMysqli->query( $this->sSql );
		}
		
	}

		
	/**********************************************
	*Will insert/Update Image
	* @param: array 
	**********************************************/
	public function saveImage( array $a = array() ){
		
		if((int)$_GET['id']>0){ 
			
			$this->sSql = "UPDATE `image_mstr` SET `image_name`='".$this->oMysqli->secure($a['imageName'])."', `image_desc`='".$this->oMysqli->secure($a['imageDesc'])."',`image_type`=".(int)$a['imageType'].",`image_tag_id`=".(int)$a['imageCategory'].", `image_file`='".$this->oMysqli->secure($a['imageFile'])."' WHERE image_id = ".(int)$_GET['id']." LIMIT 1";
        }else{
			$this->sSql = "INSERT INTO `image_mstr` (`image_name`, `image_desc`,`image_file`, `image_type`, `image_tag_id`,`insert_date`,status) VALUES ('".$this->oMysqli->secure($a['imageName'])."', '".$this->oMysqli->secure($a['imageDesc'])."', '".$this->oMysqli->secure($a['imageFile'])."', ".(int)$a['imageType'].", ".(int)$a['imageCategory'].", NOW(), '".(int)$a['status']."')";
		
		}
		
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	
	}
	
	/*********************************************
	* Will map Albums with Image 
	* @Param: array()
	**********************************************/
	public function mapAlbumImage( array $a = array() ){
		if($a){
			$imageId=(int)$a['imageId'];
			$albumIdsArray=$a['albumIds'];
			if($imageId){
				$this->sSql = "DELETE FROM `image_map` WHERE image_id='".$imageId."' AND content_type=14";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($albumIdsArray){
				foreach($albumIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `image_map` (`image_id`,`content_id`,`content_type`) VALUES ('".$imageId."',".$vT.", 14)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	
	
	/*********************************************
	* Will map Radio Station with Image 
	* @Param: array()
	**********************************************/
	public function mapRadioStationImage( array $a = array() ){
		if($a){
			$imageId=(int)$a['imageId'];
			$radioIdsArray=$a['radioIds'];
			if($imageId){
				$this->sSql = "DELETE FROM `image_map` WHERE image_id='".$imageId."' AND content_type=39";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($radioIdsArray){
				foreach($radioIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `image_map` (`image_id`,`content_id`,`content_type`) VALUES ('".$imageId."',".$vT.", 39)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Will map Artist with Image 
	* @Param: array()
	**********************************************/
	public function mapArtistImage( array $a = array() ){
		if($a){
			$imageId=(int)$a['imageId'];
			$artistIdsArray=$a['artistIds'];
			if($imageId){
				$this->sSql = "DELETE FROM `image_map` WHERE image_id='".$imageId."' AND content_type=13";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistIdsArray){
				foreach($artistIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `image_map` (`image_id`,`content_id`,`content_type`) VALUES ('".$imageId."',".$vT.", 13)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	
	/*********************************************
	* Will map Video with Image 
	* @Param: array()
	**********************************************/
	public function mapVideoImage( array $a = array() ){
		if($a){
			$imageId=(int)$a['imageId'];
			$artistIdsArray=$a['videoIds'];
			if($imageId){
				$this->sSql = "DELETE FROM `image_map` WHERE image_id='".$imageId."' AND content_type=15";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistIdsArray){
				foreach($artistIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `image_map` (`image_id`,`content_id`,`content_type`) VALUES ('".$imageId."',".$vT.", 15)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Will map Song with Image 
	* @Param: array()
	**********************************************/
	public function mapSongImage( array $a = array() ){
		if($a){
			$imageId=(int)$a['imageId'];
			$artistIdsArray=$a['songIds'];
			if($imageId){
				$this->sSql = "DELETE FROM `image_map` WHERE image_id='".$imageId."' AND content_type=4";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistIdsArray){
				foreach($artistIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `image_map` (`image_id`,`content_id`,`content_type`) VALUES ('".$imageId."',".$vT.", 4)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	
	/**********************************************
	* Will return mapped artist and albums
	**********************************************/
	public function getImageMap( array $a = array() ){
		
		$where="";
		if($a['where']){
			$where=$a['where'];
		}
		$this->sSql = "SELECT * FROM image_map WHERE 1 $where";
		return $res = $this->oMysqli->query($this->sSql);
	}

	/*********************************************
	* Will map Albums with Image 
	* @Param: array()
	**********************************************/
	public function removeImageMap( array $a = array(), $conType ){
		if($a){
			if($a['selectIds']){
				foreach($a['selectIds'] as $rK=>$rV){
					$this->sSql = "DELETE FROM image_map WHERE image_id='".(int)$rV."' AND content_id='".(int)$a['contentId']."' AND content_type='".(int)$conType."' LIMIT 1";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			return $res;
		}
	} /* removeImageMap */
	/*********************************************
	* Get all Image Edits
	* Param: imageId
	*********************************************/
	public function getImageEdits( $imageId ){
		$this->sSql="SELECT `image_id`,`config_id`, `path`, `insert_date` FROM image_mstr_config_rel WHERE status!='-1' AND image_id='".(int)$imageId."'";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	/*********************************************
	* Get all Image Edits Config
	*********************************************/
	public function getImageEditsConfig( array $a=array() ){
		$this->sSql="SELECT * FROM image_edit_config WHERE `status`!='-1';";
		$data=$this->oMysqli->query($this->sSql);
		$retData = null;
		if( $data!='-1' ){
			foreach( $data as $k=>$vv ){
				$retData[$vv->image_edit_id]['data'] = $vv;
				$retData[$vv->image_edit_id]['str']  = 'Format: '.$vv->format.', Dimension: '.$vv->dimension.', File Size: '.$vv->file_size;
			}
		}
		return $retData;
	}
	/********************************************
	* Will returns all Song 
	*@Param: array()
	********************************************/
	public function getAllImagesConfig( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY image_edit_id ASC '; $where ='';$includes ='';

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
		$this->sSql = "SELECT * FROM `image_edit_config` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/*
	*	Add/edit image rights
	*/
	public function addImageRights(array $a=array()) {
		if($a){
		
			$imageId=$this->oMysqli->secure($a['imageId']);
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


			$this->sSql = "INSERT INTO `image_rights` (`image_id`,`is_owned`,`banner_id`,`territory_in`,`territory_ex`,`start_date`,`expiry_date`,`physical_rights`,`publishing_rights`,`digital_rights`,`is_exclusive`,`insert_date`) VALUES ('".$imageId."','".$isCtype."','".$banner_id."','".$territory_in."','".$territory_ex."','".$start_date."','".$end_date."','".$physical_rights."',".$publishing_rights.",".$digital_rights.",".$is_exclusive.",now()) ON DUPLICATE KEY UPDATE `is_owned`='".$isCtype."',`banner_id`='".$banner_id."',`territory_in`='".$territory_in."',`territory_ex`='".$territory_ex."',`start_date`='".$start_date."',`expiry_date`='".$end_date."',`physical_rights`='".$physical_rights."',`publishing_rights`=".$publishing_rights.",`digital_rights`=".$digital_rights.",`is_exclusive`='".$is_exclusive."'";					

			
			//echo $this->sSql;
			$data=$this->oMysqli->query($this->sSql);
			
			/*if( $legal_status==2 ){
				$up_sql = "UPDATE image_mstr SET `status`=2 WHERE image_id='".$imageId." AND `status`=0 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}else if( $legal_status==0 ){
				$up_sql = "UPDATE image_mstr SET `status`=0 WHERE image_id='".$imageId." 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}	*/		
			
			return $data;
		}
	}
	/*********************************************
	* Get map rights with image 
	* @Param: array()
	**********************************************/
	public function getRightsByImageId( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM image_rights WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}		

	/*
		save in temp table
	*/
	public function saveTempBulk( array $a= array() ){
		$image_title=$this->oMysqli->secure($a['image_title']);
		$image_type=$this->oMysqli->secure($a['image_type']);
		$image_tag_id=$this->oMysqli->secure($a['image_tag_id']);
		$image_description=$this->oMysqli->secure($a['image_description']);
		$album_name =$this->oMysqli->secure($a['album_name']);
		$artist_name=$this->oMysqli->secure($a['artist_name']);
		$song_isrc=$this->oMysqli->secure($a['song_isrc']);
		$file_path=$this->oMysqli->secure($a['file_path']);
		$remarks=$this->oMysqli->secure($a['remark']);
		$batch_id = $this->oMysqli->secure($a['batch_id']);
		$id = $this->oMysqli->secure($a['id']);
		$status=$this->oMysqli->secure($a['status']);
		$gotodb=$this->oMysqli->secure($a['gotodb']);
		
		if($id>0){
			$this->sSql="
UPDATE `image_bulk_temp` SET	`image_title` = '".$image_title."' , `image_type` = '".$image_type."' , `image_tag_id` = '".$image_tag_id."' ,	`image_description` = '".$image_description."' ,`album_name` = '".$album_name."' ,`artist_name` = '".$artist_name."',`song_isrc`='".$song_isrc."' ,`file_path` = '".$file_path."' ,`status` = '".$status."' , 	`update_date` = NOW() ,	`batch_id` = '".$batch_id."' ,	`remarks` = '".$remarks."' ,`gotodb` = '".$gotodb."'	WHERE	`id` = '".$id."' LIMIT 1";		
		}else{		
			$this->sSql = "
INSERT INTO `image_bulk_temp` 	(`image_title`, 	`image_type`, `image_tag_id`,	`image_description`, 	`album_name`, 	`artist_name`,`song_isrc`, 	`file_path`, 	`status`, 	`insert_date`, 	 	`batch_id`, 	`remarks`)	VALUES	('".$image_title."', 	'".$image_type."','".$image_tag_i."', 	'".$image_description."', 	'".$album_name."', 	'".$artist_name."', '".$song_isrc."','".$file_path."', 	0, NOW(), 	'".$batch_id."', '".$remarks."'	);";
		}
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns all BulkSong 
	*@Param: array()
	********************************************/
	public function getAllBulkImages( array $a = array() ){
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
		$this->sSql = "SELECT * FROM `image_bulk_temp` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	

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
		$this->sSql = "SELECT COUNT(DISTINCT batch_id) as cnt FROM `image_bulk_temp` sm WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	function updateGoToDbBulk( array $a = array() ){
		$id=$a['id'];
		$this->sSql = "UPDATE `image_bulk_temp` SET gotodb='1',update_date=now() WHERE id='".$id."'";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	public function __toString(){
        return $this->sSql;
    }
}