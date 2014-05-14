<?php 

global $messenger;

$mess = $messenger['response'];
$res  = $mess['resp'];

if( $mess['status']==1 && is_array($res) && sizeof($res)>1 ){
	logger::writelogs("analytics",json_encode($res));
}	
else{
	logger::writelogs("unsuccesful",$mess['error_msg']);
}


?>