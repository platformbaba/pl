<embed type="application/x-shockwave-flash" src="http://www.odeo.com/flash/audio_player_standard_gray.swf" width="400" height="52" allowScriptAccess="always" wmode="transparent" flashvars="audio_duration=20&amp;external_url=http://192.168.64.50/cms/media/songs/edits/amr/16b12k8000hzm25s/25/22-INH100701825.amr" />
<?php exit;
print_r($_SERVER);
exit;
/*
$a=919004351102;
echo (int)$a;
exit;
$a=array("1"=>"a","2"=>"b","3"=>"c","1"=>"d");
print_r($a);
exit; 
$a=file_get_contents('http://worldspaceradio.saregama.com/ivr/api/fp_share.php?msisdn=9920202020&pf=at&action=auth');
var_dump($a);
exit;
$data["response"] = 1;
$data["msg"] = array("remark"=>"REMARK_MSG");

echo json_encode($data);
exit;
echo "<pre/>";
print_r( $_SERVER );

exit;
set_time_limit(0);
$file = 'favicon.ico';
$remote_file = '/favicon.ico';
$ftp_server="180.179.108.53";
$ftp_user_name="srgmcms";
$ftp_user_pass="password4srgmcms";
// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
ftp_pasv($conn_id, true);
$dir="nokia_deployment/DIR4";
// try to delete the directory $dir
/*if (ftp_rmdir($conn_id,$dir)){
	echo "Successfully deleted $dir\n";
}else{
	echo "There was a problem while deleting $dir\n";
}*/
echo recursiveDelete($conn_id, $dir);
if(ftp_mkdir($conn_id, $dir)) {
	echo "successfully created $dir\n";
} else {
	echo "There was a problem while creating $dir\n";
}



function recursiveDelete($handle, $directory)
{
    # here we attempt to delete the file/directory
    if( !(@ftp_rmdir($handle, $directory) || @ftp_delete($handle, $directory)) )
    {            
        # if the attempt to delete fails, get the file listing
        $filelist = @ftp_nlist($handle, $directory);
        // var_dump($filelist);exit;
        # loop through the file list and recursively delete the FILE in the list
        foreach($filelist as $file) {            
            recursiveDelete($handle, $file);            
        }
        recursiveDelete($handle, $directory);
    }
}


/*if(is_dir("ftp://".$ftp_user_name.":".$ftp_user_pass."@".$ftp_server."/".$dir)){
	if (ftp_rmdir($conn_id,$dir)) {
		echo "Successfully deleted $dir\n";
	} else {
		echo "There was a problem while deleting $dir\n";
	}
}*/
ftp_close($conn_id);
exit;/*else{
	echo "folder not exist!";
	if(ftp_mkdir($conn_id, $dir)) {
		echo "successfully created $dir\n";
	} else {
		echo "There was a problem while creating $dir\n";
	}
}*/
// upload a file
/*if(ftp_put($conn_id, $dir.$remote_file, $file, FTP_ASCII)) {
 	echo "successfully uploaded $file\n";
}else {
 	echo "There was a problem while uploading $file\n";
}*/
/*$dir_handle = @opendir("C:/Users/Jayshree/Desktop/documents/NOKIA 1. Guideline & Sample/Meta-data/Sample/DD0703/") or die("Error opening $path");
while ($file = readdir($dir_handle)) {
	ftp_put($conn_id, $dir, $file,FTP_ASCII);
}*/
ftp_putAll($conn_id, "C:/Users/Jayshree/Desktop/documents/NOKIA 1. Guideline & Sample/Meta-data/Sample/DD0703/", $dir);
function ftp_putAll($conn_id, $src_dir, $dst_dir) {
    $d = dir($src_dir);
    while($file = $d->read()) { // do this for each file in the directory
        if ($file != "." && $file != "..") { // to prevent an infinite loop
            if (is_dir($src_dir."/".$file)) { // do the following if it is a directory
                if (!@ftp_chdir($conn_id, $dst_dir."/".$file)) {
                    ftp_mkdir($conn_id, $dst_dir."/".$file); // create directories that do not yet exist
                }
                ftp_putAll($conn_id, $src_dir."/".$file, $dst_dir."/".$file); // recursive part
            } else {
                $upload = ftp_put($conn_id, $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY); // put the files
            }
        }
    }
    $d->close();
}
// close the connection
ftp_close($conn_id);

exit;
print_r($_SERVER);exit;
$langs=array('nl_BE.ISO-8859-15','nl_BE.UTF-8','en_US.UTF-8','en_GB.UTF-8','ashish');
$locale=al2gt($langs, 'text/html');
setlocale(LC_ALL,$locale);
function find_match($curlscore,$curcscore,$curgtlang,$langval,$charval, $gtlang)
{
  if($curlscore < $langval) {
    $curlscore=$langval;
    $curcscore=$charval;
    $curgtlang=$gtlang;
  } else if ($curlscore == $langval) {
    if($curcscore < $charval) {
      $curcscore=$charval;
      $curgtlang=$gtlang;
    }
  }
  return array($curlscore, $curcscore, $curgtlang);
}

function al2gt($gettextlangs, $mime) {
  /* default to "everything is acceptable", as RFC2616 specifies */
  $acceptLang=(($_SERVER["HTTP_ACCEPT_LANGUAGE"] == '') ? '*' :
  	$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
  $acceptChar=(($_SERVER["HTTP_ACCEPT_CHARSET"] == '') ? '*' :
  	$_SERVER["HTTP_ACCEPT_CHARSET"]);
  $alparts=@preg_split("/,/",$acceptLang);
  $acparts=@preg_split("/,/",$acceptChar);
  
  /* Parse the contents of the Accept-Language header.*/
  foreach($alparts as $part) {
    $part=trim($part);
    if(preg_match("/;/", $part)) {
      $lang=@preg_split("/;/",$part);
      $score=@preg_split("/=/",$lang[1]);
      $alscores[$lang[0]]=$score[1];
    } else {
      $alscores[$part]=1;
    }
  }

  /* Do the same for the Accept-Charset header. */

  /* RFC2616: ``If no "*" is present in an Accept-Charset field, then
   * all character sets not explicitly mentioned get a quality value of
   * 0, except for ISO-8859-1, which gets a quality value of 1 if not
   * explicitly mentioned.''
   * 
   * Making it 2 for the time being, so that we
   * can distinguish between "not specified" and "specified as 1" later
   * on. */
  $acscores["ISO-8859-1"]=2;

  foreach($acparts as $part) {
    $part=trim($part);
    if(preg_match("/;/", $part)) {
      $cs=@preg_split("/;/",$part);
      $score=@preg_split("/=/",$cs[1]);
      $acscores[strtoupper($cs[0])]=$score[1];
    } else {
      $acscores[strtoupper($part)]=1;
    }
  }
  if($acscores["ISO-8859-1"]==2) {
    $acscores["ISO-8859-1"]=(isset($acscores["*"])?$acscores["*"]:1);
  }

  /* 
   * Loop through the available languages/encodings, and pick the one
   * with the highest score, excluding the ones with a charset the user
   * did not include.
   */
  $curlscore=0;
  $curcscore=0;
  $curgtlang=NULL;
  foreach($gettextlangs as $gtlang) {

    $tmp1=preg_replace("/\_/","-",$gtlang);
    $tmp2=@preg_split("/\./",$tmp1);
    $allang=strtolower($tmp2[0]);
    $gtcs=strtoupper($tmp2[1]);
    $noct=@preg_split("/-/",$allang);

    $testvals=array(
         array(@$alscores[$allang], @$acscores[$gtcs]),
	 array(@$alscores[$noct[0]], @$acscores[$gtcs]),
	 array(@$alscores[$allang], @$acscores["*"]),
	 array(@$alscores[$noct[0]], @$acscores["*"]),
	 array(@$alscores["*"], @$acscores[$gtcs]),
	 array(@$alscores["*"], @$acscores["*"]));

    $found=FALSE;
    foreach($testvals as $tval) {
      if(!$found && isset($tval[0]) && isset($tval[1])) {
        $arr=find_match($curlscore, $curcscore, $curgtlang, $tval[0],
	          $tval[1], $gtlang);
        $curlscore=$arr[0];
        $curcscore=$arr[1];
        $curgtlang=$arr[2];
	$found=TRUE;
      }
    }
  }

  /* We must re-parse the gettext-string now, since we may have found it
   * through a "*" qualifier.*/
  
  $gtparts=@preg_split("/\./",$curgtlang);
  $tmp=strtolower($gtparts[0]);
  $lang=preg_replace("/\_/", "-", $tmp);
  $charset=$gtparts[1];

  header("Content-Language: $lang");
  header("Content-Type: $mime; charset=$charset");

  var_dump($curgtlang);
}
exit;
$str="ताज़ा ख़बर";
$ary[] = "ASCII";
$ary[] = "JIS";
$ary[] = "UTF-8";
echo mb_detect_encoding($str);
/*
set_time_limit(0);
$file = 'favicon.ico';
$remote_file = 'favicon.ico';
$ftp_server="180.179.108.53";
$ftp_user_name="srgmcms";
$ftp_user_pass="password4srgmcms";
// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
ftp_pasv($conn_id, true);
// upload a file
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}
// close the connection
ftp_close($conn_id);
?>
<?php
/*$a=geoip_db_get_all_info();
var_dump($a);*/
/*echo "<pre>";
print_r($_SERVER);
$region = geoip_region_name_by_code('CA', 'QC');
if ($region) {
    echo 'Region name for CA/QC is: ' . $region;
}
// Set the content-type
/*header('Content-Type: image/png');

// Create the image
$im = imagecreatetruecolor(400, 30);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $white);

// The text to draw
$text =  html_entity_decode('प्रियंका ने संभाला मोर्चा, कांग्रेस नेताओं के साथ की मीटिंग');
// Replace path by your own font path
$font = 'MANGAL.TTF';

// Add some shadow to the text
imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

// Add the text
imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);*/
?>