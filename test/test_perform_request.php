<?php
    include_once '../Course.Class.php';
    $url = $_REQUEST['url'];
    $courses = analysePrintablePage($url);
    echo 'Testing receive url from _REQUEST</br>';
    foreach($courses as $course){
        echo $course->toString();
        echo '</br></br>';
    }
?>
