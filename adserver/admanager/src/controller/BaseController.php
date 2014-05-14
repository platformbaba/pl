<?php


abstract class BaseController{
	
	protected $mysql;
	protected $advIds;
	
	function __construct(){
		global $mysql,$advIds;
		$this->mysql = &$mysql;
		$this->advIds = &$advIds;
	}
	
	abstract function execute();
}