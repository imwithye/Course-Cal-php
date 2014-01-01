<?php
	require_once '../Course.Class.php';
	
	$url = 'https://wish.wis.ntu.edu.sg/pls/webexe/AUS_STARS_PLANNER.planner?p1=NTU_U1220539K&p2=17D7C90E1CB1C884&student_type=F&acad=2013&semester=2&subj_code=BU8201&subj_code=CZ2006&subj_code=CZ2007&subj_code=CZ3005&subj_code=HC2003&subj_code=HW0210&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&index_nmbr=00182&index_nmbr=10433&index_nmbr=10282&index_nmbr=10315&index_nmbr=17205&index_nmbr=10376&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&subj_type=P&subj_type=C&subj_type=C&subj_type=C&subj_type=X&subj_type=C&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&class_info=&plan_no=&plan1_exists=Y&plan2_exists=N&plan3_exists=N&boption=Preview';
	
	echo 'Test Lesson Class: </br>';
	$lesson = new Lesson(array('type' => 'LEC'
							, 'group' => 'FS2'
							, 'time' => new LessonTime(array('startTime' => '0830'
												, 'endTime' => '0930'
												, 'wkDay' => 'mon'))
							, 'venue' => 'LT1'
							, 'remark' => 'wk2-3,6,8-10'));
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
	echo 'Test case 3, getArrayWithPrintablePage: </br>';
	$courses = Course::getArrayWithPrintablePage($url);
	foreach($courses as $course) {
		echo $course->toString().'</br>';
	}
?>
