<?php
/**
 * The Tags Model does the back-end Work for the tag Controller
 */
class tags
{
	protected $oMysqli; 
	protected $sSql; 
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all Tags 
	*@Param: array()
	********************************************/
	public function getAllTags( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY parent_tag_id,tag_id DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
				
		if(isset($a['onlyParent']) && $a['onlyParent']){
			$where.=" AND parent_tag_id = 0";
		}
		
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		$where .= " AND  status!='-1' ";
		
		$this->sSql = "SELECT * FROM `tags_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$data = $this->oMysqli->query($this->sSql);
		$aData = '';
		if( !empty($data) ){
			foreach($data as $k=>$val){
				$aData[$val->tag_id] = $val;
			}
		}
		return $aData;
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
		
		$this->sSql = "SELECT count(1) as cnt FROM `tags_mstr` WHERE 1 $where ";
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
		$this->sSql = "UPDATE `tags_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND tag_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$this->sSql = "UPDATE `tags_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND tag_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of Tags
	* @param: string 
	**********************************************/
	public function checkTagExist($tagName, $parentTagId){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND tag_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `tags_mstr` WHERE tag_name = '".$this->oMysqli->secure($tagName)."' AND parent_tag_id = '".(int)$parentTagId."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update Tags
	* @param: array 
	**********************************************/
	public function saveTag( array $a = array() ){
		//, `status`='".$this->oMysqli->secure($a['status'])."'
		
		if((int)$_GET['id']>0){
			$this->sSql = "UPDATE `tags_mstr` SET `tag_name`='".$this->oMysqli->secure($a['tagName'])."', `tag_alias`='".$this->oMysqli->secure($a['tagAlias'])."', `image`='".$a['image']."', `parent_tag_id`= '".(int)$a['parentTagId']."' WHERE tag_id = ".(int)$_GET['id']." LIMIT 1";
        }else{
			$this->sSql = "INSERT INTO `tags_mstr` (`tag_name`, `tag_alias`, `parent_tag_id`, `image`, `insert_date`) VALUES ('".$this->oMysqli->secure($a['tagName'])."', '".$this->oMysqli->secure($a['tagAlias'])."', '".(int)$a['parentTagId']."', '".$a['image']."', NOW() )";
		
		}
		
		$statusid = $this->oMysqli->query($this->sSql);
		return $statusid;
	
	
	}
	
	public function __toString(){
		return $this->sSql;
	}
}