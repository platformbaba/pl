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
	private $variable = 'object';
    public function __construct($db) {

		if($db == 'cmsdb'){		// READ USER
			$this->host = DBMASTERIP;
			$this->user = DBMASTERUSERNAME;
			$this->pass = DBMASTERPASSWORD; 
			$this->db = DBMASTERDATABSE;
            $this->port = DBMASTERPORT;
		} else{  //WRITE USER
			$this->host = "localhost";
			$this->user = "root";
			$this->pass = ""; 
			$this->db = "saregama_db";
            $this->port = "3306";
		}			

	    parent::__construct($this->host, $this->user, $this->pass, $this->db, $this->port);
		$conn=$this;
        if(mysqli_connect_error()) {
          //  echo '<br>Connect Error ' . mysqli_connect_errno() . ' -> '. mysqli_connect_error();
			throw new Exception("Connection error");
        } 

		if(DB_DEBUG)
			$this->debugi("CONNECTED",$this->host,$conn);
			
	}
	/**
	 * close the connection to the database
	**/
	public function __destruct(){
		@$close = @parent::close();
		if(DB_DEBUG)
			$this->debugi("DESCONNECTED",$this->host,$close);
	}
	public function debugi($name,$debug=NULL,$test=NULL) {
		if(strtolower($this->char) == "utf8")
			$debug = utf8_encode($debug);
		echo "<pre>".$name.": <font color='".($test?"blue":"red")."'>".$debug."</font>";
		if(!$test)
			echo "<br>ERROR: <font color='red'>(".@parent::errno().") ".@parent::error()."</font>";
		echo "</pre>";
	}
	public function secure($value) {
		return mysqli_real_escape_string($this,$this->replace($value));
	}
	/**
	 * replace strings used in sql injection
	 *
	 * @param string $value
	 * @param bool $restore
	 * @return string
	 */
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
	/**
	 * replace strings used to break lines
	 *
	 * @param string $value
	 * @return string
	 */
	private function line_break($value) {
		$value = str_ireplace("\\n","\n",$value);
		$value = str_ireplace("\\r","\r",$value);
		$value = str_ireplace("\\","",$value);
		$value = str_ireplace("\\","",$value);
		return $value;
	}
	/**
	 * execute the query
	 * if is select query return the result lines
	 * if is insert query return the inserted id
	 *
	 * @param string $sql
	 * @return string|object
	 */
	public function query($sql, $charset='') {
		/* $this->counter++;
		echo $this->counter."-- Counter<br>";
		echo $sql.'<br>';
		 */if(strtolower($this->char) == "utf8")
			//$sql = utf8_decode($sql);
		if( $charset != ''){	@parent::set_charset( $charset );	}	
		$time =  microtime(true);
		@$query = @parent::query($sql);
		//echo microtime(true)-$time;
	//	echo '<br><br><br><br><br><br><br>';
		if(DB_DEBUG)
			$this->debugi("SQL",$sql,$query);
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