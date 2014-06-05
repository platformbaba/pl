<?php
error_reporting(-1);
date_default_timezone_set('Asia/Calcutta');
echo "Sending mail start...";
echo "<br><br>";
$config['SMTPDETAIL'] = array('Host'=>'smtp.rediffmailpro.com','Port'=>587,'Username'=>"tech@rp-sg.in",'Password'=>'saregama','SMTPAuth'=>true);
$config['EMAILDETAIL'] = array('From'=>array('name'=>'Tech Team','emailid'=>"tech@rp-sg.in"));
$config['EMAILDETAIL']['To'][] = array('name'=>'Santosh','emailid'=>'santosh.soni@rp-sg.in');
//$config['EMAILDETAIL']['Cc'][] = array('name'=>'Techteam','emailid'=>'techteam@rp-sg.in');
$config['EMAILDETAIL']['Cc'][] = array('name'=>'Techteam','emailid'=>'pranay.warke@rp-sg.in');
$config['EMAILDETAIL']['Subject'] = " Test Mail Saregama";
$mailbody     = "Hi! \n\n Please find attached the Aircel CC as of ";
$mailbody    .= "\n\n Thanks & Regards,";
$mailbody    .= "\n Tech Team";
$mailbody    .= "\n\n\n ";

//$Excelfile_path = "/var/www/html/webdata/srgmdevs/wapsite/m/logs/reports/Aircel_cc_".date('Ymd').".csv";
//$generated_filename = "Aircel_cc_".date('Ymd').".csv";
                                                                
  mail($config['EMAILDETAIL']['To'],$config['EMAILDETAIL']['Subject'],$mailbody,$config['EMAILDETAIL']['From'],$config['EMAILDETAIL']['Cc']);

/*$to      = 'nobody@example.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);*/

echo "Done mail has been send";
?>