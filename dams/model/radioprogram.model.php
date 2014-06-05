<?php
/* Radioprogram management */
class radioprogram
{
 	protected $sSql;
	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }



// Insert a new Radioprogram New
	public function addRadioPrograms(array $a=array()) {
		if($a){		
			$programId = $a['program_id'];
			$channelId = $a['channelId'];
			$radioProgram = $a['radioProgram'];
			$startDate = $a['startDate'];
			$endDate = $a['endDate'];
			$startTime = $a['startTime'];
			$endTime = $a['endTime'];
			$duration = $a['duration'];
	
	if($programId){
			
			$this->sSql = "UPDATE `channel_programs` SET `channel_id`=".$channelId.",`program_name`='".$this->oMysqli->secure($radioProgram)."',`start_date`='".$startDate."',`start_time`='".$startTime."',`end_date`='".$endDate."',`end_time`='".$endTime."',`duration`=".$this->oMysqli->secure($duration).",`update_date`=NOW() WHERE `program_id`=".$programId." LIMIT 1";
		
			}else{	
			
				$this->sSql = "INSERT INTO `channel_programs`(`channel_id`,`program_name`,`start_date`,`start_time`,`end_date`,`end_time`,`insert_date`,`status`,`duration`)
				VALUES(".$this->oMysqli->secure($channelId).",'".$this->oMysqli->secure($radioProgram)."','".$this->oMysqli->secure($startDate)."',
						'".$this->oMysqli->secure($startTime)."','".$this->oMysqli->secure($endDate)."','".$this->oMysqli->secure($endTime)."',NOW(),'0',".$this->oMysqli->secure($duration).")";
				
			}
			#echo $this->sSql ;
			#exit;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
	}
	}	
####



#########################
####
public function nextChannelProgramId() {
		
		$this->sSql = "SHOW TABLE STATUS LIKE 'channel_programs'";
		$res = $this->oMysqli->query($this->sSql);
		$nextId= $res[0]->Auto_increment;

	return $nextId;

}	


#########################	
	
	// Insert a new Radio program POPUP
	public function addChannelProgram(array $a=array()) {
		if($a){
		
			$id = $a['id'];
			$channelId = $a['channelId'];
			$startDate = $a['startDate'];
			$startTime = $a['startTime'];
			$endDate = $a['endDate'];
			$endTime = $a['endTime'];
			
		if($id>0){
			
				$this->sSql = "UPDATE `channel_programs` SET `channel_id`=".$channelId.",`start_date`='".$startDate."',`start_time`='".$startTime."',
				`end_date`='".$endDate."',`end_time`='".$endTime."',`duration`,`update_date`=NOW() WHERE `program_id`=".$id." LIMIT 1";
			
			}else{	
				$this->sSql = "INSERT INTO `channel_programs`(`channel_id`,`program_name`,`start_date`,`start_time`,`end_date`,`end_time`,`insert_date`,`status`,`duration`)
				VALUES(".$this->oMysqli->secure($channelId).",".$this->oMysqli->secure($channelProgramId).",'".$this->oMysqli->secure($startDate)."',
						'".$this->oMysqli->secure($startTime)."','".$this->oMysqli->secure($endDate)."','".$this->oMysqli->secure($endTime)."',NOW(),'0')";
				
			}
			
					
			//echo $this->sSql;
			//exit;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	
	
		// Insert a new Radio program Song POPUP
		
		
	public function addProgramSongBulk(array $a=array()) {
		if($a){
					
			$id = $a['id'];
			$programId = $a['programId'];
			$songId = $a['songId'];
			$songTag = $a['songTag'];
			$isrc = $a['isrc'];	
			$rank = $a['songRank'];				
			
			$type = ($songTag=='') ? "R" : "S";
			$file = ($songTag=='') ? $songId.".mp3" : $isrc.".mp3";
			$isrc = ($songTag=='') ? $songId : $isrc;

if($songId>0){			
		if($id>0){
			
				$this->sSql = "UPDATE `program_song` SET `program_id`=".$programId.",`isrc`='".$isrc."',`file`='".$file."',
				`type`='".$type."',`update_date`=NOW() WHERE `id`=".$id." LIMIT 1";
			
			}else{	
				$this->sSql = "INSERT INTO `program_song`(`program_id`,`isrc`,`file`,`type`,`rank`,`insert_date`)
				VALUES(".$this->oMysqli->secure($programId).",'".$this->oMysqli->secure($isrc)."','".$this->oMysqli->secure($file)."',
						'".$this->oMysqli->secure($type)."','".$this->oMysqli->secure($rank)."',NOW())";
				
			}
}			
					
			//echo $this->sSql;
			//exit;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	
	
	public function addProgramSong(array $a=array()) {
		if($a){
					
			$id = $a['id'];
			$programId = $a['programId'];			
			$isrc = $a['isrc'];
			$file = $a['file'];
			$type = $a['type'];
			
			
		if($id>0){
			
				$this->sSql = "UPDATE `program_song` SET `program_id`=".$programId.",`isrc`='".$isrc."',`file`='".$file."',
				`type`='".$type."',`update_date`=NOW() WHERE `id`=".$id." LIMIT 1";
			
			}else{	
				$this->sSql = "INSERT INTO `program_song`(`program_id`,`isrc`,`file`,`type`,`insert_date`)
				VALUES(".$this->oMysqli->secure($programId).",'".$this->oMysqli->secure($isrc)."','".$this->oMysqli->secure($file)."',
						'".$this->oMysqli->secure($type)."',NOW())";
				
			}
			
					
		//	echo $this->sSql;
			//exit;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	

	
	public function checkRadioProgramExist($radioProgram){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND program_id!=".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM channel_programs WHERE program_name = '".$this->oMysqli->secure($radioProgram)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	
	public function getAllRadioProgram(array $a=array()){
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
		 $this->sSql = "SELECT * FROM `channel_programs` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	

###############
	
	public function getAllChannels(array $a=array()){
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
	 	 $this->sSql = "SELECT * FROM `radio_stations` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}	
	
	public function getAllProgramSongs(array $a=array()){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY id ASC '; $where ='';
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
		$this->sSql = "SELECT * FROM `program_song` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($this->sSql);
		return $data;
	}
	
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY insert_date DESC '; $where ='';

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderby = $a['orderby'];
		}
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
		
		$this->sSql = "SELECT count(1) as cnt FROM `channel_programs` WHERE status!='-1' $where";
		$res = $this->oMysqli->query($this->sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}	
	
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		global $aConfig;
		$limit = count($a['contentIds']);
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
		$this->sSql = "UPDATE `channel_programs` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND program_id IN(".implode(',', $a['contentIds']).") 
						$sQuery  
						LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}


	public function deletePrograomFromChannel(array $a = array()){
	
	$this->sSql = "UPDATE `channel_programs` SET `status`='-1' WHERE status!='-1' AND program_id='".(int)$a['eid']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}
	public function deleteSongFromProgram(array $a = array()){
	
	$this->sSql = "UPDATE `program_song` SET `status`='-1' WHERE status!='-1' AND id='".(int)$a['eid']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}
	
	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		$this->sSql = "UPDATE `channel_programs` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND program_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

###

	public function getRadioProgramById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND program_id IN(".$a['ids'].")";
			}	
			$this->sSql="SELECT * FROM `channel_programs` WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	
##Get Channel Program By Id.
	public function getChannelProgramById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND program_id IN(".$a['ids'].")";
			}	
			$this->sSql="SELECT * FROM `channel_programs` WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	
##Get Channel Program By Id.
	public function getProgramSongById(array $a=array()){
		$where="";
		if($a){
			if($a['ids']){
				$where=" AND id IN(".$a['ids'].")";
			}	
			$this->sSql="SELECT * FROM `program_song` WHERE 1 AND status!='-1' ".$where;
			$data=$this->oMysqli->query($this->sSql);
			return $data;
		}
	}	

	
	public function __toString(){
        return $this->sSql;
    }


}
?>