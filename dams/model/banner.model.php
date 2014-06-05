<?php
/* banner management */
class banner
{
 	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }

	// insert a new banner
	public function addBanner(array $a=array()) {
		if($a){
			$banner_name=$a['bannerName'];
			$status=$a['status'];
			$sSql = "INSERT INTO banner_mstr (banner_name,insert_date) VALUES ('".$this->oMysqli->secure($banner_name)."',now())";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function checkBannerExist($banner){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND id!=".(int)$_GET['id'];
		}
		$sSql="SELECT count(1) as cnt FROM banner_mstr WHERE banner_name = '".$this->oMysqli->secure($banner)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	// edit a banner
	public function editBanner(array $a=array()) {
		if($a){
			$banner_name=$a['bannerName'];
			$status=$a['status'];
			$bannerId=$a['id'];
			$sSql = "UPDATE banner_mstr SET banner_name='".$this->oMysqli->secure($banner_name)."' WHERE banner_id='".$bannerId."' LIMIT 1";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getBannerById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND banner_id IN(".$a['ids'].")";
			}	
		$sSql="SELECT banner_id,banner_name,status FROM banner_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getAllBanners(array $a=array()){
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
		$sSql = "SELECT banner_id,banner_name,status FROM `banner_mstr` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
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
		$sSql = "SELECT count(1) as cnt FROM `banner_mstr` WHERE status!='-1' $where";
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
		$sSql = "UPDATE `banner_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND banner_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$sSql = "UPDATE `banner_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND banner_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($sSql);
	}
}
?>