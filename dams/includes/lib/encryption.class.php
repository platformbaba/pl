<?php
final class Encryption {
	private static $key = 'cms@SaReGaMa.Com';

	static function enc($value) {
		if (!self::$key) { 
			return $value;
		}
		$output = '';
		
		for ($i = 0; $i < strlen($value); $i++) {
			$char = substr($value, $i, 1);
			$keychar = substr(self::$key, ($i % strlen(self::$key)) - 1, 1);
			$char = chr(ord($char) + ord($keychar));
			
			$output .= $char;
		} 
		
        return self::base64_safeencode($output); 
	}
	
	static function dec($value) {
		if (!self::$key) { 
			return $value;
		}
		
		$output = '';
		
		$value = self::base64_safedecode($value);
		
		for ($i = 0; $i < strlen($value); $i++) {
			$char = substr($value, $i, 1);
			$keychar = substr(self::$key, ($i % strlen(self::$key)) - 1, 1);
			$char = chr(ord($char) - ord($keychar));
			
			$output .= $char;
		}
		
		return $output;
	}
    private static function base64_safeencode($string){
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
    private static function base64_safedecode($string){
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}
?>