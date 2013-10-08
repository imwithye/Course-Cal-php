<?php
    include_once '../tools/Update_TeachingWk.Class.php';
    /*
     * This is the test file for TeachingWk.Class.php
     */
    echo 'Testing Getting timetable data</br>';
    echo 'Sem 1</br>';
    echo analyseTimetablePage(1)->toString();
    echo '<hr>';
    echo 'Sem 2</br>';
    echo analyseTimetablePage(2)->toString();
?>
