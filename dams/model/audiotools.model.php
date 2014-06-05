<?php  
/** 
 * The Audio Encode Tools Model
 */
class audiotools   
{
	public $data;
	protected $oMysqli;
	public function __construct(){
		global $oMysqli;
		$this->oMysqli=$oMysqli;
	} 

	
	
	public function getSongDetails($id){
		$sWhere="";
		if($id>0){
			$sWhere="id=".$this->oMysqli->secure($id);
		}else{
			return null;
		}
		$sSql="SELECT name, path FROM song_mstr_temp WHERE ".$sWhere." LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	
	public function getDistinctPlatforms(){
		$sSql="SELECT distinct(platform) FROM song_edit_config";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	
	public function getConfigsForPlatform($platform){
		if(isset($platform)){
			$sSql="SELECT song_edit_id,platform,format,audio_bitrate,sample_rate,duration_limit FROM song_edit_config WHERE platform='".$this->oMysqli->secure($platform)."'";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	
	}
/* Geting here all edited song value from three table*/	

	public function getEditedSongs($id,array $a=array()){
	
		$limit = MAX_DISPLAY_COUNT; $start =0; //$orderby = ' ORDER BY platForm ASC ';// $where ='';
		
		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderby = $a['orderby'];
		}
		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}

		
		 $sSql = "SELECT rel.id , rel.song_id AS songId ,rel.config_id AS configId ,rel.insert_date AS insertDate,rel.status AS Status_Rel,m.name AS song_name ,
						rel.edit_duration AS editDuration,rel.path AS path_Rel,conf.platform  AS platForm,conf.format AS forMate ,conf.audio_bitrate AS audioBitrate,conf.sample_rate AS sampleRate
				 FROM (song_mstr_temp m INNER JOIN song_mstr_config_rel rel ON (m.id=rel.song_id) ) 
				 INNER JOIN  song_edit_config conf ON (conf.song_edit_id = rel.config_id) WHERE m.id=".$this->oMysqli->secure($id)." ORDER BY platForm,insertDate DESC LIMIT $start, $limit";

		$data=$this->oMysqli->query($sSql);
		$aData = '';
		if( !empty($data) ){
			foreach($data as $k=>$val){
				 $aData[$val->songId][] = $val;
				
			}			
		}
		return $aData;
		
}


		
	public function addConfigSongsInfo(array $a=array()){
	
	foreach($a['config_ids'] as $config_id){
		$sSql="INSERT INTO song_mstr_config_rel(`song_id`,`config_id`,`path`,`edit_duration`,`status`,`insert_date`) VALUES('".$this->oMysqli->secure($a['song_id'])."','".$this->oMysqli->secure($config_id)."','".$this->oMysqli->secure($a['path'])."','".$this->oMysqli->secure($a['edit_duration'])."','0',now())";
			$data=$this->oMysqli->query($sSql);
		}
	
	
	}
	
	/*********************************************
* Will return total result count
* @param: array
********************************************/
	function getTotalCountEditedSong($id){
		$sSql = "SELECT COUNT(rel.song_id) AS cnt FROM (song_mstr_temp m INNER JOIN song_mstr_config_rel rel ON (m.id=rel.song_id) ) 
				 INNER JOIN  song_edit_config conf ON (conf.song_edit_id = rel.config_id) WHERE m.id=".$this->oMysqli->secure($id);
				//		 echo $sSql;
		$res = $this->oMysqli->query($sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}

}


?>