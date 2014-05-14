<?php
include_once(LIB_PATH.'SolrPhpClient/Apache/Solr/Service.php');

//use Controller;

class SearchController extends AbstractController{	
	
	protected $messenger;
	
	public function __construct(){
		global $messenger;
		$this->messenger =&$messenger;
	}
	

	public function execute(){
		global $messenger;
		
		$solr_module = $messenger['query']['module'];
		$actiontype = $this->messenger['query']['actiontype'];
		if(string_utils::isEmpty($actiontype))
			$actiontype="getsearch";
		$res = NULL;
		$moduleclass = NULL;
		
		if( $solr_module=="audio" ){ 
			$moduleclass = new audio_solr(); //Audio solr class.
			
		}elseif( $solr_module=="album" ){
	
			$moduleclass =new album_solr(); //Album solr class.
			
		}elseif( $solr_module=="video" ){
	
			$moduleclass =new video_solr(); //Video solr class.
			
		}elseif( $solr_module=="artist" ){
		
			$moduleclass =new artist_solr(); //Artist solr class.
			
		}elseif( $solr_module=="video" ){
			$moduleclass =new video_solr(); //Autosuggst solr class.
			
		}elseif( $solr_module=="image" ){
			$moduleclass =new image_solr(); //Autosuggst solr class.
			
		}else{
		
			throw new Exception("Illegal action type");
		// check all modules here
		// if unsupported module throw exception here;
		}
		
		if(method_exists($moduleclass,$actiontype)){
			$res = $moduleclass->$actiontype();
			$messenger['response']['status']="1";
			$messenger['response']['resp']=$res;
			$messenger['isAlreadyEncoded'] = true;	
		}else{
			throw new Exception("Unsupported Action");
		}
							
	}	
	
}
?>