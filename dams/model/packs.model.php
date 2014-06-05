<?php
/**
 * The Pack Model does the back-end Work for the pack Controller
 */
class packs
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all pack 
	*@Param: array()
	********************************************/
	public function getAllPacks( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY pack_id DESC '; $where ='';

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
		
		$this->sSql = "SELECT * FROM `pack_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns Single pack 
	*@Param: array()
	********************************************/
	public function getPackById( array $a = array() ){
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
			$where .= " AND status!='-1' ";
		
		echo $this->sSql = "SELECT pack_name FROM `pack_mstr` WHERE 1 $where";
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
		
		$this->sSql = "SELECT count(1) as cnt FROM `pack_mstr` WHERE 1 $where ";
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
		$this->sSql = "UPDATE `pack_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND pack_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$this->sSql = "UPDATE `pack_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND pack_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of Pack
	* @param: string 
	**********************************************/
	public function checkPackExist($packName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND pack_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `pack_mstr` WHERE pack_name = '".$this->oMysqli->secure($packName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update Pack
	* @param: array 
	**********************************************/
	public function savePack( array $a = array() ){
		
		if((int)$_GET['id']>0){
			$this->sSql = "UPDATE `pack_mstr` SET 	
										`pack_name`='".$this->oMysqli->secure($a['packName'])."',
										`pack_desc`='".$this->oMysqli->secure($a['packDesc'])."',
										`language_id`='".$this->oMysqli->secure($a['languageIds'])."',
										`image`='".$this->oMysqli->secure($a['image'])."',
										`cat_id`='".$this->oMysqli->secure($a['catIds'])."',
										`update_date`=now()
									WHERE pack_id = ".(int)$_GET['id']." LIMIT 1";
			$statusid = $this->oMysqli->query( $this->sSql );
			$statusid = (int)$_GET['id'];
        }else{
			$this->sSql = "INSERT INTO `pack_mstr` SET
										`pack_name`='".$this->oMysqli->secure($a['packName'])."',
										`pack_desc`='".$this->oMysqli->secure($a['packDesc'])."',
										`language_id`='".$this->oMysqli->secure($a['languageIds'])."',
										`image`='".$this->oMysqli->secure($a['image'])."',
										`cat_id`='".$this->oMysqli->secure($a['catIds'])."',
										`update_date`=now(),
										`insert_date`=now()
										";
		
			$statusid = $this->oMysqli->query( $this->sSql );
		}
		
		return $statusid;
	
	
	}
	
	/*********************************************
	* Will map artist with pack 
	* @Param: array()
	**********************************************/
	public function mapPackArtist( array $a = array() ){
		if($a){
			$packId=(int)$a['packId'];
			$artistIds=$a['artistIds'];
			if($packId){
				$this->sSql = "DELETE FROM pack_artist WHERE pack_id='".$packId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if(!empty($artistIds)){
				foreach($artistIds as $kR=>$vR){ 
					$this->sSql = "INSERT IGNORE INTO pack_artist (`pack_id`,`artist_id`) VALUES ('".$packId."','".$vR."')";
					$res = $this->oMysqli->query($this->sSql);
				}
			}			
		}
	}
	
	/*********************************************
	* Get map artist with pack 
	* @Param: array()
	**********************************************/
	public function getPackArtistMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM pack_artist WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	
	/*********************************************
	* Will map album with pack 
	* @Param: array()
	**********************************************/
	public function mapPackAlbum( array $a = array() ){
		if($a){
			$packId=(int)$a['packId'];
			$albumIds=$a['albumIds'];
			if($packId){
				$this->sSql = "DELETE FROM pack_album WHERE pack_id='".$packId."'";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			if(!empty($albumIds)){
				foreach($albumIds as $kR=>$vR){ 
					$this->sSql = "INSERT IGNORE INTO pack_album (`pack_id`,`album_id`) VALUES ('".$packId."','".$vR."')";
					$res = $this->oMysqli->query($this->sSql);
				}
			}			
		}
	}
	
	/*********************************************
	* Get map album with pack 
	* @Param: array()
	**********************************************/
	public function getPackAlbumMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM pack_album WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}

	public function __toString(){
        return $this->sSql;
    }
}