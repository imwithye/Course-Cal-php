<?php
	require_once 'ical.php';
	require_once 'mail.php';
	
	$json_data = array_key_exists('json', $_REQUEST) ? $_REQUEST['json'] : null;
	if(!$json_data){
		echo 'Error! #no data.';
		exit;
	}
	$info = json_decode($json_data, TRUE);
	if(!$info){
		echo 'Error! #wrong json format.';
		exit;
	}
	
	$url = array_key_exists('url', $info) ? $info['url'] : null;
	if($url){
		$result = createCalWithPrintablePage($url);
		if(!$result) {
			echo 'Error! #wrong url';
			exit;
		}
		else{
			if($result['error']) {
				report('Error is caught in this url: '.$result['url']); //report error
			}
			$result['ics']->returnCalendar();
			exit;
		}
	}
	else {
		$result = createCalWithCustomInformation($info);
		if($result) {
			$result['ics']->returnCalendar();
			exit;
		}
		else {
			echo 'Error! #cannot create ics with given json.';
			exit;
		}
	}
?>
