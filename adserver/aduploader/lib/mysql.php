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
    public function __construct($db) {

	
		$this->host = "localhost";
		$this->user = "root";
		$this->pass = "password"; 
		$this->db = "adserver";
       	$this->port = "3306";
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
		*/
		if(strtolower($this->char) == "utf8")
			$sql = utf8_decode($sql);
		if( $charset != '')
			@parent::set_charset( $charset );	

		@$query = @parent::query($sql);
		if((strtolower(substr(trim($sql),0,6)) == "select") && ($query != false)) {
			$return = NULL;
			while($line = $query->fetch_object()) {
				$new_line = ($this->variable == 'object') ? (object)NULL : (array)NULL;
				foreach((array)$line as $key => $value) {
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