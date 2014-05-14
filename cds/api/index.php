<?php
require_once('config.php');
require_once('lib/akamaiToken.php'); // HLS_HDS
require_once('lib/SecureStreamingPHP/PHP/gentoken.php'); // RTSP_MMS
require_once('lib/urlauthphp_1.1.2/urltoken.php'); // PMD

/* ALl Params */
$id = ( (int)$_REQUEST['id']>0? (int)$_REQUEST['id']:0);
$type = ( isset($_REQUEST['type'])? strip_tags($_REQUEST['type']):'' );
$target = ( isset($_REQUEST['target'])? strip_tags($_REQUEST['target']):'' );
$isrc = ( isset($_REQUEST['isrc'])? strip_tags($_REQUEST['isrc']):'' );

if( $id == 0 ){ exit; }
if( $isrc == '' ){ exit; }
if( empty($audioUrlArr[$type]) ){ exit; }

/* to get song url */

$song_file_name = get_file_name( $id, 'song', $isrc );

$song_url = getAudioFile($song_file_name , $type);
if( $type == 'RTSP' ){
	
	if( $isrc == 'INH109446840' ){
		$rtspUrlPart_64 = 'saregama.download.akamai.com/174228/new_cms_test/Video_!/audio_INH109446840_64.mp4';
		$akamaiToken = getSecureAkamai( array('userPath' => '/saregama.download.akamai.com/174228/new_cms_test/Video_!/audio_INH109446840_64.mp4') );	
		
		/* To Get Akamai Url */
		exec("/usr/bin/perl /var/www/cds/api/lib/od_akamaizer.pl --cpcode 240708 --url '".$rtspUrlPart_64."' --objver v01",$output_64);
		if( !empty($output_64) ){
			$song_url_64 = (string)trim($output_64[0]);
		}
		$song_url_64 .= '?auth='.$akamaiToken.'&aifp=v001';
		
		$song_file_name = 'INH109446840_124';
	}
	$rtspUrlPart = 'saregama.download.akamai.com/174228/new_cms_test/Video_!/audio_'.$song_file_name.'.mp4';
	$akamaiToken = getSecureAkamai( array('userPath' => '/saregama.download.akamai.com/174228/new_cms_test/Video_!/audio_'.$song_file_name.'.mp4') );	
	
	/* To Get Akamai Url */
	exec("/usr/bin/perl /var/www/cds/api/lib/od_akamaizer.pl --cpcode 240708 --url '".$rtspUrlPart."' --objver v01",$output);
	if( !empty($output) ){
		$song_url = (string)trim($output[0]);
	}
	
	$song_url .= '?auth='.$akamaiToken.'&aifp=v001';
	
}else if( $type == 'PHLS' ){
	$akamaiToken = getAkamai_Auth_Token($akamaiAutoTokenKeyPHLS);
	$song_url .= '?hdnea='.$akamaiToken; 
	
}else if( $type == 'NPHLS' ){
	$akamaiToken = getAkamai_Auth_Token($akamaiAutoTokenKeyNPHLS);
	$song_url .= '?hdnea='.$akamaiToken; 
	
}else if( $type == 'PHDS' ){
	$akamaiToken = getAkamai_Auth_Token($akamaiAutoTokenKeyPHLS);
	$song_url .= '?hdnea='.$akamaiToken; 
	
}else if( $type == 'PMD' ){
	$songPath = '/new_cms_test/Audio/audio_128000_'.$song_file_name.'.mp4';
	$song_url = get_pmd_url( array('url'=>$songPath) );			
}
if( $target == 'href' ){

if( $isrc == 'INH109446840' ){
echo "<p> ".$song_url."</p>";
echo "<br/>";
echo '<a href="'.$song_url.'" >Click to Play 128k</a>';

echo "<p> ".$song_url_64."</p>";
echo "<br/>";
echo '<a href="'.$song_url_64.'" >Click to Play 64k</a>';

}else{
echo "<p>".$song_url."</p>";
echo "<br/>";
echo '<a href="'.$song_url.'" >Click to Play</a>';
}

}else{
echo $song_url;
}