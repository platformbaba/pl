<?php 
/**
 * The Playlist Model does the back-end Work for the Playlist Controller
 */
class playlist
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all Playlist 
	*@Param: array()
	********************************************/
	public function getAllPlaylists( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY playlist_id DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		$where .= " AND status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT * FROM `playlist_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}

	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$where = " AND status!='-1' ";
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		$this->sSql = "SELECT count(1) as cnt FROM `playlist_mstr` WHERE 1 $where ";
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
		$this->sSql = "UPDATE `playlist_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND playlist_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		global $aConfig;
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
		$this->sSql = "UPDATE `playlist_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND playlist_id IN(".implode(',', $a['contentIds']).")
						$sQuery
						LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of Playlist
	* @param: string 
	**********************************************/
	public function checkPlaylistExist($playlistName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND playlist_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `playlist_mstr` WHERE playlist_name = '".$this->oMysqli->secure($playlistName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update Playlist
	* @param: array 
	**********************************************/
	public function savePlaylist( array $a = array() ){
		if($a){
			$playlistId=$a['playlistId'];
			$playlistName=$a['playlistName'];
			$userID=$a['userID'];
			$image=$a['image'];
			$ctype=$a['ctype'];
			$languageId=$a['languageId'];

			if((int)$playlistId>0){
				$this->sSql = "UPDATE `playlist_mstr` SET `playlist_name`='".$this->oMysqli->secure($playlistName)."',update_date=NOW(),user_id='".$userID."',`image`='".$image."',`language_id`='".$languageId."' WHERE playlist_id = ".(int)$playlistId." LIMIT 1";
			}else{
				 $this->sSql = "INSERT INTO `playlist_mstr` (`playlist_name`,`user_id`,`insert_date`, `update_date` ,`status`,`content_type`) VALUES ('".$this->oMysqli->secure($playlistName)."','".$userID."', NOW() ,NOW() ,1,'".$ctype."')";
			
			}
			$statusid = $this->oMysqli->query( $this->sSql );
			return $statusid;
		}
	}
	/*********************************************
	* Will map Song with Playlist 
	* @Param: array()
	**********************************************/
	public function mapSongPlaylist( array $a = array() ){
		if($a){
			$playlistId=(int)$a['playlistId'];
			$songKeyArray=$a['songKeyArray'];
			$ctype=$a['ctype'];
			$manage=$a['manage'];
			if($songKeyArray){
				if($ctype==15){//FOR VIDEO PLAYLIST
					if($manage==1){
						$this->sSql = "DELETE FROM playlist_video WHERE playlist_id = '".$playlistId."'";
						$res = $this->oMysqli->query($this->sSql);
					}
					$i=1;
					foreach($songKeyArray as $kAR=>$vAR){
						if($vAR){ 
							$this->sSql = "INSERT IGNORE INTO playlist_video (`video_id`,`playlist_id`,`rank`) VALUES (".$vAR.",'".$playlistId."','".$i."')";
							$res = $this->oMysqli->query($this->sSql);
							$i++;
						}
					}
				}elseif($ctype==17){//FOR IMAGES PLAYLIST
					if($manage==1){
						$this->sSql = "DELETE FROM playlist_image WHERE playlist_id = '".$playlistId."'";
						$res = $this->oMysqli->query($this->sSql);
					}
					$i=1;
					foreach($songKeyArray as $kAR=>$vAR){
						if($vAR){ 
							$this->sSql = "INSERT IGNORE INTO playlist_image (`image_id`,`playlist_id`,`rank`) VALUES (".$vAR.",'".$playlistId."','".$i."')";
							$res = $this->oMysqli->query($this->sSql);
							$i++;
						}
					}
				}else{//FOR SONG PLAYLIST
					if($manage==1){
						$this->sSql = "DELETE FROM playlist_song WHERE playlist_id = '".$playlistId."'";
						$res = $this->oMysqli->query($this->sSql);
					}
					$i=1;
					foreach($songKeyArray as $kAR=>$vAR){
						if($vAR){ 
							$this->sSql = "INSERT IGNORE INTO playlist_song (`song_id`,`playlist_id`,`rank`) VALUES (".$vAR.",'".$playlistId."','".$i."')";
							$res = $this->oMysqli->query($this->sSql);
							$i++;
						}
					}
				}	
			}
		}
	}
	/*********************************************
	* Get Songs 
	* @Param: array()
	**********************************************/
	public function getSongPlaylistMap( array $a = array() ){
		if($a){
			$orderBy = ' ORDER BY rank ASC ';
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
			if($a['orderBy']){
				$orderBy=$a['orderBy'];
			}
			$ctype=$a['ctype'];
			if($ctype==15){
				$table="playlist_video";
			}elseif($ctype==17){
				$table="playlist_image";
			}else{
				$table="playlist_song";
			}	
			
				$this->sSql = "SELECT * FROM ".$table." WHERE 1 $where $orderBy";
				return $res = $this->oMysqli->query($this->sSql);
			}
	}
	public function __toString(){
        return $this->sSql;
    }
}