<?php
abstract class BaseModel{
	
	protected $messenger;
	protected $mysql;
	
	function __construct(){
		global $messenger,$mysql;
		$this->messenger =  $messenger;
		$this->mysql = $mysql;
	}
	
}