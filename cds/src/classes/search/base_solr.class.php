<?php

abstract class base_solr{
	
	protected $messenger;
	protected $solrIp;
	protected $solrPort;
	protected $aConfig;
	
	
	public function __construct(){
	
		global $messenger,$solrIp,$solrPort,$aConfig;
		$this->messenger = &$messenger;
		$this->solrIp = $solrIp;
		$this->solrPort = $solrPort;
		$this->aConfig=$aConfig;
	}
	
	protected abstract function getsearch();
	
	
	protected function autosuggest(){
		///// check if should be in base class;	
	}
	
}