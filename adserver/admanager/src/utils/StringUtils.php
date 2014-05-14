<?php


class StringUtils{

	private function __construct(){
		// cannot create object
	}
	
	public static function getFromRequest($str,$throwExceptionOnNotSet=false,$defaultValue=NULL){
		if(isset($_REQUEST[$str]) && is_array($_REQUEST[$str]))
			return $_REQUEST[$str];
		if(isset($_REQUEST[$str]) && !StringUtils::isEmpty($_REQUEST[$str])){
			return strtolower(trim($_REQUEST[$str]));
		}
		elseif($throwExceptionOnNotSet){
			throw new Exception("Value not set for : ".$str);
		}elseif($defaultValue!=NULL){
			
			return strtolower(trim($defaultValue));
		}
		return null;
	}
	
	public static function isEmpty($str){
		$str = trim($str);
		if($str == '' || $str === null){
			return true;
		}
		return false;
	}
		
	public static function isNumeric($str){
		$str = trim($str);
		if(!StringUtils::isEmpty($str) && is_numeric($str)){
			return true;
		}
		return false;
	}
	
	public static function contains($value,$in){
	
	}
	
	public static function sqlInjection($str){
		
		if(false){
			// found sql injection attack 
			throw new Exception("Sql injection detected");
		}
		return $str;
	}
	
	public static function stripSpecialChars($str){
		if(!StringUtils::isEmpty($str)){
			$str = htmlentities($str);
			$str = html_entity_decode($str);
		}
		return $str;
	}		
	
	public static function endsWith($haystack, $needle){
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}
	
	public static function getStatusValue($status){
		if($status=='on')
			return 1;
		return 0;
	}
	
	public static function getWeek($weekArray){
		if($weekArray && is_array($weekArray)){
			
		}
	}
}

?>