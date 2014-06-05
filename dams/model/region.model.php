<?php
/* region management */
class region
{
 	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }

	// insert a new region
	public function addRegion(array $a=array()) {
		if($a){
			$region_name=$a['regionName'];
			$status=$a['status'];
			$sSql = "INSERT INTO region_mstr (region_name,insert_date) VALUES ('".$this->oMysqli->secure($region_name)."',now())";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function checkRegionExist($region){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND id!=".(int)$_GET['id'];
		}
		$sSql="SELECT count(1) as cnt FROM region_mstr WHERE region_name = '".$this->oMysqli->secure($region)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	// edit a region
	public function editRegion(array $a=array()) {
		if($a){
			$region_name=$a['regionName'];
			$status=$a['status'];
			$regionId=$a['id'];
			$sSql = "UPDATE region_mstr SET region_name='".$this->oMysqli->secure($region_name)."' WHERE region_id='".$regionId."' LIMIT 1";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getRegionById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND region_id IN(".$a['ids'].")";
			}	
			$sSql="SELECT region_id,region_name,status FROM region_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getAllRegions(array $a=array()){
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
		$sSql = "SELECT region_id,region_name,status FROM `region_mstr` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
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
		$sSql = "SELECT count(1) as cnt FROM `region_mstr` WHERE status!='-1' $where";
		$res = $this->oMysqli->query($sSql);
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
		$sSql = "UPDATE `region_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND region_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$sSql = "UPDATE `region_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND region_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will insert all language - region mapping
	* @param: array
	********************************************/
	public function mapRegionLanguage( array $a = array() ){
		if($a){
			$regionId=$a['regionId'];
			if($regionId){
				$iSql="DELETE FROM region_language WHERE region_id=".$this->oMysqli->secure($regionId);
				$idata = $this->oMysqli->query($iSql);
			}
			$languageArr=$a['languageArr'];
			if($languageArr){
				foreach($languageArr as $languageId){			
					$sSql = "INSERT INTO region_language (region_id,language_id) VALUES('".$this->oMysqli->secure($regionId)."','".$this->oMysqli->secure($languageId)."')";
					$data = $this->oMysqli->query($sSql);
				}
			}			
			return $data;
		}
	}
	/*********************************************
	* Will return all languages by region
	* @param: array
	********************************************/
	function getLanguagesByRegion( array $a = array() ){
		if($a){
			$regionId=$a['regionId'];
			$sSql = "SELECT * FROM `region_language` WHERE region_id='".$this->oMysqli->secure($regionId)."'";
			$data = $this->oMysqli->query($sSql);
			return $data;	
		}
    }
}
?>