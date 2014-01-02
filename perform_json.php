<?php
	require_once 'ical.php';
	
	$json_data = array_key_exists('txt_json', $_REQUEST) ? $_REQUEST['txt_json'] : null;
	if(!$json_data){
		echo 'Error!';
		exit;
	}
	$info = json_decode($json_data, TRUE);
	if(!$info){
		echo 'Error!';
		exit;
	}
	$result = createCalWithCustomInformation($info);
	if($result) {
		$result['ics']->returnCalendar();
	}
	else {
		echo 'Error!';
	}
?>