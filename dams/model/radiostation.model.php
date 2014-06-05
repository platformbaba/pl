<?php
/* Radiostation management */
class radiostation
{
 	protected $sSql;
	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }
	// Insert a new Radiostation
	public function addRadioStation(array $a=array()) {
		if($a){
		
			$station_id= $a['station_id'];
			$radioStationName= $a['radioStationName'];
			$languageIds = $a['languageIds'];
			$stationType = $a['stationType'];
			$preview_url = $a['preview_url'];
			$content_url = $a['content_url'];
			$description = $a['description'];
			$image		 = $a['image'];
			$artistId	 = $a['artistId_db'];

		if($station_id){
			
		$this->sSql = "UPDATE `radio_stations` SET `name`='".$this->oMysqli->secure($radioStationName)."',`language_id`='".$this->oMysqli->secure($languageIds)."',`content_url`='".$this->oMysqli->secure($content_url)."',`image`='".$this->oMysqli->secure($image)."',`description`='".$this->oMysqli->secure($description)."',`type`='".$stationType."',`artist_id`='".$this->oMysqli->secure($artistId)."',`preview_url`='".$this->oMysqli->secure($preview_url)."',`update_date`=NOW() WHERE `station_id`=".$station_id." LIMIT 1";
			
			}else{	
				$this->sSql = "INSERT INTO `radio_stations`(`name`,`language_id`,`content_url`,`image`,`description`,`type`,`artist_id`,`preview_url`,`insert_date`)
				VALUES('".$this->oMysqli->secure($radioStationName)."','".(int)$languageIds."','".$this->oMysqli->secure($content_url)."','".$this->oMysqli->secure($image)."','".$this->oMysqli->secure($description)."','".$this->oMysqli->secure($stationType)."','".$artistId."','".$preview_url."',NOW())";
				
			}
			//exit;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
	}
	}	
	public function checkRadioStationExist($radioStationName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND station_id!=".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM radio_stations WHERE name = '".$this->oMysqli->secure($radioStationName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	
	public function getAllRadioStation(array $a=array()){
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
		 $this->sSql = "SELECT * FROM `radio_stations` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
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
		
		$this->sSql = "SELECT count(1) as cnt FROM `radio_stations` WHERE status!='-1' $where";
		$res = $this->oMysqli->query($this->sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
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
		$this->sSql = "UPDATE `radio_stations` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND station_id IN(".implode(',', $a['contentIds']).") 
						$sQuery  
						LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}
	
	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		 $this->sSql = "UPDATE `radio_stations` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND station_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

###

	public function getRadioStationById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND station_id IN(".$a['ids'].")";
			}	
			$this->sSql="SELECT * FROM `radio_stations` WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	
	
	public function __toString(){
        return $this->sSql;
    }


}
?>