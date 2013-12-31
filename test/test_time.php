<?php
	require_once '../time.php';
	
	echo 'Test Event Time Class: </br>';
	$time = array('year' => '1995'
			, 'month' => 'jan'
			, 'day' => '28'
			, 'startTime' => '0830'
			, 'endTime' => '0930'
			);
	$eventTime = new EventTime($time);
	echo 'Year: '.$eventTime->year.'</br>';
	echo $eventTime->toString();
	
	echo '</br></br>';
	echo 'Test Lesson Time Class: </br>';
	echo 'Case 1: </br>';
	$time = array(
			'startTime' => '0830'
			, 'endTime' => '0930'
			, 'wkDay' => '01'
			);
	$lessonTime = new LessonTime($time);
	echo 'Year: '.$lessonTime->year.'</br>';
	echo 'wkDay: '.$lessonTime->wkDay.'</br>';
	echo $lessonTime->toString();
	echo 'Case 2: </br>';
	$time = array(
			'startTime' => '0830'
			, 'endTime' => '0930'
			, 'wkDay' => 'mon'
			);
	$lessonTime = new LessonTime($time);
	echo 'Year: '.$lessonTime->year.'</br>';
	echo 'wkDay: '.$lessonTime->wkDay.'</br>';
	echo $lessonTime->toString();
	
	echo '</br></br>';
	echo 'Test semInfo: </br>';
	$sem = semInfo('2013','1');
	echo 'Year: '.$sem['year'].'</br>';
	echo 'Month: '.$sem['month'].'</br>';
	echo 'Day: '.$sem['day'].'</br>';
	
	echo '</br></br>';
	echo 'Test fewDaysNextOrBefore: </br>';
	$time = array('year' => '1995'
			, 'month' => '02'
			, 'day' => '28'
			);
	$newTime = fewDaysNextOrBefore($time, '-1 year');
	echo 'Year: ', $newTime['year'];
?>