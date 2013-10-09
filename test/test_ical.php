<?php
    include_once '../ical.php';
    
    echo 'Test setCourseEvent</br>';
    $SemInfo = semInfo();
    echo setCourseEvent('', '', $SemInfo['2013']['1'])['year'];
?>
