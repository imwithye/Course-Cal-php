<?php
    include_once '../ical.php';
    include_once '../network.php';
    
    //setting a test course;
    $time1 = new LessonTime(1, 830, 930);
    $lesson1 = new Lesson('Lec', '', $time1, 'LT2A', '');
    $time2 = new LessonTime(1, 930, 1030);
    $lesson2 = new Lesson('TUT', 'FS2', $time2, 'TR89', 'This is a test lesson2.');
    
    $examTime = new ExamTime(2013, 12, 8, 830, 930);
    $course = new Course("CI0228", 10784);
    $course->setName("Test Course");
    $course->setAU('3 AU');
    $course->setExamTime($examTime);
    $course->addLesson($lesson1);
    $course->addLesson($lesson2);
    
    $v = new vcalendar();
    $url = "https://wish.wis.ntu.edu.sg/pls/webexe/AUS_STARS_PLANNER.planner?p1=NTU_U1220539K&p2=17D7C90E1CB1C884&student_type=F&acad=2013&semester=1&subj_code=CZ2001&subj_code=CZ2002&subj_code=CZ2003&subj_code=CZ2004&subj_code=CZ2005&subj_code=MH8300&subj_code=HW0001&subj_code=HC2011&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&index_nmbr=10227&index_nmbr=10235&index_nmbr=10463&index_nmbr=10254&index_nmbr=10262&index_nmbr=72403&index_nmbr=20202&index_nmbr=17212&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&subj_type=C&subj_type=C&subj_type=C&subj_type=C&subj_type=C&subj_type=P&subj_type=%20&subj_type=G&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&class_info=&plan_no=&plan1_exists=Y&plan2_exists=Y&plan3_exists=N&boption=Preview";
    $info = getUserInfo($url);
    setCourseEvent($course, $v, $info);
    $v['ics']->returnCalendar();
?>