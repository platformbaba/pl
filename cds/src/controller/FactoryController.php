<?php

class FactoryController{

	// register your controller here 
	// every controller should implement controller interface.
	
	public static function getController($action){
		$retVar = null;
		if($action=="search"){
			$retVar =  new SearchController();
		}else{
			$retVar = new DbController();
		}
		return $retVar;
	}
	
	
}
?>