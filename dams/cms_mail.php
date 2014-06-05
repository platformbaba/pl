<?php
include("Mail.php");

class CMS_Mail{

	private $smtpinfo = array(
			'host'=>'smtp.rediffmailpro.com',
			'port'=>'587',
			'auth'=>true,
			'username'=>'tech@rp-sg.in',
			'password'=>'saregama'

	);
	private $mail_object = null;

	function __construct(){
			$this->mail_object =& Mail::factory("smtp", $this->smtpinfo);
	}

	function sendMail($mail_arr){
			echo 'start in ';
			$headers["From"] = isset($mail_arr['from'])?$mail_arr['from']:"CMS Tech <techteam@rp-sg.in>";
			$headers["To"] = $mail_arr['to'];
			$headers["Subject"] = $mail_arr['sub'];
			$recipients = $mail_arr['to'];
			if(isset($mail_arr['cc'])){
				$headers["Cc"] = $mail_arr['cc'];
				$recipients = $mail_arr['to'].",".$mail_arr['cc'];
			}
			
			if($this->mail_object==null ) // check if the smtp connection alive 
				$this->mail_object =& Mail::factory("smtp", $this->smtpinfo);
			$res = $this->mail_object->send($recipients, $headers, $mail_arr['body']);
			var_dump($res);
	}

}

$moduleName = 'text';
$content_ids =22;
/*      Usage help if sending bulk email use object */
        $mail_arr['to'] = "amit.kumar4@rp-sg.in";  // comma separated values
        $mail_arr['cc'] = "amit.kumar4@rp-sg.in";   // comma separated values
        $mail_arr['sub'] = "Hello Mr";
        //$mail_arr['body'] = "How DO you Do";
		$mail_arr['body'] = "Hi,\n new $moduleName ( ContentId: $content_ids ) is waiting for QC Approval.\n http://192.168.64.50/cms/text?action=view&do=qclist  \n\n tete <a href='http://192.168.64.50/cms/text?action=view&do=qclist'>click here <a> teta \n\n\n This is a system generated email, do not reply to this email id.";
		$obj=new CMS_Mail;
		$obj->sendMail($mail_arr);
/* */
