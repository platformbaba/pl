<?php            
date_default_timezone_set('Asia/Calcutta');
/* All Config related data comes here */
define('SITEPATH', "http://".$_SERVER['HTTP_HOST'].'/cms/');

/* library Path */
define('LIBPATH', PATH.'includes/lib/');

/* Media PAth */
define('MEDIA_SEVERPATH', PATH.'media/');

/* Media Read PAth */
define('MEDIA_READ_SEVERPATH', PATH.'media_read/');

/* Media PAth */
define('MEDIA_SITEPATH', SITEPATH.'media/');

/* TMP NEW MEDIA */
define('TEMP_RAW_MEDIA_PATH', SITEPATH.'new_media/');

/* Image Media Path */
define('MEDIA_SEVERPATH_IMAGE', MEDIA_SEVERPATH.'photos/');

/* Image Media Site Path */
define('MEDIA_SITEPATH_IMAGE', SITEPATH.'media/photos/');

/* Doc Media Path */
define('MEDIA_SEVERPATH_DOC', MEDIA_SEVERPATH.'text/');

/* Doc Media Site Path */
define('MEDIA_SITEPATH_DOC', SITEPATH.'media/text/');

/* temp Media Path */
define('MEDIA_SEVERPATH_TEMP', MEDIA_SEVERPATH.'temp/');

/* temp Site Path */
define('MEDIA_SITEPATH_TEMP', SITEPATH.'media/temp/');

/* Song Media Server Path */
define('MEDIA_SEVERPATH_SONG', MEDIA_SEVERPATH.'songs/');

/* Song Media Read Server Path */
define('MEDIA_READ_SEVERPATH_SONG', MEDIA_READ_SEVERPATH.'songs/');

/* Song Media Site Path */
define('MEDIA_SITEPATH_SONG', SITEPATH.'media/songs/');

/* Video Media Server Path */
define('MEDIA_SEVERPATH_VIDEO', MEDIA_SEVERPATH.'videos/');

/* Video Media Site Path */
define('MEDIA_SITEPATH_VIDEO', SITEPATH.'media/videos/');

/* Songs Edit Media Site Path */
define('MEDIA_SITEPATH_SONGEDITS', SITEPATH.'media/songs/edits/');

/* Songs Edit Media Site Path */
define('MEDIA_SERVERPATH_SONGEDITS', PATH.'media/songs/edits/');

/* Songs Raw Media Site Path */
define('MEDIA_SITEPATH_SONGRAW', SITEPATH.'media/songs/raw/');

/* Songs Raw Media Server Path */
define('MEDIA_SERVERPATH_SONGRAW', PATH.'media/songs/raw/');

/* images Edit Media Site Path */
define('MEDIA_SITEPATH_IMAGEEDITS', SITEPATH.'media/images/edits/');

/* images Edit Media Site Path */
define('MEDIA_SERVERPATH_IMAGEEDITS', PATH.'media/images/edits/');
 
/* Videos Raw Media Site Path */
define('MEDIA_SITEPATH_VIDEORAW', SITEPATH.'media/videos/raw/');

/* Videos Raw Media Server Path */
define('MEDIA_SERVERPATH_VIDEORAW', PATH.'media/videos/raw/');

/* videos Edit Media Site Path */
define('MEDIA_SITEPATH_VIDEOEDITS', SITEPATH.'media/videos/edits/');

/* videos Edit Media Site Path */
define('MEDIA_SERVERPATH_VIDEOEDITS', PATH.'media/videos/edits/');

/* temp deployment Path */ 
define('MEDIA_SEVERPATH_DEPLOY', MEDIA_SEVERPATH.'temp/deployments/');

/* temp deployment Path */ 
define('MEDIA_READ_SEVERPATH_DEPLOY', MEDIA_READ_SEVERPATH.'temp/deployments/'); 
  
/* temp deployment SIte Path */ 
define('MEDIA_SITEPATH_DEPLOY', SITEPATH.'media/temp/deployments/');


/* Template Path */
define('TEMPLATESPATH', PATH.'includes/templates/');

/* Controller Path */
define('CONTROLLERPATH', PATH.'controller/');

/* Controller Site Path */
define('CONTROLLERSITEPATH', SITEPATH.'controller/');

/* View Path */
define('VIEWPATH', PATH.'view/');

/* Model Path */
define('MODELPATH', PATH.'model/');

/* JS Path */
define('JSPATH', SITEPATH.'resources/js/');

/* CSS Path */
define('CSSPATH', SITEPATH.'resources/css/');

/* IMAGES Path */
define('IMGPATH', SITEPATH.'resources/img/');

/* PLAYER Path */
define('PLAYERPATH', PATH.'resources/player/');

/* IMAGES Path */
define('EDITORIMGHTTPPATH', SITEPATH.'resources/img/editors/');
/* IMAGES Path */
define('EDITORIMGPATH', PATH.'resources/img/editors/');

/* temp ftp Path */
define('MEDIA_SERVERPATH_TEMPFTP', PATH.'media/temp/ftp/');

/* temp ftp read Path */
define('MEDIA_READ_SERVERPATH_TEMPFTP', MEDIA_READ_SEVERPATH.'temp/ftp/');

/* Number row to be displayed on list page */
define('MAX_DISPLAY_COUNT', 20);
define('MAX_DISPLAY_COUNT_EVENT', 10);

/* Audio MP3 Storage Path */
define('STORAGEPATH', SITEPATH.'source/');

/* Global Variables */
$aError=array();
$aConfig=array();

/* include common Library */
include_once(LIBPATH. 'cms.class.php');
include_once(LIBPATH. 'notification.class.php');
include_once(LIBPATH. 'tools.class.php');
include_once(LIBPATH. 'paging.class.php');
require_once(LIBPATH. 'calendar.class.php');

define('DB_CHAR','utf8');
define('DB_RETURN','array');
define('DB_DEBUG',false);
define('DB_VARIABLE',"object");

/* CMS OF instantiation */
$oMysqli = new mysqliDb('cmsdb');

/* CMS OF instantiation */
$oCms= new CMS();
$oTools = new TOOLS();
$oNotification = new Notification();

/* get moduleName */
$moduleName = $oCms->sanitizeVariable( $_GET['q'] ); 

/* Template Path */
define('MODULENAME', $moduleName );

/* Meta Data */
$aConfig['meta-title'] = 'Saregama CMS';
$aConfig['no-contents'] = 'No Contents';
/* all module action List*/
$aConfig['module-action'] = array(1 => "view", 2=>"add", 3 => "edit", 4 => "delete", 5=>'legal', 6=>'publish' );
/* all module List*/

$aConfig['module'] = array( 1 => "dashboard", 2=>"language", 3 => "editor", 4 => "song", 5 => "role" , 6 => "permission" ,7=> "audiotools", 8 => "banner", 9=> "tags", 10 => "label", 11 => "region", 12 => "options" , 13 => "artist", 14 => "album" ,15=> "video",16=> "videotools", 17=> "image", 18 => "songbulk", 19 => "text",20=> "event", 21 => "catalogue" , 22 => "imi-deployment", 23 => "reliance-audio-deployment", 24 => "spice-deployment" ,25 => "song-edits", 26=>"explore", 27=>"image-edits" , 28=>"video-edits",29 => "playlist" ,30 => "crbt", 31=>"nokia-deployment", 32=>"albumbulk",33 => "videobulk" ,34 => "imagebulk",35 => "textbulk", 36 => "songbulk-edits", 37 => "wap-song-deployment",38 => "video-youtube-deployment", 39 => "radiostation", 40 =>"radioprogram", 41 =>"packs");


/* used to show related all different contents */
$aConfig['related-contents'] = array(
								'14' => array(4, 15, 17),
								'20' => array(4, 15, 17),
								'4'  => array(15),
								'13'  => array(17, 4, 14),
							   );						 

/* always add module id otherwise...*/
$aConfig['menu-module'] = array(
							1 => array( 'name' => 'Dashboard', 'url' => 'dashboard' ,'isLogin'=>1, 'moduleId' => 1 , 'moduleIdArr' =>array(1), 'action' => 'view'),
							
							2 => array( 'name' => 'Explore by', 'sub-menu' => array(
								1 => array( 'name' => 'Label', 'url' => 'explore?s-menu=label&action=view&type=label' , 'moduleId' => 26 , 'action' => 'view'),
								2 => array( 'name' => 'Artist', 'url' => 'explore?s-menu=artist&action=view&type=artist' , 'moduleId' => 26, 'action' => 'view'),
								3 => array( 'name' => 'Year', 'url' => 'explore?s-menu=year&action=view&type=year' , 'moduleId' => 26, 'action' => 'view'),
								4 => array( 'name' => 'Genre', 'url' => 'explore?s-menu=genre&action=view&type=genre' , 'moduleId' => 26 , 'action' => 'view'),
									) ,'isLogin'=>1, 'moduleId' => 26,'moduleIdArr' =>array(26), 'action' => 'view'),
									
							3 => array( 'name' => 'Admin', 'sub-menu' => array(
								1 => array( 'name' => 'Manage Editor', 'url' => 'editor?action=view' , 'moduleId' => 3 , 'action' => 'view'),
								2 => array( 'name' => 'Manage Role', 'url' => 'role?action=view' , 'moduleId' => 5, 'action' => 'view'),
								3 => array( 'name' => 'User Activities', 'url' => 'dashboard?do=activity' , 'moduleId' => 3 , 'action' => 'view'),
								4 => array( 'name' => 'Clean Up', 'url' => 'mapper' , 'moduleId' => 5 , 'action' => 'view'),
									) ,'isLogin'=>1, 'moduleId' => 3,'moduleIdArr' =>array(3,5), 'action' => 'view'),
																				
							4 => array( 'name' => 'Content', 'sub-menu' => array(
								1 => array( 'name' => 'Album', 'url' => 'album?action=view', 'moduleId' => 14, 'action' => 'view', 'sub-menu' => array(
									1 => array( 'name' => 'Song', 'url' => 'song?action=view' , 'moduleId' => 4, 'action' => 'view'),
									2 => array( 'name' => 'Video', 'url' => 'video?action=view' , 'moduleId' => 15, 'action' => 'view'),
									3 => array( 'name' => 'Image', 'url' => 'image?action=view' , 'moduleId' => 17, 'action' => 'view'),
									4 => array( 'name' => 'Text', 'url' => 'text?action=view' , 'moduleId' => 19, 'action' => 'view'),
										) )
									) ,'isLogin'=>1, 'moduleId' => 14,'moduleIdArr' =>array(14,4,15,17,19), 'action' => 'view'),							
												
							5 => array( 'name' => 'Masters', 'sub-menu' => array(
								1 => array( 'name' => 'Artist', 'url' => 'artist?action=view' , 'moduleId' => 13, 'action' => 'view'),
								8 => array( 'name' => 'Playlist', 'url' => 'playlist?action=view' , 'moduleId' => 29, 'action' => 'view'),
								8 => array( 'name' => 'Special Pack', 'url' => 'packs?action=view' , 'moduleId' => 41, 'action' => 'view'),
								2 => array( 'name' => 'Banner', 'url' => 'banner?action=view' , 'moduleId' => 8, 'action' => 'view'),
								3 => array( 'name' => 'Catalogue', 'url' => 'catalogue?action=view' , 'moduleId' => 21, 'action' => 'view'),
								4 => array( 'name' => 'Language', 'url' => 'language?action=view' , 'moduleId' => 2, 'action' => 'view'),
								5 => array( 'name' => 'Label', 'url' => 'label?action=view' , 'moduleId' => 10, 'action' => 'view'),
								6 => array( 'name' => 'Region', 'url' => 'region?action=view' , 'moduleId' => 11, 'action' => 'view'),
								7 => array( 'name' => 'Tags', 'url' => 'tags?action=view' , 'moduleId' => 9, 'action' => 'view'),
								) ,'isLogin'=>1, 'moduleId' => 2, 'moduleIdArr' =>array(13,29,8,21,2,10,10,11,9,41),'action' => 'view'),
								
							6 => array( 'name' => 'COE', 'url' => 'event?action=view' ,'isLogin'=>1, 'moduleId' => 20,'moduleIdArr' =>array(20), 'moduleIdArr' =>array(20) , 'action' => 'view'),
							
							7 => array( 'name' => 'Deployments', 'sub-menu' => array(
								1 => array( 'name' => 'IMI Deployment', 'url' => 'imi-deployment?action=view' , 'moduleId' => 22 , 'action' => 'view'),
								2 => array( 'name' => 'Spice Deployment', 'url' => 'spice-deployment?action=view' , 'moduleId' => 24 , 'action' => 'view'),
								3 => array( 'name' => 'Reliance Audio Deployment', 'url' => 'reliance-audio-deployment?action=view' , 'moduleId' => 23 , 'action' => 'view'),
								4 => array( 'name' => 'Nokia Deployment', 'url' => 'nokia-deployment?action=view' , 'moduleId' => 31 , 'action' => 'view'),
								5 => array( 'name' => 'WAP Song Deployment', 'url' => 'wap-song-deployment?action=view' , 'moduleId' => 37 , 'action' => 'view'),
										) ,'isLogin'=>1, 'moduleId' => 1,'moduleIdArr' =>array(22,24,23,31,37), 'action' => 'view'),
							8 => array( 'name' => 'Bulk Uploads', 'sub-menu' => array(
								1 => array( 'name' => 'Album Bulk Uploads', 'url' => 'albumbulk?action=view' , 'moduleId' => 32 , 'action' => 'view'),
								2 => array( 'name' => 'Song Bulk Uploads', 'url' => 'songbulk?action=view' , 'moduleId' => 18 , 'action' => 'view'),
								3 => array( 'name' => 'Video Bulk Uploads', 'url' => 'videobulk?action=view' , 'moduleId' => 33 , 'action' => 'view'),
								4 => array( 'name' => 'Image Bulk Uploads', 'url' => 'imagebulk?action=view' , 'moduleId' => 34 , 'action' => 'view'),
								5 => array( 'name' => 'Text Bulk Uploads', 'url' => 'textbulk?action=view' , 'moduleId' => 35 , 'action' => 'view'),
								6 => array( 'name' => 'Song Bulk Edits Uploads', 'url' => 'songbulk-edits?action=add' , 'moduleId' => 36 , 'action' => 'view'),
										) ,'isLogin'=>1, 'moduleId' => 1,'moduleIdArr' =>array(32,18,33,34,35,36), 'action' => 'view'),	

							9 => array( 'name' => 'Radio', 'sub-menu' => array(
								1 => array( 'name' => 'Radio Station', 'url' => 'radiostation?action=view' , 'moduleId' => 39 , 'action' => 'view'),
								2 => array( 'name' => 'Radio Program', 'url' => 'radioprogram?action=view' , 'moduleId' => 40 , 'action' => 'view'),
									) ,'isLogin'=>1, 'moduleId' => 39,'moduleIdArr' =>array(39, 40), 'action' => 'view'),	
							);

$aConfig['status-options']	= array( '0'=>'draft', '2'=>'qc-approve','3'=>'legal-approve', '1'=>'publish', '-1'=>'delete' ); 
//0-draft,2-qc complete,3-legal complete,1-publish
$aConfig['flow']=array(
					0=>array("next"=>2,"perm"=>"qc"),//draft
					2=>array("prev"=>0,"next"=>3,"perm"=>"legal"),//qc
					3=>array("prev"=>2,"next"=>1,"perm"=>"publish"),//legal
					1=>array("prev"=>3,"perm"=>"publish"),//publish
				);

$aConfig['image_ext'] = array('jpg','jpeg', 'gif','png','txt');
$aConfig['doc_ext']	  = array('pdf','txt', 'doc','docx','csv');

$aConfig['artist_type'] = array("Starcast" => 1, "Music Director" => 2, "Lyricist" => 4, "Singer" => 8, "Director" => 16 , "Producer" => 32, "Writer" => 64 , "Mimicked Star" => 128, "Poet" => 264);

$aConfig['album_type'] = array("Film" => 1, "Original" => 2, "Digital" => 4);

$aConfig['album_content_type'] = array( 1=> "Song", 2=> "Video", 4=> "Image", 8=> "Text", 16=>"Packs");

$aConfig['image_type'] = array( "Media Art"=>1, "Animation" => 2, "Wallpaper" => 3, "Photo" => 4 );

$aConfig['text_type'] = array("sms text"=>1, "trivia" => 2);

$aConfig['gender'] = array("1" => "Male", "2" => "Female");

$aConfig['game_platform'] = array(1=>"android", 2 => "ios" , 3 => "symbian" , 4 => "window");
###
$aConfig['publishing_rights'] = array(1=>'Mechanical', 2=>'Performance', 4=>'Synchronization');   
$aConfig['digital_rights']	 = array('web'=>array(1=>'Streaming', 2=>'Downloads'),
								 	 'mobile'=>array(4=>'Streaming-voice', 8=>'Streaming-sms', 16=>'Streaming-data', 32=>'Download-voice', 64=>'Download-sms', 128=>'Download-data' ));


$aConfig['countries'] = array("All","Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
 
###
$aConfig['grade'] = array("UA","U","A","R","PG-13","PG-15","NC-17");
$aConfig['film_rating'] =array("A+","A","B","C"); 

$aConfig['calendar_event'] = array( 1 => "Birth Anniversary", 2=>"Death Anniversary", 3 => "Festivals", 4 => "Events");
######## CONFIG ARRAY FOR DEPLOYMENT ######## 
$aConfig['deployments'] = array( "22" => "IMI", "24"=>"SPICE", "23" => "RELIANCEAUDIO", "31" => "NOKIA" );
/* to get current page url*/
define('SELFURL',"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$aConfig['stationType'] = array('S'=>'Standard station','A'=>'Artist station');
$aConfig['radioSongType'] = array('S','A','R');