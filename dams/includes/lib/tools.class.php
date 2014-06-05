<?php    
/* Tools CLass contain all common functions */

class tools{  
	
	/********************************************
	* Will write log for user activity -- Not in use now
	* @param: 
	*		$moduleName : module name ( eg: album/song/label)
	*		$action : add/edit/delete/publish/draft
	*		$moduleId : key of menu-module array
	*		$editorId : Loggedin UserId
	*		$remark	:	text ( optional )
	********************************************/
	static function log($moduleName, $action, $moduleId, $editorId, $remark = null) {
        global $oMysqli; // need to remove this function
		$ip=tools::getIP();
		$remark = str_replace('approveed', 'approved', $remark); 
		$sSql = "INSERT IGNORE INTO `activity_log` (`module`, `action`, `module_id`, `editor_id`, `remark`, `activity_date`,`ip`) VALUES ('".$moduleName."', '".$action."', '".$moduleId."', '".$editorId."', '".addslashes($remark)."', '".date('Y-m-d H:i:s')."','".$ip."')";
		$statusid = $oMysqli->query($sSql);
		return $statusid;
		
	}
	
	/********************************************
	* Will write log for user activity
	* @param: array
	*		moduleName : module name ( eg: album/song/label)
	*		action : add/edit/delete/publish/draft
	*		moduleId : key of menu-module array
	*		editorId : Loggedin UserId
	*		remark	:	text ( optional )
	*		content_ids : int or array
	********************************************/
	static function writeActivityLog( array $a = array() ) {
        global $oMysqli;
		
		$statusid = 0; 
		$moduleName = $a['moduleName'];
		$action 	= $a['action'];
		$moduleId 	= (int)$a['moduleId'];
		$editorId 	= (int)$a['editorId'];
		$remark 	= ( isset($a['remark'])?$a['remark']:NULL );
		$content_ids = $a['content_ids'];
		$ip=tools::getIP();
		
		$remark = str_replace('approveed', 'approved', $remark); 
		
		if( is_array($content_ids) ){
			foreach( $content_ids as $kk=>$content_id ){
				$sSql = "INSERT IGNORE INTO `activity_log` (`module`, `action`, `module_id`, `editor_id`, `remark`, `activity_date`, `content_id`,`ip`) VALUES ('".$moduleName."', '".$action."', '".$moduleId."', '".$editorId."', '".addslashes($remark)."', '".date('Y-m-d H:i:s')."', '".$content_id."','".$ip."')";
				$statusid = $oMysqli->query($sSql);
			}
		}else{
			$content_id = (int)$content_ids;
			$sSql = "INSERT IGNORE INTO `activity_log` (`module`, `action`, `module_id`, `editor_id`, `remark`, `activity_date`, `content_id`,`ip`) VALUES ('".$moduleName."', '".$action."', '".$moduleId."', '".$editorId."', '".addslashes($remark)."', '".date('Y-m-d H:i:s')."', '".$content_id."','".$ip."')";
			$statusid = $oMysqli->query($sSql);
		}
		return $statusid;
	}
	
	/* getSongPlayUrl -- used on song list page to play song*/
	public static function getSongPlayUrl( array $a = array() ){
		$song_url = '';
		if( $a['song_id'] > '119269' ){
			$song_url = SITEPATH.'media/songs/raw/'.$a['song_file'];
		}else{
			// INH100404199_96_a.mp4 
			$songUrlPart = TOOLS::getSongPath($a['isrc']);
			$song_url = SITEPATH.'media/songs/edits/mp4/akamai/'.$songUrlPart.$a['isrc'].'_96_a.mp4';
		}
		return $song_url;
	
	} /* getSongPlayUrl */
	
	/*to retrieve ip address*/
	static function getIP(){
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
			if (array_key_exists($key, $_SERVER) === true){
				foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip){
					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
						return $ip;
					}
				}
			}
		}
		
	}
	/*get seconds value in standard format*/
	static function format_time($t,$f=':') // t = seconds, f = separator 
	{
	  return sprintf("%02d%s%02d%s%02d", floor($t/3600), $f, ($t/60)%60, $f, $t%60);
	}
	/********************************************
	* Will return link with sorting param 
	********************************************/
	public static function getListSortingUrl( array $a = array() ){
		$field=$a['field'];
		$str = str_replace('&field='.$a['field'],'', $_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI']=$str;
		$url = $_SERVER['REQUEST_URI']."&field=".$field;
		if( isset($_GET['sort']) ){
			 if( $_GET['sort'] == 'asc' ){
				$url = str_replace('sort=asc', 'sort=desc', $url);
			 }else{
				$url = str_replace('sort=desc', 'sort=asc', $url);
			 }
		}else{
			$pos = strpos($url, '?');
			if( $pos === false ){
				$url = $url.'?sort=asc';
			}else{
				$url = $url.'&sort=asc';
			}		
		}
		return $url;
	} /* getListSortingUrl */
	
	public static function getSortbyQueryString( array $a = array() ){
		$sort = '';
		if( $a['field'] !='' && isset($_GET['sort']) ){
			
				 if( $_GET['sort'] == 'asc' ){
					$sort = ' ORDER BY '.$a['field'].' asc';
				 }else{
					$sort = ' ORDER BY '.$a['field'].' desc';
				 }
			
		}else if( $a['default_field'] !='' ){
			$sort = ' ORDER BY '.$a['default_field'].' '.$a['default_sort'];
		}
		
		return $sort;
	}
	
	/* Will return Album Type Test */
	public static function getAlbumTypeText( array $a = array() ){
		$aConfig;
		$str = '';
		if( ($a['album_type']&1) == 1 ){ $str .= ' Film,'; }else{ $str .= ' Non Film,'; }
		if( ($a['album_type']&2) == 2 ){ $str .= ' Original,'; }else{ $str .= ' Compiled,'; }
		if( ($a['album_type']&4) == 4 ){ $str .= ' Digital'; }
		return $str;
	}
	
	/********************************************
	* Will return Action Value 0/1/-1
	* @param: string ActionName ( draft/publish/delete )
	********************************************/
	public static function getContentActionValue( $str ){
		global $aConfig;
		$check = array_flip($aConfig['status-options']);

		if( isset($check[strtolower($str)]) ){
			return (string)$check[strtolower($str)];
		}else{
			return '';
		}
		
	} /* getContentActionValue */
	
	
	/********************************************
	* Will return Action Type 0/1/-1
	* @param: array()
	*			type: form (optional)
	********************************************/
	public static function getContentActionTypes( array $a = array() ){
		global $aConfig;
		$tmpConfig=$aConfig['status-options'];
		if( $a['type'] == 'form' ){
			array_pop($tmpConfig);
		}
		if( $a['flow'] != 'legal' ){
			unset($tmpConfig[2]);
			unset($tmpConfig[3]);
		}
		array_walk_recursive($tmpConfig, 'TOOLS::my_upper_case');
		return $tmpConfig;		

	} /* getContentActionValue */
	
	public static function my_upper_case(&$value, $key){
		$value = ucwords($value);
		return $value;
	}
	
	
	/********************************************
	* Will return Action Type 0/1/-1
	* @param: array()
	*			type: success/error/warning/info/tip
				msg:  array{ What msg you want to show }
	********************************************/
	public static function showNotification( array $a = array() ){
		global $aConfig; 
		$retStr = '';		
		$type = strtolower(trim($a['type']));
		$tmpArr = array( 'success'=>'Success', 'error'=>'Error', 'warning'=>'Warning', 'info'=>'Information', 'tip'=>'Tips' );
		
		if( array_key_exists($type, $tmpArr) ){
			$retStr .= '<div class="notif '.$type.' bloc">';
			foreach($a['msg'] as $k=>$msg){
				$retStr .= '<strong>'.$tmpArr[$type].' :</strong> '.trim($msg).'<br/>'; 
			}
			$retStr .= '<a href="#" class="close"></a>
						</div>';
		}
		echo $retStr;
	} /* showNotification */
	
	/************************************************
	* Will return check box Html
	* @param: array()
	*			id: content_id
	*			status: content_status
	*			flow: legal (optional) 
	************************************************/
	public static function displayCheckBoxList( array $a = array() ){
		global $aConfig;
		$obj=$a['obj']; 
		$aConfig['flow'];
		$retStr = '';
		if( (int)$a['id'] > 0 ){
			if( $a['flow'] != 'legal' ){
				$retStr = '<input type="checkbox" class="checkBoxCls" value="'.(int)$a['id'].'" name="select_ids[]" />';
			}else{
				if($obj->user->hasPrivilege(strtolower(MODULENAME)."_".$aConfig['flow'][(int)$a['status']]['perm'])){	
					$retStr = '<input type="checkbox" class="checkBoxCls" value="'.(int)$a['id'].'" name="select_ids[]" />';
				}
			}
		}	
		echo $retStr;
	} /* displayCheckBoxList */
	
	
	/**********************************************
	* Will return string to display album content types
	*
	**********************************************/
	public static function displayAlbumContentTypesStr( $albumContentType ){
		global $aConfig;
		$retStr = '';
		
		if( $albumContentType > 0 ){
			foreach( $aConfig['album_content_type'] as $kkk=>$vvv ){
				if( ($albumContentType&$kkk) == $kkk ){
					$retStr .= ', '.$vvv;
				}
			}
		}
		
		$retStr = trim( $retStr, ',' );
		return $retStr;
	} /* displayAlbumContentTypesStr */
	
	/**********************************************
	* Will return multi Action drop-down
	* @param: obj
	**********************************************/
	public static function displayMultiActionHtml( $obj, $a = array() ){
		$retStr = '';
		$retStr .= '<div class="left input">';
            $retStr .= '<select name="act" id="tableaction" onchange="cms.callMultiAction(this.value)">';
                $retStr .= '<option value="">Action</option>';
							//$actionArr = TOOLS::getContentActionTypes( array('type'=>'form', 'flow'=>$a['flow'] ) );
							 
							if( $a['flow'] != 'legal' ){
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
									$retStr .= '<option value="publish">Final Approve</option>';
								}
																
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
									$retStr .= '<option value="draft">Draft</option>';
								}
							}else{
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_qc")){	
									$retStr .= '<option value="qc-approve">QC Approve</option>';
								}	
								 
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
									$retStr .= '<option value="legal-approve">Legal Approve</option>';
								}
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_qc")){	
									$retStr .= '<option value="draft">QC Unapprove</option>'; 
								}
									
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
									$retStr .= '<option value="publish">Publish</option>';
								}
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
									$retStr .= '<option value="qc-approve">Legal Unapprove</option>';
								}
									
								if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
									$retStr .= '<option value="legal-approve">Draft</option>';
								}			
							}
            $retStr .= '</select>';
        $retStr .= '</div>';	
		echo $retStr;
	} /* displayMultiActionHtml */
	
	/**********************************************
	* Will return Action Html
	* @param: obj
	**********************************************/
	public static function displayActionHtml( $obj, $a = array() ){
		$retStr = '';
		if ($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish") || $obj->user->hasPrivilege(strtolower(MODULENAME)."_legal") || $obj->user->hasPrivilege(strtolower(MODULENAME)."_qc")){
			if( $a['flow'] != 'legal' ){
				if( $a['status'] == 1 ){ 
					$retStr .= '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"draft"})\' title="UnPublish this content"><img src="'.IMGPATH.'icons/publish.gif" alt="" /></a>';
				
				}else{
					$retStr .= '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"publish"})\' title="Final Approve this content"><img src="'.IMGPATH.'icons/draft.gif" alt="" width="23" /></a>';
				}
			}else{
				if( $a['status'] == 1 ){
					$retStr .= '<a href="javascript:void(0)" onclick="jQuery(\'#lclick_'.$a['id'].'\').show();" title="Click here"><img src="'.IMGPATH.'icons/publish.gif" alt="" /></a>';
				}else if( $a['status'] == 2 ){
					$retStr .= '<a href="javascript:void(0)" onclick="jQuery(\'#lclick_'.$a['id'].'\').show();" title="Click here"><img src="'.IMGPATH.'icons/legal.png" alt="" width="23" /></a>';
				
				}else if( $a['status'] == 3 ){
					$retStr .= '<a href="javascript:void(0)" onclick="jQuery(\'#lclick_'.$a['id'].'\').show();" title="Click here"><img src="'.IMGPATH.'icons/legala.png" alt="" width="23" /></a>';
				}else{
					$retStr .= '<img src="'.IMGPATH.'icons/draft.gif" alt="" onclick="jQuery(\'#lclick_'.$a['id'].'\').show();" title="Click here" style="cursor:pointer" />';
				}
			
				$upStatus = ($a['status']==0)?"checked":"";
				$pStatus = ($a['status']==1)?"checked":"";
				$uStatus = ($a['status']==2)?"checked":"";
				$aStatus = ($a['status']==3)?"checked":"";

				$retStr .='<div id="lclick_'.$a['id'].'" style="border: 1px solid black; padding: 5px; width: 175px; background-color: white; position: absolute; z-index: 998; display: none; margin-top: -50px; margin-left: -145px;text-align:left;"><img src="'.IMGPATH.'icon_close.png" alt="Close" onclick="jQuery(\'#lclick_'.$a['id'].'\').hide();" style="float:right;cursor:pointer"/>';
				
				if( $a['status'] == 0 ){
					if($obj->user->hasPrivilege(strtolower(MODULENAME)."_qc")){	
						$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status2" value="2" '.$uStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"qc-approve"})\' /> QC Approve<br/>';
					}else{
						$retStr .="NO ACTION";
					}	
				}elseif( $a['status'] == 2 ){
					if($obj->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
						$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status3" value="3" '.$aStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"legal-approve"})\' /> Legal Approve';
					}elseif($obj->user->hasPrivilege(strtolower(MODULENAME)."_qc")){	
						$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status0" value="0" '.$upStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"draft"})\' /> QC Unapprove<br/>';
					}else{
						$retStr .="NO ACTION";
					}	
				}elseif( $a['status'] == 3 ){
					if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
						$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status1" value="1" '.$pStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"publish"})\'/> Final Approve<br/>';
					}elseif($obj->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
						$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status2" value="2" '.$uStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"qc-approve"})\' /> Legal Unapprove<br/>';
					}else{
						$retStr .="NO ACTION";
					}	
				}elseif( $a['status'] == 1 ){
					if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
						$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status3" value="3" '.$uStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"legal-approve"})\' /> Draft<br/>';
					}else{
						$retStr .="NO ACTION";
					}			
				}
				/*if($obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){	
					$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status1" value="1" '.$pStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"publish"})\'/> Publish<br/>';
				}
				if($obj->user->hasPrivilege(strtolower(MODULENAME)."_qc")){	
					$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status2" value="2" '.$uStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"legal-unapprove"})\' /> QC Approved<br/>';
				}
				if($obj->user->hasPrivilege(strtolower(MODULENAME)."_legal")){	
					$retStr .='<input type="radio" name="status_'.$a['id'].'" id="status3" value="3" '.$aStatus.' onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"legal-approve"})\' /> Legal Approved';
				}	*/
				$retStr .='</div>';
			}
		}else{
			if( $a['status'] == 1){ 
				$retStr .= '<img src="'.IMGPATH.'icons/publish.gif" alt="" />';
			}else if( $a['status'] == 2 ){
				$retStr .= '<img src="'.IMGPATH.'icons/legal.png" alt="" width="23" />';
			}else if( $a['status'] == 3 ){
				$retStr .= '<img src="'.IMGPATH.'icons/legala.png" alt="" width="23" />';
			}else{
				$retStr .= '<img src="'.IMGPATH.'icons/draft.gif" alt="" />';
			}
		}

		if( $a['status'] == 1 ){
			if ($obj->user->hasPrivilege(strtolower(MODULENAME)."_edit") && $obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
				$retStr .= '<a href="'.SITEPATH.strtolower($a['model']).'?action=edit&id='.$a['id'].'" title="Edit this content"><img src="'.IMGPATH.'icons/edit.png" alt="" /></a>';
			} 
			if ($obj->user->hasPrivilege(strtolower(MODULENAME)."_delete") && $obj->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
				$retStr .= '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"delete"})\' title="Delete this content"><img src="'.IMGPATH.'icons/delete.png" alt="" /></a>';
			}
		}else{		
			if ($obj->user->hasPrivilege(strtolower(MODULENAME)."_edit")){
				$retStr .= '<a href="'.SITEPATH.strtolower($a['model']).'?action=edit&id='.$a['id'].'" title="Edit this content"><img src="'.IMGPATH.'icons/edit.png" alt="" /></a>';
			} 
			if ($obj->user->hasPrivilege(strtolower(MODULENAME)."_delete")){
				$retStr .= '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$a['id'].', "model":"'.$a['model'].'", "action":"delete"})\' title="Delete this content"><img src="'.IMGPATH.'icons/delete.png" alt="" /></a>';
			}
		}
		
		echo $retStr;
	} /* displayActionHtml */
	
	
	/**************************************
	* Display View Contents Tabs
	**************************************/
	public static function displayViewTabsHtml( array $a = array() ){
		global $aConfig;
		
		$relatedCType = $a['relatedCType'];
		$cType = $a['cType'];
		$cTitle = $a['title'];
		$id = $a['id'];
		$tab = ( isset($a['tab'])? $a['tab']:'' );
		
		$retStr	= '';
		$retStr .= "<div class='title'>";
						if( $tab == 'logs' ){
							$retStr .= "Change Logs</span>";
						}else if( $relatedCType != '' ){
							$retStr .= "<span class='FL'>".ucfirst( $aConfig['module'][$relatedCType] )." Lists (".$a['contentCount'].") </span>";
						}elseif($cTitle!=""){
							$retStr .= "<span class='FL'>".ucfirst( $cTitle )."</span>";
						}else{
							$retStr .= "<span class='FL'>".ucfirst( $aConfig['module'][$cType] )." Details</span>";
						}
						$retStr .= "<span class='FR'>";
			 
				$buttonColor = 'white';
				if( $relatedCType == 0 && $tab==''){ $buttonColor=''; }
				$retStr .= "<a class='button MR30 ".$buttonColor."' href='".SITEPATH.$aConfig['module'][$cType]."?action=view&isPlane=1&do=details&id=".$id."'>Detail View</a>";
				
				if( !empty($aConfig['related-contents'][$cType]) ){
					foreach( $aConfig['related-contents'][$cType] as $kk => $vv ){
						$buttonColor = 'white';
						if( $vv == $relatedCType ){ $buttonColor=''; }
						$retStr .= "<a class='button MR30 ".$buttonColor."' href='".SITEPATH."related?action=view&isPlane=1&cType=".$cType."&relatedCType=".$vv."&id=".$id."'>".ucfirst($aConfig['module'][$vv])."</a>";
						
					}
				}
				$buttonColor = 'white';
				if( $tab == 'logs' ){ $buttonColor=''; }
				$retStr .= "<a class='button MR30 ".$buttonColor."' href='".SITEPATH."dashboard?do=activity-pop&isPlane=1&id=".$id."&cType=".$cType."'>Logs</a>";
				
				if($cType==4){//only for song
					$buttonColor='white';
					if( $tab == 'deployment' ){ $buttonColor=''; }
					$retStr .= "<a class='button MR30 ".$buttonColor."' href='".SITEPATH.$aConfig['module'][$cType]."?action=view&isPlane=1&do=depldetl&id=".$id."&cType=".$cType."'>Deployment Report</a>";	
				}
				if($a['back']==1){
					$retStr .= "<a class='button MR30 white' href='javascript:void(0);' onclick='window.history.back();'>Back</a>";
				}
				$retStr .= "</span>";
				$retStr .= "<br class='clear' />";
				$retStr .= "</div>";	
				echo $retStr;
	} /* displayViewTabsHtml */
	
	/**************************************
	* Will return Logged in user id
	**************************************/
	public static function getEditorId(){
		return (int)Encryption::dec($_COOKIE['edtid']);
	}
	/* Retuens Image Type eg: wallpaper/animation */
	public static function getImageTypes( array $a = array() ){
		global $aConfig;
		return $aConfig['image_type'];
	}
	
	/* Retuens Text Type eg: SMS/TRIVIA */
	public static function getTextTypes( array $a = array() ){
		global $aConfig;
		return $aConfig['text_type'];
	}

	/* Retuens Event Type eg: birth,diwali,holi,eid, */
	public static function getEventsTypes( array $a = array() ){
		global $aConfig;
		return $aConfig['calendar_event'];
	}

	/* Return Event Type by Id */
	public static function display_event_type( $id ){
		global $aConfig;
		$retStr = '';
		foreach( $aConfig['calendar_event'] as $k=>$v ){
			if( ($id&$k) == $k ){ $retStr = $v; }
		}
		$retStr = trim($retStr);
		return $retStr;
	}

	/* Return Image Type by Id */
	public static function display_image_type( $id ){
		global $aConfig;
		$retStr = '';
		foreach( $aConfig['image_type'] as $k=>$v ){
			if( ($id&$v) == $v ){ $retStr .= $k.', '; }
		}
		$retStr = trim($retStr, ',');
		return $retStr;
	}

	/* Return Text Type by Id */
	public static function display_text_type( $id ){
		global $aConfig;
		$retStr = '';
		foreach( $aConfig['text_type'] as $k=>$v ){
			if( ($id&$v) == $v ){ $retStr = $k; }
		}
		$retStr = trim($retStr);
		return $retStr;
	}
	
	/* to display image*/
	public static function getImage(array $a = array()){
	
		$simage=IMGPATH.'noimage.jpg';
		if( $a['img'] != '' ){
			$simage=MEDIA_SITEPATH_IMAGE.$a['img'];	
		}
		
		return $simage;
    }
	
	/*set theme*/
	public static function getTheme(array $a= array()){
		if(!empty($_GET['c'])){
			setcookie("cTheme",$_GET['c'],time()+(60*60*24*365),"/");
		}
		if( $_COOKIE['cTheme']!= '' ){
			$cTheme=$_COOKIE['cTheme'];
		}else{
			$cTheme='white';
		}
		return $cTheme;
	} 	
	/*
		HUMAN READABLE FILE SIZE
	*/
	public static function humanFilesize($bytes, $decimals = 2) {  
      $sz = 'BKMGTP';  
      $factor = floor((strlen($bytes) - 1) / 3);  
      return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];  
    }  
	/**********************************
	* will upload to ftp
	* @param : string ( filename )
	**********************************/
	public static function ftpUploadFolder(array $a=array()){
		$ftp_server=$a['ftp_server'];
		$ftp_user_name=$a['ftp_user_name'];
		$ftp_user_pass=$a['ftp_user_pass'];
		$dst_dir=$a['dst_dir'];
		$src_dir=$a['src_dir'];
		$mov_dir=$a['mov_dir'];
		try{
			// set up basic connection
			$conn_id = ftp_connect($ftp_server);
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			ftp_pasv($conn_id, true);
		}catch(Exception $e){
		  	$msg=$e->getMessage();
		}
	  	try{
			if(is_dir("ftp://".$ftp_user_name.":".$ftp_user_pass."@".$ftp_server."/".$dst_dir)){
		  		//ftp_rmdir($conn_id, $dst_dir."/");
				tools::recursiveDelete($conn_id, $dst_dir."/");
			}
		}catch(Exception $e){
		  	$msg=$e->getMessage();
		}
		@ftp_mkdir($conn_id, $dst_dir);
		try{
		  	$msg=tools::ftp_putAll($conn_id, $src_dir, $dst_dir);
		}catch(Exception $e){
		  	$msg=$e->getMessage();
		}
		if($msg==1){
			try{
				if(is_dir("ftp://".$ftp_user_name.":".$ftp_user_pass."@".$ftp_server."/".$mov_dir)){
		  			//ftp_rmdir($conn_id, $dst_dir."/");
					tools::recursiveDelete($conn_id, $mov_dir."/");
				}
				ftp_rename($conn_id, $dst_dir."/", $mov_dir."/");
				$msg=1;
			}catch(Exception $e){
				$msg=$e->getMessage();
			}
		}
		return $msg;
	}
	public static function ftp_putAll($conn_id, $src_dir, $dst_dir) {
		$d = dir($src_dir);
		while($file = $d->read()) { // do this for each file in the directory
			if ($file != "." && $file != "..") { // to prevent an infinite loop
				if (is_dir($src_dir."/".$file)) { // do the following if it is a directory
					if (!@ftp_chdir($conn_id, $dst_dir."/".$file)) {
						ftp_mkdir($conn_id, $dst_dir."/".$file); // create directories that do not yet exist
					}
					ftp_putAll($conn_id, $src_dir."/".$file, $dst_dir."/".$file); // recursive part
				} else {
					$msg="Error in uploading file ".$src_dir."/".$file;
					if(ftp_put($conn_id, $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY)){ // put the files
						$msg="1";
					}
				}
			}
		}
		$d->close();
		return $msg;
	}
	public static function recursiveDelete($handle, $directory)
	{
		# here we attempt to delete the file/directory
		if( !(@ftp_rmdir($handle, $directory) || @ftp_delete($handle, $directory)) )
		{            
			# if the attempt to delete fails, get the file listing
			$filelist = @ftp_nlist($handle, $directory);
			// var_dump($filelist);exit;
			# loop through the file list and recursively delete the FILE in the list
			foreach($filelist as $file) {            
				tools::recursiveDelete($handle, $file);            
			}
			tools::recursiveDelete($handle, $directory);
		}
	}
	/**********************************
	* will remove all special chars
	* @param : string ( filename )
	**********************************/
	public static function cleanFileName($string = '', $is_filename = FALSE){
		 /* Replace all weird characters with dashes */
		 $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);
		 $newstr = str_replace('.', '-', $string);
		 $newstr = $newstr.'_'.time();
		 /* Only allow one dash separator at a time (and make newstr lowercase) */
		 return mb_strtolower(preg_replace('/--+/u', '-', $newstr), 'UTF-8');
	}
	
	/**********************************
	* will remove all special chars
	* @param : string ( filename )
	**********************************/
	public static function cleaningName($string = '', $is_filename = FALSE){
		 /* Replace all weird characters with dashes */
		 $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);
		 $string = $string;
		 /* Only allow one dash separator at a time (and make string lowercase) */
		 return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
	}
	
	/**********************************
	* will remove all special chars only
	* @param : string ( filename )
	**********************************/
	public static function removeSpChars($string = '', $is_filename = FALSE){
		 /* Replace all weird characters with dashes */
		 $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '', $string);
		 $string = $string;
		 /* Only allow one dash separator at a time (and make string lowercase) */
		 return preg_replace('/--+/u', '', $string);
	}
	
	/* get deployment folder name*/
	public static function deploymentFolderName(array $a= array()){
		$fName=$a['name'];
		return tools::removeSpChars(str_replace(" ","",ucwords(strtolower($fName))));
	}
	/**********************************
	* will return imagepath by doing hash
	* @param : string ( filename )
	**********************************/
	public static function getImagePath($filename) {
		$aFileName = pathinfo($filename);
		$sHashPath = md5($aFileName['filename']);
		return substr($sHashPath,0,1)."/".substr($sHashPath,-2)."/".substr($sHashPath,1,2)."/";
	}
	
	/**********************************
	* will return songpath 
	* @param : string ( isrc )
	**********************************/
	public static function getSongPath( $isrc ) {
		return substr($isrc,-2)."/";
	}
	/**********************************
	* will return songpath 
	* @param : string ( isrc )
	**********************************/
	public static function getSongPathByIsrc($isrc,$ext) {
		return $fileToSave=$ext."/".tools::getSongPath($isrc).$isrc.".".$ext;
	}
	/**********************************
	* will return videopath 
	* @param : string ( isrc )
	**********************************/
	public static function getVideoPathByTitle($title,$ext,$id) {
		return $fileToSave=strtolower($ext."/".substr(trim($title),0,2)."/".tools::cleaningName($title)."-".$id.".".$ext);
	}
	/**********************************
	* will return image edits path 
	* @param : string ( filename )
	**********************************/
	public static function getImageEditsPath($filename) {
		return MEDIA_SITEPATH_IMAGEEDITS.$filename;
	}
	/**********************************
	* will return video edits path 
	* @param : string ( filename )
	**********************************/
	public static function getVideoEditsPath($filename) {
		return MEDIA_SITEPATH_VIDEOEDITS.$filename;
	}
	/**********************************
	* will return image path 2 char 
	* @param : string ( isrc )
	**********************************/
	public static function getImagePathChar(array $a=array() ) {
		$title=str_replace("_","",str_replace("-","",tools::cleaningName($a['title'])));
		$length=$a['length'];
		return substr($title,0,$length);
	}
	
	public static function createDir( $path ){
		$path_parts = pathinfo($path);

		$exp=explode("/",$path_parts['dirname']);
		$way='';
		foreach($exp as $n){
			$way.=$n.'/';
			if(!file_exists($way)){
				mkdir($way);
				chmod($way, 0777); 
			}
		}
	} 
	
	/************************************************
	* Wrapper function to upload images 
	* @param: imagefile - uploaded image file
	*		  showLog	- debug (default: false)
	* @return: array()
	* 			image - full image name to be saved in db.
	************************************************/
	public static function saveImage($imageFile, $showLog = false){
		global $aConfig;
		$sImageSavedName = ''; $aImageData = array();
		if( !empty($imageFile) ){
			$aFileName = pathinfo($imageFile['name']);
		//	print_r($aFileName);exit;
			if(in_array(strtolower($aFileName['extension']),$aConfig['image_ext'])){
			
			#echo $aFileName['filename'];echo "<br/>";
				$cleanFileName	= TOOLS::cleanFileName($aFileName['filename'], true);#echo "<br/>";
			//	echo $cleanFileName;exit;
				$sNewDirPath 	= TOOLS::getImagePath($cleanFileName);
				$oImages 		= new Images($imageFile['tmp_name']);
				
				$sTempImagePath		= MEDIA_SEVERPATH_IMAGE.$sNewDirPath.$cleanFileName.".".$aFileName["extension"];
				
				$sImageSavedName	= $oImages->save($sTempImagePath,1, 100, 777);
				
				$aImageData['image']	 = $sNewDirPath.$sImageSavedName;
				$aImageData['basename']	 = $sImageSavedName;
				$aImageData['filename']	 = $cleanFileName;
				$aImageData['extension'] = $aFileName["extension"];
				$aImageData['dirname']	 = $sNewDirPath;
				
				/*
				foreach ($cnf['image_sizes'] as $k=>$v){
					$sResizeImageSize = MEDIA_SEVERPATH.$sNewDirPath.$cleanFileName."_".$v['symbol'].".".$aFileName['extension'];
					
					if($showLog)
					echo(date("YmdHis")."|Line".__LINE__."|Resizing Image of  = ".$v['width']."x".$v['height'].chr(10))."<br/>";
					
					if($oImages->resize($v['width'], $v['height']) ) {
						if(($oImages->image_info[0]/$oImages->image_info[1]) == ($v['width'] / $v['height'])) {
							$oImages->save($sResizeImageSize, 1, 100, 775); // Save Path
							if($showLog)
							echo(date("YmdHis")."|Line".__LINE__."|Resized successfully for  = ".$v['width']."x".$v['height'].chr(10));
						} else {
							if($showLog)
							echo(date("YmdHis")."|Line".__LINE__."|Ratio Mismatch  Original Ratio =".($oImages->image_info[0]/$oImages->image_info[1])." - New Ratio = ".($v['width']/$v['height']).chr(10));
						}
					}#if resize
				} #foreach
				*/
			}else{
				$aImageData['error']	 = "Upload Image file.";
			}#if extension
		} #if image
		
		return $aImageData;
	}
	
	
	/************************************************
	* Wrapper function to upload All type of documents 
	* @param: imagefile - uploaded text file
	*		  showLog	- debug (default: false)
	* @return: array()
	* 			doc - full text name to be saved in db.
	************************************************/
	public static function saveDocument($docFile, $showLog = false){
		global $aConfig;
		$sDocSavedName = ''; $aDocData = array();
		$permissions =777;
		if( !empty($docFile) ){
			$aFileName = pathinfo($docFile['name']);
			if(in_array(strtolower($aFileName['extension']),$aConfig['image_ext']) || in_array(strtolower($aFileName['extension']),$aConfig['doc_ext'])){
			
				$cleanFileName	= TOOLS::cleanFileName($aFileName['filename'], true);	
				$sNewDirPath 	= TOOLS::getImagePath($cleanFileName);
				$sTempDocPath	= MEDIA_SEVERPATH_DOC.$sNewDirPath.$cleanFileName.".".$aFileName["extension"];
					if( $permissions != null) {
						chmod($sTempDocPath, 0777);
					} 
		
					$aPath = pathinfo(strtolower($sTempDocPath));
					$exp=explode("/",$aPath['dirname']);
					$way='';
					foreach($exp as $n){
					  $way.=$n.'/';
					  if(!file_exists($way))
					    mkdir($way);
				    }
				move_uploaded_file($docFile['tmp_name'],$sTempDocPath);
				$aDocData['doc']		 = $sNewDirPath.$cleanFileName.".".$aFileName["extension"];
				/*$aDocData['basename']	 = $sDocSavedName;
				$aDocData['filename']	 = $cleanFileName;
				$aDocData['extension']	 = $aFileName["extension"];
				$aDocData['dirname']	 = $sNewDirPath;*/
			}else{
				$aDocData['error']	 = "Upload doc file.";
			}#if extension
		} #if txt
		
		return $aDocData;
	}
	/* to display doc*/
	public static function getDoc(array $a = array()){
		$sDoc=MEDIA_SITEPATH_DOC.$a['doc'];	
		return $sDoc;
    }
	
	public static function saveAudioEdits(array $a = array()){
		global $aConfig;
		$uFile = $a['uFile'];
		$file = $a['file'];
		$tmpFile = $a['tmpFile'];
		$oFile = $a['oFile'];
		$sDocSavedName = ''; $aDocData = array();
		$permissions =777;
		if( !empty($file) ){
			$aFileName = pathinfo($uFile);
			if(in_array(strtolower($aFileName['extension']),$a['ext'])){
				$sTempAudioPath	= MEDIA_SERVERPATH_SONGEDITS.$oFile;
					/*if( $permissions != null) {
						chmod($sTempAudioPath,777);
					}*/
					//chmod($sTempAudioPath,0777); 
					$aPath = pathinfo($sTempAudioPath);
					$exp=explode("/",$aPath['dirname']);
					$way='';
					foreach($exp as $n){
					  $way.=$n.'/';
					  if(!file_exists($way))
					    mkdir($way,0777);
				    }
				if(move_uploaded_file($tmpFile,$sTempAudioPath)){
					$aDocData['audio']		 = $sTempAudioPath;
					chmod($sTempAudioPath,0777);
					/*$aDocData['basename']	 = $sDocSavedName;
					$aDocData['filename']	 = $cleanFileName;
					$aDocData['extension']	 = $aFileName['extension'];
					$aDocData['dirname']	 = $sNewDirPath;*/
				}else{
					$lastError=error_get_last();
					$aDocData['error']		 = $lastError['message'];
				}
			}else{
				$aDocData['error']	 = "Upload Specified Extention File.";
			}#if extension
		} #if txt
		
		return $aDocData;
	}
	public static function saveImageEdits(array $a = array()){
		global $aConfig;
		$uFile = $a['uFile'];
		$file = $a['file'];
		$tmpFile = $a['tmpFile'];
		$oFile = $a['oFile'];
		$sDocSavedName = ''; $aDocData = array();
		$permissions =777;
		if( !empty($file) ){
			$aFileName = pathinfo($uFile);
			if(in_array(strtolower($aFileName['extension']),$a['ext'])){
				$sTempAudioPath	= MEDIA_SERVERPATH_IMAGEEDITS.$oFile;
					/*if( $permissions != null) {
						chmod($sTempAudioPath,777);
					}*/ 
					$aPath = pathinfo($sTempAudioPath);
					$exp=explode("/",$aPath['dirname']);
					$way='';
					foreach($exp as $n){
					  $way.=$n.'/';
					  if(!file_exists($way))
					    mkdir($way,0777);
				    }
				if(move_uploaded_file($tmpFile,$sTempAudioPath)){
					$aDocData['image']		 = $sTempAudioPath;
				}else{
					$aDocData['error']		 = "File not uploaded!";
				}
			}else{
				$aDocData['error']	 = "Upload Specified Extention File.";
			}#if extension
		} #if txt
		
		return $aDocData;
	}
	public static function uploadFiles(array $a = array()){
		global $aConfig;
		$uFile = $a['uFile'];
		$file = $a['file'];
		$tmpFile = $a['tmpFile'];
		$oFile = $a['oFile'];
		$sDocSavedName = ''; $aDocData = array();
		$permissions =777;
		if( !empty($file) ){
			$aFileName = pathinfo($uFile);
			if(in_array(strtolower($aFileName['extension']),$a['ext'])){
				$sTempAudioPath	= $oFile;
					/*if( $permissions != null) {
						chmod($sTempAudioPath,777);
					}*/ 
					$aPath = pathinfo($sTempAudioPath);
					$exp=explode("/",$aPath['dirname']);
					$way='';
					foreach($exp as $n){
					  $way.=$n.'/';
					  if(!file_exists($way))
					    mkdir($way,0777);
				    }
				if(move_uploaded_file($tmpFile,$sTempAudioPath)){
					$aDocData['file']		 = $sTempAudioPath;
				}else{
					$aDocData['error']		 = "File not uploaded!";
				}
			}else{
				$aDocData['error']	 = "Upload Specified Extention File.";
			}#if extension
		} #if txt
		return $aDocData;
	}
	public static function copyAudioFile(array $a = array()){
			$source = $a['source'];
			$source = $a['destination'];
	}
	public static function saveVideoEdits(array $a = array()){
		global $aConfig;
		$uFile = $a['uFile'];
		$file = $a['file'];
		$tmpFile = $a['tmpFile'];
		$oFile = $a['oFile'];
		$sDocSavedName = ''; $aDocData = array();
		$permissions =777;
		if( !empty($file) ){
			$aFileName = pathinfo($uFile);
			if(in_array(strtolower($aFileName['extension']),$a['ext'])){
				$sTempAudioPath	= MEDIA_SERVERPATH_VIDEOEDITS.$oFile;
					/*if( $permissions != null) {
						chmod($sTempAudioPath,777);
					}*/ 
					$aPath = pathinfo($sTempAudioPath);
					$exp=explode("/",$aPath['dirname']);
					$way='';
					foreach($exp as $n){
					  $way.=$n.'/';
					  if(!file_exists($way))
					    mkdir($way,0777);
				    }
				if(move_uploaded_file($tmpFile,$sTempAudioPath)){
					$aDocData['video']		 = $sTempAudioPath;
				}else{
					$aDocData['error']		 = "File not uploaded!";
				}
			}else{
				$aDocData['error']	 = "Upload Specified Extention File.";
			}#if extension
		} #if txt
		
		return $aDocData;
	}
	public static function listDirectory($dir){
		$result = array();
		$root = scandir($dir);
		foreach($root as $value) {
		  if($value === '.' || $value === '..') {
			continue;
		  }
		  if(is_file("$dir$value")) {
			$result[] = "$dir$value";
			continue;
		  }
		  if(is_dir("$dir$value")) {
			$result[] = "$dir$value/";
		  }
		  foreach(self::listDirectory("$dir$value/") as $value)
		  {
			$result[] = $value;
		  }
		}
		return $result;
	}
	public static function deployedFileName(array $a = array()){
		$albumTitle=$a['albumTitle'];
		$songTitle=$a['songTitle'];
		$totalFileName=NULL;
		$limit=$a['limit'];
		$splitAlNameArr=explode(" ",ucwords($albumTitle));
		$firstLetterOfAlbumArr=array();;
		foreach($splitAlNameArr as $nA){
			$firstLetterOfAlbumArr[]=substr($nA,0,1);
		} 
		$firstLetterOfAlbum=NULL;
		$firstLetterOfAlbum=implode("",$firstLetterOfAlbumArr);
		$trackNameWtChar=tools::removeSpChars(ucwords(strtolower($songTitle)));
		$totalFileName=tools::removeSpChars($firstLetterOfAlbum)."_".$trackNameWtChar;
		$strlen=strlen($totalFileName);
		if($strlen>$limit){
			$rmLen=$strlen-$limit;
			$totalFileName=substr($totalFileName,0,-$rmLen);
		}
		return $totalFileName;
	}	
}
/* Image Class Start */
final class Images {
   
   var $image;
   var $image_type,$image_info;
   var $search = array("-", " ", "/", ".", "@", "$", "#", "'", '"','&','%20');
   var $replace = '';
      
   function __construct($filename) {
      $image_info = getimagesize($filename);
      $this->image_info = $image_info;
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   
   function save($filename, $dirtree =5, $compression=100, $permissions=null) {
	  
	  $aPath = pathinfo(strtolower($filename));
      $exp=explode("/",$aPath['dirname']);
      $way='';
      foreach($exp as $n){
         $way.=$n.'/';
         if(!file_exists($way))
            mkdir($way);
      }
        #echo $filename = $aPath['dirname']."/".str_replace($this->search, $this->replace, $aPath['filename']).".".$aPath['extension'];
		$filename = $aPath['dirname']."/".$aPath['filename'].".".$aPath['extension'];
	 	$this->resize(1600,1600);
   		
		if( strtolower($aPath['extension']) == "jpeg" || strtolower($aPath['extension']) == "jpg" ) {
			$status = imagejpeg($this->image,$filename,$compression);
		} elseif( strtolower($aPath['extension']) == "gif" ) {
			$status = imagegif($this->image,$filename);         
		} elseif( strtolower($aPath['extension']) == "png" ) {
			$status = imagepng($this->image,$filename);
		}
		
		if( $permissions != null) {
			chmod($filename, 0777);
		} 
		
		$this->processFile($filename);
	  
      if( $status ) {
          if ($dirtree > 0) {
              $filename = explode("/", $filename);
              $filename = implode("/", array_slice($filename, (-(int)$dirtree)));
          }
          return $filename;
      }
      return (boolean)false;
   }

   function watermark($image, $pos=BOTTOMRIGHT){
		$wimage = imagecreatefrompng($image);
		$sx = imagesx($wimage);
		$sy = imagesy($wimage);
		switch ($pos) {
			case "BOTTOMRIGHT":
			case 3:
				$marge_bottom = 10;
				$marge_right = 20;
				$imX = imagesx($this->image) - $sx - $marge_right;
				$imY = imagesy($this->image) - $sy - $marge_bottom;
				break;
			case "BOTTOMLEFT":
			case 4:
				$marge_bottom = 10;
				$marge_right = 10;
				$imX = 10;
				$imY = imagesy($this->image) - $sy - $marge_bottom;
				break;
			case "TOPRIGHT":
			case 2:
				$marge_bottom = 10;
				$marge_right = 10;
				$imX = $marge_right;
				$imY = $marge_bottom;
				break;
			case "TOPLEFT":
			case 1:
				$marge_bottom = 10;
				$marge_right = 10;
				$imX = imagesx($this->image) - $sx - $marge_right;
				$imY = $marge_bottom;
				break;
			case "CENTER":
			case 5:
				$marge_bottom = 20;
				$marge_right = 20;
				$imX = (imagesx($this->image)/2) - $marge_right;
				$imY = (imagesy($this->image)/2) - $marge_bottom;
				
				break;
		}
		
		imagecopy($this->image, $wimage, $imX, $imY, 0, 0, $sx, $sy);
   }
   function watermarktext($sText){
       if($sText) {
           $size = '12';
           $angle = "0";
           $font = "fonts/LSANS.TTF";
           $iWidth = $this->image_info[0];// Width
           $iHeight = $this->image_info[1];// Height
           $textcolor = imagecolorallocate($this->image, 230, 230, 230);
           
           $bbox = imagettfbbox($size, $angle, $font, $sText);
           $width = abs($bbox[2] - $bbox[0]);
           $height = abs($bbox[7] - $bbox[1]);
           imagettftext($this->image, $size, $angle, ($width), ($iHeight-10), $textcolor, $font, $sText);
       }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   /*
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   } */     
   function resize($maxWidth,$maxHeight) {
	  $iImageWidth = $this->image_info[0];// Width
	  $iImageHeight = $this->image_info[1];// Height
	  if($iImageWidth < $maxWidth || $iImageHeight < $maxHeight /*|| (($iImageWidth/$iImageHeight) != ($maxWidth / $maxHeight)) */) {
	//	echo "ImageWidth = $iImageWidth, maxWidth=$maxWidth, ImageHeight = $iImageHeight, maxHeight= $maxHeight <br/>";
		return false;
	  }
      $ratio = min(($maxWidth/$this->getWidth()), ($maxHeight/$this->getHeight()));
      $width = $ratio * $this->getWidth();
      $height = $ratio * $this->getHeight();

      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
	  return true;
   }    
   
   function crop($img_width,$img_height,$x_cord,$y_cord){
		$new_image = ImageCreateTrueColor( $img_width, $img_height );
		imagecopyresampled($new_image, $this->image, 0, 0, $x_cord, $y_cord, $img_width, $img_height, $img_width, $img_height);
		$this->image = $new_image;
   }
	

	/** smushit code Start **/
	function processFile($path) {
		if(!is_dir($path)) {		
			$pathExt = pathinfo($path, PATHINFO_EXTENSION);
			$pathExt = strtoupper($pathExt);
			
			switch ($pathExt) {
					case "JPG":
							$this->processJPG($path);
							break;
			/*		case "PNG":
							processPNG($path);
							break; */
					case "GIF":
							/* ignored for now */
							break;
							
			}			
		}
	} /* func processFile */


	function processJPG($path){
		$tmpFile = $path . ".tmp";
		$originalFileSize = filesize($path);
		$tenKB = 1024*10; /* 10kb */
		$progressive = "";
		
		if($originalFileSize > $tenKB) {
			$progressive = "-progressive"; /* apply progressive only if filesize exceeds 10kb */
		}
		
		$jpegtranCmd = "jpegtran -copy none -trim -optimize $progressive \"$path\" > \"$tmpFile\"";
		exec($jpegtranCmd);
		$this->keepSmallestFile($path, $tmpFile);
		
	} /* func processJPG	*/


	function processPNG($path) {

		$tmpFile = $path . ".tmp";
		$pngCrushCmd = "pngcrush -rem alla -brute -reduce \"$path\" \"$tmpFile\"";
		exec($pngCrushCmd );

		$this->keepSmallestFile($path, $tmpFile);

	} /* func processJPG */


	function keepSmallestFile($originalFile, $tmpFile) {

		$originalFileSize = filesize($originalFile);
		$tmpFileSize = filesize($tmpFile);
		
		/* echo "optimized: $path -- $originalFileSize to $tmpFileSize \n"; 

			#discard if tmpFileSize > originalFileSize
		*/

		if($tmpFileSize > 0 && $tmpFileSize < $originalFileSize) {
			rename($tmpFile, $originalFile);
			$percent = round(($originalFileSize - $tmpFileSize)/$originalFileSize * 100,2);
			/* echo "$originalFile [$originalFileSize]>[$tmpFileSize] $percent% saved\n"; */
		} else {
			unlink($tmpFile);
			/* echo "$originalFile [$originalFileSize]->[$tmpFileSize] = discarded\n"; */
		}

	} /* func keepSmallestFile */
	/*****************smushit code end    ***************/

} /* Image Class */