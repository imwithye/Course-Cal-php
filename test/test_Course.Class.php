<?php
	require_once '../Course.Class.php';
	
	echo 'Testing Lesson Class: </br>';
	$lesson = new Lesson(array('type' => 'LEC'
							, 'group' => 'FS2'
							, 'time' => new LessonTime(array('startTime' => '0830'
												, 'endTime' => '0930'
												, 'wkDay' => 'mon'))
							, 'venue' => 'LT1'
							, 'remark' => ''));
	echo 'Test Case 1: a new lesson created, </br>';
	echo $lesson->toString().'</br>';
?>
