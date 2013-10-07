<?php
    include_once '../Course.Class.php';
    /*
     * This is the test file for Course.Class.php
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
?>
