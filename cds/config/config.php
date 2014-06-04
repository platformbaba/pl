<?php
define('DBMASTERIP',"localhost");
define('DBMASTERPORT',"3306");
define('DBMASTERUSERNAME',"saregama_read");
define('DBMASTERPASSWORD',"passread@123");
define('DBMASTERDATABSE',"saregama_db");
define('DB_DEBUG',false);
define('MAX_DISPLAY_COUNT',10);
define('FILTERS_PATH', PATH.'src/filters/');
define('LIB_PATH', PATH.'src/lib/');
define('CONTROLLER_PATH', PATH.'src/controller/');
define('CLASSES_PATH', PATH.'src/classes/');
define('UTILS_PATH', PATH.'src/utils/');
define("DB_CLASSES_PATH",CLASSES_PATH."db/");
define("SOLR_CLASSES_PATH",CLASSES_PATH."search/");
define("DB_DTO_CLASSES_PATH",CLASSES_PATH."dto/");
define("SOLR_DTO_CLASSES_PATH",CLASSES_PATH."dto/");

define("LOGGING_PATH",PATH.'logs/');

$dbSlaveIp		 = "";
$dbSlavePort	 = "";
$dbSlaveUserName = "";
$dbSlavePassword = "";

$solrIp	  = "localhost";
$solrPort = "8080";
#$solrAutoSuggestUrl="/solr/autosuggest/";
#$solrAutoAudioUrl="/solr/audio/";
/* REDIS MEMORY CACHING*/
$redisServer = array(
    'host'     => '192.168.64.122',
    'port'     => 6379,
    'database' => 0,
	'alias' => 'saregama'
);

/***************************************************** 
* 1 ==> apply filter at the beginning of the request *
* 2 ==> apply filter at the end of the request       *
* order of the filters is important                  *
*****************************************************/
$filters = array(
				'auth.php' => 0,				// CURL call to auth service
				'cache.php' => 0,               // Request to Cache
				'logger.php' => 2    // CURL Call here
				);

$allowedModules = array(
				'audio',
				'artist',
				'album',
				'video',
				'image',
				'generic',
				'playlist',
				'event'
				);

				
$messenger = array(
			'app_id'=>'',
			'query'=>	array(
				'action'=>'',
				'actiontype'=>'',
				'query'=>'',
				'start'=>'',
				'limit'=>'',
				'filters'=>'',
				'so'=>'',
				'sf'=>'',
				'includes'=>'',
				'criteria'=>'',
				'id'=>''
				),
			'response'=>	array(
				'status' =>0,
				'resp' =>array(),
				'format'=> "json",
				'error_msg' =>'',
				'performance'=>array('init'=>round(microtime(true) * 1000),
						'execution_time'=>''
					)
				),
			'getKey' => function(){
							global $messenger;
							$str = '';
							foreach($messenger['query'] as $key=>$value){
								if(!string_utils::isEmpty($value))
									$str=$str.$key.'-'.$value.'--';
							}	
							
							$str = trim($str,"--");
									
							return $str;
			},	
			'skipController' =>false,
			'isAlreadyEncoded' =>false
			
		);


//TODO pick from CMS config
$aConfig = array();
$aConfig['artist_type'] = array("starcast" => 1, "music director" => 2, "lyricist" => 4, 
								"singer" => 8, "director" => 16 , "producer" => 32, 
								"writer" => 64 , "mimicked star" => 128, "poet" => 264);

$aConfig['album_type'] = array("film" => 1, "original" => 2, "digital" => 4);

$aConfig['album_content_type'] = array( "song"=>1,"video"=>2, "image"=>4 , "text"=>8 );
$aConfig['playlist_content_type'] = array( 4 => "audio", 15=> "video", 17=> "image");
$aConfig['calendar_event'] = array( 1 => "Birth Anniversary", 2=>"Death Anniversary", 3 => "Festivals", 4 => "Events");

define('SITEPATH', 'http://'.$_SERVER['HTTP_HOST'].'/cms/');
/* library Path */
define('LIBPATH', PATH.'includes/lib/');
/* Media PAth */
define('MEDIA_SEVERPATH', PATH.'media/');
/* Media PAth */
define('MEDIA_SITEPATH', SITEPATH.'media/');
/* Image Media Path */
define('MEDIA_SEVERPATH_IMAGE', MEDIA_SEVERPATH.'photos/');
/* Image Media Site Path */
define('MEDIA_SITEPATH_IMAGE', SITEPATH.'media/photos/');
?>