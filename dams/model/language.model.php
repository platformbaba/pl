<?php
/**
 * The Language Model does the back-end Work for the language Controller
 */
class language
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all languages 
	*@Param: array()
	********************************************/
	public function getAllLanguages( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY language_id DESC '; $where ='';

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
		
		$this->sSql = "SELECT * FROM `language_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns Single languages 
	*@Param: array()
	********************************************/
	public function getLanguageById( array $a = array() ){
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
			$where .= " AND status!='-1' ";
		
		echo $this->sSql = "SELECT language_name FROM `language_mstr` WHERE 1 $where";
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
		
		$this->sSql = "SELECT count(1) as cnt FROM `language_mstr` WHERE 1 $where ";
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
		$this->sSql = "UPDATE `language_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND language_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$this->sSql = "UPDATE `language_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND language_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of Language
	* @param: string 
	**********************************************/
	public function checkLanguageExist($languageName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND language_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `language_mstr` WHERE language_name = '".$this->oMysqli->secure($languageName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update Language
	* @param: array 
	**********************************************/
	public function saveLanguage( array $a = array() ){
		
		if((int)$_GET['id']>0){
			$this->sSql = "UPDATE `language_mstr` SET `language_name`='".$this->oMysqli->secure($a['languageName'])."' WHERE language_id = ".(int)$_GET['id']." LIMIT 1";
        }else{
			$this->sSql = "INSERT INTO `language_mstr` (`language_name`, `insert_date`) VALUES ('".$this->oMysqli->secure($a['languageName'])."', NOW() )";
		
		}
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	
	
	}
	
	public function __toString(){
        return $this->sSql;
    }
}