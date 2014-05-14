<?php

class event_db extends base_db{

	protected $_default_arr = array("event_name","event_id","language_id","event_type_id","artist_ids","playlist_ids","start_date","end_date");
	protected $_includes_arr = array();
	protected $_criteria_arr = array("language_id","event_type_id","start_date","end_date");
	
	public function __construct($oMysqli){
		parent::__construct($oMysqli);
	}
	
	public function getdetails(){
	
		$event_id	 = $this->messenger["query"]["id"];
		if(is_numeric($event_id)){
			$this->sSql = 'SELECT em.event_id,em.event_name,em.language_id,lm.language_name,em.start_date,em.end_date,em.event_desc,
							event_type
							FROM event_mstr em
							LEFT JOIN language_mstr lm ON (em.language_id=lm.language_id)
							WHERE em.status=0 AND em.event_id='.$event_id; // status will change to 1
			//$this->apply_includes();
			$res = $this->oMysqli->query($this->sSql);
		
			if(sizeof($res)==1){
				$resValue = $res[0];
				$event =  new event_db_dto();
				$event->setevent_id($resValue->event_id);
				$event->setevent_name($resValue->event_name);
				$event->setevent_language_id($resValue->language_id);
				$event->setevent_language_name($resValue->language_name);
				$event->setevent_start_date($resValue->start_date);
				$event->setevent_end_date($resValue->end_date);
				$event->setevent_desc($resValue->event_desc);
				if(key_exists($resValue->event_type,$this->aConfig['calendar_event']))
					$event->setevent_type_id($this->aConfig['calendar_event'][$resValue->event_type]);
				$event->setevent_playlist_ids($this->oCommon->getPlaylistForEvent($resValue->event_id));
				$event->setevent_artist_ids($this->oCommon->getArtistForEvent($resValue->event_id));
				
				
				$container =  new container_db_dto();
				
				$container->setdata($event);
				return $container->to_array();

			}else{
				throw new Exception("Invalid Event Id");
			}
			
		}else{
			throw new Exception("Invalid Event Id");
		}	
		
	}
	
	public function get_event_by_name(){
		
		
	}
	
	
	public function get_all_event(){
		
		$container = new container_db_dto();
		$data = array();
		$limit   = (int)$this->messenger["query"]["limit"];
		$start   = (int)$this->messenger["query"]["start"];
		$orderBy = "";
		if(	$this->messenger['query']['sf'] != '' ){
			$orderBy = " ORDER BY em.".$this->messenger['query']['sf']." ".$this->messenger['query']['so'];
		}
		$where   = ' WHERE em.status = 0 '; // This will change 0 to 1
		$this->apply_where_criteria($where);
		
		$this->sSql = "SELECT COUNT(em.event_id) AS cnt FROM `event_mstr` em ".$where;
		$res = $this->oMysqli->query($this->sSql);
		$total = 0;
		if(sizeof($res)>0){
			$container->settotal_count($res[0]->cnt);
			$this->sSql = 'SELECT em.event_id,em.event_name,em.language_id,lm.language_name,em.start_date,em.end_date,em.event_desc,
							em.event_type
							FROM event_mstr em
							LEFT JOIN language_mstr lm ON (em.language_id=lm.language_id)
							'.$where .' '.$orderBy .'LIMIT '. $start.','.$limit;
			$res = $this->oMysqli->query($this->sSql);
			
			
			if(sizeof($res)>0){				
				foreach ($res as $resValue){	
					$event = new event_db_dto();
					$event->setevent_id($resValue->event_id);
					$event->setevent_name($resValue->event_name);
					$event->setevent_language_id($resValue->language_id);
					$event->setevent_language_name($resValue->language_name);
					$event->setevent_start_date($resValue->start_date);
					$event->setevent_end_date($resValue->end_date);
					$event->setevent_desc(strip_tags($resValue->event_desc));
					if(key_exists($resValue->event_type,$this->aConfig['calendar_event']))
						$event->setevent_type_id($this->aConfig['calendar_event'][$resValue->event_type]);
					$event->setevent_playlist_ids($this->oCommon->getPlaylistForEvent($resValue->event_id));
					$event->setevent_artist_ids($this->oCommon->getArtistForEvent($resValue->event_id));
					$data[] = $event;
				}	
			}
			
		}else{
				throw new Exception("Invalid Event Id");
		}
		$container->setdata($data);
		return $container->to_array();
		
	
	}
		
	private function apply_where_criteria(&$where){
	
		if(isset($this->req_criteria_arr["language_id"]) && is_numeric($this->req_criteria_arr["language_id"])){
			$where = $where." AND em.language_id='".$this->req_criteria_arr["language_id"]."'";
		}elseif(isset($this->req_criteria_arr["language_id"])){
			throw new Exception("Invalid language Id");
		}
		
		if(isset($this->req_criteria_arr["event_type_id"]) && is_numeric($this->req_criteria_arr["event_type_id"])){
			$where = $where." AND em.event_type='".$this->req_criteria_arr["event_type_id"]."'";
		}elseif(isset($this->req_criteria_arr["event_type_id"])){
			throw new Exception("Invalid event type Id");
		}
		
		if(isset($this->req_criteria_arr["start_date-->"])){
			$where = $where." AND em.start_date >= '".$this->req_criteria_arr["start_date-->"]."'";
		}
		
		if(isset($this->req_criteria_arr["end_date--<"])){
			$where = $where." AND em.end_date <= '".$this->req_criteria_arr["end_date--<"]."'";
		}
		
	}
	
	private function apply_includes(){
	
	}

}
?>