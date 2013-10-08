<?php
    include_once '../Course.Class.php';
    /*
     * This is the test file for Course.Class.php
     * First test Lesson and Course Class.
     */
    echo 'Testing LessonTime and Lesson Class. ';
    $time1 = new LessonTime(1, 1, 830, 930);
    $lesson1 = new Lesson('Lec', 'FS2', $time1, 'LT2A', 'This is a test lesson1.');
    $time2 = new LessonTime(1, 2, 930, 1030);
    $lesson2 = new Lesson('TUT', 'FS2', $time2, 'TR89', 'This is a test lesson2.');
    echo 'This is a new lesson created: </br>';
    echo $lesson1->toString();
    echo '</br>';
    echo 'This is a new lesson created: </br>';
    echo $lesson2->toString();
    echo '<hr>';
    
    echo 'Testing ExamTime and Course Class. ';
    $examTime = new ExamTime(2013, 12, 8, 830, 930);
    $course = new Course("CI0228", 10784);
    $course->setName("Test Course");
    $course->setExamTime($examTime);
    $course->addLesson($lesson1);
    $course->addLesson($lesson2);
    echo '</br>';
    echo $course->toString();
    echo '<hr>';
    
    /*
     * Testing analyseCoursePage function
     */
    echo 'Testing analyseCoursePage function</br>';
    $testCode = 'CZ2001';
    $testIndex = 10733;
    $wrongIndex = 12312;
    echo 'Testing wrong index catch.</br>';
    if(analyseCoursePage($testCode, $wrongIndex)==null)
	echo 'Wrong Index Catched</br>';
    echo 'Testing a example Course CZ2001 with index 10733';
    echo analyseCoursePage($testCode, $testIndex)->toString();
    echo '<hr>';
    
    /*
     * Testing analysePrintablePage function
     */
    echo 'Testing analysePrintablePage function</br>';
    $testURL = "https://wish.wis.ntu.edu.sg/pls/webexe/AUS_STARS_PLANNER.planner?p1=NTU_U1220539K&p2=17D7C90E1CB1C884&student_type=F&acad=2013&semester=1&subj_code=CZ2001&subj_code=CZ2002&subj_code=CZ2003&subj_code=CZ2004&subj_code=CZ2005&subj_code=MH8300&subj_code=HW0001&subj_code=HC2011&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&index_nmbr=10227&index_nmbr=10235&index_nmbr=10463&index_nmbr=10254&index_nmbr=10262&index_nmbr=72403&index_nmbr=20202&index_nmbr=17212&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&subj_type=C&subj_type=C&subj_type=C&subj_type=C&subj_type=C&subj_type=P&subj_type=%20&subj_type=G&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&class_info=&plan_no=&plan1_exists=Y&plan2_exists=Y&plan3_exists=N&boption=Preview";
    $courses = analysePrintablePage($testURL);
    foreach($courses as $course){
        echo $course->toString();
        echo '</br></br>';
    }
    echo '<hr>';
?>
