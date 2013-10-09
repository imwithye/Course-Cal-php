<?php
    include_once '../Course.Class.php';
    $url = $_REQUEST['url'];
    $info = getUserInfo($url);
    $courses = analysePrintablePage($url, $info);
    echo 'Testing receive url from _REQUEST</br>';
    foreach($courses as $course){
        echo $course->toString();
        echo '</br></br>';
    }
?>
