<?php


class string_utils{

	private function __construct(){
		// cannot create object
	}
	
	public static function getFromRequest($str,$throwExceptionOnNotSet=false,$defaultValue=NULL){
		
		if(isset($_REQUEST[$str]) && !string_utils::isEmpty($_REQUEST[$str]))
			return strtolower(trim($_REQUEST[$str]));
		elseif($throwExceptionOnNotSet){
			throw new Exception("Value not set for : ".$str);
		}elseif($defaultValue!=NULL){
			
			return strtolower(trim($defaultValue));
		}
		return '';
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
		if(!string_utils::isEmpty($str) && is_numeric($str)){
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
		if(!string_utils::isEmpty($str)){
			$str = htmlentities($str);
			$str = html_entity_decode($str);
		}
		return $str;
	}		
	
	public static function endsWith($haystack, $needle){
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}
}

?>