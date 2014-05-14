<?php
$audioUrlArr = array(
					'PHLS'	=>	'https://new_cms_test_sec-vh.akamaihd.net/i/new_cms_test/Audio/REPLACEFILE/master.m3u8',
					'PHDS'	=>	'https://new_cms_test_sec-vh.akamaihd.net/z/new_cms_test/Audio/REPLACEFILE/manifest.f4m',
					'NPHLS'	=>	'http://new_cms_test-vh.akamaihd.net/i/new_cms_test/Audio/REPLACEFILE/master.m3u8',
					'RTSP'	=>	'rtsp://a1453.v240708b.c240708.g.vq.akamaistream.net/7/1453/240708/v0001/saregama.download.akamai.com/174228/new_cms_test/Video_!/audio_REPLACEFILE',
					'MMS'	=>	'mms://a394.v2407098.c240709.g.vm.akamaistream.net/7/394/240709/v0001/saregama.download.akamai.com/174228/new_cms_test/Audio/audio_REPLACEFILE',
					'PMD'	=>	'http://new-cms-test.saregama.com/new_cms_test/Audio/audio_128000_REPLACEFILE',
				 );
	
$videoUrlArr = array(
						'PHLS'	=>	'https://new_cms_test_sec-vh.akamaihd.net/i/new_cms_test/Video/REPLACEFILE/master.m3u8',
						'PHDS'	=>	'https://new_cms_test_sec-vh.akamaihd.net/z/new_cms_test/Video/REPLACEFILE/manifest.f4m',
						'NPHLS'	=>	'http://new_cms_test-vh.akamaihd.net/i/new_cms_test/Video/REPLACEFILE/master.m3u8',
						'RTSP'	=>	'rtsp://a1453.v240708b.c240708.g.vq.akamaistream.net/7/1453/240708/v0001/saregama.download.akamai.com/174228/new_cms_test/Video_!/video_REPLACEFILE',
						'MMS'	=>	'mms://a394.v2407098.c240709.g.vm.akamaistream.net/7/394/240709/v0001/saregama.download.akamai.com/174228/new_cms_test/Video/video_REPLACEFILE',
						'PMD'	=>	'http://new-cms-test.saregama.com/new_cms_test/Video/video_400x300_256_REPLACEFILE',
					);
					
function getAudioFile( $fileName, $type ){
	global $audioUrlArr;
	$vFile = str_replace( 'REPLACEFILE' , $fileName.'.mp4', $audioUrlArr[$type] );
		
	if( $type == 'MMS' ){
		$vFile = str_replace( 'REPLACEFILE' , $fileName.'.wma', $audioUrlArr[$type] );
	
	}else if( $type == 'PHLS' || $type == 'NPHLS' ){
		$replaceString = 'audio_,96000,128000,_'.$fileName.'.mp4.csmil';
		$vFile = str_replace( 'REPLACEFILE' , $replaceString, $audioUrlArr[$type] );
	
	}else if( $type == 'PHDS' ){
		$replaceString = 'audio_,96000,128000,_'.$fileName.'.mp4.csmil';
		$vFile = str_replace( 'REPLACEFILE' , $replaceString, $audioUrlArr[$type] );
	}
	return $vFile;
}

function get_file_name( $id, $type, $isrc){
	//$oMysqli = @new mysqli('192.168.64.122', 'amitk', 'pass@123', 'saregama_db');
	//$sql = 'SELECT isrc FROM song_mstr WHERE song_id="'.$id.'" LIMIT 1';
	return $isrc;
}

function get_pmd_url( array $a = array() ){
		$songPath = $a['url'];
		$nTime = time(void)+600;
		$nWindow = 600;
		$sSalt = 'PrfRgqRfkbzodkKFO4cx';
		$sExtract = '';
		$sParam ='';
		$song_url = 'http://download.saregama.com'.urlauth_gen_url($songPath, $sParam, $nWindow, $sSalt, $sExtract, $nTime);
		return $song_url;
}