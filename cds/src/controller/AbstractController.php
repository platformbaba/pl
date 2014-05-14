<?php
abstract class AbstractController{

	public function init(){
		// can do initallizations here;
	}
	
	public abstract function execute();
	
	
	public function cleanup(){
		if(class_exists("Cache", false)){
			global $messenger;
			if($messenger['response']['status']==1){
				$cache = Cache::getInstance();
				$cache->cachePut($messenger["getKey"](),json_encode($messenger['response']['resp']),300);
			}
		}
	
	}

}

?>