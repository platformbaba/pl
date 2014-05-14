<?php 
date_default_timezone_set('Asia/Calcutta');
class logger{
	
	
	private static $log_base_dir =LOGGING_PATH;
	private static $log_types = array("analytics","error","unsuccesful");
	
	
	public static function writelogs($log_type="analytics",$data){
		global $messenger;
		$app_id = $messenger["app_id"];
		if(strlen($app_id)>0){
			$app_id = $messenger["app_id"];
		}
		if($data && in_array($log_type,self::$log_types)){
			
			$log_file_name = self::$log_base_dir.'/'.date("Y-m-d").'_.'.$log_type.'.log';
			$handle = fopen($log_file_name,"a+");
			fwrite($handle,date("Y-m-d H:i:s").' | ' .$app_id.' | '.$data.PHP_EOL);		
			fclose($handle);
		}
	}
	
}

?>