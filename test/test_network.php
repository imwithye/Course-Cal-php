<?php
	require_once '../network.php';
	
	echo 'Test Course URL: </br>';
	$url = courseURL('CZ2001', $info);
	echo '<b>Course URL for CZ2001:</b> '.'<a href="'.$url .'">'.$url.'</a>';
	
	echo '</br></br>';
	echo 'Test Fetch Function: </br>';
	echo fetch($url);
?>