<?php

class audio_solr extends base_solr{  

	private $solr;
	
	public function __construct(){
		parent::__construct();
		$this->solr = new Apache_Solr_Service($this->solrIp, $this->solrPort, '/solr/audio/');
	}
	
	public function autosuggest(){ 
		
		$start = $this->messenger['query']['start'];
		$limit = $this->messenger['query']['limit']; 
		$query = $this->messenger['query']['queryS'];
		$query	  = "aq:".urlencode($query);
		$qType = $this->messenger["query"]["criteria"];

		$response = $this->solr->search( $query,$start,$limit,array('fq' => $qType) );
		$found    = $response->response->numFound;
		$resFetch=$response->getRawResponse();
		return $resFetch;
	}
	
	// default action
	public function getsearch(){
		
		$start = $this->messenger['query']['start'];
		$limit = $this->messenger['query']['limit']; 
		$query = $this->messenger['query']['queryS']; // Search "query" string from URL.
		if($query=="*")
			$query	  = "q:".$query;
		else{
			$q = $query;
			$query	  = 'q:"'.$query.'"';
			$query = $query.' name:"'.$q.'"';
		}
		
		$qType = $this->messenger["query"]["criteria"];
		$response = $this->solr->search( $query,$start,$limit,array('fq' => $qType) );
		$found    = $response->response->numFound;
		if($found<1){
			// retry with tokenized query
			
			$tokens = explode(" ",trim($this->messenger['query']['queryS']));
			if(sizeof($tokens>1)){
				$query = "";
				foreach($tokens as $token){
					$q = $token;
					$token	  = ' q:"'.$token.'"';
					$token = $token.' name:"'.$q.'"';
					$query = $query." ".$token;
				}
			}
			$response = $this->solr->search( $query,$start,$limit,array('fq' => $qType) );
		}
		
		$resFetch=$response->getRawResponse();
		return $resFetch;
	}
	
	
}
?>