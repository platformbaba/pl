<?php 

$view = 'audiotools';
$sAudio = new audiotools();

$action = cms::sanitizeVariable(  $_GET['action'] );
$type   = cms::sanitizeVariable( $_GET['type'] );

if($action == "view" ){

		$platform   = cms::sanitizeVariable( $_GET['platform'] );
		
		
		if($type == "ajax"){
			
			$data = $sAudio->getConfigsForPlatform($platform);
			$_rdata= array();
			foreach($data as $d){
				
				$str = $d->song_edit_id.'--'.$d->platform.'--'.$d->format.'--'.$d->audio_bitrate.'--'.$d->sample_rate.'--'.$d->duration_limit;
				array_push($_rdata,$str);
			}
		     	echo json_encode($_rdata);

		
        }else{

			$data = array();
			$aError=array();
		
			if(!empty($_POST) && isset($_POST)){			
			
				$getfromTime=$_POST['getfromTime'];
				$gettoTime=$_POST['gettoTime'];
				$song_id=(int)$_POST['song_id'];
				$config_ids=$_POST['config_ids'];
				$path=cms::sanitizeVariable($_POST['path']);
		
		
				if($getfromTime > $gettoTime){
				  $aError[]="From time should be lesser then To time!";
		        }
					
				if(empty($config_ids)){
					$aError[]="Please select at least one platform/config string!";
				}
			
					$edit_time = $getfromTime."--".$gettoTime;
				
				$postData=array( 
						'song_id'=>$_POST['song_id'],
						'config_ids'=>$_POST['config_ids'],
						'path'=>$_POST['path'],
						'edit_duration'=>$edit_time,
						);
						
			if(empty($aError)){
				$sAudio->addConfigSongsInfo($postData);
				header("location:".SITEPATH."audiotools?action=view&id=".$postData['song_id']."&type=song&msg=Action completed successfully.");
				exit;
		   }
		 }
	 


		$data['aError'] = $aError;
		
		
		$limit	= MAX_DISPLAY_COUNT;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => 'ORDER BY insert_date DESC',  
					'start'   => $start,  
				  );
	
		$data['aContent'] = $sAudio->getEditedSongs($_GET['id'], $params );
	
		
		$_d = $sAudio->getSongDetails($_GET['id'])[0];
		
		$data["songPath"] 	= $_d->path;
		$data["songName"] 	= $_d->name;
		$data["platforms"] 	= $sAudio->getDistinctPlatforms();


		/* Pagination Start Here */
		$oPage = new Paging();
		$oPage->total = $sAudio->getTotalCountEditedSong($_GET['id']);
		$oPage->page = $page;
		$oPage->limit = MAX_DISPLAY_COUNT;
		$oPage->url = "audiotools?action=view&page={page}";
		$iOffset = (($page-1)*MAX_DISPLAY_COUNT);
		$data['sPaging'] = $oPage->render();
		/* Pagination End */
		
		/* render view */		
		$oCms->view( $view, $data );
	
	}
}
