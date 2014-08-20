<?php
	require_once 'ical.php';
	
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
	$result = createCalWithCustomInformation($info);
	if($result) {
		$result['ics']->returnCalendar();
		exit;
	}
	else {
		echo 'Error! #cannot create ics with given json.';
		exit;
	}
?>
