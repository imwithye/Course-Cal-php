<?php
	require_once '../Course.Class.php';
	
	echo 'Test Lesson Class: </br>';
	$lesson = new Lesson(array('type' => 'LEC'
							, 'group' => 'FS2'
							, 'time' => new LessonTime(array('startTime' => '0830'
												, 'endTime' => '0930'
												, 'wkDay' => 'mon'))
							, 'venue' => 'LT1'
							));
	echo 'Test Case 1: a new lesson created, </br>';
	echo $lesson->toString();
	
	echo '</br></br>';
	echo 'Test Course Class: </br>';
	echo 'Test case 1, getInstanceWithCourseInfo: </br>';
	$course = Course::getInstanceWithCourseInfo(array('code' => 'CZ2001'
												, 'index' => '1000'
												, 'name' => 'Shit Course'
												, 'au' => '3'
												, 'lessons' => array($lesson)));
	echo $course->toString().'</br>';
	echo 'Test case 2, getInstanceAuto: </br>';
	$course = Course::getInstanceAuto(array('code' => 'CZ2001'
										, 'index' => '10733'
										, 'year' => '2013'
										, 'sem' => '1'));
	if(!$course)
		echo 'cannot create an instance.';
	else 
		echo $course->toString();
?>
