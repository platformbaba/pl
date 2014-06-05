<?php
/* label management */
class label
{
 	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }

	// insert a new label
	public function addLabel(array $a=array()) {
		if($a){
			$label_name=$a['labelName'];
			$status=$a['status'];
			$sSql = "INSERT INTO label_mstr (label_name,insert_date) VALUES ('".$this->oMysqli->secure($label_name)."',now())";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function checkLabelExist($label){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND id!=".(int)$_GET['id'];
		}
		$sSql="SELECT count(1) as cnt FROM label_mstr WHERE label_name = '".$this->oMysqli->secure($label)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	// edit a label
	public function editLabel(array $a=array()) {
		if($a){
			$label_name=$a['labelName'];
			$status=$a['status'];
			$labelId=$a['id'];
			$sSql = "UPDATE label_mstr SET label_name='".$this->oMysqli->secure($label_name)."' WHERE label_id='".$labelId."' LIMIT 1";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getLabelById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND label_id IN(".$a['ids'].")";
			}	
			$sSql="SELECT label_id,label_name,status FROM label_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getAllLabels(array $a=array()){
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
		$sSql = "SELECT label_id,label_name,status FROM `label_mstr` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
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

		$sSql = "SELECT count(1) as cnt FROM `label_mstr` WHERE status!='-1' $where";
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
		$sSql = "UPDATE `label_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND label_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$sSql = "UPDATE `label_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND label_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($sSql);
	}
}
?>