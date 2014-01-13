<?php
	require_once 'google/appengine/api/mail/Message.php';
	use google\appengine\api\mail\Message;
	
	function report($body){
		$mail_options = array('sender' => 'imwithye.report@gmail.com'
						, 'to' => 'imwithye@gmail.com'
						, 'subject' => 'Course Cal Report'
						, 'textBody' => $body);	//change to your own emails.
		
		try {
			$message = new Message($mail_options);
			$message->send();
			return TRUE;
		} catch (InvalidArgumentException $e) {
			return FALSE;
		}
	}//report($body);
?>