<?php


class video_solr extends base_solr{  

	private $solr;
	public function __construct(){
		parent::__construct();
		$this->solr = new Apache_Solr_Service($this->solrIp, $this->solrPort, '/solr/video/');	
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
		$resFetch=$response->getRawResponse();
		return $resFetch;
	}
}
?>