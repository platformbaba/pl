<?php
/**
 * The deployment Model does the back-end Work for the deployment Controller
 */
class deployment
{
	protected $oMysqli; 
	protected $sSql;
	
	function __construct(){
		global $oMysqli;
		$this->oMysqli = $oMysqli;
	}
	
	/********************************************
	* Will returns all deployments 
	*@Param: array()
	********************************************/
	public function getAllDeployments( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY deployment_id DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
			$where .= " AND status!='-1' ";
		
		$this->sSql = "SELECT * FROM `deployment_mstr` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}

	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$where ='';
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
			$where .= " AND  status!='-1' ";
		
		$this->sSql = "SELECT count(1) as cnt FROM `deployment_mstr` WHERE 1 $where ";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}


	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		$this->sSql = "UPDATE `deployment_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND deployment_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$this->sSql = "UPDATE `deployment_mstr` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND deployment_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query( $this->sSql );
	}

	/**********************************************
	*Will check Availability of deployment
	* @param: string 
	**********************************************/
	public function checkdeploymentExist($deploymentName){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND deployment_id != ".(int)$_GET['id'];
		}
		$this->sSql="SELECT count(1) as cnt FROM `deployment_mstr` WHERE deployment_name = '".$this->oMysqli->secure($deploymentName)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query( $this->sSql );
		return (int)$data[0]->cnt;
	}
	
	/**********************************************
	*Will insert/Update deployment
	* @param: array 
	**********************************************/
	public function saveDeployment( array $a = array() ){
		
		if((int)$_GET['id']>0){
			$this->sSql = "UPDATE `deployment_mstr` SET `deployment_name`='".$this->oMysqli->secure($a['deploymentName'])."'  WHERE deployment_id = ".(int)$_GET['id']." LIMIT 1";
        }else{
			$this->sSql = "INSERT INTO `deployment_mstr` (`deployment_name`,`service_provider`,`insert_date`,`status`,`editor_id`) VALUES ('".$this->oMysqli->secure($a['deploymentName'])."','".$this->oMysqli->secure($a['serviceProvider'])."', NOW(),0,'".TOOLS::getEditorId()."' )";
		
		}
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	}
	
	public function addToDeployment( array $a = array() ){
		$deploymentId=$this->oMysqli->secure($a['deploymentId']);
		$songTitle = $this->oMysqli->secure($a['songTitle']);
		$language = $this->oMysqli->secure($a['language']);
		$category  = $this->oMysqli->secure($a['category']);
		$subCategory  = $this->oMysqli->secure($a['subCategory']);
		$coid  = $this->oMysqli->secure($a['coid']);
		$cpid  = $this->oMysqli->secure($a['cpid']);
		$clid  = $this->oMysqli->secure($a['clid']);
		$startDate  = $this->oMysqli->secure($a['startDate']);
		$endDate  = $this->oMysqli->secure($a['endDate']);
		$exclusive  = $this->oMysqli->secure($a['exclusive']);
		$album  = $this->oMysqli->secure($a['album']);
		$clano  = $this->oMysqli->secure($a['clano']);
		$keyArtist  = $this->oMysqli->secure($a['keyArtist']);
		$musicDirector  = $this->oMysqli->secure($a['musicDirector']);
		$searchKey  = $this->oMysqli->secure($a['searchKey']);
		$keyDirector  = $this->oMysqli->secure($a['keyDirector']);
		$keyProducer  = $this->oMysqli->secure($a['keyProducer']);
		$releaseYear  = $this->oMysqli->secure($a['releaseYear']);
		$albumYear  = $this->oMysqli->secure($a['albumYear']);
		$genre  = $this->oMysqli->secure($a['genre']);
		$starcast  = $this->oMysqli->secure($a['starcast']);
		$lyricist  = $this->oMysqli->secure($a['lyricist']);
		$singer  = $this->oMysqli->secure($a['singer']);
		$isrc  = $this->oMysqli->secure($a['isrc']);
		$deploymentId  = $this->oMysqli->secure($a['deploymentId']);
		$contentId  = $this->oMysqli->secure($a['contentId']);
		$contentType =  '4';
		$ddId  = $this->oMysqli->secure($a['ddId']);
		$providerDetails = $this->oMysqli->secure($a['providerDetails']);
		if($ddId>0){
			$this->sSql = "UPDATE `deployment_details` 	SET	`isrc` = '".$isrc."' , 	`title` = '".$songTitle."' , 	`language` = '".$language."' ,`album` = '".$album."' ,	`keyartist` = '".$keyArtist."' , 	`music_director` = '".$musicDirector."' , 	`search_key` = '".$searchKey."' , 	`director` = '".$keyDirector."' , 	`producer` = '".$keyProducer."' , 	`release_year` = '".$releaseYear."' , 	`album_year` = '".$albumYear."' , 	`genre` = '".$genre."' , 	`starcast` = '".$starcast."' , 	`lyricist` = '".$lyricist."' , 	`singer` = '".$singer."' , 	`update_date` = now() , `providers_details` = '".$providerDetails."'	WHERE	`id` = '".$ddId."' ";
			}else{
			$this->sSql = "INSERT IGNORE INTO `deployment_details` 
	(`deployment_id`, `isrc`, 	`title`, 	`language`, 	`album`, `keyartist`, 	`music_director`, 	`search_key`, 	`director`, 	`producer`, 	`release_year`,`album_year`,`genre`, 	`starcast`, 	`lyricist`, 	`singer`, 	`insert_date`,`update_date`,`content_id`, `content_type`,`providers_details`)	VALUES	('".$deploymentId."', 	'".$isrc."', 	'".$songTitle."', 	'".$language."', 	'".$album."', 	'".$keyArtist."', 	'".$musicDirector."', 	'".$searchKey."', 	'".$keyDirector."', 	'".$keyProducer."', '".$releaseYear."', '".$albumYear."', 	'".$genre."', 	'".$starcast."', 	'".$lyricist."', 	'".$singer."', 	now(), now(), '".$contentId."' , '".$contentType."','".$providerDetails."')";
		}
		$ret = $this->oMysqli->query( $this->sSql );

		return $ret;
	
	}
	
	/********************************************
	* Will returns deployments details
	*@Param: array()
	********************************************/
	public function getDeploymentsDetails( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY insert_date DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT * FROM `deployment_details` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/********************************************
	* Will returns deployments details with operator
	*@Param: array()
	********************************************/
	public function getDeploymentsReport( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY dd.id DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT dd.*,dm.deployment_id,dm.deployment_name,dm.service_provider,dm.is_ready,em.id,em.name 
						FROM `deployment_details` dd 
						LEFT JOIN deployment_mstr dm ON dm.deployment_id=dd.deployment_id AND dm.status=1
						LEFT JOIN editor_master em ON em.id=dm.editor_id
						WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	public function getTotalDRCount( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY dd.id DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT count(1) as cnt
						FROM `deployment_details` dd 
						LEFT JOIN deployment_mstr dm ON dm.deployment_id=dd.deployment_id AND dm.status=1
						LEFT JOIN editor_master em ON em.id=dm.editor_id
						WHERE 1 $where";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	/********************************************
	* Will returns pltform config details
	*@Param: array()
	********************************************/
	public function getSongEditConfig( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY insert_date DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT * FROM `song_edit_config` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	
	/********************************************
	* Will returns pltform config details
	*@Param: array()
	********************************************/
	public function getSongEditConfigRel( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY insert_date DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT * FROM `song_mstr_config_rel` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getSongConfigTotalCount( array $a = array() ){
		$where ='';
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
			$where .= " AND  status!='-1' ";
		
		$this->sSql = "SELECT MAX(version) as cnt FROM `song_mstr_config_rel` WHERE 1 $where ";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;
		}
	}

	
	/**********************************************
	*Will insert/Update info config data
	* @param: array 
	**********************************************/
	public function song_mstr_config_rel( array $a = array() ){
		$songId=(int)$a['songId'];
		$configId=(int)$a['configId'];
		$path=$this->oMysqli->secure($a['path']);
		$version=(int)$a['version'];
		
		$this->sSql = "INSERT INTO `song_mstr_config_rel` (`song_id`,`config_id`,`path`,`insert_date`,`status`,`version`) VALUES ('".$songId."','".$configId."','".$path."', NOW(),1,'".$version."') ON DUPLICATE KEY UPDATE path='".$path."',insert_date=NOW()";
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	}
	/**
	**To generate xml  for IMI deployment
	**/
	public function generateImiXml(array $a = array() ){
		$songTitle = $a['songTitle'];
		$language = $a['language'];
		$album = $a['album'];
		$keyArtist = $a['keyArtist'];
		$musicDirector = $a['musicDirector'];
		$searchKey = $a['searchKey'];
		$keyDirector = $a['keyDirector'];
		$keyProducer = $a['keyProducer'];
		$releaseYear = $a['releaseYear'];
		$albumYear = $a['albumYear'];
		$genre = $a['genre'];
		$starcast = $a['starcast'];
		$lyricist = $a['lyricist'];
		$singer = $a['singer'];
		$isrc = $a['isrc'];
		$deploymentId = $a['deploymentId'];
		$contentId = $a['contentId'];
		$contentType = '4';
		$ddId = $a['ddId'];
		$providerDetails = json_decode($a['providerDetails'],true);
		$category = $providerDetails['category'];
		$subCategory = $providerDetails['subCategory'];
		$coid = $providerDetails['coid'];
		$cpid = $providerDetails['cpid'];
		$clid = $providerDetails['clid'];
		$startDate = $providerDetails['startDate'];
		$endDate = $providerDetails['endDate'];
		$exclusive = $providerDetails['exclusive'];
		$clano = $providerDetails['clano'];
		$file_0808m=$providerDetails['0808m'];
		$file_0808m40S=$providerDetails['0808m40S'];
		$file_1616m=$providerDetails['1616m'];
		$file_0808mFull=$providerDetails['0808mFull'];
		$providerCode=$providerDetails['providerCode'];
		$deploymentFolder = $a['deploymentFolder'];
	
		$xmlBody='<?xml version="1.0" encoding="UTF-8"?><content><providercode>PPLSG_'.$providerCode.'</providercode><default><title>'.$songTitle.'</title><language>'.$language.'</language><cat>'.$category.'</cat><subcat>'.$subCategory.'</subcat></default><owners><owner><coid>'.$coid.'</coid><cpid>'.$cpid.'</cpid><clid>'.$clid.'</clid><startdate>'.$startDate.'</startdate><enddate>'.$endDate.'</enddate><exclusive>'.$exclusive.'</exclusive></owner></owners><formats><format><formatid>0808m</formatid><filename>'.$file_0808m.'</filename></format><format><formatid>0808m40S</formatid><filename>'.$file_0808m40S.'</filename></format><format><formatid>1616m</formatid><filename>'.$file_1616m.'</filename></format><format><formatid>0808mFull</formatid><filename>'.$file_0808mFull.'</filename></format></formats><parameters><parameter><key>Album</key><value>'.$album.'</value></parameter><parameter><key>Clano</key><value>'.$clano.'</value></parameter><parameter><key>Artist</key><value>'.$keyArtist.'</value></parameter><parameter><key>Music Director</key><value>'.$musicDirector.'</value></parameter><parameter><key>SEARCHKEY</key><value>'.$searchKey.'</value></parameter><parameter><key>Director</key><value>'.$keyDirector.'</value></parameter><parameter><key>Producer</key><value>'.$keyProducer.'</value></parameter><parameter><key>YearOfRelease</key><value>'.$releaseYear.'</value></parameter><parameter><key>AlbumYearOfRelase</key><value>'.$albumYear.'</value></parameter><parameter><key>Genre</key><value>'.$genre.'</value></parameter><parameter><key>Starcast</key><value>'.$starcast.'</value></parameter><parameter><key>Lyricist</key><value>'.$lyricist.'</value></parameter><parameter><key>Singer</key><value>'.$singer.'</value></parameter><parameter><key>Originalcode</key><value>'.$isrc.'</value></parameter></parameters></content>';
		$xml_msg_in = fopen($deploymentFolder."/".$isrc.".xml","w");
		fwrite($xml_msg_in,$xmlBody); 
		fclose($xml_msg_in);
	}
	public function generateRelianceAudioXml(array $a = array() ){
		$songTitle = $a['songTitle'];
		$language = $a['language'];
		$album = $a['album'];
		$keyArtist = $a['keyArtist'];
		$musicDirector = $a['musicDirector'];
		$searchKey = $a['searchKey'];
		$keyDirector = $a['keyDirector'];
		$keyProducer = $a['keyProducer'];
		$releaseYear = $a['releaseYear'];
		$albumYear = $a['albumYear'];
		$genre = $a['genre'];
		$starcast = $a['starcast'];
		$lyricist = $a['lyricist'];
		$singer = $a['singer'];
		$isrc = $a['isrc'];
		$deploymentId = $a['deploymentId'];
		$contentId = $a['contentId'];
		$contentType = '4';
		$ddId = $a['ddId'];
		$providerDetails = json_decode($a['providerDetails'],true);
		$category = $providerDetails['category'];
		$subCategory = $providerDetails['subCategory'];
		$copyright = $providerDetails['copyright'];
		$label = $providerDetails['label'];
		$isFilm = $providerDetails['isFilm'];
		$startDate = $providerDetails['startDate'];
		$endDate = $providerDetails['endDate'];
		$exclusive = $providerDetails['exclusive'];
		$clano = $providerDetails['clano'];
		$WapPreviewAmr=$providerDetails['WapPreviewAmr'];
		$WapPreviewMp3=$providerDetails['WapPreviewMp3'];
		$WapPreviewGif5050=$providerDetails['WapPreviewGif5050'];
		$WapPreviewMp3=$providerDetails['WapPreviewMp3'];
		$WebPreviewGif10180=$providerDetails['WebPreviewGif10180'];
		$WebPreviewGif9696=$providerDetails['WebPreviewGif9696'];
		$FlaObjMp3=$providerDetails['FlaObjMp3'];
		$FlaObjAmr=$providerDetails['FlaObjAmr'];
		$FlaObj140140Jpg=$providerDetails['FlaObj140140Jpg'];
		$FlaObj300300Jpg=$providerDetails['FlaObj300300Jpg'];
		$FlaObj500500Jpg=$providerDetails['FlaObj500500Jpg'];
		$providerCode=$providerDetails['providerCode'];
		$deploymentFolder = $a['deploymentFolder'];
	
		$xmlBody='<?xml version="1.0" encoding="UTF-8"?><fsd><name>'.$songTitle.'</name><provider>Reliance_Saregama</provider><cat>'.$category.'</cat><subcat>'.$subCategory.'</subcat><operator></operator><royalty>'.$copyright.'</royalty><searchkeywords>'.$searchKey.'</searchkeywords><musiclabel>'.$label.'</musiclabel><movie>'.$isFilm.'</movie><album>'.$album.'</album><providercode>'.$isrc.'</providercode><metadata name="starcast" value="'.$starcast.'"/><metadata name="language" value="'.$language.'"/><metadata name="director" value="'.$keyDirector.'"/><metadata name="producer" value="'.$keyProducer.'"/><metadata name="YearOfRelease" value="'.$releaseYear.'"/><metadata name="AlbumYearOfRelease" value="'.$albumYear.'"/><metadata name="Genre" value="'.$category.'"/><metadata name="Lyricist" value="'.$lyricist.'"/><metadata name="MusicDirector" value="'.$musicDirector.'"/><metadata name="Singer" value="'.$singer.'"/><artist>'.$singer.'</artist><cla>'.$clano.'</cla><expiredate>'.$endDate.'</expiredate><activatedate>'.$startDate.'</activatedate><shortdesc>'.$album.'</shortdesc><longdesc>'.$album.'</longdesc><wappreview><file>'.$WapPreviewAmr.'</file><file>'.$WapPreviewMp3.'</file><file_50x50>'.$WapPreviewGif5050.'</file_50x50>
</wappreview><webpreview><file>'.$WapPreviewMp3.'</file><file_101x80>'.$WebPreviewGif10180.'</file_101x80><file_96x96>'.$WebPreviewGif9696.'</file_96x96></webpreview><objects><file>'.$FlaObjMp3.'</file><file>'.$FlaObjAmr.'</file><file_140x140>'.$FlaObj140140Jpg.'</file_140x140><file_300x300>'.$FlaObj300300Jpg.'</file_300x300><file_500x500>'.$FlaObj500500Jpg.'</file_500x500></objects></fsd>';
		$xml_msg_in = fopen($deploymentFolder."/".$isrc.".xml","w");
		fwrite($xml_msg_in,$xmlBody); 
		fclose($xml_msg_in);
	}

	/**********************************************
	*Will update ready status to zip file
	* @param: array 
	**********************************************/
	public function updateReady( array $a = array() ){
		$deploymentId=(int)$a['deploymentId'];
		$isReady=$this->oMysqli->secure($a['isReady']);
		
		$this->sSql = "UPDATE deployment_mstr SET is_ready='".$isReady."' WHERE deployment_id='".$deploymentId."' LIMIT 1";
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	}
	/*********************************************
	* Will DELETE given records
	* @Param: array()
	**********************************************/
	public function deleteDeployDetails( array $a = array() ){
		$id = (int)$a['id'];
		$this->sSql = "DELETE FROM deployment_details WHERE id='".$id."' LIMIT 1";
		return $res = $this->oMysqli->query( $this->sSql );
	}
	/********************************************
	* Will returns image pltform config details
	*@Param: array()
	********************************************/
	public function getImageConfigRel( array $a = array() ){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderBy = ' ORDER BY insert_date DESC '; $where ='';

		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderBy = $a['orderby'];
		}

		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
			
		if( isset($a['where']) && $a['where'] != '' ){
			$where .= $a['where'];
		}
		
		$this->sSql = "SELECT * FROM `image_mstr_config_rel` WHERE 1 $where $orderBy LIMIT $start, $limit";
		$res = $this->oMysqli->query( $this->sSql );
		return $res;
	}
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getSongImageTotalCount( array $a = array() ){
		$where ='';
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
			$where .= " AND  status!='-1' ";
		
		$this->sSql = "SELECT MAX(version) as cnt FROM `image_mstr_config_rel` WHERE 1 $where ";
		$res = $this->oMysqli->query( $this->sSql );
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;
		}
	}
	/**********************************************
	*Will insert/Update info config data
	* @param: array 
	**********************************************/
	public function image_mstr_config_rel( array $a = array() ){
		$imageId=(int)$a['imageId'];
		$configId=(int)$a['configId'];
		$path=$this->oMysqli->secure($a['path']);
		$version=(int)$a['version'];
		
		$this->sSql = "INSERT INTO `image_mstr_config_rel` (`image_id`,`config_id`,`path`,`insert_date`,`status`,`version`) VALUES ('".$imageId."','".$configId."','".$path."', NOW(),1,'".$version."') ON DUPLICATE KEY UPDATE path='".$path."',insert_date=NOW()";
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	}
	/**********************************************
	*Will insert/Update info config data
	* @param: array 
	**********************************************/
	public function video_mstr_config_rel( array $a = array() ){
		$videoId=(int)$a['videoId'];
		$configId=(int)$a['configId'];
		$path=$this->oMysqli->secure($a['path']);
		$version=(int)$a['version'];
		
		$this->sSql = "INSERT INTO `video_mstr_config_rel` (`video_id`,`config_id`,`path`,`insert_date`,`status`,`version`) VALUES ('".$videoId."','".$configId."','".$path."', NOW(),1,'".$version."') ON DUPLICATE KEY UPDATE path='".$path."',insert_date=NOW()";
		$statusid = $this->oMysqli->query( $this->sSql );
		return $statusid;
	}
	/**********************************************
	*Will insert content_master table of WAP db
	* @param: array 
	**********************************************/
	public function saveToWAP( array $a = array() ){
		$type_id = $this->oMysqli->secure( $a['type_id']);
		$category_id= $this->oMysqli->secure( $a['category_id']);
		$sub_cat= $this->oMysqli->secure( $a['sub_cat']);
		$wap_preview= $this->oMysqli->secure( $a['wap_preview']);
		$web_preview= $this->oMysqli->secure( $a['web_preview']);
		$description= $this->oMysqli->secure( $a['description']);
		$search= $this->oMysqli->secure( $a['search']);
		$vendor_id= $this->oMysqli->secure( $a['vendor_id']);
		$valid_upto= $this->oMysqli->secure( $a['valid_upto']);
		$added_on= $this->oMysqli->secure( $a['added_on']);
		$disp_name= $this->oMysqli->secure( $a['disp_name']);
		$active= $this->oMysqli->secure( $a['active']);
		$song_id= $this->oMysqli->secure( $a['song_id']);
		$actoractress= $this->oMysqli->secure( $a['actoractress']);
		$releaseyear= $this->oMysqli->secure( $a['releaseyear']);
		$genre= $this->oMysqli->secure( $a['genre']);
		$mood= $this->oMysqli->secure( $a['mood']);
		$musicdirector= $this->oMysqli->secure( $a['musicdirector']);
		$musiclabel= $this->oMysqli->secure( $a['musiclabel']);
		$rights= $this->oMysqli->secure( $a['rights']);
		$singermusician= $this->oMysqli->secure( $a['singermusician']);
		$cost_ptr= $this->oMysqli->secure( $a['cost_ptr']);
		$ext= $this->oMysqli->secure( $a['ext']);
		$language= $this->oMysqli->secure( $a['language']);
		$lyricist= $this->oMysqli->secure( $a['lyricist']);
		$producer= $this->oMysqli->secure( $a['producer']);
		$director= $this->oMysqli->secure( $a['director']);
		$distribution_rights= $this->oMysqli->secure( $a['distribution_rights']);
		$primary_artist= $this->oMysqli->secure($a['primary_artist']);
		$isrc_code= $this->oMysqli->secure($a['isrc_code']);
		$conn=$a['conn'];
		
		$this->sSql="
INSERT INTO `content_master` 	( 	`type_id`, 	`category_id`, `sub_cat`, 	`wap_preview`, 	`web_preview`, 	`description`, 	`search`, 	`vendor_id`, 	`valid_upto`, 	`added_on`, 	`disp_name`, 	`active`, `song_id`, `actoractress`, 	`releaseyear`, 	`genre`, 	`mood`, `musicdirector`, 	`musiclabel`, 	`rights`, 	`singermusician`, 	`cost_ptr`, 	`ext`, 	`language`, 	`lyricist`, 	`producer`, 	`director`, 	`distribution_rights`, 	`primary_artist`, 	`isrc_code`	)	VALUES	(	'".$type_id."', 	'".$category_id."', 	'".$sub_cat."', 	'".$wap_preview."', 	'".$web_preview."', 	'".$description."', 	'".$search."', 	'".$vendor_id."', '".$valid_upto."', 	'".$added_on."', 	'".$disp_name."', 	'".$active."', 	'".$song_id."', 	'".$actoractress."', 	'".$releaseyear."', 	'".$genre."', '".$mood."', 	'".$musicdirector."', 	'".$musiclabel."', 	'".$rights."', '".$singermusician."', '".$cost_ptr."', 	'".$ext."', 	'".$language."', 	'".$lyricist."', 	'".$producer."', 	'".$director."', 	'".$distribution_rights."', 	'".$primary_artist."', 	'".$isrc_code."'	);
";
		$statusid = $conn->query_global( array('sql'=> $this->sSql) );
		return $statusid;
	}
	public function updateToWAP( array $a = array() ){
		$cont_id = $this->oMysqli->secure( $a['cont_id']);
		$wap_preview= $this->oMysqli->secure( $a['wap_preview']);
		$web_preview= $this->oMysqli->secure( $a['web_preview']);
		$conn=$a['conn'];
		$this->sSql="UPDATE content_master SET wap_preview='".$wap_preview."', web_preview='".$web_preview."' WHERE cont_id='".$cont_id."' LIMIT 1";
		$statusid = $conn->query_global( array('sql'=> $this->sSql) );
		return $statusid;
	}
	public function insertToWAPFLA( array $a = array() ){
		$CONT_ID=$this->oMysqli->secure($a['CONT_ID']);
		$GROUP_ID=$this->oMysqli->secure($a['GROUP_ID']);
		$DISPLAY_NAME=$this->oMysqli->secure($a['DISPLAY_NAME']);
		$FILE_NAME=$this->oMysqli->secure($a['FILE_NAME']);
		$FILE_SIZE= $this->oMysqli->secure($a['FILE_SIZE']);
		$conn=$a['conn'];
		
		$this->sSql="INSERT INTO fla_data(`CONT_ID`, 	`GROUP_ID`, 	`DISPLAY_NAME`, 	`FILE_NAME`, 	`FILE_SIZE`)	VALUES	('".$CONT_ID."', 	'".$GROUP_ID."', 	'".$DISPLAY_NAME."', 	'".$FILE_NAME."', 	'".$FILE_SIZE."');";
		$statusid = $conn->query_global( array('sql'=> $this->sSql) );
		return $statusid;
	}
	public function __toString(){
        return $this->sSql;
    }
}