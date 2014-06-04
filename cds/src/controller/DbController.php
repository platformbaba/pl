<?php


class DbController extends AbstractController{

	protected $oMysqli = null;
	protected $messenger;
	
	public function __construct(){
		global $messenger;
		$this->oMysqli = new mysqliDb();
		$this->messenger =&$messenger;
	}

	public function execute(){
		
		$db_module = $this->messenger['query']['module'];
		$actiontype = $this->messenger['query']['actiontype'];
		if(string_utils::isEmpty($actiontype))
			$actiontype="getdetails";
		$res = null;
		$moduleclass = null;
		if($db_module=="audio"){			
			$moduleclass =new audio_db($this->oMysqli);
			
		}else if($db_module=="album"){
			$moduleclass =new album_db($this->oMysqli);
			
		}else if($db_module=="artist"){			
			$moduleclass =new artist_db($this->oMysqli);
			
		}else if($db_module=="playlist"){	//generic
				
			$moduleclass =new playlist_db($this->oMysqli);
			
		}else if($db_module=="event"){	//generic
				
			$moduleclass =new event_db($this->oMysqli);
			
		}else if($db_module=="generic"){	//generic
				
			$moduleclass =new generic_db($this->oMysqli);
			
		}else{
			throw new Exception("Illegal action type");
		}
		// check all modules here
		
		if (method_exists($moduleclass,$actiontype)) {
			$res = $moduleclass->$actiontype();
			$this->messenger['response']['status']="1";
			$this->messenger['response']['resp']=$res;
		}else{
			throw new Exception("Unsupported Action");
		}
							
	}	
	
}

?>