<?php
	require_once 'ical.php';
	require_once 'mail.php';
	
	$url = array_key_exists('url', $_REQUEST) ? $_REQUEST['url'] : null;
	$result = createCalWithPrintablePage($url);
	if(!$result) {
		echo 'Error!';
	}
	else{
		if($result['error']) {
			report('Error is caught in this url: '.$result['url']); //report error
		}
		$result['ics']->returnCalendar();
	}
?>
