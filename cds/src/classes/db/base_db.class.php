<?php

abstract class base_db{
	
	//protected $aconfig = array();
	protected $messenger;
	protected $oMysqli;
	protected $sSql;
	protected $aConfig;
	protected $req_includes_arr = array();
	protected $req_criteria_arr = array();

	
	public function __construct($oMysqli){
		global $messenger,$aConfig;
		$this->messenger=&$messenger;
		$this->oMysqli=$oMysqli;
		$oCommon=common_db::getCommonInstance($oMysqli);
		$this->oCommon=$oCommon;
		$this->aConfig=$aConfig;
		
		$includes   = $this->messenger["query"]["includes"];
		$criteria 	= $this->messenger["query"]["criteria"];
		if($includes){
			$this->req_includes_arr = explode(",",$includes);
		}
		if($criteria){
			$cri = explode(",",$criteria);
			foreach($cri as $cri_str){
				if (strpos($cri_str, ':') !== false){
					$_k = explode(":",$cri_str);
					$this->req_criteria_arr[$_k[0]] = $_k[1];
				}
				if(strpos($cri_str, '<') !== false){
					$_k = explode("<",$cri_str);
					$this->req_criteria_arr[$_k[0]."--<"] = $_k[1];
				}
				if(strpos($cri_str, '>') !== false){
					$_k = explode(">",$cri_str);
					$this->req_criteria_arr[$_k[0]."-->"] = $_k[1];
				}	
			}
		}

	}
	


	protected abstract function getdetails();
	//public abstract function getdetails();
	
	// when are we setting this ?
	public function __toString(){
		return $this->sSql;
	}
	
}


?>