<?php
/**
 * The Text Model does the back-end Work for the Text ( SMS/TRIVIA) Controller
 */
class text
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all text 
	*@Param: array()
	********************************************/
	public function getAllTexts( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY text_id DESC '; $where ='';

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
			$where .= " AND status!='-1'";
		
		$this->sSql = "SELECT * FROM `text_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql,'utf8');
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
		
		$this->sSql = "SELECT count(1) as cnt FROM `text_mstr` WHERE 1 $where ";
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
			$this->sSql = "UPDATE `text_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id='".(int)$a['contentId']."' LIMIT 1";
			if( $this->oMysqli->query( $this->sSql ) ){
				
				/* Delete Image_map records */
				$res = $this->oMysqli->query( "DELETE FROM `text_map` WHERE text_id='".(int)$a['contentId']."' " );
			
				$this->oMysqli->query( "COMMIT" );
			}else{
				$this->oMysqli->query( "ROLLBACK" );
			}
		
		}else{
			
		$this->sSql = "UPDATE `text_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id='".(int)$a['contentId']."' LIMIT 1";
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
			$this->sSql = "UPDATE `text_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
			if( $this->oMysqli->query( $this->sSql ) ){
				
				/* Delete Text_map records */
				$res = $this->oMysqli->query( "DELETE FROM `text_map` WHERE text_id IN(".implode(',', $a['contentIds']).") " );
			
				$this->oMysqli->query( "COMMIT" );
			}else{
				$this->oMysqli->query( "ROLLBACK" );
			}
		
		}else{
			
			$this->sSql = "UPDATE `text_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id IN(".implode(',', $a['contentIds']).")
						  $sQuery
						  LIMIT $limit";
			$res = $this->oMysqli->query( $this->sSql );
		}
		
	}

		
	/**********************************************
	*Will insert/Update Text
	* @param: array 
	**********************************************/
	public function saveText( array $a = array() ){
		
		if((int)$_GET['id']>0){
			
			$this->sSql = "UPDATE `text_mstr` SET `text_name`='".$this->oMysqli->secure($a['textName'])."', `text_desc`='".$this->oMysqli->secure($a['textDesc'])."',`text_type`=".(int)$a['textType'].", language_id=".(int)$a['languageIds'].", `file_path`='".$this->oMysqli->secure($a['txtFileName'])."'  WHERE text_id = ".(int)$_GET['id']." LIMIT 1";
        }else{
			$this->sSql = "INSERT INTO `text_mstr` (`text_name`, `text_desc`, `text_type`,`language_id`, `insert_date`,`file_path`) VALUES ('".$this->oMysqli->secure($a['textName'])."', '".$this->oMysqli->secure($a['textDesc'])."', ".(int)$a['textType'].", ".(int)$a['languageIds'].", NOW(),'".$this->oMysqli->secure($a['txtFileName'])."')";
				
		}
		$statusid = $this->oMysqli->query( $this->sSql,'utf8');
		return $statusid;
	
	}
	
	/*********************************************
	* Will map Albums with Text
	* @Param: array()
	**********************************************/
	public function mapAlbumText( array $a = array() ){
		if($a){
			$textId=(int)$a['textId'];
			$albumIdsArray=$a['albumIds'];
			if($textId){
				$this->sSql = "DELETE FROM `text_map` WHERE text_id='".$textId."' AND content_type=14";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($albumIdsArray){
				foreach($albumIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `text_map` (`text_id`,`content_id`,`content_type`) VALUES ('".$textId."',".$vT.", 14)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
		
	/*********************************************
	* Will map Artist with Text
	* @Param: array()
	**********************************************/
	public function mapArtistText( array $a = array() ){
		if($a){
			$textId=(int)$a['textId'];
			$artistIdsArray=$a['artistIds'];
			if($textId){
				$this->sSql = "DELETE FROM `text_map` WHERE text_id='".$textId."' AND content_type=13";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if($artistIdsArray){
				foreach($artistIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT IGNORE INTO `text_map` (`text_id`,`content_id`,`content_type`) VALUES ('".$textId."',".$vT.", 13)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	
	/**********************************************
	* Will return mapped artist and albums
	**********************************************/
	public function getTextMap( array $a = array() ){
		
		$where="";
		if($a['where']){
			$where=$a['where'];
		}
		$this->sSql = "SELECT * FROM text_map WHERE 1 $where";
		return $res = $this->oMysqli->query($this->sSql);
	}

	/*
	*	Add/edit text rights
	*/
	public function addTextRights(array $a=array()) {
		if($a){
		
			$textId=$this->oMysqli->secure($a['textId']);
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

			
				$this->sSql = "INSERT INTO `text_rights` (`text_id`,`is_owned`,`banner_id`,`territory_in`,`territory_ex`,`start_date`,`expiry_date`,`physical_rights`,`publishing_rights`,`digital_rights`,`is_exclusive`,`insert_date`) VALUES ('".$textId."','".$isCtype."','".$banner_id."','".$territory_in."','".$territory_ex."','".$start_date."','".$end_date."','".$physical_rights."',".$publishing_rights.",".$digital_rights.",".$is_exclusive.",now()) ON DUPLICATE KEY UPDATE `is_owned`='".$isCtype."',`banner_id`='".$banner_id."',`territory_in`='".$territory_in."',`territory_ex`='".$territory_ex."',`start_date`='".$start_date."',`expiry_date`='".$end_date."',`physical_rights`='".$physical_rights."',`publishing_rights`=".$publishing_rights.",`digital_rights`=".$digital_rights.",`is_exclusive`='".$is_exclusive."'";
					
		//	echo $this->sSql;
			$data=$this->oMysqli->query($this->sSql);
			
			/*if( $legal_status==2 ){
				$up_sql = "UPDATE text_mstr SET `status`=2 WHERE text_id='".$textId." AND `status`=0 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}else if( $legal_status==0 ){
				$up_sql = "UPDATE text_mstr SET `status`=0 WHERE text_id='".$textId." 'LIMIT 1";
				$this->oMysqli->query( $up_sql );
			}	*/		
			
			return $data;
		}
	}
	/*********************************************
	* Get map rights with text 
	* @Param: array()
	**********************************************/
	public function getRightsByTextId( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM text_rights WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}	

	/*
		save in temp table
	*/
	public function saveTempBulk( array $a= array() ){
		$text_title=$this->oMysqli->secure($a['text_title']);
		$text_type=$this->oMysqli->secure($a['text_type']);
		$text_description=$this->oMysqli->secure($a['text_description']);
		$text_language=$this->oMysqli->secure($a['text_language']);
		$album_name =$this->oMysqli->secure($a['album_name']);
		$artist_name=$this->oMysqli->secure($a['artist_name']);
		$file_path=$this->oMysqli->secure($a['file_path']);
		$remarks=$this->oMysqli->secure($a['remark']);
		$batch_id = $this->oMysqli->secure($a['batch_id']);
		$id = $this->oMysqli->secure($a['id']);
		$status=$this->oMysqli->secure($a['status']);
		$gotodb=$this->oMysqli->secure($a['gotodb']);
		
		if($id>0){
			$this->sSql="
UPDATE `text_bulk_temp` SET	`text_title` = '".$text_title."' , `text_type` = '".$text_type."' ,	`text_description` = '".$text_description."' ,`album_name` = '".$album_name."' ,`artist_name` = '".$artist_name."',`text_language`='".$text_language."' ,`file_path` = '".$file_path."' ,`status` = '".$status."' , 	`update_date` = NOW() ,	`batch_id` = '".$batch_id."' ,	`remarks` = '".$remarks."' ,`gotodb` = '".$gotodb."'	WHERE	`id` = '".$id."' LIMIT 1";		
		}else{		
			$this->sSql = "
INSERT INTO `text_bulk_temp` 	(`text_title`, 	`text_type`, 	`text_description`, 	`album_name`, 	`artist_name`,`text_language`, 	`file_path`, 	`status`, 	`insert_date`, 	 	`batch_id`, 	`remarks`)	VALUES	('".$text_title."', 	'".$text_type."', 	'".$text_description."', 	'".$album_name."', 	'".$artist_name."', '".$text_language."','".$file_path."', 	0, NOW(), 	'".$batch_id."', '".$remarks."'	);";
		}
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns all BulkSong 
	*@Param: array()
	********************************************/
	public function getAllBulkTexts( array $a = array() ){
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
		$this->sSql = "SELECT * FROM `text_bulk_temp` sm WHERE 1 $where $orderBy LIMIT $start, $limit";	

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
		$this->sSql = "SELECT COUNT(DISTINCT batch_id) as cnt FROM `text_bulk_temp` sm WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	function updateGoToDbBulk( array $a = array() ){
		$id=$a['id'];
		$this->sSql = "UPDATE `text_bulk_temp` SET gotodb='1',update_date=now() WHERE id='".$id."'";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	
	public function __toString(){
        return $this->sSql;
    }
}