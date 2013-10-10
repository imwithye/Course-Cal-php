<?php
    require_once 'ical.php';
    $url = $_REQUEST['url'];
    $result = createCal($url);
    if($result==null){
        echo 'Error!';
    }
    else{
        $courses = $result['course'];
        $errorWithRepeat = array();
        foreach($courses as $course){
            if($course->getErrorFlag()!=0)
                array_push ($errorWithRepeat, $course);
        }
        if(count($errorWithRepeat)==0)
            $result['ics']->returnCalendar();
        else{
            //Go to Error Page;
        }
    }
?>
