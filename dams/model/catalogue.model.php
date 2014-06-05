<?php
/* catalogue management */
class catalogue
{
 	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }

	
	// insert a new catalogue
	public function addCatalogue(array $a=array()) {
		if($a){
			
			$catalogue_id = $this->oMysqli->secure($a['catalogue_id']);
			$is_owned = $this->oMysqli->secure($a['is_owned']);
			$catalogueName = $this->oMysqli->secure($a['catalogueName']);
			$banner_id = $this->oMysqli->secure($a['banner_id']);
			$territory_in =  $this->oMysqli->secure($a['territory_in']);
			$territory_ex = $this->oMysqli->secure($a['territory_ex']);
			$start_date = $this->oMysqli->secure($a['start_date']);
			$end_date = $this->oMysqli->secure($a['end_date']);
			$agreementId = $this->oMysqli->secure($a['agreementId']);
			$agreementFile = $this->oMysqli->secure($a['agreementFile']);
			$intContDlt = $this->oMysqli->secure($a['internalContactDetails']);
			$contactDetails = $this->oMysqli->secure($a['contactDetails']);
			$is_exclusive = $this->oMysqli->secure($a['is_exclusive']);
			$physical_rights = $this->oMysqli->secure($a['physical_rights']);
			$publishing_rights = $this->oMysqli->secure($a['publishing_rights']);
			$digital_rights = $this->oMysqli->secure($a['digital_rights']);
			$status=$this->oMysqli->secure($a['status']);

		$this->sSql = 
				"INSERT INTO `catalogue_mstr` (`catalogue_id`,`catalogue_name`,`agreement_id`,`agreement_file`,
											`internal_contact_details`,`contact_details`,`is_owned`,`banner_id`,
											`territory_in`,`territory_ex`,`start_date`,`expiry_date`,
											`physical_rights`,`publishing_rights`,`digital_rights`,`is_exclusive`,
											`status`,`insert_date`)
				VALUES ('".$catalogue_id."','".$catalogueName."','".$agreementId."','".$agreementFile."',
						'".$intContDlt."','".$contactDetails."','".$is_owned."',".$banner_id.",
						'".$territory_in."','".$territory_ex."','".$start_date."','".$end_date."',
						'".$physical_rights."',".$publishing_rights.",".$digital_rights.",".$is_exclusive.",
						".$status.",NOW())
				ON DUPLICATE KEY UPDATE `catalogue_name`='".$catalogueName."',`agreement_id`='".$agreementId."',`agreement_file`='".$agreementFile."',
					  `internal_contact_details`='".$intContDlt."',`contact_details`='".$contactDetails."',`is_owned`='".$is_owned."',`banner_id`='".$banner_id."',
					  `territory_in`='".$territory_in."',`territory_ex`='".$territory_ex."',`start_date`='".$start_date."',`expiry_date`='".$end_date."',
					  `physical_rights`='".$physical_rights."',`publishing_rights`=".$publishing_rights.",`digital_rights`=".$digital_rights.",`is_exclusive`='".$is_exclusive."'";	
					  
		//echo " -- ".$this->sSql; exit;
		$data=$this->oMysqli->query($this->sSql);
		}
		return $data;
	}
	public function checkCatalogueExist($catalogue){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND id!=".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM catalogue_mstr WHERE catalogue_name = '".$this->oMysqli->secure($catalogue)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	public function getCatalogueById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND catalogue_id IN(".$a['ids'].")";
			}	
			 $this->sSql="SELECT * FROM catalogue_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}
	public function getAllCatalogues(array $a=array()){
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
		$this->sSql = "SELECT * FROM `catalogue_mstr` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($this->sSql);
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

		$this->sSql = "SELECT count(1) as cnt FROM `catalogue_mstr` WHERE status!='-1' $where";
		$res = $this->oMysqli->query($this->sSql);
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
		$this->sSql = "UPDATE `catalogue_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND catalogue_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($this->sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$this->sSql = "UPDATE `catalogue_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND catalogue_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($this->sSql);
	}
	public function __toString(){
        return $this->sSql;
    }
	
	function legalExpireCatalougeCount( array $a = array() ){
		
		$where = " ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}
		$this->sSql = "SELECT COUNT(DISTINCT catalouge_id) AS cnt FROM `catalogue_mstr` WHERE 1 $where $orderBy";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
		
	function legalExpireCatalogue( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY catalouge_id DESC '; $where ='';$includes ='';

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

		$this->sSql ="SELECT * FROM `catalogue_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	
	}		
}
?>