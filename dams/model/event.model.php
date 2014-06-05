<?php

/**
 * The Event Model does the back-end Work for the Calendar Event Controller
 */
class event
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all event 
	*@Param: array()
	********************************************/
	public function getAllEvents( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY event_id DESC '; $where ='';

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
			$where .= " AND status!='-1'";
		
		$this->sSql = "SELECT * FROM `event_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql,'utf8');
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
		
		$this->sSql = "SELECT count(1) as cnt FROM `event_mstr` WHERE 1 $where ";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}



	
	/*********************************************
	* Will return array of events
	* @param: YYYY, MM
	********************************************/
	function getEventByCalender( $yyyy, $mm ){
		global $aConfig;
		$ret = null;
		if( $yyyy > 0 ){
			$oLanguage = new Language();
			$aLanguage = $oLanguage->getAllLanguages( array('limit'=>100) );
			$langArr = array();
			foreach( $aLanguage as $kkk=>$vvv ){
				$langArr[$vvv->language_id] = $vvv->language_name;
			}
						
			$where = ' AND SUBSTR( start_date, 1, 7 )="'.$yyyy.'-'.$mm.'" ';
			$res = $this->getAllEvents( array( 'where'=> $where, 'limit'=>1000, 'orderby'=>' ORDER BY event_name, language_id' ) );
			if( !empty($res) ){
				foreach( $res as $kk=>$vv ){
					$data = array();
					$data['event_name'] 	 = trim($vv->event_name);
					$data['event_type']		 = $vv->event_type;
					$data['dis_type']	     = $aConfig['calendar_event'][$vv->event_type];
					$data['event_id']      	 = $vv->event_id;
					$data['language_id']     = $vv->language_id;
					$data['language']      	 = $langArr[$vv->language_id];
					$data['start_date'] 	 = date('Y-n-j', strtotime($vv->start_date));
					$data['view_url'] 		 = SITEPATH.'event?action=view&id='.$vv->event_id.'&isPlane=1&do=details';
					
					$ret[$data['start_date']][] = $data;
				}
			}
		}
		return $ret;
	}

	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		if( $a['contentActionValue'] == '-1' ){
			
			/* Delete Mapped records */
			$this->oMysqli->query( "START TRANSACTION" );
			$this->sSql = "UPDATE `event_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND event_id='".(int)$a['contentId']."' LIMIT 1";
			if( $this->oMysqli->query( $this->sSql ) ){
				$this->oMysqli->query( "COMMIT" );
			}else{
				$this->oMysqli->query( "ROLLBACK" );
			}
		
		}else{
			
		$this->sSql = "UPDATE `event_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
		}
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		if( $a['contentActionValue'] == '-1' ){
			
			/* Delete Mapped records */
			$this->oMysqli->query( "START TRANSACTION" );
			$this->sSql = "UPDATE `event_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
			if( $this->oMysqli->query( $this->sSql ) ){
				$this->oMysqli->query( "COMMIT" );
			}else{
				$this->oMysqli->query( "ROLLBACK" );
			}
		
		}else{
			
			$this->sSql = "UPDATE `event_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND text_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
			$res = $this->oMysqli->query( $this->sSql );
		}
		
	}

		
	/**********************************************
	*Will insert/Update Text
	* @param: array 
	**********************************************/
	public function saveEvent( array $a = array() ){
		
		if((int)$_GET['id']>0){
			$this->sSql = "UPDATE `event_mstr` SET `event_name`='".$this->oMysqli->secure($a['eventName'])."', `event_desc`='".$this->oMysqli->secure($a['eventDesc'])."',`event_type`=".(int)$a['eventType'].", language_id=".(int)$a['languageIds'].",`start_date`='".$this->oMysqli->secure($a['srcSrtDate'])."',`end_date`='".$this->oMysqli->secure($a['srcEndDate'])."',`update_date`=NOW()  WHERE event_id = ".(int)$_GET['id']." LIMIT 1"; 
        }else{
			$this->sSql = "INSERT INTO `event_mstr` (`event_name`, `event_desc`, `event_type`,`language_id`,`start_date`,`end_date`,`insert_date`) VALUES ('".$this->oMysqli->secure($a['eventName'])."', '".$this->oMysqli->secure($a['eventDesc'])."', ".(int)$a['eventType'].", ".(int)$a['languageIds'].",'".$this->oMysqli->secure($a['srcSrtDate'])."','".$this->oMysqli->secure($a['srcEndDate'])."',NOW())";
				
		}
		$statusid = $this->oMysqli->query( $this->sSql,'utf8');
		return $statusid;
	
	}

	/*********************************************
	* Will map Artist with Event 
	* @Param: array()
	**********************************************/
	public function mapArtistEvent( array $a = array() ){
		if($a){
			$eventId=(int)$a['eventId'];
			$artistIdsArray=$a['artistIds'];
			if($eventId){
				$this->sSql = "DELETE FROM event_map WHERE event_id='".$eventId."' AND content_type=13";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			
			if($artistIdsArray){
				foreach($artistIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO event_map(`event_id`,`content_id`,`content_type`) VALUES ('".$eventId."',".$vT.",13)";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Will map Playlist with Event 
	* @Param: array()
	**********************************************/
	public function mapPlaylistEvent( array $a = array() ){
		if($a){
			$eventId=(int)$a['eventId'];
			$playlistIdsArray=$a['playlistIds'];
			if($eventId){
				$this->sSql = "DELETE FROM event_map WHERE event_id='".$eventId."' AND content_type=29";
				$resDel = $this->oMysqli->query($this->sSql);
			}
			
			if($playlistIdsArray){
				foreach($playlistIdsArray as $kT=>$vT){
					if($vT){ 
						$this->sSql = "INSERT INTO event_map(`event_id`,`content_id`,`content_type`) VALUES ('".$eventId."',".$vT.",29)";
						$res = $this->oMysqli->query($this->sSql);
					}
				}
			}
		}
	}
	/*********************************************
	* Will map Song/video/image with Event 
	* @Param: array()
	**********************************************/
	public function mapAllEvent( array $a = array() ){
		if($a){
			$eventId=(int)$a['eventId'];
			$allEventIdsArray=$a['dataIds']; //Song/video/image
			$relatedCType=$a['relatedCType']; //Song[4]/video[15]/image[17]
			
			if($allEventIdsArray){
				foreach($allEventIdsArray as $kT=>$vT){ 
					$this->sSql = "INSERT INTO event_map(`event_id`,`content_id`,`content_type`) VALUES ('".$eventId."',".$vT.",".$relatedCType.")";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
		}
	}
	/*********************************************
	* Will Remove Songs/Video/Image with Event 
	* @Param: array()
	**********************************************/
	public function removeAllEvent( array $a = array() ){
		if($a){
			$eventId=(int)$a['eventId'];
			$allEventIdsArray=$a['dataIds'];
			$relatedCType=$a['relatedCType']; //Song[4]/video[15]/image[17]
			if($allEventIdsArray){
			     $data_arr = array();
				foreach($allEventIdsArray as $kT=>$vT){ 
				  $data_arr[] =  $vT;
				}
				 $data_IDS = implode(",", $data_arr);
				 $this->sSql = "DELETE FROM event_map WHERE event_id='".$eventId."' AND content_type='".$relatedCType."' AND content_id IN($data_IDS)";
				 $res = $this->oMysqli->query($this->sSql);
	
			}
		}
	}

	/*********************************************
	* Update song/video rank of event 
	* @Param: array()
	**********************************************/
	public function mapAllEventRank( array $a = array() ){
		if( !empty($a) ){
		 $eventId=(int)$a['eventId'];
		 
			if($a['eventRank']){
				foreach($a['eventRank'] as $rK=>$rV){
					 $this->sSql = "UPDATE event_map SET rank='".(int)$rV."' WHERE content_id='".(int)$rK."' AND event_id='".(int)$eventId."' LIMIT 1";
					$res = $this->oMysqli->query($this->sSql);
				}
			}
			return $res;
		}
	}
		
	/*********************************************
	* Get All Events Related with EVENT 
	* @Param: array()
	**********************************************/
	public function getAllEventMap( array $a = array() ){
		if($a){
			$where="";
			if($a['where']){
				$where=$a['where'];
			}
				$this->sSql = "SELECT * FROM event_map WHERE 1 $where";
				return $res = $this->oMysqli->query($this->sSql);
		}
	}
	
	public function __toString(){
        return $this->sSql;
    }
}