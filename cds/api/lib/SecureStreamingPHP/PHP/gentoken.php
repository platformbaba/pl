<?PHP
### Akamai Lib to generate Token for secure rtsp and mms urls
date_default_timezone_set('Asia/Calcutta'); 
require 'StreamTokenFactory.php';


function displayVersion() {
    $factory = new StreamTokenFactory;
    echo "Akamai Secure Streaming, PHP token generator version " .
            $factory->getVersion() . "\n";
}

function displayHelp($message) {
    displayVersion();

    if ($message != null)
        echo "Unrecognized command-line argument: " . $message . "\n";

    echo "usage: gentoken.php [options]\n";
    echo "   -f path              path being requested\n";
    echo "   -i ip                ip address of requester\n";
    echo "   -r profile           authentication profile\n";
    echo "   -p passwd            password\n";
    echo "   -k key               key filename and path (for e type tokens 32 bytes binary file)\n";
    echo "   -t time              time of token creation\n";
    echo "   -w window            time window in seconds\n";
    echo "   -d render_duration   rendering duration (valid for c,d and e tokens only)\n";
    echo "   -x payload           eXtra payload\n";
    echo "   -y token_type        'c', 'd' or 'e'\n";
    echo "   -v                   Display program version\n";
    echo "   -h                   Display help message\n";
}


function getSecureAkamai( array $a = array() ){
	$userPath = ( !empty( $a['userPath'] ) ? $a['userPath'] : '/saregama.download.akamai.com/174228/new_cms_test/Video_!/Test5.mp4' );
	
	$userIP = null;
	$userProfile = "RTSPSecure";
	$userPasswd = "P@ssw0rd";
	$userTime = time(); // current time;
	$userWindow = 900;
	$userDuration = 0;
	$userPayload = null;
	$userKey = null;
	$userSalt = null;
	$userToken = "c";
	
	//echo "<p>".$userPath." ".$userTime."</p>";
	
	$factory = new StreamTokenFactory;
	$token = $factory->getToken($userToken, $userPath,
			 $userIP, $userProfile, $userPasswd, $userTime, $userWindow, $userDuration,
			 $userPayload, $userKey);
	return $token->getToken();
}

if( isset($_GET['getToken']) && $_GET['getToken'] !='' ){
	echo getSecureAkamai( array('userPath' => $_GET['getToken']) );
}
?>
