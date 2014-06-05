<?php
/* artist management */
class artist
{
 	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }
	// insert a new artist
	public function addArtist(array $a=array()) {
		if($a){
			$artist_name=$a['artistName'];
			$status=$a['status'];
			$image=$a['image'];
			$content = $a['content'];
			$gender = $a['gender'];
			$dob = $a['dob'];
			$dod = $a['dod'];
			$sRole = $a['sRole'];
			$alias = $a['alias'];
			
			$sSql = "INSERT INTO artist_mstr (artist_name,artist_role,artist_image,artist_biography,artist_dob,artist_dod,artist_gender,insert_date,status,alias) VALUES ('".$this->oMysqli->secure($artist_name)."',".$this->oMysqli->secure($sRole).",'".$this->oMysqli->secure($image)."','".$this->oMysqli->secure($content)."','".$this->oMysqli->secure($dob)."','".$this->oMysqli->secure($dod)."','".$this->oMysqli->secure($gender)."',now(),'".$status."','".$alias."')";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function checkArtistExist(array $a=array()){
		$sWhere="";
		$artist=$a['aName'];
		$dob=$a['dob'];
		if($dob!="" && $dob!="0000-00-00"){
			$sWhere .= " AND artist_dob='".$dob."'";
		}
		if((int)$_GET['id']>0){
			$sWhere .=" AND id!=".(int)$_GET['id'];
		}
		$sSql="SELECT count(1) as cnt FROM artist_mstr WHERE artist_name = '".$this->oMysqli->secure($artist)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	// edit a artist
	public function editArtist(array $a=array()) {
		if($a){
			$artist_name=$a['artistName'];
			$status=$a['status'];
			$artistId=$a['id'];
			$image=$a['image'];
			$content = $a['content'];
			$gender = $a['gender'];
			$dob = $a['dob'];
			$dod = $a['dod'];
			$sRole = $a['sRole'];
			$alias = $a['alias'];

			$sSql = "UPDATE artist_mstr SET artist_name='".$this->oMysqli->secure($artist_name)."',artist_role=".$sRole.",artist_image='".$image."',artist_biography='".$this->oMysqli->secure($content)."',artist_dob='".$dob."',artist_dod='".$dod."',artist_gender='".$gender."',alias='".$alias."' WHERE artist_id='".$artistId."' LIMIT 1";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getArtistById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND artist_id IN(".$a['ids'].")";
			}	
			$sSql="SELECT artist_id,artist_name,artist_role,artist_image,artist_biography,artist_dob,artist_dod,artist_gender,insert_date,status,alias FROM artist_mstr WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getAllArtists(array $a=array()){
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
		$sSql = "SELECT artist_id,artist_name,artist_role,artist_image,artist_biography,artist_dob,artist_dod,artist_gender,insert_date,status,alias FROM `artist_mstr` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($sSql);
		return $data;
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
		$sSql = "SELECT count(1) as cnt FROM `artist_mstr` WHERE status!='-1' $where ";
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
		$sSql = "UPDATE `artist_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND artist_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$sSql = "UPDATE `artist_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND artist_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($sSql);
	}
	/*
		Get All Artist Type
	*/
	public function getArtistType(array $a = array()){
		global $aConfig;
		return $aConfig['artist_type'];
	}
	/*
		Get All Artist Type by value
	*/
	public function getArtistTypeByValue($val){
		global $aConfig;
		$artistTypeArr=$aConfig['artist_type'];
		$roleArr=array();
		foreach($artistTypeArr as $kAT => $vAT){
			if(($val&$vAT)==$vAT){
				$roleArr[]=$kAT;
			}		
		}
		return $roleArr;
	}
	/*********************************************
	* Map artist to avoid duplications 
	* @Param: array()
	**********************************************/
	public function mapArtistToOriginal( array $a = array() ){
		if($a){
			if($a['mArtistId'] && $a['artistId']){
					foreach($a['mArtistId'] as $mK=>$mV){
						if($mV>0){			
							$sSql = "SELECT song_id FROM artist_song WHERE artist_id='".(int)$mV."'";
							$res = $this->oMysqli->query($sSql);
							if( $res ){
								foreach( $res as $data ){
									$sSql = "DELETE FROM artist_song WHERE artist_id='".(int)$a['artistId']."' AND song_id='".$data->song_id."' LIMIT 1";
									$resd = $this->oMysqli->query($sSql);
								}
								
								$sSql = "UPDATE artist_song SET artist_id='".(int)$a['artistId']."' WHERE artist_id='".(int)$mV."'";
								$res = $this->oMysqli->query($sSql);
							}
							
							$sSql = "SELECT album_id FROM artist_album WHERE artist_id='".(int)$mV."'";
							$res = $this->oMysqli->query($sSql);
							if( $res ){
								foreach( $res as $data ){
									$sSql = "DELETE FROM artist_album WHERE artist_id='".(int)$a['artistId']."' AND album_id='".$data->album_id."' LIMIT 1";
									$resd = $this->oMysqli->query($sSql);
								}
							
								$sSql = "UPDATE artist_album SET artist_id='".(int)$a['artistId']."' WHERE artist_id='".(int)$mV."'";
								$res = $this->oMysqli->query($sSql);
							}
										
							$sSql ="DELETE FROM artist_mstr WHERE artist_id=".$mV." LIMIT 1";
							$res = $this->oMysqli->query($sSql);
						}
					}
			}
			return $res;
		}
	}
	/*********************************************
	* update alias of artist
	* @Param: int()
	**********************************************/
	public function updateAlias( array $a = array() ){
		if($a){
			if($a['alias'] && $a['artistId']){
				$sSql = "UPDATE artist_mstr SET alias=CONCAT( alias, IF(alias!='',', ',''), '".$a['alias']."') WHERE artist_id='".(int)$a['artistId']."' LIMIT 1";
				$res = $this->oMysqli->query($sSql);
			}
			return $res;
		}
	}
}
?>