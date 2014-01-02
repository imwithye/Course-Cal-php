<?php
	require_once '../ical.php';
	
	echo 'Test createCalWithCustomInformation function in ical.php: </br>';
	$info = array('mode' => 'manual'
				, 'year' => '2013'
				, 'sem' => '2'
				, 'courses' => array(
						array('code' => 'CZ2001'
							, 'index' => '10111'
							, 'name' => 'Test Course'
							, 'au' => '3.0 au'
							, 'lessons' => array(new Lesson(array('type' => 'LCT'
																, 'group' => 'FS2'
																, 'time' => new LessonTime(array('startTime' => '0830'
																								, 'endTime' => '0930'
																								, 'wkDay' => 'mon')
																						)
																, 'venue' => 'Shit place'
																, 'remark' => 'wk2-13')
															)
												)
							)
						)
				);
	$v = createCalWithCustomInformation($info);
	if($v)
		$v['ics']->returnCalendar();
	else 
		echo 'Error';
?>