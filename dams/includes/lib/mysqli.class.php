<?php
class mysqliDb extends mysqli {
    private $db,$host,$user,$pass,$conn;
	private $char = DB_CHAR;
	private $variable = DB_VARIABLE;
    public function __construct($db) {

		if( $_SERVER['SERVER_ADDR'] == '192.168.64.121'){
			// Development Environment
			
			if($db == 'cmsdb'){		// READ USER
				$this->host = "localhost"; //192.168.64.121
				$this->user = "saregama_read";
				$this->pass = "pass@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			
			}else if( $db == 'cmsdb_rw' ){  //WRITE USER
				$this->host = "192.168.64.121";
				$this->user = "amitk";
				$this->pass = "pass@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			
			}else if( $db == 'wapdb' ){  //WAP db to deploy to wap
				$this->host = "192.168.64.121";
				$this->user = "amitk";
				$this->pass = "pass@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			}else{
				$this->host = "localhost"; ////192.168.64.121
				$this->user = "saregama_read";
				$this->pass = "pass@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			}			
	
		}else if( $_SERVER['SERVER_ADDR'] == '192.168.64.52' || $_SERVER['SERVER_ADDR'] == '192.168.64.54' ){
			// LIVE Environment
			
			if($db == 'cmsdb'){		// READ USER
				$this->host = "localhost";
				$this->user = "saregama_read";
				$this->pass = "passread@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			
			}else if( $db == 'cmsdb_rw' ){  //WRITE USER
				 $this->host = "192.168.64.52";
                 $this->user = "saregama";
                 $this->pass = "pass@123";
                 $this->db = "saregama_db";
				 $this->port = "3306";
			
			}else if( $db == 'wapdb' ){  //WAP db to deploy to wap
				$this->host = "192.168.64.121";
				$this->user = "amitk";
				$this->pass = "pass@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			}else{
				// Read User
				$this->host = "localhost";
				$this->user = "saregama_read";
				$this->pass = "passread@123"; 
				$this->db = "saregama_db";
				$this->port = "3306";
			}
		
		}else{#if($_SERVER['SERVER_ADDR'] == '127.0.0.1'){//for localhost
				if( $db == 'wapdb' ){  //WRITE USER
					$this->host = "192.168.64.121";
					$this->user = "amitk";
					$this->pass = "pass@123"; 
					$this->db = "saregama_db";
					$this->port = "3306";
				}else{
					$this->host = "192.168.64.121";
					$this->user = "amitk";
					$this->pass = "pass@123"; 
					$this->db = "saregama_db";
					$this->port = "3306";
				}
		}		
	    parent::__construct($this->host, $this->user, $this->pass, $this->db, $this->port);
		$conn=$this;
        if(mysqli_connect_error()) {
            echo '<br>Connect Error ' . mysqli_connect_errno() . ' -> '. mysqli_connect_error();
			die("Connection failed: \n");
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
	 * check the string against sql injection
	 *
	 * @param string $value
	 * @return string
	*/
	public function secure($value) {
		return mysqli_real_escape_string($this,$this->replace($value));
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
		global $oMysqli_rw; 
		if(strtolower($this->char) == "utf8")
			//$sql = utf8_decode($sql);
		if( $charset != ''){	@parent::set_charset( $charset );	}	
		
		if(((strtolower(substr(trim($sql),0,6)) == "select") || (strtolower(substr(trim($sql),0,4)) == "show"))){
			//For Readonly
			@$query = @parent::query($sql);
			if(DB_DEBUG)
				$this->debugi("SQL",$sql,$query);
			
			if( $query != false ){
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
			}else{
				$return = NULL;
			}
			
		}else{
			$return = NULL;
			
			if( !is_object($oMysqli_rw) ){
				$oMysqli_rw = new mysqliDb('cmsdb_rw');
			}
			
			@$query = $oMysqli_rw->query_rw($sql);
			if(DB_DEBUG)
				$this->debugi("SQL",$sql,$query);
			
			if(strtolower(substr($sql,0,6)) == "insert"){
				$return = $oMysqli_rw->insert_id;
			}else{
				$return = $oMysqli_rw->affected_rows;
			}
			
		}
		return  $return;
	}	
	public function query_global( array $a = array()) {
		$sql=trim($a['sql']);
		$charset=$a['charset'];
		if(strtolower($this->char) == "utf8")
			//$sql = utf8_decode($sql);
		if( $charset != ''){	@parent::set_charset( $charset );	}	
		@$query = @parent::query($sql);
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
	public function query_rw($sql, $charset='') {
		@$query = @parent::query($sql);
			if(DB_DEBUG)
				$this->debugi("SQL",$sql,$query);
		if(strtolower(substr($sql,0,6)) == "insert"){
			$return = $this->insert_id;
		}else{
			$return = $this->affected_rows;
		}
		
		return  $return;	
	}
	/**
	 * get the next id
	 *
	 * @param string $table
	 * @param string $col
	 * @return int
	 */
	public function nextid($table,$col) {
		$sql = "SELECT IFNULL(MAX(".$this->secure($col)."),0) + 1 AS maximum FROM `".$this->secure($table)."`";
		$lines = $this->query($sql);
		return ($lines != NULL) ? (($this->variable == 'object') ? (int)$lines[0]->maximum : (int)$lines[0]["maximum"]) : NULL;
	}
	
	/**
	 * execute the insert query
	 *
	 * @param string $table
	 * @param array|object $values
	 * @param string $where
	 * @param string $is
	 * @return int
	 */
	public function insert($table,$values,$where = NULL,$is = NULL) {
		if($where != NULL) {
			$keys[] = "`".$this->secure($where)."`";
			$vals[] = "'".$this->secure($is)."'";
		}
		foreach((array)$values as $key => $value) {
			$keys[] = "`".$this->secure($key)."`";
			$vals[] = "'".$this->secure($value)."'";
		}
		$sql = "INSERT INTO `".$this->secure($table)."` (".implode(",",$keys).") VALUES (".implode(",",$vals).")";
		return $this->query($sql);
	}
		/**
	 * execute the delete query
	 *
	 * @param string $table
	 * @param string $where
	 * @param string $is
	 * @return int
	 */
	public function delete($table,$where,$is) {
		$where = $this->wheres($where,$is);
		$sql = "DELETE FROM `".$this->secure($table)."` WHERE ".$where;
		return $this->query($sql);
	}
	/**
	 * execute the update query
	 *
	 * @param string $table
	 * @param array|object $values
	 * @param string $where
	 * @param string $is
	 * @return int
	*/
	public function update($table,$values,$where) {
		foreach((array)$values as $key => $value)
			$updates[] = "`".$this->secure($key)."`='".$this->secure($value)."'";
		$sql = "UPDATE `".$this->secure($table)."` SET ".implode(",",$updates)." WHERE ".$where;
		return $this->query($sql);
	}
	/**
	 * execute the simple update query
	 *
	 * @param string $table
	 * @param array|object $values
	 * @param string $where
	 * @param string $is
	 * @return int
	 */
	public function simple_update($table,$values,$where,$is) {
		$where = $this->wheres($where,$is);
		foreach((array)$values as $key => $value)
			$updates[] = "`".$this->secure($key)."`='".$this->secure($value)."'";
		$sql = "UPDATE `".$this->secure($table)."` SET ".implode(",",$updates)." WHERE ".$where;
		return $this->query($sql);
	}
	
	/**
	 * execute the select query
	 *
	 * @param string $table
	 * @param string $cols
	 * @param string $where
	 * @param string $order
	 * @param int $ini
	 * @param int $end
	 * @return object
	*/
	public function select($table,$cols = "*",$where = NULL,$order = NULL,$ini = NULL,$end = NULL) {
		if(!is_array($cols) && ($cols != NULL) && ($cols != "*"))
			$cols = explode(",",trim($cols));
		foreach((array)$cols as $col)
			$rcols[] = "`".$this->secure($col)."`";
		if(!is_array($order) && ($order != NULL))
			$order = explode(",",trim($order));	
		foreach((array)$order as $ord)
			$rorder[] = "`".$this->secure($ord)."`";
		$sql = "SELECT ".((($cols != NULL) && ($cols != "*")) ? implode(", ",$rcols) : "*")." FROM `".$this->secure($table)."`";
		if($where != NULL)
			$sql.= " WHERE ".$this->replace($where);
		if($order != NULL)
			$sql.= " ORDER BY ".implode(", ",$rorder);
		if($end != NULL)
			$sql.= " LIMIT ".(int)$ini.",".(int)$end;
		return $this->query($sql);
	}

	/**
	 * execute the simple select query
	 *
	 * @param string $table
	 * @param string $cols
	 * @param string|array $where
	 * @param string|array $is
	 * @param string $order
	 * @param int $ini
	 * @param int $end
	 * @return object
	 */
	public function simple_select($table,$cols = "*",$where = NULL,$is = NULL,$order = NULL,$ini = NULL,$end = NULL) {
		$where = $this->wheres($where,$is);
		return $this->select($table,$cols,$where,$order,$ini,$end);
	}

	/**
	 * discouraged
	*/
	public function sselect($table,$cols = "*",$where = NULL,$is = NULL,$order = NULL,$ini = NULL,$end = NULL) {
		return $this->simple_select($table,$cols,$where,$is,$order,$ini,$end);
	}
	/**
	 * execute the select query for search
	 *
	 * @param string $table
	 * @param string|array $cols
	 * @param string|array $search
	 * @param string $is
	 * @return object
	*/
	public function search($table,$cols = "*",$search,$is,$order = NULL,$ini = NULL,$end = NULL) {		
		if(is_array($search))
			foreach((array)$search as $current)
				$where[] = "`".$this->secure($current)."` LIKE '".$this->secure($is)."'";
		else
			$where[] = "`".$this->secure($search)."` LIKE '".$this->secure($is)."'";
		$where = implode(" OR ",$where);
		return $this->select($table,$cols,$where,$order,$ini,$end);
	}
	
	/**
	 * create the 'where' area of the query
	 * check if is array and implode the values
	 *
	 * @param string|array $where
	 * @param string|array $is
	 * @param string $concat
	 * @return string
	*/
	private function wheres($where,$is,$concat = "AND") {
		if(($where != NULL) && ($is != NULL)) {
			if(is_array($where)) {
				for($i=0,$t=count($where);$i<$t;$i++)
					$array[] = "`".$this->secure($where[$i])."`='".$this->secure($is[$i])."'";
				$where = implode(" ".$concat." ",$array);
			} else	
				$where = "`".$this->secure($where)."`='".$this->secure($is)."'";
		}
		return $where;
	}
	/**
	 * show the debug message
	 *
	 * @param string $name
	 * @param string $debug
	 * @param bool $test
	 */
	public function debugi($name,$debug=NULL,$test=NULL) {
		if(strtolower($this->char) == "utf8")
			$debug = utf8_encode($debug);
		echo "<pre>".$name.": <font color='".($test?"blue":"red")."'>".$debug."</font>";
		if(!$test)
			echo "<br>ERROR: <font color='red'>(".@parent::errno().") ".@parent::error()."</font>";
		echo "</pre>";
	}
}
?>