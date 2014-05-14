<?php
//Singleton pattern
require __DIR__.'/predis/autoload.php';	
class Cache{
	protected $redisServer;
	private function __construct(){
		global $redisServer;
		$this->redis = new Predis\Client($redisServer);
	}

	private function __clone(){
    }
	
	public static function getInstance(){
		static $inst = null;
		if ($inst === null) {
			$inst = new Cache();
		}
		return $inst;
	}
	
	public function cachePut($key,$value,$time){
		try {
			$this->redis->set($key, $value);	
			$this->redis->expire($key, $time);
			return 1;
		}catch (Exception $e) {
			return 0;
		}
	}
	
	public function cacheGet($key){
		try {
			$value = $this->redis->get($key);
			return $value;
		}catch (Exception $e) {
			return 0;
		}
	}
	
	public function getCacheKey($request){
		return $request;
	}

}
?>