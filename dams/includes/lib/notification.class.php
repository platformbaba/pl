<?php
class Notification {

	public function sendNotification( array $a = array() ){
		global $aConfig;
			$moduleName	 = strtolower($a['moduleName']);
			$action		 = $a['action'];
			$moduleId	 = $a['moduleId'];
			$editorId    = $a['editorId'];
			$content_ids = $a['content_ids'];
			$moduleName	 = $aConfig['module'][$moduleId];
		
		//echo " step1 >>>  ";
		$permission = '';
		switch($action){
			case 'add':
				$mail_arr['sub']  = "New $moduleName content ( ContentId: $content_ids ) is pending for QC Approval.";
				$mail_arr['body'] = "Hi,\n new $moduleName content ( ContentId: $content_ids ) is pending for QC Approval.\n http://192.168.64.50/cms/$moduleName?action=view&do=qclist \n\n\n This is a system generated email, do not reply to this email id. \n\n Thanks.";
				$permission = $moduleName.'_qc';
				break;
			
			case 'qc-approve':
				$mail_arr['sub']  = "New $moduleName content ( ContentId: $content_ids ) is pending for Legal Approval.";
				$mail_arr['body'] = "Hi,\n new $moduleName content ( ContentId: $content_ids ) is pending for Legal Approval.\n http://192.168.64.50/cms/$moduleName?action=view&do=legallist \n\n\n This is a system generated email, do not reply to this email id. \n\n Thanks.";
				$permission = $moduleName.'_legal';
				break;
				
			case 'legal-approve':
				$mail_arr['sub']  = "New $moduleName content ( ContentId: $content_ids ) is pending for Final Approval.";
				$mail_arr['body'] = "Hi,\n new $moduleName content ( ContentId: $content_ids ) is pending for Final Approval.\n http://192.168.64.50/cms/$moduleName?action=view&do=publishlist \n\n\n This is a system generated email, do not reply to this email id. \n\n Thanks.";
				$permission = $moduleName.'_publish';
				break;	
				
		}
		
		
		
		if( $permission != '' ){
			//echo " step2 >>>  ".$permission;
			$mEditor = new editor();
			$aUserData = $mEditor->getUsersByContentPermission( array('perm' => $permission) );
			$mail_arr['to'] = '';
			if( !empty($aUserData) ){
				$emailTmp = '';
				foreach( $aUserData as $kk=>$da ){
					if( $da->email_id != '' ){
					$emailTmp .= $da->email_id.',';
					}					
				}
				$emailTmp = trim($emailTmp, ',');
				$mail_arr['to'] = $emailTmp;
			}
			//print_r($mail_arr);
			if( !empty($mail_arr['to']) ){
				//echo " step3 >>>  ";
				$this->sendNotificationMail( $mail_arr );
			}
		}
	}
	
	public function sendNotificationMail( $mail_arr ){
		//echo " step4 >>>  ";
		include_once(LIBPATH. 'cms_mail.class.php');
		$obj=new CMS_Mail;
		$res = $obj->sendMail($mail_arr);
		//var_dump( $res );
	}

}
