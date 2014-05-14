<?php
/********************************************/
#		**MYSQL CONNECTION**				#
#		####################				#											
#											#
/********************************************/

class mysqliDb extends mysqli {
	private $counter = 0;
	private $db,$host,$user,$pass,$conn;
	private $char = 'utf8';
	private $variable = 'array';
    public function __construct() {

		$this->host = DBMASTERIP;
		$this->user = DBMASTERUSERNAME;
		$this->pass = DBMASTERPASSWORD; 
		$this->db = DBMASTERDATABSE;
        $this->port = DBMASTERPORT;
	    parent::__construct($this->host, $this->user, $this->pass, $this->db, $this->port);
		$conn=$this;
        if(mysqli_connect_error()) {
          //  echo '<br>Connect Error ' . mysqli_connect_errno() . ' -> '. mysqli_connect_error();
			throw new Exception("Connection error");
        } 

		
			
	}
	/**
	 * close the connection to the database
	**/
	public function __destruct(){
		@$close = @parent::close();
	}

	private function replace($value,$restore = false) {
		$injection = array("select","insert","delete","table","update","trucate","drop","applet","object","--");
		if($restore == false)
		foreach((array)$injection as $find)
			$value = str_ireplace($find." ","{{".$find."}}",$value);
		else
		foreach((array)$injection as $find)
			$value = str_ireplace("{{".$find."}}",$find." ",$value);
		$value = $this->line_break($value);
		return $value;
	}
	
	private function line_break($value) {
		$value = str_ireplace("\\n","\n",$value);
		$value = str_ireplace("\\r","\r",$value);
		$value = str_ireplace("\\","",$value);
		$value = str_ireplace("\\","",$value);
		return $value;
	}
	
	public function query($sql, $charset='') {
		if( $charset != ''){
			@parent::set_charset( $charset );	
		}	
		@$query = @parent::query($sql);
		if((strtolower(substr(trim($sql),0,6)) == "select") && ($query != false)) {
			$return = NULL;
			while($line = $query->fetch_object()) {
				$new_line = ($this->variable == 'object') ? (object)NULL : (array)NULL;
				foreach((array)$line as $key => $value) {
					//$value = $this->replace(((strtolower($this->char) == "utf8") ? utf8_encode($value) : $value),true);
					$value = $this->replace($value,true);
					if($this->variable == 'object')
						$new_line->$key = $value;
					else
						$new_line["$key"] = $value;
				}
				$return[] = $new_line;
			}
		}elseif(strtolower(substr($sql,0,6)) == "insert")
			$return = $this->insert_id;
		else
			$return = $this->affected_rows;
		return  $return;
	}	
}
?>