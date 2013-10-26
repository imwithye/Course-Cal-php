<?php
    require_once 'ical.php';
    require_once 'mail.php';
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
            //foreach($errorWithRepeat as $errorCourse)
                //report($errorCourse->toString().'</br></br>');
            $result['ics']->returnCalendar();
        }
    }
?>
