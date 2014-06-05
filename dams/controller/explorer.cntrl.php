<?php  
/*
*	Not In Use
*	For exploring the directory to searc and set media file
*/
$action = cms::sanitizeVariable( $_GET['action'] );
$action = ($action==''?'view':$action);
$view = 'explorer_list';
if($action == 'view'){
	if(isset($_REQUEST['dir'])) {
		$current_dir = cms::sanitizeVariable($_REQUEST['dir']);
	}
	$lastDirectory=cms::sanitizeVariable($_REQUEST['ldir']);//MEDIA_SEVERPATH_SONG;
	$data['aContent']=array();
	if ($handle = opendir($current_dir)) {
		 while (false !== ($file_or_dir = readdir($handle))) {
			if(in_array($file_or_dir, array('.', '..'))) continue;
			$path = $current_dir.'/'.$file_or_dir;
			$pathSplit=explode("/",$current_dir);
			unset($pathSplit[(sizeof($pathSplit)-1)]);
			$back=implode("/",$pathSplit);
			if(strpos($back."/",$lastDirectory)===FALSE){
				$back=$_GET['dir'];
			}
			if(is_file($path)) {
				$data['aContent'][]=array("path"=>$path,"dir" => $file_or_dir,"isFile"=>1,"back"=>$back, "file" =>  str_replace(PATH,SITEPATH,$path));
			} else {
				$data['aContent'][]=array("path"=>$path,"dir" => $file_or_dir,"isFile"=>0,"back"=>$back,"file"=>"");
			}
		}
		closedir($handle);
	}
}
function sortByOrder($a, $b) {
    return $b['isFile'] - $a['isFile'];
}
usort($data['aContent'], 'sortByOrder');
/* render view */
$oCms->view( $view, $data );