<?php      
$view = 'mapper_list';      
$action = cms::sanitizeVariable( $_GET['action'] );
$action = ($action==''?'view':$action);
$do = cms::sanitizeVariable( $_GET['do'] );
$mAlbum=new album();
$mArtist=new artist();
global $aConfig;
$data['status_options'] = TOOLS::getContentActionTypes( array('type'=>'form') );
$id = cms::sanitizeVariable((int)$_GET['id']);
$srcAlbum = cms::sanitizeVariable( $_GET['srcAlbum'] );
$srcCType	 = cms::sanitizeVariable( $_GET['srcCType'] );

if($action == 'view'){
	$view = 'mapper_album_list';
		/* Publish/Draft/Delete Action Start */
		if(isset($_POST) && !empty($_POST)){
			if($srcCType==1){
				$oAlbumId=(int)$_POST['oAlbumId'];
				$mAlbumId=$_POST['mAlbumId'];
				if($oAlbumId==0){
					$aError[]="Enter Original Album Id!";
				}
				if(empty($mAlbumId)){
					$aError[]="Enter Map Album Id!";
				}
				if($mAlbumId && $oAlbumId && empty($aError)){
					$param=array(
							'albumId' => $oAlbumId,
							'mAlbumId' => $mAlbumId,
							);
					$result=$mAlbum->mapAlbumToOriginal($param);
				}
			}elseif($srcCType==2){
				$oArtistId=(int)$_POST['oArtistId'];
				$mArtistId=$_POST['mArtistId'];
				if($oArtistId==0){
					$aError[]="Enter Original Artist Id!";
				}
				if(empty($mArtistId)){
					$aError[]="Enter Map Artist Id!";
				}
				$mArtistIdCl=array();
				if($mArtistId && $oArtistId && empty($aError)){
					foreach($mArtistId as $mK=>$mV){
						if($mV>0){
							$mArtistIdCl[]=$mV;
						}
					}	
					$wheres=" AND artist_id IN(".implode(",",$mArtistIdCl).")";
					$params = array(
								'limit'	  => 1000,  
								'orderby' => 'ORDER BY insert_date DESC',  
								'start'   => 0,  
								'where'	  => $wheres,
							  );
					$dataAlias = $mArtist->getAllArtists($params );
					if($dataAlias){
						$dataAliasArr=array();
						foreach($dataAlias as $kD=>$kV ){
							$dataAliasArr[]=$kV->artist_name;
						}
						$dataAliasStr=NULL;
						if(sizeof($dataAliasArr)>0){
							$dataAliasStr=implode(",",$dataAliasArr);
						}
						
						if($dataAliasStr){
							$mArtist->updateAlias(array("alias"=>$dataAliasStr,"artistId"=>$oArtistId));
						}
					}
					$param=array(
							'artistId' => $oArtistId,
							'mArtistId' => $mArtistId,
							);
					
					$result=$mArtist->mapArtistToOriginal($param);
					
				}
			}
			$data['aError']=$aError;
			if(empty($aError)){
				$data['aSuccess']=array("Action completed successfully");;
			}	
		}
		/* Publish/Draft/Delete Action End */
		
		/* Search Param start */
		if($srcCType==1){
			$where		 = '';
			if( $srcAlbum != '' ){
				$where .= ' AND album_name like "'.$oMysqli->secure($srcAlbum).'%"';
			}else if( $srcCType != '' ){
				$srcCtypeVal = TOOLS::getContentActionValue( $srcCType );
				$where .= ' AND status ="'.$srcCtypeVal.'" ';
			}
			/* Search Param end */
			
			/* Show Language as List Start */
			$limit	= 10000;
			$page	= (int)$_GET['page'];
			$start	= ( $page>0 ? (($page-1)*MAX_DISPLAY_COUNT) : 0 );
			$params = array(
						'limit'	  => $limit,  
						'orderby' => 'ORDER BY insert_date ASC',  
						'start'   => $start,  
						'where'	  => $where,
					  );
			$aDataArr = $mAlbum->getAllAlbums($params );
			if($aDataArr){
				foreach($aDataArr as $dt){
					$languageArr[$dt->album_id]=$dt->language_id;
				}
				$languageStr=implode(",",$languageArr);
				$mLanguage=new language();
				$lParams = array(
						'limit'	  => 100000,  
						'orderby' => 'ORDER BY language_name ASC',  
						'start'   => 0,  
						'where'   => " AND language_id IN (".$languageStr.")",
				   );
				$languageList=$mLanguage->getAllLanguages($lParams);
				if($languageList){
					foreach($languageList as $l){
						$languageIdArr[$l->language_id]=$l->language_name;
					}
					$data['aLanguage']=$languageIdArr;
				}	
				$data['aContent'] = $aDataArr;
			}
			$view = 'mapper_album_list';
		}elseif($srcCType==2){
			if( $srcAlbum != '' ){
				$where .= ' AND artist_name like "'.$oMysqli->secure($srcAlbum).'%"';
			}
			/* Show Language as List Start */
			$limit	= 10000;
			$start	= 0;
			
			$params = array(
						'limit'	  => $limit,  
						'orderby' => 'ORDER BY insert_date DESC',  
						'start'   => $start,  
						'where'	  => $where,
					  );
			$data['aContent'] = $mArtist->getAllArtists($params );
			if($data['aContent']){
				$roleArr=array();
				$artist_type=$mArtist->getArtistType();
				foreach($data['aContent'] as $aData){	
					$roleVal=$aData->artist_role;
					foreach($artist_type as $kAT => $vAT){
						if(($roleVal&$vAT)==$vAT){
							$roleArr[$aData->artist_id][]=$vAT;
						}
					}
				}
				if($data['aContent']){
					foreach($data['aContent'] as $kAll=>$vAll){
						$aRoleArr=NULL;
						$aRoleArr=$mArtist->getArtistTypeByValue($vAll->artist_role);
						$data['aRole'][$vAll->artist_role]= (sizeof($aRoleArr)>0)?implode(" ,",$aRoleArr):"";
					}
				}
			}		
			$view = 'mapper_artist_list';
		}
		$data['aSearch']['srcAlbum'] 	= $srcAlbum;
		$data['aSearch']['srcCType'] 	= $srcCType;

}
/* render view */
$oCms->view( $view, $data );