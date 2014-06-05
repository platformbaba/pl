<?php
/**
 * The Dashboard Model does the back-end Work for the dahsboard Controller
 */
class dashboard
{
	protected $oMysqli; 
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all activity 
	*@Param: array()
	********************************************/
	public function getAllContents( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY log_id DESC '; $where = '';

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
		
		$sSql = "SELECT * FROM saregama_db.`activity_log` WHERE 1 $where $orderby LIMIT $start, $limit";
		$res = $this->oMysqli->query($sSql);
		return $res;
	}

	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$where = '';
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
		
		$sSql = "SELECT count(1) as cnt FROM saregama_db.`activity_log` WHERE 1 $where";
		$res = $this->oMysqli->query($sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}

}